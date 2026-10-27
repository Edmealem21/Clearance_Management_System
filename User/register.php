<?php
session_start();
error_reporting(0);
include('../connect.php');
include('../connect2.php');

$fullname = mysqli_real_escape_string($conn, $_POST['txtfullname']);
$matric_no = mysqli_real_escape_string($conn, $_POST['txtmatric_no']);
$password_stud = mysqli_real_escape_string($conn, $_POST['txtpassword']);
$session = mysqli_real_escape_string($conn, $_POST['txtsession']);
$faculty = mysqli_real_escape_string($conn, $_POST['txtfaculty']);
$dept = mysqli_real_escape_string($conn, $_POST['txtdept']);
$phone = mysqli_real_escape_string($conn, $_POST['txtphone']);
$photo = 'uploads/avatar_nick.png';

$sql = "SELECT * FROM students WHERE matric_no='$matric_no'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $response = array('success' => false, 'error' => 'Matric No already exists.');
} else {
    $query = "INSERT INTO students (fullname, matric_no, password, session, faculty, dept, phone, photo)
              VALUES ('$fullname', '$matric_no', '$password_stud', '$session', '$faculty', '$dept', '$phone', '$photo')";

    $result = mysqli_query($conn, $query);
    if ($result) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false, 'error' => 'Problem registering student');
    }
}

echo json_encode($response);
?>