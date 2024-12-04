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

$output = shell_exec('/usr/bin/cpustat');

list($frequency, $temperature) = explode(' / ', trim($output));

$freq = htmlspecialchars($frequency);
$temp = htmlspecialchars($temperature);

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

function calculatePercentage($part, $total) {
    if ($total == 0) {
        return 0;
    }
    return ($part / $total) * 100;
}

function convertToMBandGB($valueInKB) {
    $valueInMB = $valueInKB / 1024;
    $valueInGB = $valueInMB / 1024;
    
    return [
        'MB' => $valueInMB,
        'GB' => $valueInGB
    ];
}

function formatMemory($valueInMB) {
    if ($valueInMB < 1024) {
        return number_format($valueInMB, 2) . " MiB";
    } else {
        return number_format($valueInMB / 1024, 2) . " GiB";
    }
}

$rootInfo = shell_exec('df -h /');

$lines = explode("\n", trim($rootInfo));

$data = preg_split('/\s+/', $lines[1]);

$freehdd = $data[3];
$used = $data[4];

$freehdd = preg_replace('/([0-9\.]+)([A-Za-z])/', '$1 $2iB', $freehdd);
$used = preg_replace('/([0-9\.]+)([A-Za-z])/', '$1 $2iB', $used);
    
$model = trim(shell_exec('cat /proc/device-tree/model | tr -d "\000"'));

$releaseInfo = shell_exec("cat /etc/openwrt_release");

$lines = explode("\n", trim($releaseInfo));
$id = "";
$version = "";

foreach ($lines as $line) {
    if (strpos($line, "DISTRIB_ID=") === 0) {
        $id = trim(str_replace(["DISTRIB_ID='", "'"], "", $line));
    }
    if (strpos($line, "DISTRIB_RELEASE=") === 0) {
        $version = trim(str_replace(["DISTRIB_RELEASE='", "'"], "", $line));
    }
}

if (file_exists("/usr/bin/cpustat") && is_executable("/usr/bin/cpustat")) {
    $time = shell_exec("/usr/bin/cpustat -u");
    $load = shell_exec("/usr/bin/cpustat -l");
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

$model = htmlspecialchars($model);
$uptime = htmlspecialchars($time);
$load = htmlspecialchars($load);
$host = gethostname();
?> 
