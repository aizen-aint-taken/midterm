<?php
session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('location: ../index.php');
    exit;
}

include("../config/conn.php");
$books = $conn->query("SELECT * FROM books WHERE Stock > 0");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ely Gian Ga">
    <meta name="description" content="Student Book Reservation System">
    <title>Book Reservation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/css/users.css">
</head>

<body>
<div class="container mt-5">
        <!-- Search Bar -->
        <div class="d-flex justify-content-center my-3">
            <div class="input-group w-50">
                <input type="search" data-name="books" id="Search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <button type="button" class="btn btn-outline-primary">Search</button>
            </div>
        </div>

        <!-- Table View for Large Screens -->
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Genre</th>
                    <th>Published Date</th>
                    <th>Language</th>
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
                            <button class="btn btn-primary btn-sm reserve-btn" data-toggle="modal" data-target="#reserveBookModal"
                                data-id="<?= htmlspecialchars($book['BookID']) ?>"
                                data-title="<?= htmlspecialchars($book['Title']) ?>"
                                data-author="<?= htmlspecialchars($book['Author']) ?>">Reserve</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Card View for Small Screens -->
        <div class="card-container text-center">
            <?php foreach ($books as $book): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?= htmlspecialchars($book['Title']) ?></h5>
                        <p class="card-text">
                            <strong>Author:</strong> <?= htmlspecialchars($book['Author']) ?><br>
                            <strong>Publisher:</strong> <?= htmlspecialchars($book['Publisher']) ?><br>
                            <strong>Genre:</strong> <?= htmlspecialchars($book['Genre']) ?><br>
                            <strong>Published Date:</strong> <?= htmlspecialchars($book['PublishedDate']) ?><br>
                            <strong>Language:</strong> <?= htmlspecialchars($book['Language']) ?><br>
                            <strong>Stock:</strong> <?= htmlspecialchars($book['Stock']) ?>
                        </p>
                        <button class="btn btn-primary btn-sm reserve-btn" data-toggle="modal" data-target="#reserveBookModal"
                            data-id="<?= htmlspecialchars($book['BookID']) ?>"
                            data-title="<?= htmlspecialchars($book['Title']) ?>"
                            data-author="<?= htmlspecialchars($book['Author']) ?>">Reserve</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Reserve Book Modal -->
    <div class="modal fade" id="reserveBookModal" tabindex="-1" aria-labelledby="reserveBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reserveBookModalLabel">Reserve Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../BooksCrud/Reserve.php" method="POST">
                        <input type="hidden" name="book_id" id="reserveBookId">
                        <div class="form-group">
                            <label for="reserveBookTitle">Book Title</label>
                            <input type="text" class="form-control" id="reserveBookTitle" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reserveBookAuthor">Author</label>
                            <input type="text" class="form-control" id="reserveBookAuthor" readonly>
                        </div>
                        <div class="form-group">
                            <label for="studentName">Your Name</label>
                            <input type="text" class="form-control" name="student_name" id="studentName" required>
                        </div>
                        <div class="form-group">
                            <label for="studentId">Student ID</label>
                            <input type="text" class="form-control" name="student_id" id="studentId" required>
                        </div>
                        <button type="submit" class="btn btn-success">Reserve</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle reserve button click to populate modal fields
        $('.reserve-btn').on('click', function () {
            const bookId = $(this).data('id');
            const bookTitle = $(this).data('title');
            const bookAuthor = $(this).data('author');

            $('#reserveBookId').val(bookId);
            $('#reserveBookTitle').val(bookTitle);
            $('#reserveBookAuthor').val(bookAuthor);
        });
    </script>
    <a href="../logout.php">Logout</a>
</body>

</html>