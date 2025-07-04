<?php
include("includes/db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (!isset($_SESSION['cust_email'])) {
    echo "<script>window.open('customer_login.php', '_self')</script>";
    exit;
} else {
    // Retrieve invoice number from session
    $invoiceNo = isset($_SESSION['invoiceNo']) ? $_SESSION['invoiceNo'] : 'N/A';

    // Fetch customer details for email
    $cust_email = $_SESSION['cust_email'];
    $query = "SELECT cust_id, cust_name FROM customers WHERE cust_email = '$cust_email'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $cust_id = $row['cust_id'];
        $cust_name = $row['cust_name'];
    } else {
        $cust_id = '';
        $cust_name = 'Customer'; // Default if no data is found
    }

    // Fetch shipping address using $customer_id from customer_address table
    $ship_address_query = "SELECT * FROM customer_address WHERE cust_id = '$cust_id'";
    $ship_address_result = mysqli_query($con, $ship_address_query);
    $ship_address = '';
    if ($ship_address_result && mysqli_num_rows($ship_address_result) > 0) {
        $ship_address_row = mysqli_fetch_assoc($ship_address_result);
        $ship_address = $ship_address_row['cust_name'] . ', ' . $ship_address_row['house_no'] . ', '
            . $ship_address_row['street_name'] . ', ' . $ship_address_row['city'] . ', ' . $ship_address_row['district'] .
            ', ' . $ship_address_row['state'] . ', ' . $ship_address_row['country'] . ' - ' . $ship_address_row['pincode'];
        $ship_contact = $ship_address_row['cust_contact'];
    } else {
        $ship_address = 'Not available'; // Default address if not found
        $ship_contact = 'Not available';
    }

    // Fetch billing address using $customer_id from customer_address table
    $bill_address_query = "SELECT * FROM customer_billing_address WHERE cust_id = '$cust_id'";
    $bill_address_result = mysqli_query($con, $bill_address_query);
    $bill_address = '';
    if ($bill_address_result && mysqli_num_rows($bill_address_result) > 0) {
        $bill_address_row = mysqli_fetch_assoc($bill_address_result);
        $bill_address = $bill_address_row['cust_name'] . ', ' . $bill_address_row['house_no'] . ', '
            . $bill_address_row['street_name'] . ', ' . $bill_address_row['city'] . ', ' . $bill_address_row['district'] .
            ', ' . $bill_address_row['state'] . ', ' . $bill_address_row['country'] . ' - ' . $bill_address_row['pincode'];
        $bill_contact = $bill_address_row['cust_contact'];
    } else {
        $bill_address = 'Not available'; // Default address if not found
        $bill_contact = 'Not available';
    }

      // Fetch the latest `order_date` for the customer
      $order_date_query = "SELECT order_date FROM customer_order WHERE cust_id = '$cust_id' ORDER BY order_date DESC LIMIT 1";
      $order_date_result = mysqli_query($con, $order_date_query);
      $order_date = mysqli_fetch_assoc($order_date_result)['order_date'] ?? null;
  
      if ($order_date) {
          // Fetch all order items for the same `order_date`
          $select_order_items = "
              SELECT co.product_id, co.qty, co.size, co.order_date,co.payment_mode, co.exp_delivery_date, co.invoice_no, co.due_amount, p.product_title, p.product_img1
              FROM customer_order co
              JOIN products p ON co.product_id = p.product_id
              WHERE co.cust_id = '$cust_id' AND co.order_date = '$order_date'
          ";
          $run_order_items = mysqli_query($con, $select_order_items);

    $cart_items = '';
    while ($row_order_item = mysqli_fetch_array($run_order_items)) {
        $product_image = $row_order_item['product_img1'];
        $product_title = $row_order_item['product_title'];
        $due_amount = $row_order_item['due_amount'];
        $quantity = $row_order_item['qty'];
        $size = $row_order_item['size'];
        $invoice_no = $row_order_item['invoice_no'];
        $order_date = $row_order_item['order_date'];
        $payment_mode = $row_order_item['payment_mode'];
        $exp_delivery_date = $row_order_item['exp_delivery_date'];

        // Format the order date
        $formatted_order_date = date('d-m-Y H:i:s', strtotime($order_date));

        $cart_items .= "<tr>
         <td><img src='admin_area/product_images/$product_image' width='80' alt='img'></td>
                            <td>$product_title</td>
                            <td>$quantity</td>
                            <td>₹ $due_amount</td>
                            <td>$size</td>
                            <td>$invoice_no</td>
                        </tr>";
    }

    // Send confirmation email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'shreyakush8604@gmail.com';
        $mail->Password = 'glcy aviv bmnt kkfp'; // Use environment variables or a safer way for storing sensitive data
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('no-reply@clothify.com', 'Clothify');
        $mail->addAddress($cust_email, $cust_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Order Confirmation - Invoice #' . $invoiceNo;
        $mail->Body = '
            <h2>Order Confirmation</h2>
            <p>Dear ' . $cust_name . ',</p>
            <p>Thank you for your order! Your order has been successfully placed. Below are the details:</p>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                    <th>Image</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Size</th>
                        <th>Invoice No</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $cart_items . '
                </tbody>
            </table>
            <p><strong>Shipping Address:</strong> ' . $ship_address . '</p>
            <p><strong>Billing Address:</strong> ' . $bill_address . '</p>
            <p><strong>Mobile Number:</strong> ' . $ship_contact . '</p>
            <p><strong>Order Date:</strong> ' . $formatted_order_date . '</p>
            <p><strong>Expected Delivery Date:</strong> ' . $exp_delivery_date . '</p>
            <p><strong>Payment Mode:</strong> '.$payment_mode.' </p>
            <p>We will notify you once your order is shipped. Thank you for shopping with us!</p>
            <p>Best Regards,<br>Clothify Store Team</p>
        ';

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
}
?>