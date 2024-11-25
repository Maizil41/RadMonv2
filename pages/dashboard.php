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
include ("../backend/data.php");
include ("../backend/income.php");
include ("../backend/auth_log.php");
?>

<div id="sidenav" class="sidenav">
<a href="../pages/dashboard.php" class="menu active"><i class="fa fa-dashboard"></i> Dashboard</a>
<!--hotspot-->
<div class="dropdown-btn"><i class="fa fa-wifi"></i> Hotspot
<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<!--users--> 
<div class="dropdown-btn"><i class="fa fa-users"></i> Users<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<a href="../hotspot/user.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-list "></i> User List </a>
<a href="../hotspot/adduser.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-user-plus "></i> Add User </a>
<a href="../hotspot/generate.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-user-plus"></i> Generate </a>        
</div>
<!--profile-->
<div class="dropdown-btn "><i class=" fa fa-pie-chart"></i> User Profile<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../hotspot/profile.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-list "></i> Profile List </a>
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
    
<div id="reloadHome">
    <div id="r_1" class="row">
      <div class="col-4">
        <div class="box bmh-75 box-bordered">
          <div class="box-group">
            <div class="box-group-icon"><i class="fa fa-calendar"></i></div>
              <div class="box-group-area">
                <span >System date & time<br>
                  <span id="date"></span> <span id="time"></span><br>
                   Uptime: <span id="uptime"><?php echo $uptime; ?></span>
              </div>
            </div>
          </div>
        </div>
      <div class="col-4">
        <div class="box bmh-75 box-bordered">
          <div class="box-group">
            <div class="box-group-icon"><i class="fa fa-info-circle"></i></div>
              <div class="box-group-area">
                <span >
                    Board Name : <?php echo "$board"; ?><br/>
                    Model : <?php echo "$model"; ?><br/>
                    Router OS : <?php echo "$id $version"; ?></span>
              </div>
            </div>
        </div>
    </div>
    <div class="col-4">
      <div class="box bmh-75 box-bordered">
        <div class="box-group">
          <div class="box-group-icon"><i class="fa fa-server"></i></div>
              <div class="box-group-area">
                <span >
                    CPU Load : <span id="cpu-load"><?php echo $cpuValue; ?>%</span> Temp : <?php echo "$temp"; ?><br/>
                    Free Memory : <?php echo $freeMemory; ?><br/>
                    Free HDD : <?php echo "$freehdd"; ?><br/>
                </div>
              </div>
            </div>
          </div> 
        </div>
        <div class="row">
          <div class="col-12">
            <div id="r_2" class="row">
              <div class="card">
                <div class="card-header">
                  <h3>
                    <i class="fa fa-wifi"></i> Hotspot
                  </h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-3 col-box-6">
                      <div class="box bg-blue bmh-75">
                        <a href="../hotspot/active.php">
                          <h1><span id="dataonline"><?php echo "$totalOnline"; ?></span> <span style="font-size: 15px;">item</span>
                          </h1>
                          <div>
                            <i class="fa fa-laptop"></i> Hotspot Active
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class="col-3 col-box-6">
                      <div class="box bg-green bmh-75">
                        <a href="../hotspot/user.php">
                          <h1><span id="datatotal"><?php echo "$totalUser"; ?></span> <span style="font-size: 15px;">items</span>
                          </h1>
                          <div>
                            <i class="fa fa-users"></i> Hotspot User
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class="col-3 col-box-6">
                      <div class="box bg-yellow bmh-75">
                          <div>
                              <h1>Rp <span style="font-size: 22px;" id="datatoday"><?php echo number_format($totalPendapatanHariIni, 0, ',', '.'); ?></span>
                            </h1>
                          </div>
                          <div>
                            <i class="fa fa-money"></i> Today Income
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class="col-3 col-box-6">
                      <div class="box bg-red bmh-75">
                          <div>
                            <h1>
                              <h1>Rp <span style="font-size: 22px;" id="datamonth"><?php echo number_format($totalPendapatan_bulanIni, 0, ',', '.'); ?></span>
                            </h1>
                          </div>
                          <div>
                            <i class="fa fa-money"></i> Monthly Income
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <!-- Traffic -->
              <div class="col-8">
                <div class="card">
                  <div class="card-header">
                    <h3>
                      <i class="fa fa-area-chart"></i> Traffic
                    </h3>
                  </div>
                  <div class="card-body">
                   <canvas id="trafficMonitor" width="600" height="240"></canvas>
                  </div>
                </div>
              </div>
              <!-- Hotspot Log -->
              <div class="col-4">
                <div class="box bmh-75 box-bordered" style='display:none;'>
                  <div class="box-group">
                    <div class="box-group-icon">
                      <i class="fa fa-money"></i>
                    </div>
                    <div class="box-group-area">
                      <div id="reloadLreport">
                        <div id="loader">
                          <i>
                            <span>
                              <i class="fa fa-circle-o-notch fa-spin"></i> Processing... </span>
                          </i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h3>
                        <i class="fa fa-align-justify"></i> Hotspot Log </a>
                        </h3>
                    </div>
                  <div class="card-body">
                <div style="padding: 5px; height: 287px;" class="mr-t-10 overflow">
            <table class="table table-sm table-bordered table-hover" id="userlog" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th><center>Users</center></th>
                        <th><center>Reply</center></th>
                        <th><center>Time</center></th>
                    </tr>
                </thead>
            <tbody>
                <?php foreach($user_data as $user){echo"  <tr>
                    <td><center>{$user['username']}</center></td>
                        <td style='color: ".($user['reply']=='log in by voucher' || $user['reply'] == 'log in by mac' ? 'green':($user['reply'] == 'login failed, invalid voucher' || $user['reply'] == 'login failed, invalid mac' ? 'red':'black')).";'><center>{$user['reply']}</center></td>
                            <td><center>{$user['authdate']}</center></td>
                            </tr>";} ?>
                        </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/chart.min.js"></script>
<script src="../plugins/chart.date.js"></script>
<script src="../plugins/chart.iface.js" defer></script>
<script src="../plugins/dash.load.js" defer></script>
</body>
</html>
