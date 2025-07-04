<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("includes/db.php");
include("functions/functions.php");
include("includes/main.php");
include("includes/header.php");

if (!isset($_SESSION['cust_email'])) {
    echo "<script>alert('Please login first to checkout')</script>";
    echo "<script>window.open('customer_login.php', '_self')</script>";
} else {
    $grand_total = isset($_SESSION['grand_total']) ? $_SESSION['grand_total'] : 0;

    $cust_email = $_SESSION['cust_email'];
    $get_customer = "SELECT * FROM customers WHERE cust_email = '$cust_email'";
    $run_cust = mysqli_query($con, $get_customer);

    if ($run_cust && mysqli_num_rows($run_cust) > 0) {
        $row_cust = mysqli_fetch_array($run_cust);
        $customer_id = $row_cust['cust_id'];
    } else {
        echo "<script>alert('Customer not found.');</script>";
        exit();
    }

    $ship_address_query = "SELECT * FROM customer_address WHERE cust_id = '$customer_id'";
    $ship_address_result = mysqli_query($con, $ship_address_query);
    $ship_address = '';
    if ($ship_address_result && mysqli_num_rows($ship_address_result) > 0) {
        $ship_address_row = mysqli_fetch_assoc($ship_address_result);
        $landmark = !empty($ship_address_row['landmark']) ? ' NEAR ' . $ship_address_row['landmark'] : '';
        $ship_address = $ship_address_row['cust_name'] . ', ' . $ship_address_row['house_no'] . ', ' . $ship_address_row['street_name'] . ', ' . $landmark . ', ' . $ship_address_row['city'] . ', ' . $ship_address_row['district'] . ', ' . $ship_address_row['state'] . ', ' . $ship_address_row['country'] . ' - ' . $ship_address_row['pincode'];
        $ship_contact = $ship_address_row['cust_contact'];
    } else {
        $ship_address = 'Not available';
        $ship_contact = 'Not available';
    }

    $bill_address_query = "SELECT * FROM customer_billing_address WHERE cust_id = '$customer_id'";
    $bill_address_result = mysqli_query($con, $bill_address_query);
    $bill_address = '';
    if ($bill_address_result && mysqli_num_rows($bill_address_result) > 0) {
        $bill_address_row = mysqli_fetch_assoc($bill_address_result);
        $landmark = !empty($bill_address_row['landmark']) ? ' NEAR ' . $bill_address_row['landmark'] : '';
        $bill_address = $bill_address_row['cust_name'] . ', ' . $bill_address_row['house_no'] . ', ' . $bill_address_row['street_name'] . ', ' . $landmark . ', ' . $bill_address_row['city'] . ', ' . $bill_address_row['district'] . ', ' . $bill_address_row['state'] . ', ' . $bill_address_row['country'] . ' - ' . $bill_address_row['pincode'];
        $bill_contact = $bill_address_row['cust_contact'];
    } else {
        $bill_address = 'Not available';
        $bill_contact = 'Not available';
    }

    // Check if shipping and billing addresses are empty
    if ($ship_address === 'Not available' || $bill_address === 'Not available') {
        echo "<script>alert('Shipping and billing addresses are required to place an order.')</script>";
        echo "<script>window.location.href = 'account.php?my_address';</script>";
        exit();
    }
    $ip_add = getUserIP();
    $cust_id = isset($_SESSION['cust_id']) ? $_SESSION['cust_id'] : '';
    $select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add' OR cust_id='$cust_id'";
    $run_cart = mysqli_query($db, $select_cart);
    $count = mysqli_num_rows($run_cart); // Count items in the cart

    // Initialize totals
    $total = 0;
    $tax_total = 0;
    $item_tax = 0;
    $shipping = 0;

    // Calculate subtotal, tax, and shipping
    while ($row_cart = mysqli_fetch_array($run_cart)) {
        $pro_id = $row_cart['p_id'];
        $pro_qty = $row_cart['qty'];

        // Fetch product details
        $get_product = "SELECT * FROM products WHERE product_id='$pro_id'";
        $run_pro = mysqli_query($db, $get_product);
        $row_pro = mysqli_fetch_array($run_pro);

        $p_price = $row_pro['product_price'];
        $item_total = $p_price * $pro_qty;

        // Add item totals to the overall cart totals
        $total += $item_total;
        $item_tax = $total * 0.01; // 1% tax per item
    }

    // Apply shipping if subtotal is between 0 and 799
    if ($total > 0 && $total < 599) {
        $shipping = 99;
    }

    $grand_total = $total + $shipping + $item_tax;

    $_SESSION['subtotal'] = $total;
    $_SESSION['shipping'] = $shipping;
    $_SESSION['tax_total'] = $item_tax;
    $_SESSION['grand_total'] = $grand_total;
    ?>
    <div id="content">
        <div class="container">
            <!-- Loading Overlay (Initially hidden) -->
            <div id="loading-overlay" style="display: none;">
                <div class="loading-circle"></div>
            </div>

            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="home.php">Home</a></li>
                    <li>Check Out</li>
                </ul>
            </div>


            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">
                        <h4>Shipping To:</h4>
                        <p><?php echo $ship_address; ?> </p>
                        <hr>
                        <h4>Billing To:</h4>
                        <?php echo $bill_address; ?> </p>
                        <div class="text-center">
                            <a href="account.php?my_address" class="btn btn-primary"><i class="fa fa-refresh"></i> Change
                                Address</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="box" id="order-summary">
                    <div class="box-header">
                        <h3>Order Summary</h3>
                    </div>
                    <p class="text-muted">Shipping & Additional Costs are calculated based on the values you have entered
                    </p>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-left">Order Subtotal</td>
                                    <td class="text-right">₹ <?php echo number_format($total, 2); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-left">Shipping & handling</td>
                                    <td class="text-right">₹ <?php echo number_format($shipping, 2); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-left">Tax (1%)</td>
                                    <td class="text-right">₹ <?php echo number_format($item_tax, 2); ?></td>
                                </tr>
                                <tr class="total">
                                    <td class="text-left">Total</td>
                                    <td class="text-right">₹ <?php echo number_format($grand_total, 2); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="box">
                    <div class="card">
                        <div class="card-header">
                            <center>
                                <h3>Choose a payment method</h3>
                            </center>
                            <div class="form-group text-center">
                                <h4><strong>Total Payment: $<?php echo number_format($grand_total, 2); ?></strong></h4>
                            </div>
                            <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                                <!-- Credit card form tabs -->
                                <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                    <!-- COD option -->
                                    <li class="col-md-12">
                                        <center>
                                            <a data-toggle="pill" href="#cod" class="btn btn-primary btn-lg">
                                                <i class="fas fa-cash-register mr-2"></i> Cash on Delivery
                                            </a>
                                        </center> <br>
                                        <div id="paypal-button-container"></div>
                                    </li>
                                </ul>
                                <ul>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <!-- Credit card info -->


                            <!-- Cash on Delivery info -->
                            <div id="cod" class="tab-pane fade pt-3">
                                <div class="form-group">
                                    <h6>Cash on Delivery (COD) selected</h6>
                                </div>
                                <!-- Place Order button for COD -->
                                <div class="form-group">
                                    <button type="button" class="btn btn-success btn-block" id="place-order-btn">
                                        Place Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Custom styles to handle tab behavior and prevent spacing issues -->


        </div>
    </div>

    <!-- Footer start -->
    <?php include("includes/footer.php"); ?>
    <!-- Footer end -->

    <!-- Script to insert payment method to customer order table -->
    <script>
        //Script to insert payment method to customer order table
        document.getElementById('place-order-btn').addEventListener('click', function () {
            // Show the loading overlay
            document.getElementById('loading-overlay').style.display = 'block';

            // Create an object with order details
            var orderDetails = {
                paymentMethod: 'COD',
                userId: 1,  // You will dynamically get the user ID (from session or database)
                totalAmount: 100,  // Total amount for the order (you can dynamically calculate this)
                status: 'Pending'
            };

            // Create a hidden form to send data to the PHP server
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'place_order.php';

            // Add fields to the form dynamically
            for (var key in orderDetails) {
                if (orderDetails.hasOwnProperty(key)) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = orderDetails[key];
                    form.appendChild(input);
                }
            }

            // Append the form to the document and submit it
            document.body.appendChild(form);
            form.submit();
        });
    </script>

    <!-- PayPal integration script -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=AWXhg8kK6UJOxkqGEjqw78Ibkt3FUZCKL5arN_gNwMDDCSKvTHxwHX89fvLpdmPkTNqy7tb3Hn9B9YrT&components=buttons"></script>
    <script>
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo $grand_total; ?> // Total amount to be paid
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    // Prepare data to send to the server
                    var invoiceNo = "INV" + Math.floor(Math.random() * 1000000); // Generate a random invoice number
                    var orderData = {
                        order_id: details.id,
                        cust_id: <?php echo $customer_id; ?>, // Customer ID
                        product_id: <?php echo $pro_id; ?>, // Product ID
                        due_amount: <?php echo $grand_total; ?>,
                        invoice_no: invoiceNo, // Pass the generated invoice number
                        qty: 1, // Set dynamically based on cart
                        size: 'M', // Set dynamically if required
                        payment_id: details.id, // PayPal payment ID
                        ship_address: '<?php echo $ship_address; ?>', // Shipping address
                        bill_address: '<?php echo $bill_address; ?>', // Billing address
                        txn_id: details.purchase_units[0].payments.captures[0].id, // PayPal transaction ID
                        amount: details.purchase_units[0].amount.value, // Total amount
                        currency: details.purchase_units[0].amount.currency_code, // Currency
                        mobile: '<?php echo $ship_contact; ?>', // Customer's mobile number
                        email: '<?php echo $cust_email; ?>' // Customer's email
                    };


                    // Send data to the server using AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "place_order.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onload = function () {
                        if (xhr.status == 200) {
                            alert('Payment successful! Order placed.');
                            window.location.href = 'order_placed_succ.php'; // Redirect after success
                        } else {
                            alert('Error processing the payment!');
                        }
                    };
                    var dataString = "";
                    for (var key in orderData) {
                        dataString += key + "=" + encodeURIComponent(orderData[key]) + "&";
                    }
                    xhr.send(dataString);
                });
            },
            onError: function (err) {
                alert('An error occurred during payment: ' + err);
            }
        }).render('#paypal-button-container');


    </script>
<?php } ?>