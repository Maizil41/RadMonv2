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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!empty($input['users']) && is_array($input['users'])) {
        $users = $input['users'];
        
        $errors = [];
        foreach ($users as $user) {
            $user = mysqli_real_escape_string($conn, $user);
            
            $sqlDeleteData = "DELETE FROM income WHERE username = '$user'";
            
            @mysqli_query($conn, $sqlDeleteData);
        }
        
    } if (empty($errors)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'errors' => $errors]);
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
