<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("includes/db.php");

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {

    // Update return status and handle transaction details
    if (isset($_POST['return_refund_id_status']) && isset($_POST['return_refund_status'])) {
        $return_id = mysqli_real_escape_string($con, $_POST['return_refund_id_status']);
        $return_refund_status = mysqli_real_escape_string($con, $_POST['return_refund_status']);

        // Check for "Returned / Refunded" status
        if ($return_refund_status === 'Returned / Refunded') {
            $transaction_id = 'TXN-' . uniqid() . '-' . time();

            // Fetch the selected transfer method
            $get_transfer_method = "SELECT transfer_method FROM return_refund WHERE return_refund_id = '$return_id'";
            $run_transfer_method = mysqli_query($con, $get_transfer_method);
            $row_transfer_method = mysqli_fetch_array($run_transfer_method);
            $transfer_method = $row_transfer_method['transfer_method'] ?? '';

            $bank_or_upi_details = '';

            if ($transfer_method === 'bank_transfer') {
                // Fetch bank details
                $get_bank_details = "
                SELECT 
                    CONCAT(account_holder_name, ', ', bank_name, ' (', account_number, '), IFSC: ', ifsc_code) AS bank_details 
                FROM customer_bank_details
                WHERE cust_id = (SELECT cust_id FROM return_refund WHERE return_refund_id = '$return_id')
            ";

                $run_bank_details = mysqli_query($con, $get_bank_details);
                $row_bank_details = mysqli_fetch_array($run_bank_details);
                $bank_or_upi_details = $row_bank_details['bank_details'] ?? 'N/A';
            } elseif ($transfer_method === 'upi_id') {
                // Fetch UPI details
                $get_upi_details = "SELECT upi_id FROM customer_bank_details 
                                    WHERE cust_id = (SELECT cust_id FROM return_refund WHERE return_refund_id = '$return_id')";
                $run_upi_details = mysqli_query($con, $get_upi_details);
                $row_upi_details = mysqli_fetch_array($run_upi_details);
                $bank_or_upi_details = $row_upi_details['upi_id'] ?? 'N/A';
            }

            // Update status and details
            $update_return_refund_status = "
                UPDATE return_refund 
                SET return_refund_status = '$return_refund_status',
                    transaction_id = '$transaction_id',
                    processed_at = NOW(),
                    refunded_to = '$bank_or_upi_details'
                WHERE return_refund_id = '$return_id'
            ";
        } else {
            // Update for other statuses
            $update_return_refund_status = "
                UPDATE return_refund 
                SET return_refund_status = '$return_refund_status' 
                WHERE return_refund_id = '$return_id'
            ";
        }

        // Execute the query
        $run_update = mysqli_query($con, $update_return_refund_status);

        if ($run_update) {
            echo "<script>alert('Return & Refund status updated successfully!')</script>";
            echo "<script>window.open('index.php?view_return_refund_orders','_self')</script>";
        } else {
            echo "<script>alert('Error updating return & refund status.')</script>";
        }
    }

    // Handle transfer method update
    if (isset($_POST['return_refund_id_transfer']) && isset($_POST['transfer_method'])) {
        $return_id = mysqli_real_escape_string($con, $_POST['return_refund_id_transfer']);
        $transfer_method = mysqli_real_escape_string($con, $_POST['transfer_method']);

        $update_transfer_method = "
            UPDATE return_refund 
            SET transfer_method = '$transfer_method' 
            WHERE return_refund_id = '$return_id'
        ";
        $run_update_transfer = mysqli_query($con, $update_transfer_method);

        if ($run_update_transfer) {
            echo "<script>alert('Transfer method updated successfully!')</script>";
            echo "<script>window.open('index.php?view_return_refund_orders','_self')</script>";
        } else {
            echo "<script>alert('Error updating transfer method.')</script>";
        }
    }
    ?>


    <div class="row"><!--row-1 start-->
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ View Request Return Orders
                </li>
            </ol>
        </div>
    </div><!--row-1 end-->

    <div class="row"><!--row-2 start-->
        <div class="col-lg-12"><!--col-lg-12 start-->
            <div class="panel panel-default"><!--panel panel-default start-->
                <div class="panel-heading"><!--panel-heading start-->
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i> Return & Refund Orders
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
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Size</th>
                                    <th>Request Date</th>
                                    <th>Total Amount</th>
                                    <th>Reason</th>
                                    <th>Contact</th>
                                    <th>Ship Address</th>
                                    <th>Bill Address</th>
                                    <th>Transfer Method</th> <!-- New Transfer Method Column -->
                                    <th>Bank/UPI Details</th>
                                    <th>Status</th>
                                    <th>Delete Record</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;

                                // Fetch all return refund orders with statuses 'Requested', 'Approved', or 'Rejected'
                                $get_orders = "SELECT * FROM return_refund WHERE return_refund_status IN ('Requested', 'Approved', 'Rejected')";
                                $run_orders = mysqli_query($con, $get_orders);

                                while ($row_orders = mysqli_fetch_array($run_orders)) {
                                    $return_refund_id = $row_orders['return_refund_id'];
                                    $c_id = $row_orders['cust_id'];
                                    $invoice_no = $row_orders['invoice_no'];
                                    $product_id = $row_orders['product_id'];
                                    $return_date = $row_orders['requested_at'];
                                    $return_refund_status = $row_orders['return_refund_status'];
                                    $return_refund_reason = $row_orders['return_refund_reason'];
                                    $shipping_contact = $row_orders['cust_contact'];
                                    $ship_address = $row_orders['ship_address'];
                                    $bill_address = $row_orders['bill_address'];
                                    $transfer_method = $row_orders['transfer_method']; // Fetch the transfer method
                            
                                    // Fetch customer bank details
                                    $get_bank_details = "SELECT * FROM customer_bank_details WHERE cust_id = '$c_id'";
                                    $run_bank_details = mysqli_query($con, $get_bank_details);
                                    $row_bank_details = mysqli_fetch_array($run_bank_details);

                                    $bank_name = $row_bank_details['bank_name'] ?? "N/A"; // Use fallback value if not set
                                    $account_number = $row_bank_details['account_number'] ?? "N/A";
                                    $account_holder_name = $row_bank_details['account_holder_name'] ?? "N/A";
                                    $ifsc_code = $row_bank_details['ifsc_code'] ?? "N/A";
                                    $upi_id = $row_bank_details['upi_id'] ?? "N/A";

                                    // Fetch product details
                                    $get_products = "SELECT * FROM products WHERE product_id='$product_id'";
                                    $run_products = mysqli_query($con, $get_products);
                                    $row_products = mysqli_fetch_array($run_products);
                                    $product_title = $row_products['product_title'];
                                    $product_price = $row_products['product_price'];

                                    // Fetch quantity, size from customer_order table using order_id
                                    $order_id = $row_orders['order_id'];
                                    $get_order_details = "SELECT qty, size FROM customer_order WHERE order_id='$order_id'";
                                    $run_order_details = mysqli_query($con, $get_order_details);
                                    $row_order_details = mysqli_fetch_array($run_order_details);
                                    $quantity = $row_order_details['qty'] ?? "N/A";
                                    $size = $row_order_details['size'] ?? "N/A";

                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php
                                            $get_customer = "SELECT cust_email FROM customers WHERE cust_id='$c_id'";
                                            $run_customer = mysqli_query($con, $get_customer);
                                            $row_customer = mysqli_fetch_array($run_customer);
                                            $customer_email = $row_customer['cust_email'] ?? "N/A";
                                            echo $customer_email;
                                            ?>
                                        </td>
                                        <td bgcolor="yellow"><?php echo $invoice_no; ?></td>
                                        <td><?php echo $product_title; ?></td>
                                        <td><?php echo $quantity; ?></td>
                                        <td><?php echo $size; ?></td>
                                        <td><?php echo $return_date; ?></td>
                                        <td><?php echo $product_price; ?></td>
                                        <td><?php echo $return_refund_reason; ?></td>
                                        <td><?php echo $shipping_contact; ?></td>
                                        <td><?php echo $ship_address; ?></td>
                                        <td><?php echo $bill_address; ?></td>

                                        <!-- Form for Transfer Method -->
                                        <td>
                                            <form action="" method="POST">
                                                <input type="hidden" name="return_refund_id_transfer"
                                                    value="<?php echo $return_refund_id; ?>">
                                                <select name="transfer_method" class="form-control"
                                                    style="min-width: 120px; max-width: 100%;">
                                                    <option value="bank_transfer" <?php echo ($transfer_method == 'bank_transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                                                    <option value="upi_id" <?php echo ($transfer_method == 'upi_id' ? 'selected' : ''); ?>>UPI ID</option>
                                                </select> <br>
                                                <button type="submit" class="btn btn-primary mt-2">Update Method</button>
                                            </form>
                                        </td>

                                        <!-- Bank/UPI Details -->
                                        <td>
                                            <?php
                                            if (!empty($transfer_method)) {
                                                if ($transfer_method == 'bank_transfer') {
                                                    echo "Bank: " . ($bank_name ?? "N/A") . "<br>";
                                                    echo "Account Holder Name: " . ($account_holder_name ?? "N/A") . "<br>";
                                                    echo "Account Number: " . ($account_number ?? "N/A") . "<br>";
                                                    echo "IFSC Code: " . ($ifsc_code ?? "N/A");
                                                } elseif ($transfer_method == 'upi_id') {
                                                    echo "UPI ID: " . ($upi_id ?? "N/A");
                                                } else {
                                                    echo "Invalid payment method.";
                                                }
                                            } else {
                                                echo "No payment method selected.";
                                            }
                                            ?>
                                        </td>

                                        <!-- Form for Return Status -->
                                        <td>
                                            <form action="" method="POST">
                                                <input type="hidden" name="return_refund_id_status"
                                                    value="<?php echo $return_refund_id; ?>">
                                                <select name="return_refund_status" class="form-control"
                                                    style="min-width: 120px; max-width: 100%;">
                                                    <option value="Approved" <?php if ($return_refund_status == 'Approved')
                                                        echo 'selected'; ?>>Approved</option>
                                                    <option value="Rejected" <?php if ($return_refund_status == 'Rejected')
                                                        echo 'selected'; ?>>Rejected</option>
                                                    <option value="Returned / Refunded" <?php if ($return_refund_status == 'Returned / Refunded')
                                                        echo 'selected'; ?>>
                                                        Returned / Refunded</option>
                                                    <option value="Requested" <?php if ($return_refund_status == 'Requested')
                                                        echo 'selected'; ?>>Requested</option>
                                                    <option value="none" <?php if ($return_refund_status == 'none')
                                                        echo 'selected'; ?>>None</option>
                                                </select> <br>
                                                <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                                            </form>
                                        </td>

                                        <td>
                                            <a href="index.php?delete_return_order=<?php echo $return_refund_id; ?>">
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