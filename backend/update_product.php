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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateproduct'])) {

    $uid = $_POST['uid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];
    
    if (empty($name)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $stmt = $conn->prepare("UPDATE product SET name = ?, price = ?, amount = ? WHERE id = ?");
    $stmt->bind_param("siii", $name, $price, $amount, $uid);
    
    if ($stmt->execute()) {
        header('Location: ../billing/product.php');
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
?>
