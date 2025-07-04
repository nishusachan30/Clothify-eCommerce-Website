<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("includes/db.php");
include("functions/functions.php");
include("includes/main.php");
include("includes/header.php");
?>

<?php
// Handling the customer registration process when the "submit" button is pressed.
if (isset($_POST['submit'])) {
    // Retrieving form data from the POST request
    $c_name = $_POST['c_name'];
    $c_email = $_POST['c_email'];
    $c_password = $_POST['c_password'];
    $cnf_password = $_POST['cnf_password'];
    $c_contact = $_POST['c_contact'];
    $c_image = $_FILES['c_image']['name'];
    $c_tmp_image = $_FILES['c_image']['tmp_name'];
    $c_ip = getUserIP();

    // Check if passwords match
    if ($c_password !== $cnf_password) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    } else {
        // Check if the email is already registered
        $check_email_query = "SELECT cust_email FROM customers WHERE cust_email='$c_email'";
        $run_email_query = mysqli_query($con, $check_email_query);
        
        if (mysqli_num_rows($run_email_query) > 0) {
            echo "<script>alert('This email is already registered. Please use a different email.');</script>";
        } else {
            // Move uploaded image to the "customer/customer_images" directory
            move_uploaded_file($c_tmp_image, "customer/customer_images/$c_image");
            
              // Hash the password before storing it
              $hashed_password = password_hash($c_password, PASSWORD_DEFAULT);

            // Insert the customer data into the database
            $insert_customer = "INSERT INTO customers (cust_name, cust_email, cust_pass, cust_contact, cust_image, cust_ip) 
            VALUES ('$c_name', '$c_email', '$hashed_password', '$c_contact', '$c_image', '$c_ip')";
            
            $run_customer = mysqli_query($con, $insert_customer);
            
            // Check if the customer has any items in the cart
            $sel_cart = "SELECT * FROM cart WHERE ip_add='$c_ip'";
            $run_cart = mysqli_query($con, $sel_cart);
            $check_cart = mysqli_num_rows($run_cart);

            // If the customer has items in the cart, redirect to the account page
            if ($check_cart > 0) {
                $_SESSION['cust_email'] = $c_email;
                echo "<script>alert('You have been registered successfully.');</script>";
                echo "<script>window.open('account.php?my_order', '_self');</script>";
            } else {
                // Otherwise, redirect to the homepage
                $_SESSION['cust_email'] = $c_email;
                echo "<script>alert('You have been registered successfully.');</script>";
                echo "<script>window.open('index.php', '_self');</script>";
            }
        }
    }
}
?>

<div id="content"><!-- content start -->
    <div class="container"><!-- container start -->
        <div class="col-md-12"><!-- col-md-12 start -->
            <ul class="breadcrumb">
                <li><a href="home.php">Home</a></li>
                <li>Registration</li>
            </ul>
        </div><!-- col-md-12 end -->

        <!-- Customer registration form -->
        <div class="col-md-6 col-md-offset-3"><!-- col-md-6 start -->
            <div class="box"><!-- box start -->
                <div class="box-header"><!-- box-header start -->
                    <center>
                        <h2>Customer Registration</h2>
                    </center>
                </div><!-- box-header end -->
                <form action="customer_registration.php" method="post" enctype="multipart/form-data">
                    <!-- Form fields for customer details -->
                    <div class="form-group">
                        <label>Full Name <span style="color: red;">*</span></label>
                        <input type="text" name="c_name" class="form-control" 
                        value="<?php echo isset($_POST['c_name']) ? htmlspecialchars($_POST['c_name']) : ''; ?>" 
                        style="text-transform: uppercase;" 
                        oninput="this.value = this.value.toUpperCase();" required="">
                    </div>
                    <div class="form-group">
                        <label>Email <span style="color: red;">*</span></label>
                        <input type="text" name="c_email" class="form-control" title="Please enter a valid email id" 
                        value="<?php echo isset($_POST['c_email']) ? htmlspecialchars($_POST['c_email']) : ''; ?>" 
                        style="text-transform: uppercase;" 
                        oninput="this.value = this.value.toUpperCase();" required="">
                    </div>
                    <div class="form-group">
                        <label>Password <span style="color: red;">*</span></label>
                        <div style="position: relative;">
                            <input type="password" name="c_password" id="password" class="form-control"
                            value="<?php echo isset($_POST['c_password']) ? htmlspecialchars($_POST['c_password']) : ''; ?>" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password <span style="color: red;">*</span></label>
                        <input type="password" name="cnf_password" class="form-control"
                        value="<?php echo isset($_POST['cnf_password']) ? htmlspecialchars($_POST['cnf_password']) : ''; ?>" required="">
                    </div>
                    <div class="form-group">
                        <label>Mobile No <span style="color: red;">*</span></label>
                        <input type="tel" name="c_contact" class="form-control" pattern="[0-9]{10}" 
                        maxlength="10" minlength="10" 
                        title="Please enter a 10-digit mobile number" 
                        value="<?php echo isset($_POST['c_contact']) ? htmlspecialchars($_POST['c_contact']) : ''; ?>" required/>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="c_image" class="form-control" 
                        value="<?php echo isset($_POST['c_image']) ? htmlspecialchars($_POST['c_image']) : ''; ?>">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit" name="submit">
                            <i class="fa-solid fa-user-md"></i> Register
                        </button>
                    </div>
                </form>
                <center>
                    <a href="customer_login.php">
                        <h5>Already a user? Login</h5>
                    </a>
                </center>
            </div><!-- box end -->
        </div><!-- col-md-6 end -->
    </div><!-- container end -->
</div><!-- content end -->

<!-- Footer inclusion -->
<?php include("includes/footer.php"); ?>

