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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['name'], $input['rate_down'], $input['rate_down_unit'], $input['rate_up'], $input['rate_up_unit'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit();
    }

    $name = trim($input['name']);
    $rate_down = floatval(str_replace(',', '.', $input['rate_down']));
    $rate_down_unit = $input['rate_down_unit'];
    $rate_up = floatval(str_replace(',', '.', $input['rate_up']));
    $rate_up_unit = $input['rate_up_unit'];

    $rate_down_bps = 0;
    $rate_up_bps = 0;

    if ($rate_down_unit === 'Kbps') {
        $rate_down_bps = $rate_down * 1000;
    } elseif ($rate_down_unit === 'Mbps') {
        $rate_down_bps = $rate_down * 1048576;
    } else {
        $rate_down_bps = $rate_down;
    }

    if ($rate_up_unit === 'Kbps') {
        $rate_up_bps = $rate_up * 1000;
    } elseif ($rate_up_unit === 'Mbps') {
        $rate_up_bps = $rate_up * 1048576;
    } else {
        $rate_up_bps = $rate_up;
    }

    $creation_date = date('Y-m-d H:i:s');

    $sql = "SELECT COUNT(*) as count FROM bandwidth WHERE name = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            echo json_encode(['status' => 'error', 'message' => '❌ Bandwidth Name already exists.']);
            $conn->close();
            exit();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed: ' . $conn->error]);
        $conn->close();
        exit();
    }

    $insert = "INSERT INTO bandwidth (name, rate_down, rate_up, creation_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert);
    if ($stmt) {
        $stmt->bind_param("siis", $name, $rate_down_bps, $rate_up_bps, $creation_date);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => '✅ Bandwidth successfully added.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => '❌ Error: ' . $conn->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => '❌ Error: ' . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
