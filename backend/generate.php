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
require_once '../config/pdo_db.php';

function generate_random_string($stringLength = 6, $stringType = 'number', $prefix = '') {
    $characters_num = '0123456789';
    $characters_lower = 'abcdefghijklmnopqrstuvwxyz';
    $characters_upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_string = '';

    switch ($stringType) {
        case 'num':
            $characters = $characters_num;
            break;
        case 'lower':
            $characters = $characters_lower;
            break;
        case 'upper':
            $characters = $characters_upper;
            break;
        case 'lowernum':
            $num_count = ceil($stringLength / 2);
            $char_count = $stringLength - $num_count;
            $random_string = str_shuffle(
                substr(str_shuffle($characters_lower), 0, $char_count) .
                substr(str_shuffle($characters_num), 0, $num_count)
            );
            break;
        case 'uppernum':
            $num_count = ceil($stringLength / 2);
            $char_count = $stringLength - $num_count;
            $random_string = str_shuffle(
                substr(str_shuffle($characters_upper), 0, $char_count) .
                substr(str_shuffle($characters_num), 0, $num_count)
            );
            break;
        default:
            $characters = $characters_num;
    }

    if (!empty($characters)) {
        $characters_length = strlen($characters);
        for ($i = 0; $i < $stringLength; $i++) {
            $random_string .= $characters[rand(0, $characters_length - 1)];
        }
    }

    return $prefix . $random_string;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['addBatch']) && $_POST['addBatch'] === 'top') {
        try {
            $batchName = isset($_POST['batchName']) ? trim($_POST['batchName']) : '';
            $planName = isset($_POST['planName']) ? trim($_POST['planName']) : '';
            $userCount = isset($_POST['userCount']) ? (int)$_POST['userCount'] : 0;
            $stringType = isset($_POST['stringType']) ? $_POST['stringType'] : 'number';
            $stringLength = isset($_POST['stringLength']) ? (int)$_POST['stringLength'] : 6;
            $prefix = isset($_POST['prefix']) ? $_POST['prefix'] : '';

            if (empty($batchName) || empty($planName) || $userCount <= 0) {
                throw new Exception('Batch name, plan name, and user count are required and must be valid.');
            }

            $conn = get_db_connection();
            if (!$conn) {
                throw new Exception('Database connection failed');
            }

            $conn->beginTransaction();

            $now = new DateTime();
            $timestamp = $now->format('Y-m-d H:i:s');

            $stmt = $conn->prepare("INSERT INTO batch_history (batch_name, batch_description, hotspot_id, batch_status, creationdate, creationby) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$batchName, $planName, '1', 'Pending', $timestamp, 'radmon']);
            
            $stmt = $conn->prepare("SELECT id FROM batch_history WHERE batch_name = ?");
            $stmt->execute([$batchName]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                $batch_id = $row['id'];
            } else {
                throw new Exception("Batch not found");
            }

            for ($i = 0; $i < $userCount; $i++) {
                $number = generate_random_string($stringLength, $stringType, $prefix);
                
                $now_formatted = $now->format('Y-m-d H:i:s');
                
                $stmt = $conn->prepare("INSERT INTO radcheck (username, attribute, op, value) VALUES (?, ?, ?, ?)");
                $stmt->execute([$number, 'Auth-Type', ':=', 'Accept']);
                
                $stmt = $conn->prepare("INSERT INTO radusergroup (username, groupname, priority) VALUES (?, ?, ?)");
                $stmt->execute([$number, $planName, '0']);
                
                $stmt = $conn->prepare("INSERT INTO userinfo (username, firstname, lastname, email, department, company, workphone, homephone, mobilephone, address, city, state, country, zip, notes, changeuserinfo, portalloginpassword, creationdate, creationby) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$number, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', $now_formatted, 'radmon']);
                
                $stmt = $conn->prepare("INSERT INTO userbillinfo (username, planName, contactperson, company, email, phone, address, city, state, country, zip, paymentmethod, cash, creditcardname, creditcardnumber, creditcardverification, creditcardtype, creditcardexp, notes, changeuserbillinfo, lead, coupon, ordertaker, billstatus, postalinvoice, faxinvoice, emailinvoice, batch_id, creationdate, creationby) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$number, $planName, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', $batch_id, $now_formatted, 'radmon']);
            }

            $conn->commit();
            
            header('Location: ../voucher/quick_print.php');
            exit();
            
        } catch (Exception $e) {
            if (isset($conn)) {
                $conn->rollBack();
            }
            $message = urlencode("❌ " . $e->getMessage());
            header('Location: ../hotspot/generate.php?message=' . $message);
            exit();
        }
    } else {
        $message = urlencode("❌ " . $e->getMessage());
        header('Location: ../hotspot/generate.php?message=' . $message);
        exit();
    }
}
?>
