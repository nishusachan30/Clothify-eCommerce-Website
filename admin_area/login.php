<?php
session_start();
include("includes/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <form action="" class="form-login" method="post">
            <h2 class="form-login-heading">Admin Login</h2>
            <input type="text" name="admin_email" class="form-control" placeholder="Email Address" required>
            <input type="password" name="admin_pass" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="admin_login">Log In</button>
            <center>
            <h4 class="forget-password">Lost your password? <br>
                <a href="forget_password.php">Reset Password</a>
            </h4>
            </center>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['admin_login'])) {
    $admin_email = mysqli_real_escape_string($con, $_POST['admin_email']);
    $admin_pass = mysqli_real_escape_string($con, $_POST['admin_pass']);
    
    // Fetch the admin details using the email
    $get_admin = "SELECT * FROM admins WHERE admin_email='$admin_email'";
    $run_admin = mysqli_query($con, $get_admin);
    
    if ($row_admin = mysqli_fetch_assoc($run_admin)) {
        $hashed_pass = $row_admin['admin_pass']; // Get the hashed password from the database
        
        // Verify the provided password with the hashed password
        if (password_verify($admin_pass, $hashed_pass)) {
            $_SESSION['admin_email'] = $admin_email;
            echo "<script>alert('You are logged in successfully');</script>";
            echo "<script>window.open('index.php?dashboard','_self');</script>";
        } else {
            echo "<script>alert('Email or Password is incorrect');</script>";
        }
    } else {
        echo "<script>alert('Email or Password is incorrect');</script>";
    }
}
?>
