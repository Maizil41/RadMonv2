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

$response = [];

function toxbyte($size) {
    if (empty($size)) {
        return "Unlimited";
    }
    
    if ($size >= 1073741824) {
        return round($size / 1073741824, 2) . " GB";
    } elseif ($size >= 1048576) {
        return round($size / 1048576, 2) . " MB";
    } elseif ($size >= 1024) {
        return round($size / 1024, 2) . " KB";
    } else {
        return $size . " B";
    }
}

function formatTime($time) {
    if ($time < 60) {
        return sprintf("");
    } elseif ($time < 3600) {
        $minutes = round($time / 60);
        return sprintf("%d minutes", $minutes);
    } elseif ($time < 86400) {
        $hours = round($time / 3600);
        return sprintf("%d hours", $hours);
    } else {
        $days = round($time / 86400);
        return sprintf("%d days", $days);
    }
}

function money($number) {
    return "Rp " . number_format($number, 0, ',', '.');
}
try {
    $sql_total = "SELECT COUNT(*) as total FROM billing_plans WHERE planCode = 'PPPoE'";
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
        bp.planCode = 'PPPoE'
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
                'maxTotalOctets' => toxbyte($row['Max_Total_Octets']),
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
