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
    echo "<script>alert('Bandwidth ID is missing!'); window.location.href = 'list_bandwidth.php';</script>";
    exit();
}

$bw_id = $_GET['id'];

$stmt = $conn->prepare("SELECT name, rate_down, rate_up FROM bandwidth WHERE id = ?");
$stmt->bind_param("i", $bw_id);
$stmt->execute();
$result = $stmt->get_result();
$bw = $result->fetch_assoc();

if (!$bw) {
    echo "<script>alert('Bandwidth not found!'); window.location.href = 'list_bandwidth.php';</script>";
    exit();
}

$rate_down_bps = $bw['rate_down'];
$rate_up_bps = $bw['rate_up'];

if ($rate_down_bps >= 1048576) {
    $rate_down = round($rate_down_bps / 1048576, 2);
    $rate_down_unit = "Mbps";
} else {
    $rate_down = round($rate_down_bps / 1000, 2);
    $rate_down_unit = "Kbps";
}

if ($rate_up_bps >= 1048576) {
    $rate_up = round($rate_up_bps / 1048576, 2);
    $rate_up_unit = "Mbps";
} else {
    $rate_up = round($rate_up_bps / 1000, 2);
    $rate_up_unit = "Kbps";
}
?>