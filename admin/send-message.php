// send-message.php

session_start();
include('includes/dbconnection.php');

$sender_id = $_SESSION['sturecmsaid'];
$message = $_POST['message'];

$sql = "INSERT INTO tblmessages (sender_id, message_text) VALUES (:sender_id, :message)";
$query = $dbh->prepare($sql);
$query->bindParam(':sender_id', $sender_id, PDO::PARAM_INT);
$query->bindParam(':message', $message, PDO::PARAM_STR);
$query->execute();
