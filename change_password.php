<form action="" method="post"> <!-- Form starts for changing password -->
    <div class="box"><!-- Box container for form styling -->
        <center>
            <h1>Change Your Password</h1>
        </center>

        <!-- Input for current password -->
        <div class="form-group"><!-- Form group for current password -->
            <label>Enter your current password</label>
            <input type="password" name="old_password" class="form-control" required>
        </div><!-- End of form group for current password -->

        <!-- Input for new password -->
        <div class="form-group"><!-- Form group for new password -->
            <label>Enter new password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div><!-- End of form group for new password -->

        <!-- Input for confirming new password -->
        <div class="form-group"><!-- Form group for confirming new password -->
            <label>Confirm new password</label>
            <input type="password" name="c_n_password" class="form-control" required>
        </div><!-- End of form group for confirming new password -->

        <!-- Submit button for updating password -->
        <div class="text-center"><!-- Center-aligned button -->
            <button class="btn btn-primary btn-lg" name="update" type="submit"><i class="fa fa-refresh"></i>
                Update Password
            </button>
        </div>
    </div><!-- End of box container for form styling -->
</form><!-- End of form -->

<?php
// Check if the 'update' button has been clicked
if (isset($_POST['update'])) {
    // Retrieve logged-in user's email and form inputs
    $c_email = $_SESSION['cust_email'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $c_n_password = $_POST['c_n_password'];

    // Validate form inputs
    if (empty($old_password) || empty($new_password) || empty($c_n_password)) {
        echo "<script>alert('All fields are required. Please fill out all fields.');</script>";
        exit();
    }

    // Fetch the hashed password from the database
    $select_cust = "SELECT cust_pass FROM customers WHERE cust_email=?";
    $stmt = $con->prepare($select_cust);
    if (!$stmt) {
        echo "<script>alert('Error preparing database query: " . $con->error . "');</script>";
        exit();
    }
    $stmt->bind_param("s", $c_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Handle error if user does not exist
    if ($result->num_rows == 0) {
        echo "<script>alert('No user found with this email address.');</script>";
        exit();
    }

    $row = $result->fetch_assoc();

    // Verify the current password
    if (!password_verify($old_password, $row['cust_pass'])) {
        echo "<script>alert('Your current password is incorrect. Please try again.');</script>";
        exit();
    }

    // Check if the new password matches the confirmation password
    if ($new_password != $c_n_password) {
        echo "<script>alert('Your new password does not match the confirmation password.');</script>";
        exit();
    }



    // Hash the new password
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password query
    $update_q = "UPDATE customers SET cust_pass=? WHERE cust_email=?";
    $update_stmt = $con->prepare($update_q);
    if (!$update_stmt) {
        echo "<script>alert('Error preparing update query: " . $con->error . "');</script>";
        exit();
    }
    $update_stmt->bind_param("ss", $hashed_new_password, $c_email);

    if ($update_stmt->execute()) {
        echo "<script>alert('Your password has been updated successfully.');</script>";
        echo "<script>window.open('account.php?change_password', '_self');</script>";
    } else {
        echo "<script>alert('Failed to update password. Please try again later.');</script>";
        exit();
    }
}
?>