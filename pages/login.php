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
            <div style="position: relative; width: 100%; display: inline-block;">
              <input style="width: 100%; height: 35px; font-size: 16px;" 
                     class="form-control" 
                     type="username" 
                     name="username" 
                     id="username" 
                     placeholder="Username" 
                     required="1">
              <button type="button" 
                      style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none;">
                <i class="fa fa-user"></i>
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td class="align-middle text-center">
            <div style="position: relative; width: 100%; display: inline-block;">
              <input style="width: 100%; height: 35px; font-size: 16px;" 
                     class="form-control" 
                     type="password" 
                     name="password" 
                     id="password" 
                     placeholder="Password" 
                     required="1">
              <button type="button" 
                      onclick="togglePassword()" 
                      style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                <i id="toggleIcon" class="fa fa-lock"></i>
              </button>
            </div>
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
<script>
function togglePassword() {
  const passwordField = document.getElementById('password');
  const toggleIcon = document.getElementById('toggleIcon');
  
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    toggleIcon.classList.remove('fa-lock');
    toggleIcon.classList.add('fa-unlock');
  } else {
    passwordField.type = 'password';
    toggleIcon.classList.remove('fa-unlock');
    toggleIcon.classList.add('fa-lock');
  }
}
</script>
</body>
</html>
