<?php
session_start();
require_once 'config/conn.php';

if ($_POST) {
    $usermail = mysqli_real_escape_string($conn, $_POST['email']);
    $userpassword = $_POST['password'];

    // eh Fetch ang user details gikan sa database  
    $getemail = $conn->query("SELECT * FROM webuser WHERE email = '$usermail'");

    if ($getemail->num_rows == 1) {
        $userData = $getemail->fetch_assoc();
        $usertype = $userData['usertype'];

        if ($usertype == 'u') {
            $validate = $conn->query("SELECT * FROM users WHERE email = '$usermail' AND password = '$userpassword'");
            if ($validate->num_rows == 1) {
                $user = $validate->fetch_assoc();
                $_SESSION['user'] = $usermail;
                $_SESSION['usertype'] = 'u';
                $_SESSION['student_id'] = $user['id'];
                $_SESSION['username'] = $user['name'];

                // Set a flag in localStorage for the user side ni siya
                echo "<script>localStorage.setItem('isLoggedIn', 'true');</script>";
                header('location: users/index.php');
                exit();
            } else {
                $error = 'Invalid Email or Password!';
            }
        } else if ($usertype == 'a') {
            $validate = $conn->query("SELECT * FROM admin WHERE email = '$usermail' AND password = '$userpassword'");
            if ($validate->num_rows == 1) {
                $admin = $validate->fetch_assoc();
                $_SESSION['user'] = $usermail;
                $_SESSION['usertype'] = 'a';
                $_SESSION['admin_email'] = $admin['email']; // Store admin email in session para inig refresh sa tab dili madamay ang isa ka tab

                // Set a flag in localStorage for the client side
                echo "<script>localStorage.setItem('isLoggedIn', 'true');</script>";
                header('location: admin/index.php');
                exit();
            } else {
                $error = 'Invalid Email or Password!';
            }
        }
    } else {
        $error = 'Email not found!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('maharlika/2nd pic.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-container {
            max-width: 400px;
            width: 90%;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        #clock {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 1rem;
            text-align: center;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            position: relative;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .eye-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div id="clock" class="mb-4"></div>
        <h2 class="text-center mb-4">LOGIN</h2>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form id="loginForm" action="" method="POST">
            <div class="mb-3">
                <div class="input-group">
                    <label for="email"></label>
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                </div>
            </div>
            <div class="mb-3 position-relative">
                <div class="input-group">
                    <label for=""></label>
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    <i class="fa-solid fa-eye eye-icon" id="togglePassword"></i>
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary" id="submitBtn">Login
                    <div class="spinner text-center" id="spinner"></div>
                </button>
            </div>
            <div class="text-center mt-3">
                <a href="forgot_password.php">Forgot Password?</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const clock = document.getElementById('clock');
            const passwordField = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const spinner = document.getElementById('spinner');
            const submitBtn = document.getElementById('submitBtn');
            const loginForm = document.getElementById('loginForm');


            function updateClock() {
                const now = new Date();
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                };
                clock.textContent = now.toLocaleString('en-PH', options);
            }

            setInterval(updateClock, 1000);
            updateClock();


            togglePassword.addEventListener('click', () => {
                const type = passwordField.type === 'password' ? 'text' : 'password';
                passwordField.type = type;
                togglePassword.classList.toggle('fa-eye-slash');
            });


            loginForm.onsubmit = (e) => {
                e.preventDefault();
                submitBtn.disabled = true;
                spinner.style.display = 'inline-block';

                setTimeout(() => {
                    loginForm.submit();
                }, 4000);
            };

            document.getElementById('submitBtn').addEventListener('click', function() {
                this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Logging in...';
            });

        });
    </script>
</body>

</html>