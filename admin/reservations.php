<?php
session_start();
include("../config/conn.php");

$studentId = $_SESSION['student_id'];
$reservations = $conn->query("SELECT
    U.name AS USERNAME,
    R.ReserveDate AS RESERVEDATE,
    B.Title AS BOOK_TITLE,
    R.STATUS AS STATUS,
    CASE
        WHEN R.STATUS = 'Reserved' AND R.ReserveDate < NOW() THEN 'Not Returned'
        WHEN R.STATUS = 'Reserved' AND R.ReserveDate >= NOW() THEN 'Returned'
        ELSE 'Unknown'
    END AS RETURN_STATUS
FROM `reservations` AS R
INNER JOIN users AS U ON R.StudentID = U.id
INNER JOIN books AS B ON R.BookID = B.BookID
WHERE U.id = '$studentId'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/bootstrap.min.css">
    <title>Reservation</title>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
            font-size: 24px;
        }

        .table {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 14px;
        }

        .table thead {
            background-color: #343a40;
            color: white;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }

        .table td,
        .table th {
            vertical-align: middle;
            padding: 8px;
        }

        .table-responsive {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <h1>Reservation List</h1>
    <div class="table-responsive">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>USER NAME</th>
                    <th>RESERVEDATE</th>
                    <th>BOOK TITLE</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reserve): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserve['USERNAME']) ?></td>
                        <td><?= htmlspecialchars($reserve['RESERVEDATE']) ?></td>
                        <td><?= htmlspecialchars($reserve['BOOK_TITLE']) ?></td>
                        <td><a href="">Approve</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+pP2mhbVZjfgvBx0wTFFuwHugLrzzDxukRMblgfddPukVzEADGt/76FdKGEukS" crossorigin="anonymous"></script>
</body>

</html>