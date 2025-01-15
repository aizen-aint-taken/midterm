<?php

session_start();

require_once '../config/conn.php';

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('location: ../index.php');
    exit;
}


$subject = isset($_GET['subject']) ? $_GET['subject'] : '';

// Modify the query to filter by subject if one is selected
if ($subject) {
    $stmt = $conn->prepare("SELECT * FROM books WHERE Genre = :subject");
    $stmt->execute(['subject' => $subject]);
} else {
    $stmt = $conn->query("SELECT * FROM books");
}

$books = $stmt->fetch_all();


include('../includes/header.php');
include('../includes/sidebar.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="UI PAGE">
    <meta name="author" content="Ely Gian Ga">
    <link rel="stylesheet" href="../public/assets/css/bootstrap.min.css">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../public/assets/css/font-awesome.css">
    <link rel="stylesheet" href="../public/assets/css/admin_index.css">
    <title>Library Inventory</title>
</head>

<body>
    <div class="content-wrapper">

        <div class="container">
            <h2 class="text-center">Real-Time Book Reservation Notifications</h2>
            <div id="notifications"></div>
        </div>


        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs justify-content-center" id="dashboard-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="literature-tab" data-bs-toggle="tab" href="#literature" role="tab" aria-controls="literature" aria-selected="true">
                            <i class="fas fa-book"></i> Books
                        </a>
                    </li>

                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-5" id="dashboard-tabContent">
                    <!-- Literature Tab -->
                    <div class="tab-pane fade show active" id="literature" role="tabpanel" aria-labelledby="literature-tab">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-book text-center"></i>
                            </div>
                            <div class="card-body">
                                <?php
                                include("../categories/Books.php");
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include('../includes/footer.php'); ?>
    <script src="../public/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
    <script>
        const client = mqtt.connect('ws://broker.hivemq.com:8000/mqtt');
        client.on('connect', () => {
            console.log('Connected to MQTT broker');
            client.subscribe('library/admin/notifications');
        });

        client.on('message', (topic, message) => {
            if (topic === 'library/admin/notifications') {
                const data = JSON.parse(message.toString());
                const notification = `
                    <div class="alert alert-info">
                        <strong>New Reservation:</strong> ${data.title} by ${data.author}<br>
                        Reserved by: ${data.name}
                    </div>`;
                document.getElementById('notifications').innerHTML += notification;
            }
        });
    </script>
</body>

</html>