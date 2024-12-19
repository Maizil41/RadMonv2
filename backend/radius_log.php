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
$logFile = '/tmp/log/radius.log';

if (isset($_POST['hapus']) && $_POST['hapus'] == '1') {
    if (file_exists($logFile)) {
        file_put_contents($logFile, '');
    } else {
    }
}

if (file_exists($logFile)) {
    $log = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($log === false) {
        $log = ['Tidak dapat membaca log.'];
    }
} else {
    $log = ['File log tidak ditemukan.'];
}

$log = array_reverse($log);

$logString = '';
foreach ($log as $line) {
    #if (strpos($line, 'Login incorrect') !== false) {
    #    if (preg_match('/\[([A-Fa-f0-9]{2}[:-]){5}[A-Fa-f0-9]{2}\//', $line)) {
    #        continue;
    #    }
    #}

    $encodedLine = htmlspecialchars($line);
    $encodedLine = str_replace(
        ['Login OK', 'LogOut OK', 'Login incorrect'],
        ['<span style="color:#4DBD74;">Login OK</span>', 
         '<span style="color:#FFC107;">LogOut OK</span>', 
         '<span style="color:#FF0000;">Login incorrect</span>'],
        $encodedLine
    );
    
    $logString .= $encodedLine . "<br>";
}
?>
