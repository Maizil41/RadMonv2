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
include ("../backend/interface.php");
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
<a href="../billing/product.php" class=""><i class="fa fa-shopping-cart"></i> Product List </a>
</div>
<!--report-->
<a href="../hotspot/report.php" class="menu"><i class="nav-icon fa fa-money"></i> Report</a>
<!--settings-->
<div class="dropdown-btn active"><i class="fa fa-gear"></i> Settings 
<i class="fa fa-caret-down"></i> &nbsp;
</div>
<div class="dropdown-container">
<a href="../pages/admin.php" class="menu"><i class="fa fa-gear"></i> Admin Settings </a>
<a href="../pppoe/settings.php" class="active"><i class="fa fa-wrench"></i> PPPoE Settings </a>
<a href="../hotspot/hslogo.php" class="menu"><i class="fa fa-upload"></i> Upload Logo </a>
<a href="../voucher/template.php" class="menu"><i class="fa fa-edit"></i> Template Setting </a>          
<a href="../pages/backup.php" class="menu"><i class="fa fa-folder-open"></i> Backup & Restore </a>          
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
                    <h3 class="card-title"><i class="fa fa-wrench"></i> PPPoE Settings &nbsp; | &nbsp; 
                        <small id="loader" style="display: none;">
                            <i><i class="fa fa-circle-o-notch fa-spin"></i> Processing...</i>
                        </small>
                        <?php if (isset($_GET['message'])): ?>
                            <small id="message">
                                <?php echo htmlspecialchars($_GET['message']); ?>
                            </small>
                        <?php endif; ?>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="../backend/ppp.setting.php" id="changePass">
                        <table class="table table-sm">
                            <tr id="TimeLimit">
                                <td class="align-middle">Interface</td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-12">
                                            <?php
                                            echo '<select class="form-control" name="interface" placeholder="pppoe_server" title="Interface">';
                                            foreach ($interfaces as $iface) {
                                                $selected = ($iface == $interface) ? 'selected' : '';
                                                echo "<option value=\"$iface\" $selected>$iface</option>";
                                            }
                                            echo '</select>';
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>                        
                            <tr>
                                <td class="align-middle">IP Address </td>
                                <td><input class="form-control" id="ipaddress" type="text" size="10" name="ipaddress" placeholder="192.168.2.1" title="IP Address" value="<?php echo $ipaddress; ?>" required="1" /></td>
                            </tr>
                            <tr>
                                <td class="align-middle">File Config </td>
                                <td><input class="form-control" id="config" type="text" size="10" name="config" placeholder="/etc/ppp/options" title="File Config" value="<?php echo $fileconfig; ?>" required="1" /></td>
                            </tr>
                            <tr>
                                <td class="align-middle">Option MTU </td>
                                <td><input class="form-control" id="mtu" type="text" size="10" name="mtu" placeholder="1468" title="MTU" value="<?php echo $optionmtu; ?>" required="1" /></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-right">
                                    <button type="submit" name="save" value="save" class="btn bg-primary"><i class="fa fa-save"></i> Save</button>
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
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
</body>
</html>

