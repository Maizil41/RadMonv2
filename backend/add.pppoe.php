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
require_once '../config/mysqli_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $client_name = isset($_POST['clientName']) ? trim($_POST['clientName']) : '';
    $ip_address = $_POST['ip_address'];
    $plan_name = isset($_POST['planName']) ? trim($_POST['planName']) : '';
    $now = date('Y-m-d H:i:s');
    $iprange = $ip_address . "-" . $ip_address;
    
    if (!empty($ip_address)) {
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM radreply WHERE value = ?");
        $check_stmt->bind_param("s", $ip_address);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count > 0) {
            $message = urlencode("❌ IP Address already exists.");
            header('Location: ../pppoe/add_account.php?message=' . $message);
            exit();
        
            }
        }

    # $stmt = $conn->prepare("SELECT r.bw_id, b.rate_down, b.rate_up 
    #                         FROM radgroupbw r
    #                         JOIN bandwidth b ON r.bw_id = b.id 
    #                         WHERE r.groupname = ?");
    # $stmt->bind_param("s", $plan_name);
    # $stmt->execute();
    # $stmt->bind_result($bw_id, $rate_down, $rate_up);

    # if ($stmt->fetch()) {
    #     $dspeed = number_format(($rate_down / 1048576) * 125) . "kb/s";
    #     $uspeed = number_format(($rate_up / 1048576) * 125) . "kb/s";

    #     $stmt->close();
    # }
    
    if (!empty($username)) {
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM radcheck WHERE username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count > 0) {
            $message = urlencode("❌ Username already exists.");
            header('Location: ../pppoe/add_account.php?message=' . $message);
            exit();
        } else {
            try {
                $conn->begin_transaction();

                if (isset($_POST['addUser']) && $_POST['addUser'] == 'top') {
                    $stmt = $conn->prepare("INSERT INTO radcheck (username, attribute, op, value) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $username, $attribute, $op, $value);
                    $attribute = "Cleartext-Password";
                    $op = ":=";
                    $value = "$password";
                    $stmt->execute();
                    $stmt->close();
                    
                    $stmt = $conn->prepare("INSERT INTO radreply (username, attribute, op, value) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $username, $attribute, $op, $value);
                    $attribute = "Framed-IP-Address";
                    $op = "=";
                    $value = "$ip_address";
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $conn->prepare("INSERT INTO radusergroup (username, groupname, priority) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $username, $plan_name, $priority);
                    $priority = "0";
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $conn->prepare("INSERT INTO userinfo (username, firstname, lastname, email, department, company, workphone, homephone, mobilephone, address, city, state, country, zip, notes, changeuserinfo, portalloginpassword, creationdate, creationby) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssssssssssssss", $username, $client_name, $lastname, $email, $department, $company, $workphone, $homephone, $client_phone, $address, $city, $state, $country, $zip, $notes, $changeuserinfo, $portalloginpassword, $now, $creationby);
                    $lastname = '';
                    $email = '';
                    $department = '';
                    $company = '';
                    $workphone = '';
                    $homephone = '';
                    $address = '';
                    $city = '';
                    $state = '';
                    $country = '';
                    $zip = '';
                    $notes = '';
                    $changeuserinfo = '0';
                    $portalloginpassword = '';
                    $creationby = 'radmon';
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $conn->prepare("INSERT INTO userbillinfo (username, planName, contactperson, company, email, phone, address, city, state, country, zip, paymentmethod, cash, creditcardname, creditcardnumber, creditcardverification, creditcardtype, creditcardexp, notes, changeuserbillinfo, lead, coupon, ordertaker, billstatus, nextinvoicedue, billdue, postalinvoice, faxinvoice, emailinvoice, creationdate, creationby) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssssssssssssssssssssssssss", $username, $plan_name, $client_name, $company, $email, $client_phone, $address, $city, $state, $country, $zip, $paymentmethod, $cash, $creditcardname, $creditcardnumber, $creditcardverification, $creditcardtype, $creditcardexp, $notes, $changeuserbillinfo, $lead, $coupon, $ordertaker, $billstatus, $nextinvoicedue, $billdue, $postalinvoice, $faxinvoice, $emailinvoice, $now, $creationby);
                    $company = '';
                    $email = '';
                    $address = '';
                    $city = '';
                    $state = '';
                    $country = '';
                    $zip = '';
                    $paymentmethod = '';
                    $cash = '';
                    $creditcardname = '';
                    $creditcardnumber = '';
                    $creditcardverification = '';
                    $creditcardtype = '';
                    $creditcardexp = '';
                    $notes = '';
                    $changeuserbillinfo = '0';
                    $lead = '';
                    $coupon = '';
                    $ordertaker = '';
                    $billstatus = '';
                    $nextinvoicedue = '0';
                    $billdue = '0';
                    $postalinvoice = '';
                    $faxinvoice = '';
                    $emailinvoice = '';
                    $creationby = 'radmon';
                    $stmt->execute();
                    $stmt->close();

                    $conn->commit();
                    
                    # shell_exec("iptables -I FORWARD -m iprange --dst-range $iprange -m hashlimit --hashlimit-above $dspeed --hashlimit-mode dstip --hashlimit-name $username -j DROP -m comment --comment $username");
                    # shell_exec("iptables -I FORWARD -m iprange --src-range $iprange -m hashlimit --hashlimit-above $uspeed --hashlimit-mode srcip --hashlimit-name $username -j DROP -m comment --comment $username");
                
                    $message = urlencode("✅ User successfully added.");
                    header('Location: ../pppoe/add_account.php?message=' . $message);
                    exit();
                }

            } catch (Exception $e) {
                $conn->rollback();
                $message = urlencode("❌ " . $e->getMessage());
                header('Location: ../pppoe/add_account.php?message=' . $message);
                exit();
            }
        }
    } else {
        $message = urlencode("❌ " . $e->getMessage());
        header('Location: ../pppoe/add_account.php?message=' . $message);
        exit();
    }

    $conn->close();
}
?>