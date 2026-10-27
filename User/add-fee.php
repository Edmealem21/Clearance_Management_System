<?php
session_start();
error_reporting(0);
include('../connect.php');
include('../connect2.php');

$username = $_SESSION['user-username'];
$sql = "SELECT * FROM user WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row1 = $result->fetch_assoc();

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

if (isset($_POST["btnAdd"])) {
    $faculty = $_POST['cmdfaculty'];
    $dept = $_POST['cmddept'];
    $session = $_POST['cmdsession'];
    $amt = $_POST['txtamt'];
    $matric_no = $_POST['matric_no']; // Add matric_no field
    $job_position = $_POST['field']; // Add job_position field

    // Form validation
    if (empty($faculty) || empty($dept) || empty($session) || empty($amt) || empty($matric_no) || empty($job_position)) {
        $_SESSION['error'] = 'Please fill out all required fields';
       // echo "<script>alert('Please fill out all required fields');</script>";
    } else {
        // Check if matric number exists in the students table
        $sql = "SELECT * FROM students WHERE matric_no=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $matric_no);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // If matric number does not exist in students table, display error message
            $_SESSION['error'] = 'The matric number has not been recorded';
            //echo "<script>alert('The matric number has not been recorded');</script>";
        } else {
            // Fetch student data from the database
            $student_data = $result->fetch_assoc();

            // Check if faculty and department match with the retrieved student's data
            if (
                $faculty != $student_data['faculty'] ||
                $dept != $student_data['dept']
            ) {
                // If data mismatches, display error message
                $_SESSION['error'] = 'You must provide correct data';
                //echo "<script>alert('You must provide correct data');</script>";
            } else {
                // Check if fee already exists for the specified matric_no, faculty, and department
                $sql = "SELECT * FROM fee WHERE session=? AND faculty=? AND dept=? AND matric_no=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $session, $faculty, $dept, $matric_no);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // If fee exists, check if the job position is different from the existing one
                    $existing_fee = $result->fetch_assoc();
                    $existing_job_position = $existing_fee['job_position'];

                    if ($job_position != $existing_job_position) {
                        // If job position is different, insert a new record
                        $sql = "INSERT INTO fee (session, faculty, dept, amount, matric_no, job_position) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ssssss", $session, $faculty, $dept, $amt, $matric_no, $job_position);
                        if ($stmt->execute()) {
                            $_SESSION['success'] = 'Fee added successfully';
                           // echo "<script>alert('Fee added successfully');</script>";
                        } else {
                            $_SESSION['error'] = 'Problem adding fee';
                            //echo "<script>alert('Problem adding fee');</script>";
                        }
                    } else {
                        // If job position is the same, display error message
                        $_SESSION['error'] = 'The job position is already assigned for this fee';
                        //echo "<script>alert('The job position is already assigned for this fee');</script>";
                    }
                } else {
                    // If fee does not exist, insert a new record
                    $sql = "INSERT INTO fee (session, faculty, dept, amount, matric_no, job_position) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssss", $session, $faculty, $dept, $amt, $matric_no, $job_position);
                    if ($stmt->execute()) {
                        $_SESSION['success'] = 'Fee added successfully';
                        //echo "<script>alert('Fee added successfully');</script>";
                    } else {
                        $_SESSION['error'] = 'Problem adding fee';
                        //echo "<script>alert('Problem adding fee');</script>";
                    }
                }
            }
        }
    }
}
?>


<!-- Your existing HTML code here -->

<!-- Your existing HTML code here -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add fee|Admin Dashboard</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <style>
  .main-header  {
    background-color: #007bff;
  }
  #a{
    color: white;
    
  }
</style>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="http://localhost/internship_project/login.php" class="nav-link" id="a">Home</a>
            </li>
        </ul>
        
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
        <ul class="navbar-nav ml-auto">
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index.php" class="brand-link">
            <img src="../images/dbu_logo.Jpg" alt=" Logo"  width="200" height="111" class="" style="opacity: .8">
            <span class="brand-text font-weight-light"></span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="../<?php echo $row1['photo']; ?>" alt="User Image" width="220" height="192" class="img-circle elevation-2">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?php echo $row1['fullname']; ?></a>
                </div>
            </div>
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <?php
                    include('sidebar.php');
                    ?>
                </ul>
            </nav>
        </div>
    </aside>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="http://localhost/internship_project/login.php" >Home</a></li>
                            <li class="breadcrumb-item active">Add Fee</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add New Fee</h3>
                            </div>
                            <form id="form" action="" method="post" class="">
                                <div class="card-body">
                                <div class="card-body">
    <?php if(isset($error_message)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php } ?>
    <?php if(isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['error']; ?>
        </div>
    <?php unset($_SESSION['error']); } ?>
    <?php if(isset($_SESSION['success'])) { ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['success']; ?>
        </div>
    <?php unset($_SESSION['success']); } ?>
