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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!empty($input['users']) && is_array($input['users'])) {
        $users = $input['users'];

        require_once '../config/mysqli_db.php';

        $errors = [];
        foreach ($users as $user) {
            $user = mysqli_real_escape_string($conn, $user);

            $sqlDeleteRadacct = "DELETE FROM radacct WHERE username = '$user'";
            $sqlDeleteRadcheck = "DELETE FROM radcheck WHERE username = '$user'";
            $sqlDeleteUserBillInfo = "DELETE FROM userbillinfo WHERE username = '$user'";
            $sqlDeleteUserUserinfo = "DELETE FROM userinfo WHERE username = '$user'";
            $sqlDeleteUserRadusergroup = "DELETE FROM radusergroup WHERE username = '$user'";

            if (!mysqli_query($conn, $sqlDeleteRadacct)) $errors[] = "Error deleting from radacct for $user: " . mysqli_error($conn);
            if (!mysqli_query($conn, $sqlDeleteRadcheck)) $errors[] = "Error deleting from radcheck for $user: " . mysqli_error($conn);
            if (!mysqli_query($conn, $sqlDeleteUserBillInfo)) $errors[] = "Error deleting from userbillinfo for $user: " . mysqli_error($conn);
            if (!mysqli_query($conn, $sqlDeleteUserUserinfo)) $errors[] = "Error deleting from userinfo for $user: " . mysqli_error($conn);
            if (!mysqli_query($conn, $sqlDeleteUserRadusergroup)) $errors[] = "Error deleting from radusergroup for $user: " . mysqli_error($conn);
        }

        if (empty($errors)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'errors' => $errors]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Data tidak valid.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Metode tidak valid.']);
}
?>
