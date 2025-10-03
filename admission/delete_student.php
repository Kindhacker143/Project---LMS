<?php
// Include database connection
include('config.php');

if(isset($_GET['id'])) {
    $student_id = $_GET['id'];
    
    $delete_query = "DELETE FROM admission WHERE id = $student_id";
    if (mysqli_query($conn, $delete_query)) {
        header("Location: view_students.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
