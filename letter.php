<?php
session_start();
error_reporting(0);
include('connect.php');

if(empty($_SESSION['matric_no'])) {   
    header("Location: login.php"); 
} else {
}

$ID = $_SESSION["ID"];
$matric_no = $_SESSION["matric_no"];

$sql = "SELECT * FROM students WHERE matric_no='$matric_no'"; 
$result = $conn->query($sql);
$rowaccess = mysqli_fetch_array($result);

// Fetch data from clearance_requests table if exists
$reason = '';
$date_formatted = '';
$sql_clearance = "SELECT * FROM clearance_requests WHERE matric_no='$matric_no'";
$result_clearance = $conn->query($sql_clearance);
$row_clearance = mysqli_fetch_array($result_clearance);
if ($row_clearance) {
    $reason = $row_clearance['reason'];
    // Format the date
    $date = new DateTime($row_clearance['date']);
    $date_formatted = $date->format('d/m/y');
}

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Letter | DBU University</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
        .style1 {
            font-size: xx-large;
            font-weight: bold;
        }
        .style2 {
            font-weight: bold;
        }
        .content:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            background-image: url(uploads/db-logo.jpg);
            background-size: 250px;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 80%;
            opacity: 0.8;
            z-index: 2;
        }
    </style>
</head>
<body>
    <div class="content"></div>
    <div class="wrapper wrapper-content animated fadeInRight article">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="text-center article-title">
                            <p class="text-muted">&nbsp;</p>
                            <h3>DEBRE BERHAN UNIVERSITY OFFICE OF THE REGISTRAR <img src="<?php echo $rowaccess['photo']; ?>" width="150" height="100"></h3>
                            <h3 align="center">WITHDRAWAL/CLEARANCE/SHEET</h3>
                        </div>
                        <p align="center" class="style1"><strong><h3 style="display: inline;">FOR</h3> <h2 style="display: inline; margin-left: 5px; margin-right: 5px;"><strong>REGULAR DEGREE</strong></h2> <h3 style="display: inline;">STUDENTS</h3></strong></p>
                        <p>&nbsp;</p>
                        <p>
                            <h4>Purpose:</h4> 
                        </p><br>
                        <p>If a student is withdrawing or clearing at the end of the academic year or graduating from the University he/she has to complete the procedure on this form. Only with the proper clearance of withdrawal can transcripts, letter of enrollment, honorable dismissal be issued to the student. Readmission to the institute can only be considered if proper termination is certificd by the University.</p><br>
                        <p>1. Have terminal interview if withdrawal with the head of your course coordinating unit and the head of the University obtaining their signatures below.</p><br>
                        <p>2. Obtain the other signatures designated.</p><br>
                        <p>3. Return this form to the registrar office not later than one week after your absence from class. This form becomes part of your permanent file and record.</p>
                        <p>&nbsp;</p>
                        <p align="justify" >This is to certify that you have been cleared by the following departments:</p>
                        <div align="justify">
                            <ul>
                                <li>Course coordinator </li>  
                                <li>Library</li> 
                                <li>Dormitory </li>
                                <li>Cafeteria </li>
                                <li>Sport </li>
                                <li>Bookstore </li>
                            </ul>
                        </div>
                        <div>
                            <p align="justify">Your Details remains:</p>
                            <p align="justify"><strong>FULLNAME:</strong> <?php echo $rowaccess['fullname']; ?></p>
                            <p align="justify"><strong>SEX:</strong> <?php echo $rowaccess['sex']; ?></p>
                            <p align="justify"><strong>MATRIC NUMBER:</strong> <?php echo $rowaccess['matric_no']; ?></p>
                            <p align="justify"><strong>FACULTY:</strong> <?php echo $rowaccess['faculty']; ?></p>
                            <p align="justify"><strong>DEPARTMENT:</strong> <?php echo $rowaccess['dept']; ?></p>
                            <!-- Other content -->
                        <p align="justify">
                            <!-- Display the reason conditionally -->
                            <?php if ($reason): ?>
                            <strong>REASON:</strong> <?php echo $reason; ?>
                            <?php endif; ?>
                        </p>
                            <p align="justify">&nbsp;</p>
                            <p align="justify">Date of receiving the clearance, if neccesary including the ID card by record officer of the register.</p>
                            <p align="justify"><strong>DD/MM/YY:</strong> <?php echo $date_formatted; ?></p>
                            <p align="justify">Seal of the register office</p>
                            <p align="right" class="style2">SIGNED</p>
                            <p align="right">&nbsp;</p>
                            <p align="right"><strong>REGISTRAR </strong></p>
                        </div>
                        <hr>
                        <div class="row">
                            <div align="center">
                                <a href="#" id="print-button" onclick="window.print();return false;">
                                    <button type="button">Print this page</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
</body>
</html>
