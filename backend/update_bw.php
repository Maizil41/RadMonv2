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
header("Content-Type: application/json");

require '../config/mysqli_db.php';

$response = [
    "success" => false,
    "message" => "",
    "data" => null,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $bw_id = isset($input['id']) ? trim($input['id']) : '';
    $name = isset($input['name']) ? trim($input['name']) : '';
    
    $rate_down = isset($input['rate_down']) ? floatval($input['rate_down']) : 0;
    $rate_down_unit = isset($input['rate_down_unit']) ? $input['rate_down_unit'] : 'Kbps';
    $rate_up = isset($input['rate_up']) ? floatval($input['rate_up']) : 0;
    $rate_up_unit = isset($input['rate_up_unit']) ? $input['rate_up_unit'] : 'Kbps';

    $rate_down_bps = ($rate_down_unit === 'Kbps') ? $rate_down * 1000 : 
                     (($rate_down_unit === 'Mbps') ? $rate_down * 1048576 : $rate_down);

    $rate_up_bps = ($rate_up_unit === 'Kbps') ? $rate_up * 1000 : 
                   (($rate_up_unit === 'Mbps') ? $rate_up * 1048576 : $rate_up);

    $update_date = date('Y-m-d H:i:s');

    $sql = "SELECT COUNT(*) as count FROM bandwidth WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $bw_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $update = "UPDATE bandwidth SET name = ?, rate_down = ?, rate_up = ?, creation_date = ? WHERE id = ?";
            $stmt = $conn->prepare($update);
            if ($stmt) {
                $stmt->bind_param("siiss", $name, $rate_down_bps, $rate_up_bps, $update_date, $bw_id);
                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = "✅ Bandwidth successfully updated.";
                    $response['data'] = [
                        "id" => $bw_id,
                        "name" => $name,
                        "rate_down" => $rate_down_bps,
                        "rate_up" => $rate_up_bps,
                        "creation_date" => $update_date,
                    ];
                } else {
                    $response['message'] = "❌ Error: " . $conn->error;
                }
                $stmt->close();
            } else {
                $response['message'] = "❌ Error: " . $conn->error;
            }
        } else {
            $response['message'] = "❌ Error: ID not found.";
        }
    } else {
        $response['message'] = "❌ Error: " . $conn->error;
    }
} else {
    $response['message'] = "❌ Invalid request method. Only POST is allowed.";
}

$conn->close();

echo json_encode($response);
?>
