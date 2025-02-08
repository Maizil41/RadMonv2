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
include ("../backend/voucher.php");
?>

<div id="sidenav" class="sidenav">
<a href="../pages/dashboard.php" class="menu"><i class="fa fa-dashboard"></i> Dashboard</a>
<!--hotspot-->
<div class="dropdown-btn"><i class="fa fa-wifi"></i> Hotspot
<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<a href="../hotspot/user.php" class="menu"><i class="fa fa-users"></i> Hotspot User</a>
<a href="../hotspot/profile.php" class="menu"><i class="fa fa-pie-chart"></i> Hotspot Profile</a>
<a href="../hotspot/binding.php" class="menu"><i class="fa fa-address-book"></i> MAC Bindings</a>
<a href="../hotspot/active.php" class="menu"><i class="fa fa-wifi"></i> Hotspot Active</a>
</div>
<!--pppoe-->
<div class="dropdown-btn"><i class="fa fa-sitemap"></i> PPPoE
<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<a href="../pppoe/account.php" class="menu"><i class="fa fa-users"></i> PPPoE User</a>
<a href="../pppoe/profile.php" class="menu"><i class="fa fa-pie-chart"></i> PPPoE Profile</a>
<a href="../pppoe/active.php" class="menu"><i class="fa fa-plug"></i> PPPoE Active</a>
</div>
<!--bandwidth-->
<a href="../hotspot/bandwidth.php" class="menu"><i class="fa fa-area-chart "></i> Bandwidth </a>
<!--quick print-->
<a href="../voucher/quick_print.php" class="menu"><i class="fa fa-print"></i> Quick Print </a>
<!--vouchers-->
<a href="../voucher/voucher.php" class="active"><i class="fa fa-ticket"></i> Vouchers </a>
<!--log-->
<div class="dropdown-btn"><i class="fa fa-align-justify"></i> Log<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<a href="../logs/hotspot.php" class="menu"><i class="fa fa-wifi"></i> Hotspot Log </a>
<a href="../logs/pppoe.php" class="menu"><i class="fa fa-sitemap"></i> PPPoE Log </a>
<a href="../logs/applog.php" class="menu"><i class="fa fa-exclamation-circle"></i> App Log </a>
<a href="../logs/radius.php" class="menu"><i class="fa fa-database"></i> Radius Log </a>
</div>
<!--system-->
<a href="../pages/server.php" class="menu"><i class="fa fa-server"></i> Status </a>
<!--billing-->
<div class="dropdown-btn"><i class="fa fa-credit-card"></i> Billing<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../billing/request.php" class="menu"><i class="fa fa-plus-circle "></i> Topup Request </a>
<a href="../billing/user.php" class="menu"><i class="fa fa-user "></i> Client List </a>
<a href="../billing/product.php" class=""><i class="fa fa-shopping-cart"></i> Product List </a>
</div>
<!--report-->
<a href="../hotspot/report.php" class="menu"><i class="nav-icon fa fa-money"></i> Report</a>
<!--settings-->
<div class="dropdown-btn"><i class="fa fa-gear"></i> Settings 
<i class="fa fa-caret-down"></i> &nbsp;
</div>
<div class="dropdown-container">
<a href="../pages/admin.php" class="menu"><i class="fa fa-gear"></i> Admin Settings </a>
<a href="../pppoe/settings.php" class="menu"><i class="fa fa-wrench"></i> PPPoE Settings </a>
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
	<h3><i class=" fa fa-ticket"></i> Vouchers &nbsp;&nbsp; | &nbsp;&nbsp;<i onclick="location.reload();" class="fa fa-refresh pointer" title="Reload data"></i></h3>
</div>

<div class="card-body">
    <div class="overflow" style="max-height: 80vh">
        <div class="row">
            <?php
            if ($resultCount->num_rows > 0) {
                while ($row = $resultCount->fetch_assoc()) {
                    $planName = $row['planName'];
                    $totalUser = $row['username_count'];
                    $randomColor = generateRandomColor();
                    ?>
                    <div class="col-4">
                        <div class="box bmh-75 box-bordered" style="background-color: <?php echo $randomColor; ?>; color: white;">
                            <div class="box-group">
                                <div class="box-group-icon">
                                    <?php if ($planName === 'All Users'): ?>
                                        <i class="fa fa-users"></i>
                                    <?php else: ?>
                                        <a title="Open User by profile <?php echo htmlspecialchars($planName); ?>" href="../hotspot/user.php?planName=<?php echo urlencode($planName); ?>">
                                            <i class="fa fa-ticket"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="box-group-area">
                                    <h3>
                                        <?php echo $planName; ?><br>
                                        <?php echo $totalUser; ?> Items
                                    </h3>
                                    <?php if ($planName === 'All Users'): ?>
                                        <a title="Open All Users" href="../hotspot/user.php">
                                            <i class="fa fa-external-link"></i> Open
                                        </a>
                                    <?php else: ?>
                                        <a title="Open User by profile <?php echo htmlspecialchars($planName); ?>" href="../hotspot/user.php?planName=<?php echo urlencode($planName); ?>">
                                            <i class="fa fa-external-link"></i> Open
                                        </a>&nbsp;
                                        <a title="Generate User by profile <?php echo htmlspecialchars($planName); ?>" href="../hotspot/generate.php?planName=<?php echo urlencode($planName); ?>">
                                            <i class="fa fa-users"></i> Generate
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='col-12'>Tidak ada data.</div>";
            }
            ?>
        </div>
    </div>
</div>
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
</body>
</html>

