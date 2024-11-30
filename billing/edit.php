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
include ("../include/billing.edit.php");
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
<a href="../logs/radius.php" class="menu"><i class="fa fa-database"></i> Radius Log </a>
</div>
<!--system-->
<a href="../pages/server.php" class="menu"><i class="fa fa-server"></i> Status </a>
<!--billing-->
<div class="dropdown-btn active"><i class="fa fa-credit-card"></i> Billing<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../billing/request.php" class="menu"><i class="fa fa-plus-circle "></i> Topup Request </a>
<a href="../billing/user.php" class="active"><i class="fa fa-user "></i> Client List </a>
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
                        <h3><i class="fa fa-edit"></i> Edit Client : <?php echo htmlspecialchars($uid['username']); ?></h3>
                    </div>
                    <div class="card-body">
                        <form method="post" role="form" action="../backend/update_client.php">
                            <div>
                                <input type="hidden" id="uid" name="uid" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                                <a class="btn bg-warning" href="../billing/user.php"> <i class="fa fa-close"></i> Close</a>
                                <button type="submit" name="updateusers" class="btn bg-primary"><i class="fa fa-save"></i> Save</button>
                            </div>

                            <table class="table">
                                <tr>
                                    <td>Username</td>
                                    <td>
                                        <input type="text" class="form-control" id="username" name="username" maxlength="16" value="<?php echo htmlspecialchars($uid['username']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td>
                                        <input type="text" class="form-control" id="password" name="password" maxlength="16" value="<?php echo htmlspecialchars($uid['password']); ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Balance</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-1">
                                                <input type="text" class="form-control" value="Rp" disabled>
                                            </div>
                                            <div class="input-group-11">
                                                <input type="number" id="balance" class="form-control" name="balance" value="<?php echo htmlspecialchars($uid['balance']); ?>" min="0" required>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Telegram</td>
                                    <td>
                                        <input type="number" class="form-control" id="telegram" name="telegram" value="<?php echo htmlspecialchars($uid['telegram_id']); ?>" oninput="if(this.value.length > 12) this.value = this.value.slice(0,12);" title="Masukkan ID yang valid">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">WhatsApp</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-1">
                                                <input type="number" class="form-control" value="62" disabled>
                                            </div>
                                            <div class="input-group-11">
                                                <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo htmlspecialchars($client_phone); ?>" oninput="if(this.value.length > 17) this.value = this.value.slice(0,17);" pattern="[0-9\-]+" title="Masukkan nomor yang valid">
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
</body>
</html>
