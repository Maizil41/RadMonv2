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
include ("../backend/profile.php");
?>

<div id="sidenav" class="sidenav">
<a href="../pages/dashboard.php" class="menu"><i class="fa fa-dashboard"></i> Dashboard</a>
<!--hotspot-->
<div class="dropdown-btn active"><i class="fa fa-wifi"></i> Hotspot
<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<a href="../hotspot/user.php" class="menu"><i class="fa fa-users"></i> Hotspot User</a>
<a href="../hotspot/profile.php" class="active"><i class="fa fa-pie-chart"></i> Hotspot Profile</a>
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
                        <h3><i class="fa fa-edit"></i> Edit Profile : <?php echo htmlspecialchars($plan['planName']); ?></h3>
                    </div>
                    <div class="card-body">
                        <form method="post" role="form" action="../backend/update_plan.php">
                            <div>
                                <input type="hidden" id="planTimeBank" name="planTimeBank" value="<?php echo htmlspecialchars($plan['planTimeBank']); ?>">
                                <input type="hidden" id="profileTimeBank" name="profileTimeBank" value="<?php echo htmlspecialchars($plan['Max_All_Session']); ?>">
                                <input type="hidden" id="dataLimit" name="dataLimit" value="<?php echo $data_value; ?>">
                                <input type="hidden" id="rate_down" name="rate_down">
                                <input type="hidden" id="rate_up" name="rate_up">
                                <a class="btn bg-warning" href="../hotspot/profile.php"> <i class="fa fa-close"></i> Close</a>
                                <button type="submit" name="updatebillplans" value="top" class="btn bg-primary"><i class="fa fa-save"></i> Save</button>
                            </div>

                            <table class="table">
                                <tr>
                                    <td><input type="hidden" id="planName" name="planName" value="<?php echo htmlspecialchars($plan['planName']); ?>"></td>
                                </tr>
                                <tr>
                                    <td>Plan Code</td>
                                    <td>
                                        <input type="text" class="form-control" id="planCode" name="planCode" maxlength="6" value="<?php echo htmlspecialchars($plan['planCode']); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Idle Timeout</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-8">
                                                <input type="number" class="form-control" id="idleTimeout" name="idleTimeout" maxlength="6" value="<?php echo htmlspecialchars($plan['idle_timeout']); ?>">
                                            </div>
                                            <div class="input-group-4">
                                                <span class="group-item group-item-l pd-2p5 text-left align-middle">Detik</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shared User</td>
                                    <td>
                                        <input type="number" class="form-control" id="shared" name="shared" value="<?php echo htmlspecialchars($plan['Simultaneous_Use']); ?>" min="1" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Duration</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-8">
                                                <input type="number" class="form-control" id="profileTimeBankInput" name="profileTimeBankInput" value="<?php echo $time_max; ?>" min="0">
                                            </div>
                                            <div class="input-group-4">
                                                <select class="form-control" id="profileTimeBankSelect" name="profileTimeBankSelect">
                                                    <option value="M" <?php echo ($time_max_unit == 'M') ? 'selected' : ''; ?>>Menit</option>
                                                    <option value="H" <?php echo ($time_max_unit == 'H') ? 'selected' : ''; ?>>Jam</option>
                                                    <option value="D" <?php echo ($time_max_unit == 'D') ? 'selected' : ''; ?>>Hari</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Data Limit</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-8">
                                                <input type="number" class="form-control" id="data_limit" name="data_limit" value="<?php echo $data_value; ?>" min="0">
                                            </div>
                                            <div class="input-group-4">
                                                <select class="form-control" id="data_unit" name="data_unit">
                                                    <option value="MB" <?php echo ($data_unit == 'MB') ? 'selected' : ''; ?>>MB</option>
                                                    <option value="GB" <?php echo ($data_unit == 'GB') ? 'selected' : ''; ?>>GB</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rate limit [down/up]</td>
                                    <td>
                                        <select id="bw_id" name="bw_id" class="form-control">
                                            <option value="">Select Bandwidth...</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Selling Price Rp</td>
                                    <td><input type="number" id="planCost" class="form-control" name="planCost" value="<?php echo htmlspecialchars($plan['planCost']); ?>" min="0" required></td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Validity</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-8">
                                                <input type="number" class="form-control" id="planTimeBankInput" name="planTimeBankInput" value="<?php echo $time_bank; ?>" min="0">
                                            </div>
                                            <div class="input-group-4">
                                                <select class="form-control" id="planTimeBankSelect" name="planTimeBankSelect">
                                                    <option value="M" <?php echo ($time_bank_unit == 'M') ? 'selected' : ''; ?>>Menit</option>
                                                    <option value="H" <?php echo ($time_bank_unit == 'H') ? 'selected' : ''; ?>>Jam</option>
                                                    <option value="D" <?php echo ($time_bank_unit == 'D') ? 'selected' : ''; ?>>Hari</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/update.profile.js"></script>
</body>
</html>
