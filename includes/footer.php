
</main>
<?php
include("includes/db.php");
include("includes/header.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require_once 'phpmailer/src/Exception.php';
require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php';

if (isset($_POST['form_subscribe'])) {
    $email = mysqli_real_escape_string($con, $_POST['email_subscribe']);

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email already exists in the database
        $checkEmailQuery = "SELECT * FROM newsletter_subscribers WHERE email = '$email'";
        $result = mysqli_query($con, $checkEmailQuery);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('You are already subscribed.');</script>";
        } else {
            // Insert email into the database
            $insertQuery = "INSERT INTO newsletter_subscribers (email, subscription_date) VALUES ('$email', NOW())";
            if (mysqli_query($con, $insertQuery)) {
                // Send confirmation email
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = 'shreyakush8604@gmail.com'; // SMTP username
                    $mail->Password = 'glcy aviv bmnt kkfp'; // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Sender and recipient
                    $mail->setFrom('noreply@clothify.com', 'Clothify Newsletter');
                    $mail->addAddress($email);

                    // Email content
                    $mail->isHTML(true);
                    $mail->Subject = 'Newsletter Subscription Confirmation';
                    $mail->Body = '<h1>Thank you for subscribing!</h1><p>You have successfully subscribed to the Clothify Newsletter.</p>';

                    $mail->send();
                    $message = '<div class="alert alert-success">Subscription successful! A confirmation email has been sent.</div>';
                } catch (Exception $e) {
                    $message = '<div class="alert alert-danger">Subscription successful, but the confirmation email could not be sent. Error: ' . $mail->ErrorInfo . '</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">Error subscribing. Please try again.</div>';
            }
        }
    } else {
        $message = '<div class="alert alert-danger">Please enter a valid email address.</div>';
    }
}
?>

<section id="home-newsletter" style="margin-top:20px; margin-bottom:0px; padding: 20px 0; background: #232f3e;">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3">
                <div class="single"
                    style="max-width: 400px; margin: 0 auto; text-align: center; position: relative; z-index: 2;"></div>
                <form action="" method="post">
                    <h2
                        style="font-size: 22px; color: white; text-align:center; text-transform: uppercase; margin-bottom: 20px; margin-top: 0;">
                        Subscribe To Clothify Newsletter</h2>
                    <?php if (isset($message))
                        echo $message; ?>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Enter Your Email Address"
                            name="email_subscribe" required>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit" name="form_subscribe">Subscribe</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer with Contact Info and Social Icons -->
<div id="footer" style="margin-top:0px; margin-bottom:0px; background: #1a242f;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Left Side: Customer Care Info -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="color: #fff; font-size: 14px;">
                    <p  style="margin-bottom: 0;">
                    <i class="fa fa-headset" style="margin-right: 5px;"></i> +1 800 123 4567<br>
                    <a href="../contactus.php" style="text-decoration:none;"><i class="fa fa-envelope" style="margin-right: 5px;"></i> support@clothify.com</a>
                    <h5 style="margin-top: 5px;"> <a href="../aboutus.php" style="text-decoration:none;">About Us</a> |
                        <a href="../contactus.php" style="text-decoration:none;">Contact Us</a>
                    </h5>
                    </p>
                    <a href="https://www.facebook.com" target="_blank" style="color: white; margin-right: 10px;">
                        <i class="fa fa-facebook" style="font-size: 16px;"></i>
                    </a>
                    <a href="https://www.x.com" target="_blank" style="color: white; margin-right: 10px;">
                        <i class="fa fa-x" style="font-size: 16px;"></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" style="color:white; margin-right: 10px;">
                        <i class="fa fa-instagram" style="font-size: 16px;"></i>
                    </a>
                    <a href="https://www.linkedin.com" target="_blank" style="color: white; margin-right: 10px;">
                        <i class="fa fa-linkedin" style="font-size: 16px;"></i>
                    </a>
                    <a href="https://www.whatsapp.com" target="_blank" style="color:white; margin-right: 10px;">
                        <i class="fa fa-whatsapp" style="font-size: 16px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>




<div id="copyright" style="margin-top:0px; margin-bottom:0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 copyright">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <p style="margin-top:5px; margin-bottom: 0;"> Copyright © 2024 - All Rights Reserved | 
                    Clothify Ecommerce Website PHP - Developed By Nishu Nishan</p>
                    <h5 style="margin-top: 5px;"> <a href="../policy_details.php" style="text-decoration:none;">Privacy Policy</a> |
                        <a href="../terms.php" style="text-decoration:none;">Terms of Service</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- JavaScript to Show More Reviews -->
<script>
    document.getElementById('view-more-btn').addEventListener('click', function () {
        const hiddenReviews = document.querySelectorAll('.review-box[style="display:none;"]');
        let count = 0;

        // Show the next set of 4 reviews
        hiddenReviews.forEach(review => {
            if (count < 4) {
                review.style.display = 'flex';
                count++;
            }
        });

        // Hide "View More" button if no more hidden reviews
        if (document.querySelectorAll('.review-box[style="display:none;"]').length === 0) {
            document.getElementById('view-more-btn').style.display = 'none';
        }
    });
</script>
<script>
    document.querySelectorAll('#rating-stars .star').forEach(star => {
        star.addEventListener('click', () => {
            // Clear all stars, then color the clicked star and preceding stars
            document.querySelectorAll('#rating-stars .star').forEach(s => s.style.color = '#ddd');
            star.style.color = 'gold';
            let previousStar = star.previousElementSibling;
            while (previousStar) {
                if (previousStar.classList.contains('star')) {
                    previousStar.style.color = 'gold';
                }
                previousStar = previousStar.previousElementSibling;
            }
        });
    });
</script>

</body>
</html>
