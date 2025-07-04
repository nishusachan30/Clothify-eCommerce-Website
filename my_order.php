<div class="box"><!-- Box Start -->
    <center>
        <h1>My Orders</h1>
        <p>Your all orders at one place</p>
    </center>

    <hr> <!-- Horizontal line separating header and table -->

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Product Image</th>
                    <th>Due Amount</th>
                    <th>Invoice No.</th>
                    <th>Quantity</th>
                    <th>Size</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Initialize error message variable
                $error_message = "";

                // Fetch the logged-in customer's email from session
                if (isset($_SESSION['cust_email'])) {
                    $customer_session = $_SESSION['cust_email'];
                    
                    // Get customer data from the database using their email
                    $get_customer = "SELECT * FROM customers WHERE cust_email='$customer_session'";
                    $run_cust = mysqli_query($con, $get_customer);

                    if ($run_cust) {
                        if (mysqli_num_rows($run_cust) > 0) {
                            $row_cust = mysqli_fetch_array($run_cust);
                            $customer_id = $row_cust['cust_id'];

                            // Fetch all orders of the customer from the 'customer_order' table
                            $get_order = "SELECT * FROM customer_order WHERE cust_id='$customer_id' ORDER BY order_date ASC";
                            $run_order = mysqli_query($con, $get_order);

                            if ($run_order) {
                                if (mysqli_num_rows($run_order) > 0) {
                                    $i = 0;

                                    // Loop through each order
                                    while ($row_order = mysqli_fetch_array($run_order)) {
                                        $order_id = $row_order['order_id'];
                                        $product_id = $row_order['product_id'];
                                        $order_due_amount = $row_order['due_amount'];
                                        $order_invoice = $row_order['invoice_no'];
                                        $order_qty = $row_order['qty'];
                                        $order_size = $row_order['size'];
                                        $order_date = $row_order['order_date'];
                                        $order_status = $row_order['order_status'];
                                        $i++;

                                        // Fetch the product image using the product_id
                                        $get_product = "SELECT product_img1 FROM products WHERE product_id='$product_id'";
                                        $run_product = mysqli_query($con, $get_product);

                                        if ($run_product && mysqli_num_rows($run_product) > 0) {
                                            $row_product = mysqli_fetch_array($run_product);
                                            $product_img = $row_product['product_img1'];
                                        } else {
                                            $product_img = "no_image.png"; // Fallback image
                                        }
                ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><img src="admin_area/product_images/<?php echo $product_img; ?>" alt="Product Image" width="50" height="50"></td>
                                            <td><?php echo $order_due_amount; ?></td>
                                            <td><?php echo $order_invoice; ?></td>
                                            <td><?php echo $order_qty; ?></td>
                                            <td><?php echo $order_size; ?></td>
                                            <td><?php echo $order_date; ?></td>
                                            <td><?php echo $order_status; ?></td>
                                            <td> 
                                                <button onclick="redirectToOrderDetails(<?php echo $order_id; ?>)" class="btn btn-primary btn-sm">Details</button>
                                            </td>
                                        </tr>
                <?php
                                    }
                                } else {
                                    $error_message = "No orders found for your account.";
                                }
                            } else {
                                $error_message = "Failed to fetch orders. Please try again later.";
                            }
                        } else {
                            $error_message = "Customer account not found.";
                        }
                    } else {
                        $error_message = "Failed to fetch customer information. Please try again later.";
                    }
                } else {
                    $error_message = "You are not logged in.";
                }

                // Display error message if any
                if (!empty($error_message)) {
                    echo "<tr><td colspan='8' class='text-center text-danger'>$error_message</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div><!-- Box End -->

<script>
    function redirectToOrderDetails(orderId) {
        window.location.href = `order_details.php?order_id=${orderId}`;
    }
</script>
