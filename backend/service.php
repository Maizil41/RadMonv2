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
if (isset($_GET['service'])) {
    $service = escapeshellcmd($_GET['service']);
    $output = shell_exec("/etc/init.d/$service restart 2>&1");
    echo "Service $service berhasil direstart: $output";
} else {
    echo "Service tidak ditemukan.";
}
?>
