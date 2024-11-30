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
include ("../backend/login.php");

function loadCache($key) {
    $cacheFile = __DIR__ . '/../cache/' . $key . '.cache';
    if (file_exists($cacheFile)) {
        return file_get_contents($cacheFile);
    }
    return null;
}

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$userIP = getUserIP();

$theme = isset($_GET['themes']) ? $_GET['themes'] : (loadCache('theme') ?? 'blue');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>RadMonv2 </title>
		<meta charset="utf-8">
		<meta http-equiv="cache-control" content="private" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
<div style="padding-top: 5%;"  class="login-box">
  <div class="card">
    <div class="card-header">
      <h3>Please Login</h3>
    </div>
    <div class="card-body">
      <div class="text-center pd-5">
        <img src="../img/radmon.png" alt="RadMonv2 Logo">
      </div>
      <div  class="text-center">
      <span style="font-size: 25px; margin: 10px;">RADMON V2</span>
      </div>
      <center>
      <form autocomplete="off" action="../pages/login.php" method="post">
      <input type="hidden" name="ipaddress" id="ipaddress" value="<?php echo $userIP ?>">
      <table class="table" style="width:90%">
        <tr>
          <td class="align-middle text-center">
            <input style="width: 100%; height: 35px; font-size: 16px;" class="form-control" type="text" name="username" id="username" placeholder="Username" required="1" autofocus>
          </td>
        </tr>
        <tr>
          <td class="align-middle text-center">
            <input style="width: 100%; height: 35px; font-size: 16px;" class="form-control" type="password" name="password" id="password" placeholder="Password" required="1">
          </td>
        </tr>
        <tr>
          <td class="align-middle text-center">
            <input style="width: 100%; margin-top:20px; height: 35px; font-weight: bold; font-size: 17px;" class="btn-login bg-primary pointer" type="submit" name="login" value="Login">
          </td>
        </tr>
        <tr>
          <td class="align-middle text-center">
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<div style="width: 100%; padding:5px 0px 5px 0px; border-radius:5px;" class="bg-danger"><i class="fa fa-ban"></i> Alert!<br>' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            </td>
        </tr>
      </table>
      </form>
      </center>
    </div>
  </div>
</div>
</body>
</html>

