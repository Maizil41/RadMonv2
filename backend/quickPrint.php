<?php
header('Content-Type: application/json');
require '../config/mysqli_db.php';

$sql = "
WITH UserCounts AS (
    SELECT 
        batch_id,
        COUNT(username) AS total_user
    FROM 
        userbillinfo
    GROUP BY 
        batch_id
)
SELECT 
    bh.id AS batch_id,
    bh.batch_name,
    bh.batch_description,
    bh.creationdate,
    bh.batch_status,
    bh.creationby,
    COALESCE(uc.total_user, 0) AS total_user,
    ui.planName,
    rug.groupname
FROM 
    batch_history bh
LEFT JOIN 
    UserCounts uc ON bh.id = uc.batch_id
LEFT JOIN 
    userbillinfo ui ON bh.id = ui.batch_id
LEFT JOIN 
    radusergroup rug ON ui.username = rug.username
GROUP BY
    bh.id, bh.batch_name, bh.batch_description, bh.creationdate, bh.batch_status, bh.creationby, uc.total_user, ui.planName, rug.groupname
ORDER BY 
    bh.id DESC;
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$response = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $batch_id = $row['batch_id'];
        $batch_name = htmlspecialchars($row['batch_name']);
        $batch_description = htmlspecialchars($row['batch_description']);
        $creationdate = htmlspecialchars($row['creationdate']);
        $user_count = (int)$row['total_user'];
        $plan_name = htmlspecialchars($row['planName']);
        $batch_status = htmlspecialchars($row['batch_status']);
        $creationby = htmlspecialchars($row['creationby']);
        
        $sql_accounts = "SELECT username FROM userbillinfo WHERE batch_id = ?";
        $stmt_accounts = $conn->prepare($sql_accounts);
        $stmt_accounts->bind_param("i", $batch_id);
        $stmt_accounts->execute();
        $result_accounts = $stmt_accounts->get_result();
        
        $accounts = [];
        while ($row_accounts = $result_accounts->fetch_assoc()) {
            $accounts[] = [
                "username" => htmlspecialchars($row_accounts['username']),
                "password" => "Accept"
            ];
        }

        $response[] = [
            "batch_id" => $batch_id,
            "batch_name" => $batch_name,
            "batch_description" => $batch_description,
            "creationdate" => $creationdate,
            "total_user" => $user_count,
            "plan_name" => $plan_name,
            "batch_status" => $batch_status,
            "creationby" => $creationby,
            "accounts" => $accounts
        ];
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);

?>
