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

require_once '../config/pdo_db.php';

$conn = get_db_connection();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $batch_id = intval($_GET['id']);

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("DELETE FROM batch_history WHERE id = ?");
        $stmt->execute([$batch_id]);

        $stmt = $conn->prepare("SELECT username FROM userbillinfo WHERE batch_id = ?");
        $stmt->execute([$batch_id]);
        $usernames = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        if ($usernames) {
            $placeholders = implode(',', array_fill(0, count($usernames), '?'));

            $stmt = $conn->prepare("DELETE FROM radcheck WHERE username IN ($placeholders)");
            $stmt->execute($usernames);

            $stmt = $conn->prepare("DELETE FROM radacct WHERE username IN ($placeholders)");
            $stmt->execute($usernames);

            $stmt = $conn->prepare("DELETE FROM userinfo WHERE username IN ($placeholders)");
            $stmt->execute($usernames);

            $stmt = $conn->prepare("DELETE FROM radusergroup WHERE username IN ($placeholders)");
            $stmt->execute($usernames);

            $stmt = $conn->prepare("DELETE FROM userbillinfo WHERE batch_id = ?");
            $stmt->execute([$batch_id]);
        }

        $conn->commit();

    } catch (Exception $e) {
        $conn->rollBack();
    }

    exit;
}

$rows = [];
?>
