<?php
session_start();
error_reporting(0);
include('../connect.php');
include('../connect2.php');

$matric_no = $_GET['matric_no']; // Change parameter to matric_no

// Prepare and execute the SQL query to delete the fee with the specified matric_no
$sql = "DELETE FROM fee WHERE matric_no=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matric_no); // Change parameter type to "s" for string
if ($stmt->execute()) {
    // If deletion is successful, redirect back to the page with a success message
    $_SESSION['success'] = 'Fee deleted successfully';
    header("Location: add-fee.php");
    exit();
} else {
    // If deletion fails, redirect back to the page with an error message
    $_SESSION['error'] = 'Error deleting fee';
    header("Location: add-fee.php");
    exit();
}
?>