</div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Matric No</label>
                                        <input type="text" class="form-control" name="matric_no" id="matric_no" placeholder="Enter Matric No">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Session</label>
                                        <?php
                                        $sql = "SELECT * FROM tblsession";
                                        $stmt = $dbh->prepare($sql);
                                        $stmt->execute();
                                        $sessions = $stmt->fetchAll();
                                        ?>
                                        <select name="cmdsession" id="select" class="form-control" required="">
                                            <option value="" disabled selected>Select Session</option>
                                            <?php foreach ($sessions as $row_session): ?>
                                                <option value="<?= $row_session['session']; ?>"><?= $row_session['session']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Faculty</label>
                                        <select name="cmdfaculty" id="select" class="form-control" required="">
                                        <option value="Computing">Computing</option>
   <option value="Engineering">Engineering</option>
   <option value="School of Law">School of Law</option>
   <option value="Agriculture & Natural Resource Science">Agriculture & Natural Resource Science</option>
   <option value="Business and Economices">Business and Economices</option>
   <option value="Natural and Computational Science">Natural and Computational Science</option>
   <option value="Social Science and Humanities">Social Science and Humanities</option>
   <option value="Health Science">Health Science</option>
   <option value="Distance & Continuing">Distance & Continuing</option>
   <option value="fresh man"> fresh man</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Department</label>
                                        <select name="cmddept" id="select" class="form-control" required="">
                                           <option value="" disabled selected>Choose Department</option>
                                           <option value="Computer Science">Computer Science</option>
   <option value="Software Engineering">Software Engineering</option>
   <option value="Information System">Information System</option>
   <option value="Information Technology">Information Technology</option>
   <option value="Electrical& computer Engineering">Electrical& computer Engineering </option>
   <option value="Civil Engineering">Civil Engineering</option>
   <option value="Chemical Engineering">Chemical Engineering </option>
   <option value="Mechanical Engineering"> Mechanical Engineering</option>
   <option value="Construction technology and Management">Construction technology and Management</option>
   <option value="Surveying Engineeringt">Surveying Engineering</option>
   <option value="Industrial Engineering"> Industrial Engineering</option>
   <option value="Food Engineering">Food Engineering</option>
   <option value="Law">Law</option>
   <option value="Nursing">Nursing  </option>
   <option value="Health Officer">Health Officer</option>
   <option value="Midwifery">Midwifery  </option>
   <option value="Medicine">Medicine</option>
   <option value="Magement">Management</option>
   <option value="Economics">Economics</option>
   <option value="Biology">Biology</option>
   <option value="Chemistry">Chemistry</option>
   <option value="Physics">Physics</option>
   <option value="Math’s">Math’s</option>
   <option value="Sport science">Sport science</option>
   <option value="Accounting and Finance">Accounting and Finance</option>
   <option value="Tourism and Hospitality Management">Tourism and Hospitality Management</option>
   <option value="Logistics and Supply Chain Management">Logistics and Supply Chain Management </option>
   <option value="Marketing Management">Marketing Management</option>
   <option value="Amharic Language & Literature">Amharic Language & Literature</option>
   <option value="English Language & Literature">English Language & Literature</option>
   <option value="Geography & Environmental Studies">Geography & Environmental Studies</option>
   <option value="History & Heritage Management"> History & Heritage Management</option>
   <option value="Psychology, Sociology, Civics & Ethical Studies">Psychology, Sociology, Civics & Ethical Studies</option>
   <option value="Journalism & Communications">Journalism & Communications</option>
   <option value="Natural Science">Natural Science</option>
   <option value="Social Science">Social Science</option>
                                        </select>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Amount (ETB)</label>
                                        <input type="text" class="form-control" name="txtamt" id="exampleInputEmail1" size="77" placeholder="Enter Amount" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="field">Job Position</label>
                                        <select name="field" id="field" class="form-control" required>
                                            <option value="" disabled selected>Select Job Position</option>
                                            <option value="course coordinator">Course Coordinator</option>
                                            <option value="library">Library</option>
                                            <option value="cafeteria">Cafeteria</option>
                                            <option value="dormitory">Dormitory</option>
                                            <option value="bookstore">Bookstore</option>
                                            <option value="sport">Sport</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" name="btnAdd" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Fee Structure</h3>
                            </div>
                            <div class="card-body">
                                <table width="106%" align="center" class="table table-bordered table-striped" id="example1">
                                    <thead>
                                    <tr> 
                                        <th width="3%"><div align="center">#</div></th>
                                        <th width="13%"><div align="center">Faculty</div></th>
                                        <th width="8%"><div align="center">Department</div></th>
                                        <th width="7%"><div align="center">Session</div></th>
                                        <th width="8%"><div align="center">Matric No</div></th>
                                        <th width="6%"><div align="center">Amount</div></th>
                                        <th width="10%"><div align="center">Job Position</div></th>
                                        <th width="6%"><div align="center">Action</div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                         <?php 
                                          $sql = "SELECT * FROM fee order by session ASC";
                                           $result = $conn->query($sql); 
                                           $cnt=1;
                                           while($row = $result->fetch_assoc()) { ?>
                                               <tr class="gradeX">
                                                   <td height="47"><div align="center"><?php echo $cnt; ?></div></td>
                                                   <td><div align="center"><?php echo $row['faculty']; ?></div></td>
                                                   <td><div align="center"><?php echo $row['dept']; ?></div></td>
                                                   <td><div align="center"><?php echo $row['session']; ?></div></td>
                                                   <td><div align="center"><?php echo $row['matric_no']; ?></div></td>
                                                   <td><div align="center">ETB<?php echo number_format((float) $row['amount'] ,2); ?></div></td>
                                                   <td><div align="center"><?php echo $row['job_position']; ?></div></td>
                                                   <td>
                                                       <div class="btn-group">
                                                           <button type="button" class="btn btn-danger btn-flat">Action</button>
                                                           <button type="button" class="btn btn-danger btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                               <span class="sr-only">Toggle Dropdown</span>
                                                           </button>
                                                           <div class="dropdown-menu" role="menu">
                                                               <a class="dropdown-item" href="delete-fee.php?matric_no=<?php echo $row['matric_no']; ?>" onClick="return deldata('<?php echo $row['fullname']; ?> ');">Delete</a>
                                                           </div>
                                                       </div>
                                                   </td>
                                               </tr>
                                               <?php $cnt=$cnt+1;} ?>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
        </div>
        <strong><?php include '../footer.php' ?></strong>
    </footer>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>
</body>
</html>
