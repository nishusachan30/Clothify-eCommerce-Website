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
    echo "<script>window.open('', '_self');</script>";
    exit;
}

$cust_email = $_SESSION['cust_email'];

// Fetch customer details
$query = "SELECT cust_id, cust_name FROM customers WHERE cust_email = '$cust_email'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $customer = mysqli_fetch_assoc($result);
    $cust_id = $customer['cust_id'];
    $cust_name = $customer['cust_name'];
} else {
    echo "<script>alert('Customer not found.');</script>";
    exit;
}


// Fetch shipping address
$ship_address_query = "SELECT * FROM customer_address WHERE cust_id = '$cust_id'";
$ship_address_result = mysqli_query($con, $ship_address_query);
if ($ship_address_result && mysqli_num_rows($ship_address_result) > 0) {
    $ship_address_row = mysqli_fetch_assoc($ship_address_result);
    $ship_address = "{$ship_address_row['cust_name']}, {$ship_address_row['house_no']}, {$ship_address_row['street_name']}, {$ship_address_row['landmark']}, {$ship_address_row['city']}, {$ship_address_row['district']}, {$ship_address_row['state']}, {$ship_address_row['country']} - {$ship_address_row['pincode']}";
    $ship_contact = $ship_address_row['cust_contact'];
} else {
    $ship_address = 'Not available';
    $ship_contact = 'Not available';
}

// Fetch billing address
$bill_address_query = "SELECT * FROM customer_billing_address WHERE cust_id = '$cust_id'";
$bill_address_result = mysqli_query($con, $bill_address_query);
if ($bill_address_result && mysqli_num_rows($bill_address_result) > 0) {
    $bill_address_row = mysqli_fetch_assoc($bill_address_result);
    $bill_address = "{$bill_address_row['cust_name']}, {$bill_address_row['house_no']}, {$bill_address_row['street_name']}, {$bill_address_row['landmark']}, {$bill_address_row['city']}, {$bill_address_row['district']}, {$bill_address_row['state']}, {$bill_address_row['country']} - {$bill_address_row['pincode']}";
    $bill_contact = $bill_address_row['cust_contact'];
} else {
    $bill_address = 'Not available';
    $bill_contact = 'Not available';
}

// Verify order ID and retrieve order details
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $order_query = "SELECT * FROM customer_order WHERE order_id='$order_id'";
    $order_result = mysqli_query($con, $order_query);

    if ($order_result && mysqli_num_rows($order_result) > 0) {
        $order = mysqli_fetch_array($order_result);

        // Order details
        $product_id = $order['product_id'];
        $order_due_amount = $order['due_amount'];
        $order_invoice = $order['invoice_no'];
        $order_qty = $order['qty'];
        $order_size = $order['size'];
        $order_date = $order['order_date'];
        $order_status = $order['order_status'];
        $payment_mode = $order['payment_mode'];
        $exp_delivery_date = $order['exp_delivery_date'];
        $delivery_date = $order['delivered_on'];


        // Fetch product image
        $product_query = "SELECT product_title, product_img1 FROM products WHERE product_id='$product_id'";
        $product_result = mysqli_query($con, $product_query);
        $product = mysqli_fetch_array($product_result);
        $product_img = $product['product_img1'];
        $product_title = $product['product_title'];

        // Fetch return/refund status from return_refund table
        $return_refund_query = "SELECT return_refund_status, return_refund_reason FROM return_refund WHERE order_id='$order_id' AND cust_id='$cust_id' ORDER BY requested_at DESC LIMIT 1";
        $return_refund_result = mysqli_query($con, $return_refund_query);

        if ($return_refund_result && mysqli_num_rows($return_refund_result) > 0) {
            $return_refund = mysqli_fetch_assoc($return_refund_result);
            $return_refund_status = $return_refund['return_refund_status'];
            $return_refund_reason = $return_refund['return_refund_reason'];
        } else {
            $return_refund_status = 'None';
            $return_refund_reason = 'N/A';
        }
    } else {
        echo "Order not found.";
        exit;
    }
} else {
    echo "Invalid order ID.";
    exit;
}
?>

