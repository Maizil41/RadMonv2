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

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT acctsessionid, nasipaddress, framedipaddress FROM radacct WHERE username = '$user' AND acctstoptime IS NULL";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $acctid = $row['acctsessionid'];
            $framedipaddress = $row['framedipaddress'];
            $nasipaddress = ($row['nasipaddress'] === '10.10.10.1') ? '127.0.0.1' : $row['nasipaddress'];
            $nasipaddress = escapeshellarg($nasipaddress);

            $command = 'echo \'User-Name="' . $user . '",Acct-Session-Id="' . $acctid . '",Framed-IP-Address="' . $framedipaddress . '"\' | radclient -c 1 -n 3 -r 3 -t 3 -x ' . $nasipaddress . ':3799 disconnect testing123 2>&1';
            shell_exec($command);
        }
    }
}
exit;
?>
