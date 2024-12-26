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

if (!isset($_GET['id'])) {
    echo "<script>alert('UserID is missing!'); window.location.href = 'balance.php';</script>";
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT username, password, balance, whatsapp_number, telegram_id FROM client WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$uid = $result->fetch_assoc();

if (!$uid) {
    echo "<script>alert('User not found!'); window.location.href = 'balance.php';</script>";
    exit();
}

$client_phone = isset($uid['whatsapp_number']) ? preg_replace('/^62/', '', trim($uid['whatsapp_number'])) : '';

?>