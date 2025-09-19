<?php
// PrintTickets RadiusMonitor By Maizil
include "phpqrcode/qrlib.php";

require '../config/mysqli_db.php';
require '../config/db_config.php';

function esc($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$sql = "SELECT hsname1, hsname2, hsip, hsdomain, hscsn, hsqrmode, hsipdomain, logomode FROM print_config WHERE id = 1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hsname1    = $row['hsname1']    ?? '';
    $hsname2    = $row['hsname2']    ?? '';
    $hsip       = $row['hsip']       ?? '';
    $hsdomain   = $row['hsdomain']   ?? '';
    $hscsn      = $row['hscsn']      ?? '';
    $hsqrmode   = $row['hsqrmode']   ?? '';
    $hsipdomain = $row['hsipdomain'] ?? '';
    $logomode   = $row['logomode']   ?? '';
} else {
    $hsname1 = $hsname2 = $hsip = $hsdomain = $hscsn = $hsqrmode = $hsipdomain = $logomode = '';
}
$conn->close();

if (strpos($hscsn, '62') === 0) {
    $cs_number = '0' . substr($hscsn, 2);
} else {
    $cs_number = $hscsn;
}
$formatted_cs = preg_replace('/(\d{4})(\d{4})(\d+)/', '$1-$2-$3', $cs_number);

$id     = $_GET['id']    ?? null;
$name   = $_GET['name']  ?? ($_GET['batch'] ?? null);

if (empty($id) || empty($name)) {
    http_response_code(400);
    exit("Bad Request: butuh query ?id=<batch_id>&name=<batch_name>");
}

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://127.0.0.1/RadMonv2'); // TODO: override via env/config
}
$apiUrl = BASE_URL . '/backend/quickPrint.php?id=' . urlencode($id) . '&name=' . urlencode($name);

$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTPHEADER => ['Accept: application/json']
]);
$apiResp  = curl_exec($ch);
$curlErr  = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($apiResp === false || $httpCode < 200 || $httpCode >= 300) {
    http_response_code(502);
    exit("Failed to fetch data ($httpCode): " . esc($curlErr ?: 'invalid response'));
}

$data = json_decode($apiResp, true);
if (!is_array($data) || empty($data) || !isset($data[0]['accounts'])) {
    http_response_code(502);
    exit("QuickPrint format unexpected.");
}

$batch = $data[0];
$plan  = $batch['plan_name'] ?? $name;

$accounts = [];
foreach (($batch['accounts'] ?? []) as $acc) {
    if (!empty($acc['username'])) {
        $u = (string)$acc['username'];
        $p = (string)($acc['password'] ?? '');
        $accounts[] = $u . "," . $p;
    }
}
if (empty($accounts)) {
    http_response_code(404);
    exit("Akun kosong di batch ini.");
}

$host     = $db_config['servername'];
$dbname   = $db_config['dbname'];
$username = $db_config['username'];
$password = $db_config['password'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->prepare("SELECT planCost, planTimeBank, planCurrency FROM billing_plans WHERE planName = :plan");
    $stmt->execute([':plan' => $plan]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $ticketCurrency = (string)$row["planCurrency"];
        $ticketCostNum  = is_numeric($row["planCost"]) ? (int)$row["planCost"] : 0;
        $ticketCostText = $row["planCost"] . " " . $ticketCurrency;
        $ticketTime     = time2str($row["planTimeBank"]);
    } else {
        $ticketCurrency = '';
        $ticketCostNum  = 0;
        $ticketCostText = '0';
        $ticketTime     = '';
    }

    $stmtQuota = $pdo->prepare("SELECT value FROM radgroupreply WHERE groupname = :plan AND attribute = 'ChilliSpot-Max-Total-Octets'");
    $stmtQuota->execute([':plan' => $plan]);
    $quotaRow = $stmtQuota->fetch(PDO::FETCH_ASSOC);
    $ticketQuota = isset($quotaRow["value"]) ? formatBytes((int)$quotaRow["value"]) : "";

    $stmtActive = $pdo->prepare("SELECT value FROM radgroupcheck WHERE groupname = :plan AND attribute = 'Max-All-Session'");
    $stmtActive->execute([':plan' => $plan]);
    $activeRow = $stmtActive->fetch(PDO::FETCH_ASSOC);
    $ticketActiveTime = isset($activeRow["value"]) ? time2str($activeRow["value"]) : "";

} catch (Exception $e) {
    http_response_code(500);
    exit("DB error: " . esc($e->getMessage()));
}

