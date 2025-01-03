<?php
include  "../config/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['author'], $_POST['publisher'], $_POST['genre'], $_POST['published_date'], $_POST['language'], $_POST['stock'])) {

    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $publisher = trim($_POST['publisher']);
    $genre = trim($_POST['genre']);
    $published_date = $_POST['published_date'];
    $language = trim($_POST['language']);
    $stock = (int)$_POST['stock'];

    
    if (empty($title) || empty($author) || empty($publisher) || empty($genre) || empty($published_date) || empty($language) || $stock < 0) {
        die("Invalid input! Please ensure all fields are filled correctly.");
    }

    try {
      
        $sql = "INSERT INTO books (Title, Author, Publisher, Genre, PublishedDate, Language, Stock) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute([$title, $author, $publisher, $genre, $published_date, $language, $stock])) {
        
            $conn->query("SET @new_id = 0;");
            $conn->query("
                UPDATE books
                SET BookID = (@new_id := @new_id + 1)
                ORDER BY BookID;
            ");

            header('Location: ../admin/index.php');
            exit;
        } else {
            throw new Exception("Failed to insert book into the database.");
        }
    } catch (Exception $e) {
        // Log and display error
        error_log($e->getMessage());
        die("An error occurred while adding the book. Please try again later.");
    }
} else {
    die("Invalid request!");
}
