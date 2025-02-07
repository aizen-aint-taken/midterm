<?php
session_name('user_session');  // Use the user session name
session_start();
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session
header('location: index.php');
exit;
