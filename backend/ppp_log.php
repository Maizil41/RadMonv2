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

if (isset($_POST['hapus']) && $_POST['hapus'] == '1') {
    $query = "DELETE FROM radpostauth WHERE reply IN ('PPP Login Success', 'PPP Login Failed')";

    if (!$conn->query($query)) {
        error_log("Error saat menghapus data: " . $conn->error);
    }
}

$sql = "SELECT username, pass, reply, authdate 
        FROM radpostauth 
        WHERE reply IN ('PPP Login Success', 'PPP Login Failed') 
        ORDER BY id DESC";

$result = $conn->query($sql);

$user_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = htmlspecialchars($row['username']);
        $password = htmlspecialchars($row['pass']);
        $reply = htmlspecialchars($row['reply']);
        $authdate = htmlspecialchars($row['authdate']);

        $user_data[] = [
            'username' => $username,
            'password' => $password,
            'reply' => $reply,
            'authdate' => $authdate
        ];
    }
} else {
    $user_data[] = [
        'username' => '',
        'password' => '',
        'reply' => '',
        'authdate' => ''
    ];
}

$conn->close();
?>
