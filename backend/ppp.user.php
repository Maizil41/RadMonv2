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

$total_query = "SELECT COUNT(DISTINCT username) AS total_ppp
FROM radcheck 
WHERE attribute = 'Cleartext-Password';
";

$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_ppp = $total_row['total_ppp'];

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
           SUM(acctinputoctets) AS total_acctinputoctets,
           SUM(acctoutputoctets) AS total_acctoutputoctets,
           SUM(acctsessiontime) AS total_acctsessiontime
    FROM radacct
    GROUP BY username
),
AggregatedData AS (
    SELECT r.username,
           u.contactperson,
           u.planName,
           p.planCost,
           ugr.groupname,
           MAX(CASE WHEN rr.attribute = 'Framed-IP-Address' THEN rr.value END) AS Framed_IP_Address,
           MAX(a.callingstationid) AS callingstationid,
           MAX(CASE WHEN rc.attribute = 'Cleartext-Password' THEN rc.value END) AS Password,
           COALESCE(acs.total_acctinputoctets, 0) AS total_acctinputoctets,
           COALESCE(acs.total_acctoutputoctets, 0) AS total_acctoutputoctets,
           COALESCE(acs.total_acctsessiontime, 0) AS total_acctsessiontime
    FROM radcheck r
    LEFT JOIN userbillinfo u ON r.username = u.username
    LEFT JOIN billing_plans p ON u.planName = p.planName
    LEFT JOIN radusergroup ugr ON r.username = ugr.username
    LEFT JOIN AcctSummary acs ON r.username = acs.username
    LEFT JOIN radacct a ON r.username = a.username
    LEFT JOIN radreply rr ON r.username = rr.username
    LEFT JOIN radcheck rc ON r.username = rc.username
    WHERE EXISTS (
        SELECT 1
        FROM radcheck rc2
        WHERE rc2.username = r.username
          AND rc2.attribute = 'Cleartext-Password'
    )
    GROUP BY r.username, u.contactperson, u.planName, p.planCost, ugr.groupname
),
FinalData AS (
    SELECT ad.username,
           ad.contactperson,
           ad.planName,
           ad.planCost,
           ad.groupname,
           ad.Framed_IP_Address,
           ad.callingstationid,
           ad.Password,
           ad.total_acctinputoctets,
           ad.total_acctoutputoctets,
           ad.total_acctsessiontime,
           COALESCE(sd.status, 'OFFLINE') AS status
    FROM AggregatedData ad
    LEFT JOIN StatusData sd ON ad.username = sd.username
)
SELECT *
FROM FinalData;
";

$result = $conn->query($sql);
?>