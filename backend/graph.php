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
header("Content-Type: application/json");

$interface = 'br-radius';

function getInterfaceSpeed($interface) {
    $output = shell_exec("cat /proc/net/dev | grep $interface");

    if ($output === null) {
        return [
            "error" => "Tidak dapat mengambil data dari interface $interface"
        ];
    }

    $output = preg_replace('!\s+!', ' ', $output);
    $data = explode(' ', trim($output));

    if (count($data) < 10) {
        return [
            "error" => "Format data tidak valid"
        ];
    }

    return [
        "interface" => $interface,
        "rx_bytes" => (int)$data[1],
        "tx_bytes" => (int)$data[9]
    ];
}

$data = getInterfaceSpeed($interface);

echo json_encode($data);
?>
