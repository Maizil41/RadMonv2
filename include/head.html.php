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
require '../pages/auth.php';

session_start();

function saveCache($key, $value) {
    $cacheFile = __DIR__ . '/../cache/' . $key . '.cache';
    file_put_contents($cacheFile, $value);
}

function loadCache($key) {
    $cacheFile = __DIR__ . '/../cache/' . $key . '.cache';
    if (file_exists($cacheFile)) {
        return file_get_contents($cacheFile);
    }
    return null;
}

if (!is_dir(__DIR__ . '/../cache')) {
    mkdir(__DIR__ . '/../cache', 0755, true);
}

$theme = isset($_GET['themes']) ? $_GET['themes'] : (loadCache('theme') ?? 'blue');

saveCache('theme', $theme);

$status = isset($_GET['status']) ? $_GET['status'] : '';

?>

<!DOCTYPE html>
<html>
	<head>
		<title>RADMON V2</title>
		<meta charset="utf-8">
		<meta http-equiv="cache-control" content="private" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="../css/font-awesome/css/font-awesome.min.css" />
		<link rel="icon" href="../img/radmon.png" />
		<script src="../js/jquery.min.js"></script>
		<script src="../js/pace.min.js"></script>
        <link href="../css/pace.<?php echo $theme; ?>.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/radmon-ui.<?php echo $theme; ?>.min.css">
	</head>
	<body>
		<div class="wrapper">
		
        <div id="navbar" class="navbar">
          <div class="navbar-left">
            <a id="brand" class="text-center" href="../pages/dashboard.php">RADMON V2</a>
            <a id="openNav" class="navbar-hover" href="javascript:void(0)">
              <i class="fa fa-bars"></i>
            </a>
            <a id="closeNav" class="navbar-hover" href="javascript:void(0)">
              <i class="fa fa-bars"></i>
            </a>
          </div>
          <div class="navbar-right">
            <a id="logout" href="../pages/logout.php">
              <i class="fa fa-sign-out mr-1"></i> Logout </a>
              
            <select class="stheme ses text-right mr-t-10 pd-5" id="themeSelector" onchange="changeTheme(this.value)">
                <option value="" disabled selected>Themes</option>
                <option value="blue">Blue</option>
                <option value="green">Green</option>
                <option value="pink">Pink</option>
                <option value="light">Light</option>
                <option value="dark">Dark</option>
            </select>
        </div>
    </div>
</div>
<script src="../js/themes-change.js"></script>

