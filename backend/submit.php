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

$hsname1 = $conn->real_escape_string($_POST['hsname1']);
$hsname2 = $conn->real_escape_string($_POST['hsname2']);
$hsip = $conn->real_escape_string($_POST['hsip']);
$hsdomain = $conn->real_escape_string($_POST['hsdomain']);
$hscsn = $conn->real_escape_string($_POST['hscsn']);
$hsqrmode = $conn->real_escape_string($_POST['hsqrmode']);
$hsipdomain = $conn->real_escape_string($_POST['hsipdomain']);
$logomode = $conn->real_escape_string($_POST['logomode']);

$sql = "UPDATE print_config SET 
    hsname1 = '$hsname1', 
    hsname2 = '$hsname2', 
    hsip = '$hsip', 
    hsdomain = '$hsdomain', 
    hscsn = '$hscsn', 
    hsqrmode = '$hsqrmode', 
    hsipdomain = '$hsipdomain', 
    logomode = '$logomode' 
    WHERE id = 1";

if ($conn->query($sql) === TRUE) {
    $message = urlencode("✅ Success.");
    header('Location: ../voucher/template.php?message=' . $message);
    exit();
} else {
    $message = urlencode("❌ Failed.");
    header('Location: ../voucher/template.php?message=' . $message);
    exit();
}

$conn->close();
?>
