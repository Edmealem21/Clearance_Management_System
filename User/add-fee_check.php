<?php
session_start();
error_reporting(0);
include('../connect.php');
include('../connect2.php');

$username = $_SESSION['admin-username'];
$sql = "SELECT * FROM admin WHERE username='$username'";
$result = $conn->query($sql);
$row1 = mysqli_fetch_array($result);

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

if (isset($_POST["btnAdd"])) {
    $faculty = mysqli_real_escape_string($conn, $_POST['cmdfaculty']);
    $dept = mysqli_real_escape_string($conn, $_POST['cmddept']);
    $session = mysqli_real_escape_string($conn, $_POST['cmdsession']);
    $amt = mysqli_real_escape_string($conn, $_POST['txtamt']);
    $matric_no = mysqli_real_escape_string($conn, $_POST['txtmatric_no']);

    if (!empty($matric_no)) {
        // Add fee for a specific matriculation number
        $sql = "SELECT * FROM student WHERE matric_no='$matric_no' AND faculty='$faculty' AND dept='$dept'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Save fee details with Matric No.
            $query = "INSERT INTO `fee` (session, matric_no, faculty, dept, amount)
                      VALUES ('$session', '$matric_no', '$faculty', '$dept', '$amt')";

            $result = mysqli_query($conn, $query);
            if ($result) {
                $_SESSION['success'] = 'Fee added successfully for the specified student.';
            } else {
                $_SESSION['error'] = 'Problem adding fee for the specified student.';
            }
        } else {
            $_SESSION['error'] = 'The specified student does not exist in the database.';
        }
    } else {
        // Add fee for all members of the department
        $sql = "SELECT * FROM student WHERE faculty='$faculty' AND dept='$dept'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $matric_no = $row['matric_no'];
                // Save fee details without Matric No.
                $query = "INSERT INTO `fee` (session, matric_no, faculty, dept, amount)
                          VALUES ('$session', '$matric_no', '$faculty', '$dept', '$amt')";

                $result = mysqli_query($conn, $query);
            }
            $_SESSION['success'] = 'Fee added successfully for all students in the department.';
        } else {
            $_SESSION['error'] = 'No students found in the department.';
        }
    }
}
?>
