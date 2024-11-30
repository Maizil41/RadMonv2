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
include ("../backend/pppuser.php");
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
<a href="../hotspot/active.php" class=""><i class="fa fa-wifi"></i> Hotspot Active</a>
</div>

<!--pppoe-->
<div class="dropdown-btn active"><i class="fa fa-sitemap"></i> PPPoE
<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../pppoe/account.php" class="active"><i class="fa fa-users"></i> PPPoE User</a>
<a href="../pppoe/profile.php" class=""><i class="fa fa-pie-chart"></i> PPPoE Profile</a>
<a href="../pppoe/active.php" class=""><i class="fa fa-plug"></i> PPPoE Active</a>
</div>

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
<h3><i class="fa fa-users"></i> PPPoE Users<span style="font-size: 14px">
&nbsp; | &nbsp; <a href="../pppoe/add_account.php" title="Add User"><i class="fa fa-user-plus"></i> Add</a>
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
</div>
</div>
 
<div class="col-6">
</div>
</div>
<?php
echo "
<div class='overflow mr-t-10 box-bordered' style='max-height: 75vh'>
    <table id='dataTable' class='table table-bordered table-hover text-nowrap'>
    <thead>
    <tr>
    <th class='text-center align-middle'>$total_ppp items</th>
    <th class='text-center align-middle pointer' title='Click to sort'><i class='fa fa-sort'></i> Client</th>
    <th class='text-center align-middle pointer' title='Click to sort'><i class='fa fa-sort'></i> Username</th>
    <th class='text-center align-middle pointer' title='Click to sort'><i class='fa fa-sort'></i> Password</th>
    <th class='text-center align-middle pointer' title='Click to sort'><i class='fa fa-sort'></i> IP Address</th>
    <th class='text-center align-middle pointer' title='Click to sort'><i class='fa fa-sort'></i> Mac Address</th>
    <th class='text-center align-middle pointer' title='Click to sort'><i class='fa fa-sort'></i> Profile</th>
    <th class='text-center align-middle pointer' title='Click to sort'><i class='fa fa-sort'></i> Cost</th>
    <th class='text-center align-middle pointer' title='Click to sort'><i class='fa fa-sort'></i> Usage</th>
    <th class='text-center align-middle pointer' title='Click to sort'><i class='fa fa-sort'></i> Traffic</th>
    <th class='text-center align-middle'>Status</th>
    </tr>
    </thead>
    <tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clientName =  htmlspecialchars($row['contactperson']);
        $username = htmlspecialchars($row['username']);
        $password = htmlspecialchars($row['Password']);
        $ipAddress = htmlspecialchars($row['Framed_IP_Address']);
        $macAddress = htmlspecialchars($row['callingstationid']);
        $profile = htmlspecialchars($row['groupname']);
        $cost = htmlspecialchars(money($row['planCost']));
        $usage = htmlspecialchars(time2str($row['total_acctsessiontime']));
        $traffic = htmlspecialchars(toxbyte($row['total_acctinputoctets'] + $row['total_acctoutputoctets']));
        $status = htmlspecialchars($row['status']);

        $statusClass = '';
        switch (true) {
            case strpos($status, 'ONLINE') !== false:
                $statusClass = 'fa fa-check-circle text-success';
                $title = 'Online';
                break;
            case strpos($status, 'EXPIRED') !== false:
                $statusClass = 'fa fa-ban text-danger';
                $title = 'Expired';
                break;
            case strpos($status, 'OFFLINE') !== false:
                $statusClass = 'fa fa-times-circle text-secondary';
                $title = 'Offline';
                break;
        }

        echo "<tr>
                <td><center>
                <span class='fa fa-trash text-danger pointer' onclick=\"deleteUser('" . htmlspecialchars($username) . "')\"></span>&nbsp;&nbsp;
                <span class='fa fa-refresh text-warning pointer' onclick=\"resetuser('" . htmlspecialchars($username) . "')\"></span>
                </td>
                <td><center>$clientName</td>
                <td><center>$username</td>
                <td><center>$password</td>
                <td><center>$ipAddress</td>
                <td><center>$macAddress</td>
                <td><center>$profile</td>
                <td><center>$cost</td>
                <td><center>$usage</td>
                <td><center>$traffic</td>
                <td><center><span class='$statusClass' title='$title'> $title</span></td>
              </tr>";
    }

} else {
    echo "<tr><td colspan='11'><center>Tidak ada data</center></td></tr>";
}

echo "</tbody></table></div>";

$conn->close();
?>
</div>
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/delete.ppp.js"></script>
</body>
</html>

