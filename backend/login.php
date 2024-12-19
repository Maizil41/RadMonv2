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
require_once '../config/pdo_db.php';

$conn = get_db_connection();

session_name('radmonv2_session');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userIP = $_POST['ipaddress'];

    $stmt = $conn->prepare("SELECT password FROM operators WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $user['password'] === $password) {
        $_SESSION['username'] = $username;

        $log_stmt = $conn->prepare("INSERT INTO app_log (username, password, ipaddress, reply) VALUES (?, ?, ?, ?)");
        $log_stmt->execute([$username, $password, $userIP, 'Login successful']);

        header("Location: ../pages/dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password.";

        $log_stmt = $conn->prepare("INSERT INTO app_log (username, password, ipaddress, reply) VALUES (?, ?, ?, ?)");
        $log_stmt->execute([$username, $password, $userIP, 'Login Failed']);

        header("Location: ../pages/login.php");
        exit();
    }
}
?>