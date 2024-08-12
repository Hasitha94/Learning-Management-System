<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
                        function insertQuestion($dbh, $eid, $question, $sn)
                        {
                            $qid = uniqid();
                            $ch = "4";

                            $sql = "INSERT INTO tblquestion (eid, qid, question, choice, sn) VALUES (:eid, :qid, :question, :ch, :sn)";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                            $query->bindParam(':qid', $qid, PDO::PARAM_STR);
                            $query->bindParam(':question', $question, PDO::PARAM_STR);
                            $query->bindParam(':ch', $ch, PDO::PARAM_STR);
                            $query->bindParam(':sn', $sn, PDO::PARAM_STR);
                            $query->execute();

                            return $qid;
                        }

                        function insertOption($dbh, $qid, $opt)
                        {
                            $optionId = uniqid();

                            $sql = "INSERT INTO tbloption (qid, opt, optionid) VALUES (:qid, :opt, :optionid)";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':qid', $qid, PDO::PARAM_STR);
                            $query->bindParam(':opt', $opt, PDO::PARAM_STR);
                            $query->bindParam(':optionid', $optionId, PDO::PARAM_STR);
                            $query->execute();

                            return $optionId;
                        }

                        function insertAnswer($dbh, $qid, $ansid)
                        {
                            $sql = "INSERT INTO tblanswer (qid, ansid) VALUES (:qid, :ansid)";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':qid', $qid, PDO::PARAM_STR);
                            $query->bindParam(':ansid', $ansid, PDO::PARAM_STR);
                            $query->execute();
                        }

                        if (strlen($_SESSION['sturecmsaid'] == 0)) {
                            header('location:logout.php');
                        } else {
                            if (isset($_POST['submit'])) {
                                $total = @$_GET['total'];
                                $eid = @$_GET['eid'];
                                $success = true;

                                try {
                                    $dbh->beginTransaction();

                                    for ($i = 1; $i <= $total; $i++) {
                                        $question = $_POST['question' . $i];
                                        $sn = $i;

                                        $qid = insertQuestion($dbh, $eid, $question, $sn);

                                        $a = $_POST[$i . '1'];
                                        $b = $_POST[$i . '2'];
                                        $c = $_POST[$i . '3'];
                                        $d = $_POST[$i . '4'];

                                        $oaid = insertOption($dbh, $qid, $a);
                                        $obid = insertOption($dbh, $qid, $b);
                                        $ocid = insertOption($dbh, $qid, $c);
                                        $odid = insertOption($dbh, $qid, $d);

                                        $e = $_POST['ans' . $i];
                                        $ansid = '';

                                        switch ($e) {
                                            case 'a':
                                                $ansid = $oaid;
                                                break;
                                            case 'b':
                                                $ansid = $obid;
                                                break;
                                            case 'c':
                                                $ansid = $ocid;
                                                break;
                                            case 'd':
                                                $ansid = $odid;
                                                break;
                                            default:
                                                $ansid = $oaid;
                                        }

                                        insertAnswer($dbh, $qid, $ansid);
                                    }

                                    $dbh->commit();
                                    echo "Questions inserted successfully.";
                                    header("Location: manage-quiz.php");
                                } catch (Exception $e) {
                                    $dbh->rollBack();
                                    echo "Error Inserting Questions: " . $e->getMessage();
                                }
                            }
                        }
                    }
                }
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Smart Study Grade Hub || Add Questions </title>
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
                            <h3 class="page-title"> Add Questions </h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"> Add Questions </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row">

                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title" style="text-align: center;">Add Questions </h4>

                                        <form class="forms-sample" method="POST">

                                            <?php
                                            for ($i = 1; $i <= @$_GET['total']; $i++) {
                                            ?>

                                                <div class="form-group">
                                                    <label for="question">Question Number <?php echo $i ?> :</label>
                                                    <input type="text" id="question<?php echo $i ?>" name="question<?php echo $i ?>" placeholder="Enter Question Number <?php echo $i ?> here" class="form-control" required='true'>
                                                </div>

                                                <div class="form-group">
                                                    <label for="<?php echo $i ?>1">Enter option a:</label>
                                                    <input type="text" id="<?php echo $i ?>1" name="<?php echo $i ?>1" placeholder="Enter option a" class="form-control" required="true">
                                                </div>

                                                <div class="form-group">
                                                    <label for="<?php echo $i ?>2">Enter option b:</label>
                                                    <input type="text" id="<?php echo $i ?>2" name="<?php echo $i ?>2" placeholder="Enter option b" class="form-control" required="true">
                                                </div>

                                                <div class="form-group">
                                                    <label for="<?php echo $i ?>3">Enter option c:</label>
                                                    <input type="text" id="<?php echo $i ?>3" name="<?php echo $i ?>3" placeholder="Enter option c" class="form-control" required="true">
                                                </div>

                                                <div class="form-group">
                                                    <label for="<?php echo $i ?>4">Enter option d:</label>
                                                    <input type="text" id="<?php echo $i ?>4" name="<?php echo $i ?>4" placeholder="Enter option d" class="form-control" required="true">
                                                </div>

                                                <div class="form-group">
                                                    <label for="ans<?php echo $i ?>">Choose correct Answer</label>
                                                    <select name="ans<?php echo $i ?>" id="ans<?php echo $i ?>" class="form-control" required="true">
                                                        <option value="a">Select Answer for Question <?php echo $i ?> </option>
                                                        <option value="a">Option A</option>
                                                        <option value="b">Option B</option>
                                                        <option value="c">Option C</option>
                                                        <option value="d">Option D</option>
                                                    </select>
                                                </div>

                                            <?php } ?>

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

    </html>