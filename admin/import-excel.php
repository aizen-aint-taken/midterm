<?php
session_start();
include("../config/conn.php");
require '../vendor-import-excel/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Initialize session variables for messages
if (!isset($_SESSION['success'])) $_SESSION['success'] = [];
if (!isset($_SESSION['exists'])) $_SESSION['exists'] = [];
if (!isset($_SESSION['error'])) $_SESSION['error'] = [];

if (isset($_POST['import'])) {
    $fileName = $_FILES['books']['name'];
    $fileTmp = $_FILES['books']['tmp_name'];
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

    // Validate file type (only Excel files allowed)
    if (!in_array($fileType, ['xlsx', 'xls'])) {
        $_SESSION['error'][] = "Invalid file type. Please upload an Excel file.";
        header('location:index.php');
        exit;
    }

    try {
        // Load the Excel file
        $spreadsheet = IOFactory::load($fileTmp);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Fetch existing books to check for duplicates
        $existingBooks = [];
        $result = $conn->query("SELECT Title, Author FROM books");
        while ($book = $result->fetch_assoc()) {
            $existingBooks[$book['Title'] . "|" . $book['Author']] = true;
        }

        // sulod og data
        $values = [];
        $placeholders = [];

        foreach ($rows as $row) {
            [$title, $author, $publisher, $sourceOfAcquisition, $publishDate, $language, $stock] = $row;

            // Validate data
            if (empty($title) || empty($author) || empty($publisher) || empty($sourceOfAcquisition) || empty($publishDate) || empty($language) || !is_numeric($stock)) {
                $_SESSION['error'][] = "Invalid data in row: " . implode(", ", $row);
                continue;
            }

            // Validate date format
            try {
                $date = new DateTime($publishDate);
                $publishDate = $date->format('Y-m-d');
            } catch (Exception $e) {
                $_SESSION['error'][] = "Invalid date format in row: " . implode(", ", $row);
                continue;
            }

            // Check for duplicates
            $key = $title . "|" . $author;
            if (isset($existingBooks[$key])) {
                $_SESSION['exists'][] = "Book already exists: " . $title;
                continue;
            }

            // Add values for insertion
            $values = array_merge($values, [$title, $author, $publisher, $sourceOfAcquisition, $publishDate, $language, $stock]);
            $placeholders[] = "(?, ?, ?, ?, ?, ?, ?)";
        }

        // Insert new books into the database
        if (!empty($placeholders)) {
            $sql = "INSERT INTO `books` (`Title`, `Author`, `Publisher`, `Source of Acquisition`, `PublishedDate`, `Language`, `Stock`) VALUES " . implode(", ", $placeholders);
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(str_repeat('s', count($values)), ...$values);

            if ($stmt->execute()) {
                $_SESSION['success'][] = "Books imported successfully.";

                // Reset AUTO_INCREMENT value
                $result = $conn->query("SELECT MAX(id) AS max_id FROM books");
                $row = $result->fetch_assoc();
                $maxId = $row['max_id'];
                $conn->query("ALTER TABLE books AUTO_INCREMENT = " . ($maxId + 1));
            } else {
                $_SESSION['error'][] = "Error: " . $stmt->error;
            }
        }

        header('location:index.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['error'][] = "Error loading file: " . $e->getMessage();
        header('location:index.php');
        exit;
    }
}
