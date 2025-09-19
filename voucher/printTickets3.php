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

    echo "<title>".esc($timestamp)."</title>\n";
    echo '<style type="text/css">
    .barcode {
      height: 0.88em;
      width: 0;
      box-shadow: 1px 0 0 1px #343434, 5px 0 0 1px #343434, 10px 0 0 1px #343434, 11px 0 0 1px #343434, 15px 0 0 1px #343434, 18px 0 0 1px #343434, 22px 0 0 1px #343434, 23px 0 0 1px #343434, 26px 0 0 1px #343434, 30px 0 0 1px #343434, 35px 0 0 1px #343434, 37px 0 0 1px #343434, 41px 0 0 1px #343434, 44px 0 0 1px #343434, 47px 0 0 1px #343434, 51px 0 0 1px #343434, 56px 0 0 1px #343434, 59px 0 0 1px #343434, 64px 0 0 1px #343434, 68px 0 0 1px #343434, 72px 0 0 1px #343434, 74px 0 0 1px #343434, 77px 0 0 1px #343434, 81px 0 0 1px #343434;
    }
    </style>';

    foreach ($accounts as $userpass) {
        [$user, $pass] = array_pad(explode(",", $userpass, 2), 2, '');

        $qrcodeData = buildQrData($hsqrmode, $hsipdomain, $hsip, $hsdomain, $user, $pass);

        $qrName = safeFileName($user) . ".png";
        $qrPath = $tempdir . $qrName;
        QRcode::png($qrcodeData, $qrPath, $errorCorrectionLevel, $matrixPointSize, 2);

        $qrSrc = "tmp/" . basename($qrPath);
?>
<table style="display: inline-block;border-collapse: collapse;border: 1px solid #666;margin: 2.5px;width: 190px;overflow:hidden;position:relative;padding: 1px;margin: 0px;border: 1px solid #444; background:; ">
  <tbody>
    <tr>
      <td style="background:
				<?php echo $color ?>;color:#666;padding:0px;" valign="top" colspan="2">
        <div style="text-align:center;color:#fff;font-size:10px;font-weight:bold;margin:1px;padding:2.5px;">
          <b>LAYANAN INTERNET BEBAS KUOTA</b>
        </div>
      </td>
    <tr>
      <td style="color:#666;" valign="top">
        <table style="width:100%;">
          <tbody>
            <tr>
            <tr>
              <td style="width:75px">
                <div style="position:relative;z-index:-1;padding: 0px;float:left;">
                  <div style="position:absolute;top:0;display:inline;margin-top:-100px;width: 0; height: 0; border-top: 230px solid transparent;border-left: 50px solid transparent;border-right:140px solid #DCDCDC; "></div>
                </div>
                </div>
                <?php if ($logomode == "text"): ?>
               <span style="font-size: 13.5px;font-weight: bold;"><?php echo $hsname1; ?><span style="color:<?php echo $color; ?>;"><?php echo $hsname2; ?>
              <?php elseif ($logomode == "image"): ?>
              <img src="../img/logo/radmon-logo.png" alt="logo" style="height: 25px; width: 100px; border: 0;">
              <?php endif; ?>
              </td>
              <td style="width:115px">
                <div style="float:right;margin-top:-6px;margin-right:0px;width:5%;text-align:right;font-size:7px;"></div>
                <div style="margin:-10px;text-align:right;font-weight:bold;font-size:16px;padding-left:20px;color:
				<?php echo $color ?>">Rp. <?= $ticketCostNum; ?> </div>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td style="color:#666;border-collapse: collapse;" valign="top">
        <table style="width:100%;border-collapse: collapse;">
          <tbody>
            <tr>
              <td style="width:95px" valign="top">
                <div style="clear:both;color:#555;margin-top:5px;margin-bottom:2.5px;">
                  <div style="padding:0px;border-bottom:1px solid;text-align:center;font-weight:bold;font-size:9px;color:#444">𝘒𝘖𝘋𝘌 𝘝𝘖𝘜𝘊𝘏𝘌𝘙</div>
                  <div style="padding:0px;border-bottom:1px solid;text-align:center;font-weight:bold;font-size:14px;color:
					<?php echo $color ?>"> <?php echo $user;?> </div>
                </div>
                <div style="text-align:center;color:#111;font-size:8px;font-weight:bold;margin:0px;padding:2.5px;"> Hubungkan Ke Jaringan <?= $hsname1.$hsname2; ?> Buka Browser Ketik: <?= $hsip; ?> </div>
              </td>
              <p style=" margin-top:-10px;margin-bottom:0px">
                <td style="width:100px;text-align:right;">
                  <div style="clear:both;padding:0 2.5px;font-size:7px;font-weight:bold;color:#000000">
                    <div style="margin:2px;text-align:right;font-weight:bold;font-size:10px;padding-left:5px;color:
					    <?php echo $color ?>">Berlaku : <?= $ticketTime; ?> </div> <?php
                        $tempdir = "tmp/";

                        if (!file_exists($tempdir)) {
                            mkdir($tempdir, 0777, true);
                        }

                        if($hsqrmode == "code") {
                            $qrcodeData = "$user";
                        } elseif ($hsqrmode == "url") {
                            if($hsipdomain == "ip") {
                                $qrcodeData = "http://$hsip:3990/login?username=$user&password=$pass";
                            } elseif ($hsipdomain == "domain") {
                                $qrcodeData = "http://$hsdomain:3990/login?username=$user&password=$pass";
                            }
                        }

                        $errorCorrectionLevel = "L";
                        $matrixPointSize = 4;

                        QRcode::png($qrcodeData, $tempdir . $user . ".png", $errorCorrectionLevel, $matrixPointSize, 2);
                        ?> <img src="
						<?php echo ($tempdir.$user . '.png');?>" <img style="border: 1px 
					<?php echo $color ?> solid; border-radius: 5px; solid  #444;width:65px;height:65x;" </div>
                </td>
                    </tr>
                        <tr>
                    <td>
                <div class='barcode'></div>
                    <td style="background:
				    <?php echo $color ?>; colspan=" 2">
                    <div style="text-align:right;color:#fff;font-size:11px;font-weight:bold;margin:1px;padding:2px;">
                  <b>
                    <center>Paket : <?= $ticketActiveTime; ?>
                  </b>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<?php
    }
}
?>