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

function money($number) {
    return "Rp " . number_format($number, 0, ',', '.');
}

function toxbyte($size) {
    if ($size > 1073741824) {
        return round($size / 1073741824, 2) . " GB";
    } elseif ($size > 1048576) {
        return round($size / 1048576, 2) . " MB";
    } elseif ($size > 1024) {
        return round($size / 1024, 2) . " KB";
    } else {
        return $size . " B";
    }
}

function time2str($time) {
    $str = "";
    $time = floor($time);
    if (!$time) return "0 seconds";
    $d = floor($time / 86400);
    if ($d) {
        $str .= "$d days, ";
        $time %= 86400;
    }
    $h = floor($time / 3600);
    if ($h) {
        $str .= "$h hrs, ";
        $time %= 3600;
    }
    $m = floor($time / 60);
    if ($m) {
        $str .= "$m min, ";
        $time %= 60;
    }
    if ($time) $str .= "$time sec, ";
    return rtrim($str, ', ');
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$total_query = "SELECT COUNT(DISTINCT username) AS total_users
FROM radacct
WHERE acctstoptime IS NULL";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_users = $total_row['total_users'];

$query = "
WITH TotalSesi AS (
    SELECT username, 
           SUM(acctsessiontime) AS total_acctsessiontime, 
           SUM(acctinputoctets) AS total_acctinputoctets, 
           SUM(acctoutputoctets) AS total_acctoutputoctets,
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
       rgc.value AS Max_All_Session
FROM radacct ra
JOIN TotalSesi ts ON ra.username = ts.username
LEFT JOIN userbillinfo ubi ON ra.username = ubi.username
LEFT JOIN radgroupcheck rgc ON ubi.planName = rgc.groupname AND rgc.attribute = 'Max-All-Session'
WHERE ra.acctstoptime IS NULL
GROUP BY ra.username, ra.callingstationid, ra.framedipaddress, ts.total_acctsessiontime, ts.total_acctinputoctets, ts.total_acctoutputoctets, ts.last_uptime, ubi.planName, rgc.value;
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
    'page' => $page,
    'total_users' => $total_users,
    'users' => $activeUsers
]);

?>
