<?php
include "../config/conn.php";

if (isset($_POST['deleteBook'])) {
    $bookId = $_POST['deleteBook'];

    try {
        $deleteQuery = $conn->prepare("DELETE FROM books WHERE BookID = ?");
        $deleteQuery->bind_param("i", $bookId);
        $deleteQuery->execute();

        $conn->query("SET @new_id = 0;");
        $conn->query("
            UPDATE books
            SET BookID = (@new_id := @new_id + 1)
            ORDER BY BookID;
        ");

        $rowCountResult = $conn->query("SELECT COUNT(*) AS total FROM books");
        $rowCount = $rowCountResult->fetch_assoc()['total'];

        if ($rowCount == 0) {
            $conn->query("ALTER TABLE books AUTO_INCREMENT = 1");
        }

        header("Location: ../admin/index.php");
        exit;
    } catch (Exception $e) {
        error_log($e->getMessage());
        die("An error occurred while deleting the book. Please try again later.");
    }
} else {
    die("Invalid request!");
}
