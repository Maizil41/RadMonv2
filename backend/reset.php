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

    $sqlUpdate = "UPDATE radacct SET acctsessiontime = 0, acctinputoctets = 0, acctoutputoctets = 0, acctterminatecause = 'Admin-Reset' WHERE username = '$user'";

    mysqli_query($conn, $sqlUpdate);
}
?>