<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $subject = $_POST['subject'];
        $name = $_POST['name'];
        $total = $_POST['total'];
        $correct = $_POST['correct'];
        $wrong = $_POST['wrong'];
        $time = $_POST['time'];
        $description = $_POST['description'];
        $id = uniqid();

        $sql = "insert into tblquiz(subject,name,total,correct,wrong,time,description,eid)values(:subject,:name,:total,:correct,:wrong,:time,:description,:id)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':subject', $subject, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':total', $total, PDO::PARAM_STR);
        $query->bindParam(':correct', $correct, PDO::PARAM_STR);
        $query->bindParam(':wrong', $wrong, PDO::PARAM_STR);
        $query->bindParam(':time', $time, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $LastInsertId = $dbh->lastInsertId();
        if ($LastInsertId > 0) {
            echo '<script>alert("Quiz has been added.")</script>';
            echo "<script>window.location.href ='add-quiz-part.php?eid=$id&total=$total'</script>";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Smart Study Grade Hub || Add Quiz</title>
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
                                    <li class="breadcrumb-item active" aria-current="page"> Add Quiz</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row">

                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title" style="text-align: center;">Add Quiz</h4>

                                        <form class="forms-sample" method="post">

                                            <div class="form-group">
                                                <label for="Subject">Select Subject</label>
                                                <select name="subject" class="form-control" required='true'>
                                                    <option value="">Select Subject</option>
                                                    <?php
                                                    $sql2 = "SELECT * from tblsubject";
                                                    $query2 = $dbh->prepare($sql2);
                                                    $query2->execute();
                                                    $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                    foreach ($result2 as $row1) {
                                                    ?>
                                                        <option value="<?php echo htmlentities($row1->ID); ?>">
                                                            <?php echo htmlentities($row1->SubjectName); ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">Quiz Name</label>
                                                <input type="text" id="name" name="name" placeholder="Enter Quiz title" class="form-control" required='true'>
                                            </div>

                                            <div class="form-group">
                                                <label for="total">Number Of Questions</label>
                                                <input type="number" id="total" name="total" placeholder="Enter total number of questions" class="form-control" required='true'>
                                            </div>

                                            <div class="form-group">
                                                <label for="correct">Enter Marks for Correct Answer</label>
                                                <input type="number" id="correct" name="correct" placeholder="Enter Marks for Correct Answer" min="0" class="form-control" required='true'>
                                            </div>

                                            <div class="form-group">
                                                <label for="wrong">Enter the Penalty Marks for Wrong Answer </label>
                                                <input type="number" id="wrong" name="wrong" placeholder="Enter the Penalty Marks for Wrong Answer" min="0" class="form-control" required='true'>
                                            </div>

                                            <div class="form-group">
                                                <label for="time">Enter the time for Test </label>
                                                <input type="number" id="time" name="time" placeholder="Enter the time for test in miniutes" min="0" class="form-control" required='true'>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Enter the Description ... </label>
                                                <input type="text" id="description" name="description" placeholder="Enter the Description" class="form-control">
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