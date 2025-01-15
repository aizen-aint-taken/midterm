<?php


$conn = new mysqli('localhost', 'root', '', 'library_inventory');

if ($conn->connect_error) {
    die("Connection Failed!:" . $conn->connect_error);
}
