<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Record | Dashboard</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <style>
        /* Custom CSS for table styling */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border: 3px solid #dee2e6;
        }
        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 3px solid #dee2e6;
            border-left: 3px solid #dee2e6;
        }
        .table th:first-child,
        .table td:first-child {
            border-left: 3px;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 3px solid #dee2e6;
        }
        .table tbody+tbody {
            border-top: 3px solid #dee2e6;
        }
        .table-bordered {
            border: 3px solid #dee2e6;
        }
        .table-bordered th,
        .table-bordered td {
            border: 3px solid #dee2e6;
        }
        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 4px;
        }
        /* Outside border */
        .outer-border {
            border: 4px solid #dee2e6;
            padding: 1rem;
            margin: 30px;
        }
        .request{
            margin-left: 800px;
            margin-right: 800px;
            border: 4px;
            background-color:#007bff;
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
                <a href="#" class="nav-link" id="a">Home</a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <!-- Your sidebar code here -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <!-- Content header -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Table with outer border -->
                <div class="outer-border">
                    <div class="request" style="display: inline;"><center><h4>Students Clearance Request Detail</h4></center></div>

                    <!-- Table -->
                    <table class="table" id="example">
                        <!-- Table header -->
                        <thead>
                            <tr>
                                <th width="10%"><div align="center">Full Name</div></th>
                                <th width="5%"><div align="center">Matric No</div></th>
                                <th width="5%"><div align="center">Sex</div></th>
                                <th width="6%"><div align="center">Faculty</div></th>
                                <th width="5%"><div align="center">Department</div></th>
                                <th width="6%"><div align="center">Reason</div></th>
                                <th width="7%"><div align="center">School Year</div></th>
                                <th width="7%"><div align="center">Date</div></th>
                                <th width="6%"><div align="center">Action</div></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                                // Include the file that contains database connection details
                                include('connect.php');
                                
                                // Check if the connection is successful
                                if ($conn === false) {
                                    die("ERROR: Could not connect. " . mysqli_connect_error());
                                }
                                
                                // Query to fetch data from students and clearance_requests tables
                                $sql = "SELECT s.fullname, s.matric_no, s.sex, s.faculty, s.dept, c.reason, c.school_year, c.date 
                                        FROM students s 
                                        INNER JOIN clearance_requests c ON s.matric_no = c.matric_no";
                                $result = $conn->query($sql);

                                // Check if there are rows returned from the query
                                if ($result->num_rows > 0) {
                                    // Loop through each row of the result set
                                    while ($row = $result->fetch_assoc()) {
                                        // Access data from the $row variable here
                            ?>
                            <tr>
                                <td><?php echo $row['fullname']; ?></td>
                                <td><?php echo $row['matric_no']; ?></td>
                                <td><?php echo $row['sex']; ?></td>
                                <td><?php echo $row['faculty']; ?></td>
                                <td><?php echo $row['dept']; ?></td>
                                <td><?php echo $row['reason']; ?></td>
                                <td><?php echo $row['school_year']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-danger btn-flat">Action</button>
                                        <button type="button" class="btn btn-danger btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item" href="delete_request.php?matric_no=<?php echo $row['matric_no']; ?>" onClick="return ConfirmDelete('<?php echo $row['fullname']; ?>');">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                    } 
                                } else {
                                    echo "<tr><td colspan='9'>No clearance requests found.</td></tr>";
                                }
                                // Close the database connection
                                $conn->close();
                            ?>
                        </tbody>

                        <!-- Table footer -->
                        <tfoot>
                            <tr>
                                <td colspan="9">&nbsp;</td>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- Table end -->
                </div>
                <!-- /.outer-border -->
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
    <!-- Footer -->
    <footer class="main-footer">
        <!-- Footer content here -->
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<!-- Your custom JavaScript -->
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });

    function ConfirmDelete(fullname) {
        return confirm("Are you sure you want to delete " + fullname + " from the database?");
    }
</script>
</body>
</html>
