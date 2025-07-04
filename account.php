<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Redirect to login page if the customer is not logged in
if(!isset($_SESSION['cust_email'])){
    echo "<script>window.open('customer_login.php', '_self')</script>";
} else {
    // Include necessary files
    include("includes/db.php");
    include("functions/functions.php");
    include("includes/main.php");
    include("includes/header.php");
?>

<div id="content"><!-- content start -->
    <div class="container"><!-- container start -->
        <div class="col-md-12"><!-- col-md-12 start -->
            <ul class="breadcrumb"> <!-- Breadcrumb navigation -->
                <li><a href="home.php">Home</a></li> <!-- Link to home page -->
                <li>My Account</li> <!-- Current page label -->
            </ul>
        </div><!-- col-md-12 end -->

        <div class="col-md-3"><!-- col-md-3 start -->
            <?php include("includes/sidebar_account.php"); ?>  <!-- Include account sidebar -->
        </div><!-- col-md-3 end -->

        <div class="col-md-9"><!-- col-md-9 start -->

            <!-- Conditionally include different pages based on the URL parameters -->

            <!-- Include my_order.php if 'my_order' parameter is set -->
            <?php if(isset($_GET['my_order'])){
                include("my_order.php");
            } ?>
            <!-- my_order.php inclusion end -->

            <!-- Include my_address.php if 'my_address' parameter is set -->
            <?php if(isset($_GET['my_address'])){
                include("my_address.php");
            } ?>
            <!-- my_address.php inclusion end -->

            <!-- Include edit_account.php if 'edit_account' parameter is set -->
            <?php if(isset($_GET['edit_account'])){
                include("edit_account.php");
            } ?>
            <!-- edit_account.php inclusion end -->

            <!-- Include customer_bank_details.php if 'customer_bank_details' parameter is set -->
            <?php if(isset($_GET['customer_bank_details'])){
                include("customer_bank_details.php");
            } ?>
            <!-- customer_bank_details.php inclusion end -->

            <!-- Include customer_refund.php if 'customer_refund' parameter is set -->
            <?php if(isset($_GET['customer_refund'])){
                include("customer_refund.php");
            } ?>
            <!-- customer_refund.php inclusion end -->

            <!-- Include change_password.php if 'change_password' parameter is set -->
            <?php if(isset($_GET['change_password'])){
                include("change_password.php");
            } ?>
            <!-- change_password.php inclusion end -->

            <!-- Include delete_account.php if 'delete_account' parameter is set -->
            <?php if(isset($_GET['delete_account'])){
                include("delete_account.php");
            } ?>
            <!-- delete_account.php inclusion end -->

            <!-- Include logout.php if 'logout' parameter is set -->
            <?php if(isset($_GET['logout'])){
                include("logout.php");
            } ?>
            <!-- logout.php inclusion end -->

        </div><!-- col-md-9 end -->

    </div><!-- container end -->
</div><!-- content end -->

<!-- Include footer section -->
<?php include("includes/footer.php"); ?>

<?php } ?>