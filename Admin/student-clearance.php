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

    $sql = "select * from admin where username='$username'"; 
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);

    // Check if 'matric_no' parameter is set in the URL
    if(isset($_GET['matric_no'])) {
        $matric_no = $_GET['matric_no'];

        // Assuming 'is_cafeteria_approved' is a column in your 'students' table
        // Clear the cafeteria status for the specific student matriculation number
        
        // Redirect back to the student clearance page after clearing the status
        header("Location: student-clearance.php");
        exit(); // Exit the script after redirecting
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Clearance | Dashboard</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- Summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <style type="text/css">
        .style7 {
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            display: inline-block;
            color: #212529;
            text-align: center;
        }
        .clearance-request-detail {
            position: absolute;
            bottom: 25px;
            right: 10px;
            padding-right: 200px;
        }
    </style>
    <style>
  .main-header  {
    background-color: #007bff;
  }
  #a{
    color: white;
    
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
                <a href="http://localhost/internship_project/login.php" class="nav-link" id="a">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="../images/dbu_logo.Jpg" alt=" Logo"  width="200" height="111" class="" style="opacity: .8">
            <span class="brand-text font-weight-light">  </span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="../<?php echo $row['photo'];  ?>" alt="User Image" width="220" height="192" class="img-circle elevation-2">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?php echo $row['fullname'];  ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <?php
                    include('sidebar.php');
                    ?>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">&nbsp;</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="http://localhost/internship_project/login.php">Home</a></li>
                            <li class="breadcrumb-item active">Student Clearance</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <p>&nbsp;</p>
                    <table width="1204" height="227" border="0" align="center">
                        <tr>
                            <td width="1090" height="184"><div class="card">
                                    <div class="card-header">
                                        <h4>Student Clearance Approval Page </h4>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table width="85%" align="center" class="table table-bordered table-striped" id="example1">
                                            <thead>
                                                <th width="10%"><div align="center">Fullname</div></th>
                                                <th width="7%"><div align="center">Photo</div></th>
                                                <th width="5%"><div align="center">Matric No</div></th>
                                                <th width="6%"><div align="center">Course coordinator Status</div></th>
                                                <th width="5%"><div align="center">Library Status</div></th>
                                                <th width="5%"><div align="center">Cafeteria Status</div></th>
                                                <th width="5%"><div align="center">Dormitory Status</div></th>
                                                <th width="5%"><div align="center">Sport Status</div></th>
                                                <th width="5%"><div align="center">Bookstore Status</div></th>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql = "SELECT * FROM students order by ID ASC";
                                            $result = $conn->query($sql);
                                            while($row = $result->fetch_assoc()) { ?>
                                                <tr class="gradeX">
                                                    <td height="104"><div align="center"><?php echo $row['fullname']; ?> </div></td>
                                                    <td><div align="center"><span class="controls"><img src="../<?php echo $row['photo'];?>"  width="91" height="73" border="2"/></span></div></td>
                                                    <td><div align="center"><?php echo $row['matric_no']; ?></div></td>
                                                    <td>
                                                        <?php if (($row['is_course_cordinator_approved']) == '1')  { ?>
                                                            <div align="center"><span class="badge badge-success">Cleared</span></div>
                                                        <?php } else {?>
                                                            <div align="center" id="pending_button_<?php echo $row['matric_no']; ?>"><a href="clear_course.php?matric_no=<?php echo $row['matric_no']; ?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');"><i class="fa fa-check" title="Click to Clear Student"> <span class="badge badge-warning">Pending</span></i> </a></div>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if (($row['is_library_approved']) == '1')  { ?>
                                                            <div align="center"><span class="badge badge-success">Cleared</span></div>
                                                        <?php } else {?>
                                                            <div align="center"><a href="clear_library.php?matric_no=<?php echo $row['matric_no']; ?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');"><i class="fa fa-check" title="Click to Clear Student"> <span class="badge badge-warning">Pending</span></i> </a></div>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if (($row['is_cafeteria_approved']) == '1')  { ?>
                                                            <div align="center"><span class="badge badge-success">Cleared</span></div>
                                                        <?php } else {?>
                                                            <div align="center"><a href="clear_cafeteria.php?matric_no=<?php echo $row['matric_no']; ?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');"><i class="fa fa-check" title="Click to Clear Student"> <span class="badge badge-warning">Pending</span></i> </a></div>
                                                        <?php } ?>
                                                    </td> 

                                                    <td>
                                                        <?php if (($row['is_dormitory_approved']) == '1')  { ?>
                                                            <div align="center"><span class="badge badge-success">Cleared</span></div>
                                                        <?php } else {?>
                                                            <div align="center"><a href="clear_dormitory.php?matric_no=<?php echo $row['matric_no']; ?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');"><i class="fa fa-check" title="Click to Clear Student"> <span class="badge badge-warning">Pending</span></i> </a></div>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if (($row['is_sport_approved']) == '1')  { ?>
                                                            <div align="center"><span class="badge badge-success">Cleared</span></div>
                                                        <?php } else {?>
                                                            <div align="center"><a href="clear_sport.php?matric_no=<?php echo $row['matric_no']; ?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');"><i class="fa fa-check" title="Click to Clear Student"> <span class="badge badge-warning">Pending</span></i> </a></div>
                                                        <?php } ?>
                                                    </td>

                                                    <td>
                                                        <?php if (($row['is_bookstore_approved']) == '1')  { ?>
                                                            <div align="center"><span class="badge badge-success">Cleared</span></div>
                                                        <?php } else {?>
                                                            <div align="center"><a href="clear_bookstore.php?matric_no=<?php echo $row['matric_no']; ?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');"><i class="fa fa-check" title="Click to Clear Student"> <span class="badge badge-warning">Pending</span></i> </a></div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                        <a href="http://localhost/final_project_of_online_stuudent_clearance/clerance_requestdetail.php" class="clearance-request-detail">You Want See Clearance Request Detail?</a>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <table width="392" border="0" align="right">
                                    <tr>
                                        <td width="386"></td>
                                    </tr>
                                </table>
                                <p>&nbsp;</p>
                            </td>
                        </tr>
                    </table>
                    <p>
                        <!-- /.card -->
                    </p>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
    </div>
    <?php  include('../footer.php');   ?>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    function clear_student(matric_no) {
    if (confirm("ARE YOU SURE YOU WISH TO CLEAR STUDENT WITH MATRIC NO. " + " " + matric_no + " " + " FOR NYSC/GRADUATION ?")) {
        // Call the PHP script with AJAX to update the database for the specific student matriculation number
        $.ajax({
            url: 'clear_student.php', // Change this to your PHP script URL
            type: 'GET',
            data: {matric_no: matric_no},
            success: function(response) {
                // If the PHP script returns success, reload the page to reflect the changes
                window.location.reload(true);
            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error(xhr);
            }
        });
        return true;
    } else {
        return false;
    }
}

</script>
