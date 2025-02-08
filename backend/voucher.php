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

$sql = "SELECT 
    bp.planName,
    COUNT(DISTINCT rug.username) AS username_count
FROM 
    billing_plans bp
LEFT JOIN 
    radusergroup rug
    ON rug.groupname = bp.planName
    AND rug.username NOT LIKE '%:%:%:%:%:%'
    AND rug.username NOT LIKE '%-%-%-%-%-%'
WHERE 
    bp.planCode <> 'PPPoE'
GROUP BY 
    bp.planName

UNION ALL

SELECT 
    'All Users' AS planName,
    COUNT(DISTINCT rc.username) AS username_count
FROM 
    radcheck rc
WHERE 
    rc.username NOT LIKE '%:%:%:%:%:%'
    AND rc.username NOT LIKE '%-%-%-%-%-%'
    AND rc.username NOT IN (
        SELECT DISTINCT username
        FROM radcheck
        WHERE attribute = 'Cleartext-Password'
    )
ORDER BY 
    CASE 
        WHEN planName = 'All Users' THEN 0 
        ELSE 1 
    END,
    planName
";

$resultCount = $conn->query($sql);

function generateRandomColor() {
    $colors = [
        'rgba(0, 191, 255, 0.8)',
        'rgba(75, 0, 130, 0.8)',
        'rgba(0, 128, 0, 0.8)',
        'rgba(128, 0, 128, 0.8)',
        'rgba(255, 99, 71, 0.8)',
        'rgba(255, 69, 0, 0.8)',
        'rgba(30, 144, 255, 0.8)',
        'rgba(50, 205, 50, 0.8)',
        'rgba(255, 215, 0, 0.8)',
        'rgba(255, 20, 147, 0.8)',
        'rgba(255, 105, 180, 0.8)',
        'rgba(255, 165, 0, 0.8)',
        'rgba(75, 255, 255, 0.8)',
        'rgba(0, 255, 127, 0.8)',
        'rgba(238, 130, 238, 0.8)',
        'rgba(135, 206, 250, 0.8)',
        'rgba(240, 128, 128, 0.8)',
        'rgba(144, 238, 144, 0.8)',
        'rgba(255, 140, 0, 0.8)',
        'rgba(238, 221, 130, 0.8)',
        'rgba(135, 206, 235, 0.8)',
        'rgba(255, 105, 180, 0.8)',
        'rgba(255, 182, 193, 0.8)',
        'rgba(255, 99, 255, 0.8)',
        'rgba(255, 127, 80, 0.8)',
        'rgba(100, 149, 237, 0.8)',
        'rgba(34, 139, 34, 0.8)',
        'rgba(255, 228, 181, 0.8)',
        'rgba(0, 255, 255, 0.8)',
        'rgba(221, 160, 221, 0.8)',
        'rgba(255, 182, 193, 0.8)',
        'rgba(221, 160, 221, 0.8)',
        'rgba(186, 85, 211, 0.8)'
    ];

    static $usedColors = [];

    $availableColors = array_diff($colors, $usedColors);

    if (empty($availableColors)) {
        $usedColors = []; 
        $availableColors = $colors;
    }

    $randomColor = $availableColors[array_rand($availableColors)];

    $usedColors[] = $randomColor;

    return $randomColor;
}
?>
