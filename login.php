<?php
session_start();
error_reporting(1);
include('connect.php');
include('connect2.php'); // Include the second database connection for students

// Initialize session variables
$username = '';
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

if (isset($_POST['btnlogin'])) {
    $username = $_POST['txtusername'];
    $password = $_POST['txtpassword'];
    $status = 'Active';

    // Check if the user is an admin
    $sql_admin = "SELECT * FROM admin WHERE username=? AND password=? AND status=?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("sss", $username, $password, $status);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();
    $row_admin = $result_admin->fetch_assoc();

    // Check if the user is a regular user
    $sql_user = "SELECT * FROM user WHERE username=? AND password=? AND status=?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("sss", $username, $password, $status);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $row_user = $result_user->fetch_assoc();

    if ($row_admin) {
        $_SESSION["admin-username"] = $row_admin['username'];
        header("Location: Admin/index.php");
        exit();
    } elseif ($row_user) {
        $_SESSION["user-username"] = $row_user['username'];
        header("Location: User/index.php");
        exit();
    } else {
        // Check if the user is a student
        $sql_student = "SELECT * FROM `students` WHERE `matric_no`=? AND `password`=?";
        $query_student = $dbh->prepare($sql_student);
        $query_student->execute(array($username, $password));
        $row_student = $query_student->rowCount();
        $fetch_student = $query_student->fetch();

        if ($row_student > 0) {
            // Set session variables for the student
            foreach ($fetch_student as $items => $v) {
                if (!is_numeric($items)) {
                    $_SESSION[$items] = $v;
                }
            }
            header("Location: index.php"); // Redirect after successful login
            exit();
        } else {
            $_SESSION['error'] = 'Wrong Username/Matric No and Password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Form | Online Clearance System</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    .style2 { color: #000099; font-weight: bold; }
    .style3 { font-size: 12px }
    .style4 { color: #000000; font-size: medium; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; }
    .navbar { background-color: #007bff; position: fixed; width: 100%; top: 0; z-index: 1000; padding: 10px 0; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
    .navbar ul { list-style-type: none; margin: 0; padding: 0; display: flex; }
    .navbar li { margin-right: 10px; }
    .navbar a { color: #f2f2f2; text-decoration: none; padding: 14px 10px; }
    .navbar a:hover { background-color: #ddd; color: black; }
    .footer { color: #000000; font-weight: bold; text-align: center; height: 40px; background-color: #007bff; padding: 10px; position: fixed; left: 0; bottom: 0; width: 100%; }
    .welcome-text{
      background-color:white; opacity:80%; align:center;  text-align: center; position: fixed; color:blue; width: 100%; top: 43px; z-index: 1000; padding: 10px 0; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body class="hold-transition login-page" style="background-image: url('../images/dbu2.jpg'); background-size: cover;">
<div class="welcome-text">
        <p><h1>Welcome to DBU Student Management System</h1></p>
    </div>
<div class="navbar">
  <ul>
    <li><a href="login.php">Home</a></li>
    <li><a href="about.html">About</a></li>
    <li><a href="contact.html">Contact</a></li>
    <li><a href="Gallery.html">Gallery</a></li>
    <li><a href="help.php">Help</a></li>
  </ul>
</div>
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b><img src="images/db-logo.jpg" width="350" height="93"><span class="style4"></span></b></a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg style2">LOGIN FORM</p>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="txtusername" placeholder="Enter Username or Matric No">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="txtpassword" placeholder="Enter Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="col-4">
          <button type="submit" name="btnlogin" class="btn btn-primary btn-block">Login</button>
        </div>
      </form>
      <p class="mb-1">&nbsp;</p>
    </div>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
<div class="footer">
  <p> Copyright @ <?php echo date("Y")?>.DBU COMPUTER SCIENCE STUDENTS | 2024 | DBU Online Student Management system | DEBRE BERHAN UNIVERSITY, AMHARA, ETHIOPIA. All Rights Reserved. </p>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<link rel="stylesheet" href="popup_style.css">
<?php if (!empty($_SESSION['success'])) { ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Success</strong> 
    </h3>
    <p><?php echo $_SESSION['success']; ?></p>
    <p>
      <button class="button button--success" data-for="js_success-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["success"]); } ?>
<?php if (!empty($_SESSION['error'])) { ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Error</strong> 
    </h3>
    <p><?php echo $_SESSION['error']; ?></p>
    <p>
      <button class="button button--error" data-for="js_error-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["error"]); } ?>
<script>
  var addButtonTrigger = function addButtonTrigger(el) {
    el.addEventListener('click', function () {
      var popupEl = document.querySelector('.' + el.dataset.for);
      popupEl.classList.toggle('popup--visible');
    });
  };
  Array.from(document.querySelectorAll('button[data-for]')).forEach(addButtonTrigger);
</script>
</body>
</html>