<div id="content"> <!-- content starts -->
    <div class="container"> <!--container starts -->
        <div class="col-md-12"> <!-- col-md-12 starts -->
            <ul class="breadcrumb">
                <li><a href="home.php">Home</a></li>
                <li>Account</li>
                <li>My Order</li>
                <li>Order Details</li>
            </ul>
        </div> <!-- col-md-12 ends -->

        <div class="col-md-3"> <!--col-md-3 starts-->
            <?php include("includes/sidebar_account.php"); ?>
        </div> <!--col-md-3 ends-->

        <div class="col-md-9"> <!--col-md-9 starts-->
            <div class="box"> <!--box starts-->
                <center>
                    <h1>Order Details</h1>
                    <p>Details for: <?php echo htmlspecialchars($product_title); ?></p>
                </center>
                <hr>
                <div class="table-responsive"> <!--table-responsive starts-->
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Product Image</th>
                            <td><img src="admin_area/product_images/<?php echo htmlspecialchars($product_img); ?>"
                                    alt="Product Image" width="100" height="100"></td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>₹<?php echo htmlspecialchars($order_due_amount); ?></td>
                        </tr>
                        <tr>
                            <th>Invoice No.</th>
                            <td><?php echo htmlspecialchars($order_invoice); ?></td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td><?php echo htmlspecialchars($order_qty); ?></td>
                        </tr>
                        <tr>
                            <th>Size</th>
                            <td><?php echo htmlspecialchars($order_size); ?></td>
                        </tr>
                        <tr>
                            <th>Order Status</th>
                            <td><strong><?php echo htmlspecialchars($order_status); ?></strong></td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td><?php echo htmlspecialchars($order_date); ?></td>
                        </tr>
                        <?php if ($order_status == 'Delivered'): ?>
                            <tr>
                                <th>Delivery Date</th>
                                <td>
                                    <?php
                                    $current_date = date("Y-m-d"); // Fetch current date
                                    ?>
                                    <p>This order was delivered successfully on
                                        <strong> <?php echo htmlspecialchars($current_date); ?></strong>.<br> The customer
                                        is happy with the
                                        product, and no issues were reported.
                                    </p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <th>Expected Delivery Date</th>
                                <td><?php echo htmlspecialchars($exp_delivery_date); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Payment Mode</th>
                            <td><?php echo htmlspecialchars($payment_mode); ?></td>
                        </tr>
                        <tr>
                            <th>Shipping Address</th>
                            <td><?php echo htmlspecialchars($ship_address); ?></td>
                        </tr>
                        <tr>
                            <th>Billing Address</th>
                            <td><?php echo htmlspecialchars($bill_address); ?></td>
                        </tr>
                    </table>
                    <hr>

                    <?php
                    // Calculate days passed since delivery
                    $current_date = date("Y-m-d");
                    $delivery_date_obj = new DateTime($delivery_date);
                    $current_date_obj = new DateTime($current_date);
                    $days_since_delivery = $current_date_obj->diff($delivery_date_obj)->days;

                    // Check if the button should be disabled (after 5 days)
                    $disable_return_button = ($days_since_delivery > 5);
                    ?>


                    <!-- Cancel and Return buttons -->
                    <div class="text-center"> <!--text-center starts-->
                        <div class="btn-container"> <!--btn-container starts-->
                            <div class="col-md-6"> <!--col-md-6 start-->
                                <?php if ($order_status == 'Seller is processing your order' || $order_status == 'Shipped'): ?>
                                    <form action="cancel_order.php" method="POST"
                                        style="display: inline-block; margin-right: 10px;">
                                        <input type="hidden" name="order_id"
                                            value="<?php echo htmlspecialchars($order_id); ?>">
                                        <button type="submit" name="cancel_order" class="btn btn-danger"><i
                                                class="fa fa-ban"></i>
                                            Cancel Order</button>
                                    </form>

                                <?php elseif ($order_status == 'Cancelled'): ?>
                                    <p style="color:red;">Order is already cancelled.</p>
                                <?php else: ?>
                                    <p style="color:red;">Cancellation period is over for this product.</p>
                                <?php endif; ?>
                                <hr>
                            </div> <!--col-md-6 ends-->

                            <div class="col-md-6"> <!--col-md-6 starts-->
                                <a href="terms.php?#link-2">see return & refund policy</a>
                                <?php if ($order_status == 'Delivered' && $return_refund_status == 'None' && !$disable_return_button): ?>
                                    <form action="request_return_refund.php" method="POST">
                                        <input type="hidden" name="order_id"
                                            value="<?php echo htmlspecialchars($order_id); ?>">
                                        <label for="return_refund_reason">Select Reason for Return:</label>
                                        <select name="return_refund_reason" id="return_refund_reason" class="form-control"
                                            required>
                                            <option value="" disabled selected>Select a reason</option>
                                            <option value="Item is damaged or defective">Item is damaged or defective
                                            </option>
                                            <option value="Wrong item delivered">Wrong item delivered</option>
                                            <option value="Item does not match description">Item does not match description
                                            </option>
                                            <option value="Size/fit issue">Size/fit issue</option>
                                            <option value="Received late">Received late</option>
                                            <option value="Changed my mind">Changed my mind</option>
                                        </select>
                                        <button type="submit" name="request_return_refund" class="btn btn-warning"><i
                                                class="fa fa-rotate-left"></i> Request Return & Refund</button>
                                    </form>
                                <?php else: ?>
                                    <form action="request_return_refund.php" method="POST">
                                        <input type="hidden" name="order_id"
                                            value="<?php echo htmlspecialchars($order_id); ?>">
                                        <button type="submit" name="request_return_refund" class="btn btn-warning" disabled>
                                            <i class="fa fa-rotate-left"></i> Request Return & Refund</button>
                                    </form>
                                <?php endif; ?>
                                <?php if ($return_refund_status == 'Requested'): ?>
                                    <p style="color:orange;">Return & Refund request is pending approval.</p>
                                <?php elseif ($return_refund_status == 'Approved'): ?>
                                    <p style="color:green;">Return & Refund have been approved and processed.</p>
                                <?php elseif ($return_refund_status == 'Rejected'): ?>
                                    <p style="color:red;">Return & Refund request was rejected.</p>
                                <?php elseif ($return_refund_status == 'Returned / Refunded'): ?>
                                    <p style="color:blue;">Return & Refund have been completed.</p>
                                <?php endif; ?>

                                <?php if ($disable_return_button): ?>
                                    <p style="color:red;">Return & Refund request period has expired (5 days past delivery
                                        date).</p>
                                <?php endif; ?>

                                <?php if (!empty($return_refund_reason)): ?>
                                    <p><strong>Reason:</strong> <?php echo htmlspecialchars($return_refund_reason); ?></p>
                                <?php endif; ?>
                            </div> <!--col-md-6 ends-->
                        </div> <!--btn-container ends-->
                    </div> <!--text-center ends-->
                </div> <!--table-responsive ends-->
            </div> <!--box ends-->
        </div> <!--col-md-9 ends-->
    </div> <!--containers end-->
</div> <!--content ends-->

<!-- include footer -->
<?php include("includes/footer.php"); ?>