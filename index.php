<?php
session_start();

require_once 'config/conn.php';

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

if ($_POST) {

    $usermail = mysqli_escape_string($conn,$_POST['email']);
    $userpassword = $_POST['password'];
    $hashedPassword = password_hash($userpassword, PASSWORD_DEFAULT);


    $getemail = $conn->query("SELECT * FROM webuser WHERE email = '$usermail'");

    if ($getemail->num_rows == 1) {
        $usertype = $getemail->fetch_assoc()['usertype'];
        // echo $usertype;
        // exit;
        if ($usertype == 'u') {

            $validate = $conn->query("SELECT * FROM users WHERE email = '$usermail' AND password = '$userpassword'");

            if ($validate->num_rows == 1) {
                $_SESSION['user'] = $usermail;
                $_SESSION['usertype'] = 'u';

                header('location: users/index.php');
            } else {
                $error = 'Wrong credentials: Invalid Email or Password!';
            }
        } else if ($usertype == 'a') {
            $validate = $conn->query("SELECT * FROM `admin` WHERE email = '$usermail' AND password = '$userpassword'");

            if ($validate->num_rows == 1) {
                $_SESSION['user'] = $usermail;
                $_SESSION['usertype'] = 'a';

                header('location: admin/index.php');
            } else {
                $error = 'Wrong credentials: Invalid Email or Password!';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/assets/css/login.css">
    <title>Login</title>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center">Login</h2>
        <form action="" method="POST">
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Username" required>
            </div>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="password" required>
            </div>
            <div>
                <input type="submit" class="btn btn-primary mt-3 form-control" value="Login">
            </div>
            <?php if (isset($error)) {
            ?>
                <p style="color: #8E0D0D; font-size: 14px;" class="text-center"><?= $error ?></p>
            <?php
            }
            ?>
        </form>
    </div>
</body>

</html> 