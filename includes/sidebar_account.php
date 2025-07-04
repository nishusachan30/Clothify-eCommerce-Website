<?php
// Start a session if one does not already exist
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include("includes/db.php");
?>

<!-- Sidebar panel start -->
<div class="panel panel-default sidebar-menu">
    <!-- Panel heading start -->
    <div class="panel-heading">
        <?php
        // Retrieve the session customer email
        $session_customer = $_SESSION['cust_email'];

        // Fetch customer details from the database using the email
        $get_cust = "select * from customers where cust_email='$session_customer'";
        $run_cust = mysqli_query($con, $get_cust);
        $row_customers = mysqli_fetch_array($run_cust);

        // Extract customer image and name from the database result
        $customer_image = $row_customers['cust_image'];
        $customer_name = $row_customers['cust_name'];

        // Display customer details if logged in
        if (!isset($_SESSION['cust_email'])) {
            // Do nothing if no customer email is in session
        } else {
            // Display customer's profile image and name
            echo "
            <center>
                <img src='customer/customer_images/$customer_image' class='img-responsive' width='100' height='100' alt=''>
            </center>
            <br>
            <h3 align='center' class='panel-title'>Name : $customer_name</h3>
            ";
        }
        ?>
    </div>
    <!-- Panel heading end -->

    <!-- Panel body containing navigation links -->
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
            <!-- Navigation links for the sidebar -->
            <li class="<?php if (isset($_GET['my_order'])) { echo "active"; } ?>">
                <a href="account.php?my_order"><i class="fa-solid fa-bars"></i> My Orders</a>
            </li>
            <li class="<?php if (isset($_GET['my_address'])) { echo "active"; } ?>">
                <a href="account.php?my_address"><i class="fa fa-location-dot"></i> My Address</a>
            </li>
            <li class="<?php if (isset($_GET['edit_account'])) { echo "active"; } ?>">
                <a href="account.php?edit_account"><i class="fa-solid fa-user"></i> Edit Account</a>
            </li>
            <li class="<?php if (isset($_GET['customer_bank_details'])) { echo "active"; } ?>">
                <a href="account.php?customer_bank_details"><i class="fa fa-building-columns"></i> Bank & UPI Details</a>
            </li>
            <li class="<?php if (isset($_GET['customer_refund'])) { echo "active"; } ?>">
                <a href="account.php?customer_refund"><i class="fa-solid fa-receipt"></i> Refund</a>
            </li>
            <li class="<?php if (isset($_GET['change_password'])) { echo "active"; } ?>">
                <a href="account.php?change_password"><i class="fa-solid fa-lock"></i> Change Password</a>
            </li>
            <li class="<?php if (isset($_GET['delete_account'])) { echo "active"; } ?>">
                <a href="account.php?delete_account"><i class="fa-solid fa-trash"></i> Delete Account</a>
            </li>
            <li class="<?php if (isset($_GET['logout'])) { echo "active"; } ?>">
                <a href="../logout.php?logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </li>
        </ul>
    </div>
    <!-- Panel body end -->
</div>
<!-- Sidebar panel end -->
