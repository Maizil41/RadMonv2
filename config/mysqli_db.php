<?php
require_once 'db_config.php';

$conn = new mysqli($db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname']);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
