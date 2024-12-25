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
include ("../include/billing.request.php");
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
<div class="dropdown-btn active"><i class=" fa fa-credit-card"></i> Billing<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../billing/request.php" class="active"> <i class="fa fa-plus-circle "></i> Topup Request </a>
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
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
	<h3><i class=" fa fa-plus-circle"></i> Topup Request </h3>
</div>
<div class="card-body">
<div class="row">
<div class="row">
<div class="col-12">
</div>
<div class="overflow box-bordered" style="max-height: 70vh">
<table id="dataTable" class="table table-bordered table-hover text-nowrap">
<thead class="thead-light">
<tr>
  <th><center><?php echo "$total_request"; ?></th>
  <th><center>Topup ID</th>
  <th><center>Username</th>
  <th><center>Whatsapp</th>
  <th><center>Amount</th>
  <th><center>Date</th>
  </tr>
</thead>
<tbody>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>
            <i class='fa fa-close text-danger pointer'
                onclick=\"reject('" . htmlspecialchars($row['id']) . "', '" . htmlspecialchars($row['username']) . "', '" . htmlspecialchars($row['whatsapp_number']) . "', '" . htmlspecialchars($row['amount']) . "')\"></i>&nbsp;&nbsp;
            <i class='fa fa-check text-success pointer'
                onclick=\"accept('" . htmlspecialchars($row['id']) . "', '" . htmlspecialchars($row['username']) . "', '" . htmlspecialchars($row['whatsapp_number']) . "', '" . htmlspecialchars($row['amount']) . "')\"></i>
            </center></td>";
        echo "<td><center>" . htmlspecialchars($row["id"]) . "</center></td>";
        echo "<td><center>" . htmlspecialchars($row["username"]) . "</center></td>";
        echo "<td><center>" . htmlspecialchars($row["whatsapp_number"]) . "</center></td>";
        echo "<td><center>" . money($row["amount"]) . "</center></td>";
        echo "<td><center>" . htmlspecialchars($row["date"]) . "</center></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'><center>Tidak ada data</center></td></tr>";
}

$conn->close();
?>

<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/user.topup.js"></script>
</body>
</html>