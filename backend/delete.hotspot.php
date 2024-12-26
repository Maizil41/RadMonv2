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
    $sqlDeleteRadcheck = "DELETE FROM radcheck WHERE username = '$user'";
    $sqlDeleteUserBillInfo = "DELETE FROM userbillinfo WHERE username = '$user'";
    $sqlDeleteUserUserinfo = "DELETE FROM userinfo WHERE username = '$user'";
    $sqlDeleteUserRadusergroup = "DELETE FROM radusergroup WHERE username = '$user'";

    mysqli_query($conn, $sqlDeleteRadacct);
    mysqli_query($conn, $sqlDeleteRadcheck);
    mysqli_query($conn, $sqlDeleteUserBillInfo);
    mysqli_query($conn, $sqlDeleteUserUserinfo);
    mysqli_query($conn, $sqlDeleteUserRadusergroup);
}

exit;
?>

