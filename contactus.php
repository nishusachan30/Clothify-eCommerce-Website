<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Function to check internet connectivity
function isInternetConnected($host = 'smtp.gmail.com', $port = 587, $timeout = 10) {
    $connected = @fsockopen($host, $port, $errno, $errstr, $timeout);
    if ($connected) {
        fclose($connected); // Close the connection
        return true;
    }
    return false;
}

// Initialize message variables
$errorMessage = '';
$successMessage = '';

if (isset($_POST['submit'])) {
    $sender_name = $_POST['name'];
    $sender_email = $_POST['email'];
    $sender_subject = $_POST['subject'];
    $sender_message = $_POST['message'];
    $enquiry_type = $_POST['enquiry_type'];

    $new_message = "
        <h1>This Message Has Been Sent By $sender_name</h1>
        <p><b>Sender Email:</b> $sender_email</p>
        <p><b>Sender Subject:</b> $sender_subject</p>
        <p><b>Sender Enquiry Type:</b> $enquiry_type</p>
        <p><b>Sender Message:</b> $sender_message</p>
    ";

    // Check if internet is connected before sending email
    if (isInternetConnected()) {
        try {
            // Create an instance of PHPMailer
            $mail = new PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'shreyakush8604@gmail.com'; // Your SMTP username
            $mail->Password = 'glcy aviv bmnt kkfp';      // Your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Admin email setup
            $mail->setFrom($sender_email, $sender_name);
            $mail->addAddress('shreyakush8604@gmail.com', 'Clothify'); // Admin email address
            $mail->addReplyTo($sender_email, $sender_name);

            // Content for admin email
            $mail->isHTML(true);
            $mail->Subject = $sender_subject;
            $mail->Body = $new_message;

            $mail->send();

            // Success message for user confirmation
            $successMessage = "Your message has been sent successfully to the admin.";

            // Send confirmation email to the user with their query details
            $mail->clearAddresses();
            $mail->setFrom('shreyakush8604@gmail.com', 'Clothify Support'); // Your company email and name
            $mail->addAddress($sender_email); // User's email
            $mail->Subject = "Confirmation of Your Query Submission";

            // Customize the email body to include user's query details
            $mail->Body = "
                <h2>Thank you for contacting Clothify!</h2>
                <p>We have received your message and will get back to you as soon as possible.</p>
                <h3>Your Query Details:</h3>
                <p><b>Name:</b> $sender_name</p>
                <p><b>Email:</b> $sender_email</p>
                <p><b>Subject:</b> $sender_subject</p>
                <p><b>Enquiry Type:</b> $enquiry_type</p>
                <p><b>Message:</b> $sender_message</p>
                <p>Thank you for reaching out to us!</p>
                <p>Best regards, <br>Clothify Support Team</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $errorMessage = "Please connect to the internet to send your message.";
    }
}
?>

<div id="content">
    <div class="container">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="home.php">Home</a></li>
                <li>Contact Us</li>
            </ul>
        </div>

        <div class="col-md-9 col-md-offset-2">
            <div class="box">
                <div class="box-header">
                    <center>
                        <h2>Contact Us</h2>
                        <p class="text-muted">If you have any questions, please feel free to contact us,
                            our customer service center is working for you 24/7.</p>
                    </center>
                </div>

                <!-- Display success or error message at the top of the form -->
                <?php if ($successMessage): ?>
                    <div class="alert alert-success text-center">
                        <?php echo $successMessage; ?>
                    </div>
                <?php elseif ($errorMessage): ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>

                <form action="contactus.php" method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" class="form-control" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" name="message"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Select Enquiry Type</label>
                        <select name="enquiry_type" class="form-control">
                            <option>Select Enquiry Type</option>
                            <?php
                            $get_enquiry_types = "select * from enquiry_types";
                            $run_enquiry_types = mysqli_query($con, $get_enquiry_types);
                            while ($row_enquiry_types = mysqli_fetch_array($run_enquiry_types)) {
                                $enquiry_title = $row_enquiry_types['enquiry_title'];
                                echo "<option>$enquiry_title</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fa fa-user-md"></i> Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>
