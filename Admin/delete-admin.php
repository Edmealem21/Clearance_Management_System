<?php
error_reporting(0);
include('../connect2.php');

if(isset($_GET['password'])) {
    $password = $_GET['password'];
    
    // Prepare a DELETE query to delete records from both admin and user tables
    $sql = "DELETE FROM admin WHERE password = ?; DELETE FROM user WHERE password = ?";
    
    // Prepare and execute the statement
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$password, $password]);
    
    header("Location: admin-record.php"); 
} else {
    // Handle the case where 'password' is not set
    // You might want to redirect or display an error message
}
?>
