<?php
// PrintTickets RadiusMonitor By Maizil
include "phpqrcode/qrlib.php";

require '../config/mysqli_db.php';
require '../config/db_config.php';

$sql = "SELECT hsname1, hsname2, hsip, hsdomain, hscsn, hsqrmode, hsipdomain, logomode FROM print_config WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $hsname1 = isset($row['hsname1']) ? $row['hsname1'] : '';
    $hsname2 = isset($row['hsname2']) ? $row['hsname2'] : '';
    $hsip = isset($row['hsip']) ? $row['hsip'] : '';
    $hsdomain = isset($row['hsdomain']) ? $row['hsdomain'] : '';
    $hscsn = isset($row['hscsn']) ? $row['hscsn'] : '';
    $hsqrmode = isset($row['hsqrmode']) ? $row['hsqrmode'] : '';
    $hsipdomain = isset($row['hsipdomain']) ? $row['hsipdomain'] : '';
    $logomode = isset($row['logomode']) ? $row['logomode'] : '';
} else {
    $hsname1 = $hsname2 = $hsip = $hsdomain = $hscsn = $hsqrmode = $hsipdomain = $logomode = '';
}

$conn->close();

if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "batch") {
    if (isset($_REQUEST['format'])) {
        $format = $_REQUEST['format'];

    } else {
        
    }

    $plan = $_REQUEST["plan"];
    $accounts_temp = $_REQUEST["accounts"];
    $accounts = explode("||", $accounts_temp);

    $host = $db_config['servername'];
    $dbname = $db_config['dbname'];
    $username = $db_config['username'];
    $password = $db_config['password'];

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT planCost, planTimeBank, planCurrency FROM billing_plans WHERE planName = :plan";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':plan', $plan, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $ticketCurrency = $row["planCurrency"];
            $ticketCost = $row["planCost"] . " " . $ticketCurrency;
            $ticketTime = time2str($row["planTimeBank"]);
            
        } else {
        $ticketCurrency = '0';
        $ticketCost = '0';
        $ticketTime = '';
        }

            $sqlQuota = "SELECT value FROM radgroupreply WHERE groupname = :plan AND attribute = 'ChilliSpot-Max-Total-Octets'";
            $stmtQuota = $pdo->prepare($sqlQuota);
            $stmtQuota->bindParam(':plan', $plan, PDO::PARAM_STR);
            $stmtQuota->execute();

            $quotaRow = $stmtQuota->fetch(PDO::FETCH_ASSOC);
            $ticketQuota = isset($quotaRow["value"]) ? formatBytes($quotaRow["value"]) : "";

            $sqlActiveTime = "SELECT value FROM radgroupcheck WHERE groupname = :plan AND attribute = 'Max-All-Session'";
            $stmtActiveTime = $pdo->prepare($sqlActiveTime);
            $stmtActiveTime->bindParam(':plan', $plan, PDO::PARAM_STR);
            $stmtActiveTime->execute();

            $activeRow = $stmtActiveTime->fetch(PDO::FETCH_ASSOC);
            $ticketActiveTime = isset($activeRow["value"]) ? time2str($activeRow["value"]) : "";

            $timestamp = date('Y-m-d H:i:s');

            printTicketsHTMLTable($accounts, $ticketCost, $ticketTime, $ticketQuota, $ticketActiveTime, $timestamp);

}

function formatBytes($bytes, $decimal = 0) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%." . $decimal . "f", $bytes / pow(1024, $factor)) . ' ' . $units[$factor];
}

function time2str($time) {
    if (!is_numeric($time)) {
        return '';
    }
    $units = array(
        "TAHUN" => 365*24*3600,
        "BULAN" => 30*24*3600,
        "HARI" => 24*3600,
        "JAM" => 3600,
        "MENIT" => 60,
        "DETIK" => 1,
    );

    $str = "";
    foreach ($units as $name => $divisor) {
        $quot = intval($time / $divisor);
        if ($quot) {
            $str .= "$quot $name ";
            $time -= $quot * $divisor;
        }
    }

    return trim($str);
}

