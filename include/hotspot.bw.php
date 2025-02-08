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
require '../config/mysqli_db.php';
include '../include/functions.php';

$sql_total = "SELECT COUNT(*) as total FROM bandwidth";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_bandwidth = $row_total['total'];

$sql = "SELECT id, name, rate_down, rate_up
FROM bandwidth
ORDER BY id DESC";

$result = $conn->query($sql);
?>