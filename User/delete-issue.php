<?php 
error_reporting(0);
include('../connect2.php');

$matric_no = $_GET['matric_no'];        
$sql = "DELETE FROM recorded_issue WHERE matric_no=?";
$stmt = $dbh->prepare($sql);
$stmt->execute([$matric_no]);

header("Location: borrowed_materialrecord.php"); 
?>
