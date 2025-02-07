<?php
include("../config/conn.php");
session_start();
$studentId = $_SESSION['student_id'];

// Fetch the latest reservation data for the user
$reservations = $conn->query("SELECT
    U.name AS USERNAME,
    R.ReserveDate AS RESERVEDATE,
    B.Title AS BOOK_TITLE,
    R.STATUS AS STATUS
FROM `reservations` AS R
INNER JOIN users AS U ON R.StudentID = U.id
INNER JOIN books AS B ON R.BookID = B.BookID
WHERE U.id = '$studentId'");

$response = [];

foreach ($reservations as $reserve) {
    // Determine badge color class based on the status
    $statusClass = 'badge-secondary'; // Default for unknown status
    if ($reserve['STATUS'] == 'Approved') {
        $statusClass = 'badge-success';
    } elseif ($reserve['STATUS'] == 'Rejected') {
        $statusClass = 'badge-danger';
    } elseif ($reserve['STATUS'] == 'Reserved') {
        $statusClass = 'badge-warning';
    }

    $response[] = [
        'RESERVEDATE' => $reserve['RESERVEDATE'],
        'BOOK_TITLE' => $reserve['BOOK_TITLE'],
        'STATUS' => $reserve['STATUS'],
        'STATUS_CLASS' => $statusClass
    ];
}

// Send the response as JSON
echo json_encode($response);
?>
