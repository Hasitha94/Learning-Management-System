<!-- Include header and sidebar -->
<?php include_once('includes/header.php'); ?>
<?php include_once('includes/sidebar.php'); ?>

<!-- Main content -->
<div class="content-wrapper">
    <link rel="stylesheet" href="css/style.css">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="chat-container">
                        <div class="messages" id="messages">
                            <!-- Include messages here -->
                            <?php include('load-messages.php'); ?>
                        </div>
                        <textarea id="message-input" rows="3" placeholder="Type your message..."></textarea>
                        <button id="send-button">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include footer -->
<?php include_once('includes/footer.php'); ?>

<!-- Include JavaScript files -->
<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="js/chat.js"></script>

