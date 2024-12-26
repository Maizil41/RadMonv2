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
<title> <?php echo $timestamp ?> </title>
<style>
  .barcode {
    height: 0.88em;
    width: 0;
    box-shadow: 1px 0 0 1px #343434, 5px 0 0 1px #343434, 10px 0 0 1px #343434, 11px 0 0 1px #343434, 15px 0 0 1px #343434, 18px 0 0 1px #343434, 22px 0 0 1px #343434, 23px 0 0 1px #343434, 26px 0 0 1px #343434, 30px 0 0 1px #343434, 35px 0 0 1px #343434, 37px 0 0 1px #343434, 41px 0 0 1px #343434, 44px 0 0 1px #343434, 47px 0 0 1px #343434, 51px 0 0 1px #343434, 56px 0 0 1px #343434, 59px 0 0 1px #343434, 64px 0 0 1px #343434, 68px 0 0 1px #343434, 72px 0 0 1px #343434, 74px 0 0 1px #343434, 77px 0 0 1px #343434, 81px 0 0 1px #343434;
  }
</style>
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
				<?php echo $color ?>">Rp. <?= $ticketCost; ?> </div>
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
<?php } } ?> 