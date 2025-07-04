<?php
include("includes/db.php");

// Retrieve customer details based on the logged-in email
$customer_email = $_SESSION['cust_email'];
$get_customer = "SELECT * FROM customers WHERE cust_email='$customer_email'";
$run_cust = mysqli_query($con, $get_customer);

// Check if customer query was successful
if (!$run_cust) {
    die("Error fetching customer details: " . mysqli_error($con));
}

$row_cust = mysqli_fetch_array($run_cust);

$customer_id = $row_cust['cust_id'];

// Initialize message and alert type variables
$message = "";
$alert_type = ""; // For alert messages, 'success' for green, 'danger' for red

// Check if bank and UPI details already exist for the customer
$get_bank_details = "SELECT * FROM customer_bank_details WHERE cust_id='$customer_id'";
$run_bank_details = mysqli_query($con, $get_bank_details);

// Check if bank details query was successful
if (!$run_bank_details) {
    die("Error fetching bank details: " . mysqli_error($con));
}

$bank_details = mysqli_fetch_array($run_bank_details);

// Pre-fill form values with existing bank and UPI details if available
$bank_name = isset($bank_details['bank_name']) ? $bank_details['bank_name'] : '';
$account_holder_name = isset($bank_details['account_holder_name']) ? $bank_details['account_holder_name'] : '';
$account_number = isset($bank_details['account_number']) ? $bank_details['account_number'] : '';
$ifsc_code = isset($bank_details['ifsc_code']) ? $bank_details['ifsc_code'] : '';
$upi_id = isset($bank_details['upi_id']) ? $bank_details['upi_id'] : ''; // Assume `upi_id` column exists

// Process form submission for bank details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_bank_details'])) {
    // Sanitize and retrieve form inputs
    $bank_name = mysqli_real_escape_string($con, $_POST['bank_name']);
    $account_holder_name = mysqli_real_escape_string($con, $_POST['account_holder_name']);
    $account_number = mysqli_real_escape_string($con, $_POST['account_number']);
    $ifsc_code = mysqli_real_escape_string($con, $_POST['ifsc_code']);

    if ($bank_details) {
        // Update existing bank details
        $sql = "UPDATE customer_bank_details 
                SET bank_name='$bank_name', account_holder_name='$account_holder_name', 
                    account_number='$account_number', ifsc_code='$ifsc_code' 
                WHERE cust_id='$customer_id'";
        if (mysqli_query($con, $sql)) {
            $message = "Bank details updated successfully!";
            $alert_type = "success";
        } else {
            $message = "Error updating bank details: " . mysqli_error($con);
            $alert_type = "danger";
        }
    } else {
        // Insert new bank details
        $sql = "INSERT INTO customer_bank_details (cust_id, bank_name, account_holder_name, account_number, ifsc_code)
                VALUES ('$customer_id', '$bank_name', '$account_holder_name', '$account_number', '$ifsc_code')";
        if (mysqli_query($con, $sql)) {
            $message = "Bank details saved successfully!";
            $alert_type = "success";
        } else {
            $message = "Error saving bank details: " . mysqli_error($con);
            $alert_type = "danger";
        }
    }
}

// Process form submission for UPI ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_upi_id'])) {
    $upi_id = mysqli_real_escape_string($con, $_POST['upi_id']);

    if ($bank_details) {
        // Update existing UPI ID
        $sql = "UPDATE customer_bank_details 
                SET upi_id='$upi_id' 
                WHERE cust_id='$customer_id'";
        if (mysqli_query($con, $sql)) {
            $message = "UPI ID updated successfully!";
            $alert_type = "success";
        } else {
            $message = "Error updating UPI ID: " . mysqli_error($con);
            $alert_type = "danger";
        }
    } else {
        // Insert UPI ID along with customer ID
        $sql = "INSERT INTO customer_bank_details (cust_id, upi_id)
                VALUES ('$customer_id', '$upi_id')";
        if (mysqli_query($con, $sql)) {
            $message = "UPI ID saved successfully!";
            $alert_type = "success";
        } else {
            $message = "Error saving UPI ID: " . mysqli_error($con);
            $alert_type = "danger";
        }
    }
}
?>

<div class="box">
    <center>
        <!-- Display success or error message if available -->
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $alert_type; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </center>

    <!-- Bank details form -->
    <form action="" method="POST">
        <center>
            <h1>Your Bank Details</h1>
        </center>

        <div class="form-group">
            <label for="bank_name">Bank Name:</label>
            <input type="text" name="bank_name" class="form-control" value="<?php echo htmlspecialchars($bank_name); ?>"
                style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required>
        </div>

        <div class="form-group">
            <label for="account_holder_name">Account Holder Name:</label>
            <input type="text" name="account_holder_name" class="form-control"
                value="<?php echo htmlspecialchars($account_holder_name); ?>" style="text-transform: uppercase;"
                oninput="this.value = this.value.toUpperCase();" required>
        </div>

        <div class="form-group">
            <label for="account_number">Account Number:</label>
            <input type="text" name="account_number" class="form-control"
                value="<?php echo htmlspecialchars($account_number); ?>" pattern="\d{12}"
                title="Account number must be 12 digits." required>
        </div>

        <div class="form-group">
            <label for="ifsc_code">IFSC Code:</label>
            <input type="text" name="ifsc_code" class="form-control" value="<?php echo htmlspecialchars($ifsc_code); ?>"
                pattern="[A-Za-z]{4}\d{7}" title="IFSC code must be 4 letters followed by 7 digits."
                style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required>
        </div>

        <div class="text-center">
            <button class="btn btn-primary" type="submit" name="save_bank_details">
                <i class="fa fa-save"></i> Save Bank Details
            </button>
        </div>
    </form>

    <hr>

    <!-- UPI ID form -->
    <form action="" method="POST">
        <center>
            <h1>Your UPI ID</h1>
        </center>

        <div class="form-group">
            <label for="upi_id">UPI ID:</label>
            <input type="text" name="upi_id" class="form-control" value="<?php echo isset($upi_id) ? htmlspecialchars($upi_id) : ''; ?>" required>
            <small>UPI ID must contain '@' followed by unique identifier.</small>
        </div>

        <div class="text-center">
            <button class="btn btn-primary" type="submit" name="save_upi_id">
                <i class="fa fa-save"></i> Save UPI ID
            </button>
        </div>
    </form>

    <div class="box">
        <p><strong>Note: The bank account and UPI details provided here are used solely to facilitate and process your
                refund securely. By providing accurate banking information, we ensure that any refunds are deposited
                directly into your account without delays. Rest assured that your data is handled with the highest level
                of confidentiality and is stored securely to protect your financial privacy. This information will only
                be used for refund transactions and not for any other purposes.</strong></p>
    </div>
</div>
