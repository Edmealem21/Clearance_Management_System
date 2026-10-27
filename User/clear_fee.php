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
        
        // Update all statuses to '1' for the specific student matriculation number
        mysqli_query($conn, "UPDATE students 
                             SET is_course_cordinator_approved='1',
                                 is_dormitory_approved='1',
                                 is_library_approved='1',
                                 is_sport_approved='1',
                                 is_cafteria_approved='1',
                                 is_bookstore_approved='1',
                             WHERE matric_no='$matric_no'");
        
        // Redirect back to the student clearance page after clearing the statuses
        header("Location: student-clearance.php");
        exit(); // Exit the script after redirecting
    }
}
?>
