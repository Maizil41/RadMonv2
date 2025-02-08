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
function runShellCommand($command) {
    $output = shell_exec($command);
    return trim($output);
}

$output = runShellCommand("awk '\$1 == \"config\" && \$2 == \"device\" {iface = \"\"; next} \$1 == \"option\" && \$2 == \"name\" {print substr(\$3, 2, length(\$3)-2)}' /etc/config/network");

$interfaces = explode("\n", trim($output));

$interfaces = array_filter($interfaces, function($iface) {
    return !preg_match('/^loopback|^wan/', $iface);
});

$interfaces = array_values($interfaces);

$interface = runShellCommand("uci get network.pppoe.device");
$ipaddress = runShellCommand("uci get pppoe.@pppoe_server[0].localip");
$fileconfig = runShellCommand("uci get pppoe.@pppoe_server[0].optionsfile");
$optionmtu = runShellCommand("uci get pppoe.@pppoe_server[0].mss");

?>