<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadDir = 'uploads/'; // Change this to your preferred directory
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);  // Create the directory if it doesn't exist
    }

    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $targetFile = $uploadDir . $fileName;
    
  
    $allowedTypes = ['xlsx', 'xls', 'csv'];
    $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    if (!in_array($fileExtension, $allowedTypes)) {
        echo 'Invalid file type. Only Excel and CSV files are allowed.';
        exit;
    }

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        echo 'File uploaded successfully!';
    } else {
        echo 'File upload failed.';
    }
} else {
    echo 'No file was uploaded.';
}
?>
