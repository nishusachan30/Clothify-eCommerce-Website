<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login.php','_self')</script>";
} else {
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> <a href="index.php?dashboard"> Dashboard </a> / View Payments
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Payments
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Payment No</th>
                                <th>Invoice No</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Amount Paid</th>
                                <th>Product Title</th>
                                <th>Currency</th>
                                <th>Reference No</th>
                                <th>Payment Date</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Delete Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $get_payments = "SELECT * FROM payments";
                            $run_payments = mysqli_query($con, $get_payments);
                            while ($row = mysqli_fetch_array($run_payments)) {
                                $payment_id = $row['payid'];
                                $email = $row['email'];
                                $mobile = $row['mobile'];
                                $invoice_no = $row['invoice_no'];
                                $amount = $row['amount'];
                                $currency = $row['currency'];
                                $payment_mode = $row['payment_mode'];
                                $payment_date = $row['payment_date'];
                                $status = $row['status'];
                                $ref_no = $row['ref_no'];
                                $product_id = $row['product_id'];
                                $i++;

                                // Fetch product title based on product_id
                                $get_product_title = "SELECT product_title FROM products WHERE product_id='$product_id'";
                                $run_product_title = mysqli_query($con, $get_product_title);
                                $product_title_data = mysqli_fetch_array($run_product_title);
                                $product_title = $product_title_data['product_title'];
                            ?>
                            <tr>
                                <td><?php echo $i; ?> </td>
                                <td bgcolor="yellow"><?php echo $invoice_no; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $mobile; ?></td>
                                <td><?php echo $amount; ?></td>
                                <td><?php echo $product_title; ?></td>
                                <td><?php echo $currency; ?></td>
                                <td><?php echo $ref_no; ?></td>
                                <td><?php echo ($status !== 'Pending') ? $payment_date : 'NULL'; ?></td>
                                <td><?php echo $payment_mode; ?></td>
                                <td><?php echo $status; ?></td>
                                <td><a href="index.php?delete_payment=<?php echo $payment_id; ?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>
