<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connect.php');
if (empty($_SESSION['matric_no'])) {   
    header("Location: login.php"); 
    exit; // Add exit after redirection to stop further execution
}

// Get necessary session details 
$ID = $_SESSION["ID"];
$matric_no = $_SESSION["matric_no"];
$dept = $_SESSION['dept'];
$faculty = $_SESSION['faculty'];

// Get individual fee components
$sql_individual_fee = "SELECT job_position, amount FROM fee WHERE matric_no='$matric_no'";
$result_individual_fee = $conn->query($sql_individual_fee);

if (!$result_individual_fee) {
    die("Query failed: " . $conn->error);
}

$sql = "select * from students where matric_no='$matric_no'"; 
$result = $conn->query($sql);
$rowaccess = mysqli_fetch_array($result);

$course = $rowaccess["is_course_cordinator_approved"];
$library = $rowaccess["is_library_approved"];
$cafeteria = $rowaccess["is_cafeteria_approved"];
$dormitory = $rowaccess["is_dormitory_approved"];
$sport = $rowaccess['is_sport_approved'];
$bookstore = $rowaccess["is_bookstore_approved"];

// Initialize variables to hold fee amounts for different components
$course_coordinator = 0;
$library_fee = 0;
$cafeteria_fee = 0;
$dormitory_fee = 0;
$sport_fee = 0;
$bookstore_fee = 0;

// Loop through each fee component and assign the amount based on job_position
while ($row_individual_fee = $result_individual_fee->fetch_assoc()) {
    $job_position = $row_individual_fee['job_position'];
    $amount = $row_individual_fee['amount'];

    // Check job_position and assign the amount to the corresponding variable
    switch ($job_position) {
        case 'course coordinator':
            $course_coordinator += $amount;
            break;
        case 'library':
            $library_fee += $amount;
            break;
        case 'cafeteria':
            $cafeteria_fee += $amount;
            break;
        case 'dormitory':
            $dormitory_fee += $amount;
            break;
        case 'sport':
            $sport_fee += $amount;
            break;
        case 'bookstore':
            $bookstore_fee += $amount;
            break;
        default:
            // Handle other job_positions if needed
            break;
    }
}

// Calculate total fee
$total_fee = $course_coordinator + $library_fee + $cafeteria_fee + $dormitory_fee + $bookstore_fee + $sport_fee;

// Get total payment
$sql_total_payment = "SELECT SUM(amount) AS tot_pay FROM payment WHERE  matric_no = '$matric_no'";
$result_total_payment = $conn->query($sql_total_payment);
$row_total_payment = mysqli_fetch_array($result_total_payment);
$tot_pay = $row_total_payment['tot_pay'];

// Calculate outstanding fee
$outstanding_fee = $total_fee - $tot_pay;

// Clear total fee and individual fee components if outstanding fee is 0
if ($total_fee == 0) {
    $outstanding_fee = 0;
    $course_coordinator = 0;
    $library_fee = 0;
    $cafeteria_fee = 0;
    $dormitory_fee = 0;
    $sport_fee = 0;
    $bookstore_fee = 0;
    // Check if all status are cleared and set status to cleared if so
    if ($course == 1 && $library == 1 && $cafeteria == 1 && $dormitory == 1 && $sport == 1 && $bookstore == 1) {
        $is_cleared = true;
    } else {
        $is_cleared = false;
    }
} else {
    $is_cleared = false;
}

