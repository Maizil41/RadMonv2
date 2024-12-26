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
header('Content-Type: application/json');

if (!isset($_GET['host']) || empty($_GET['host'])) {
    echo json_encode(['error' => 'Host tidak diberikan']);
    exit;
}

$host = escapeshellarg($_GET['host']);

$output = [];
$returnVar = 0;
exec("ping -c 4 $host", $output, $returnVar);

if ($returnVar !== 0) {
    // Jika perintah ping gagal
    echo json_encode(['error' => 'Ping gagal.']);
    exit;
}

$packetLoss = null;
$avgTime = null;
foreach ($output as $line) {
    if (preg_match('/(\d+)% packet loss/', $line, $matches)) {
        $packetLoss = $matches[1];
    }
    if (preg_match('/round-trip min\/avg\/max = [\d.]+\/([\d.]+)\/[\d.]+ ms/', $line, $matches)) {
        $avgTime = $matches[1];
    }
}

if ($packetLoss === null || $avgTime === null) {
    echo json_encode(['error' => 'Data tidak dapat dianalisis.']);
    exit;
}

echo json_encode([
    'packetLoss' => $packetLoss,
    'avgTime' => $avgTime
]);

?>