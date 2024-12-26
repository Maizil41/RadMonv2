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
include ("../backend/ipinfo.php");
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
<div class="dropdown-btn"><i class="fa fa-align-justify"></i> Log<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<a href="../logs/hotspot.php" class="menu"><i class="fa fa-wifi"></i> Hotspot Log </a>
<a href="../logs/pppoe.php" class="menu"><i class="fa fa-sitemap"></i> PPPoE Log </a>
<a href="../logs/applog.php" class="menu"><i class="fa fa-exclamation-circle"></i> App Log </a>
<a href="../logs/radius.php" class="menu"><i class="fa fa-database"></i> Radius Log </a>
</div>
<!--system-->
<a href="../pages/server.php" class="active"><i class="fa fa-server"></i> Status </a>
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
<a href="../pages/backup.php" class="menu"><i class="fa fa-folder-open"></i> Backup & Restore </a>          
</div>>
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
              <div class="box-group-icon">
                <i class="fa fa-calendar"></i>
              </div>
              <div class="box-group-area">
                <span>System date & time <br>
                  <span id="date"></span>
                  <span id="time"></span>
                  <br> Uptime: <span id="uptime"> <?php echo $uptime; ?> </span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="box bmh-75 box-bordered">
            <div class="box-group">
              <div class="box-group-icon">
                <i class="fa fa-info-circle"></i>
              </div>
              <div class="box-group-area">
                <span> Hostname : <?php echo "$host"; ?> <br /> Model : <?php echo "$model"; ?> <br /> Router OS : <?php echo "$distrib $version"; ?> </span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="box bmh-75 box-bordered">
            <div class="box-group">
              <div class="box-group-icon">
                <i class="fa fa-server"></i>
              </div>
              <div class="box-group-area">
                <span> CPU Load : <span id="cpu-"> <?php echo $cpuValue; ?>% </span> Temp : <?php echo "$temp"; ?> <br /> Free Memory : <?php echo $freeMemory; ?><br/> Free HDD : <?php echo "$freehdd"; ?> <br />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="box bmh-75 box-bordered">
          <div class="box-group">
            <div class="box-group-icon">
              <i class="fa fa-globe"></i>
            </div>
            <div class="box-group-area">
              <span> IP : <?php echo $ip; ?> <br> ISP : <?php echo $organization; ?> <br> Country : <?php echo $country; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="box bmh-75 box-bordered">
          <div class="box-group">
            <div class="box-group-icon">
              <i class="fa fa-chrome"></i>
            </div>
            <div class="box-group-area">
              <div id="result">Check Ping...</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="box bmh-75 box-bordered">
          <div class="box-group">
            <div class="box-group-icon">
              <i class="fa fa-sitemap"></i>
            </div>
            <div class="box-group-area">
                <span> 
                <?php
                echo printLan();
                echo printWan1();
                echo printWan2();
                ?>
                </span>
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
                  <i class="fa fa-plug"></i> Service Status
                </h3>
              </div>
              <div class="card-body">
                <div class="row"> <?php foreach ($services as $displayName => $serviceName): ?> 
                <?php 
                $isRunning = check_service_status($serviceName);
                $bgClass = $isRunning ? "bg-green" : "bg-red";
                $iconClass = $isRunning ? "fa-plug" : "fa-power-off";
                $statusText = $isRunning ? "Running" : "Not Running";
                ?>
                <div class="col-3 col-box-6">
                <div class="box 
                    <?= $bgClass ?> bmh-75">
                      <h1> <?= $displayName ?> </h1>
                      <div>
                        <i class="fa 
						<?= $iconClass ?>">
                        </i> <?= $statusText ?>
                      </div>
                    </div>
                  </div> <?php endforeach; ?> </div>
              </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/dash.load.js" defer></script>
<script src="../plugins/check.ping.js"></script>
</body>
</html>
