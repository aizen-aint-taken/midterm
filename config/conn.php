<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'library_inventory';


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}
?>
