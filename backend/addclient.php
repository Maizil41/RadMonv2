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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addclient'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $balance = $_POST['balance'];
    $telegram = isset($_POST['telegram']) ? trim($_POST['telegram']) : '';
    $whatsapp = isset($_POST['whatsapp']) ? trim($_POST['whatsapp']) : '';

    $stmt_check = $conn->prepare("SELECT id FROM client WHERE username = ?");
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $message = urlencode("❌ Username already exists.");
        header('Location: ../billing/adduser.php?message=' . $message);
        exit();
    }

    if (!empty($whatsapp) && substr($whatsapp, 0, 2) !== '62') {
        $whatsapp = '62' . $whatsapp;
    }
    
    if (empty($username) || empty($password)) {
        $message = urlencode("❌ " . $e->getMessage());
        header('Location: ../hotspot/adduser.php?message=' . $message);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO client (username, password, balance, telegram_id, whatsapp_number) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $username, $password, $balance, $telegram, $whatsapp);
    
    if ($stmt->execute()) {
        header('Location: ../billing/user.php');
        exit();
    } else {
        $message = urlencode("❌ " . $e->getMessage());
        header('Location: ../hotspot/adduser.php?message=' . $message);
        exit();
    }
}
?>
