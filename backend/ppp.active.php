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

$total_query = "SELECT COUNT(DISTINCT username) AS total_users FROM radacct WHERE acctstoptime IS NULL AND framedprotocol = 'ppp';";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_users = $total_row['total_users'];

$query = "
WITH TotalSesi AS (
    SELECT username, 
           SUM(acctsessiontime) AS total_acctsessiontime, 
           SUM(CASE WHEN acctstoptime IS NULL THEN acctinputoctets ELSE 0 END) AS total_acctinputoctets,
           SUM(CASE WHEN acctstoptime IS NULL THEN acctoutputoctets ELSE 0 END) AS total_acctoutputoctets,
           SUM(CASE WHEN acctstoptime IS NULL THEN acctsessiontime ELSE 0 END) AS last_uptime
    FROM radacct 
    GROUP BY username
)
SELECT ra.username, 
       ra.callingstationid, 
       ra.framedipaddress, 
       ts.total_acctsessiontime, 
       ts.total_acctinputoctets, 
       ts.total_acctoutputoctets, 
       ts.last_uptime, 
       ubi.planName, 
       rgc.value AS Max_All_Session,
       rc.value AS password,
       ubi.contactperson
FROM radacct ra
JOIN TotalSesi ts ON ra.username = ts.username
LEFT JOIN userbillinfo ubi ON ra.username = ubi.username
LEFT JOIN radgroupcheck rgc ON ubi.planName = rgc.groupname AND rgc.attribute = 'Max-All-Session'
LEFT JOIN radcheck rc ON ra.username = rc.username AND rc.attribute = 'Cleartext-Password'
WHERE ra.acctstoptime IS NULL
  AND ra.servicetype = 'Framed-User'
GROUP BY ra.username, ra.callingstationid, ra.framedipaddress, ts.total_acctsessiontime, ts.total_acctinputoctets, ts.total_acctoutputoctets, ts.last_uptime, ubi.planName, rgc.value, rc.value, ubi.contactperson
ORDER BY last_uptime;
";

$result = $conn->query($query);

$activeUsers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clientName = htmlspecialchars($row['contactperson']);
        $username = htmlspecialchars($row['username']);
        $password = htmlspecialchars($row['password']);
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
            'clientName' => $clientName,
            'username' => $username,
            'password' => $password,
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
