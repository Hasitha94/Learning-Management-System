<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid'] == 0)) {
    header('location:logout.php');
} else {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Smart Study Grade Hub || View Assignments</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
        <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="vendors/select2/select2.min.css">
        <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <!-- endinject -->
        <!-- Layout styles -->
        <link rel="stylesheet" href="css/style.css" />

    </head>

    <body>
        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <?php include_once('includes/header.php'); ?>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_sidebar.html -->
                <?php include_once('includes/sidebar.php'); ?>
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="page-header">
                            <h3 class="page-title"> View Assignment </h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"> View Assignment</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row">

                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">

                                        <table border="1" class="table table-bordered mg-b-0">
                                            <?php
                                            $stuclass = $_SESSION['stuclass'];
                                            // $sql = "SELECT tblclass.ID,tblclass.ClassName,tblclass.Section,tblnotice.NoticeTitle,tblnotice.CreationDate,tblnotice.ClassId,tblnotice.NoticeMsg,tblnotice.ID as nid from tblnotice join tblclass on tblclass.ID=tblnotice.ClassId where tblnotice.ClassId=:stuclass";
                                            $sql = "SELECT tblclass.ID,tblclass.ClassName,tblclass.Section,tblassignment.ID,tblassignment.Assignment_Name,tblassignment.Grade,tblassignment.Assignment_File,tblassignment.ID as nid from tblassignment join tblclass on tblclass.ID=tblassignment.Grade where tblassignment.Grade=:stuclass";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':stuclass', $stuclass, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $row) {
                                                    $name = $row->Assignment_File;
                                                    ?>
                                                    <tr align="center" class="table-warning">
                                                        <td colspan="4" style="font-size:20px;color:blue">
                                                            Assignment</td>
                                                    </tr>
                                                    <tr class="table-info">
                                                        <th>Assignment Name </th>
                                                        <td><?php echo $row->Assignment_Name; ?></td>
                                                    </tr>
                                                    <tr class="table-info">
                                                        <th>Assignment Grade</th>
                                                        <td><?php echo $row->ClassName; ?></td>
                                                    </tr>
                                                    <tr class="table-info">
                                                        <th>Assignment File</th>
                                                        <td><a href="download.php?filename=<?php echo $name; ?>&id=<?php echo $row->ID; ?>">Download</a></td>
                                                    </tr>

                                                <?php
                                                }
                                            } else { ?>
                                                <tr>
                                                    <th colspan="2" style="color:red;">No Assignment Found</th>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->
                    <?php include_once('includes/footer.php'); ?>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="vendors/js/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="vendors/select2/select2.min.js"></script>
        <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="js/off-canvas.js"></script>
        <script src="js/misc.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page -->
        <script src="js/typeahead.js"></script>
        <script src="js/select2.js"></script>
        <!-- End custom js for this page -->
    </body>

    </html><?php }  ?>