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
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ View Cancelled Orders
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Cancelled Orders
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
                                <th>Total Amount</th>
                                <th>Order Status</th>
                                <th>Delete Record</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $get_orders = "SELECT * FROM customer_order WHERE order_status='Cancelled'";
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
                                    <td><?php echo $due_amount; ?></td>
                                    <td>
                                        <?php
                                        if ($order_status == 'Cancelled') {
                                            echo 'Cancelled';
                                        } else {
                                            echo $order_status == 'Unknown';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="index.php?delete_cancelled_order=<?php echo $order_id; ?>">
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