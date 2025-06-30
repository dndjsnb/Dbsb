<?php
header('Content-Type: application/json');

$upload_dir = 'files/';
$files = [];

if (is_dir($upload_dir)) {
    if ($dh = opendir($upload_dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' && $file != '..') {
                $file_path = $upload_dir . $file;
                $file_size = filesize($file_path);
                $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);
                
                $files[] = [
                    'name' => $file,
                    'ext' => $file_ext,
                    'size' => formatSizeUnits($file_size)
                ];
            }
        }
        closedir($dh);
    }
}

echo json_encode($files);

function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}
?>
