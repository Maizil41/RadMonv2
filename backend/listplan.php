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
header('Content-Type: application/json');
require_once '../config/mysqli_db.php';
include '../include/functions.php';

$response = [];

try {
    $sql_total = "SELECT COUNT(*) as total FROM billing_plans WHERE planCode != 'PPPoE'";
    $result_total = $conn->query($sql_total);
    $row_total = $result_total->fetch_assoc();
    $response['total_batches'] = $row_total['total'];

    $sql = "SELECT 
        bp.id, 
        bp.planName, 
        bp.planCode, 
        bp.planTimeBank, 
        bp.planCost,
        rgc_simultaneous.value AS Simultaneous_Use,
        rgc_max.value AS Max_All_Session,
        rgr_octets.value AS Max_Total_Octets,
        rgbw.bw_id,
        bw.name AS bw_name
FROM 
        billing_plans bp
LEFT JOIN 
        radgroupcheck rgc_simultaneous 
        ON bp.planName = rgc_simultaneous.groupname 
        AND rgc_simultaneous.attribute = 'Simultaneous-Use'
LEFT JOIN 
        radgroupcheck rgc_max 
        ON bp.planName = rgc_max.groupname 
        AND rgc_max.attribute = 'Max-All-Session'
LEFT JOIN 
        radgroupreply rgr_octets 
        ON bp.planName = rgr_octets.groupname 
        AND rgr_octets.attribute = 'ChilliSpot-Max-Total-Octets'
LEFT JOIN 
        radgroupbw rgbw 
        ON bp.planName = rgbw.groupname
LEFT JOIN 
        bandwidth bw
        ON rgbw.bw_id = bw.id 
WHERE 
        bp.planCode <> 'PPPoE'
ORDER BY 
        bp.id DESC;
    ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $response['data'] = [];
        while ($row = $result->fetch_assoc()) {
            $response['data'][] = [
                'id' => htmlspecialchars($row['id']),
                'planName' => htmlspecialchars($row['planName']),
                'planCode' => htmlspecialchars($row['planCode']),
                'planCost' => money($row['planCost']),
                'planTimeBank' => formatTime($row['planTimeBank']),
                'maxAllSession' => formatTime($row['Max_All_Session']),
                'simultaneousUse' => htmlspecialchars($row['Simultaneous_Use']),
                'maxTotalOctets' => toxbyte_plan($row['Max_Total_Octets']),
                'bandwidthName' => htmlspecialchars($row['bw_name']),
            ];
        }
    } else {
        $response['data'] = [];
        $response['message'] = 'Tidak ada data.';
    }
    $response['status'] = 'success';
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
