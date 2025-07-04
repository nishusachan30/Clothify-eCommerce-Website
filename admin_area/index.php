<?php
// Start the session to track user login state
session_start();

// Include the database connection file
include("includes/db.php");

// Check if the admin is logged in, otherwise redirect to the login page
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    // Admin dashboard logic starts here

    // Get the logged-in admin's email from the session
    $admin_session = $_SESSION['admin_email'];

    // Fetch admin details from the database
    $get_admin = "select * from admins where admin_email='$admin_session'";
    $run_admin = mysqli_query($con, $get_admin);
    $row_admin = mysqli_fetch_array($run_admin);

    // Store admin details in variables
    $admin_id = $row_admin['admin_id'];
    $admin_name = $row_admin['admin_name'];
    $admin_email = $row_admin['admin_email'];
    $admin_image = $row_admin['admin_image'];
    $admin_country = $row_admin['admin_country'];
    $admin_job = $row_admin['admin_job'];
    $admin_contact = $row_admin['admin_contact'];
    $admin_about = $row_admin['admin_about'];

    // Fetch the total number of products
    $get_pro = "select * from products";
    $run_pro = mysqli_query($con, $get_pro);
    $count_pro = mysqli_num_rows($run_pro);

    // Fetch the total number of customers
    $get_cust = "select * from customers";
    $run_cust = mysqli_query($con, $get_cust);
    $count_cust = mysqli_num_rows($run_cust);

    // Fetch the total number of product categories
    $get_p_cat = "select * from product_category";
    $run_p_cat = mysqli_query($con, $get_p_cat);
    $count_p_cat = mysqli_num_rows($run_p_cat);

    // Fetch the total number of customer orders
    $get_order = "select * from customer_order";
    $run_order = mysqli_query($con, $get_order);
    $count_order = mysqli_num_rows($run_order);

    // Fetch the total number of pending orders
    $get_pending_orders = "SELECT * FROM customer_order WHERE order_status='Seller is processing your order' OR order_status='Out For Delivery' OR order_status='Shipped'";
    $run_pending_orders = mysqli_query($con, $get_pending_orders);
    $count_pending_orders = mysqli_num_rows($run_pending_orders);

    // Fetch the total number of cancelled orders
    $get_cancelled_orders = "SELECT * FROM customer_order WHERE order_status='Cancelled'";
    $run_cancelled_orders = mysqli_query($con, $get_cancelled_orders);
    $count_cancelled_orders = mysqli_num_rows($run_cancelled_orders);

    // Fetch the total number of return/refund requests
    $get_return_orders = "SELECT * FROM return_refund WHERE return_refund_status='Approved' OR return_refund_status='Rejected' OR return_refund_status='Requested'";
    $run_return_orders = mysqli_query($con, $get_return_orders);
    $count_return_orders = mysqli_num_rows($run_return_orders);

    // Fetch the total number of completed refunds/returns
    $get_completed_refund = "SELECT * FROM return_refund WHERE return_refund_status='Returned / Refunded'";
    $run_completed_refund = mysqli_query($con, $get_completed_refund);
    $count_completed_refund = mysqli_num_rows($run_completed_refund);

    // Fetch the total number of completed orders
    $get_completed_orders = "SELECT * FROM customer_order WHERE order_status='Delivered'";
    $run_completed_orders = mysqli_query($con, $get_completed_orders);
    $count_completed_orders = mysqli_num_rows($run_completed_orders);

   // Calculate the total earnings from completed payments
$get_total_earnings = "SELECT SUM(amount) as Total FROM payments WHERE status = 'Completed'";
$run_total_earnings = mysqli_query($con, $get_total_earnings);
$row = mysqli_fetch_assoc($run_total_earnings);
$count_total_earnings = $row['Total'];

// Format the total earnings to two decimal places
$count_total_earnings = number_format((float)$count_total_earnings, 2, '.', '');

    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Admin Panel</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <!--<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font_awesome.min.css" rel="stylesheet" 
integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3S10sibVcOQVnN" crossorigin="anonymous">-->
        <script src="https://kit.fontawesome.com/b49e178814.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php') ?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <?php
                    if (isset($_GET['dashboard'])) {
                        include('dashboard.php');
                    }
                    if (isset($_GET['insert_product'])) {
                        include('insert_product.php');
                    }
                    if (isset($_GET['view_product'])) {
                        include('view_product.php');
                    }
                    if (isset($_GET['delete_product'])) {
                        include('delete_product.php');
                    }
                    if (isset($_GET['edit_product'])) {
                        include('edit_product.php');
                    }
                    if (isset($_GET['insert_product_cat'])) {
                        include('insert_p_cat.php');
                    }
                    if (isset($_GET['view_return_refund_orders'])) {
                        include('view_return_refund_orders.php');
                    }
                    if (isset($_GET['view_cancelled_orders'])) {
                        include('view_cancelled_orders.php');
                    }
                    if (isset($_GET['view_product_cat'])) {
                        include('view_p_cat.php');
                    }
                    if (isset($_GET['delete_p_cat'])) {
                        include('delete_p_cat.php');
                    }
                    if (isset($_GET['edit_p_cat'])) {
                        include('edit_p_cat.php');
                    }
                    if (isset($_GET['insert_categories'])) {
                        include('insert_cat.php');
                    }
                    if (isset($_GET['view_categories'])) {
                        include('view_cat.php');
                    }
                    if (isset($_GET['delete_cat'])) {
                        include('delete_cat.php');
                    }
                    if (isset($_GET['edit_cat'])) {
                        include('edit_cat.php');
                    }
                    if (isset($_GET['insert_slider'])) {
                        include('insert_slider.php');
                    }
                    if (isset($_GET['view_slider'])) {
                        include('view_slider.php');
                    }
                    if (isset($_GET['delete_slide'])) {
                        include('delete_slider.php');
                    }
                    if (isset($_GET['edit_slide'])) {
                        include('edit_slider.php');
                    }
                    if (isset($_GET['view_customer'])) {
                        include('view_customer.php');
                    }
                    if (isset($_GET['customer_delete'])) {
                        include('customer_delete.php');
                    }
                    if (isset($_GET['view_order'])) {
                        include('view_order.php');
                    }
                    if (isset($_GET['delete_order'])) {
                        include('delete_order.php');
                    }
                    if (isset($_GET['view_payments'])) {
                        include('view_payments.php');
                    }
                    if (isset($_GET['delete_payment'])) {
                        include('delete_payment.php');
                    }
                    if (isset($_GET['insert_admin'])) {
                        include('insert_admin.php');
                    }
                    if (isset($_GET['view_admin'])) {
                        include('view_admin.php');
                    }
                    if (isset($_GET['delete_admin'])) {
                        include('delete_admin.php');
                    }
                    if (isset($_GET['edit_admin'])) {
                        include('edit_admin.php');
                    }
                    if (isset($_GET['view'])) {
                        include('edit_admin_profile.php');
                    }
                    if (isset($_GET['view_pending_orders'])) {
                        include('view_pending_orders.php');
                    }
                    if (isset($_GET['view_completed_orders'])) {
                        include('view_completed_orders.php');
                    }
                    if (isset($_GET['insert_manufacturers'])) {
                        include('insert_manufacturers.php');
                    }
                    if (isset($_GET['edit_manufacturers'])) {
                        include('edit_manufacturers.php');
                    }
                    if (isset($_GET['view_manufacturers'])) {
                        include('view_manufacturers.php');
                    }
                    if (isset($_GET['delete_manufacturers'])) {
                        include('delete_manufacturers.php');
                    }
                    if (isset($_GET['insert_enquiry'])) {
                        include("insert_enquiry.php");
                    }
                    if (isset($_GET['view_enquiry'])) {
                        include("view_enquiry.php");
                    }
                    if (isset($_GET['delete_enquiry'])) {
                        include("delete_enquiry.php");
                    }
                    if (isset($_GET['edit_enquiry'])) {
                        include("edit_enquiry.php");
                    }
                    if (isset($_GET['edit_contact_us'])) {
                        include("edit_contact_us.php");
                    }
                    if (isset($_GET['insert_term'])) {
                        include("insert_term.php");
                    }
                    if (isset($_GET['view_terms'])) {
                        include("view_terms.php");
                    }
                    if (isset($_GET['delete_term'])) {
                        include("delete_term.php");
                    }
                    if (isset($_GET['edit_term'])) {
                        include("edit_term.php");
                    }
                    if (isset($_GET['edit_about_us'])) {
                        include("edit_about_us.php");
                    }
                    if (isset($_GET['delete_completed_order'])) {
                        include("delete_completed_order.php");
                    }
                    if (isset($_GET['delete_cancelled_order'])) {
                        include("delete_cancelled_order.php");
                    }
                    if (isset($_GET['delete_return_order'])) {
                        include("delete_return_order.php");
                    }
                    if (isset($_GET['delete_pending_order'])) {
                        include("delete_pending_order.php");
                    }
                    if (isset($_GET['view_completed_refund'])) {
                        include("view_completed_refund.php");
                    }
                    if (isset($_GET['delete_completed_refund'])) {
                        include("delete_completed_refund.php");
                    }
                    if (isset($_GET['insert_boxes'])) {
                        include("insert_boxes.php");
                    }
                    if (isset($_GET['view_boxes'])) {
                        include("view_boxes.php");
                    }
                    if (isset($_GET['edit_boxes'])) {
                        include("edit_boxes.php");
                    }
                    if (isset($_GET['delete_boxes'])) {
                        include("delete_boxes.php");
                    }
                    if (isset($_GET['insert_policy'])) {
                        include("insert_policy.php");
                    }
                    if (isset($_GET['view_policy'])) {
                        include("view_policy.php");
                    }
                    if (isset($_GET['edit_policy'])) {
                        include("edit_policy.php");
                    }
                    if (isset($_GET['delete_policy'])) {
                        include("delete_policy.php");
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </body>

    </html>
<?php } ?>