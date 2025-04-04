<?php
function get_db_connection() {

    require_once 'db_config.php';

    $host = $db_config['servername'];
    $db = $db_config['dbname'];
    $user = $db_config['username'];
    $pass = $db_config['password'];

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        die('Koneksi gagal: ' . $e->getMessage());
    }
}
?>
