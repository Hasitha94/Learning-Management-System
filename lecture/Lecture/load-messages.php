<?php
include('includes/dbconnection.php');

$sql = "SELECT m.message_text, a.AdminName FROM tblmessages m INNER JOIN tbladmin a ON m.sender_id = a.ID ORDER BY m.sent_at ASC";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $result) {
    echo '<div class="message">';
    echo '<p><strong>' . htmlentities($result['AdminName']) . '</strong>: ' . htmlentities($result['message_text']) . '</p>';
    echo '</div>';
}
?>
