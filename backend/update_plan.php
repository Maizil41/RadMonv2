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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updatebillplans']) && $_POST['updatebillplans'] === 'top') {
    try {

        $pdo = get_db_connection();
        if (!$pdo) {
            throw new Exception('Database connection failed');
        }
        
        $pdo->beginTransaction();

        $planName = isset($_POST['planName']) ? trim($_POST['planName']) : '';
        $planCode = isset($_POST['planCode']) ? trim($_POST['planCode']) : '';
        $planCost = isset($_POST['planCost']) ? trim($_POST['planCost']) : '';
        $planTimeBank = isset($_POST['planTimeBank']) ? trim($_POST['planTimeBank']) : '';
        $durasi = isset($_POST['profileTimeBank']) ? trim($_POST['profileTimeBank']) : '';
        $timeout = isset($_POST['idleTimeout']) ? trim($_POST['idleTimeout']) : '';
        $shared = isset($_POST['shared']) ? trim($_POST['shared']) : '';
        $down = isset($_POST['rate_down']) ? trim($_POST['rate_down']) : '';
        $up = isset($_POST['rate_up']) ? trim($_POST['rate_up']) : '';
        $bw = isset($_POST['dataLimit']) ? trim($_POST['dataLimit']) : '';
        $bw_id = isset($_POST['bw_id']) ? trim($_POST['bw_id']) : '';

        if (empty($planName)) {
            throw new Exception('Plan name cannot be empty.');
        }

        $stmt = $pdo->prepare("UPDATE billing_plans SET 
            planCode = :planCode,
            planCost = :planCost,
            planTimeBank = :planTimeBank,
            updatedate = :updatedate,
            updateby = :updateby
        WHERE planName = :planName");
        
        $now = new DateTime();
        $timestamp = $now->format('Y-m-d H:i:s');
        $updateby = 'radmon';
        
        $stmt->bindParam(':planCode', $planCode);
        $stmt->bindParam(':planCost', $planCost);
        $stmt->bindParam(':planTimeBank', $planTimeBank);
        $stmt->bindParam(':updatedate', $timestamp);
        $stmt->bindParam(':updateby', $updateby);
        $stmt->bindParam(':planName', $planName);
        
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM radgroupcheck WHERE groupname = :planName");
        $stmt->bindParam(':planName', $planName);
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM radgroupreply WHERE groupname = :planName");
        $stmt->bindParam(':planName', $planName);
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM radgroupbw WHERE groupname = :planName");
        $stmt->bindParam(':planName', $planName);
        $stmt->execute();

        $query_check = "INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES ";
        $params_check = [];
        $values_check = [];

        $values_check[] = "(?, 'Auth-Type', ':=', 'Accept')";
        $params_check[] = $planName;

        if (!empty($durasi)) {
            $values_check[] = "(?, 'Max-All-Session', ':=', ?)";
            $params_check[] = $planName;
            $params_check[] = $durasi;
        }

        if (!empty($shared)) {
            $values_check[] = "(?, 'Simultaneous-Use', ':=', ?)";
            $params_check[] = $planName;
            $params_check[] = $shared;
        }

        if (!empty($values_check)) {
            $query_check .= implode(", ", $values_check);
            $stmt = $pdo->prepare($query_check);
            $stmt->execute($params_check);
        }

        $query_reply = "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ";
        $params_reply = [];
        $values_reply = [];

        if (!empty($down)) {
            $values_reply[] = "(?, 'WISPr-Bandwidth-Max-Down', ':=', ?)";
            $params_reply[] = $planName;
            $params_reply[] = $down;
        }

        if (!empty($up)) {
            $values_reply[] = "(?, 'WISPr-Bandwidth-Max-Up', ':=', ?)";
            $params_reply[] = $planName;
            $params_reply[] = $up;
        }

        if (!empty($bw)) {
            $values_reply[] = "(?, 'ChilliSpot-Max-Total-Octets', ':=', ?)";
            $params_reply[] = $planName;
            $params_reply[] = $bw;
        }
        
        if (!empty($timeout)) {
            $values_reply[] = "(?, 'Idle-Timeout', ':=', ?)";
            $params_reply[] = $planName;
            $params_reply[] = $timeout;
        }

        $values_reply[] = "(?, 'Acct-Interim-Interval', ':=', '60')";
        $params_reply[] = $planName;

        if (!empty($values_reply)) {
            $query_reply .= implode(", ", $values_reply);
            $stmt = $pdo->prepare($query_reply);
            $stmt->execute($params_reply);
        }

        if (!empty($bw_id)) {
            $stmt = $pdo->prepare("INSERT INTO radgroupbw (groupname, bw_id) VALUES (:planName, :bw_id)");
            $stmt->bindParam(':planName', $planName);
            $stmt->bindParam(':bw_id', $bw_id);
            $stmt->execute();
        }
        
        if (!empty($planTimeBank)) {
            $stmt = $pdo->prepare("INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES (:planName, 'Access-Period', ':=', :planTimeBank)");
            $stmt->bindParam(':planName', $planName);
            $stmt->bindParam(':planTimeBank', $planTimeBank);
            $stmt->execute();
        }

        $pdo->commit();

        header('Location: ../hotspot/profile.php');
        exit();
        
    } catch (Exception $e) {

        $pdo->rollBack();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>
