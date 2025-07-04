<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("includes/db.php");
include_once("includes/header.php");
include_once("functions/functions.php");
include_once("includes/main.php");
?>

<div id="content"><!-- content start -->
    <div class="container"><!-- container start -->
        <div class="col-md-12"><!-- col-md-12 start -->
            <ul class="breadcrumb">
                <li><a href="home.php">Home</a></li>
                <li>Login</li>
            </ul>
        </div><!-- col-md-12 end -->
        <!-- User Login Form Section -->
        <div class="col-md-6 col-md-offset-3"><!--col-md-6 Starts-->
            <div class="box">
                <div class="box-header">
                    <center>
                        <h2>Login</h2>
                        <p class="lead">Already our customer?</p>
                    </center>
                </div>
                <!-- Form to collect login details -->
                <form action="customer_login.php" method="post">
                    <!-- Email input field -->
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="text" class="form-control" name="c_email" required=""
                            value="<?php echo isset($_POST['c_email']) ? htmlspecialchars($_POST['c_email']) : ''; ?>">
                    </div>
                    <!-- Password input field -->
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" class="form-control" name="c_password" required=""
                            value="<?php echo isset($_POST['c_password']) ? htmlspecialchars($_POST['c_password']) : ''; ?>">
                    </div>
                    <!-- Login button -->
                    <div class="text-center">
                        <center>
                            <button name="login" value="Login" class="btn btn-primary">
                                <i class="fa fa-sign-in"></i> Login
                            </button>

                        </center>
                    </div>
                </form>
                <!-- Links for registration and password reset -->
                <center>
                    <a href="customer_registration.php">
                        <h5>New ? Register Now</h5>
                    </a>
                </center>
                <center>
                    <a href="forget_password.php">
                        <h5>Forget Password? Reset Now</h5>
                    </a>
                </center>
            </div>
        </div><!--col-md-6 Ends-->
    </div>
</div>

<?php
// Handling login form submission
if (isset($_POST['login'])) {
    // Capturing login credentials from form
    $cust_email = $_POST['c_email'];
    $cust_pass = $_POST['c_password'];

    // Basic validation to check if fields are empty
    if (empty($cust_email) || empty($cust_pass)) {
        echo "<script>alert('Please fill in both email and password.');</script>";
        exit();
    }

    // Query to fetch customer data based on entered email
    $select_customers = "SELECT * FROM customers WHERE cust_email='$cust_email'";
    $run_cust = mysqli_query($con, $select_customers);

    // Checking if query runs successfully
    if (!$run_cust) {
        echo "<script>alert('Error executing the query. Please try again later.');</script>";
        exit();
    }

    // Checking if the customer exists in the database
    $customer_data = mysqli_fetch_assoc($run_cust);

    if (!$customer_data) {
        echo "<script>alert('Email or Password is Incorrect');</script>";
        exit();
    }

    // Verify the password using password_verify()
    if (!password_verify($cust_pass, $customer_data['cust_pass'])) {
        echo "<script>alert('Email or Password is Incorrect');</script>";
        exit();
    }

    // Getting user's IP address
    $get_ip = getUserIP();

    // Query to check the cart based on user's IP address
    $select_cart = "SELECT * FROM cart WHERE ip_add='$get_ip'";
    $run_cart = mysqli_query($con, $select_cart);

    // Error handling for the cart query
    if (!$run_cart) {
        echo "<script>alert('Error fetching cart details. Please try again later.');</script>";
        exit();
    }

    $check_cart = mysqli_num_rows($run_cart);

    // Log the user in and set the session
    $_SESSION['cust_email'] = $cust_email;

    // Redirect based on cart contents
    if ($check_cart > 0) {
        echo "<script>alert('You are logged in successfully');</script>";
        echo "<script>window.open('account.php?my_order', '_self');</script>";
    } else {
        echo "<script>alert('You are logged in successfully');</script>";
        echo "<script>window.open('index.php', '_self');</script>";
    }
}
?>

<?php include("includes/footer.php"); ?>
