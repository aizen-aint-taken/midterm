<?php
session_start();
// git test
require_once '../config/conn.php';

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('location: ../index.php');
    exit;
}

if ($_POST) {
    $email_result = $conn->query("select * from webuser");

    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $sect = mysqli_real_escape_string($conn, $_POST['sect']);
    $email = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
    $pass = $_POST['password'];
    // $hasspass = password_hash($pass, PASSWORD_BCRYPT);

    $email_result = $conn->query("select * from webuser where email='$email';");
    if ($email_result->num_rows == 1) {
        $error = "Already have an account for this Email address.";
    } else {
        $conn->query("INSERT INTO users(email, password, name, age, year, sect) VALUES ('$email','$pass','$name','$age','$year','$sect')");
        $conn->query("INSERT INTO webuser(email, usertype) VALUES ('$email','u')");

        $_SESSION['user'] = $email;
        $_SESSION['usertype'] = "u";

        $success =  "Account Successfully Created";
    }
}

$users = $conn->query("SELECT * FROM `users`");

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
    <link rel="stylesheet" href="public/assets/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/css/admin_index.css">
    <title>Add Student</title>
</head>

<body>
    <div class="container mt-5 w-50">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#addBookModal">Add Students</button>
        </div>

        <!-- Success message -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <!-- Error message -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <!-- Table View -->
        <div class="table-responsive w-100">
            <table class="table table-striped text-center ">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>Year Level</th>
                        <th>Section</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['age']) ?></td>
                            <td><?= htmlspecialchars($user['year']) ?></td>
                            <td><?= htmlspecialchars($user['sect']) ?></td>
                            <td>
                                <!-- Delete button -->
                                <form action="../admin/deleteStudent.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Add Student Modal -->
        <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Add Students</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="../admin/student.php" method="POST">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Put Your Full Name" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="text" class="form-control" name="age" id="age" placeholder="Put Your Age" required>
                            </div>
                            <div class="form-group">
                                <label for="year">Year Level</label>
                                <input type="text" class="form-control" name="year" id="year" placeholder="Your Grade(7-12)" required>
                            </div>
                            <div class="form-group">
                                <label for="sect">Section</label>
                                <input type="text" class="form-control" name="sect" id="sect" placeholder="Your Section" required>
                            </div>
                            <div class="form-group">
                                <label for="mail">Email</label>
                                <input type="mail" class="form-control" name="mail" id="mail" placeholder="Your Email" required>
                            </div>
                            <div class="form-group">
                                <label for="pass">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="*******" id="password" required>
                            </div>
                            <button type="submit" class="btn btn-success">Add Student</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include('../includes/footer.php'); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>