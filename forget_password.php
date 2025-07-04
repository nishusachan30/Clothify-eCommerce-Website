<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Clear OTP email session when the page is accessed directly
if (!isset($_POST['send_otp']) && !isset($_POST['reset_password'])) {
    unset($_SESSION['otp_email']);
}

include("includes/db.php");
include("functions/functions.php");
include("includes/header.php");
include("includes/main.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$error = "";
$success = "";

// Step 1: Send OTP
if (isset($_POST['send_otp'])) {
    $email = trim($_POST['c_email']);

    if (empty($email)) {
        $error = "Please enter your email.";
    } else {
        $query = "SELECT * FROM customers WHERE cust_email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $otp = rand(1000, 9999);
            $timestamp = date('Y-m-d H:i:s');

            $update_otp_query = "UPDATE customers SET otp_code = ?, otp_timestamp = ? WHERE cust_email = ?";
            $stmt = $con->prepare($update_otp_query);
            $stmt->bind_param("sss", $otp, $timestamp, $email);
            $stmt->execute();

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'shreyakush8604@gmail.com';
                $mail->Password = 'glcy aviv bmnt kkfp';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('no-reply@clothify.com', 'Clothify');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset OTP';
                $mail->Body = "Your OTP for password reset is <strong>$otp</strong>. It is valid for 5 minutes.";

                $mail->send();
                $success = "OTP sent to your email.";
                $_SESSION['otp_email'] = $email; // Store email for OTP verification
            } catch (Exception $e) {
                $error = "Failed to send OTP. Error: " . $mail->ErrorInfo;
            }
        } else {
            $error = "No account found with that email.";
        }
    }
}

// Step 2: Verify OTP and Reset Password
if (isset($_POST['reset_password'])) {
    $email = $_SESSION['otp_email'] ?? null;
    $entered_otp = trim($_POST['otp']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!$email) {
        $error = "Session expired. Please restart the process.";
    } else {
        $query = "SELECT otp_code, otp_timestamp FROM customers WHERE cust_email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $otp_timestamp = strtotime($data['otp_timestamp']);
            $current_time = time();

            $time_difference = $current_time - $otp_timestamp;

            if (trim($data['otp_code']) === $entered_otp && $time_difference <= 300) {
                if ($new_password !== $confirm_password) {
                    $error = "Passwords do not match.";
                } else {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_pass_query = "UPDATE customers SET cust_pass = ?, otp_code = NULL, otp_timestamp = NULL WHERE cust_email = ?";
                    $stmt = $con->prepare($update_pass_query);
                    $stmt->bind_param("ss", $hashed_password, $email);
                    $stmt->execute();

                    $success = "Password updated successfully.";
                    unset($_SESSION['otp_email']);
                    echo "<script> alert('Password updated successfully.'); </script>";
                    echo "<script>window.open('customer_login.php', '_self');</script>";
                }
            } else {
                $error = "Invalid or expired OTP.";
            }
        } else {
            $error = "Invalid session state. Please restart.";
            unset($_SESSION['otp_email']);
        }
    }
}
?>

<div id="content"><!-- content start -->
    <div class="container"><!-- container start -->
        <div class="col-md-6 col-md-offset-3"><!-- col-md-6 col-md-offset-3 start -->
            <div class="box"><!-- box start -->
                <div class="box-header"><!-- box-header start -->
                    <center>
                        <h2>Reset Password</h2>
                    </center>
                </div><!-- box-header end -->

                <!-- Step 1: Send OTP -->
                <?php if (!isset($_SESSION['otp_email'])): ?>
                    <form action="forget_password.php" method="post"><!-- form start -->
                        <div class="form-group">
                            <label>Email <span style="color: red;">*</span></label>
                            <input type="email" name="c_email" class="form-control" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="send_otp" class="btn btn-primary">
                                <i class="fa fa-envelope"></i> Send OTP
                            </button>
                        </div>
                    </form><!-- form end -->
                <?php endif; ?>

                <!-- Step 2: Verify OTP and Reset Password -->
                <?php if (isset($_SESSION['otp_email'])): ?>

                    <form action="forget_password.php" method="post"><!-- form start -->
                        <div class="form-group">
                            <label>Enter OTP <span style="color: red;">*</span></label>
                            <input type="text" name="otp" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>New Password <span style="color: red;">*</span></label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password <span style="color: red;">*</span></label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="reset_password" class="btn btn-primary">
                                <i class="fa fa-refresh"></i> Reset Password
                            </button><br><br>
                    </form><!-- form end -->
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php elseif ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
            </div><!-- box end -->
        </div><!-- col-md-6 col-md-offset-3 end -->
    </div><!-- container end -->
</div><!-- content end -->


<!-- Footer start -->
<?php include("includes/footer.php"); ?>