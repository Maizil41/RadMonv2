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
function get_ip_info()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $json = curl_exec($ch);
    curl_close($ch);

    if ($json === false) {
        return [];
    }
    $data = json_decode($json, true);
    return $data;
}

$ip_info = get_ip_info();

$ip = isset($ip_info["query"]) ? $ip_info["query"] : "N/A";
$city = isset($ip_info["city"]) ? $ip_info["city"] : "N/A";
$region = isset($ip_info["regionName"]) ? $ip_info["regionName"] : "N/A";
$country = isset($ip_info["country"]) ? $ip_info["country"] : "N/A";
$org_info = isset($ip_info["as"]) ? $ip_info["as"] : "N/A";

$org_parts = explode(" ", $org_info, 2);
$as_number = $org_parts[0];
$organization = isset($org_parts[1]) ? $org_parts[1] : "N/A";

function executeCommand($command)
{
    return trim(shell_exec($command));
}

function printWan()
{
    $output = "";
    $firewallZones = explode(
        "\n",
        executeCommand("uci -q show firewall | grep .masq= | cut -f2 -d.")
    );
    foreach ($firewallZones as $zone) {
        $isMasquerading = executeCommand("uci -q get firewall.$zone.masq");
        if ($isMasquerading === "1") {
            $networks = explode(
                " ",
                executeCommand("uci -q get firewall.$zone.network")
            );
            foreach ($networks as $device) {
                $status = executeCommand(
                    "ubus call network.interface.$device status 2>/dev/null"
                );
                if (!empty($status)) {
                    $statusData = json_decode($status, true);
                    if (isset($statusData["ipv4-address"][0])) {
                        $ip4 = $statusData["ipv4-address"][0]["address"] ?? "";
                        $subnet4 = $statusData["ipv4-address"][0]["mask"] ?? "";
                        $ip4 =
                            !empty($ip4) && !empty($subnet4)
                                ? "$ip4/$subnet4"
                                : $ip4;
                        $output .= "WAN: $ip4 <br>";
                    }
                }
            }
        }
    }
    return $output;
}

function printLan()
{
    $output = "";
    $firewallZones = explode(
        "\n",
        executeCommand(
            "uci -q show firewall | grep ']=zone' | cut -f2 -d. | cut -f1 -d="
        )
    );
    foreach ($firewallZones as $zone) {
        $isMasquerading = executeCommand("uci -q get firewall.$zone.masq");
        if ($isMasquerading !== "1") {
            $networks = explode(
                " ",
                executeCommand("uci -q get firewall.$zone.network")
            );
            foreach ($networks as $device) {
                if ($device === "hotspot") {
                    continue;
                }
                $status = executeCommand(
                    "ubus call network.interface.$device status 2>/dev/null"
                );
                if (!empty($status)) {
                    $statusData = json_decode($status, true);
                    if (isset($statusData["ipv4-address"][0])) {
                        $ip4 = $statusData["ipv4-address"][0]["address"] ?? "";
                        $subnet4 = $statusData["ipv4-address"][0]["mask"] ?? "";
                        $ip4 =
                            !empty($ip4) && !empty($subnet4)
                                ? "$ip4/$subnet4"
                                : $ip4;
                        $output .= "LAN: $ip4 <br>";
                    }
                }
            }
        }
    }
    return $output;
}

function printHotspot()
{
    $output = "";
    $firewallZones = explode(
        "\n",
        executeCommand(
            "uci -q show firewall | grep ']=zone' | cut -f2 -d. | cut -f1 -d="
        )
    );
    foreach ($firewallZones as $zone) {
        $isMasquerading = executeCommand("uci -q get firewall.$zone.masq");
        if ($isMasquerading !== "1") {
            $networks = explode(
                " ",
                executeCommand("uci -q get firewall.$zone.network")
            );
            foreach ($networks as $device) {
                if ($device !== "hotspot") {
                    continue;
                }
                $status = executeCommand(
                    "ubus call network.interface.$device status 2>/dev/null"
                );
                if (!empty($status)) {
                    $statusData = json_decode($status, true);
                    if (isset($statusData["ipv4-address"][0])) {
                        $ip4 = $statusData["ipv4-address"][0]["address"] ?? "";
                        $subnet4 = $statusData["ipv4-address"][0]["mask"] ?? "";
                        $ip4 =
                            !empty($ip4) && !empty($subnet4)
                                ? "$ip4/$subnet4"
                                : $ip4;
                        $output .= "HOTSPOT: $ip4 <br>";
                    }
                }
            }
        }
    }
    return $output;
}

function check_service_status($service_name) {
    $command = "pgrep $service_name";
    $output = shell_exec($command);
    return !empty($output) ? true : false;
}

$services = [
    "MySQL" => "mysql",
    "Radiusd" => "radiusd",
    "Chilli" => "chilli",
    "PPPoE" => "pppoe"
];

?>
