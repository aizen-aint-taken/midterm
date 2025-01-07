<?php
include "../config/conn.php";
require '../vendor/autoload.php';

use PhpMqtt\Client\MqttClient;

// Validate input
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['author'], $_POST['publisher'], $_POST['genre'], $_POST['published_date'], $_POST['language'], $_POST['stock'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $publisher = trim($_POST['publisher']);
    $genre = trim($_POST['genre']);
    $published_date = trim($_POST['published_date']);
    $language = trim($_POST['language']);
    $stock = (int)$_POST['stock'];

    // Ensure all fields are valid
    if (empty($title) || empty($author) || empty($publisher) || empty($genre) || empty($published_date) || empty($language) || $stock < 0) {
        die("Invalid input! Please ensure all fields are filled correctly.");
    }

    try {
        // Insert into database
        $sql = "INSERT INTO books (Title, Author, Publisher, Genre, PublishedDate, Language, Stock) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute([$title, $author, $publisher, $genre, $published_date, $language, $stock])) {
            // Reorganize BookID sequence
            $conn->query("SET @new_id = 0;");
            $conn->query("
                UPDATE books
                SET BookID = (@new_id := @new_id + 1)
                ORDER BY BookID;
            ");

            // MQTT Logic
            $config = include('../config/mqtt.php');
            $mqtt = new MqttClient($config['host'], $config['port'], $config['client_id']);

            try {
                $mqtt->connect($config['username'], $config['password']);

                // Prepare MQTT message
                $topic = 'books/inventory';
                $message = json_encode([
                    'action' => 'add',
                    'title' => $title,
                    'author' => $author,
                ]);

                $mqtt->publish($topic, $message, 0); // QoS 0
                $mqtt->disconnect();
            } catch (\PhpMqtt\Client\Exceptions\MqttClientException $e) {
                error_log('MQTT Error: ' . $e->getMessage());
            }

            // Redirect after successful operation
            header('Location: ../admin/index.php');
            exit;
        } else {
            throw new Exception("Failed to insert book into the database.");
        }
    } catch (Exception $e) {
        // Log error and display user-friendly message
        error_log($e->getMessage());
        die("An error occurred while adding the book. Please try again later.");
    }
} else {
    die("Invalid request!");
}
