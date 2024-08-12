<?php

if (isset($_GET['q']) && $_GET['q'] == 'quiz' && isset($_GET['step']) && $_GET['step'] == 2) {
    // Sanitize inputs
    $eid = mysqli_real_escape_string($con, $_GET['eid']);
    $sn = (int)$_GET['n'];
    $total = (int)$_GET['t'];
    $ans = $_POST['ans'];
    $qid = mysqli_real_escape_string($con, $_GET['qid']);

    // Retrieve the correct answer from the database
    $q = mysqli_query($con, "SELECT ansid FROM answer WHERE qid='$qid'");
    $row = mysqli_fetch_array($q);
    $ansid = $row['ansid'];

    // Check if the answer is correct
    if ($ans == $ansid) {
        // Update user's score and level
        $q = mysqli_query($con, "SELECT sahi, wrong FROM quiz WHERE eid='$eid'");
        $row = mysqli_fetch_array($q);
        $sahi = $row['sahi'];
        $wrong = $row['wrong'];

        if ($sn == 1) {
            mysqli_query($con, "INSERT INTO history VALUES('$email','$eid',0,0,0,0,NOW())");
        }

        mysqli_query($con, "UPDATE history SET score=score+$sahi, level=$sn, sahi=sahi+1, date=NOW() WHERE email='$email' AND eid='$eid'");
    } else {
        // Update user's score and level for wrong answer
        $q = mysqli_query($con, "SELECT wrong FROM quiz WHERE eid='$eid'");
        $row = mysqli_fetch_array($q);
        $wrong = $row['wrong'];

        if ($sn == 1) {
            mysqli_query($con, "INSERT INTO history VALUES('$email','$eid',0,0,0,0,NOW())");
        }

        mysqli_query($con, "UPDATE history SET score=score-$wrong, level=$sn, wrong=wrong+1, date=NOW() WHERE email='$email' AND eid='$eid'");
    }

    // Redirect to the next question or results page
    if ($sn != $total) {
        $sn++;
        header("Location: account.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total");
        exit;
    } else {
        if ($_SESSION['key'] != 'sunny7785068889') {
            // Update user's score in the rank table
            $q = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND email='$email'");
            $row = mysqli_fetch_array($q);
            $s = $row['score'];

            $q = mysqli_query($con, "SELECT * FROM rank WHERE email='$email'");
            $rowcount = mysqli_num_rows($q);

            if ($rowcount == 0) {
                mysqli_query($con, "INSERT INTO rank VALUES('$email','$s',NOW())");
            } else {
                $q = mysqli_query($con, "SELECT score FROM rank WHERE email='$email'");
                $row = mysqli_fetch_array($q);
                $sun = $row['score'] + $s;

                mysqli_query($con, "UPDATE rank SET score=$sun, time=NOW() WHERE email='$email'");
            }
        }
        header("Location: account.php?q=result&eid=$eid");
        exit;
    }
} else {
    header("Location: some_error_page.php"); // Redirect to an error page if the parameters are not set correctly
    exit;
}


?>