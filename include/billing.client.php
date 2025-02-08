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

$sql_total = "SELECT COUNT(*) as total FROM client";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_users = $row_total['total'];

$query = "SELECT id, username, password, balance, whatsapp_number, telegram_id FROM client ORDER BY username DESC";
$result = $conn->query($query);
?>