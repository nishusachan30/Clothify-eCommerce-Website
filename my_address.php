<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("includes/db.php");

// Check if customer email is set in session
if (!isset($_SESSION['cust_email'])) {
    echo "<script>alert('Please log in first.');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

// Assuming cust_email is obtained from session
$cust_email = $_SESSION['cust_email'];
$get_customer = "SELECT * FROM customers WHERE cust_email = '$cust_email'";
$run_cust = mysqli_query($con, $get_customer);

if (!$run_cust) {
    die("Error fetching customer data: " . mysqli_error($con));
}

if (mysqli_num_rows($run_cust) > 0) {
    $row_cust = mysqli_fetch_array($run_cust);
    $customer_id = $row_cust['cust_id'];
} else {
    echo "<script>alert('Customer not found.');</script>";
    exit();
}

// Fetch shipping address
$get_shipping_address = "SELECT * FROM customer_address WHERE cust_id = '$customer_id'";
$run_shipping_address = mysqli_query($con, $get_shipping_address);
$shipping_address = mysqli_fetch_array($run_shipping_address);

// Fetch billing address
$get_billing_address = "SELECT * FROM customer_billing_address WHERE cust_id = '$customer_id'";
$run_billing_address = mysqli_query($con, $get_billing_address);
$billing_address = mysqli_fetch_array($run_billing_address);
?>


<div class="box">
    <center>
        <h1>My Address</h1>
    </center>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="cust_id" value="<?php echo $customer_id; ?>">

        <!-- Shipping Address Section -->
        <div class="col-md-6 col-sm-6">
            <h4>Shipping Address</h4>
            <div class="form-group">
                <label>Full Name <span style="color: red;">*</span></label>
                <input type="text" name="ship_cust_name"
                    value="<?php echo htmlspecialchars($shipping_address['cust_name'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>House No</label>
                <input type="text" name="ship_house_no"
                    value="<?php echo htmlspecialchars($shipping_address['house_no'] ?? ''); ?>" class="form-control"
                    style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>Street Name <span style="color: red;">*</span></label>
                <input type="text" name="ship_street_name"
                    value="<?php echo htmlspecialchars($shipping_address['street_name'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>Landmark</label>
                <input type="text" name="ship_landmark"
                    value="<?php echo htmlspecialchars($shipping_address['landmark'] ?? ''); ?>" class="form-control"
                    style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>City <span style="color: red;">*</span></label>
                <input type="text" name="ship_city"
                    value="<?php echo htmlspecialchars($shipping_address['city'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>District <span style="color: red;">*</span></label>
                <input type="text" name="ship_district"
                    value="<?php echo htmlspecialchars($shipping_address['district'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>State <span style="color: red;">*</span></label>
                <input type="text" name="ship_state"
                    value="<?php echo htmlspecialchars($shipping_address['state'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>Pincode <span style="color: red;">*</span></label>
                <input type="text" name="ship_pincode"
                    value="<?php echo htmlspecialchars($shipping_address['pincode'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>Country <span style="color: red;">*</span></label>
                <select name="ship_country" class="form-control" required>
                    <option value="INDIA" selected>INDIA</option>
                </select>
            </div>
            <div class="form-group">
                <label>Mobile <span style="color: red;">*</span></label>
                <input type="text" name="ship_contact"
                    value="<?php echo htmlspecialchars($shipping_address['cust_contact'] ?? ''); ?>"
                    class="form-control" required style="text-transform: uppercase;"
                    oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="text-center">
                <button class="btn btn-success" type="submit" name="update_shipping">
                    <i class="fa fa-refresh"></i> Update Shipping Address
                </button>
            </div>
        </div>
    </form>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="cust_id" value="<?php echo $customer_id; ?>">

        <!-- Billing Address Section with "Same as Shipping" Checkbox -->
        <div class="col-md-6 col-sm-6">
            <h4>Billing Address</h4>
            <div class="form-group">
                <label>Full Name <span style="color: red;">*</span></label>
                <input type="text" name="bill_cust_name" id="bill_cust_name"
                    value="<?php echo htmlspecialchars($billing_address['cust_name'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>House No</label>
                <input type="text" name="bill_house_no" id="bill_house_no"
                    value="<?php echo htmlspecialchars($billing_address['house_no'] ?? ''); ?>" class="form-control"
                    style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>Street Name <span style="color: red;">*</span></label>
                <input type="text" name="bill_street_name" id="bill_street_name"
                    value="<?php echo htmlspecialchars($billing_address['street_name'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>Landmark</label>
                <input type="text" name="bill_landmark"
                    value="<?php echo htmlspecialchars($billing_address['landmark'] ?? ''); ?>" class="form-control"
                    style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>City <span style="color: red;">*</span></label>
                <input type="text" name="bill_city" id="bill_city"
                    value="<?php echo htmlspecialchars($billing_address['city'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>District <span style="color: red;">*</span></label>
                <input type="text" name="bill_district" id="bill_district"
                    value="<?php echo htmlspecialchars($billing_address['district'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>State <span style="color: red;">*</span></label>
                <input type="text" name="bill_state" id="bill_state"
                    value="<?php echo htmlspecialchars($billing_address['state'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>Pincode <span style="color: red;">*</span></label>
                <input type="text" name="bill_pincode" id="bill_pincode"
                    value="<?php echo htmlspecialchars($billing_address['pincode'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label>Country <span style="color: red;">*</span></label>
                <select name="bill_country" class="form-control" required>
                    <option value="INDIA" selected>INDIA</option>
                </select>
            </div>
            <div class="form-group">
                <label>Mobile <span style="color: red;">*</span></label>
                <input type="text" name="bill_contact" id="bill_contact"
                    value="<?php echo htmlspecialchars($billing_address['cust_contact'] ?? ''); ?>" class="form-control"
                    required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-success" type="submit" name="update_billing">
                <i class="fa fa-refresh"></i> Update Billing Address
            </button>
        </div>
    </form>
</div>
</div>

<?php
if (isset($_POST['update_shipping'])) {
    $cust_id = $_POST['cust_id'];
    $ship_cust_name = $_POST['ship_cust_name'];
    $ship_house_no = $_POST['ship_house_no'];
    $ship_street_name = $_POST['ship_street_name'];
    $ship_landmark = $_POST['ship_landmark'];
    $ship_city = $_POST['ship_city'];
    $ship_district = $_POST['ship_district'];
    $ship_state = $_POST['ship_state'];
    $ship_pincode = $_POST['ship_pincode'];
    $ship_country = $_POST['ship_country'];
    $ship_contact = $_POST['ship_contact'];


    if ($shipping_address) {
        // Update existing shipping address
        $update_shipping = "UPDATE customer_address SET 
            cust_name = '$ship_cust_name',
            house_no = '$ship_house_no',
            street_name = '$ship_street_name',
            landmark = '$ship_landmark',
            city = '$ship_city',
            district = '$ship_district',
            state = '$ship_state',
            pincode = '$ship_pincode',
            country = '$ship_country',
            cust_contact = '$ship_contact'
            WHERE cust_id = '$cust_id'";


        $run_update_shipping = mysqli_query($con, $update_shipping);
        if ($run_update_shipping) {
            echo "<script>alert('Shipping address updated successfully!');</script>";
            echo "<script>window.open('account.php?my_address', '_self')</script>";
        } else {
            echo "<script>alert('Error updating shipping address.');</script>";
        }
    } else {
        // Insert new shipping address
        $insert_shipping = "INSERT INTO customer_address (cust_id, cust_name, house_no, street_name, landmark, city, district, state, pincode, country, cust_contact) VALUES 
            ('$cust_id', '$ship_cust_name', '$ship_house_no', '$ship_street_name', '$ship_landmark', '$ship_city', '$ship_district', '$ship_state', '$ship_pincode', '$ship_country','$ship_contact')";

        $run_insert_shipping = mysqli_query($con, $insert_shipping);
        if ($run_insert_shipping) {
            echo "<script>alert('Shipping address added successfully!');</script>";
            echo "<script>window.open('account.php?my_address', '_self')</script>";
        } else {
            echo "<script>alert('Error adding shipping address.');</script>";
        }
    }
}


if (isset($_POST['update_billing'])) {
    $cust_id = $_POST['cust_id'];
    $bill_cust_name = $_POST['bill_cust_name'];
    $bill_house_no = $_POST['bill_house_no'];
    $bill_street_name = $_POST['bill_street_name'];
    $bill_landmark = $_POST['bill_landmark'];
    $bill_city = $_POST['bill_city'];
    $bill_district = $_POST['bill_district'];
    $bill_state = $_POST['bill_state'];
    $bill_pincode = $_POST['bill_pincode'];
    $bill_country = $_POST['bill_country'];
    $bill_contact = $_POST['bill_contact'];

    $run_update_billing = false;
    $run_insert_billing = false;

    // Check if billing address exists and perform update or insert for billing
    if ($billing_address) {
        $update_billing = "UPDATE customer_billing_address SET 
            cust_name = '$bill_cust_name',
            house_no = '$bill_house_no',
            street_name = '$bill_street_name',
            landmark = '$bill_landmark',
            city = '$bill_city',
            district = '$bill_district',
            state = '$bill_state',
            pincode = '$bill_pincode',
            country = '$bill_country',
            cust_contact = '$bill_contact'
            WHERE cust_id = '$cust_id'";

        $run_update_billing = mysqli_query($con, $update_billing);
    } else {
        $insert_billing = "INSERT INTO customer_billing_address (cust_id, cust_name, house_no, street_name, landmark, city, district, state, pincode, country, cust_contact) VALUES 
            ('$cust_id', '$bill_cust_name', '$bill_house_no', '$bill_street_name', '$bill_landmark', '$bill_city', '$bill_district', '$bill_state', '$bill_pincode', '$bill_country', '$bill_contact')";

        $run_insert_billing = mysqli_query($con, $insert_billing);
    }

    if ($run_update_billing) {
        echo "<script>alert('Billing address updated successfully!');</script>";
        echo "<script>window.open('account.php?my_address', '_self')</script>";
    } else {
        echo "<script>alert('Error updating billing address.');</script>";
    }
}

?>