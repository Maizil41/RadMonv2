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
include ("../backend/ppp_log.php");
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
<a href="../voucher/voucher.php" class="menu"><i class="fa fa-ticket"></i> Vouchers </a>
<!--log-->
<div class="dropdown-btn active"><i class="fa fa-align-justify"></i> Log<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<a href="../logs/hotspot.php" class="menu"><i class="fa fa-wifi"></i> Hotspot Log </a>
<a href="../logs/pppoe.php" class="active"><i class="fa fa-sitemap"></i> PPPoE Log </a>
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
</div>
<!--report-->
<a href="../hotspot/report.php" class="menu"><i class="nav-icon fa fa-money"></i> Report</a>
<!--settings-->
<div class="dropdown-btn"><i class="fa fa-gear"></i> Settings 
<i class="fa fa-caret-down"></i> &nbsp;
</div>
<div class="dropdown-container">
<a href="../pages/admin.php" class="menu"><i class="fa fa-gear"></i> Admin Settings </a>
<a href="../hotspot/hslogo.php" class="menu"><i class="fa fa-upload"></i> Upload Logo </a>
<a href="../voucher/template.php" class="menu"><i class="fa fa-edit"></i> Template Setting </a>          
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
    <h3><i class=" fa fa-align-justify"></i> PPPoE Log &nbsp; | &nbsp;&nbsp;<i onclick="location.reload();" class="fa fa-refresh pointer " title="Reload data"></i></h3>
</div>
<div class="card-body">

<div style="max-width: 350px;">
    <input id="filterTable" type="text" class="form-control" placeholder="Search.."> 
</div>
<div style="padding: 5px; max-height: 75vh;" class="mr-t-10 overflow">
<table class="table table-sm table-bordered table-hover" id="dataTable" >
	<thead>
        <tr>
            <th class="text-center">Username</th>
            <th class="text-center">Password</th>
            <th class="text-center">Reply</th>
            <th class="text-center">Time</th>
        </tr>
    </thead>
	<tbody>
<?php foreach($user_data as $user) {
$color = ($user['reply'] == 'PPP Login Success') ? '#4DBD74' : 
(($user['reply'] == 'PPP Login Failed') ? '#FF0000' : 'black');
echo "
<tr>
    <td><center>{$user['username']}</center></td>
    <td><center>{$user['password']}</center></td>
    <td style='color: {$color};'><center>{$user['reply']}</center></td>
    <td><center>{$user['authdate']}</center></td>
</tr>
";
} ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>

</div>
</div>
</div>
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script>$(document).ready(function(){makeAllSortable();$("#filterTable").on("keyup",function(){var value=$(this).val().toLowerCase();$("#dataTable tbody tr").filter(function(){$(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)})})});</script>
</body>
</html>

