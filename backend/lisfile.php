<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'list') {
    $directory = '../backup/';
    $files = array_diff(scandir($directory), array('.', '..'));
    $fileList = [];

    foreach ($files as $file) {
        $filePath = $directory . $file;
        if (is_file($filePath)) {
            $fileList[] = [
                'name' => $file,
                'size' => filesize($filePath)
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'files' => $fileList
    ]);
    exit;
}
?>
