<?php
session_start();
error_reporting(E_ALL);
include('connect.php');
include('connect2.php');

// Initialize variables
$reason = $school_year = "";

// Assume the logged-in user's matric_no is stored in a session variable
if (!isset($_SESSION['matric_no'])) {
    // Redirect to login if matric_no is not set in the session
    header("Location: login.php");
    exit();
}

$matric_no = $_SESSION['matric_no'];

// Fetch the logged-in user's details
$query = "SELECT * FROM `students` WHERE matric_no = '$matric_no'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Fetch and display the data
    $row = mysqli_fetch_assoc($result);
    // We no longer need to fetch other fields
} else {
    // If no data found for the given matric_no, display an error message
    $error_message = "This matric number is not known";
}

// Check if form is submitted
if (isset($_POST["submit"])) {
    // Validate and sanitize user inputs
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $school_year = mysqli_real_escape_string($conn, $_POST['school_year']);
    $entered_matric_no = mysqli_real_escape_string($conn, $_POST['matric_no']);

    // Verify the entered matric number matches the session matric number
    if ($entered_matric_no !== $matric_no) {
        $_SESSION['error'] = 'Your matric number is incorrect';
    } else {
        // Proceed with inserting clearance request
        $query = "INSERT INTO `clearance_requests` (reason, school_year, matric_no, date)
                  VALUES ('$reason', '$school_year', '$matric_no', NOW())";

        // Execute the query
        $result = mysqli_query($conn, $query);

        // Check for errors in query execution
        if ($result) {
            $_SESSION['success'] = 'Clearance request submitted successfully.';
            // Include the sendSMS.php file if necessary
            include('sendSMS.php');
            // Placeholder function call to send SMS notification
            sendSMS($matric_no, $reason);
            // Redirect to index.php
            header("Location: index.php");
            exit(); // Stop execution after redirect
        } else {
            $_SESSION['error'] = 'Problem submitting clearance request';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Request Clearance | Dashboard</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <style>
  /* Internal CSS Styles */
  body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
  }

  .navbar {
    background-color: #007bff !important;
    border-bottom: 1px solid #dee2e6 !important;
    padding: 15px 20px;
    position: relative;
    text-align: center;
  }

  .logout-button {
    position: absolute;
    top: 10px;
    right: 0px;
    padding: 10px 20px;
    color:white;
    border-radius: 5px;
    text-decoration: none;
    opacity: 80%;
  }

  .logout-button:hover {
    background-color: #0056b3;
  }

  .container {
    margin-top: 50px;
  }

  .card {
    border: 1px solid #007bff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    width: 100%; /* Adjust the width of the form */
    max-width: 600px; /* Set the maximum width */
    margin: auto; /* Center the form horizontally */
    border-color: #6c757d; /* Change border color */
  }

  .card-header {
    background-color: #007bff;
    color: #ffffff;
    border-radius: 10px 10px 0 0;
    padding: 10px 20px;
  }

  .card-title {
    margin-bottom: 0;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-control {
    border: 1px solid #ced4da;
    border-radius: 5px;
    padding: 10px;
    width: 100%; /* Ensure all form controls are full-width */
  }

  .form-control:focus {
    border-color: #007bff;
    box-shadow: none;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 5px;
    padding: 10px 20px;
    width: 100%; /* Make submit button full-width */
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }

  .alert {
    margin-top: 20px;
    border-radius: 5px;
    padding: 10px 20px;
    color: red;
  }

  label {
    margin-bottom: 5px;
    font-weight: bold;
  }

  .form-group-inline {
    display: flex;
    align-items: center;
    margin-left: 20px; /* Adjust margin from left */
    margin-top: 10px; /* Add space from the top */
    margin-bottom: 10px; /* Add space from the bottom */
    gap: 10px; /* Add space between elements */
  }

  .form-group-inline label {
    margin-right: 10px; /* Adjust space between label and input */
    flex-shrink: 0; /* Prevent label from shrinking */
    width: 120px; /* Fixed width for labels */
  }

  .form-group-inline input[type="radio"] {
    margin-right: 5px; /* Adjust space between radio buttons */
  }

  .form-group-inline select,
  .form-group-inline input[type="text"],
  .form-group-inline input[type="radio"] {
    flex-grow: 1; /* Allow input fields to grow */
  }

  .form-group {
    margin-bottom: 20px;
    margin-left: 10px;
    margin-top: 15px;
  }

  .form-group label {
    margin-bottom: 5px;
  }

  .form-control {
    border: 1px solid #ced4da;
    border-radius: 8px;
    padding: 10px;
    width: 95%;
  }

  #fullname{
    width: 91%;
  }
  #matric_no{
    width: 91%
  }
  .form-control:focus {
    border-color: #007bff;
    box-shadow: none;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 5px;
    padding: 10px 20px;
    width: 40%;
    margin-top: 0px;
    margin-left: 20px;
    margin-bottom: 10px;
    margin-right: 50px;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }

  .alert {
    margin-top: 20px;
    border-radius: 5px;
    padding: 10px 20px;
  }

  label {
    margin-bottom: 5px;
    font-weight: bold;
  }

  .form-group-inline {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .form-group-inline label {
    margin-bottom: 0;
  }

  .form-group-inline input {
    margin-left: 5px;
  }

  .form-group-inline {
    display: flex;
    align-items: center;
    margin-left: 20px; /* Adjust margin from left */
    margin-bottom: 20px;
  }

  .form-group-inline label {
    margin-right: 10px; /* Adjust space between label and input */
    flex-shrink: 0; /* Prevent label from shrinking */
    width: 120px; /* Fixed width for labels */
  }

  .form-group-inline input[type="radio"] {
    margin-right: 5px; /* Adjust space between radio buttons */
  }

  .form-group-inline select,
  .form-group-inline input[type="text"],
  .form-group-inline input[type="radio"] {
    flex-grow: 1; /* Allow input fields to grow */
  }

  .form-group {
    margin-bottom: 20px;
    margin-left: 10px;
    margin-top: 15px;
  }

  .form-group label {
    margin-bottom: 5px;
  }

  .form-control {
    border: 1px solid #ced4da;
    border-radius: 8px;
    padding: 10px;
    width: 95%;
  }

  #fullname{
    width: 91%;
  }
  #matric_no{
    width: 91%
  }
  .form-control:focus {
    border-color: #007bff;
    box-shadow: none;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 5px;
    padding: 10px 20px;
    width: 40%;
    margin-top: 0px;
    margin-left: 20px;
    margin-bottom: 10px;
    margin-right: 50px;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }

  .alert {
    margin-top: 20px;
    border-radius: 5px;
    padding: 10px 20px;
  }

  label {
    margin-bottom: 5px;
    font-weight: bold;
  }

  .form-group-inline {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .form-group-inline label {
    margin-bottom: 0;
  }

  .form-group-inline input {
    margin-left: 5px;
  }
  .form-group-inline{
    margin-right: 27px;
  
  }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a href="logout.php" class="logout-button">Logout</a>
</nav>
<div class="container">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Request Clearance</h4>
    </div>
    <div class="card-body">
      <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
      <?php endif; ?>

      <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
      <?php endif; ?>

      <form method="POST" action="">
         <div class="form-group">
                <select class="form-control" name="reason" id="reason" required="">
                  <option value="" disabled selected>Reason for Clearance</option>
                  <option value="end_of_semester">End of Semester</option>
                  <option value="withdrawal">Withdrawal</option>
                  <option value="academic_dismissal">Academic Dismissal</option>
                  <option value="graduated">Graduated</option>
                  <option value="health_problem">Health Problem</option>
                </select>
              </div>

              <div class="form-group">
                <select class="form-control" name="school_year" id="school_year" required="">
                  <option value="" disabled selected>Select Class/Year</option>
                  <option value="I">Year I</option>
                  <option value="II">Year II</option>
                  <option value="III">Year III</option>
                  <option value="IV">Year IV</option>
                  <option value="V">Year V</option>
                  <option value="Graduated">Graduated</option>
                </select>
              </div>

              <!-- Displaying the matric number field with inline CSS -->
<div class="form-group-inline">
    <input type="text" class="form-control" id="matric_no" name="matric_no" value="" placeholder="enter your matric no">
</div>


        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
