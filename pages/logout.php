<?php
session_name('radmonv2_session');
session_start();
session_destroy();
header("Location: ./login.php");
exit();
?>
