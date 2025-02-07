<?php
 // Set a unique session name for the user
session_start();
include("../config/conn.php");

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('location: ../index.php');
    exit;
}

if (isset($_POST['searchBtn']) && !empty(trim($_POST['search']))) {
    $searchTerm = trim($_POST['search']);
    $booksQuery = "SELECT * FROM books WHERE Stock > 0 AND (Title LIKE '%$searchTerm%' OR Author LIKE '%$searchTerm%' OR Publisher LIKE '%$searchTerm%' OR 	Source of Acquisition LIKE '%$searchTerm%' OR Language LIKE '%$searchTerm%')";
    $books = $conn->query($booksQuery);
} else {
    $books = $conn->query("SELECT * FROM books WHERE Stock > 0");
}

$filterBooks = $conn->query("SELECT * FROM books GROUP BY Language");

$studentId = $_SESSION['student_id'];
$reservations = $conn->query("SELECT
U.name AS USERNAME,
R.ReserveDate AS RESERVEDATE,
B.Title AS BOOK_TITLE
FROM reservations AS R
INNER JOIN users AS U ON R.StudentID = U.id
INNER JOIN books AS B ON R.BookID = B.BookID WHERE U.id ='$studentId'");

if (isset($_POST['filter'])) {
    $booksFilter = $_POST['booksFilter'];
    $books = $conn->query("SELECT * FROM books WHERE Language = '$booksFilter'");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">

</head>

<body>
    <?php include("./sidebar.php") ?>
    <div class="main-content">
        <?php include('./header.php') ?>
        <div class="container w-100 mt-5">
            <h1 class="text-center">Library Books</h1>
            <!-- Filter Form -->
            <form action="index.php" method="post" class="filter-form mb-4">
                <div class="input-group" style="max-width: 400px; width: 100%;">
                    <select name="booksFilter" id="booksFilter" class="form-select">
                        <option selected disabled hidden>Select Subject</option>
                        <?php foreach ($filterBooks as $book): ?>
                            <option value="<?= htmlspecialchars($book['Language']) ?>">
                                <?= htmlspecialchars($book['Language']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="filter" class="btn btn-primary d-flex align-items-center">
                        <i class="fas fa-filter me-2"></i> Select
                    </button>
                </div>
            </form>

            <!-- Search Bar -->
            <div class="filter-container mt-3 d-flex justify-content-center">
                <div class="input-group" style="max-width: 400px; width: 100%;">
                    <input type="text" id="searchBar" name="search" class="form-control" placeholder="Search for books..." value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                    <button type="submit" name="searchBtn" class="btn btn-primary d-flex align-items-center">
                        <i class="fas fa-search me-2"></i> Search
                    </button>
                </div>
            </div>

            <!-- Table for Desktop -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-striped text-center" id="booksTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Source of Acquisition</th>
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
                                <td><?= htmlspecialchars($book['Source of Acquisition']) ?></td>
                                <td><?= htmlspecialchars($book['PublishedDate']) ?></td>
                                <td><?= htmlspecialchars($book['Language']) ?></td>
                                <td><?= htmlspecialchars($book['Stock']) ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalId"
                                        data-id="<?= htmlspecialchars($book['BookID']) ?>"
                                        data-title="<?= htmlspecialchars($book['Title']) ?>"
                                        data-author="<?= htmlspecialchars($book['Author']) ?>">
                                        Queue
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Cards for Mobile View -->
            <div class="card-group d-block d-md-none text-center">
                <?php foreach ($books as $book): ?>
                    <div class="card book-card">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($book['Title']) ?></h5>
                            <p class="card-text">
                                <strong>Author:</strong> <?= htmlspecialchars($book['Author']) ?><br>
                                <strong>Publisher:</strong> <?= htmlspecialchars($book['Publisher']) ?><br>
                                <strong>Source of Acquisition :</strong> <?= htmlspecialchars($book['Source of Acquisition']) ?><br>
                                <strong>Stock:</strong> <?= htmlspecialchars($book['Stock']) ?>
                            </p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalId"
                                data-id="<?= htmlspecialchars($book['BookID']) ?>"
                                data-title="<?= htmlspecialchars($book['Title']) ?>"
                                data-author="<?= htmlspecialchars($book['Author']) ?>">
                                Queue
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Modal for Reservation -->
            <div class="modal fade" id="modalId" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reserve Book</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        <script src="../public/assets/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('modalId');
                modal.addEventListener('show.bs.modal', event => {
                    const button = event.relatedTarget;
                    const bookId = button.getAttribute('data-id');
                    const bookTitle = button.getAttribute('data-title');
                    const bookAuthor = button.getAttribute('data-author');

                    document.getElementById('reserveBookId').value = bookId;
                    document.getElementById('reserveBookTitle').value = bookTitle;
                    document.getElementById('reserveBookAuthor').value = bookAuthor;
                });

                document.getElementById('searchBar').addEventListener('input', function() {
                    const searchValue = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#booksTable tbody tr');
                    const cards = document.querySelectorAll('.book-card');

                    rows.forEach(row => {
                        const rowText = row.textContent.toLowerCase();
                        row.style.display = rowText.includes(searchValue) ? '' : 'none';
                    });

                    cards.forEach(card => {
                        const cardText = card.textContent.toLowerCase();
                        card.style.display = cardText.includes(searchValue) ? '' : 'none';
                    });
                });
            });
        </script>
    </div>
</body>

</html>