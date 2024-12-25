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
include ("../include/hotspot.editbw.php");
?>

<div id="sidenav" class="sidenav">
<a href="../pages/dashboard.php" class="menu"><i class="fa fa-dashboard"></i> Dashboard</a>
<!--hotspot-->
<div class="dropdown-btn"><i class="fa fa-wifi"></i> Hotspot
<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../hotspot/user.php" class=""><i class="fa fa-users"></i> Hotspot User</a>
<a href="../hotspot/profile.php" class=""><i class="fa fa-pie-chart"></i> Hotspot Profile</a>
<a href="../hotspot/binding.php" class="menu"><i class="fa fa-address-book"></i> MAC Bindings</a>
<a href="../hotspot/active.php" class=""><i class="fa fa-wifi"></i> Hotspot Active</a>
</div>
<!--bandwidth-->
<a href="../hotspot/bandwidth.php" class="active"><i class="fa fa-area-chart "></i> Bandwidth </a>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <h3>
                        <i class="fa fa-edit"></i> Edit Bandwidth : <?php echo htmlspecialchars($bw['name']); ?> &nbsp; | &nbsp;
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
                        <form method="post" role="form" action="../backend/update_bw.php" id="updatebw">
                            <div>
                                <a class="btn bg-warning" href="../hotspot/bandwidth.php"> <i class="fa fa-close"></i> Close</a>
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($bw_id); ?>">
                                <button type="submit" name="updatebillplans" value="top" class="btn bg-primary"><i class="fa fa-save"></i> Save</button>
                            </div>

                            <table class="table">
                                <tr>
                                    <td>Bandwidth Name</td>
                                    <td><input type="text" class="form-control" id="name" name="name" autocomplete="name" value="<?php echo htmlspecialchars($bw['name']); ?>" required></td>
                                </tr>
                                <tr>
                                    <td>Rate Download</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-8">
                                                <input type="number" class="form-control" id="rate_down" name="rate_down" value="<?php echo htmlspecialchars($rate_down); ?>" required>
                                            </div>
                                            <div class="input-group-4">
                                            <select class="form-control" id="rate_down_unit" name="rate_down_unit">
                                                <option value="Kbps" <?php echo $rate_down_unit == 'Kbps' ? 'selected' : ''; ?>>Kbps</option>
                                                <option value="Mbps" <?php echo $rate_down_unit == 'Mbps' ? 'selected' : ''; ?>>Mbps</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td>Rate Upload</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-8">
                                                <input type="number" class="form-control" id="rate_up" name="rate_up" value="<?php echo htmlspecialchars($rate_up); ?>" required>
                                            </div>
                                            <div class="input-group-4">
                                            <select class="form-control" id="rate_up_unit" name="rate_up_unit">
                                                <option value="Kbps" <?php echo $rate_up_unit == 'Kbps' ? 'selected' : ''; ?>>Kbps</option>
                                                <option value="Mbps" <?php echo $rate_up_unit == 'Mbps' ? 'selected' : ''; ?>>Mbps</option>
                                            </select>
                                        </td>
                                    </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/update.bw.js"></script>

</body>
</html>
