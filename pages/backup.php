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
<div class="dropdown-btn"><i class="fa fa-wifi"></i> Hotspot
<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container">
<a href="../hotspot/user.php" class="menu"><i class="fa fa-users"></i> Hotspot User</a>
<a href="../hotspot/profile.php" class="menu"><i class="fa fa-pie-chart"></i> Hotspot Profile</a>
<a href="../hotspot/binding.php" class="menu"><i class="fa fa-address-book"></i> MAC Bindings</a>
<a href="../hotspot/active.php" class="menu"><i class="fa fa-wifi"></i> Hotspot Active</a>
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
<div class="dropdown-btn active"><i class="fa fa-gear"></i> Settings 
<i class="fa fa-caret-down"></i> &nbsp;
</div>
<div class="dropdown-container">
<a href="../pages/admin.php" class="menu"><i class="fa fa-gear"></i> Admin Settings </a>
<a href="../hotspot/hslogo.php" class="menu"><i class="fa fa-upload"></i> Upload Logo </a>
<a href="../voucher/template.php" class="menu"><i class="fa fa-edit"></i> Template Setting </a>          
<a href="../pages/backup.php" class="active"><i class="fa fa-folder-open"></i> Backup & Restore </a>          
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
                        <h3 class="card-title"><i class="fa fa-folder-open"></i> Backup & Restore &nbsp; | &nbsp; 
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
                        <form action="../backend/backup.php" method="post" enctype="multipart/form-data" id="changeLogo">
                           <div class="pd-10">Format file : sql</div>
                            <div class="input-group">
                                <div class="input-group-4 col-box-12">
                                    <input style="cursor: pointer;" type="file" class="group-item" name="UploadDB" accept=".sql" required>
                                </div>
                                <button type="submit" value="Upload" name="submit" class="btn bg-primary">
                                    <i class="fa fa-upload"></i> Upload
                                </button>
                                <a href="../backend/backup.php?action=backup" class="btn bg-success">
                                    <i class="fa fa-download"></i> Backup
                                </a>
                            </div>
                        </form>
                        <div class="mr-t-10">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><center>No</center></th>
                                        <th><center>Database</center></th>
                                        <th><center>Size</center></th>
                                        <th><center>Action</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $directory = '../backup/';
                                    $files = array_diff(scandir($directory), array('.', '..'));
                                    $files = array_reverse($files);
                                    $nomor_urut = 1;

                                    function formatSize($size) {
                                        if ($size >= 1073741824) {
                                            $size = number_format($size / 1073741824, 2) . ' GB';
                                        } elseif ($size >= 1048576) {
                                            $size = number_format($size / 1048576, 2) . ' MB';
                                        } elseif ($size >= 1024) {
                                            $size = number_format($size / 1024, 2) . ' KB';
                                        } else {
                                            $size = $size . ' bytes';
                                        }
                                        return $size;
                                    }

                                    foreach ($files as $file): ?>
                                        <tr>
                                            <td style="text-align: center;">
                                                <?php echo $nomor_urut++; ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <a><i class="fa fa-database"></i> <?php echo $file; ?></a>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php 
                                                $fileSize = filesize($directory . $file); 
                                                echo formatSize($fileSize); 
                                                ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <a class="btn bg-danger" href="../backend/backup.php?action=delete&file=<?php echo urlencode($file); ?>" onclick="return confirm('Yakin ingin menghapus database ini?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <a class="btn bg-warning" href="../backend/backup.php?action=restore&file=<?php echo urlencode($file); ?>" onclick="return confirm('Yakin ingin merestore database ini?')">
                                                    <i class="fa fa-rotate-left"></i>
                                                </a>
                                                <a class="btn bg-success" href="../backend/backup.php?action=download&file=<?php echo urlencode($file); ?>">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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
