// add-fee 


<?php
session_start();
error_reporting(0);
include('../connect.php');

$username = $_SESSION['admin-username'];
$sql = "SELECT * FROM admin WHERE username='$username'";
$result = $conn->query($sql);
$row1 = mysqli_fetch_array($result);

include('../connect2.php');
date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

if (isset($_POST["btnAdd"])) {
    $faculty = mysqli_real_escape_string($conn, $_POST['cmdfaculty']);
    $dept = mysqli_real_escape_string($conn, $_POST['cmddept']);
    $session = mysqli_real_escape_string($conn, $_POST['cmdsession']);
    $amt = mysqli_real_escape_string($conn, $_POST['txtamt']);
    $matric_no = mysqli_real_escape_string($conn, $_POST['txtmatric_no']);

    $sql = "SELECT * FROM fee WHERE session='$session' AND faculty='$faculty' AND dept='$dept' AND matric_no='$matric_no'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 10) {
        $_SESSION['error'] = 'This Fee Already Exists';
    } else {
        // Save fee details
        $query = "INSERT INTO `fee` (session, faculty, dept, amount, matric_no)
        VALUES ('$session', '$faculty', '$dept', '$amt', '$matric_no')";

        $result = mysqli_query($conn, $query);
        if ($result) {
            $_SESSION['success'] = 'Fee Added Successfully';
        } else {
            $_SESSION['error'] = 'Problem Adding Fee';
        }
    }
} elseif (isset($_POST["btnAddWithoutMatric"])) {
    $faculty = mysqli_real_escape_string($conn, $_POST['cmdfaculty']);
    $dept = mysqli_real_escape_string($conn, $_POST['cmddept']);
    $session = mysqli_real_escape_string($conn, $_POST['cmdsession']);
    $amt = mysqli_real_escape_string($conn, $_POST['txtamt']);

    // Save fee details without matric_no
    $query = "INSERT INTO `fee` (session, faculty, dept, amount)
    VALUES ('$session', '$faculty', '$dept', '$amt')";

    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION['success'] = 'Fee Added Successfully';
    } else {
        $_SESSION['error'] = 'Problem Adding Fee';
    }
}
?>




