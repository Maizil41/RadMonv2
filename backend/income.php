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

$sqlOnlineCount = "
    SELECT 
        COUNT(*) AS total_online
    FROM radacct ra
    LEFT JOIN userbillinfo ub ON ra.username = ub.username
    WHERE ra.acctstoptime IS NULL
";
$resultOnlineCount = $conn->query($sqlOnlineCount);
$rowOnlineCount = $resultOnlineCount->fetch_assoc();
$totalOnline = $rowOnlineCount['total_online'];

$sqlTotalUser = "SELECT COUNT(DISTINCT username) AS total_user FROM radcheck WHERE username NOT LIKE '%:%' AND username NOT LIKE '%-%'";
$resultTotalUser = $conn->query($sqlTotalUser);
$rowTotalUser = $resultTotalUser->fetch_assoc();
$totalUser = $rowTotalUser['total_user'];

$sqlUserCountToday = "
    SELECT COUNT(DISTINCT a.username) AS total_user_today
    FROM radacct a
    WHERE a.acctstarttime IS NOT NULL AND DATE(a.acctstarttime) = CURDATE()
";

$sqlUserCountYesterday = "
    SELECT COUNT(DISTINCT a.username) AS total_user_yesterday
    FROM radacct a
    WHERE a.acctstoptime IS NOT NULL AND DATE(a.acctstarttime) = CURDATE() - INTERVAL 1 DAY
";

$resultUserCountToday = $conn->query($sqlUserCountToday);
$userCountToday = $resultUserCountToday->fetch_assoc()['total_user_today'];

$resultUserCountYesterday = $conn->query($sqlUserCountYesterday);
$userCountYesterday = $resultUserCountYesterday->fetch_assoc()['total_user_yesterday'];

    if ($userCountYesterday > 0 && $userCountToday > 0) {
        $percentChange1 = (($userCountToday - $userCountYesterday) / $userCountYesterday) * 100;
    } else {
        $percentChange1 = ($userCountToday > 0) ? 100 : 0;
    }

$percentChangeFormatted1 = number_format($percentChange1, 0) . '%';

$sqlPendapatanHariIni = "
SELECT SUM(amount) AS total_pendapatan
FROM income
WHERE DATE(date) = CURDATE();
";
$resultPendapatanHariIni = $conn->query($sqlPendapatanHariIni);
$rowPendapatanHariIni = $resultPendapatanHariIni->fetch_assoc();
$totalPendapatanHariIni = $rowPendapatanHariIni['total_pendapatan'];

$sqlPendapatanKemarin = "
SELECT SUM(amount) AS total_pendapatan
FROM income
WHERE DATE(date) = CURDATE() - INTERVAL 1 DAY
";
$resultPendapatanKemarin = $conn->query($sqlPendapatanKemarin);
$rowPendapatanKemarin = $resultPendapatanKemarin->fetch_assoc();
$totalPendapatanKemarin = $rowPendapatanKemarin['total_pendapatan'];

        if ($totalPendapatanKemarin > 0 && $totalPendapatanHariIni > 0) {
            $percentChange2 = (($totalPendapatanHariIni - $totalPendapatanKemarin) / $totalPendapatanKemarin) * 100;
        } else {
            $percentChange2 = ($totalPendapatanHariIni > 0) ? 100 : 0;
        }

$percentChangeFormatted2 = number_format(abs($percentChange2), 0) . '%';
$percentChangeFormatted2 = number_format($percentChange2, 0) . '%';

$totalPendapatanKemarin = number_format($totalPendapatanKemarin, 0);

$sqlPendapatan_bulanIni = "
SELECT SUM(amount) AS total_pendapatan
FROM income
WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())
";

$resultPendapatan_bulanIni = $conn->query($sqlPendapatan_bulanIni);
$rowPendapatan_bulanIni = $resultPendapatan_bulanIni->fetch_assoc();

if (is_array($rowPendapatan_bulanIni) && isset($rowPendapatan_bulanIni['total_pendapatan'])) {
    $totalPendapatan_bulanIni = $rowPendapatan_bulanIni['total_pendapatan'];
} else {
    $totalPendapatan_bulanIni = 0;
}

$sqlPendapatan_bulanLalu = "
SELECT SUM(amount) AS total_pendapatan
FROM income
WHERE YEAR(date) = YEAR(CURDATE() - INTERVAL 1 MONTH) 
  AND MONTH(date) = MONTH(CURDATE() - INTERVAL 1 MONTH)
";

$resultPendapatan_bulanLalu = $conn->query($sqlPendapatan_bulanLalu);
$rowPendapatan_bulanLalu = $resultPendapatan_bulanLalu->fetch_assoc();

if (is_array($rowPendapatan_bulanLalu) && isset($rowPendapatan_bulanLalu['total_pendapatan'])) {
    $totalPendapatan_bulanLalu = $rowPendapatan_bulanLalu['total_pendapatan'];
} else {
    $totalPendapatan_bulanLalu = 0;
}

        if ($totalPendapatan_bulanLalu > 0 && $totalPendapatan_bulanIni > 0) {
            $percentChange3 = (($totalPendapatan_bulanIni - $totalPendapatan_bulanLalu) / $totalPendapatan_bulanIni) * 100;
        } else {
            $percentChange3 = ($totalPendapatan_bulanIni > 0) ? 100 : 0;
        }

$percentChangeFormatted3 = number_format(abs($percentChange3), 0) . '%';
$percentChangeFormatted3 = number_format($percentChange3, 0) . '%';

$totalPendapatan_bulanLalu = number_format($totalPendapatan_bulanLalu, 0);

?>
