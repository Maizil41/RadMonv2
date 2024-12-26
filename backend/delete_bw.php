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
    $bw_id = mysqli_real_escape_string($conn, $_GET['id']);

    $checkQuery = "SELECT COUNT(*) FROM radgroupbw WHERE bw_id = '$bw_id'";
    $result = mysqli_query($conn, $checkQuery);
    $row = mysqli_fetch_row($result);

    if ($row[0] > 0) {
        $sqldeletegbw = "DELETE FROM radgroupbw WHERE bw_id = '$bw_id'";
        mysqli_query($conn, $sqldeletegbw);
    }

    $sqldeletebw = "DELETE FROM bandwidth WHERE id = '$bw_id'";
    mysqli_query($conn, $sqldeletebw);
}

exit;
?>