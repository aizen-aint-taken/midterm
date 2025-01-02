<?php

// hi
session_start();

require_once '../config/conn.php';

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('location: ../index.php');
    exit;
}



if ($_POST) {

    $email_result = $conn->query("select * from webuser");

    $name = mysqli_real_escape_string( $conn , $_POST["name"]);
    $age = mysqli_real_escape_string($conn,$_POST['age']);
    $year = mysqli_real_escape_string($conn , $_POST['year']);
    $sect = mysqli_real_escape_string($conn , $_POST['sect']);
    $email = filter_var( $_POST['mail'] ,  FILTER_VALIDATE_EMAIL);
    $pass = $_POST['password'];
    $hasspass = password_hash($pass,PASSWORD_BCRYPT);

    $email_result = $conn->query("select * from webuser where email='$email';");
    if ($email_result->num_rows == 1) {
        $error = "Already have an account for this Email address.";
    } else {
        $conn->query("INSERT INTO users(email, password, name, age, year, sect) VALUES ('$email','$hasspass','$name','$age','$year','$sect')");
        $conn->query("INSERT INTO webuser(email, usertype) VALUES ('$email','u')");

        $_SESSION['user'] = $email;
        $_SESSION['usertype'] = "u";
        // $_SESSION['username'] = $fname;

        // echo "INSERT INTO patient(pemail, pname, ppassword, paddress, pdob, ptel) VALUES ('$email','$name','$npassword','$address','$dob','$mnumber')";

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
    <link rel="stylesheet" href="../public/assets/css/admin_index.css">
    <title>Add Student</title>
</head>

<body>
    <div class="container mt-5">
        <div class=" d-flex justify-content-end mb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#addBookModal">Add Student</button>
        </div>



        <!-- Table POV dako na screeen -->
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Age</th>
                    <th>Year Level</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['age'] ?></td>
                        <td><?= $user['year'] ?></td>
                        <td><?= $user['sect'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>





        <!-- Modals -->
        <!-- Add Book Modal -->
        <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Add Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Juan Dela Cruz" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="text" class="form-control" name="age" id="age" placeholder="17" required>
                            </div>
                            <div class="form-group">
                                <label for="year">Year Level</label>
                                <input type="text" class="form-control" name="year" id="year" placeholder="Grade 9" required>
                            </div>
                            <div class="form-group">
                                <label for="sect">Section</label>
                                <input type="text" class="form-control" name="sect" id="sect" placeholder="Section Maganda" required>
                            </div>
                            <div class="form-group">
                                <label for="mail">Email</label>
                                <input type="mail" class="form-control" name="mail" id="mail" placeholder="juandelacruz@gmail.com" required>
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

    </div>

    <?php include('../includes/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>