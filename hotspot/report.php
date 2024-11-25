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
<a href="../hotspot/profile.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-list "></i> Profile List </a>
<a href="../hotspot/bandwidth.php" class=""> &nbsp;&nbsp;&nbsp;<i class="fa fa-hourglass "></i> Bandwidth List </a>
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
<!--billing-->
<div class="dropdown-btn "><i class=" fa fa-credit-card"></i> Billing<i class="fa fa-caret-down"></i>
</div>
<div class="dropdown-container ">
<a href="../billing/request.php" class=""> <i class="fa fa-plus-circle "></i> Topup Request </a>
<a href="../billing/user.php" class=""> <i class="fa fa-user "></i> Client List </a>
</div>
<!--report-->
<a href="../hotspot/report.php" class="menu active"><i class="nav-icon fa fa-money"></i> Report</a>
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

<?php
include('../config/mysqli_db.php');

$year_filter = isset($_GET['year']) ? $_GET['year'] : '';
$month_filter = isset($_GET['month']) ? $_GET['month'] : '';
$day_filter = isset($_GET['day']) ? $_GET['day'] : '';

if (isset($_GET['delete'])) {
    $delete_sql = "DELETE FROM income WHERE 1";
    
    if ($year_filter) {
        $delete_sql .= " AND YEAR(date) = '$year_filter'";
    }
    if ($month_filter) {
        $delete_sql .= " AND MONTH(date) = '$month_filter'";
    }
    if ($day_filter) {
        $delete_sql .= " AND DAY(date) = '$day_filter'";
    }

    if ($conn->query($delete_sql) === TRUE) {
    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }
}

$sql = "SELECT * FROM income WHERE 1";

if ($year_filter) {
    $sql .= " AND YEAR(date) = '$year_filter'";
}
if ($month_filter) {
    $sql .= " AND MONTH(date) = '$month_filter'";
}
if ($day_filter) {
    $sql .= " AND DAY(date) = '$day_filter'";
}

$result = $conn->query($sql);

$year_query = "SELECT DISTINCT YEAR(date) AS year FROM income ORDER BY year DESC";
$month_query = "SELECT DISTINCT MONTH(date) AS month FROM income ORDER BY month ASC";

$year_result = $conn->query($year_query);
$month_result = $conn->query($month_query);

echo '<div id="main">  
<div id="loading" class="lds-dual-ring"></div>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
	<h3><i class=" fa fa-money"></i> Selling Report   <small id="loader" style="display: none;" ><i><i class="fa fa-circle-o-notch fa-spin"></i> Processing... </i></small></h3>
</div>
<div class="card-body">
<div class="row">
	<div class="row">
	<div class="col-12">
	</div>
<div class="input-group mr-b-10">
    <div class="input-group-1 col-box-2">
        <select style="padding:5px;" class="group-item group-item-l" title="days" id="D">
            <option value="">Day</option>';
            for ($i = 1; $i <= 31; $i++) {
                $day = str_pad($i, 2, '0', STR_PAD_LEFT);
                echo "<option value='$day'>$day</option>";
            }
            echo '</select>
    </div>
    <div class="input-group-2 col-box-4">
        <select style="padding:5px;" class="group-item group-item-md" title="Month" id="M">
            <option value="">Select Month</option>';
            if ($month_result->num_rows > 0) {
                while($month_row = $month_result->fetch_assoc()) {
                    $month_num = $month_row['month'];
                    $month_name = date('F', mktime(0, 0, 0, $month_num, 10)); // Mengonversi bulan nomor menjadi nama bulan
                    echo "<option value='$month_num' " . ($month_num == $month_filter ? 'selected' : '') . ">$month_name</option>";
                }
            }
            echo '</select>
    </div>
    <div class="input-group-2 col-box-3">
        <select style="padding:5px;" class="group-item group-item-md" title="Year" id="Y">
            <option value="">Select Year</option>';
            if ($year_result->num_rows > 0) {
                while($year_row = $year_result->fetch_assoc()) {
                    echo "<option value='" . $year_row['year'] . "' " . ($year_row['year'] == $year_filter ? 'selected' : '') . ">" . $year_row['year'] . "</option>";
                }
            }
            echo '</select>
    </div>
    <!-- Tombol Filter -->
    <div class="input-group-2 col-box-3">
        <div style="padding:3.5px;" class="group-item group-item-r text-center pointer" onclick="filterR(); loader();"><i class="fa fa-search"></i> Filter</div>
    </div>
    <!-- Tombol Hapus Data -->
    <div class="input-group-2 col-box-3">
        <div style="padding:3.5px;" class="group-item group-item-r text-center pointer" onclick="confirmDelete()"><i class="fa fa-trash"></i> Delete Filtered Data</div>
    </div>
</div>

		  <div class="overflow box-bordered" style="max-height: 70vh">
			<table id="dataTable" class="table table-bordered table-hover text-nowrap">
				<thead class="thead-light">
				<tr>
				  <th><center>No</th>
				  <th><center>Username</th>
				  <th><center>Date</th>
				  <th><center>Price</th>
				</tr>
				</thead>
				<tbody>';

				if ($result->num_rows > 0) {
					$counter = 1;
					while($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td><center>" . $counter++ . "</td>";
						echo "<td><center>" . $row["username"] . "</td>";
						echo "<td><center>" . $row["date"] . "</td>";
						echo "<td style='text-align:center;'>" . $row["amount"] . "</td>";
						echo "</tr>";
					}
				} else {
					echo "<tr><td colspan='4'><center>Tidak ada data</td></tr>";
				}


echo '<script type="text/javascript">
    function confirmDelete() {
        var confirmAction = confirm("Apakah Anda yakin ingin menghapus data yang sudah difilter?");
        if (confirmAction) {
            var url = "?themes=' . $theme . '&delete=true&year=' . $year_filter . '&month=' . $month_filter . '&day=' . $day_filter . '";
            window.location.href = url;
        }
    }
</script>';

$conn->close();
?>

<script type="text/javascript">
    function filterR() {
        var day = document.getElementById('D').value;
        var month = document.getElementById('M').value;
        var year = document.getElementById('Y').value;

        var url = "../hotspot/report.php?report=selling";
        
        if (day) {
            url += "&day=" + day;
        }
        if (month) {
            url += "&month=" + month;
        }
        if (year) {
            url += "&year=" + year;
        }

        window.location.href = url;
    }
</script>


<script src="../js/radmon-ui.<?php echo $theme; ?>.min.js"></script>
<script src="../js/radmon.js"></script>


<script>
$(document).ready(function(){
  makeAllSortable();
  $("#filterTable").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#dataTable tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

</script>
</body>
</html>