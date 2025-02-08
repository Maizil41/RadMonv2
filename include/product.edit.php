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
    echo "<script>alert('Product ID is missing!'); window.location.href = 'product.php';</script>";
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT name, price, amount FROM product WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$uid = $result->fetch_assoc();

if (!$uid) {
    echo "<script>alert('Product not found!'); window.location.href = 'product.php';</script>";
    exit();
}

?>