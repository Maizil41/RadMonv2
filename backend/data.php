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
function getCpuUsage() {
    $cpuUsage = [];

    if (file_exists("/sys/devices/system/cpu/cpufreq/policy0/scaling_available_frequencies")) {
        $command = "expr 100 - $(top -n 1 | grep 'CPU:' | awk -F '%' '{print $4}' | awk -F ' ' '{print $2}')";
        $output = shell_exec($command);

        if ($output !== null) {
            $cpuValue = intval(trim($output));
            $cpuUsage[] = ['cpu' => $cpuValue];
        }
    }

    return $cpuUsage;
}

$data = getCpuUsage();

$cpuValue = $data[0]['cpu'];

function getMemoryInfo() {
    $command = "awk 'BEGIN{Total=0;Free=0}$1~/^MemTotal:/{Total=$2}$1~/^MemFree:|^Buffers:|^Cached:/{Free+=$2}END{Used=Total-Free;printf\"%.0f\t%.0f\t%.1f\t%.0f\",Total*1024,Used*1024,(Total>0)?((Used/Total)*100):0,Free*1024}' /proc/meminfo 2>/dev/null";
    $output = shell_exec($command);

    list($total, $used, $usedPercent, $free) = explode("\t", trim($output));

    return [
        'total' => (int)$total,
        'used' => (int)$used,
        'used_percent' => (float)$usedPercent,
        'free' => (int)$free
    ];
}

function convertMemory($bytes) {
    if ($bytes >= 1024 * 1024 * 1024) {
        $size = $bytes / (1024 * 1024 * 1024);
        return round($size, 2) . " GiB";
    } elseif ($bytes >= 1024 * 1024) {
        $size = $bytes / (1024 * 1024);
        return round($size, 2) . " MiB";
    } else {
        $size = $bytes / 1024;
        return round($size, 2) . " KiB";
    }
}

$memoryInfo = getMemoryInfo();
$freeMemory = convertMemory($memoryInfo['free']);
$totalMemory = convertMemory($memoryInfo['total']);

function formatMemory($valueInMB) {
    if ($valueInMB < 1024) {
        return number_format($valueInMB, 2) . " MiB";
    } else {
        return number_format($valueInMB / 1024, 2) . " GiB";
    }
}

$free_hdd = shell_exec("df -h / | grep '/' | awk '{print $4}'");
$total_hdd = shell_exec("df -h / | grep '/' | awk '{print $2}'");

$freehdd = preg_replace('/([0-9\.]+)([A-Za-z])/', '$1 $2iB', $free_hdd);
$totalhdd = preg_replace('/([0-9\.]+)([A-Za-z])/', '$1 $2iB', $total_hdd);
    
$model = trim(shell_exec('ubus call system board | jq -r ".model"'));
$distrib = trim(shell_exec('ubus call system board | jq -r ".release" | jq -r ".distribution"'));
$version = trim(shell_exec('ubus call system board | jq -r ".release" | jq -r ".version"'));

if (file_exists("/usr/bin/cpustat") && is_executable("/usr/bin/cpustat")) {
    $time = shell_exec("/usr/bin/cpustat -u");
    $load = shell_exec("/usr/bin/cpustat -l");
    $temp = shell_exec("/usr/bin/cpustat -t");
} else {
    $uptimeString = shell_exec('uptime | tr -d \',\'');

    preg_match("/up\s+(.+?),/", $uptimeString, $uptimeMatches);
    $time = $uptimeMatches[1];

    preg_match("/average:\s+(.+)/", $uptimeString, $loadMatches);
    $load = $loadMatches[1];

    if (strpos($time, "h") !== false) {
        $time = trim($time);
    } elseif (strpos($time, "day") !== false) {
        preg_match("/(\d+) day/", $time, $daysMatches);
        $days = $daysMatches[1] . "d ";
        $time = preg_replace("/\d+ day\s+/", "", $time);
        $time = $days . str_replace(":", "h ", trim($time));
    }
}

define('PROC_UPTIME', '/proc/uptime');

function getSystemUptime() {
    if (file_exists(PROC_UPTIME)) {
        $uptimeData = file_get_contents(PROC_UPTIME);
        $uptimeSeconds = (float) explode(" ", $uptimeData)[0];

        $days = floor($uptimeSeconds / 86400);
        $hours = floor(($uptimeSeconds % 86400) / 3600);
        $minutes = floor(($uptimeSeconds % 3600) / 60);
        $seconds = floor($uptimeSeconds % 60);

        $parts = [];
        if ($days > 0) {
            $parts[] = sprintf('%dd', $days);
        }
        if ($hours > 0) {
            $parts[] = sprintf('%dh', $hours);
        }
        if ($minutes > 0) {
            $parts[] = sprintf('%dm', $minutes);
        }
        if ($seconds > 0) {
            $parts[] = sprintf('%ds', $seconds);
        }

        return implode(' ', $parts);
    } else {
        return "Tidak dapat membaca uptime sistem.";
    }
}

$load = htmlspecialchars($load);
$uptime = getSystemUptime();
$host = gethostname();
?> 
