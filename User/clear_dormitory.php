<?php
session_start();
error_reporting(0);
include('../connect.php');

if(strlen($_SESSION['admin-username']) == "") {   
    header("Location: login.php"); 
} else {
    $username = $_SESSION['admin-username'];
    date_default_timezone_set('Africa/Lagos');
    $current_date = date('Y-m-d H:i:s');

    // Clear student status
    if(isset($_GET['matric_no'])) {
        $matric_no = $_GET['matric_no'];
        
        // Assuming 'is_dormitory_approved' is a column in your 'students' table
        // Clear the dormitory status for the specific student matriculation number
        mysqli_query($conn, "UPDATE students SET is_dormitory_approved='1' WHERE matric_no='$matric_no'");
        
        // Redirect back to the student clearance page after clearing the status
        header("Location: student-clearance.php");
        exit(); // Exit the script after redirecting
    }
}
?>
