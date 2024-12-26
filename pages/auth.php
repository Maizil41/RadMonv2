<?php
session_name('radmonv2_session');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../pages/login.php");
    exit();
}
?>
