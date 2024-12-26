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
include ("../backend/bill.profile.php");
?>

<div id="sidenav" class="sidenav">
<a href="../pages/dashboard.php" class="menu"><i class="fa fa-dashboard"></i> Dashboard</a>
<!--hotspot-->
<div class="dropdown-btn active"><i class="fa fa-wifi"></i> Hotspot
<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../hotspot/user.php" class="active"><i class="fa fa-users"></i> Hotspot User</a>
<a href="../hotspot/profile.php" class=""><i class="fa fa-pie-chart"></i> Hotspot Profile</a>
<a href="../hotspot/binding.php" class="menu"><i class="fa fa-address-book"></i> MAC Bindings</a>
<a href="../hotspot/active.php" class=""><i class="fa fa-wifi"></i> Hotspot Active</a>
</div>
<!--pppoe-->
<div class="dropdown-btn"><i class="fa fa-sitemap"></i> PPPoE
<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../pppoe/account.php" class=""><i class="fa fa-users"></i> PPPoE User</a>
<a href="../pppoe/profile.php" class=""><i class="fa fa-pie-chart"></i> PPPoE Profile</a>
<a href="../pppoe/active.php" class=""><i class="fa fa-plug"></i> PPPoE Active</a>
</div>
<!--bandwidth-->
<a href="../hotspot/bandwidth.php" class=""><i class="fa fa-area-chart "></i> Bandwidth </a>
<!--quick print-->
<a href="../voucher/quick_print.php" class="menu"> <i class="fa fa-print"></i> Quick Print </a>
<!--vouchers-->
<a href="../voucher/voucher.php" class="menu"> <i class="fa fa-ticket"></i> Vouchers </a>
<!--log-->
<div class="dropdown-btn"><i class="fa fa-align-justify"></i> Log<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<a href="../logs/hotspot.php" class=""> <i class="fa fa-wifi"></i> Hotspot Log </a>
<a href="../logs/pppoe.php" class=""> <i class="fa fa-sitemap"></i> PPPoE Log </a>
<a href="../logs/applog.php" class="menu"><i class="fa fa-exclamation-circle"></i> App Log </a>
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
<div class="dropdown-container">
<a href="../pages/admin.php" class="menu"><i class="fa fa-gear"></i> Admin Settings </a>
<a href="../hotspot/hslogo.php" class="menu"><i class="fa fa-upload"></i> Upload Logo </a>
<a href="../voucher/template.php" class="menu"><i class="fa fa-edit"></i> Template Setting </a>          
<a href="../pages/backup.php" class="menu"><i class="fa fa-folder-open"></i> Backup & Restore </a>          
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
    <i class="fa fa-user-plus"></i> Generate User &nbsp; | &nbsp;
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
    <form method="post" role="form" action="../backend/generate.php" id="addUserForm">
        <div>
            <a class="btn bg-warning" href="../hotspot/user.php">
                <i class="fa fa-close"></i> Close
            </a>
            <button type="submit" name="addBatch" value="top" class="btn bg-primary" title="Generate User">
                <i class="fa fa-save"></i> Generate
            </button>
        </div>

        <table class="table">
            <tr>
                <td class="align-middle">Qty</td>
                <td>
                    <div>
                        <input class="form-control" type="number" id="userCount" name="userCount" min="1" max="250" value="1" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Length Code</td>
                <td>
                    <input type="number" id="stringLength" class="form-control" name="stringLength" value="6" min="1" max="12" required>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Prefix</td>
                <td>
                    <input class="form-control" type="text" maxlength="3" id="prefix" name="prefix">
                </td>
            </tr>
            <tr>
                <td class="align-middle">Character</td>
                <td>
                    <select class="form-control" id="stringType" name="stringType" required>
                        <option value="num">Random 1234</option>
                        <option value="lower">Random abcd</option>
                        <option value="upper">Random ABCD</option>
                        <option value="lowernum">Random abcd123</option>
                        <option value="uppernum">Random ABCD123</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Profile</td>
                <td>
                    <select name="planName" class="form-control" required>
                        <option value="">Select Profile</option>
                        <?php foreach ($plans as $plan): ?>
                            <option value="<?php echo $plan; ?>" <?php echo $plan == $selectedPlan ? 'selected' : ''; ?>>
                                <?php echo $plan; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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
        <i class="fa fa-book"></i> Readme
      </h3>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <td colspan="2">
            Qty = Jumlah Voucher<br>
            Length Code = Panjang kode<br>
            Character = Tipe kode voucher<br><br>
            <b>NB :</b> Prefix adalah kode awalan tiap voucher,<br>
            Misalnya RAD, semua voucher akan diawali dengan RAD <br>
            lalu diikuti kode random, boleh dikosongkan
          </td>
      </table>
    </div>
  </div>
</div>
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/add.batch.js"></script>
</body>
</html>