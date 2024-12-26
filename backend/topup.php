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
require '../config/mysqli_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id'], $_POST['username'], $_POST['whatsapp_number'], $_POST['amount'])) {
    
    $action = $_POST['action'];
    $id = $_POST['id'];
    $username = $_POST['username'];
    $amount = floatval($_POST['amount']);
    $whatsapp_number = $_POST['whatsapp_number'];
    
    if ($action === 'accept') {
        $query = 'UPDATE client SET balance = balance + ? WHERE username = ?';
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Error prepare statement: ' . $conn->error);
        }
        $stmt->bind_param('ds', $amount, $username);
        $stmt->execute();
        $stmt->close();

        $query = 'UPDATE topup SET status = "Accept" WHERE id = ? AND amount = ? AND status = "Pending"';
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Error prepare statement: ' . $conn->error);
        }
        $stmt->bind_param('sd', $id, $amount);
        $stmt->execute();
        $stmt->close();

        $message = "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n*▬▬▬   TOPUP INVOICE  ▬▬▬*\n▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n*Nama : $username*\n*Nomor : $whatsapp_number*\n*Jumlah : Rp.$amount*\n*Topup ID : $id*\n*Status : SUKSES*\n▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬ ";
        kirimPesanWhatsApp($whatsapp_number, $message);

    } elseif ($action === 'reject') {
        $query = 'UPDATE topup SET status = "Reject" WHERE id = ? AND amount = ? AND status = "Pending"';
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Error prepare statement: ' . $conn->error);
        }
        $stmt->bind_param('sd', $id, $amount);
        $stmt->execute();
        $stmt->close();

        $message = "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n*▬▬▬   TOPUP INVOICE  ▬▬▬*\n▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n*Nama : $username*\n*Nomor : $whatsapp_number*\n*Jumlah : Rp.$amount*\n*Topup ID : $id*\n*Status : GAGAL*\n▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬ ";
        kirimPesanWhatsApp($whatsapp_number, $message);

    } else {
        exit();
    }
    
    exit();
}

$conn->close();

function kirimPesanWhatsApp($whatsapp_number, $message) {
    $url = 'http://localhost:3000/send-message';
    $data = [
        'to' => $whatsapp_number,
        'message' => $message,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    if ($response === false) {
        die('cURL Error: ' . curl_error($ch));
    }

    curl_close($ch);
    return $response;
}
?>