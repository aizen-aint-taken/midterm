<?php
session_start();
include("../config/conn.php");
require '../vendor-import-excel/autoload.php';


// my revision
use PhpOffice\PhpSpreadsheet\IOFactory;

if (!isset($_SESSION['success'])) $_SESSION['success'] = [];
if (!isset($_SESSION['exists'])) $_SESSION['exists'] = [];
if (!isset($_SESSION['error'])) $_SESSION['error'] = [];

if (isset($_POST['import'])) {
    $fileName = $_FILES['books']['name'];
    $fileTmp = $_FILES['books']['tmp_name'];
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

    // excel file type validation
    if (!in_array($fileType, ['xlsx', 'xls'])) {
        $_SESSION['error'][] = "Invalid file type. Please upload an Excel file.";
        header('location:index.php');
        exit;
    }

    try {
        $spreedsheet = IOFactory::load($fileTmp);
        $worksheet = $spreedsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Fetch existing para i check if duplicated sya
        $existingBooks = [];
        $result = $conn->query("SELECT Title, Author FROM books");
        while ($book = $result->fetch_assoc()) {
            $existingBooks[$book['Title'] . "|" . $book['Author']] = true;
        }

        $values = [];
        $placeholders = [];
        foreach ($rows as $row) {
            [$title, $author, $publisher, $genre, $publishDate, $language, $stock] = $row;

            // Validate data
            if (empty($title) || empty($author) || empty($publisher) || empty($genre) || empty($publishDate) || empty($language) || !is_numeric($stock)) {
                $_SESSION['error'][] = "Invalid data in row: " . implode(", ", $row);
                continue;
            }

            $key = $title . "|" . $author;
            if (isset($existingBooks[$key])) {
                $_SESSION['exists'][] = "Book already exists: " . $title;
                continue;
            }

            $values = array_merge($values, [$title, $author, $publisher, $genre, $publishDate, $language, $stock]);
            $placeholders[] = "(?, ?, ?, ?, ?, ?, ?)";
        }

        // Insert og bag o na books
        if (!empty($placeholders)) {
            $sql = "INSERT INTO `books` (`Title`, `Author`, `Publisher`, `Genre`, `PublishedDate`, `Language`, `Stock`) VALUES " . implode(", ", $placeholders);
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(str_repeat('s', count($values)), ...$values);

            if ($stmt->execute()) {
                $_SESSION['success'][] = "Books imported successfully.";
            } else {
                $_SESSION['error'][] = "Error: " . $stmt->error;
            }
        }

        // Reassign sequential IDs
        $conn->query("CREATE TEMPORARY TABLE temp_books AS SELECT Title, Author, Publisher, Genre, PublishedDate, Language, Stock FROM books");
        $conn->query("TRUNCATE TABLE books");
        $conn->query("INSERT INTO books (Title, Author, Publisher, Genre, PublishedDate, Language, Stock) SELECT * FROM temp_books");
        $conn->query("DROP TEMPORARY TABLE temp_books");

        header('location:index.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['error'][] = "Error loading file: " . $e->getMessage();
        header('location:index.php');
        exit;
    }
}


// original code

// <?php
// session_start();
// include("../config/conn.php");

// require '../vendor-import-excel/autoload.php';

// use PhpOffice\PhpSpreadsheet\IOFactory;

// if (!isset($_SESSION['success'])) {
//     $_SESSION['success'] = [];
// }

// if (!isset($_SESSION['exists'])) {
//     $_SESSION['exists'] = [];
// }

// if (!isset($_SESSION['error'])) {
//     $_SESSION['error'] = [];
// }


// if (isset($_POST['import'])) {

//     $fileName = $_FILES['books']['name'];
//     $fileTmp = $_FILES['books']['tmp_name'];

//     // var_dump($fileName);

//     try {
//         $spreedsheet = IOFactory::load($fileTmp);
//         $worksheet = $spreedsheet->getActiveSheet();
//         $rows = $worksheet->toArray();

//         // var_dump($rows);

//         foreach ($rows as $row) {
//             $title = $row[0];
//             $author = $row[1];
//             $publisher = $row[2];
//             $genre = $row[3];
//             $publishDate = $row[4];
//             // subject ni sya 
//              $language = $row[5];  
//             $stock = $row[6];


//             // var_dump([
//             //     'Title' => $title,
//             //     'Author' => $author,
//             //     'Publisher' => $publisher,
//             //     'Genre' => $genre,
//             //     'PublishedDate' => $publishDate,
//             //     'Language' => $language,
//             //     'Stock' => $stock
//             // ]);

//             // Check og nang exists sa database dili na need mag import og nag exists pwede ra pamaagi sa edit
//             $books = $conn->prepare("SELECT COUNT(*) FROM books WHERE Title = ? AND Author = ?");
//             $books->bind_param('ss', $title, $author);
//             $books->execute();
//             $books->bind_result($count);
//             $books->fetch();
//             $books->close();


//             if ($count == 0) {
//                 // pag wala nag exist matix ma insert
//                 $books = $conn->prepare("INSERT INTO books (Title, Author, Publisher, Genre, PublishedDate, Language,  Stock) VALUES (?,?,?,?,?,?,?)");

//                 $books->bind_param('sssssss', $title, $author, $publisher, $genre, $publishDate, $language, $stock);
//                 // $books->execute();

//                 if (!$books->execute()) {
//                     $_SESSION['error'][] = "Error: " . $books->error;
//                 } else {
//                     $_SESSION['success'][] = "Book inserted successfully: " . $title;
//                 }
//             } else {
//                 $_SESSION['exists'][] = "Book already exists: " . $title;
//             }
//         }

//         header('location:index.php');
//         exit;
//     } catch (Exception $e) {

//         $_SESSION['error'] = "Error loading file: " . $e->getMessage();
//         header('location:index.php');
//         exit;
//     }
// }