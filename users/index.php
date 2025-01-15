<?php
session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('location: ../index.php');
    exit;
}

include("../config/conn.php");
$books = $conn->query("SELECT * FROM books WHERE Stock > 0");
$filterBooks = $conn->query("SELECT * FROM `books` GROUP BY Language");

$studentId = $_SESSION['student_id'];

$reservations = $conn->query("SELECT
U.name AS USERNAME,
R.ReserveDate AS RESERVEDATE,
B.Title AS BOOK_TITLE
FROM `reservations` AS R
INNER JOIN users AS U ON R.StudentID = U.id
INNER JOIN books AS B ON R.BookID = B.BookID WHERE U.id ='$studentId'");


if (isset($_POST['filter'])) {
    $booksFilter = $_POST['booksFilter'];
    $books = $conn->query("SELECT * FROM books WHERE Language = '$booksFilter'");
} else {
    $books = $conn->query("SELECT * FROM books WHERE Stock > 0");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ely Gian Ga">
    <meta name="description" content="Student Book Reservation System">
    <title>Book Reservation</title>
    <link rel="stylesheet" href="../public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/assets/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../public/assets/css/users.css">


</head>

<body>

    <div class="d-flex">
        <div id="sidebar w-50" class=" sidebar-overlay bg-secondary text-white vh-200 p-3">
            <h4 class="text-center">Menu</h4>
            <ul class="nav flex-column mt-4">
                <p id="welcome-message" class="welcome-message text-white">
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo "Welcome, " . htmlspecialchars($_SESSION['username']) . " ! ";
                    }
                    ?>
                </p>
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="reservations.php">My Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
                </li>
            </ul>
        </div>

        <div class="container">
            <form action="index.php" method="post" class="filter-form">
                <label for="booksFilter">Filter By Subject:</label>
                <select name="booksFilter" id="booksFilter">
                    <option selected disabled hidden>Select Subject</option>
                    <?php foreach ($filterBooks as $book): ?>
                        <option value="<?= htmlspecialchars($book['Language']) ?>">
                            <?= htmlspecialchars($book['Language']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="filter">Filter</button>
            </form>

            <!-- Table View for Large Screens -->
            <table class="table table-striped text-center" id="booksTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Genre</th>
                        <th>Published Date</th>
                        <th>Subject</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['BookID']) ?></td>
                            <td><?= htmlspecialchars($book['Title']) ?></td>
                            <td><?= htmlspecialchars($book['Author']) ?></td>
                            <td><?= htmlspecialchars($book['Publisher']) ?></td>
                            <td><?= htmlspecialchars($book['Genre']) ?></td>
                            <td><?= htmlspecialchars($book['PublishedDate']) ?></td>
                            <td><?= htmlspecialchars($book['Language']) ?></td>
                            <td><?= htmlspecialchars($book['Stock']) ?></td>
                            <td>
                                <!-- Modal trigger button -->
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm rb"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalId" data-id="<?= htmlspecialchars($book['BookID']) ?>"
                                    data-title="<?= htmlspecialchars($book['Title']) ?>"
                                    data-author="<?= htmlspecialchars($book['Author']) ?>">
                                    Queue
                                </button>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Card View for Small Screens -->
            <div class="card-container">
                <?php foreach ($books as $book): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($book['Title']) ?></h5>
                            <p class="card-text">
                                <strong>Author:</strong> <?= htmlspecialchars($book['Author']) ?><br>
                                <strong>Publisher:</strong> <?= htmlspecialchars($book['Publisher']) ?><br>
                                <strong>Genre:</strong> <?= htmlspecialchars($book['Genre']) ?><br>
                                <strong>Published Date:</strong> <?= htmlspecialchars($book['PublishedDate']) ?><br>
                                <strong>Language:</strong> <?= htmlspecialchars($book['Language']) ?><br>
                                <strong>Stock:</strong> <?= htmlspecialchars($book['Stock']) ?>
                            </p>
                            <!-- Modal trigger button -->
                            <button
                                type="button"
                                class="btn btn-primary btn-sm rbm"
                                data-bs-toggle="modal"
                                data-bs-target="#mobileModal" data-id="<?= htmlspecialchars($book['BookID']) ?>"
                                data-title="<?= htmlspecialchars($book['Title']) ?>"
                                data-author="<?= htmlspecialchars($book['Author']) ?>">
                                Queue
                            </button>
                            <!-- <button
                            type="button"
                            class="btn btn-primary btn-sm rbm"
                            data-bs-toggle="modal"
                            data-bs-target="" data-id="<?= htmlspecialchars($book['BookID']) ?>"
                            data-title="<?= htmlspecialchars($book['Title']) ?>"
                            data-author="<?= htmlspecialchars($book['Author']) ?>">
                            Reserve
                        </button> -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Modal Body  Mobile-->
            <div
                class="modal fade"
                id="mobileModal"
                tabindex="-1"
                data-bs-backdrop="static"
                data-bs-keyboard="false"

                role="dialog"
                aria-labelledby="modalTitleId"
                aria-hidden="true">
                <div
                    class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">
                                Modal title
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="reserve.php" method="POST">
                                <input type="hidden" name="book_id" id="reserveBookIdm">
                                <div class="form-group">
                                    <label for="reserveBookTitle">Book Title</label>
                                    <input type="text" name="book_title" class="form-control" id="reserveBookTitlem" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="reserveBookAuthor">Author</label>
                                    <input type="text" name="book_author" class="form-control" id="reserveBookAuthorm" readonly>
                                </div>
                                <button type="submit" name="reserve" class="btn btn-success">Reserve</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Body Desktop-->

            <div
                class="modal fade"
                id="modalId"
                tabindex="-1"
                data-bs-backdrop="static"
                data-bs-keyboard="false"

                role="dialog"
                aria-labelledby="modalTitleId"
                aria-hidden="true">
                <div
                    class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">
                                Reserve Book
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="reserve.php" method="POST">
                                <input type="hidden" name="book_id" id="reserveBookId">
                                <div class="form-group">
                                    <label for="reserveBookTitle">Book Title</label>
                                    <input type="text" name="book_title" class="form-control" id="reserveBookTitle" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="reserveBookAuthor">Author</label>
                                    <input type="text" name="book_author" class="form-control" id="reserveBookAuthor" readonly>
                                </div>
                                <!-- <div class="form-group">
                                <label for="studentName">Your Name</label>
                                <input type="text" class="form-control" name="student_name" id="studentName" required>
                            </div>
                            <div class="form-group">
                                <label for="studentId">Student ID</label>
                                <input type="text" class="form-control" name="student_id" id="studentId" required>
                            </div> -->
                                <button type="submit" name="reserve" class="btn btn-success">Reserve</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Logout Modal -->
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to log out?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="../logout.php" class="btn btn-danger">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="../public/assets/js/jquery-3.5.1.min.js"></script>
        <script src="../public/assets/js/jquery.dataTables.js"></script>
        <script src="../public/assets/js/popper.min.js"></script>
        <script src="../public/assets/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {

                $('.rb').on('click', function() {
                    // alert()
                    const bookId = $(this).data('id');
                    const bookTitle = $(this).data('title');
                    const bookAuthor = $(this).data('author');
                    console.log(bookId, bookTitle, bookAuthor);

                    $('#reserveBookId').val(bookId);
                    $('#reserveBookTitle').val(bookTitle);
                    $('#reserveBookAuthor').val(bookAuthor);
                });

                $('.rbm').on('click', function() {
                    // alert()
                    const bookId = $(this).data('id');
                    const bookTitle = $(this).data('title');
                    const bookAuthor = $(this).data('author');
                    // console.log(bookId, bookTitle, bookAuthor);

                    $('#reserveBookIdm').val(bookId);
                    $('#reserveBookTitlem').val(bookTitle);
                    $('#reserveBookAuthorm').val(bookAuthor);
                });

                $('#booksTable').DataTable();

                $('form.filter-form').on('submit', function(event) {
                    const booksFilter = $('#booksFilter').val();
                    console.log(booksFilter);

                    if (booksFilter === null || booksFilter === '') {
                        event.preventDefault();
                        alert('Please select a genre before selecting a subject.');
                    }
                });
            });
        </script>
</body>

</html>