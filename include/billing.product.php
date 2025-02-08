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

$sql_total = "SELECT COUNT(*) as total FROM product";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_product = $row_total['total'];

$query = "SELECT id, name, price, amount FROM product ORDER BY id DESC";
$result = $conn->query($query);
?>