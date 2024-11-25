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
include ("../backend/alluser.php");
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
<a href="../hotspot/user.php" class="active"> &nbsp;&nbsp;&nbsp;<i class="fa fa-list "></i> User List </a>
<a href="../hotspot/adduser.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-user-plus "></i> Add User </a>
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
<div class="col-12">
<div class="card">
<div class="card-header">
<h3><i class="fa fa-users"></i> Users<span style="font-size: 14px">
&nbsp; | &nbsp; <a href="../hotspot/adduser.php" title="Add User"><i class="fa fa-user-plus"></i> Add</a>
&nbsp; | &nbsp; <a href="../hotspot/generate.php" title="Generate User"><i class="fa fa-users"></i> Generate</a>
</span>  &nbsp;
<small id="loader" style="display: none;" ><i><i class='fa fa-circle-o-notch fa-spin'></i> Processing... </i></small>
</h3>
</div>

<div class="card-body">
<div class="row">
<div class="col-6 pd-t-5 pd-b-5">
<div class="input-group">
<div class="input-group-4 col-box-4">
<input id="filterTable" type="text" style="padding:5.8px;" class="group-item group-item-l" placeholder="Search">
</div>
  
<div class="input-group-4 col-box-4">
<select id="userstatus" name="userstatus" class="group-item group-item-m" onchange="location = this.value; loader()">
    <option value="">All User</option>
    <option value="ONLINE" <?php echo ($statusFilter == 'ONLINE' ? 'selected' : ''); ?>>Online</option>
    <option value="OFFLINE" <?php echo ($statusFilter == 'OFFLINE' ? 'selected' : ''); ?>>Offline</option>
    <option value="EXPIRED" <?php echo ($statusFilter == 'EXPIRED' ? 'selected' : ''); ?>>Expired</option>
</select>

</div>
<div class="input-group-4 col-box-4">
    <select style="padding:5px;" class="group-item group-item-m" onchange="location = this.value; loader()" title="Filter by Profile">
        <option value="../hotspot/user.php?status=<?php echo $status; ?>" <?php echo (!isset($_GET['planName']) ? 'selected' : ''); ?>>All Profile</option>
        <?php
        include ("../backend/voucher.php");
        $resultCount = $conn->query($sql);
        $currentPlanName = isset($_GET['planName']) ? $_GET['planName'] : '';
        if ($resultCount->num_rows > 0) {
            while ($row = $resultCount->fetch_assoc()) {
                $planName = $row['planName'];
                if ($planName === "All Users") {
                    continue;
                }
                $selected = ($planName === $currentPlanName) ? 'selected' : '';
                ?>
                <option value="../hotspot/user.php?planName=<?php echo htmlspecialchars($planName); ?>&status=<?php echo $status; ?>" <?php echo $selected; ?>>
                    <?php echo htmlspecialchars($planName); ?>
                </option>
                <?php
            }
        }
        ?>
    </select>
</div>
</div>
</div>
 
<div class="col-6">

</div>
</div>

<div class="overflow mr-t-10 box-bordered" style="max-height: 75vh">
<table id="dataTable" class="table table-bordered table-hover text-nowrap">
<thead>
<tr>
<th class="text-center align-middle"><?php echo "$total_users"; ?></th>
<th class="text-center align-middle">Print</th>
<th class="text-center align-middle pointer" title="Click to sort"><i class="fa fa-sort"></i> Name</th>
<th class="text-center align-middle pointer" title="Click to sort"><i class="fa fa-sort"></i> Voucher</th>
<th class="text-center align-middle pointer" title="Click to sort"><i class="fa fa-sort"></i> Mac Address</th>
<th class="text-center align-middle pointer" title="Click to sort"><i class="fa fa-sort"></i> IP Address</th>
<th class="text-center align-middle pointer" title="Click to sort"><i class="fa fa-sort"></i> Cost</th>
<th class="text-center align-middle pointer" title="Click to sort"><i class="fa fa-sort"></i> Profile</th>
<th class="text-center align-middle pointer" title="Click to sort"><i class="fa fa-sort"></i> Usage</th>
<th class="text-center align-middle pointer" title="Click to sort"><i class="fa fa-sort"></i> Traffic</th>
<th class="text-center align-middle">Status</th>
</tr>
</thead>
<tbody>
<?php include ("../include/hotspot.user.php"); ?>
</div>
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/delete.user.js"></script>
</body>
</html>