$timestamp = date('Y-m-d H:i:s');

printTicketsHTMLTable(
    $accounts,
    $ticketCostText,
    $ticketCostNum,
    $ticketTime,
    $ticketQuota,
    $ticketActiveTime,
    $timestamp,
    [
        'hsname1'=>$hsname1,'hsname2'=>$hsname2,'hsip'=>$hsip,'hsdomain'=>$hsdomain,
        'hsqrmode'=>$hsqrmode,'hsipdomain'=>$hsipdomain,'formatted_cs'=>$formatted_cs,'logomode'=>$logomode
    ]
);

function formatBytes($bytes, $decimal = 0) {
    $units = ['B','KB','MB','GB','TB','PB','EB','ZB','YB'];
    $i = 0;
    $val = (float)$bytes;
    while ($val >= 1024 && $i < count($units)-1) { $val /= 1024; $i++; }
    return sprintf("%.".$decimal."f", $val) . ' ' . $units[$i];
}
function time2str($time) {
    if (!is_numeric($time)) return '';
    $units = [
        "TAHUN" => 365*24*3600,
        "BULAN" => 30*24*3600,
        "HARI"  => 24*3600,
        "JAM"   => 3600,
        "MENIT" => 60,
        "DETIK" => 1,
    ];
    $time = (int)$time;
    $str = "";
    foreach ($units as $name => $divisor) {
        $quot = intdiv($time, $divisor);
        if ($quot) {
            $str .= "$quot $name ";
            $time -= $quot * $divisor;
        }
    }
    return trim($str);
}
function pickColorByCost(int $cost) {
    // rapihin rentang biar kontinyu
    if ($cost <= 500) return "#4bde97";
    if ($cost <= 999) return "#333";
    if ($cost <= 4000) return "#e83e8c";
    if ($cost <= 24000) return "#f74e07";
    if ($cost <= 49000) return "#0f8d43";
    if ($cost <= 100000) return "#9911b1";
    return "#333";
}
function safeFileName($name) {
    $name = preg_replace('/[^A-Za-z0-9_\-]/', '_', (string)$name);
    return $name !== '' ? $name : 'qr_' . bin2hex(random_bytes(4));
}

function buildQrData(string $hsqrmode, string $hsipdomain, string $hsip, string $hsdomain, string $user, string $pass) {
    if ($hsqrmode === "code") return $user;
    $base = '';
    if ($hsipdomain === "ip" && $hsip) {
        $base = "http://{$hsip}:3990/login";
    } else {
        $base = "http://{$hsdomain}:3990/login";
    }
    return $base . '?username=' . rawurlencode($user) . '&password=' . rawurlencode($pass);
}

function printTicketsHTMLTable(array $accounts, string $ticketCostText, int $ticketCostNum, string $ticketTime, string $ticketQuota, string $ticketActiveTime, string $timestamp, array $cfg)
{
    $hsname1     = $cfg['hsname1'];
    $hsname2     = $cfg['hsname2'];
    $hsip        = $cfg['hsip'];
    $hsdomain    = $cfg['hsdomain'];
    $hsqrmode    = $cfg['hsqrmode'];
    $hsipdomain  = $cfg['hsipdomain'];
    $formatted_cs= $cfg['formatted_cs'];
    $logomode    = $cfg['logomode'];

    $color = pickColorByCost($ticketCostNum);

    $tempdir = __DIR__ . "/tmp/";
    if (!is_dir($tempdir)) { mkdir($tempdir, 0775, true); }

    $size = isset($_REQUEST["size"]) ? (int)$_REQUEST["size"] : 5;
    $matrixPointSize = max(5, min($size, 10));
    $errorCorrectionLevel = "L";
    
    foreach ($accounts as $userpass) {
        [$user, $pass] = array_pad(explode(",", $userpass, 2), 2, '');

        $qrcodeData = buildQrData($hsqrmode, $hsipdomain, $hsip, $hsdomain, $user, $pass);

        $qrName = safeFileName($user) . ".png";
        $qrPath = $tempdir . $qrName;
        QRcode::png($qrcodeData, $qrPath, $errorCorrectionLevel, $matrixPointSize, 2);

        $qrSrc = "tmp/" . basename($qrPath);
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
							<td><span class="price">Rp <?php echo $ticketCostNum;?></span></td>
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
							<td colspan="2" style="font-weight:bold; font-size:12px">CS : <?php echo $formatted_cs;?></td>
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
