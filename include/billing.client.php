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

function money($number) {
    return "Rp " . number_format($number, 0, ',', '.');
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql_total = "SELECT COUNT(*) as total FROM client";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_users = $row_total['total'];

$query = "SELECT id, username, password, balance, whatsapp_number, telegram_id FROM client ORDER BY username DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($query);
?>