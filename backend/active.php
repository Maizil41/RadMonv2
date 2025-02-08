<?php
/*
*******************************************************************************************************************
* Warning!!!, Tidak untuk diperjual belikan!, Cukup pakai sendiri atau share kepada orang lain secara gratis
*******************************************************************************************************************
* Author : @Maizil https://t.me/maizil41
*******************************************************************************************************************
* © 2024 Mutiara-Net By @Maizil
*******************************************************************************************************************
*/
require_once '../config/mysqli_db.php';
include '../include/functions.php';

$total_query = "SELECT COUNT(DISTINCT username, framedipaddress) AS total_users FROM radacct WHERE acctstoptime IS NULL AND framedprotocol != 'ppp';";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_users = $total_row['total_users'];

$query = "
WITH TotalSesi AS (
    SELECT username,
           SUM(acctsessiontime) AS total_acctsessiontime
    FROM radacct
    GROUP BY username
),
DetailSesi AS (
    SELECT username,
           framedipaddress,
           SUM(CASE WHEN acctstoptime IS NULL THEN acctinputoctets ELSE 0 END) AS total_acctinputoctets,
           SUM(CASE WHEN acctstoptime IS NULL THEN acctoutputoctets ELSE 0 END) AS total_acctoutputoctets,
           MAX(CASE WHEN acctstoptime IS NULL THEN acctsessiontime ELSE 0 END) AS last_uptime
    FROM radacct
    GROUP BY username, framedipaddress
)
SELECT ra.username,
       ra.callingstationid,
       ra.framedipaddress,
       ts.total_acctsessiontime,
       ds.total_acctinputoctets,
       ds.total_acctoutputoctets,
       ds.last_uptime,
       ubi.planName,
       COALESCE(
           rgc.value,
           (SELECT value FROM radgroupcheck WHERE groupname = ubi.planName AND attribute = 'Access-Period' LIMIT 1)
       ) AS Max_All_Session
FROM radacct ra
JOIN TotalSesi ts ON ra.username = ts.username
JOIN DetailSesi ds ON ra.username = ds.username AND ra.framedipaddress = ds.framedipaddress
LEFT JOIN userbillinfo ubi ON ra.username = ubi.username
LEFT JOIN radgroupcheck rgc ON ubi.planName = rgc.groupname AND rgc.attribute = 'Max-All-Session'
WHERE ra.acctstoptime IS NULL
  AND ra.servicetype != 'Framed-User'
GROUP BY ra.username, ra.callingstationid, ra.framedipaddress, ts.total_acctsessiontime, ds.total_acctinputoctets, ds.total_acctoutputoctets, ds.last_uptime, ubi.planName, rgc.value
ORDER BY ds.last_uptime;
";

$result = $conn->query($query);

$activeUsers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = htmlspecialchars($row['username']);
        $usermac = htmlspecialchars($row['callingstationid']);    
        $ip = htmlspecialchars($row['framedipaddress']);
        $plan = htmlspecialchars($row['planName']);
        
        if (is_null($row['Max_All_Session'])) {
            $totalTime = "";
        } else {
            $totalTime = time2str(($row['Max_All_Session']) - ($row['total_acctsessiontime']));
        }

        $uptime = htmlspecialchars(time2str($row['last_uptime']));
        $upload = htmlspecialchars(toxbyte($row['total_acctinputoctets']));
        $download = htmlspecialchars(toxbyte($row['total_acctoutputoctets']));
        $traffic = htmlspecialchars(toxbyte($row['total_acctinputoctets'] + $row['total_acctoutputoctets']));

        $activeUsers[] = [
            'username' => $username,
            'mac' => $usermac,
            'ip' => $ip,
            'plan' => $plan,
            'totalTime' => $totalTime,
            'uptime' => $uptime,
            'upload' => $upload,
            'download' => $download,
            'traffic' => $traffic
        ];
    }
}

header('Content-Type: application/json');
echo json_encode([
    'total_users' => $total_users,
    'users' => $activeUsers
]);

?>
