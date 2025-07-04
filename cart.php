<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("includes/db.php");
include("functions/functions.php");
include("includes/main.php");
include("includes/header.php");

addCart();

$ip_add = getUserIP();
$cust_id = isset($_SESSION['cust_id']) ? $_SESSION['cust_id'] : '';
$select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add' OR cust_id='$cust_id'";

// Handle possible errors in the query
$run_cart = mysqli_query($db, $select_cart);
if (!$run_cart) {
    echo "<script>alert('Error fetching cart items: " . mysqli_error($db) . "');</script>";
    exit;
}

$count = mysqli_num_rows($run_cart); // Count items in the cart

if (isset($_POST['update'])) {
    $ip_add = getUserIP();
    $cust_id = isset($_SESSION['cust_id']) ? $_SESSION['cust_id'] : '';

    if (isset($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $key => $value) {
            $pro_id = $key;
            $new_qty = $value;
            $new_size = isset($_POST['size'][$key]) ? $_POST['size'][$key] : 'S';

            $update_cart = "UPDATE cart SET qty='$new_qty', size='$new_size' 
                            WHERE (ip_add='$ip_add' OR cust_id='$cust_id') AND p_id='$pro_id'";

            $update_result = mysqli_query($db, $update_cart);
            if (!$update_result) {
                echo "<script>alert('Error updating cart for product ID $pro_id: " . mysqli_error($db) . "');</script>";
                exit;
            }
        }
    }
}

?>

