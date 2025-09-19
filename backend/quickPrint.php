<?php
declare(strict_types=1);
header('Content-Type: application/json');

require '../config/mysqli_db.php';

$id   = isset($_GET['id'])   && $_GET['id']   !== '' ? $_GET['id']   : null;
$name = isset($_GET['name']) && $_GET['name'] !== '' ? $_GET['name'] : null;

$conditions = [];
$params     = [];
$types      = '';

if ($id !== null) {
    $conditions[] = 'bh.id = ?';
    $types       .= 'i';
    $params[]     = (int)$id;
}
if ($name !== null) {
    $conditions[] = 'bh.batch_name = ?';
    $types       .= 's';
    $params[]     = $name;
}
$whereSql = '';
if (!empty($conditions)) {
    $whereSql = 'WHERE ' . implode(' AND ', $conditions);
}

$sql = "
WITH UserCounts AS (
    SELECT 
        batch_id,
        COUNT(username) AS total_user
    FROM userbillinfo
    GROUP BY batch_id
)
SELECT 
    bh.id AS batch_id,
    bh.batch_name,
    bh.batch_description,
    DATE(bh.creationdate) AS creation_date,
    TIME(bh.creationdate) AS creation_time,
    bh.batch_status,
    bh.creationby,
    COALESCE(uc.total_user, 0) AS total_user,
    -- stabilkan plan_name kalau banyak baris dari join
    MAX(ui.planName) AS plan_name
FROM batch_history bh
LEFT JOIN UserCounts uc ON bh.id = uc.batch_id
LEFT JOIN userbillinfo ui ON bh.id = ui.batch_id
{$whereSql}
GROUP BY
    bh.id, bh.batch_name, bh.batch_description, creation_date, creation_time, bh.batch_status, bh.creationby, uc.total_user
ORDER BY bh.id DESC
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Prepare failed', 'detail' => $conn->error], JSON_PRETTY_PRINT);
    exit;
}
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$response = [];
$batchIds = [];

while ($row = $result->fetch_assoc()) {
    $batch_id        = (int)$row['batch_id'];
    $batchIds[]      = $batch_id;

    $response[$batch_id] = [
        "batch_id"         => $batch_id,
        "batch_name"       => $row['batch_name'],
        "batch_description"=> $row['batch_description'],
        "creationdate"     => $row['creation_date'],
        "creationtime"     => $row['creation_time'],
        "total_user"       => (int)$row['total_user'],
        "plan_name"        => $row['plan_name'] ?? null,
        "batch_status"     => $row['batch_status'],
        "creationby"       => $row['creationby'],
        "accounts"         => []
    ];
}
$stmt->close();

if (empty($response)) {
    echo json_encode([], JSON_PRETTY_PRINT);
    exit;
}

$inPlaceholders = implode(',', array_fill(0, count($batchIds), '?'));
$typesAcc = str_repeat('i', count($batchIds));

$sqlAcc = "SELECT batch_id, username FROM userbillinfo WHERE batch_id IN ($inPlaceholders) ORDER BY batch_id, username";
$stmtAcc = $conn->prepare($sqlAcc);
if (!$stmtAcc) {
    http_response_code(500);
    echo json_encode(['error' => 'Prepare accounts failed', 'detail' => $conn->error], JSON_PRETTY_PRINT);
    exit;
}
$stmtAcc->bind_param($typesAcc, ...$batchIds);
$stmtAcc->execute();
$resAcc = $stmtAcc->get_result();

while ($r = $resAcc->fetch_assoc()) {
    $bid = (int)$r['batch_id'];
    if (isset($response[$bid])) {
        $response[$bid]['accounts'][] = [
            "username" => $r['username'],
            "password" => "Accept"
        ];
    }
}
$stmtAcc->close();

$conn->close();

$final = array_values(
    array_reverse(
        array_replace([], $response)
    )
);
usort($final, function($a, $b) { return $b['batch_id'] <=> $a['batch_id']; });

echo json_encode($final, JSON_PRETTY_PRINT);
