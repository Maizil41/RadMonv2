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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $timeout = isset($_POST['idleTimeout']) ? trim($_POST['idleTimeout']) : '';

        $durasi = isset($_POST['profileTimeBank']) ? trim($_POST['profileTimeBank']) : '';
        $shared = isset($_POST['shared']) ? trim($_POST['shared']) : '';
        $down = isset($_POST['rate_down']) ? trim($_POST['rate_down']) : '';
        $up = isset($_POST['rate_up']) ? trim($_POST['rate_up']) : '';
        $bw = isset($_POST['dataLimit']) ? trim($_POST['dataLimit']) : '';
        $bw_name = isset($_POST['bw_name']) ? trim($_POST['bw_name']) : '';
        $bw_id = isset($_POST['bw_id']) ? trim($_POST['bw_id']) : '';
        
        $profileType = isset($_POST['typebp']) ? trim($_POST['typebp']) : '';
        $limitType = isset($_POST['limit_type']) ? trim($_POST['limit_type']) : '';
        
        if ($profileType === 'Unlimited') {
            $planTimeBank = '';
            $durasi = '';
            $bw = '';
        } elseif ($profileType === 'Limited') {
            if ($limitType === 'Time_Limit') {
                $bw = '';
            } elseif ($limitType === 'Data_Limit') {
                $planTimeBank = '';
                $durasi = '';
            }
        }
        
        if (empty($planName)) {
            throw new Exception('Plan name cannot be empty.');
        }

        $sql = "
            SELECT COUNT(*) FROM (
                SELECT 1 FROM billing_plans WHERE planName = ?
                UNION ALL
                SELECT 1 FROM radgroupcheck WHERE groupname = ?
                UNION ALL
                SELECT 1 FROM radgroupreply WHERE groupname = ?
            ) AS combined";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$planName, $planName, $planName]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $message = urlencode("❌ Profile Name already exists.");
            header('Location: ../hotspot/newprofile.php?message=' . $message);
            exit();
        }

        $planType = 'Prepaid';
        $planTimeType = 'Accumulative';
        $planTimeRefillCost = '';
        $planBandwidthUp = '';
        $planBandwidthDown = '';
        $planTrafficTotal = '';
        $planTrafficUp = '';
        $planTrafficDown = '';
        $planTrafficRefillCost = '';
        $planRecurring = 'No';
        $planRecurringPeriod = 'Never';
        $planRecurringBillingSchedule = 'Fixed';
        $planSetupCost = '';
        $planTax = '';
        $planCurrency = '';
        $planGroup = '';
        $planActive = 'yes';
        $creationby = 'radmon';
        $updateby = 'radmon';
        $now = new DateTime();
        $timestamp = $now->format('Y-m-d H:i:s');

        $stmt = $pdo->prepare("INSERT INTO billing_plans (
            id, planName, planId, planType, planTimeBank, planTimeType, planTimeRefillCost, 
            planBandwidthUp, planBandwidthDown, planTrafficTotal, planTrafficUp, planTrafficDown, 
            planTrafficRefillCost, planRecurring, planRecurringPeriod, planRecurringBillingSchedule, 
            planCost, planSetupCost, planTax, planCurrency, planGroup, planActive, creationdate, 
            creationby, updatedate, updateby, planCode
        ) VALUES (
            NULL, :planName, :planId, :planType, :planTimeBank, :planTimeType, :planTimeRefillCost, 
            :planBandwidthUp, :planBandwidthDown, :planTrafficTotal, :planTrafficUp, :planTrafficDown, 
            :planTrafficRefillCost, :planRecurring, :planRecurringPeriod, :planRecurringBillingSchedule, 
            :planCost, :planSetupCost, :planTax, :planCurrency, :planGroup, :planActive, :creationdate, 
            :creationby, :updatedate, :updateby, :planCode
        )");

        $stmt->bindParam(':planName', $planName);
        $stmt->bindParam(':planId', $planName);
        $stmt->bindParam(':planType', $planType);
        $stmt->bindParam(':planTimeBank', $planTimeBank);
        $stmt->bindParam(':planTimeType', $planTimeType);
        $stmt->bindParam(':planTimeRefillCost', $planTimeRefillCost);
        $stmt->bindParam(':planBandwidthUp', $planBandwidthUp);
        $stmt->bindParam(':planBandwidthDown', $planBandwidthDown);
        $stmt->bindParam(':planTrafficTotal', $planTrafficTotal);
        $stmt->bindParam(':planTrafficUp', $planTrafficUp);
        $stmt->bindParam(':planTrafficDown', $planTrafficDown);
        $stmt->bindParam(':planTrafficRefillCost', $planTrafficRefillCost);
        $stmt->bindParam(':planRecurring', $planRecurring);
        $stmt->bindParam(':planRecurringPeriod', $planRecurringPeriod);
        $stmt->bindParam(':planRecurringBillingSchedule', $planRecurringBillingSchedule);
        $stmt->bindParam(':planCost', $planCost);
        $stmt->bindParam(':planSetupCost', $planSetupCost);
        $stmt->bindParam(':planTax', $planTax);
        $stmt->bindParam(':planCurrency', $planCurrency);
        $stmt->bindParam(':planGroup', $planGroup);
        $stmt->bindParam(':planActive', $planActive);
        $stmt->bindParam(':creationdate', $timestamp);
        $stmt->bindParam(':creationby', $creationby);
        $stmt->bindParam(':updatedate', $timestamp);
        $stmt->bindParam(':updateby', $updateby);
        $stmt->bindParam(':planCode', $planCode);

        $stmt->execute();

        $query_check = "INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES ";
        $params_check = [];
        $values_check = [];
        
        $values_check[] = "(?, 'Auth-Type', ':=', 'Accept')";
        $params_check[] = $planName;
        
        if (!empty($planTimeBank)) {
            $stmt = $pdo->prepare("INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES (:planName, 'Access-Period', ':=', :planTimeBank)");
            $stmt->bindParam(':planName', $planName);
            $stmt->bindParam(':planTimeBank', $planTimeBank);
            $stmt->execute();
        }

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
        
        if (!empty($bw_id)) {
            $query_bw = "INSERT INTO radgroupbw (groupname, bw_id) VALUES (?, ?)";
            $stmt = $pdo->prepare($query_bw);
            $stmt->execute([$planName, $bw_id]);
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

        $pdo->commit();

        $message = urlencode("✅ Profile successfully added.");
        header('Location: ../hotspot/newprofile.php?message=' . $message);
        exit();
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = urlencode("❌ " . $e->getMessage());
        header('Location: ../hotspot/newprofile.php?message=' . $message);
        exit();
    }
}
?>