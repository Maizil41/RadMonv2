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

    $sqlDeleteRadacct = "DELETE FROM radacct WHERE username = '$user'";
    $sqlDeleteRadcheck = "DELETE FROM radcheck WHERE username = '$user' AND attribute = 'Expiration'";

    @mysqli_query($conn, $sqlDeleteRadacct);
    @mysqli_query($conn, $sqlDeleteRadcheck);
}
?>