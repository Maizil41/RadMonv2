<?php
header('Content-Type: application/json');
include('../backend/voucher.php');
require_once '../config/mysqli_db.php';
include '../include/functions.php';

$statusFilter = isset($_GET['statusFilter']) ? $_GET['statusFilter'] : '';
$planNameFilter = isset($_GET['planNameFilter']) ? $_GET['planNameFilter'] : '';

$sql = "
WITH LatestAcct AS (
    SELECT username,
           MAX(acctstarttime) AS latest_acctstarttime
    FROM radacct
    GROUP BY username
),
StatusData AS (
    SELECT a.username,
           CASE
               WHEN a.acctterminatecause = 'Session-Timeout' THEN 'EXPIRED'
               WHEN a.acctstoptime IS NOT NULL THEN 'OFFLINE'
               WHEN a.acctstoptime IS NULL AND a.acctstarttime = la.latest_acctstarttime THEN 'ONLINE'
               ELSE 'OFFLINE'
           END AS status
    FROM radacct a
    JOIN LatestAcct la ON a.username = la.username AND a.acctstarttime = la.latest_acctstarttime
),
AcctSummary AS (
    SELECT username,
           SUM(acctinputoctets) AS total_input_octets,
           SUM(acctoutputoctets) AS total_output_octets,
           SUM(acctsessiontime) AS total_session_time
    FROM radacct
    GROUP BY username
),
AggregatedData AS (
    SELECT r.username,
           u.contactperson,
           u.planName,
           p.planCost,
           ugr.groupname,
           la.framedipaddress AS ip_address,
           la.callingstationid AS mac_address,
           COALESCE(acs.total_input_octets, 0) AS total_input_octets,
           COALESCE(acs.total_output_octets, 0) AS total_output_octets,
           COALESCE(acs.total_session_time, 0) AS total_session_time
    FROM radcheck r
    LEFT JOIN userbillinfo u ON r.username = u.username
    LEFT JOIN billing_plans p ON u.planName = p.planName
    LEFT JOIN radusergroup ugr ON r.username = ugr.username
    LEFT JOIN AcctSummary acs ON r.username = acs.username
    LEFT JOIN (
        SELECT a.username, a.framedipaddress, a.callingstationid
        FROM radacct a
        JOIN LatestAcct la ON a.username = la.username AND a.acctstarttime = la.latest_acctstarttime
    ) la ON r.username = la.username
    GROUP BY r.username, u.contactperson, u.planName, p.planCost, ugr.groupname, la.framedipaddress, la.callingstationid
),
FinalData AS (
    SELECT ad.username,
           ad.contactperson,
           ad.planName,
           ad.planCost,
           ad.groupname,
           ad.ip_address,
           ad.mac_address,
           ad.total_input_octets,
           ad.total_output_octets,
           ad.total_session_time,
           COALESCE(sd.status, 'OFFLINE') AS status
    FROM AggregatedData ad
    LEFT JOIN StatusData sd ON ad.username = sd.username
)
SELECT *
FROM FinalData
WHERE ('$statusFilter' = '' OR status = '$statusFilter')
AND ('$planNameFilter' = '' OR planName = '$planNameFilter')
AND username NOT LIKE '%:%:%:%:%:%'
AND username NOT LIKE '%-%-%-%-%-%'
AND username NOT IN (
    SELECT username
    FROM radcheck
    WHERE attribute = 'Cleartext-Password'
)
ORDER BY status DESC";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'username' => $row['username'],
            'name' => $row['contactperson'],
            'plan_name' => $row['planName'],
            'plan_cost' => $row['planCost'],
            'group_name' => $row['groupname'],
            'ip_address' => $row['ip_address'],
            'mac_address' => $row['mac_address'],
            'total_input_octets' => $row['total_input_octets'],
            'total_output_octets' => $row['total_output_octets'],
            'total_time' => time2str($row['total_session_time']),
            'status' => $row['status'],
        ];
    }
}

echo json_encode($data);
?>
