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
include ("../include/head.html.php");
?>

<div id="sidenav" class="sidenav">
<a href="../pages/dashboard.php" class="menu "><i class="fa fa-dashboard"></i> Dashboard</a>
<!--hotspot-->
<div class="dropdown-btn active"><i class="fa fa-wifi"></i> Hotspot
<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<!--users--> 
<div class="dropdown-btn active"><i class="fa fa-users"></i> Users<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<a href="../hotspot/user.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-list "></i> User List </a>
<a href="../hotspot/adduser.php" class="active"> &nbsp;&nbsp;&nbsp;<i class="fa fa-user-plus "></i> Add User </a>
<a href="../hotspot/generate.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-user-plus"></i> Generate </a>        
</div>
<!--profile-->
<div class="dropdown-btn "><i class=" fa fa-pie-chart"></i> User Profile<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../hotspot/profile.php" class=" "> &nbsp;&nbsp;&nbsp;<i class="fa fa-list "></i> Profile List </a>
<a href="../hotspot/bandwidth.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-hourglass "></i> Bandwidth List </a>
</div>
<!--active-->
<a href="../hotspot/active.php" class="menu"><i class="fa fa-wifi"></i> Hotspot Active</a>
<!--ip bindings-->
<a href="../hotspot/binding.php" class="menu"><i class="fa fa-address-book"></i> MAC Bindings</a>
</div>
<!--quick print-->
<a href="../voucher/quick_print.php" class="menu"> <i class="fa fa-print"></i> Quick Print </a>
<!--vouchers-->
<a href="../voucher/voucher.php" class="menu"> <i class="fa fa-ticket"></i> Vouchers </a>
<!--log-->
<div class="dropdown-btn"><i class="fa fa-align-justify"></i> Log<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<a href="../logs/hotspot.php" class=""> <i class="fa fa-wifi"></i> Hotspot Log </a>
<a href="../logs/radius.php" class=""> <i class="fa fa-database"></i> Radius Log </a>
</div>
<!--system-->
<a href="../pages/server.php" class="menu"> <i class="fa fa-server"></i> Status </a>
<!--billing-->
<div class="dropdown-btn "><i class=" fa fa-credit-card"></i> Billing<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../billing/request.php" class=""> <i class="fa fa-plus-circle "></i> Topup Request </a>
<a href="../billing/user.php" class=""> <i class="fa fa-user "></i> Client List </a>
</div>
<!--report-->
<a href="../hotspot/report.php" class="menu"><i class="nav-icon fa fa-money"></i> Report</a>
<!--settings-->
<div class="dropdown-btn "><i class="fa fa-gear"></i> Settings 
<i class="fa fa-caret-down"></i> &nbsp;
</div>
<div class="dropdown-container ">
<a href="../pages/admin.php" class="menu"> <i class="fa fa-gear"></i> Admin Settings </a>
<a href="../hotspot/hslogo.php" class="menu"> <i class="fa fa-upload"></i> Upload Logo </a>
<a href="../voucher/template.php" class="menu"> <i class="fa fa-edit"></i> Template Setting </a>          
</div>
<!--about-->
<a href="../pages/about.php" class="menu"><i class="fa fa-info-circle"></i> About</a>
</div>

<div id="main">  
<div id="loading" class="lds-dual-ring"></div>
<div class="main-container" style="display:none">
<div class="row">
<div class="col-8">
<div class="card box-bordered">
<div class="card-header">
<h3>
    <i class="fa fa-user-plus"></i> Add User &nbsp; | &nbsp;
    <small id="loader" style="display: none;">
        <i><i class="fa fa-circle-o-notch fa-spin"></i> Processing...</i>
    </small>
    <?php if (isset($_GET['message'])): ?>
        <small id="message">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </small>
    <?php endif; ?>
</h3>
</div>
<div class="card-body">
    <form method="post" role="form" action="../backend/adduser.php" id="addUserForm">
        <div>
            <a class="btn bg-warning" href="../hotspot/user.php">
                <i class="fa fa-close"></i> Close
            </a>
            <button type="submit" name="addUser" value="top" class="btn bg-primary">
                <i class="fa fa-save"></i> Save
            </button>
        </div>

        <table class="table">
            <tr>
                <td class="align-middle">Username</td>
                <td>
                    <input class="form-control" type="text" autocomplete="off" id="usernameTop" name="username" required autofocus>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Client Name</td>
                <td>
                    <input class="form-control" type="text" autocomplete="off" id="clientName" name="clientName" autofocus>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Profile</td>
                <td>
                    <select class="form-control" id="planDropup" name="planName" autocomplete="off">
                        <option value="">Select Plan</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="align-middle">WhatsApp</td>
                <td>
                    <input class="form-control" type="tel" autocomplete="off" id="Whatsapp_number" name="Whatsapp_number" placeholder="">
                </td>
            </tr>
            <tr>
                <td class="align-middle">Telegram</td>
                <td>
                    <input class="form-control" type="text" title="No special characters" id="comment" autocomplete="off" name="comment">
                </td>
            </tr>
        </table>
    </form>
</div>
</div>
</div>
<div class="col-4">
  <div class="card">
    <div class="card-header">
      <h3>
        <i class="fa fa-book"></i> Read Me
      </h3>
    </div>
    <div class="card-body">
      <table>
        <tr>
        <table class="table table-bordered">
          <td colspan="2">
                <ul>
                    <li>Username : Kode Voucher</li>
                    <li>Client Name : Nama pelanggan</li>
                    <li>WhatsApp : Nomor WA Pelanggan (Diawali 62)</li>
                    <li>Telegram : ID Telegram Pelanggan.</li><br>
                </ul>
            <p style="padding:0px 5px;"><b>NOTES:</b>
            Yang wajib diisi hanya Username, sisanya opsional<br>
            Abaikan jika tidak ingin diisi</p>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/add.user.js"></script>
</body>
</html>
