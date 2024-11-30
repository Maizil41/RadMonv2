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
<div class="dropdown-container ">
<a href="../hotspot/user.php" class=""><i class="fa fa-users"></i> Hotspot User</a>
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
                <span>System date & time<br>
                  <span id="date"></span> <span id="time"></span><br>
                  Uptime: <span id="uptime"><?php echo $uptime; ?></span>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="box bmh-75 box-bordered">
            <div class="box-group">
              <div class="box-group-icon"><i class="fa fa-info-circle"></i></div>
              <div class="box-group-area">
                <span>
                  Board Name: <?php echo "$board"; ?><br/>
                  Model: <?php echo "$model"; ?><br/>
                  Router OS: <?php echo "$id $version"; ?>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="box bmh-75 box-bordered">
            <div class="box-group">
              <div class="box-group-icon"><i class="fa fa-server"></i></div>
              <div class="box-group-area">
                <span>
                  CPU Load: <span id="cpu-load"><?php echo $cpuValue; ?>%</span> Temp: <?php echo "$temp"; ?><br/>
                  Free Memory: <?php echo $freeMemory; ?><br/>
                  Free HDD: <?php echo "$freehdd"; ?><br/>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Hotspot Section -->
      <div id="r_2" class="row">
        <div class="card">
          <div class="card-header">
            <h3><i class="fa fa-wifi"></i> Hotspot</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- Hotspot Active -->
              <div class="col-3 col-box-6">
                <div class="box bg-blue bmh-75">
                  <a href="../hotspot/active.php">
                    <h1>
                      <span id="hsonline"><?php echo "$totalOnline"; ?></span> 
                      <span style="font-size: 15px;">items</span>
                    </h1>
                    <div><i class="fa fa-laptop"></i> Hotspot Active</div>
                  </a>
                </div>
              </div>
              <!-- Hotspot User -->
              <div class="col-3 col-box-6">
                <div class="box bg-green bmh-75">
                  <a href="../hotspot/user.php">
                    <h1>
                      <span id="hstotal"><?php echo "$totalUser"; ?></span> 
                      <span style="font-size: 15px;">items</span>
                    </h1>
                    <div><i class="fa fa-users"></i> Hotspot User</div>
                  </a>
                </div>
              </div>
              <!-- Today Income -->
              <div class="col-3 col-box-6">
                <div class="box bg-yellow bmh-75">
                  <h1>
                    Rp <span style="font-size: 22px;" id="incometoday"><?php echo number_format($totalPendapatanHariIni, 0, ',', '.'); ?></span>
                  </h1>
                  <div><i class="fa fa-money"></i> Today Income</div>
                </div>
              </div>
              <!-- Monthly Income -->
              <div class="col-3 col-box-6">
                <div class="box bg-red bmh-75">
                  <h1>
                    Rp <span style="font-size: 22px;" id="incomemonth"><?php echo number_format($totalPendapatan_bulanIni, 0, ',', '.'); ?></span>
                  </h1>
                  <div><i class="fa fa-money"></i> Monthly Income</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- PPPoE Section -->
      <div id="r_2" class="row">
        <div class="card">
          <div class="card-header">
            <h3><i class="fa fa-sitemap"></i> PPPoE</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- PPPoE Active -->
              <div class="col-3 col-box-6">
                <div class="box bg-blue bmh-75">
                  <a href="../pppoe/active.php">
                    <h1>
                      <span id="ppponline"><?php echo "$pppOnline"; ?></span>
                      <span style="font-size: 15px;">items</span>
                    </h1>
                    <div><i class="fa fa-plug"></i> PPPoE Active</div>
                  </a>
                </div>
              </div>
              <!-- PPPoE User -->
              <div class="col-3 col-box-6">
                <div class="box bg-green bmh-75">
                  <a href="../pppoe/account.php">
                    <h1>
                      <span id="ppptotal"><?php echo "$pppTotal"; ?></span>
                      <span style="font-size: 15px;">items</span>
                    </h1>
                    <div><i class="fa fa-users"></i> PPPoE User</div>
                  </a>
                </div>
              </div>
              <!-- Yearly Income -->
              <div class="col-3 col-box-6">
                <div class="box bg-yellow bmh-75">
                  <h1>
                    Rp <span style="font-size: 22px;" id="incomeyear"><?php echo number_format($totalPendapatan_tahunIni, 0, ',', '.'); ?></span>
                  </h1>
                  <div><i class="fa fa-money"></i> Yearly Income</div>
                </div>
              </div>
              <!-- Total Income -->
              <div class="col-3 col-box-6">
                <div class="box bg-red bmh-75">
                  <h1>
                    Rp <span style="font-size: 22px;" id="incometotal"><?php echo number_format($totalPendapatan_total, 0, ',', '.'); ?></span>
                  </h1>
                  <div><i class="fa fa-money"></i> Total Income</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Traffic Section -->
      <div class="row">
        <div class="col-8">
          <div class="card">
            <div class="card-header">
              <h3><i class="fa fa-area-chart"></i> Traffic</h3>
            </div>
            <div class="card-body">
              <canvas id="trafficMonitor" width="600" height="240"></canvas>
            </div>
          </div>
        </div>
        <!-- Login Log -->
        <div class="col-4">
          <div class="card">
            <div class="card-header">
              <h3><i class="fa fa-align-justify"></i> Login Log</h3>
            </div>
            <div class="card-body">
              <div style="padding: 5px; height: 287px;" class="mr-t-10 overflow">
                <table class="table table-sm table-bordered table-hover" id="loginlog" style="font-size: 12px;">
                  <thead>
                    <tr>
                      <th><center>Users</center></th>
                      <th><center>Reply</center></th>
                      <th><center>Time</center></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($user_data as $user) { ?>
                    <tr>
                      <td><center><?php echo htmlspecialchars($user['username']); ?></center></td>
                      <td style="color: 
                        <?php echo ($user['reply']=='log in by voucher'||$user['reply']=='log in by mac'||$user['reply']=='PPP Login Success') ? 'green' : (($user['reply']=='login failed, invalid voucher'||$user['reply']=='login failed, invalid mac'||$user['reply']=='PPP Login Failed') ? 'red' : 'black'); ?>;">
                        <center><?php echo htmlspecialchars($user['reply']); ?></center>
                      </td>
                      <td><center><?php echo htmlspecialchars($user['authdate']); ?></center></td>
                    </tr>
                    <?php } ?>
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
<script src="../plugins/chart.min.js"></script>
<script src="../plugins/chart.date.js"></script>
<script src="../plugins/chart.iface.js" defer></script>
<script src="../plugins/dash.load.js" defer></script>
</body>
</html>
