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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addProduct'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];

    $stmt_check = $conn->prepare("SELECT * FROM product WHERE name = ?");
    $stmt_check->bind_param("s", $name);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $message = urlencode("❌ product name already exists.");
        header('Location: ../billing/addproduct.php?message=' . $message);
        exit();
    }
    
    if (empty($name)) {
        $message = urlencode("❌ " . $e->getMessage());
        header('Location: ../billing/addproduct.php?message=' . $message);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO product (name, price, amount) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $name, $price, $amount);
    
    if ($stmt->execute()) {
        $message = urlencode("✅ product succesfully added.");
        header('Location: ../billing/addproduct.php?message=' . $message);
        exit();
    } else {
        $message = urlencode("❌ " . $e->getMessage());
        header('Location: ../billing/addproduct.php?message=' . $message);
        exit();
    }
}
?>
