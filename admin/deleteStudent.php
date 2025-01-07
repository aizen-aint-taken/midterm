<?php
require_once '../config/conn.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_id']) && !empty($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];

        
        $conn->begin_transaction();

        try {
           
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $delete_id);  // "i" means integer
            $stmt->execute();
            
            if ($stmt->affected_rows == 0) {
                throw new Exception("Student not found.");
            }

            $stmt = $conn->prepare("DELETE FROM webuser WHERE email = (SELECT email FROM users WHERE id = ?)");
            $stmt->bind_param("i", $delete_id);  // Use parameterized query
            $stmt->execute();

            if ($stmt->affected_rows == 0) {
                throw new Exception("No matching webuser found for deletion.");
            }

          
            $conn->commit();

            header('Location: ../admin/deleteStudent.php?success=Student deleted successfully');
        } catch (Exception $e) {
          
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "No student ID provided for deletion.";
    }
}
