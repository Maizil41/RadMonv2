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

$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$planNameFilter = isset($_GET['planName']) ? $_GET['planName'] : '';

$total_query = "
SELECT COUNT(DISTINCT r.username) as total_users 
FROM radcheck r 
LEFT JOIN (
    SELECT username, acctstoptime, acctterminatecause, callingstationid, framedipaddress, acctsessiontime, acctinputoctets, acctoutputoctets 
    FROM radacct 
    WHERE (username, acctstarttime) IN (
        SELECT username, MAX(acctstarttime) 
        FROM radacct 
        WHERE username REGEXP '^[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}$'
        GROUP BY username
    )
) latest_acct ON r.username = latest_acct.username 
LEFT JOIN userbillinfo u ON r.username = u.username 
LEFT JOIN billing_plans p ON u.planName = p.planName 
LEFT JOIN radusergroup ugr ON r.username = ugr.username 
WHERE r.username REGEXP '^[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}$'
AND ('$statusFilter' = '' OR 
    CASE 
        WHEN latest_acct.username IS NULL THEN 'OFFLINE' 
        WHEN latest_acct.acctterminatecause = 'Session-Timeout' THEN 'EXPIRED' 
        WHEN latest_acct.acctstoptime IS NOT NULL THEN 'OFFLINE' 
        WHEN latest_acct.acctstoptime IS NULL THEN 'ONLINE' 
        ELSE 'OFFLINE' 
    END = '$statusFilter'
) 
AND ('$planNameFilter' = '' OR u.planName = '$planNameFilter') 
";

$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_users = $total_row['total_users'];

$query = "
WITH LatestAcct AS (
    SELECT username,
           MAX(acctstarttime) AS latest_acctstarttime
    FROM radacct
    WHERE username REGEXP '^[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}$'
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
    WHERE a.username REGEXP '^[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}$'
),
AcctSummary AS (
    SELECT username,
           SUM(acctinputoctets) AS total_input_octets,
           SUM(acctoutputoctets) AS total_output_octets,
           SUM(acctsessiontime) AS total_session_time
    FROM radacct
    WHERE username REGEXP '^[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}$'
    GROUP BY username
),
AggregatedData AS (
    SELECT r.username,
           uinfo.firstname AS user_alias,
           u.planName,
           p.planCost,
           ugr.groupname,
           (SELECT framedipaddress 
            FROM radacct 
            WHERE username = r.username 
              AND acctstarttime = la.latest_acctstarttime
            LIMIT 1) AS ip_address,
           (SELECT callingstationid 
            FROM radacct 
            WHERE username = r.username 
              AND acctstarttime = la.latest_acctstarttime
            LIMIT 1) AS mac_address,
           COALESCE(acs.total_input_octets, 0) AS total_input_octets,
           COALESCE(acs.total_output_octets, 0) AS total_output_octets,
           COALESCE(acs.total_session_time, 0) AS total_session_time
    FROM radcheck r
    LEFT JOIN userbillinfo u ON r.username = u.username
    LEFT JOIN billing_plans p ON u.planName = p.planName
    LEFT JOIN radusergroup ugr ON r.username = ugr.username
    LEFT JOIN AcctSummary acs ON r.username = acs.username
    LEFT JOIN LatestAcct la ON r.username = la.username
    LEFT JOIN userinfo uinfo ON r.username = uinfo.username
    WHERE r.username REGEXP '^[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}([-:]?)[0-9A-Fa-f]{2}$'
),
FinalData AS (
    SELECT ad.username,
           ad.user_alias,
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
AND ('$planNameFilter' = '' OR planName = '$planNameFilter');
";
$result = $conn->query($query);

?>