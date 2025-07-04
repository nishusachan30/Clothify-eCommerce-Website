
<div class="box">
    <center>
        <h1>Do you really want to delete your account?</h1>
    
        <form action="" method="post">
            <!-- Buttons for confirming or cancelling account deletion -->
            <input type="submit" name="yes" value="Yes, I want to Delete" class="btn btn-danger">
            <input type="submit" name="no" value="No, I don't want to Delete" class="btn btn-primary">
        </form>
    </center>
</div>

<?php
// Check if the customer is logged in
if (!isset($_SESSION['cust_email'])) {
    echo "<script> alert('You must be logged in to delete your account.') </script>";
    echo "<script> window.open('customer_login.php','_self') </script>";
    exit();
}

// Retrieving the email of the currently logged-in user from the session
$c_email = $_SESSION['cust_email'];

// If the user clicks 'Yes' to confirm deletion
if (isset($_POST['yes'])) {
    // Ensure proper escaping of user input to prevent SQL injection
    $c_email_safe = mysqli_real_escape_string($con, $c_email);

    // Retrieve customer ID from the email
    $query = "SELECT cust_id FROM customers WHERE cust_email='$c_email_safe'";
    $result = mysqli_query($con, $query);
    $customer = mysqli_fetch_assoc($result);
    
    if ($customer) {
        $cust_id = $customer['cust_id'];

        // Delete related records in the return_refund table
        $delete_refund_q = "DELETE FROM return_refund WHERE cust_id='$cust_id'";
        mysqli_query($con, $delete_refund_q);

        // Query to delete the customer record from the database
        $delete_q = "DELETE FROM customers WHERE cust_email='$c_email_safe'";

        // Execute the deletion query
        $run_q = mysqli_query($con, $delete_q);

        // Check if the deletion was successful
        if ($run_q) {
            // Destroying the session to log the user out
            session_destroy();

            // Alert the user that their account has been deleted
            echo "<script> alert('Your account has been deleted successfully.') </script>";

            // Redirect to the homepage
            echo "<script> window.open('index.php','_self') </script>";
        } else {
            // If there was an error with the query, show an error message
            echo "<script> alert('There was an error deleting your account. Please try again later.') </script>";
        }
    } else {
        echo "<script> alert('Customer record not found.') </script>";
    }
} elseif (isset($_POST['no'])) {
    // If the user clicks 'No', redirect them to the account page
    echo "<script> window.open('account.php','_self') </script>";
}
?>
