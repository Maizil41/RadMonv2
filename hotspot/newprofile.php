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
<a href="../hotspot/profile.php" class="active"><i class="fa fa-pie-chart"></i> Hotspot Profile</a>
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
    <div class="main-container" style="display:none">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fa fa-plus"></i> Add Profile &nbsp; | &nbsp; 
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
                        <form method="post" role="form" action="../backend/addprofile.php" id="addprofile">
                            <div>
                                <input type="hidden" id="planTimeBank" name="planTimeBank">
                                <input type="hidden" id="profileTimeBank" name="profileTimeBank" value="0">
                                <input type="hidden" id="dataLimit" name="dataLimit">
                                <input type="hidden" id="rate_down" name="rate_down">
                                <input type="hidden" id="rate_up" name="rate_up">
                                <a class="btn bg-warning" href="../hotspot/profile.php"> <i class="fa fa-close"></i> Close</a>
                                <button type="submit" name="updatebillplans" value="top" class="btn bg-primary"><i class="fa fa-save"></i> Save</button>
                            </div>

                            <table class="table">
                                <tr>
                                    <td>Profile Name</td>
                                    <td><input type="text" class="form-control" id="planName" name="planName" required></td>
                                </tr>
                                <tr>
                                    <td>Profile Code</td>
                                    <td><input type="text" class="form-control" id="planCode" name="planCode" maxlength="6"></td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Idle Timeout</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-8">
                                                <input type="number" class="form-control" id="idleTimeout" name="idleTimeout" value="0" min="0">
                                            </div>
                                            <div class="input-group-4">
                                                <span class="group-item group-item-l pd-2p5 text-left align-middle">Detik</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>Shared User</td>
                                    <td><input type="number" class="form-control" id="shared" name="shared" value="1" min="1" required></td>
                                </tr>
                                
                                <tr>
                                    <td>Profile Type</td>
                                    <td>
                                        <input type="radio" id="Unlimited" name="typebp" value="Unlimited" checked> Unlimited
                                        <input type="radio" id="Limited" name="typebp" value="Limited"> Limited
                                    </td>
                                </tr>
                                    
 
                                <tr style="display:none;" id="Type">
                                    <td class="align-middle">Limit Type</td>
                                    <td>
                                        <input type="radio" id="Time_Limit" name="limit_type" value="Time_Limit" checked> Time Limit
                                        <input type="radio" id="Data_Limit" name="limit_type" value="Data_Limit"> Data Limit
                                        <input type="radio" id="Both_Limit" name="limit_type" value="Both_Limit"> Both Limit
                                    </td>
                                </tr>
                                
                                <tr style="display:none;" id="TimeLimit">
                                    <td class="align-middle">Duration</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-8">
                                                <input type="number" class="form-control" id="profileTimeBankInput" name="profileTimeBankInput" value="0" min="0">
                                            </div>
                                            <div class="input-group-4">
                                                <select class="form-control" id="profileTimeBankSelect" name="profileTimeBankSelect">
                                                    <option value="M">Menit</option>
                                                    <option value="H">Jam</option>
                                                    <option value="D">Hari</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="display:none;" id="ValidityLimit">
                                    <td class="align-middle">Validity</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-8">
                                                <input type="number" class="form-control" id="planTimeBankInput" name="planTimeBankInput" value="0" min="0">
                                            </div>
                                            <div class="input-group-4">
                                                <select class="form-control" id="planTimeBankSelect" name="planTimeBankSelect">
                                                    <option value="M">Menit</option>
                                                    <option value="H">Jam</option>
                                                    <option value="D">Hari</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="display:none;" id="DataLimit">
                                    <td class="align-middle">Data Limit</td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-8">
                                                <input type="number" class="form-control" id="data_limit" name="data_limit" value="0" min="0">
                                            </div>
                                            <div class="input-group-4">
                                                <select class="form-control" id="data_unit" name="data_unit">
                                                    <option value="MB">MB</option>
                                                    <option value="GB">GB</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>Rate limit</td>
                                    <td>
                                        <select id="bw_id" name="bw_id" class="form-control">
                                            <option value="">Select Bandwidth...</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">Selling Price Rp</td>
                                    <td><input type="number" id="planCost" class="form-control" name="planCost" value="0" min="0" required></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fa fa-book"></i> Read Me</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2">
                                    <p style="padding:0px 5px;"><b>NOTES:</b>
                                        <ul>
                                            <li>Profile Code : Wajib diisi jika ingin paket tampil di bot Whatsapp.</li>
                                            <li>Idle Timeout : Ini akan memutuskan user setelah tidak aktif dalam waktu yang ditentukan, dan harus login ulang.</li>
                                            <li>Shared User : Satu kode voucher bisa digunakan untuk beberapa device sesuai yang diinginkan.</li>
                                            <li>Limit Type : Sesuaikan Limit yang diinginkan, <br>Time limit = Limit waktu, <br>Data Limit = Limit Kuota, <br>Both Limit = Limit Keduanya.</li>
                                        </ul>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>
<script src="../plugins/add.profile.js"></script>
</body>
</html>
