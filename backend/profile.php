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

if (!isset($_GET['id'])) {
    echo "<script>alert('Plan ID is missing!'); window.location.href = 'list_plan.php';</script>";
    exit();
}

$plan_id = $_GET['id'];

$stmt = $conn->prepare("SELECT 
    bp.planName, 
    bp.planCode, 
    bp.planTimeBank, 
    bp.planCost,
    rgc_simultaneous.value AS Simultaneous_Use,
    rgc_max.value AS Max_All_Session,
    rgr_octets.value AS Max_Total_Octets,
    rgr_timeout.value AS idle_timeout
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
    radgroupreply rgr_timeout 
    ON bp.planName = rgr_timeout.groupname 
    AND rgr_timeout.attribute = 'Idle-Timeout'
WHERE bp.id = ?");
$stmt->bind_param("i", $plan_id);
$stmt->execute();
$result = $stmt->get_result();
$plan = $result->fetch_assoc();

if (!$plan) {
    echo "<script>alert('Plan not found!'); window.location.href = 'list_plan.php';</script>";
    exit();
}

$time_bank_in_seconds = (int)$plan['planTimeBank'];
$time_bank_unit = "S";

if ($time_bank_in_seconds >= 86400) {
    $time_bank = floor($time_bank_in_seconds / 86400);
    $time_bank_unit = "D";
} elseif ($time_bank_in_seconds >= 3600) {
    $time_bank = floor($time_bank_in_seconds / 3600);
    $time_bank_unit = "H";
} elseif ($time_bank_in_seconds >= 60) {
    $time_bank = floor($time_bank_in_seconds / 60);
    $time_bank_unit = "M";
} else {
    $time_bank = $time_bank_in_seconds;
}

$time_max_in_seconds = (int)$plan['Max_All_Session'];
$time_max_unit = "S";

if ($time_max_in_seconds >= 86400) {
    $time_max = floor($time_max_in_seconds / 86400);
    $time_max_unit = "D";
} elseif ($time_max_in_seconds >= 3600) {
    $time_max = floor($time_max_in_seconds / 3600);
    $time_max_unit = "H";
} elseif ($time_max_in_seconds >= 60) {
    $time_max = floor($time_max_in_seconds / 60);
    $time_max_unit = "M";
} else {
    $time_max = $time_max_in_seconds;
}

$data_value_in_bits = (int)$plan['Max_Total_Octets'];
$data_unit = "MB";
$data_value = $data_value_in_bits / 1024 / 1024;

if ($data_value >= 1024) {
    $data_value = $data_value / 1024;
    $data_unit = "GB";
}
?>