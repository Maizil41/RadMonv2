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

$sql = "SELECT * FROM app_log ORDER BY id DESC";

$result = $conn->query($sql);

$user_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = htmlspecialchars($row['username']);
        $password = htmlspecialchars($row['password']);
        $ipaddress = htmlspecialchars($row['ipaddress']);
        $reply = htmlspecialchars($row['reply']);
        $authdate = htmlspecialchars($row['date']);

        $user_data[] = [
            'username' => $username,
            'password' => $password,
            'ipaddress' => $ipaddress,
            'reply' => $reply,
            'authdate' => $authdate
        ];
    }
} else {
    $user_data[] = [
        'username' => '',
        'password' => '',
        'ipaddress' => '',
        'reply' => '',
        'authdate' => ''
    ];
}
?>
