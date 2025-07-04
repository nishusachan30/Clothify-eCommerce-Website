<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("includes/db.php");

if (!isset($_SESSION['admin_email'])) {
    echo "<script> window.open('login.php','_self') </script>";
} else {

    ?>

    <div class="row"><!--row-1 start-->
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ View Completed Return & Refund Orders
                </li>
            </ol>
        </div>
    </div><!--row-1 end-->

    <div class="row"><!--row-2 start-->
        <div class="col-lg-12"><!--col-lg-12 start-->
            <div class="panel panel-default"><!--panel panel-default start-->
                <div class="panel-heading"><!--panel-heading start-->
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i> Completed Return & Refund Orders
                    </h3>
                </div><!--panel-heading end-->

                <div class="panel_body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Return No</th>
                                    <th>Customer Email</th>
                                    <th>Invoice No</th>
                                    <th>Transaction ID</th>
                                    <th>Product Title</th>
                                    <th>Qty</th>
                                    <th>Size</th>
                                    <th>Refund Processed Date</th>
                                    <th>Refunded To</th>
                                    <th>Total Amount</th>
                                    <th>Reason</th>
                                    <th>Contact</th>
                                    <th>Return & Refund Status</th>
                                    <th>Delete Record</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $get_orders = "SELECT * FROM return_refund WHERE return_refund_status IN ('Returned / Refunded')";
                                $run_orders = mysqli_query($con, $get_orders);
                                while ($row_orders = mysqli_fetch_array($run_orders)) {
                                    $return_refund_id = $row_orders['return_refund_id'];
                                    $c_id = $row_orders['cust_id'];
                                    $invoice_no = $row_orders['invoice_no'];
                                    $refunded_to = $row_orders['refunded_to'];
                                    $product_id = $row_orders['product_id'];
                                    $return_date = $row_orders['processed_at'];
                                    $transaction_id = $row_orders['transaction_id'];
                                    $return_refund_status = $row_orders['return_refund_status'];// Added refund_status
                                    $return_refund_reason = $row_orders['return_refund_reason'];// Added refund_status
                                    $shipping_contact = $row_orders['cust_contact'];// Added refund_status
                                    $get_products = "select * from products where product_id='$product_id'";
                                    $run_products = mysqli_query($con, $get_products);
                                    $row_products = mysqli_fetch_array($run_products);
                                    $product_title = $row_products['product_title'];
                                    $product_price = $row_products['product_price'];

                                    // Fetch quantity, delivered_on, and size from customer_order table using order_id
                                    $order_id = $row_orders['order_id']; 
                                    $get_order_details = "SELECT qty, delivered_on, size FROM customer_order WHERE order_id='$order_id'";
                                    $run_order_details = mysqli_query($con, $get_order_details);
                                    $row_order_details = mysqli_fetch_array($run_order_details);
                                    $quantity = $row_order_details['qty'];
                                    $size = $row_order_details['size'];

                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php
                                            $get_customer = "select * from customers where cust_id='$c_id'";
                                            $run_customer = mysqli_query($con, $get_customer);
                                            $row_customer = mysqli_fetch_array($run_customer);
                                            $customer_email = $row_customer['cust_email'];
                                            echo $customer_email;
                                            ?>
                                        </td>
                                        <td bgcolor="yellow"><?php echo $invoice_no; ?></td>
                                        <td><?php echo $transaction_id; ?></td>
                                        <td><?php echo $product_title; ?></td>
                                        <td><?php echo $quantity; ?></td>
                                        <td><?php echo $size; ?></td>
                                        <td><?php echo $return_date; ?></td>
                                        <td><?php echo $refunded_to; ?></td>
                                        <td>₹<?php echo $product_price; ?></td>
                                        <td><?php echo $return_refund_reason; ?></td>
                                        <td><?php echo $shipping_contact; ?></td>
                                        <td><?php echo $return_refund_status; ?></td>
                                        <td>
                                        <a href="index.php?delete_completed_refund=<?php echo $return_refund_id; ?>">
                                            <i class="fa fa-trash-o"></i> Delete
                                        </a>
                                    </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div><!--panel panel-default end-->
        </div><!--col-lg-12 end-->
    </div><!--row-2 end-->

<?php } ?>