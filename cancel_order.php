<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("includes/db.php");

// Check if the cancel order request is submitted with an order ID
if (isset($_POST['cancel_order']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Ensure the customer is logged in
    if (!isset($_SESSION['cust_email'])) {
        echo "<script>alert('Please log in to cancel an order.');</script>";
        echo "<script>window.open('customer_login.php', '_self');</script>";
        exit;
    }

    // Get customer email from session and retrieve customer ID from the database
    $cust_email = $_SESSION['cust_email'];
    $cust_query = "SELECT cust_id FROM customers WHERE cust_email = '$cust_email'";
    $cust_result = mysqli_query($con, $cust_query);

    // Check if the customer query was successful
    if (!$cust_result) {
        echo "<script>alert('Error retrieving customer data: " . mysqli_error($con) . "');</script>";
        exit;
    }

    $cust_data = mysqli_fetch_assoc($cust_result);

    // Check if customer data was retrieved
    if (!$cust_data) {
        echo "<script>alert('Customer information could not be retrieved.');</script>";
        exit;
    }

    $cust_id = $cust_data['cust_id'];

    // Verify the order exists and belongs to the logged-in customer
    $order_query = "SELECT * FROM customer_order WHERE order_id = '$order_id' AND cust_id = '$cust_id'";
    $order_result = mysqli_query($con, $order_query);

    // Check if the order query was successful
    if (!$order_result) {
        echo "<script>alert('Error retrieving order data: " . mysqli_error($con) . "');</script>";
        exit;
    }

    $order = mysqli_fetch_assoc($order_result);

    // If order does not exist or does not belong to the customer, display an error
    if (!$order) {
        echo "<script>alert('Order not found or does not belong to you.');</script>";
        exit;
    }

    // Only allow cancellation if the order status is 'Seller is processing your order'
    if ($order['order_status'] != 'Seller is processing your order') {
        echo "<script>alert('Order cannot be canceled as it is already " . $order['order_status'] . ".');</script>";
        echo "<script>window.open('order_details.php?order_id=$order_id', '_self');</script>";
        exit;
    }

    // Start a transaction to ensure order cancellation and stock update occur together
    mysqli_begin_transaction($con);

    try {
        // Update the order status to 'Cancelled'
        $cancel_order_query = "UPDATE customer_order SET order_status = 'Cancelled' WHERE order_id = '$order_id'";
        if (!mysqli_query($con, $cancel_order_query)) {
            throw new Exception("Error updating order status: " . mysqli_error($con));
        }

        // Restore stock for each product in the order
        $items_query = "SELECT product_id, qty FROM customer_order WHERE order_id = '$order_id'";
        $items_result = mysqli_query($con, $items_query);

        // Check if the items query was successful
        if (!$items_result) {
            throw new Exception("Error retrieving items for the order: " . mysqli_error($con));
        }

        while ($item = mysqli_fetch_assoc($items_result)) {
            $product_id = $item['product_id'];
            $quantity = $item['qty'];

            // Update stock for the product in the database
            $update_stock_query = "UPDATE products SET product_availability = product_availability + $quantity WHERE product_id = '$product_id'";
            if (!mysqli_query($con, $update_stock_query)) {
                throw new Exception("Error updating stock for product ID $product_id: " . mysqli_error($con));
            }
        }

        // Commit the transaction if everything succeeded
        mysqli_commit($con);

        // Provide feedback and redirect the user to the order details page
        echo "<script>alert('Order has been canceled successfully.');</script>";
        echo "<script>window.open('order_details.php?order_id=$order_id', '_self');</script>";
    } catch (Exception $e) {
        // Roll back the transaction if any step failed, then display an error
        mysqli_rollback($con);
        echo "<script>alert('An error occurred: " . $e->getMessage() . "');</script>";
    }
} else {
    // If the cancel order form is not properly submitted, display an error
    echo "<script>alert('Invalid request.');</script>";
}
?>
