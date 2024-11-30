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
require '../config/mysqli_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['clientName'];
    $plan_name = isset($_POST['planName']) ? trim($_POST['planName']) : '';
    $now = date('Y-m-d H:i:s');

    $code = '';
    if (isset($_POST['typebp']) && $_POST['typebp'] == 'Select') {
        $code = $_POST['macSelect'];
    } elseif (isset($_POST['typebp']) && $_POST['typebp'] == 'Manual') {
        $code = $_POST['macManual'];
        if (preg_match('/^([0-9A-Fa-f]{2}-){5}[0-9A-Fa-f]{2}$/', $code) || preg_match('/^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/', $code)) {
            $code = strtoupper(str_replace(':', '-', $code));
        } else {
            $message = urlencode("❌ Invalid Mac Type.");
            header('Location: ../hotspot/newprofile.php?message=' . $message);
            exit();
        }
    }

    if (!empty($code) && !empty($plan_name)) {
        try {
            $conn->begin_transaction();
            $stmt = $conn->prepare("SELECT username FROM radcheck WHERE username = ?");
            $stmt->bind_param("s", $code);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $message = urlencode("❌ Mac Address already exists.");
                header('Location: ../hotspot/addmac.php?message=' . $message);
                $stmt->close();
                $conn->close();
                exit();
            }
            $stmt->close();

            if (isset($_POST['addMac']) && $_POST['addMac'] == 'top') {
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
                $stmt->bind_param("sssssssssssssssssss", $code, $firstname, $lastname, $email, $department, $company, $workphone, $homephone, $mobilephone, $address, $city, $state, $country, $zip, $notes, $changeuserinfo, $portalloginpassword, $now, $creationby);
                $lastname = '';
                $email = '';
                $department = '';
                $company = '';
                $workphone = '';
                $homephone = '';
                $mobilephone = '';
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
                $stmt->bind_param("sssssssssssssssssssssssssssssss", $code, $plan_name, $contactperson, $company, $email, $phone, $address, $city, $state, $country, $zip, $paymentmethod, $cash, $creditcardname, $creditcardnumber, $creditcardverification, $creditcardtype, $creditcardexp, $notes, $changeuserbillinfo, $lead, $coupon, $ordertaker, $billstatus, $nextinvoicedue, $billdue, $postalinvoice, $faxinvoice, $emailinvoice, $now, $creationby);
                $contactperson = '';
                $company = '';
                $email = '';
                $phone = '';
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

                $message = urlencode("✅ Mac successfully added.");
                header('Location: ../hotspot/addmac.php?message=' . $message);
                exit();
            }

        } catch (Exception $e) {
            $conn->rollback();
            $message = urlencode("❌ " . $e->getMessage());
            header('Location: ../hotspot/addmac.php?message=' . $message);
            exit();
        }
    } else {
        $message = urlencode("❌ " . $e->getMessage());
        header('Location: ../hotspot/addmac.php?message=' . $message);
        exit();
    }

    $conn->close();
}
?>