<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("includes/db.php");
include("includes/header.php");
include("includes/main.php");
include_once("functions/functions.php");

// Redirect to checkout if the customer is not logged in
if (!isset($_SESSION['cust_email'])) {
    echo "<script>alert('Please log in to continue.'); window.open('customer_login.php', '_self');</script>";
    exit;
}

$cust_email = $_SESSION['cust_email'];

// Fetch customer details
$query = "SELECT cust_id, cust_name, cust_contact FROM customers WHERE cust_email = '$cust_email'";
$result = mysqli_query($con, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $customer = mysqli_fetch_assoc($result);
        $cust_id = $customer['cust_id'];
        $cust_name = $customer['cust_name'];
        $cust_contact = $customer['cust_contact'];
    } else {
        echo "<script>alert('Customer not found.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Error fetching customer details. Please try again.'); window.history.back();</script>";
    exit;
}

// Check if order_id is provided and retrieve order details
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    
    // Check if 'return_refund_status' is set, else set it to 'None'
    $return_refund_status = isset($_POST['return_refund_status']) ? $_POST['return_refund_status'] : 'None';
    
    // Ensure refund reason is set
    $return_refund_reason = isset($_POST['return_refund_reason']) ? mysqli_real_escape_string($con, $_POST['return_refund_reason']) : 'No reason provided';

    // Check if a refund request already exists for this order
    $check_query = "SELECT * FROM return_refund WHERE order_id = '$order_id' AND cust_id = '$cust_id'";
    $check_result = mysqli_query($con, $check_query);

    if ($check_result) {
        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('A refund request for this order already exists.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Error checking existing refund request. Please try again.'); window.history.back();</script>";
        exit;
    }

    // Fetch order details
    $order_query = "SELECT * FROM customer_order WHERE order_id = '$order_id' AND cust_id = '$cust_id'";
    $order_result = mysqli_query($con, $order_query);

    if ($order_result) {
        if (mysqli_num_rows($order_result) > 0) {
            $order = mysqli_fetch_assoc($order_result);
            $invoice_no = $order['invoice_no'];
            $product_id = $order['product_id'];
            $order_date = $order['order_date'];
            $ship_address = $order['ship_address'] ?? "N/A";
            $bill_address = $order['bill_address'] ?? "N/A";

            // Fetch product details to get the product price and title
            $product_query = "SELECT product_title, product_price FROM products WHERE product_id = '$product_id'";
            $product_result = mysqli_query($con, $product_query);

            if ($product_result) {
                if (mysqli_num_rows($product_result) > 0) {
                    $product = mysqli_fetch_assoc($product_result);
                    $product_title = $product['product_title'];
                    $refund_amount = $product['product_price'];  // Use product price for refund amount

                    // Insert refund request into return_refund table, including shipping address
                    $insert_query = "INSERT INTO return_refund (order_id, cust_id, product_id, invoice_no, product_title, return_refund_status, return_refund_reason, requested_at, refund_amount, order_date, ship_address, bill_address, cust_contact)
                                     VALUES ('$order_id', '$cust_id', '$product_id', '$invoice_no', '$product_title', 'Requested', '$return_refund_reason', NOW(), '$refund_amount', '$order_date', '$ship_address', '$bill_address', '$cust_contact')";

                    if (mysqli_query($con, $insert_query)) {
                        echo "<script>alert('Return/Refund request submitted successfully.'); window.location.href='order_details.php?order_id=$order_id';</script>";
                    } else {
                        echo "<script>alert('Error submitting return/refund request. Please try again.'); window.history.back();</script>";
                    }
                } else {
                    echo "<script>alert('Product not found.'); window.history.back();</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Error fetching product details. Please try again.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Order not found.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Error fetching order details. Please try again.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
    exit;
}
?>
