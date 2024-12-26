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

$sql_bw = "SELECT DISTINCT id, name, rate_down, rate_up FROM bandwidth";
$result_bw = $conn->query($sql_bw);

if (!$result_bw) {
    die("Query failed: " . $conn->error);
}

$options = array();
$options['data'] = array();

if ($result_bw->num_rows > 0) {
    while($row = $result_bw->fetch_assoc()) {
        $options['data'][] = array(
            'bw_id' => $row['id'],
            'bw_name' => $row['name'],
            'rate_down' => $row['rate_down'],
            'rate_up' => $row['rate_up']
        );
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($options);
?>
