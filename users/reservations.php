<?php
session_start();
include("../config/conn.php");
// select tanan sa books nga naay stock
$books = $conn->query("SELECT * FROM books WHERE Stock > 0");
// filter sa books base sa subject
$filterBooks = $conn->query("SELECT * FROM `books` GROUP BY Language");
$studentId = $_SESSION['student_id'];

// select sa tanan nga gireserve sa student
$reservations = $conn->query("SELECT
    U.name AS USERNAME,
    R.ReserveDate AS RESERVEDATE,
    B.Title AS BOOK_TITLE,
    R.STATUS AS STATUS,
    CASE
        WHEN R.STATUS = 'Reserved' AND R.ReserveDate < NOW() THEN 'Not Returned'
        WHEN R.STATUS = 'Reserved' AND R.ReserveDate >= NOW() THEN 'Returned'
        ELSE 'pending'
    END AS RETURN_STATUS
FROM `reservations` AS R
INNER JOIN users AS U ON R.StudentID = U.id
INNER JOIN books AS B ON R.BookID = B.BookID
WHERE U.id = '$studentId'");;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/css/reservations.css">
    <title>Document</title>
</head>

<body>
    <div class="container mt-3 w-50 h-25">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>RESERVEDATE</th>
                    <th>BOOK TITLE</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reserve): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserve['RESERVEDATE']) ?></td>
                        <td><?= htmlspecialchars($reserve['BOOK_TITLE']) ?></td>
                        <td> <?php
                                $statusClass = 'unknown'; // Default
                                if ($reserve['RETURN_STATUS'] == 'Not Returned') {
                                    $statusClass = 'not-returned';
                                } elseif ($reserve['RETURN_STATUS'] == 'Returned') {
                                    $statusClass = 'reserved';
                                } elseif ($reserve['RETURN_STATUS'] == 'Reserved') {
                                    $statusClass = 'pending';
                                }
                                ?>
                            <p class="<?= $statusClass ?>"><?= htmlspecialchars($reserve['RETURN_STATUS']) ?></p>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>