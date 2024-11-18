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
include('../include/head.html.php');
?>

<div id="sidenav" class="sidenav">
<a href="../pages/dashboard.php" class="menu "><i class="fa fa-dashboard"></i> Dashboard</a>
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
<a href="../hotspot/profile.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-list"></i> Profile List </a>
<a href="../hotspot/bandwidth.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-hourglass"></i> Bandwidth List </a>
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
<!--report-->
<a href="../hotspot/report.php" class="menu"><i class="nav-icon fa fa-money"></i> Report</a>
<!--settings-->
<div class="dropdown-btn active"><i class="fa fa-gear"></i> Settings 
<i class="fa fa-caret-down"></i> &nbsp;
</div>
<div class="dropdown-container ">
<a href="../pages/admin.php" class="menu"> <i class="fa fa-gear"></i> Admin Settings </a>
<a href="../hotspot/hslogo.php" class="menu active"> <i class="fa fa-upload"></i> Upload Logo </a>
<a href="../voucher/template.php" class="menu"> <i class="fa fa-edit"></i> Template Setting </a>          
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
                        <h3 class="card-title"><i class="fa fa-upload"></i> Upload Logo &nbsp; | &nbsp; 
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
                        <form action="../backend/logo.php" method="post" enctype="multipart/form-data" id="changeLogo">
                           <div class="pd-10">Format file : jpg, jpeg, png</div>
                            <div class="input-group">
                                <div class="input-group-4 col-box-8">
                                    <input style="cursor: pointer; " type="file" class="group-item group-item-l" name="UploadLogo" accept=".jpg, .jpeg, .png" required>
                                </div>
                                <div class="input-group-2 col-box-4">
                                    <input style="cursor: pointer; font-size: 12px; padding:8px;" class="group-item group-item-r" type="submit" value="Upload" name="submit">
                                </div>
                            </div>
                        </form>
                        <div class="mr-t-10">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Current Logo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $directory = '../img/logo/';
                                    $files = array_diff(scandir($directory), array('.', '..'));
                                    foreach ($files as $file) {
                                        echo "
                                        <tr>
                                            <td>
                                                <a href=\"$directory$file\" target=\"_blank\">
                                                    <img height=\"100px\" src=\"$directory$file\" alt=\"$file\">
                                                </a><br>
                                            </td>
                                            <td>
                                                <a class=\"btn bg-danger\" href=\"../backend/logo.php?action=delete&file=$file\" onclick=\"return confirm('Yakin ingin menghapus logo ini?')\">
                                                    <i class=\"fa fa-trash\"></i> Delete
                                                </a>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
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
<script src="../plugins/change.logo.js"></script>
</body>
</html>