<?php
include("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservationId = $_POST['reservation_id'];
    $newStatus = $_POST['status'];

    $stmt = $conn->prepare("UPDATE reservations SET STATUS = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $reservationId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }

    $stmt->close();
    $conn->close();
}
