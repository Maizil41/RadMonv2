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

$pppoeConfigFile = '/etc/config/pppoe';
$localIp = '';

if (file_exists($pppoeConfigFile)) {
    $configContents = file_get_contents($pppoeConfigFile);
    if (preg_match('/option\s+localip\s+\'([^\']+)\'/', $configContents, $matches)) {
        $localIp = $matches[1];
    }
}

$ipRange = [];
if ($localIp) {
    $ipParts = explode('.', $localIp);
    if (count($ipParts) == 4) {
        $baseIp = $ipParts[0] . '.' . $ipParts[1] . '.' . $ipParts[2];
        for ($i = 2; $i <= 254; $i++) {
            $ipRange[] = $baseIp . '.' . $i;
        }
    }
}

$query = "SELECT value FROM radreply";
$result = $conn->query($query);

$existingValues = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $existingValues[] = $row['value'];
    }
}

$newIPs = array_diff($ipRange, $existingValues);

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'data' => array_values($newIPs)
]);

$conn->close();
?>
