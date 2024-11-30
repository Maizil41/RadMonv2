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

$sqlOnlineCount = "SELECT COUNT(*) AS total_online FROM radacct WHERE acctstoptime IS NULL AND framedprotocol != 'ppp';";
$resultOnlineCount = $conn->query($sqlOnlineCount);
$rowOnlineCount = $resultOnlineCount->fetch_assoc();
$totalOnline = $rowOnlineCount['total_online'];

$sqlTotalUser = "SELECT COUNT(DISTINCT username) AS total_user
FROM radcheck
WHERE username NOT LIKE '%:%'
  AND username NOT LIKE '%-%'
  AND username NOT IN (
      SELECT username
      FROM radcheck
      WHERE attribute = 'Cleartext-Password'
  );
";
$resultTotalUser = $conn->query($sqlTotalUser);
$rowTotalUser = $resultTotalUser->fetch_assoc();
$totalUser = $rowTotalUser['total_user'];

$sqlpppOnline = "SELECT COUNT(*) AS online_ppp FROM radacct WHERE acctstoptime IS NULL AND framedprotocol = 'ppp';";
$resultOnlineppp = $conn->query($sqlpppOnline);
$rowOnlineppp = $resultOnlineppp->fetch_assoc();
$pppOnline = $rowOnlineppp['online_ppp'];

$sqlTotalppp = "SELECT COUNT(DISTINCT username) AS total_ppp
FROM radcheck
WHERE username NOT LIKE '%:%'
  AND username NOT LIKE '%-%'
  AND username IN (
      SELECT username
      FROM radcheck
      WHERE attribute = 'Cleartext-Password'
  );
";
$resultTotalppp = $conn->query($sqlTotalppp);
$rowTotalppp = $resultTotalppp->fetch_assoc();
$pppTotal = $rowTotalppp['total_ppp'];

$sqlPendapatanHariIni = "
SELECT SUM(amount) AS total_harian
FROM income
WHERE DATE(date) = CURDATE();
";
$resultPendapatanHariIni = $conn->query($sqlPendapatanHariIni);
$rowPendapatanHariIni = $resultPendapatanHariIni->fetch_assoc();
$totalPendapatanHariIni = $rowPendapatanHariIni['total_harian'];

$sqlPendapatan_bulanIni = "
SELECT SUM(amount) AS total_bulanan
FROM income
WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())
";

$resultPendapatan_bulanIni = $conn->query($sqlPendapatan_bulanIni);
$rowPendapatan_bulanIni = $resultPendapatan_bulanIni->fetch_assoc();
$totalPendapatan_bulanIni = $rowPendapatan_bulanIni['total_bulanan'];

$sqlPendapatan_tahunIni = "
SELECT SUM(amount) AS total_tahunan
FROM income
WHERE YEAR(date) = YEAR(CURDATE())
";

$resultPendapatan_tahunIni = $conn->query($sqlPendapatan_tahunIni);
$rowPendapatan_tahunIni = $resultPendapatan_tahunIni->fetch_assoc();
$totalPendapatan_tahunIni = $rowPendapatan_tahunIni['total_tahunan'];

$sqlPendapatan_total = "
SELECT SUM(amount) AS total_pendapatan
FROM income
";

$resultPendapatan_total = $conn->query($sqlPendapatan_total);
$rowPendapatan_total = $resultPendapatan_total->fetch_assoc();
$totalPendapatan_total = $rowPendapatan_total['total_pendapatan'];
?>
