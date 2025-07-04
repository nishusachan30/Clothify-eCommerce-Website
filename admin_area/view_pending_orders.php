<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("includes/db.php"); // Include your database connection

// Redirect to login page if admin is not logged in
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
    exit();
}

// Update order status if form is submitted
if (isset($_POST['order_id']) && isset($_POST['order_status'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $update_order_status = "UPDATE customer_order SET order_status = '$order_status' WHERE order_id = '$order_id'";
    $run_update = mysqli_query($con, $update_order_status);

    if ($run_update) {
        echo "<script>alert('Order status has been updated successfully!')</script>";
        echo "<script>window.open('index.php?view_pending_orders','_self')</script>";
    } else {
        echo "<script>alert('Error updating order status.')</script>";
    }
    // Assuming somewhere in your order management flow, you set the status to 'Delivered'
    if ($order_status == 'Delivered') {

        // Update the delivery date in the customer_order table
        $update_delivery_query = "UPDATE customer_order SET delivered_on = NOW() WHERE order_id = '$order_id'";
        if (!mysqli_query($con, $update_delivery_query)) {
            echo "<script>alert('Error updating delivery date. Please try again.');</script>";
        }
        // Fetch the invoice number associated with the delivered order
        $get_invoice = "SELECT invoice_no FROM customer_order WHERE order_id = '$order_id'";
        $run_invoice = mysqli_query($con, $get_invoice);

        if (!$run_invoice) {
            die("Error fetching invoice number: " . mysqli_error($con));
        }

        $row_invoice = mysqli_fetch_assoc($run_invoice);

        if ($row_invoice) {
            $invoice_no = $row_invoice['invoice_no'];

            // Update the payment date in the payments table where the invoice number matches
            $update_payment_date = "UPDATE payments SET payment_date = NOW(), status='Completed' WHERE invoice_no = '$invoice_no'";
            if (!mysqli_query($con, $update_payment_date)) {
                die("Error updating payment date: " . mysqli_error($con));
            }
        } else {
            die("Invoice number not found for order_id: $order_id");
        }
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ View Pending Orders
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Pending Orders
                </h3>
            </div>

            <div class="panel_body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Customer Email</th>
                                <th>Invoice No</th>
                                <th>Product Title</th>
                                <th>Product Qty</th>
                                <th>Product Size</th>
                                <th>Order Date</th>
                                <th>Ship Address</th>
                                <th>Bill Address</th>
                                <th>Total Amount</th>
                                <th>Order Status</th>
                                <th>Delete Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $get_orders = "SELECT * FROM customer_order WHERE order_status IN ('Seller is processing your order','Shipped', 'Out For Delivery')";
                            $run_orders = mysqli_query($con, $get_orders);

                            while ($row_orders = mysqli_fetch_array($run_orders)) {
                                $order_id = $row_orders['order_id'];
                                $c_id = $row_orders['cust_id'];
                                $invoice_no = $row_orders['invoice_no'];
                                $product_id = $row_orders['product_id'];
                                $qty = $row_orders['qty'];
                                $size = $row_orders['size'];
                                $order_date = $row_orders['order_date'];
                                $due_amount = $row_orders['due_amount'];
                                $order_status = $row_orders['order_status'];
                                $ship_address = $row_orders['ship_address'];
                                $bill_address = $row_orders['bill_address'];

                                // Fetch product title
                                $get_products = "SELECT product_title FROM products WHERE product_id='$product_id'";
                                $run_products = mysqli_query($con, $get_products);
                                $row_products = mysqli_fetch_array($run_products);
                                $product_title = $row_products['product_title'];
                                $i++;

                                // Fetch customer email
                                $get_customer = "SELECT cust_email FROM customers WHERE cust_id='$c_id'";
                                $run_customer = mysqli_query($con, $get_customer);
                                $row_customer = mysqli_fetch_array($run_customer);
                                $customer_email = $row_customer['cust_email'];
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $customer_email; ?></td>
                                    <td bgcolor="yellow"><?php echo $invoice_no; ?></td>
                                    <td><?php echo $product_title; ?></td>
                                    <td><?php echo $qty; ?></td>
                                    <td><?php echo $size; ?></td>
                                    <td><?php echo $order_date; ?></td>
                                    <td><?php echo $ship_address; ?></td>
                                    <td><?php echo $bill_address; ?></td>
                                    <td><?php echo $due_amount; ?></td>
                                    <td>
                                        <form action="" method="POST">
                                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                            <select name="order_status" onchange="this.form.submit()" class="form-control"
                                                style="min-width: 150px; max-width: 100%;">
                                                <option value="Seller is processing your order" <?php if ($order_status == 'Seller is processing your order')
                                                    echo 'selected'; ?>>Seller is processing your order</option>
                                                <option value="Shipped" <?php if ($order_status == 'Shipped')
                                                    echo 'selected'; ?>>Shipped</option>
                                                <option value="Out for Delivery" <?php if ($order_status == 'Out for Delivery')
                                                    echo 'selected'; ?>>Out for Delivery</option>
                                                <option value="Delivered" <?php if ($order_status == 'Delivered')
                                                    echo 'selected'; ?>>Delivered</option>
                                                <option value="Cancelled" <?php if ($order_status == 'Cancelled')
                                                    echo 'selected'; ?>>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="index.php?delete_pending_order=<?php echo $order_id; ?>">
                                            <i class="fa fa-trash-o"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>