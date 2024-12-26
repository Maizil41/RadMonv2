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

header('Content-Type: application/json');

$targetDir = "../img/logo/";

$response = [
    'status' => 'error',
    'message' => 'Invalid request.'
];

function formatSize($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } else {
        $bytes = $bytes . ' bytes';
    }
    return $bytes;
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES["UploadLogo"])) {
        $fileName = basename($_FILES["UploadLogo"]["name"]);
        $newFileName = "radmon-logo.png";
        $targetFilePath = $targetDir . $newFileName;
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowTypes = ['jpg', 'jpeg', 'png'];

        if (in_array($fileType, $allowTypes)) {
            if (file_exists($targetFilePath)) {
                unlink($targetFilePath);
            }

            if (move_uploaded_file($_FILES["UploadLogo"]["tmp_name"], $targetFilePath)) {
                $response['status'] = 'success';
                $response['message'] = '✅ Upload successful.';
            } else {
                $response['message'] = '❌ Upload failed. Please try again.';
            }
        } else {
            $response['message'] = 'Invalid file type or file size too large.';
        }
    } elseif (isset($_GET['action'])) {
        $action = $_GET['action'];
        if ($action === 'delete' && isset($_GET['file'])) {
            $file = $targetDir . basename($_GET['file']);
            if (file_exists($file)) {
                unlink($file);
                $response['status'] = 'success';
                $response['message'] = '✅ Logo deleted successfully.';
            } else {
                $response['message'] = '❌ File not found.';
            }
        } elseif ($action === 'download' && isset($_GET['file'])) { 
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
                $response['message'] = '❌ File not found.';
            }
        } elseif ($action === 'list') {
            $directory = '../img/logo/';
            $files = array_diff(scandir($directory), array('.', '..'));
            $files = array_reverse($files);
            $fileList = [];

            if (empty($files)) {
                $response['status'] = 'error';
                $response['message'] = '❌ No Logo files found.';
            } else {
                foreach ($files as $file) {
                    $filePath = $directory . $file;
                    if (is_file($filePath)) {
                        $fileList[] = [
                            'name' => $file,
                            'size' => formatSize(filesize($filePath))
                        ];
                    }
                }

                $response['status'] = 'success';
                $response['files'] = $fileList;
            }
        }
    }
} catch (Exception $e) {
    $response['message'] = 'An error occurred: ' . $e->getMessage();
}

echo json_encode($response);
exit;
