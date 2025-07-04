<?php
if (!isset($_SESSION['cust_email'])) {
    echo "<script>alert('You need to log in first.');</script>";
    echo "<script>window.open('customer_login.php', '_self');</script>";
    exit;
}

$cust_email = $_SESSION['cust_email'];

// Sanitize the customer email to prevent SQL injection
$cust_email = mysqli_real_escape_string($con, $cust_email);

// Fetch customer ID based on email
$query = "SELECT cust_id FROM customers WHERE cust_email = '$cust_email'";
$result = mysqli_query($con, $query);

// Check if query was successful
if (!$result) {
    echo "<script>alert('Error fetching customer details. Please try again later.');</script>";
    exit;
}

$customer = mysqli_fetch_assoc($result);

// Check if customer exists
if (!$customer) {
    echo "<script>alert('Customer not found. Please log in again.');</script>";
    echo "<script>window.open('customer_login.php', '_self');</script>";
    exit;
}

$cust_id = $customer['cust_id'];

// Fetch refund details along with transaction ID from payments table using invoice_no
$refunds_query = "
    SELECT 
        rr.return_refund_id AS ref_no,
        p.product_title,
        co.qty,
        co.size,
        rr.refund_amount AS amount,
        co.invoice_no,
        rr.processed_at AS date,
        rr.refunded_to,
        rr.transaction_id  -- Fetch the transaction ID here from the payments table
    FROM 
        return_refund rr
    JOIN customer_order co ON rr.order_id = co.order_id
    JOIN products p ON co.product_id = p.product_id
    LEFT JOIN payments pay ON co.invoice_no = pay.invoice_no  -- Join with payments table using invoice_no
    WHERE 
        rr.cust_id = '$cust_id' AND 
        rr.return_refund_status = 'Returned / Refunded'
    ORDER BY rr.requested_at DESC";

// Run the refunds query
$refunds_result = mysqli_query($con, $refunds_query);

// Check if the query was successful
if (!$refunds_result) {
    echo "<script>alert('Error fetching refund details. Please try again later.');</script>";
    exit;
}

?>

<div class="box"> <!--box starts -->
    <h1>Your Refunds</h1>
    <h4><strong>"All refunds will be processed based on the original price of the product only; shipping charges and taxes are non-refundable."</strong></h4>
    <p><a href="terms.php#link-2">see more</a></p>
    <hr>
    <div class="table-responsive"> <!--table-responsive starts -->
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Invoice No</th>
                    <th>Transaction ID</th> <!-- Updated column header -->
                    <th>Processed At</th>
                    <th>Refunded To</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial_no = 1;
                if (mysqli_num_rows($refunds_result) > 0) {
                    while ($refund = mysqli_fetch_assoc($refunds_result)) {
                        echo "<tr>";
                        echo "<td>" . $serial_no++ . "</td>";
                        echo "<td>" . htmlspecialchars($refund['product_title']) . "</td>";
                        echo "<td>" . htmlspecialchars($refund['qty']) . "</td>";
                        echo "<td>₹" . htmlspecialchars($refund['amount']) . "</td>";
                        echo "<td>" . htmlspecialchars($refund['invoice_no']) . "</td>";
                        echo "<td>" . htmlspecialchars($refund['transaction_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($refund['date']) . "</td>";
                        echo "<td>" . htmlspecialchars($refund['refunded_to']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No refunds available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div> <!--table-responsive ends -->
</div> <!--box ends -->
