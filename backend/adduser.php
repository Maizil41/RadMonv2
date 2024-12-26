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
    $code = $_POST['username'];
    $plan_name = isset($_POST['planName']) ? trim($_POST['planName']) : '';
    $client_name = isset($_POST['clientName']) ? trim($_POST['clientName']) : '';
    $client_phone = isset($_POST['Whatsapp_number']) && !empty(trim($_POST['Whatsapp_number'])) ? '62' . trim($_POST['Whatsapp_number']) : '';
    $now = date('Y-m-d H:i:s');

    if (!empty($code)) {
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM radcheck WHERE username = ?");
        $check_stmt->bind_param("s", $code);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count > 0) {
            $message = urlencode("❌ Username already exists.");
            header('Location: ../hotspot/adduser.php?message=' . $message);
            exit();
        } else {
            try {
                
                $conn->begin_transaction();

                if (isset($_POST['addUser']) && $_POST['addUser'] == 'top') {
                    $stmt = $conn->prepare("INSERT INTO radcheck (username, attribute, op, value) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $code, $attribute, $op, $value);
                    $attribute = "Auth-Type";
                    $op = ":=";
                    $value = "Accept";
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $conn->prepare("INSERT INTO radusergroup (username, groupname, priority) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $code, $plan_name, $priority);
                    $priority = "0";
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $conn->prepare("INSERT INTO userinfo (username, firstname, lastname, email, department, company, workphone, homephone, mobilephone, address, city, state, country, zip, notes, changeuserinfo, portalloginpassword, creationdate, creationby) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssssssssssssss", $code, $client_name, $lastname, $email, $department, $company, $workphone, $homephone, $client_phone, $address, $city, $state, $country, $zip, $notes, $changeuserinfo, $portalloginpassword, $now, $creationby);
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
                    $stmt->bind_param("sssssssssssssssssssssssssssssss", $code, $plan_name, $client_name, $company, $email, $client_phone, $address, $city, $state, $country, $zip, $paymentmethod, $cash, $creditcardname, $creditcardnumber, $creditcardverification, $creditcardtype, $creditcardexp, $notes, $changeuserbillinfo, $lead, $coupon, $ordertaker, $billstatus, $nextinvoicedue, $billdue, $postalinvoice, $faxinvoice, $emailinvoice, $now, $creationby);
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
                    
                    $message = urlencode("✅ User successfully added.");
                    header('Location: ../hotspot/adduser.php?message=' . $message);
                    exit();
                }

            } catch (Exception $e) {
                $conn->rollback();
                $message = urlencode("❌ " . $e->getMessage());
                header('Location: ../hotspot/adduser.php?message=' . $message);
                exit();
            }
        }
    } else {
        $message = urlencode("❌ " . $e->getMessage());
        header('Location: ../hotspot/adduser.php?message=' . $message);
        exit();
    }

    $conn->close();
}
?>