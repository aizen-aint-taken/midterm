<?php
require_once '../config/conn.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_id']) && !empty($_POST['delete_id'])) {
        $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
        
        
        $conn->query("DELETE FROM users WHERE id = '$delete_id'");
        
       
        $conn->query("DELETE FROM webuser WHERE email = (SELECT email FROM users WHERE id = '$delete_id')");
        
     
        header('Location: ../admin/deleteStudent.php?success=Student deleted successfully');
    } else {
        echo "No student ID provided for deletion.";
    }
}
?>
