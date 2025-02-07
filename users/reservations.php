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
        ELSE 'Pending'
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
    <link rel="stylesheet" href="../public/assets/css/reservations.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Reservations</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding: 15px;
            }
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 1.5rem;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease-in-out;
        }

        .badge {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 20px;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-secondary {
            background-color: #6c757d;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table thead th {
            background-color: #007bff;
            color: #fff;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php include("../users/sidebar.php"); ?>

    <div class="content-wrapper">
        <div class="container mt-5">
            <div class="card shadow-lg">
                <div class="card-header text-center">
                    <h2 class="fw-bold mb-0">Reservation List</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="reservationTable" class="table table-striped table-hover text-center align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">Reserved Date</th>
                                    <th scope="col">Book Title</th>
                                    <th scope="col">Approval Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reservations as $reserve): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($reserve['RESERVEDATE']) ?></td>
                                        <td><?= htmlspecialchars($reserve['BOOK_TITLE']) ?></td>
                                        <td>
                                            <?php
                                            $statusClass = 'badge-secondary';
                                            if ($reserve['STATUS'] == 'Approved') {
                                                $statusClass = 'badge-success';
                                            } elseif ($reserve['STATUS'] == 'Rejected') {
                                                $statusClass = 'badge-danger';
                                            } elseif ($reserve['STATUS'] == 'Returned') {
                                                $statusClass = 'badge-warning';
                                            }
                                            ?>
                                            <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($reserve['STATUS']) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../public/assets/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX Polling Script -->
    <script>
        function fetchReservations() {
            fetch("fetch_reservations.php")
                .then(response => response.json())
                .then(data => {
                    let tableBody = document.querySelector("#reservationTable tbody");
                    tableBody.innerHTML = "";

                    data.forEach(reservation => {
                        let row = document.createElement("tr");

                        row.innerHTML = `
                            <td>${reservation.RESERVEDATE}</td>
                            <td>${reservation.BOOK_TITLE}</td>
                            <td><span class="badge ${reservation.STATUS_CLASS}">${reservation.STATUS}</span></td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching reservations:', error));
        }

        setInterval(fetchReservations, 5000);
    </script>

</body>

</html>