function printTicketsHTMLTable($accounts, $ticketCost, $ticketTime, $ticketQuota, $ticketActiveTime, $timestamp)
{
    global $dnsname, $hslogo, $hsip, $hscsn, $hsdomain, $hsname1, $hsname2, $hsqrmode, $hsipdomain, $qrcodeData, $logomode;

    if ($ticketCost <= 500) {
        $color = "#4bde97";
    } elseif ($ticketCost >= 1000 && $ticketCost <= 4000) {
        $color = "#e83e8c";
    } elseif ($ticketCost >= 4000 && $ticketCost <= 24000) {
        $color = "#f74e07";
    } elseif ($ticketCost >= 25000 && $ticketCost <= 49000) {
        $color = "#0f8d43";
    } elseif ($ticketCost >= 50000 && $ticketCost <= 100000) {
        $color = "#9911b1";
    }

    array_shift($accounts);
    foreach ($accounts as $userpass) {
        list($user, $pass) = explode(",", $userpass);

        $size = isset($_REQUEST["size"]) ? (int)$_REQUEST["size"] : 5;
        $matrixPointSize = min(max($size, 5), 10);

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $timestamp ?></title>
        <style>body{color:#000;background-color:#FFF;font-size:14px;font-family:'Helvetica',arial,sans-serif;margin:0;-webkit-print-color-adjust:exact}table.voucher{display:inline-block;border:2px solid #000;margin:2px}@page{size:auto;margin-left:7mm;margin-right:3mm;margin-top:9mm;margin-bottom:3mm}@media print{table{page-break-after:auto}tr{page-break-inside:avoid;page-break-after:auto}td{page-break-inside:avoid;page-break-after:auto}thead{display:table-header-group}tfoot{display:table-footer-group}}.rotate{max-width:15px;white-space:nowrap;vertical-align:bottom;padding-right:5px}.rotate>div{transform:rotate(-90deg)}.qrcode{height:100px;width:100px}.price{font-size:20px}</style>
	</head>
<body>
<table class="voucher" style=" width: 180px;">
	<tbody>
		<tr>
			<td style="text-align: center; font-size: 14px; border-bottom: 1px black solid;">
            <?php if ($logomode == "text"): ?>
                <center><span style="font-size: 25px;font-weight: bold;"><?php echo $hsname1; ?><span style="color:<?php echo $color; ?>;"><?php echo $hsname2; ?></center>
            <?php elseif ($logomode == "image"): ?>
                <img src="../img/logo/radmon-logo.png" alt="logo" style="height: 58px; width: 170px; border: 0;">
            <?php endif; ?>
			<span><?php echo $timestamp ?></span>
			</td>
		</tr>
		<tr>
			<td>
				<table style=" text-align: center; width: 170px; font-size: 12px;">
					<tbody>
						<tr>
							<td>
                            <table style="width:100%;height:100%;">
                                <tr>
                                    <td style="width: 50%">Username</td>
                                    <?php if ($pass !== "Accept"): ?>
                                        <td>Password</td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                <tr style="font-size: 14px;"></td>
                                    <td style="border: 1px solid black; font-weight:bold;"><?php echo $user; ?></td>
                                    <?php if ($pass !== "Accept"): ?>
                                    <td style="border: 1px solid black; font-weight:bold;"><?php echo $pass; ?></td>
                                    <?php endif; ?>
                                </tr>
                            </table>
							</td>
						</tr>

						<tr>
							<td colspan="2" style="border-top: 1px solid black;font-weight:bold; font-size:14px"><span class="validity"><?php echo $ticketActiveTime;?></span> <?php echo $ticketTime;?></span> <?php echo $ticketQuota;?></span></td>
						</tr>
						<tr>
							<td><span class="price">Rp <?php echo $ticketCost;?></span></td>
						</tr>
						<tr>
							<td colspan="2">
                            <?php
                                $tempdir = "tmp/";

                                    if (!file_exists($tempdir)) {
                                        mkdir($tempdir);}
                                        
                                            if($hsqrmode == "code") {
                                                $qrcodeData = "$user";
                                                $size = 10;
                                            } elseif ($hsqrmode == "url") {
                                                if($hsipdomain == "ip") {
                                                    $qrcodeData = "http://$hsip:3990/login?username=$user&password=$pass";
                                                    $size = 4;
                                                } elseif ($hsipdomain == "domain") {
                                                    $qrcodeData = "http://$hsdomain:3990/login?username=$user&password=$pass";
                                                    $size = 4;
                                                }
                                            }

                                            $errorCorrectionLevel = 'M';

                                            $matrixPointSize = min(max((int)($_REQUEST['size'] ?? $size), 2), 5);

                                            $qrcodeFilename = $tempdir . $user . '.png';

                                            QRcode::png($qrcodeData, $qrcodeFilename, $errorCorrectionLevel, $matrixPointSize, 2);

                                            echo '<img src="' . htmlspecialchars($qrcodeFilename) . '" alt="QR Code">';
                                        ?>
                                    <td>
                                 </tr>
						    <tr>
							<td colspan="2" style="font-weight:bold; font-size:12px">CS : <?php echo $hscsn;?></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>
<?php
    }
}
?>
