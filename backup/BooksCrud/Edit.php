<?php
include  "../config/conn.php";

if (isset($_POST['editBook']) && $_POST['editBook'] == 1) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $genre = $_POST['genre'];
    $published_date = $_POST['published_date'];
    $language = $_POST['language'];
    $stock = $_POST['stock'];

    $stmt = $conn->prepare("UPDATE books SET Title = ?, Author = ?, Publisher = ?, Genre = ?, PublishedDate = ?, Language = ?, Stock = ? WHERE BookID = ?");
    $stmt->execute([$title, $author, $publisher, $genre, $published_date, $language, $stock, $id]);

    header("Location: ../admin/index.php");
}
