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
    AND rug.username REGEXP '^[0-9A-Fa-f]{2}([:-])[0-9A-Fa-f]{2}\\1[0-9A-Fa-f]{2}\\1[0-9A-Fa-f]{2}\\1[0-9A-Fa-f]{2}$'
GROUP BY 
    bp.planName

UNION ALL

SELECT 
    'All Users' AS planName,
    COUNT(DISTINCT rc.username) AS username_count
FROM 
    radcheck rc
WHERE 
    rc.username REGEXP '^[0-9A-Fa-f]{2}([:-])[0-9A-Fa-f]{2}\\1[0-9A-Fa-f]{2}\\1[0-9A-Fa-f]{2}\\1[0-9A-Fa-f]{2}$'
ORDER BY 
    CASE 
        WHEN planName = 'All Users' THEN 0 
        ELSE 1 
    END,
    planName
";
?>
