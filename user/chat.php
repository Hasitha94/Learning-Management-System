<?php include_once('includes/header.php'); ?>
<?php include_once('includes/sidebar.php'); ?>

<div class="content-wrapper">
    <link rel="stylesheet" href="css/style.css">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="chat-container">
                        <div class="messages" id="messages">
                            <?php include('load-messages.php'); ?>
                        </div>
                        <form id="message-form" action="send-message.php" method="POST">
                            <textarea id="message-input" name="message" rows="3" placeholder="Type your message..."></textarea>
                            <button type="submit" id="send-button">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="js/chat.js"></script>