<div id="content"> <!--content starts-->
    <div class="container"> <!--container starts-->
        <div class="col-md-12"> <!--col-md-12 starts-->
            <ul class="breadcrumb">
                <li><a href="home.php">Home</a></li>
                <li>Cart</li>
            </ul>
        </div> <!--col-md-12 ends-->

        <div class="col-md-12" id="cart"> <!--col-md-12 starts-->
            <div class="breadcrumb"> <!--breadcrumb starts-->
                <form action="cart.php" method="post" enctype="multipart/form-data">
                    <h1>Shopping Cart</h1>
                    <?php
                    $select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add' OR cust_id='$cust_id'";
                    $run_cart = mysqli_query($db, $select_cart);
                    if (!$run_cart) {
                        echo "<script>alert('Error fetching cart items: " . mysqli_error($db) . "');</script>";
                        exit;
                    }
                    $count = mysqli_num_rows($run_cart);
                    ?>
                    <p class="text-muted">You have <?php echo $count; ?> item(s) in your cart.</p>

                    <?php
                    $low_stock_message_displayed = false;
                    while ($row_cart = mysqli_fetch_array($run_cart)) {
                        $pro_id = $row_cart['p_id'];
                        $get_product = "SELECT product_availability FROM products WHERE product_id='$pro_id'";
                        $run_pro = mysqli_query($db, $get_product);
                        if (!$run_pro) {
                            echo "<script>alert('Error fetching product availability: " . mysqli_error($db) . "');</script>";
                            exit;
                        }
                        $row_pro = mysqli_fetch_array($run_pro);

                        if ($row_pro['product_availability'] < 10 && !$low_stock_message_displayed) {
                            echo '<p style="color: orange; font-weight: bold; text-align: center;">Stock is emptying fast!</p>';
                            $low_stock_message_displayed = true;
                        }
                    }

                    $run_cart = mysqli_query($db, $select_cart);
                    ?>

                    <div class="table-responsive"> <!--table-responsive starts-->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Size</th>
                                    <th>Delete</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                while ($row = mysqli_fetch_array($run_cart)) {
                                    $pro_id = $row['p_id'];
                                    $pro_size = $row['size'];
                                    $pro_qty = $row['qty'];

                                    $get_product = "SELECT * FROM products WHERE product_id='$pro_id'";
                                    $run_pro = mysqli_query($db, $get_product);
                                    if (!$run_pro) {
                                        echo "<script>alert('Error fetching product details: " . mysqli_error($db) . "');</script>";
                                        exit;
                                    }

                                    while ($row_pro = mysqli_fetch_array($run_pro)) {
                                        $p_title = $row_pro['product_title'];
                                        $p_img1 = $row_pro['product_img1'];
                                        $p_price = $row_pro['product_price'];
                                        $sub_total = $p_price * $pro_qty;
                                        $total += $sub_total;
                                        ?>
                                        <tr>
                                            <td><img src="admin_area/product_images/<?php echo $p_img1; ?>" alt=""></td>
                                            <td><?php echo $p_title; ?></td>
                                            <td><input type="number" name="qty[<?php echo $pro_id; ?>]"
                                                    value="<?php echo $pro_qty; ?>" min="1" style="width: 60px;"></td>
                                            <td>₹ <?php echo $p_price; ?></td>
                                            <td>
                                                <select name="size[<?php echo $pro_id; ?>]">
                                                    <option value="S" <?php echo ($pro_size == "S") ? "selected" : ""; ?>>S
                                                    </option>
                                                    <option value="M" <?php echo ($pro_size == "M") ? "selected" : ""; ?>>M
                                                    </option>
                                                    <option value="L" <?php echo ($pro_size == "L") ? "selected" : ""; ?>>L
                                                    </option>
                                                    <option value="XL" <?php echo ($pro_size == "XL") ? "selected" : ""; ?>>XL
                                                    </option>
                                                    <option value="XXL" <?php echo ($pro_size == "XXL") ? "selected" : ""; ?>>XXL
                                                    </option>
                                                </select>
                                            </td>
                                            <td><input type="checkbox" name="remove[]" value="<?php echo $pro_id; ?>"></td>
                                            <td>₹ <?php echo $sub_total; ?></td>
                                        </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div> <!--table-responsive ends-->

                    <div class="breadcrumb-footer">
                        <div class="pull-left">
                            <h4>Total Price</h4>
                        </div>
                        <div class="pull-right">
                            <h4>₹ <?php echo $total; ?></h4>
                        </div>
                    </div>

                    <div class="breadcrumb-footer">
                        <div class="pull-left">
                            <a href="shop.php" class="btn btn-default">
                                <i class="fa fa-chevron-left"></i> Continue Shopping
                            </a>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-default" type="submit" name="update" value="Update Cart">
                                <i class="fa fa-refresh"></i> Update Cart
                            </button>
                        </div>
                        <div id="checkout-progress" style="display: none; margin-top: 20px;">
                            <!--checkout-progress starts-->
                            <div class="progress">
                                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 0%;"></div>
                                <span id="progress-label">Starting...</span>
                            </div>
                        </div><!--checkout-progress ends-->
                    </div>

                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <div class="text-right">
                                    <a href="<?php echo ($count > 0) ? 'pay.php' : '#'; ?>" id="proceed-checkout-btn"
                                        class="btn btn-primary" <?php echo ($count == 0) ? 'onclick="alert(\'Your cart is empty. Add items to proceed.\'); return false;"' : ''; ?>>
                                        Proceed to Checkout <i class="fa fa-chevron-right"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </form>
            </div> <!--breadcrumb ends-->
            <?php update_cart(); ?>
        </div> <!--col-md-12 starts-->

        <div class="col-md-12 col-sm-12"> <!-- col-md-12 start-->
            <div id="row" class="breadcrumb"><!-- row Starts -->
                <h3 class="text-center">You may also like these Products</h3>
            </div> <!--row ends-->
            <?php getSuggestion(); ?>
        </div><!-- col-md-12 ends-->
    </div><!--container ends-->
</div><!--content ends-->

<!-- Script to show process to redirecting checkout -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkoutBtn = document.getElementById("proceed-checkout-btn");
        const progressBar = document.getElementById("progress-bar");
        const progressLabel = document.getElementById("progress-label");
        const progressContainer = document.getElementById("checkout-progress");

        checkoutBtn.addEventListener("click", function (e) {
            // Prevent default navigation initially
            e.preventDefault();

            // Show the progress bar
            progressContainer.style.display = "block";

            let progress = 0;
            let stages = [
                "Fetching customer details...",
                "Loading cart items...",
                "Applying discounts...",
                "Calculating taxes...",
                "Preparing checkout..."
            ];

            // Increment progress and update stages
            const progressInterval = setInterval(() => {
                progress += 20;
                progressBar.style.width = `${progress}%`;

                // Update progress label based on stage
                const stageIndex = progress / 20 - 1;
                if (stages[stageIndex]) {
                    progressLabel.textContent = stages[stageIndex];
                }

                if (progress === 100) {
                    clearInterval(progressInterval);
                    progressLabel.textContent = "Redirecting to Checkout...";

                    // After completion, redirect to the checkout page
                    setTimeout(() => {
                        window.location.href = checkoutBtn.href;
                    }, 1000); // 1-second delay for better UX
                }
            }, 1000); // Update every 1 second
        });
    });
</script>

<!-- include footer -->
<?php include("includes/footer.php"); ?>