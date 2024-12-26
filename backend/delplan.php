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
    $plan_name = mysqli_real_escape_string($conn, $_GET['id']);

    $sqlbilling_plans = "DELETE FROM billing_plans WHERE planName = '$plan_name'";
    $sqlradgroupreply = "DELETE FROM radgroupreply WHERE groupname = '$plan_name'";
    $sqlradgroupcheck = "DELETE FROM radgroupcheck WHERE groupname = '$plan_name'";
    $sqlradgroupbw = "DELETE FROM radgroupbw WHERE groupname = '$plan_name'";

    mysqli_query($conn, $sqlbilling_plans);
    mysqli_query($conn, $sqlradgroupreply);
    mysqli_query($conn, $sqlradgroupcheck);
    mysqli_query($conn, $sqlradgroupbw);
}

exit;
?>
