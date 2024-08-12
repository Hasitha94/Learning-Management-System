<?php
// Start session (ensure it's the first thing in the file)
session_start();

// Example code to send messages
// Modify as per your actual logic to handle message sending

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['message'])) {
        // Process the message here (insert into database, etc.)
        $message = $_POST['message'];

        // Example: Save to database
        $sender_id = $_SESSION['sturecmsuid']; // Assuming you have a session variable set for student ID
        $sent_at = date('Y-m-d H:i:s'); // Current timestamp
        $sql = "INSERT INTO tblmessages (sender_id, message_text, sent_at) VALUES (:sender_id, :message_text, :sent_at)";
        
        $query = $dbh->prepare($sql);
        $query->bindParam(':sender_id', $sender_id, PDO::PARAM_INT);
        $query->bindParam(':message_text', $message, PDO::PARAM_STR);
        $query->bindParam(':sent_at', $sent_at, PDO::PARAM_STR);
        
        if ($query->execute()) {
            // Message sent successfully
            header('Location: index.php'); // Redirect back to chat page after sending message
            exit;
        } else {
            // Handle error
            echo "Error sending message";
        }
    }
}
?>
