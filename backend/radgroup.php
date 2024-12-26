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

$sql_combined = "
SELECT DISTINCT planName FROM billing_plans
WHERE planName IN (
    SELECT DISTINCT groupname FROM radgroupcheck
    INTERSECT
    SELECT DISTINCT groupname FROM radgroupreply
)
AND planCode != 'PPPoE';
";

$result_combined = $conn->query($sql_combined);

$options = array();
$options['plans'] = array();

if ($result_combined->num_rows > 0) {
    while($row = $result_combined->fetch_assoc()) {
        $options['plans'][] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');

echo json_encode($options);
?>