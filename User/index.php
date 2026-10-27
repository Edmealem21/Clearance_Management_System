<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../connect.php');
if(empty($_SESSION['user-username'])) {   
    header("Location: ../login.php"); 
} else {
}
  
$username = $_SESSION["user-username"];
date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d');

$username = $_SESSION['user-username'];
$sql = "SELECT * FROM user WHERE username='$username'";
$result = $conn->query($sql);
$row1 = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome to User Dashboard</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <style>
  .main-header  {
    background-color: #007bff;
  }
  #a{
    color: white;
    
  }
  .block{
    margin-top: 30px;
  }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link" id="a">Home</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../images/dbu_logo.Jpg" alt=" Logo"  width="240" height="99" class="" style="opacity: .8">
      <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../<?php echo $row1['photo']; ?>" alt="User Image" width="300" height="250" class="img-circle elevation-2">
        </div>
       <!-- Move the designation <div> below the fullname <div> -->
<!-- Add space between the fullname and the designation -->
<!-- Displaying the full name above the designation with space between them -->
<div style="text-align: center;">
    <div style="margin-bottom: 10px;">
        <a href="#" style="font-size: 18px; color: white;"><?php echo $row1['fullname']; ?></a>
    </div>
    <div style="margin-top: 10px;">
        <a href="#" style="font-size: 16px; color: white;"><?php echo $row1['designation']; ?></a>
    </div>
</div>

      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <?php
            include('sidebar1.php');
          ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  
  <?php
    $query = "SELECT * FROM students "; 
    $result = mysqli_query($conn, $query); 

    if ($result) { 
        $row_students = mysqli_num_rows($result); 
    }
  
    $query = "SELECT * FROM user "; 
    $result = mysqli_query($conn, $query); 

    if ($result) { 
        $row_users = mysqli_num_rows($result); 
    }
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fa  fa-users" id="icon"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">No. Of Student(s)</span>
                <span class="info-box-number"><?php echo $row_students; ?></span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-user" id="icon"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">No. Of User(s)</span>
                <span class="info-box-number"><?php echo $row_students; ?></span>
              </div>
            </div>
          </div>
          <?php
            $sql = "select SUM(amount) as tot_pay from payment"; 
            $result = $conn->query($sql);
            $rowpayment = mysqli_fetch_array($result);
            $tot_pay = $rowpayment['tot_pay'];
          ?>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-dollar-sign"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Amount Paid</span>
                <span class="info-box-number">ETB<?php echo number_format((float) $tot_pay, 2); ?></span>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <div class="col-md-8">
            <!-- MAP & BOX PANE -->
            <div class="row">
              <div class="col-md-6">
                <!-- DIRECT CHAT -->
              </div>
              <div class="col-md-6">
                <!-- USERS LIST -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Latest Student(s)</h3>
                    <div class="card-tools">
                      <span class="badge badge-danger"><?php echo $row_students; ?> New Student(s)</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <?php 
                    $sql = "SELECT * FROM students ORDER BY ID DESC LIMIT 8;";
                    $result = $conn->query($sql);
                    while($row_new_students = $result->fetch_assoc()) { 
                  ?>
                  <div class="card-body p-0">
                    <ul class="users-list clearfix">
                      <li>
                        <img src="../<?php echo $row_new_students['photo']; ?>" alt="students Image">
                        <a class="users-list-name" href="#"><?php echo $row_new_students['fullname']; ?></a>
                        <span class="users-list-date"><?php echo $row_new_students['matric_no']; ?></span>
                      </li>
                      <?php } ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