// HTML and JavaScript section
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard | Online clearance System</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
<!-- Morris -->
<link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
<!-- Gritter -->
<link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
<link href="css/animate.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
<style type="text/css">
<!--
.style1 {color: #000000}
.style2 {color: #FF0000}
-->
</style>
</head>
<body>
<div class="ibox-content">
    <h3 class="no-margins">
        <?php if ($is_cleared) { ?>
            <div align="center"><i class="fa fa-check-circle" style="font-size:28px;color:green"></i>
                <?php echo "Cleared"; ?>
            </div>
        <?php } else { ?>
            <div align="center"><i class="fa fa-times-circle" style="font-size:28px;color:orange"></i>
                <?php echo "Pending"; ?>
            </div>
        <?php } ?> 
    </h3>
    
</div>

<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                             <img src="<?php echo $rowaccess['photo'];  ?>" alt="image" width="142" height="153" class="img-circle" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"><span class="text-muted text-xs block">Matric No:<?php echo $matric_no; ?> <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>  
                    <?php
                    include('sidebar.php');
                    ?>
                </li>
            </ul>
        </div>
    </nav>
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome <?php echo $rowaccess['fullname']; ?></span>
                    </li>
                    <li class="dropdown">
                        <li>
                            <a href="logout.php">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="wrapper wrapper-content">
            <div class="row">
                <?php 
                $query = "SELECT * FROM students "; 
                $result = mysqli_query($conn, $query); 
                if ($result) { 
                    // It returns the number of rows in the table. 
                    $row_students = mysqli_num_rows($result); 
                }
                ?>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><span class="label label-primary pull-right">Total Fee</span></h5>
                        </div>
                        <div class="ibox-content">
                            <h3 class="no-margins">ETB<?php echo number_format((float) $total_fee ,2); ?></h3>
                            <small> </small> 
                        </div>
                    </div>
                </div>             
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><span class="label label-secondary pull-right">Amount Paid</span></h5>
                        </div>
                        <div class="ibox-content">
                            <h3 class="no-margins">ETB<?php echo number_format((float) $tot_pay ,2); ?></h3>
                            <small> </small> 
                        </div>
                    </div>
                </div>    
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><span class="label label-info pull-right">Status</span></h5>
                        </div>
                        <div class="ibox-content">
                            <h3 class="no-margins">
                                <?php if ($is_cleared) { ?>
                                <div align="center"><i class="fa fa-check-circle" style="font-size:28px;color:green"></i>
                                    <?php echo "Cleared"; ?></div>
                                <?php } else {?>
                                <div align="left"><i class="fa fa-times-circle" style="font-size:28px;color:orange"></i>
                                    <?php echo "Pending"; ?></div>
                                <?php } ?> 
                            </h3>
                            <p class="no-margins">&nbsp;</p>
                            <?php if ($is_cleared)  { ?>
                                <span class="style2"><small> <a href="letter.php" target="_blank">Print Clearance Letter</a></small></span>  
                            <?php } ?>
                        </div>
                    </div>
                </div>    
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><span class="label label-success pull-right"><h2>Individual fee</h2></span></h5>
                        </div>
                        <div class="ibox-content">
                            <h3 class="no-margins">Course Coordinator: <?php echo number_format((float) $course_coordinator ,2); ?>  </h3>
                            <small> </small> 
                        </div>
                        <div class="ibox-content">
                            <h3 class="no-margins">Library: <?php echo number_format((float) $library_fee ,2); ?>  </h3>
                            <small> </small> 
                        </div>
                        <div class="ibox-content">
                            <h3 class="no-margins">Cafeteria: <?php echo number_format((float) $cafeteria_fee ,2); ?>  </h3>
                            <small> </small> 
                        </div>
                        <div class="ibox-content">
                            <h3 class="no-margins">Dormitory: <?php echo number_format((float) $dormitory_fee ,2); ?>  </h3>
                            <small> </small> 
                        </div>
                        <div class="ibox-content">
                            <h3 class="no-margins">Bookstore: <?php echo number_format((float) $bookstore_fee,2); ?>  </h3>
                            <small> </small> 
                        </div>
                        <div class="ibox-content">
                            <h3 class="no-margins">Sport: <?php echo number_format((float) $sport_fee ,2); ?>  </h3>
                            <small> </small> 
                        </div>
                        <div class="ibox-content">
                            <h3 class="no-margins">Total Fee: <?php echo number_format((float) $total_fee ,2); ?>  </h3>
                            <small> </small> 
                        </div>

                    </div>
                </div>             
 
                <div class="row">
                    <div class="col-lg-12"> 
                        <p>&nbsp;</p>
                        <p>
                        </p>
                        <p>      </p>
                        <table width="1201" height="341" align="center">
                            <tr>
                                <td width="1237">
                                    <table border="0" align="center" class="table table-hover no-margins">
                                        <thead>
                                            <tr>
                                                <th width="5%"><div align="center"><span class="style1">Fee </span></div></th>
                                                <th width="5%"><div align="center">Course coordinator </div></th>
                                                <th width="5%"><div align="center">Library </div></th>
                                                <th width="5%"><div align="center">Cafeteria </div></th>
                                                <th width="5%"><div align="center">Dormitory </div></th>
                                                <th width="5%"><div align="center">Sport </div></th>
                                                <th width="5%"><div align="center">Bookstore </div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?php if ($outstanding_fee == 0) { ?>
                                                    <div align="center"><span class="label label-primary">Cleared</span> </div>
                                                    <?php } else {?>
                                                    <div align="center"><span class="label label-warning">Pending</span> </div>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($rowaccess['is_course_cordinator_approved'] == 0) { ?>
                                                    <div align="center"><span class="label label-warning">Pending</span> </div>
                                                    <?php } else {?>
                                                    <div align="center"><span class="label label-primary">Cleared</span> </div>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($rowaccess['is_library_approved'] == 0) { ?>
                                                    <div align="center"><span class="label label-warning">Pending</span> </div>
                                                    <?php } else {?>
                                                    <div align="center"><span class="label label-primary">Cleared</span> </div>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($rowaccess['is_cafeteria_approved'] == 0) { ?>
                                                    <div align="center"><span class="label label-warning">Pending</span> </div>
                                                    <?php } else {?>
                                                    <div align="center"><span class="label label-primary">Cleared</span> </div>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($rowaccess['is_dormitory_approved'] == 0) { ?>
                                                    <div align="center"><span class="label label-warning">Pending</span> </div>
                                                    <?php } else {?>
                                                    <div align="center"><span class="label label-primary">Cleared</span> </div>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($rowaccess['is_sport_approved'] == 0) { ?>
                                                    <div align="center"><span class="label label-warning">Pending</span> </div>
                                                    <?php } else {?>
                                                    <div align="center"><span class="label label-primary">Cleared</span> </div>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($rowaccess['is_bookstore_approved'] == 0) { ?>
                                                    <div align="center"><span class="label label-warning">Pending</span> </div>
                                                    <?php } else {?>
                                                    <div align="center"><span class="label label-primary">Cleared</span> </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <p align="center"></p>
                        <div class="row">&nbsp; </p>
                    </div>
                </div>


            </div>
            <div class="footer">
                <div>
                    <?php include('footer.php');  ?>            
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="js/plugins/flot/jquery.flot.time.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>
    <script src="js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script src="js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- EayPIE -->
    <script src="js/plugins/easypiechart/jquery.easypiechart.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="js/demo/sparkline-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('.chart').easyPieChart({
                barColor: '#f8ac59',
//                scaleColor: false,
                scaleLength: 5,
                lineWidth: 4,
                size: 80
            });

            $('.chart2').easyPieChart({
                barColor: '#1c84c6',
//                scaleColor: false,
                scaleLength: 5,
                lineWidth: 4,
                size: 80
            });

            var data2 = [
                [gd(2012, 1, 1), 7], [gd(2012, 1, 2), 6], [gd(2012, 1, 3), 4], [gd(2012, 1, 4), 8],
                [gd(2012, 1, 5), 9], [gd(2012, 1, 6), 7], [gd(2012, 1, 7), 5], [gd(2012, 1, 8), 4],
                [gd(2012, 1, 9), 7], [gd(2012, 1, 10), 8], [gd(2012, 1, 11), 9], [gd(2012, 1, 12), 6],
                [gd(2012, 1, 13), 4], [gd(2012, 1, 14), 5], [gd(2012, 1, 15), 11], [gd(2012, 1, 16), 8],
                [gd(2012, 1, 17), 8], [gd(2012, 1, 18), 11], [gd(2012, 1, 19), 11], [gd(2012, 1, 20), 6],
                [gd(2012, 1, 21), 6], [gd(2012, 1, 22), 8], [gd(2012, 1, 23), 11], [gd(2012, 1, 24), 13],
                [gd(2012, 1, 25), 7], [gd(2012, 1, 26), 9], [gd(2012, 1, 27), 9], [gd(2012, 1, 28), 8],
                [gd(2012, 1, 29), 5], [gd(2012, 1, 30), 8], [gd(2012, 1, 31), 25]
            ];

            var dataset = [
                {
                    label: "Number of orders",
                    data: data2,
                    color: "#1ab394",
                    bars: {
                        show: true,
                        align: "center",
                        barWidth: 24 * 60 * 60 * 600,
                        lineWidth: 0
                    }

                }
            ];

            var options = {
                xaxis: {
                    mode: "time",
                    tickSize: [3, "day"],
                    tickLength: 0,
                    axisLabel: "Date",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 10,
                    color: "#d5d5d5"
                },
                yaxis: {
                    axisLabel: "Value",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 3,
                    color: "#d5d5d5"
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        fillColor: {
                            colors: [
                                {
                                    opacity: 0.2
                                }, {
                                    opacity: 0.1
                                }
                            ]
                        },
                        lineWidth: 2
                    },
                    points: {
                        show: true
                    },
                    shadowSize: 0
                },
                legend: {
                    show: false
                },
                tooltip: {
                    show: true,
                    content: "<span style='font-size: 10px;'>%y Orders</span> <span style='font-size: 10px;'>on %x</span>",
                    shifts: {
                        x: -60,
                        y: 25
                    },
                    defaultTheme: false
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#d5d5d5",
                    borderWidth: 1,
                    color: '#d5d5d5'
                },
                colors: ["#1ab394"],
                hooks: {
                    draw: function() {
                        var ctx = this.getCanvas().getContext("2d");
                        var x = this.series[0].bars['bars'][0].x;
                        var y = this.series[0].bars['bars'][0].y;
                        ctx.fillText("Cleared", x, y);
                    }
                }
            };

            function gd(year, month, day) {
                return new Date(year, month - 1, day).getTime();
            }

            var previousPoint = null, previousLabel = null;

            $.plot($("#flot-dashboard-chart"), dataset, options);

            var doughnutData = {
                labels: ["App","Software","Laptop" ],
                datasets: [{
                    data: [300,50,100],
                    backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
                }]
            } ;

            var doughnutOptions = {
                responsive: false,
                legend: {
                    display: false
                }
            };

            var ctx4 = document.getElementById("doughnutChart").getContext("2d");
            new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

            var doughnutData = {
                labels: ["App","Software","Laptop" ],
                datasets: [{
                    data: [300,50,100],
                    backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
                }]
            } ;

            var doughnutOptions = {
                responsive: false,
                legend: {
                    display: false
                }
            };

            var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
            new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

            var doughnutData = {
                labels: ["App","Software","Laptop" ],
                datasets: [{
                    data: [300,50,100],
                    backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
                }]
            } ;

            var doughnutOptions = {
                responsive: false,
                legend: {
                    display: false
                }
            };

            var ctx4 = document.getElementById("doughnutChart3").getContext("2d");
            new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

        });
    </script>
</body>
</html>
