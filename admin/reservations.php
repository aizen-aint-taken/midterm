    <?php
    session_start();
    // var_dump($_SESSION);
    include("../config/conn.php");

    $studentId = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : null;
    // var_dump($studentId);

    $selectedUserId = isset($_GET['user_id']) ? $_GET['user_id'] : '';



    $users = $conn->query("SELECT id, name FROM users");

    $query = "
        SELECT
            R.id AS ReserveID,  
            U.name AS USERNAME,
            R.ReserveDate AS RESERVEDATE,
            B.Title AS BOOK_TITLE,
            CASE
                WHEN R.STATUS IS NULL OR R.STATUS = '' THEN 'Pending'
                ELSE R.STATUS
            END AS STATUS
        FROM `reservations` AS R
        INNER JOIN users AS U ON R.StudentID = U.id
        INNER JOIN books AS B ON R.BookID = B.BookID
    ";

    if ($selectedUserId && $selectedUserId != 'all') {
        $query .= " WHERE U.id = " . (int)$selectedUserId;
    }

    $reservations = $conn->query($query);

    $selectedUserName = '';
    if ($selectedUserId && $selectedUserId != 'all') {
        $userQuery = $conn->query("SELECT name FROM users WHERE id = " . (int)$selectedUserId);
        $userData = $userQuery->fetch_assoc();
        $selectedUserName = $userData['name'];
    }
    include("../includes/header.php");
    include('../includes/sidebar.php');
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../public/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css" integrity="sha512-IuO+tczf4J43RzbCMEFggCWW5JuX78IrCJRFFBoQEXNvGI6gkUw4OjuwMidiS4Lm9Q2lILzpJwZuMWuSEeT9UQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="reservation.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <title>Reservation List</title>
        <style>
            .content-container {

                background-color: #ffffff;
                border-radius: 8px;
                padding: 30px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                margin-top: 20px;
                transition: margin-left 0.3s ease-in-out;
                /* width: calc(100% - 250px); */
            }

            .table-container {
                margin-top: 20px;
            }

            h1 {
                color: #333;
            }

            .filter-container {
                margin-bottom: 20px;
            }

            .filter-container label {
                font-weight: 500;
            }

            .filter-container select,
            .filter-container button {
                width: auto;
                margin-right: 10px;
            }

            .alert {
                display: none;
            }

            .card {
                border-radius: 15px;
                border: 3px solid black;
            }

            #no-results {
                display: none;
                font-weight: bold;
                font-size: xx-large;
                text-align: center;
                color: red;
                margin-top: 20px;
            }

            @media (max-width: 768px) {
                .content-container {
                    margin-left: 0;
                }
            }
        </style>
    </head>


    <body>

        <div class="container content-container">

            <h1 class="text-center">Students List</h1>
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-success" role="alert" id="success-alert">
                        Status updated successfully!
                    </div>
                    <div class="alert alert-danger" role="alert" id="error-alert">
                        Error updating status.
                    </div>


                    <div class="filter-container">
                        <!-- User Filter -->
                        <div class="flex-grow-1">
                            <label for="user-filter" class="form-label fw-bold">Filter by Student</label>
                            <select id="user-filter" class="form-select">
                                <option value="all" <?= $selectedUserId === 'all' ? 'selected' : '' ?>>All Users</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= $user['id'] == $selectedUserId ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($user['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <div>
                            <button id="filter-btn" class="btn btn-primary">
                                <i class="fas fa-filter me-2"></i>Apply Filter
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center my-3">
                        <div class="input-group w-sm-50">

                            <input type="text" id="search" data-name="books" id="Search" class="form-control rounded" placeholder="Search a Student" aria-label="Search" aria-describedby="search-addon" /><br>
                            <button type="button" class="btn btn-outline-primary" onclick="clearSearch()">Search</button><br>
                        </div>
                    </div>

                    <hr style="border: 3px solid #333">

                    <?php if ($selectedUserName && $selectedUserId != 'all'): ?>
                        <h3 style="color: green" class="text-center">Showing Reservations for : <?= htmlspecialchars($selectedUserName) ?></h3>
                    <?php elseif ($selectedUserId == 'all'): ?>
                        <h3 class="text-center">Showing All Reservations</h3>
                    <?php endif; ?>

                    <div class="table-responsive table-container">
                        <table class="table table-striped table-hover text-center ">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Reservation Date</th>
                                    <th>Book Title</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reservations as $reserve): ?>
                                    <tr id="row-<?= $reserve['ReserveID'] ?>" class="table-row">
                                        <td><?= htmlspecialchars($reserve['USERNAME']) ?></td>
                                        <td><?= htmlspecialchars($reserve['RESERVEDATE']) ?></td>
                                        <td><?= htmlspecialchars($reserve['BOOK_TITLE']) ?></td>
                                        <td>
                                            <select class="form-select status-dropdown <?= 'status-' . strtolower($reserve['STATUS']) ?>"
                                                data-id="<?= $reserve['ReserveID'] ?>"
                                                data-previous="<?= $reserve['STATUS'] ?>">
                                                <option value="Pending" <?= $reserve['STATUS'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                <option style="color: green;" value="Approved" <?= $reserve['STATUS'] == 'Approved' ? 'selected' : '' ?>>Approve</option>
                                                <option style="color: red;" value="Rejected" <?= $reserve['STATUS'] == 'Rejected' ? 'selected' : '' ?>>Reject</option>
                                                <option style="color: blue;" value="Returned" <?= $reserve['STATUS'] == 'Returned' ? 'selected' : '' ?>>Return</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p id="no-results" style="font-weight: bold; font-size: xx-large; " class="text-center text-danger mt-5" style="display: none;">No student record found</p>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            document.getElementById("filter-btn").addEventListener("click", function() {
                let userId = document.getElementById("user-filter").value;
                let url = new URL(window.location.href);
                url.searchParams.set("user_id", userId);
                window.location.href = url.toString();
            });

            document.getElementById('search').addEventListener('input', function() {
                let query = this.value.toLowerCase();
                // console.log(query)
                let rows = document.querySelectorAll('table tbody tr');
                let noResults = document.getElementById('no-results');
                let found = false;

                rows.forEach(function(row) {
                    var rowText = row.textContent.toLowerCase();

                    if (rowText.includes(query)) {
                        row.style.display = '';
                        found = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (found) {
                    noResults.style.display = 'none';
                } else {
                    noResults.style.display = "block";
                }
            });

            function clearSearch() {
                document.getElementById('search').value = '';
                document.querySelectorAll('table tbody tr').forEach(function(row) {
                    row.style.display = '';
                });
            }
        </script>
        <script src="status.js"></script>
    </body>

    </html>