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

$sql_total = "SELECT COUNT(*) as total FROM topup WHERE status = 'pending' ";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_request = $row_total['total'];

$query = "SELECT t.id, t.user_id, t.username, t.amount, t.status, t.date, c.whatsapp_number
FROM topup t
JOIN client c ON c.id = t.user_id
WHERE t.status = 'pending'
ORDER BY t.date
DESC";
$result = $conn->query($query);
?>