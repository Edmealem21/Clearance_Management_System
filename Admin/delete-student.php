<?php 
error_reporting(0);
include('../connect2.php');

$matric_no = $_GET['matric_no'];        
$sql = "DELETE FROM students WHERE matric_no=?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$matric_no]);

header("Location: student-record.php"); 
?>
