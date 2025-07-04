<?php
// Description: This code handles the process of updating a customer's account details. 
// It retrieves the customer's current information, allows them to edit it, 
// and then saves the updated details back to the database. If the email is updated, 
// the user is logged out and redirected to the login page.
?>

<?php
    // Check if the customer is logged in
    if (!isset($_SESSION['cust_email'])) {
        echo "<script>alert('You must be logged in to update your profile.');</script>";
        echo "<script>window.open('customer_login.php', '_self');</script>";
        exit();
    }

    // Retrieve customer details from the database based on the logged-in email
    $customer_email = $_SESSION['cust_email'];
    $get_customer = "SELECT * FROM customers WHERE cust_email='$customer_email'";
    $run_cust = mysqli_query($con, $get_customer);

    if (!$run_cust || mysqli_num_rows($run_cust) == 0) {
        echo "<script>alert('Error fetching your account details. Please try again later.');</script>";
        exit();
    }

    $row_cust = mysqli_fetch_array($run_cust);

    // Assign the fetched customer details to variables
    $customer_id = $row_cust['cust_id'];
    $customer_name = $row_cust['cust_name'];
    $customer_email = $row_cust['cust_email'];
    $customer_contact = $row_cust['cust_contact'];
    $customer_image = $row_cust['cust_image'];
?>

<div class="box">
    <!-- Form to update account details -->
    <form action="" method="POST" enctype="multipart/form-data">
        <center>
            <h1>My Profile</h1>
        </center>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="c_name" value="<?php echo htmlspecialchars($customer_name); ?>" class="form-control" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="c_email" value="<?php echo htmlspecialchars($customer_email); ?>" class="form-control" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required>
        </div>
        <div class="form-group">
            <label>Mobile Number</label>
            <input type="text" name="c_contact" value="<?php echo htmlspecialchars($customer_contact); ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="c_image" class="form-control">
            <img src="customer/customer_images/<?php echo htmlspecialchars($customer_image); ?>" class="img-responsive" height="100" width="100" alt="Customer Image">
            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($customer_image); ?>">
        </div>
        <div class="text-center">
            <button class="btn btn-primary" type="submit" name="update">
                <i class="fa-solid fa-user-md"></i> Save Details
            </button>
        </div>
    </form>
</div>

<?php
    // Check if the form was submitted
    if (isset($_POST['update'])) {
        // Escape input values to prevent SQL injection
        $c_name = mysqli_real_escape_string($con, trim($_POST['c_name']));
        $c_email = mysqli_real_escape_string($con, trim($_POST['c_email']));
        $c_contact = mysqli_real_escape_string($con, trim($_POST['c_contact']));
        $c_image = $_FILES['c_image']['name'];
        $c_image_tmp = $_FILES['c_image']['tmp_name'];

        // If no image was uploaded, use the existing one
        if (empty($c_image)) {
            $c_image = $_POST['existing_image'];
        } else {
            // Validate and move uploaded image
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif','webp'];
            $image_extension = strtolower(pathinfo($c_image, PATHINFO_EXTENSION));

            if (!in_array($image_extension, $allowed_extensions)) {
                echo "<script>alert('Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF.');</script>";
                exit();
            }

            if (!move_uploaded_file($c_image_tmp, "customer/customer_images/$c_image")) {
                echo "<script>alert('Error uploading the image. Please try again.');</script>";
                exit();
            }
        }

        // Check if the email was changed
        $email_changed = ($c_email != $customer_email);

        // Query to update the customer details in the database
        $update_customer = "UPDATE customers SET cust_name='$c_name', cust_email='$c_email', cust_contact='$c_contact', cust_image='$c_image' WHERE cust_id='$customer_id'";
        $run_customer = mysqli_query($con, $update_customer);

        // Handle the outcome of the update query
        if ($run_customer) {
            if ($email_changed) {
                // Log out and redirect if the email was changed
                session_unset();
                session_destroy();
                echo "<script>alert('Your email has been updated. Please log in again.');</script>";
                echo "<script>window.open('customer_login.php', '_self');</script>";
            } else {
                // Confirm successful update
                echo "<script>alert('Your details have been updated successfully.');</script>";
                echo "<script>window.open('account.php?edit_account', '_self');</script>";
            }
        } else {
            // Display an error if the update query failed
            echo "<script>alert('There was an error updating your details. Please try again.');</script>";
        }
    }
?>
