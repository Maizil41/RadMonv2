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
function money($number) {
    return "Rp " . number_format($number, 0, ',', '.');
}

function toxbyte($size) {
    if ($size > 1073741824) {
        return round($size / 1073741824, 2) . " GB";
    } elseif ($size > 1048576) {
        return round($size / 1048576, 2) . " MB";
    } elseif ($size > 1024) {
        return round($size / 1024, 2) . " KB";
    } else {
        return $size . " B";
    }
}

function toxbyte_plan($size) {
    if (empty($size)) {
        return "Unlimited";
    }
    
    if ($size >= 1073741824) {
        return round($size / 1073741824, 2) . " GB";
    } elseif ($size >= 1048576) {
        return round($size / 1048576, 2) . " MB";
    } elseif ($size >= 1024) {
        return round($size / 1024, 2) . " KB";
    } else {
        return $size . " B";
    }
}

function time2str($time) {
    $str = "";
    $time = floor($time);
    if (!$time) return "0 seconds";
    $d = floor($time / 86400);
    if ($d) {
        $str .= "$d days, ";
        $time %= 86400;
    }
    $h = floor($time / 3600);
    if ($h) {
        $str .= "$h hrs, ";
        $time %= 3600;
    }
    $m = floor($time / 60);
    if ($m) {
        $str .= "$m min, ";
        $time %= 60;
    }
    if ($time) $str .= "$time sec, ";
    return rtrim($str, ', ');
}

function formatTime($time) {
    if ($time < 60) {
        return sprintf("");
    } elseif ($time < 3600) {
        $minutes = round($time / 60);
        return sprintf("%d minutes", $minutes);
    } elseif ($time < 86400) {
        $hours = round($time / 3600);
        return sprintf("%d hours", $hours);
    } else {
        $days = round($time / 86400);
        return sprintf("%d days", $days);
    }
}

function format_bandwidth($bps) {
    if ($bps >= 1048576) {
        $value = $bps / 1048576;
        $formatted_value = ($value == (int)$value) ? (int)$value : number_format($value, 1, '.', '');
        return $formatted_value . ' Mbps';
    } elseif ($bps >= 1000) {
        $value = $bps / 1000;
        $formatted_value = ($value == (int)$value) ? (int)$value : number_format($value, 1, '.', '');
        return $formatted_value . ' Kbps';
    } else {
        return number_format($bps) . ' bps';
    }
}
?>