<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("includes/db.php");
include("functions/functions.php");


// Check if the customer is logged in (cust_id exists in session)
if (isset($_SESSION['cust_email'])) {
    $cust_email = $_SESSION['cust_email'];
    $query = "SELECT cust_id, cust_contact FROM customers WHERE cust_email='$cust_email'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $cust_id = $row['cust_id'];
        $mobile = $row['cust_contact'];
    } else {
        echo "Customer ID not found. Please log in again.";
        exit;
    }
} else {
    echo "You need to log in first.";
    exit;
}

// Ensure `grand_total` is set in the session
if (!isset($_SESSION['grand_total'])) {
    echo "Grand total not available.";
    exit;
}

$grand_total = $_SESSION['grand_total'];
$email = $_SESSION['cust_email'];

// Fetch addresses from my_address table
$address_query = "
    SELECT 
        CONCAT(
            house_no, ' ', street_name, ', ', 
            IF(landmark != '', CONCAT(landmark, ', '), ''), 
            city, ', ', 
            district, ', ', 
            state, ' - ', 
            pincode, ', ', 
            country
        ) AS full_address 
    FROM customer_address 
    WHERE cust_id = '$cust_id' 
    LIMIT 1
";

$address_result = mysqli_query($db, $address_query);

if (mysqli_num_rows($address_result) > 0) {
    $address_row = mysqli_fetch_assoc($address_result);
    $ship_address = $address_row['full_address'];
    $bill_address = $address_row['full_address']; // Assuming billing is the same as shipping
} else {
    echo "Address not found. Please update your address.";
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paymentMethod'], $_POST['totalAmount'])) {
    $paymentMethod = $_POST['paymentMethod'];
    $totalAmount = $_POST['totalAmount'];

    $orderStatus = 'Seller is processing your order';
    $ip_add = getUserIP();
    $select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add' OR cust_id='$cust_id'";
    $run_cart = mysqli_query($db, $select_cart);

    if (mysqli_num_rows($run_cart) > 0) {
        $con->begin_transaction();

        try {
            // Initialize an array to track inserted order IDs for payments
            $orderIds = [];

            // Define tax rate and shipping charges (can be dynamic if needed)
            $taxRate = 0.01; // 18% tax
            $shippingCharges = 99; // Total shipping charges for the order

            // Calculate the total number of items in the cart to divide shipping charges proportionally
            $totalItems = mysqli_num_rows($run_cart);

            while ($item = mysqli_fetch_array($run_cart)) {
                $productId = $item['p_id'];
                $quantity = $item['qty'];
                $size = $item['size'];

                // Fetch product price from the database
                $get_product = "SELECT product_price FROM products WHERE product_id='$productId'";
                $run_product = mysqli_query($db, $get_product);
                $product_data = mysqli_fetch_array($run_product);
                $price = $product_data['product_price'];

                // Calculate base amount for the current product
                $baseAmount = $quantity * $price;

                // Calculate tax and proportional shipping charge
                $taxAmount = $baseAmount * $taxRate;
                // Apply shipping charges conditionally
                $shippingShare = 0; // Default is no shipping charge
                if ($baseAmount < 599) {
                    $shippingShare = $shippingCharges / $totalItems;
                }
                $shippingShare = $shippingCharges / $totalItems;

                // Calculate total due amount (including tax and shipping charges)
                $dueAmount = $baseAmount + $taxAmount + $shippingShare;

                // Generate a new invoice number for each product
                $invoiceNo = generateInvoiceNo();

                // Insert the order into `customer_order` table
                $sql = "INSERT INTO customer_order (cust_id, product_id, due_amount, invoice_no, qty, size, order_date, order_status, payment_mode, ship_address, bill_address)
            VALUES ('$cust_id', '$productId', '$dueAmount', '$invoiceNo', '$quantity', '$size', NOW(), '$orderStatus', '$paymentMethod','$ship_address','$bill_address')";

                if (!$con->query($sql)) {
                    throw new Exception("Error inserting order: " . $con->error);
                }

                // Retrieve the last inserted order ID
                $order_id = $con->insert_id;

                // Store the order ID and other data for payment insertion
                $orderIds[] = [
                    'order_id' => $order_id,
                    'product_id' => $productId,
                    'invoice_no' => $invoiceNo,
                    'due_amount' => $dueAmount // Save the due amount for payment
                ];
            }

            // Generate a unique reference number for the payment
            $refNo = generateRefNo();

            // Determine payment status and set payment date accordingly
            $paymentStatus = ($paymentMethod === 'COD') ? 'Pending' : 'Completed';
            $paymentDate = ($paymentStatus === 'Pending') ? 'NULL' : 'NOW()';

            // Insert payment information into `payments` table
            foreach ($orderIds as $order) {
                $paymentSql = "INSERT INTO payments (order_id, cust_id, amount, invoice_no, product_id, currency, mobile, email, payment_date, payment_mode, status, ref_no)
                               VALUES ('{$order['order_id']}', '$cust_id', '{$order['due_amount']}', '{$order['invoice_no']}', '{$order['product_id']}', 'INR', '$mobile', '$email', $paymentDate, '$paymentMethod', '$paymentStatus', '$refNo')";

                if (!$con->query($paymentSql)) {
                    throw new Exception("Error inserting payment: " . $con->error);
                }
            }

            $con->commit();

            // Clear cart items after successful order placement
            $clear_cart = "DELETE FROM cart WHERE ip_add='$ip_add' OR cust_id='$cust_id'";
            mysqli_query($db, $clear_cart);

            // Store the last `invoiceNo` in session for redirect
            $_SESSION['invoiceNo'] = end($orderIds)['invoice_no']; // Get the last invoice number
            header("Location: order_placed_succ.php");
            exit;
        } catch (Exception $e) {
            $con->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Your cart is empty.";
    }

} else {
    echo "Invalid request.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect POST data
    $order_id = $_POST['order_id'];
    $cust_id = $_POST['cust_id'];
    $product_id = $_POST['product_id'];
    $due_amount = $_POST['due_amount'];
    $invoice_no = $_POST['invoice_no'];
    $qty = $_POST['qty'];
    $size = $_POST['size'];
    $payment_status = 'Completed'; // Since PayPal payment is successful
    $payment_mode = 'PayPal';
    $payment_id = $_POST['payment_id'];
    $order_date = date('Y-m-d H:i:s');
    $ship_address = $_POST['ship_address'];
    $bill_address = $_POST['bill_address'];
    $order_status = 'Seller is processing your order';
    $exp_delivery_date = $_POST['exp_delivery_date'];
    $return_status = 'Not Applicable';

    // Insert into customer_order table
    $insert_order = "INSERT INTO customer_order (order_id, cust_id, product_id, due_amount, invoice_no, qty, size, payment_status, payment_mode, payment_id, order_date, ship_address, bill_address, order_status, exp_delivery_date, return_status) VALUES ('$order_id', '$cust_id', '$product_id', '$due_amount', '$invoice_no', '$qty', '$size', '$payment_status', '$payment_mode', '$payment_id', '$order_date', '$ship_address', '$bill_address', '$order_status', '$exp_delivery_date', '$return_status')";
    $run_insert_order = mysqli_query($con, $insert_order);

    if ($run_insert_order) {
        // Insert into payments table
        $txn_id = isset($_POST['txn_id']) ? mysqli_real_escape_string($con, $_POST['txn_id']) : '';
        $amount = isset($_POST['amount']) ? mysqli_real_escape_string($con, $_POST['amount']) : '';
        $currency = isset($_POST['currency']) ? mysqli_real_escape_string($con, $_POST['currency']) : '';
        $mobile = isset($_POST['mobile']) ? mysqli_real_escape_string($con, $_POST['mobile']) : '';
        $email = isset($_POST['email']) ? mysqli_real_escape_string($con, $_POST['email']) : '';
        $payment_date = date('Y-m-d H:i:s');
        $status = 'Completed';
        
        $insert_payment = "INSERT INTO payments (order_id, cust_id, invoice_no, ref_no, txn_id, amount, product_id, currency, mobile, email, payment_mode, payment_date, status) 
                           VALUES ('$order_id', '$cust_id', '$invoice_no', NULL, '$txn_id', '$amount', '$product_id', '$currency', '$mobile', '$email', '$payment_mode', '$payment_date', '$status')";
        $run_insert_payment = mysqli_query($con, $insert_payment);
        
        if ($run_insert_payment) {
            // Clear cart items after successful order and payment
            $clear_cart = "DELETE FROM cart WHERE cust_id='$cust_id'"; // Remove items for logged-in users
            mysqli_query($con, $clear_cart); // Remove cart for the user
            
            echo "Payment data inserted and cart cleared successfully!";
        } else {
            echo "Error inserting payment details: " . mysqli_error($con);
        }
        
    } else {
        echo "Error inserting order details.";
    }
} else {
    echo "Invalid request method.";
}

$con->close();

function generateInvoiceNo()
{
    return 'INV-' . strtoupper(uniqid());
}

// Function to generate a unique reference number
function generateRefNo()
{
    return 'REF-' . strtoupper(uniqid());
}
?>