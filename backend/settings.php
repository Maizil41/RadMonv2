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

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$userIP = getUserIP();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $useradm = $_POST['useradm'];
    $passadm = $_POST['passadm'];
    #$teleid = $_POST['telegram_id'];
    #$bottoken = $_POST['bot_token'];

    $sql = "UPDATE operators SET username = ?, password = ?, telegram_id = ?, bot_token = ? WHERE id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $useradm, $passadm, $teleid, $bottoken);

    if ($stmt->execute()) {
        $log_stmt = $conn->prepare("INSERT INTO app_log (username, password, ipaddress, reply) VALUES (?, ?, ?, ?)");
        $log_stmt->execute([$useradm, $passadm, $userIP, 'Password Changed']);
        $message = urlencode("✅ Success.");
        header('Location: ../pages/admin.php?message=' . $message);
        exit();
    } else {
    $message = urlencode("❌ Failed.");
        header('Location: ../pages/admin.php?message=' . $message);
        exit();
    }
}

$stmt = $conn->prepare("SELECT * FROM operators WHERE id = ?");
$stmt->bind_param("i", $id);
$id = 1;
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $username_value = $row['username'];
    $password_value = $row['password'];
    #$telegram_value = $row['telegram_id'];
    #$token_value = $row['bot_token'];
} else {
    die("Data tidak ditemukan");
}


$conn->close();
?>
