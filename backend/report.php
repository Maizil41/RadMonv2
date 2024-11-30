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
include ("../config/mysqli_db.php");

$year_filter = isset($_GET['year']) ? $_GET['year'] : '';
$month_filter = isset($_GET['month']) ? $_GET['month'] : '';
$day_filter = isset($_GET['day']) ? $_GET['day'] : '';

if (isset($_GET['delete'])) {
    $delete_sql = "DELETE FROM income WHERE 1";
    
    if ($year_filter) {
        $delete_sql .= " AND YEAR(date) = '$year_filter'";
    }
    if ($month_filter) {
        $delete_sql .= " AND MONTH(date) = '$month_filter'";
    }
    if ($day_filter) {
        $delete_sql .= " AND DAY(date) = '$day_filter'";
    }

    if ($conn->query($delete_sql) === TRUE) {
    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }
}

$sql = "SELECT username, amount, DATE(date) AS date, TIME(date) AS time FROM income WHERE 1";

if ($year_filter) {
    $sql .= " AND YEAR(date) = '$year_filter'";
}
if ($month_filter) {
    $sql .= " AND MONTH(date) = '$month_filter'";
}
if ($day_filter) {
    $sql .= " AND DAY(date) = '$day_filter'";
}

$result = $conn->query($sql);

$year_query = "SELECT DISTINCT YEAR(date) AS year FROM income ORDER BY year DESC";
$month_query = "SELECT DISTINCT MONTH(date) AS month FROM income ORDER BY month ASC";

$year_result = $conn->query($year_query);
$month_result = $conn->query($month_query);

?>