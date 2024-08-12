<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        $answer = $_POST['ans'];
        $qid = $_POST['qid'];
        $sn = $_GET['n'];
        $eid = $_POST['eid'];

        $sql = "SELECT * from tblanswer where tblanswer.qid=:qid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':qid', $qid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($results as $row) {
            $ansid = $row->ansid;
        }

        $sql = "SELECT * FROM tblquiz WHERE eid = '$eid'";
        $query = $dbh->prepare($sql);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($results as $row) {
            $correctmark = $row->correct;
            $wrongmark = $row->wrong;
            $total = $row->total;
        }

        $userid = $_SESSION['sturecmsstuid'];
        $sql = "SELECT * FROM tblstudent WHERE StuID = '$userid'";
        $query = $dbh->prepare($sql);
        $query->bindParam(':userid', $userid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($results as $row) {
            $email = $row->StudentEmail;
        }

        // $email = "pubudunavod98@gmail.com";

        if ($answer == $ansid) {

            if ($sn == 1) {

                $sql = "insert into tblhistory(email,eid,score,level,correct,wrong,date)values(:email,:eid,'0','0','0','0',NOW())";
                $query = $dbh->prepare($sql);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->execute();

                $sql1 = "SELECT * FROM tblhistory WHERE eid = '$eid' AND email = '$email'";
                $query = $dbh->prepare($sql1);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                foreach ($results as $row) {
                    $score = $row->score;
                }

                $correct++;
                $score = $correctmark + $score;


                $sql = "UPDATE tblhistory SET score=:score, level=:sn, correct=:correct, date=NOW() WHERE email=:email AND eid=:eid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':score', $score, PDO::PARAM_STR);
                $query->bindParam(':sn', $sn, PDO::PARAM_STR);
                $query->bindParam(':correct', $correct, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->execute();
            } else {

                $sql1 = "SELECT * FROM tblhistory WHERE eid = '$eid' AND email = '$email'";
                $query = $dbh->prepare($sql1);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                foreach ($results as $row) {
                    $score = $row->score;
                    $correct = $row->correct;
                }

                $correct++;
                $score = $correctmark + $score;

                $sql = "UPDATE tblhistory SET score=:score, level=:sn, correct=:correct, date=NOW() WHERE email=:email AND eid=:eid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':score', $score, PDO::PARAM_STR);
                $query->bindParam(':sn', $sn, PDO::PARAM_STR);
                $query->bindParam(':correct', $correct, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->execute();
            }
        } else {

            $sql = "SELECT * FROM tblquiz WHERE eid = '$eid'";
            $query = $dbh->prepare($sql);
            $query->bindParam(':eid', $eid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            foreach ($results as $row) {
                $wrongmark = $row->wrong;
            }

            if ($sn == 1) {

                $sql = "insert into tblhistory(email,eid,score,level,correct,wrong,date)values(:email,:eid,'0','0','0','0',NOW())";
                $query = $dbh->prepare($sql);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->execute();

                $sql1 = "SELECT * FROM tblhistory WHERE eid = '$eid' AND email = '$email'";
                $query = $dbh->prepare($sql1);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);


                foreach ($results as $row) {
                    $score = $row->score;
                    $wrong = $row->wrong;
                }

                $wrong++;
                $score = $score - $wrongmark;

                $sql = "UPDATE tblhistory SET score=:score, level=:sn, wrong=:wrong, date=NOW() WHERE email=:email AND eid=:eid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':score', $score, PDO::PARAM_STR);
                $query->bindParam(':sn', $sn, PDO::PARAM_STR);
                $query->bindParam(':wrong', $wrong, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->execute();
            } else {

                $sql1 = "SELECT * FROM tblhistory WHERE eid = '$eid' AND email = '$email'";
                $query = $dbh->prepare($sql1);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);


                foreach ($results as $row) {
                    $score = $row->score;
                    $wrong = $row->wrong;
                }

                $wrong++;
                $score = $score - $wrongmark;

                $sql = "UPDATE tblhistory SET score=:score, level=:sn, wrong=:wrong, date=NOW() WHERE email=:email AND eid=:eid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':score', $score, PDO::PARAM_STR);
                $query->bindParam(':sn', $sn, PDO::PARAM_STR);
                $query->bindParam(':wrong', $wrong, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->execute();
            }
        }

        // Redirect to the next question or results page
        if (
            $sn != $total
        ) {
            $sn++;
            header("Location: account.php?eid=$eid&n=$sn");
        } else {
            header("Location: quiz-result.php?eid=$eid");
        }
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Smart Study Grade Hub ||| Quiz </title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
        <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <!-- endinject -->
        <!-- Layout styles -->
        <link rel="stylesheet" href="./css/style.css">
        <!-- End layout styles -->

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
                            <h3 class="page-title"> Quiz Start </h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"> Quiz </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex align-items-center mb-4">
                                            <h4 class="card-title mb-sm-0">Manage Class</h4>
                                            <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> View all Classes</a>
                                        </div>
                                        <div class="table-responsive border rounded p-1">


                                            <form action="" method="post">

                                                <?php

                                                $eid = @$_GET['eid'];
                                                $sn = @$_GET['n'];
                                                $total = @$_GET['total'];

                                                $sql = "SELECT * FROM tblquestion WHERE eid='$eid' AND sn='$sn'";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                                                $query->bindParam(':sn', $sn, PDO::PARAM_INT);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                foreach ($results as $row) {
                                                    $question = $row->question;
                                                    $sn = $row->sn;
                                                    $qid = $row->qid;

                                                    echo "Question ID: $sn, Question: $question <br>";
                                                } ?>

                                                <?php
                                                $sql1 = "SELECT * FROM tbloption WHERE qid='$qid'";
                                                $query = $dbh->prepare($sql1);
                                                $query->bindParam(':qid', $qid, PDO::PARAM_STR);
                                                $query->execute();
                                                $results1 = $query->fetchAll(PDO::FETCH_OBJ);

                                                foreach ($results1 as $row) {
                                                    $option = $row->opt;
                                                    $optionid = $row->optionid;

                                                ?>
                                                    <input type="hidden" name="eid" value="<?php echo $eid ?>">
                                                    <input type="hidden" name="qid" value="<?php echo $qid ?>">
                                                    <input type="hidden" name="sn" value="<?php echo $sn ?>">
                                                    <input type="radio" name="ans" required value="<?php echo $optionid ?>"> <?php echo $option ?> <br>

                                                <?php } ?>

                                                <button type="submit" class="btn btn-primary mr-2" name="submit">Next</button>

                                            </form>


                                        </div>

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
        <script src="./vendors/chart.js/Chart.min.js"></script>
        <script src="./vendors/moment/moment.min.js"></script>
        <script src="./vendors/daterangepicker/daterangepicker.js"></script>
        <script src="./vendors/chartist/chartist.min.js"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="js/off-canvas.js"></script>
        <script src="js/misc.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page -->
        <script src="./js/dashboard.js"></script>
        <!-- End custom js for this page -->
    </body>

    </html><?php }  ?>