<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

include '../config/conn.php';

// $oneal = "gae";
// echo $oneal;

$sql_users = "SELECT users.name, COUNT(books.BookId) AS total_books 
              FROM users 
              LEFT JOIN books ON users.id = books.BookId 
              GROUP BY users.id";

$sql_books = "SELECT Title, Stock FROM books";



$result_users = $conn->query($sql_users);
$result_books = $conn->query($sql_books);

$data = [
    "users" => [],
    "books" => []
];

while ($row = $result_users->fetch_assoc()) {
    $data["users"][] = $row;
}


while ($row = $result_books->fetch_assoc()) {
    $data["books"][] = $row;
}

echo json_encode($data);
$conn->close();
