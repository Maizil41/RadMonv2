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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['action']) && $_POST['action'] === 'delete') {
    
    $id = $_POST['id'];

    $sqlDeleteClient = "DELETE FROM client WHERE id = '$id'";


    mysqli_query($conn, $sqlDeleteClient);

}

exit;
?>