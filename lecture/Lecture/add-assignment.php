<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {

                if (isset($_POST['submit'])) {
                    $assignmentname = $_POST['assignmentname'];
                    $grade = $_POST['gradeid'];
                    $filename = $_FILES['assignmentfile']['name'];
                    $destination = 'assignments/' . $filename;
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $file = $_FILES['assignmentfile']['tmp_name'];
                    $size = $_FILES['assignmentfile']['size'];

                    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
                        echo '<script>alert("Doc type should be zip pdf docx!")</script>';
                    } elseif ($size > 100000000
                    ) {
                        echo '<script>alert("File size is too Large!")</script>';
                    } else {
                        if (move_uploaded_file($file, $destination)) {
                            // Prepare the SQL statement
                            $sql = "INSERT INTO tblassignment (Assignment_Name, Grade, Assignment_File) VALUES (:assignmentname, :grade, :filename)";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':assignmentname', $assignmentname, PDO::PARAM_STR);
                            $query->bindParam(':grade', $grade, PDO::PARAM_INT);
                            $query->bindParam(':filename', $filename, PDO::PARAM_STR);
                            // Execute the query
                            if ($query->execute()) {
                                echo "<script>alert('File uploaded successfully!')</script>";
                                echo "<script>window.location.href ='add-assignment.php'</script>";
                            } else {
                                echo '<script>alert("Failed to insert into database!")</script>';
                            }
                        } else {
                            echo '<script>alert("Failed to move uploaded file!")</script>';
                        }
                    }
                }
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Smart Study Grade Hub || Add Assignment</title>
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
                            <h3 class="page-title"> Add Class </h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"> Add Assignment</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row">

                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title" style="text-align: center;">Add Assignment</h4>

                                        <form class="forms-sample" method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label for="AssignmentName">Assignment Name</label>
                                                <input type="text" name="assignmentname" class="form-control" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="AssignmentName">Grade</label>
                                                <select name="gradeid" class="form-control" required='true'>
                                                    <option value="">Select Grade</option>
                                                    <?php
                                                    $sql2 = "SELECT * from tblclass ";
                                                    $query2 = $dbh->prepare($sql2);
                                                    $query2->execute();
                                                    $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                    foreach ($result2 as $row1) {
                                                    ?>
                                                        <option value="<?php echo htmlentities($row1->ID); ?>">
                                                            <?php echo htmlentities($row1->ClassName); ?>
                                                            <?php echo htmlentities($row1->Section); ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="assignmentfile">Assignment File</label>
                                                <input type="file" name="assignmentfile" id="assignmentfile" class="form-control" required='true'>
                                            </div>

                                            <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>

                                        </form>
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