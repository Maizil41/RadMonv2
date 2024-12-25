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
require_once '../config/db_config.php';

$targetDir = "../backup/";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES["UploadDB"])) {
    $fileName = basename($_FILES["UploadDB"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowTypes = array('sql');

    if (in_array($fileType, $allowTypes) && $_FILES["UploadDB"]["size"] < 5 * 1024 * 1024) { // Maks 5 MB
        if (file_exists($targetFilePath)) {
            unlink($targetFilePath);
        }

        if (move_uploaded_file($_FILES["UploadDB"]["tmp_name"], $targetFilePath)) {
            header('Location: ../pages/backup.php?message=' . urlencode("✅ Success"));
        } else {
            header('Location: ../pages/backup.php?message=' . urlencode("❌ Upload failed. Please try again."));
        }
    } else {
        header('Location: ../pages/backup.php?message=' . urlencode("❌ Invalid file type or file size too large."));
    }
    exit;
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'delete' && isset($_GET['file'])) {
        $file = $targetDir . basename($_GET['file']);
        if (file_exists($file)) {
            unlink($file);
            $message = urlencode("✅ Database deleted successfully.");
        } else {
            $message = urlencode("❌ File not found.");
        }
        header('Location: ../pages/backup.php?message=' . $message);
        exit;
    }

    if ($action === 'restore' && isset($_GET['file'])) {
        $file = $targetDir . basename($_GET['file']);
        if (file_exists($file)) {
            $escapedFile = escapeshellarg($file);
            $command = "mysql --host=" . escapeshellarg($db_config['servername']) .
                       " --user=" . escapeshellarg($db_config['username']) .
                       " --password=" . escapeshellarg($db_config['password']) .
                       " " . escapeshellarg($db_config['dbname']) . 
                       " < {$escapedFile}";
            exec($command, $output, $result);
            $message = ($result === 0) ? "✅ Database restored successfully." : "❌ Restore failed.";
        } else {
            $message = "❌ File not found.";
        }
        header('Location: ../pages/backup.php?message=' . urlencode($message));
        exit;
    }

    if ($action === 'backup') {
        $date = date('Y-m-d_H-i-s');
        $backupFile = "backup_{$db_config['dbname']}_{$date}.sql";
        $command = "mysqldump --host=" . escapeshellarg($db_config['servername']) .
                   " --user=" . escapeshellarg($db_config['username']) .
                   " --password=" . escapeshellarg($db_config['password']) .
                   " " . escapeshellarg($db_config['dbname']) .
                   " > {$targetDir}{$backupFile}";
        exec($command, $output, $result);

        if ($result === 0) {
            $message = urlencode("✅ Database backup successfully.");
        } else {
            $message = urlencode("❌ Backup failed.");
        }
        header('Location: ../pages/backup.php?message=' . $message);
        exit;
    }

    if ($action === 'download' && isset($_GET['file'])) { 
        $file = $targetDir . basename($_GET['file']);
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        } else {
            $message = urlencode("❌ File not found.");
        }
        header('Location: ../pages/backup.php?message=' . $message);
        exit;
    }
}
?>