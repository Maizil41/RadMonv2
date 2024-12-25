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
?>

<div id="sidenav" class="sidenav">
<a href="../pages/dashboard.php" class="menu"><i class="fa fa-dashboard"></i> Dashboard</a>
<!--hotspot-->
<div class="dropdown-btn active"><i class="fa fa-wifi"></i> Hotspot
<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../hotspot/user.php" class=""><i class="fa fa-users"></i> Hotspot User</a>
<a href="../hotspot/profile.php" class=""><i class="fa fa-pie-chart"></i> Hotspot Profile</a>
<a href="../hotspot/binding.php" class="active"><i class="fa fa-address-book"></i> MAC Bindings</a>
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
    <div class="main-container" style="display:none;">
        <div class="row">
            <div class="col-8">
                <div class="card box-bordered">
                    <div class="card-header">
                        <h3>
                            <i class="fa fa-user-plus"></i> Add Mac &nbsp; | &nbsp;
                            <small id="loader" style="display: none;">
                                <i class="fa fa-circle-o-notch fa-spin"></i> Processing...</i>
                            </small>
                            <?php if (isset($_GET['message'])): ?>
                                <small id="message">
                                    <?php echo htmlspecialchars($_GET['message']); ?>
                                </small>
                            <?php endif; ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" role="form" action="../backend/addmac.php" id="addMacForm">
                            <div class="mb-3">
                                <a class="btn bg-warning" href="../hotspot/binding.php">
                                    <i class="fa fa-close"></i> Close
                                </a>
                                <button type="submit" name="addMac" value="top" class="btn bg-primary">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>

                            <table class="table">
                                <tr>
                                    <td class="align-middle">Client Name</td>
                                    <td>
                                        <input class="form-control" type="text" autocomplete="off" id="clientName" name="clientName">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Profile</td>
                                    <td>
                                        <select class="form-control" id="planDropup" name="planName" autocomplete="off" required>
                                            <option value="">Select Profile</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>MAC Type</td>
                                    <td>
                                        <input type="radio" id="Select" name="typebp" value="Select" checked onclick="toggleMacInput()"> Select
                                        <input type="radio" id="Manual" name="typebp" value="Manual" onclick="toggleMacInput()"> Manual
                                    </td>
                                </tr>
                                <tr id="SelectMac">
                                    <td class="align-middle">Select Mac</td>
                                    <td>
                                        <select id="macDropdown" name="macSelect" class="form-control" autocomplete="off">
                                            <option value="">Select Mac</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr id="InputMac" style="display: none;">
                                    <td class="align-middle">Input Mac</td>
                                    <td>
                                        <input type="text" id="macManualInput" class="form-control" name="macManual" placeholder="Input Mac Address" maxlength="17" autocomplete="on">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">WhatsApp</td>
                                    <td>
                                        <input class="form-control" type="tel" autocomplete="off" id="Whatsapp_number" name="Whatsapp_number">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Telegram</td>
                                    <td>
                                        <input class="form-control" type="text" id="comment" autocomplete="off" name="comment" title="No special characters">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h3>
                            <i class="fa fa-book"></i> Read Me
                        </h3>
                    </div>
                    <div class="card-body">
                    <table class="table table-bordered">
                    <td colspan="2">
                        <ul>
                            <li>Client Name : Nama pelanggan.</li>
                            <li>Mac Type : Tipe Mac (Input manual atau pilih dari dropdown).</li>
                            <li>WhatsApp : Nomor whatsapp pelanggan.</li>
                            <li>Telegram : Id telegram pelanggan</li>
                        </ul>
                        <p><b>NOTES:</b> Yang wajib diisi hanya Mac Address dan Profile, sisanya opsional.<br>Abaikan jika tidak ingin diisi.</p>
                        </td></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/add.mac.js"></script>
</body>
</html>
