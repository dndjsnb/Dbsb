<?php
$upload_dir = 'files/';

if (isset($_GET['file'])) {
    $file_name = basename($_GET['file']);
    $file_path = $upload_dir . $file_name;
    
    if (file_exists($file_path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    } else {
        die('File tidak ditemukan.');
    }
} else {
    die('Parameter file tidak valid.');
}
?>
