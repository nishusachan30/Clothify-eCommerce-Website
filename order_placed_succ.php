<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/order_confirm_mail.php");

$order_id = $_GET['order_id'] ?? null;
?>
<body>
    <div class="success">
        <section class="active">
            <div class="modal-box">
                <i class="fa-regular fa-circle-check"></i>
                <h2>Order Placed Successfully</h2>
                <p style="text-align:center;">You will receive a confirmation email shortly.</p>
                <!-- Display the invoice number -->

                <div class="buttons text-center">
                    <p id="countdown" style="font-weight: bold;">Redirecting to my orders in <span id="time">3</span>
                        seconds...</p>
                    <a href="account.php?my_order&order_id=<?php echo htmlspecialchars($order_id); ?>"
                        class="btn btn-primary">Back to my orders</a>
                </div>
            </div>
        </section>
    </div>

    <!-- Countdown Timer -->
    <script>
        let countdownTime = 3; // Start countdown from 10 seconds
        const countdownElement = document.getElementById("time");

        // Function to update countdown every second
        const countdownInterval = setInterval(function () {
            countdownTime--; // Decrease time by 1 each second
            countdownElement.textContent = countdownTime; // Update the countdown display

            // Redirect when countdown reaches 0
            if (countdownTime <= 0) {
                clearInterval(countdownInterval); // Stop the countdown
                window.location.href = 'account.php?my_order'; // Redirect to the desired page
            }
        }, 1000); // 1000ms = 1 second
    </script>
</body>
</html>