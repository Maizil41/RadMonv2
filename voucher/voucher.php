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
<a href="../hotspot/bandwidth.php" class=""><i class="fa fa-area-chart "></i> Bandwidth </a>
<!--quick print-->
<a href="../voucher/quick_print.php" class="menu"> <i class="fa fa-print"></i> Quick Print </a>
<!--vouchers-->
<a href="../voucher/voucher.php" class="active"> <i class="fa fa-ticket"></i> Vouchers </a>
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
	<h3><i class=" fa fa-users"></i> Vouchers &nbsp;&nbsp; | &nbsp;&nbsp;<i onclick="location.reload();" class="fa fa-refresh pointer" title="Reload data"></i></h3>
</div>
<?php
include ("../backend/voucher.php");

$resultCount = $conn->query($sql);

function generateRandomColor() {
    $colors = [
        'rgba(0, 191, 255, 0.8)',
        'rgba(75, 0, 130, 0.8)',
        'rgba(0, 128, 0, 0.8)',
        'rgba(128, 0, 128, 0.8)',
        'rgba(255, 99, 71, 0.8)',
        'rgba(255, 69, 0, 0.8)',
        'rgba(30, 144, 255, 0.8)',
        'rgba(50, 205, 50, 0.8)',
        'rgba(255, 215, 0, 0.8)',
        'rgba(255, 20, 147, 0.8)',
        'rgba(255, 105, 180, 0.8)',
        'rgba(255, 165, 0, 0.8)',
        'rgba(75, 255, 255, 0.8)',
        'rgba(0, 255, 127, 0.8)',
        'rgba(238, 130, 238, 0.8)',
        'rgba(135, 206, 250, 0.8)',
        'rgba(240, 128, 128, 0.8)',
        'rgba(144, 238, 144, 0.8)',
        'rgba(255, 140, 0, 0.8)',
        'rgba(238, 221, 130, 0.8)',
        'rgba(135, 206, 235, 0.8)',
        'rgba(255, 105, 180, 0.8)',
        'rgba(255, 182, 193, 0.8)',
        'rgba(255, 99, 255, 0.8)',
        'rgba(255, 127, 80, 0.8)',
        'rgba(100, 149, 237, 0.8)',
        'rgba(34, 139, 34, 0.8)',
        'rgba(255, 228, 181, 0.8)',
        'rgba(0, 255, 255, 0.8)',
        'rgba(221, 160, 221, 0.8)',
        'rgba(255, 182, 193, 0.8)',
        'rgba(221, 160, 221, 0.8)',
        'rgba(186, 85, 211, 0.8)'
    ];

    static $usedColors = [];

    $availableColors = array_diff($colors, $usedColors);

    if (empty($availableColors)) {
        $usedColors = []; 
        $availableColors = $colors;
    }

    $randomColor = $availableColors[array_rand($availableColors)];

    $usedColors[] = $randomColor;

    return $randomColor;
}

?>
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

