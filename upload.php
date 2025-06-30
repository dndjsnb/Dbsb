<?php
$upload_dir = 'files/';
$allowed_types = ['pdf', 'doc', 'docx', 'zip', 'rar', 'jpg', 'jpeg', 'png', 'gif'];
$max_size = 10 * 1024 * 1024; // 10MB

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $target_file = $upload_dir . basename($_FILES["fileToUpload"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;
    
    // Validasi file
    if (file_exists($target_file)) {
        die("Maaf, file sudah ada.");
    }
    
    if (!in_array($fileType, $allowed_types)) {
        die("Maaf, hanya file " . implode(', ', $allowed_types) . " yang diperbolehkan.");
    }
    
    if ($_FILES["fileToUpload"]["size"] > $max_size) {
        die("Maaf, ukuran file terlalu besar. Maksimal 10MB.");
    }
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "File ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " berhasil diupload.";
    } else {
        echo "Maaf, terjadi error saat mengupload file.";
    }
} else {
    echo "Permintaan tidak valid.";
}
?>