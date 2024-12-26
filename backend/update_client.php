<?php
/*
*******************************************************************************************************************
* Warning!!!, Tidak untuk diperjual belikan!, Cukup pakai sendiri atau share kepada orang lain secara gratis
*******************************************************************************************************************
* Dibuat oleh @Maizil https://t.me/maizil41
*******************************************************************************************************************
* © 2024 Mutiara-Net By @Maizil
*******************************************************************************************************************
*/

require '../config/mysqli_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateusers'])) {

    $uid = $_POST['uid'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $balance = $_POST['balance'];
    $telegram = $_POST['telegram'];
    $whatsapp = isset($_POST['whatsapp']) ? trim($_POST['whatsapp']) : '';

    if (!empty($whatsapp) && substr($whatsapp, 0, 2) !== '62') {
        $whatsapp = '62' . $whatsapp;
    }
    
    if (empty($username) || empty($password)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $stmt = $conn->prepare("UPDATE client SET username = ?, password = ?, balance = ?, telegram_id = ?, whatsapp_number = ? WHERE id = ?");
    $stmt->bind_param("ssissi", $username, $password, $balance, $telegram, $whatsapp, $uid);
    
    if ($stmt->execute()) {
        header('Location: ../billing/user.php');
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
?>
