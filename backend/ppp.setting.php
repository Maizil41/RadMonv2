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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $interface = $_POST['interface'] ?? '';
    $ipaddress = $_POST['ipaddress'] ?? '';
    $config = $_POST['config'] ?? '';
    $mtu = $_POST['mtu'] ?? '';

    if (!empty($interface) && !empty($ipaddress) && !empty($config) && !empty($mtu)) {
        shell_exec("uci set pppoe.@pppoe_server[0].localip='$ipaddress'");
        shell_exec("uci set pppoe.@pppoe_server[0].optionsfile='$config'");
        shell_exec("uci set pppoe.@pppoe_server[0].mss='$mtu'");
        shell_exec("uci commit pppoe");
        shell_exec("uci set network.pppoe.device='$interface'");
        shell_exec("uci set network.pppoe.ipaddr='$ipaddress'");
        shell_exec("uci commit network");
        shell_exec("ifdown pppoe && ifup pppoe");
        shell_exec("/etc/init.d/pppoe-server restart");

        header('Location: ../pppoe/settings.php?message=✅+Success.');
        exit;
    } else {
        header('Location: ../pppoe/settings.php?message=❌+Failed.');
        exit;
    }
} else {
    header('Location: ../pppoe/settings.php');
    exit;
}
