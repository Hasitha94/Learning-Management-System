<?php
session_start();
include('../includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid'] == 0)) {
    header('location:logout.php');
} else {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Smart Study Grade Hub ||| Subject Marks</title>
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
                            <h3 class="page-title"> Manage Marks </h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"> Subject Marks</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex align-items-center mb-4">
                                            <div class="wrap">
                                                <form action="" method="post">
                                                    <div class="form-group">
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

                                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Search</button>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="table-responsive border rounded p-1">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="font-weight-bold">S.ID</th>
                                                        <th class="font-weight-bold">Term</th>
                                                        <th class="font-weight-bold">Subject</th>
                                                        <th class="font-weight-bold">Marks</th>
                                                        <th class="font-weight-bold">#</th>
                                                        <th class="font-weight-bold">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sid = $_SESSION['sturecmsstuid'];
                                                    if (isset($_GET['pageno'])) {
                                                        $pageno = $_GET['pageno'];
                                                    } else {
                                                        $pageno = 1;
                                                    }



                                                    if (isset($_POST['submit'])) {
                                                        $subjectid = $_POST['subject'];

                                                        // $sql = "SELECT tblsubject.ID from tblsubject where tblsubject.ID=:subjectId";
                                                        // $query3 = $dbh->prepare($sql);
                                                        // $query3->bindParam(':subjectId', $subjectId, PDO::PARAM_STR);
                                                        // $query3->execute();
                                                        // $results4 = $query3->fetchAll(PDO::FETCH_OBJ);

                                                        $sid = $_SESSION['sturecmsstuid'];
                                                        // Formula for pagination
                                                        $no_of_records_per_page = 15;
                                                        $offset = ($pageno - 1) * $no_of_records_per_page;
                                                        $ret = "SELECT tblasmarks.ID,tblasmarks.Student_ID,tblasmarks.Term,tblasmarks.Subject,tblasmarks.Mark,tblsubject.SubjectName from tblasmarks join tblsubject on tblasmarks.Subject=tblsubject.ID where tblasmarks.Student_ID=:sid";
                                                        $query1 = $dbh->prepare($ret);
                                                        $query1->execute();
                                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                                        $total_rows = $query1->rowCount();
                                                        $total_pages = ceil($total_rows / $no_of_records_per_page);
                                                        // $sql = "SELECT tblasmarks.ID,tblasmarks.Student_ID,tblasmarks.Term,tblasmarks.Subject,tblasmarks.Mark,tblsubject.SubjectName from tblasmarks join tblsubject on tblasmarks.Subject=tblsubject.ID where tblasmarks.Student_ID=:sid AND tblasmarks.Subject=:subjectid LIMIT $offset, $no_of_records_per_page";
                                                        $sql = "SELECT * from tblasmarks join tblsubject on tblasmarks.Subject=tblsubject.ID where tblasmarks.Subject=$subjectid AND tblasmarks.Student_ID=:sid LIMIT $offset, $no_of_records_per_page";
                                                        $query = $dbh->prepare($sql);
                                                        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);


                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $row) {               ?>
                                                                <tr>

                                                                    <td><?php echo htmlentities($row->Student_ID); ?></td>
                                                                    <td><?php echo htmlentities($row->Term); ?></td>
                                                                    <td><?php echo htmlentities($row->SubjectName); ?></td>
                                                                    <td><?php echo htmlentities($row->Mark); ?></td>
                                                                    <td><?php
                                                                        if ($row->Mark < 50) {
                                                                        ?>
                                                                            <a href="quiz-start.php?subjectid=<?php echo htmlentities($row->Subject); ?>">
                                                                                <h6>Quiz!</h6>
                                                                            </a>
                                                                        <?php
                                                                        } else {
                                                                        } ?>
                                                                    </td>
                                                                    <td>
                                                                        <div><a href="edit-class-detail.php?editid=<?php echo htmlentities($row->ID); ?>"><i class="icon-eye"></i></a>
                                                                            || <a href="manage-class.php?delid=<?php echo ($row->ID); ?>" onclick="return confirm('Do you really want to Delete ?');"> <i class="icon-trash"></i></a></div>
                                                                    </td>
                                                                </tr><?php
                                                                    }
                                                                }
                                                            }
                                                                        ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div align="left">
                                            <ul class="pagination">
                                                <li><a href="?pageno=1"><strong>First></strong></a></li>
                                                <li class="<?php if ($pageno <= 1) {
                                                                echo 'disabled';
                                                            } ?>">
                                                    <a href="<?php if ($pageno <= 1) {
                                                                    echo '#';
                                                                } else {
                                                                    echo "?pageno=" . ($pageno - 1);
                                                                } ?>"><strong style="padding-left: 10px">Prev></strong></a>
                                                </li>
                                                <li class="<?php if ($pageno >= $total_pages) {
                                                                echo 'disabled';
                                                            } ?>">
                                                    <a href="<?php if ($pageno >= $total_pages) {
                                                                    echo '#';
                                                                } else {
                                                                    echo "?pageno=" . ($pageno + 1);
                                                                } ?>"><strong style="padding-left: 10px">Next></strong></a>
                                                </li>
                                                <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a></li>
                                            </ul>
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
        <!-- Custom Icon Script -->
        <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
        <!-- End of Custom Icon Script -->
    </body>

    </html><?php }  ?>