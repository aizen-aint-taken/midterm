<?php

session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('location: ../index.php');
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Side</title>
</head>

<body>
    <h1>This is User Side</h1>
    <a href="../logout.php">Logout</a>
</body>

</html>