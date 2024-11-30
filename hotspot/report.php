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
include ("../backend/report.php");
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
<a href="../pages/server.php" class="menu"><i class="fa fa-server"></i> Status </a>
<!--billing-->
<div class="dropdown-btn"><i class="fa fa-credit-card"></i> Billing<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../billing/request.php" class="menu"><i class="fa fa-plus-circle "></i> Topup Request </a>
<a href="../billing/user.php" class="menu"><i class="fa fa-user "></i> Client List </a>
</div>
<!--report-->
<a href="../hotspot/report.php" class="active"><i class="nav-icon fa fa-money"></i> Report</a>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        <i class="fa fa-money"></i> Selling Report 
                        <small id="loader" style="display: none;">
                            <i><i class="fa fa-circle-o-notch fa-spin"></i> Processing...</i>
                        </small>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Filter Inputs -->
                        <div class="input-group mr-b-10">
                            <!-- Day Selector -->
                            <div class="input-group-1 col-box-2">
                                <select class="group-item group-item-l" title="days" id="D">
                                    <option value="">Day</option>
                                    <?php 
                                    for ($i = 1; $i <= 31; $i++) {
                                        $day = str_pad($i, 2, '0', STR_PAD_LEFT);
                                        echo "<option value='$day'>$day</option>";
                                    } 
                                    ?>
                                </select>
                            </div>
                            <!-- Month Selector -->
                            <div class="input-group-2 col-box-4">
                                <select class="group-item group-item-md" title="Month" id="M">
                                    <option value="">Select Month</option>
                                    <?php 
                                    if ($month_result->num_rows > 0) {
                                        while ($month_row = $month_result->fetch_assoc()) {
                                            $month_num = $month_row['month'];
                                            $month_name = date('F', mktime(0, 0, 0, $month_num, 10)); 
                                            echo "<option value='$month_num'" . ($month_num == $month_filter ? ' selected' : '') . ">$month_name</option>";
                                        }
                                    } 
                                    ?>
                                </select>
                            </div>
                            <!-- Year Selector -->
                            <div class="input-group-2 col-box-3">
                                <select class="group-item group-item-md" title="Year" id="Y">
                                    <option value="">Select Year</option>
                                    <?php 
                                    if ($year_result->num_rows > 0) {
                                        while ($year_row = $year_result->fetch_assoc()) {
                                            echo "<option value='" . $year_row['year'] . "'" . ($year_row['year'] == $year_filter ? ' selected' : '') . ">" . $year_row['year'] . "</option>";
                                        }
                                    } 
                                    ?>
                                </select>
                            </div>
                            <!-- Filter Button -->
                            <div class="input-group-2 col-box-3">
                                <div class="group-item group-item-r text-center pointer" onclick="filterR(); loader();">
                                    <i class="fa fa-search"></i> Filter
                                </div>
                            </div>
                            <!-- Delete Data Button -->
                            <div class="input-group-2 col-box-3">
                                <div class="group-item group-item-r text-center pointer" onclick="confirmDelete()">
                                    <i class="fa fa-trash"></i> Delete Data
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Data Table -->
                    <div class="overflow box-bordered" style="max-height: 70vh">
                        <table id="dataTable" class="table table-bordered table-hover text-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th><center>No</center></th>
                                    <th><center>Username</center></th>
                                    <th><center>Date</center></th>
                                    <th><center>Time</center></th>
                                    <th><center>Price</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if ($result->num_rows > 0) {
                                    $counter = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td><center>" . $counter++ . "</center></td>";
                                        echo "<td><center>" . $row["username"] . "</center></td>";
                                        echo "<td><center>" . $row["date"] . "</center></td>";
                                        echo "<td><center>" . $row["time"] . "</center></td>";
                                        echo "<td style='text-align:center;'>" . $row["amount"] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'><center>Tidak ada data</center></td></tr>";
                                }
                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/report.js"></script>

</body>
</html>