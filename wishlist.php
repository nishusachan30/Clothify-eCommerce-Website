<?php
/**
 * This script manages the wishlist functionality for an eCommerce website.
 * 
 * Features:
 * - Allows logged-in users to add products to their wishlist.
 * - Enables users to remove products from their wishlist.
 * - Displays the wishlist with product details such as:
 *   - Product title, price, and discount.
 *   - Stock availability status.
 * - Provides navigation to product details and wishlist management options.
 * 
 * Dependencies:
 * - Database connection: Includes necessary files to connect to the database.
 * - Functions: Utilizes helper functions for additional calculations (e.g., discounts).
 * - Main layout components: Includes header, footer, and navigation elements.
 * 
 * User Experience:
 * - Ensures only logged-in users can manage their wishlist.
 * - Displays success or error messages in a user-friendly format.
 * - Automatically redirects users to appropriate pages if actions are restricted.
 */

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
include("includes/db.php");
include("functions/functions.php");
include("includes/main.php");
include("includes/header.php");

// Check if user is logged in
if (isset($_SESSION['cust_email'])) {
    $cust_email = $_SESSION['cust_email'];

    // Fetch customer ID from the database
    $get_cust_id = "SELECT cust_id FROM customers WHERE cust_email = '$cust_email'";
    $run_cust_id = mysqli_query($con, $get_cust_id);

    if ($run_cust_id) {
        if ($row = mysqli_fetch_array($run_cust_id)) {
            $cust_id = $row['cust_id'];

            // Handle adding product to wishlist
            if (isset($_GET['add_wishlist'])) {
                try {
                    $product_id = intval($_GET['add_wishlist']);
                    $check_wishlist = "SELECT * FROM wishlist WHERE cust_id = '$cust_id' AND product_id = '$product_id'";
                    $run_check_wishlist = mysqli_query($con, $check_wishlist);

                    if ($run_check_wishlist) {
                        if (mysqli_num_rows($run_check_wishlist) == 0) {
                            $add_wishlist = "INSERT INTO wishlist (cust_id, product_id) VALUES ('$cust_id', '$product_id')";
                            $insert_result = mysqli_query($con, $add_wishlist);

                            if ($insert_result) {
                                $message = "Product has been added to your wishlist!";
                            } else {
                                throw new Exception("Failed to add product to wishlist. Please try again later.");
                            }
                        } else {
                            $message = "Product is already in your wishlist.";
                        }
                    } else {
                        throw new Exception("Failed to check if product is in wishlist. Please try again later.");
                    }
                } catch (Exception $e) {
                    $message = "Error: " . $e->getMessage();
                }
            }

            // Handle removing product from wishlist
            if (isset($_GET['remove'])) {
                try {
                    $product_id = intval($_GET['remove']);
                    $remove_wishlist = "DELETE FROM wishlist WHERE cust_id = '$cust_id' AND product_id = '$product_id'";
                    $delete_result = mysqli_query($con, $remove_wishlist);

                    if ($delete_result) {
                        $message = "Product has been removed from your wishlist!";
                        echo "<script>window.open('wishlist.php', '_self');</script>";
                    } else {
                        throw new Exception("Failed to remove product from wishlist. Please try again later.");
                    }
                } catch (Exception $e) {
                    $message = "Error: " . $e->getMessage();
                }
            }
        } else {
            // Redirect if user not found in the database
            echo "<script>alert('User not found. Please log in.');</script>";
            echo "<script>window.open('customer_login.php', '_self');</script>";
        }
    } else {
        // Error when fetching user data from the database
        $message = "Error fetching customer information. Please try again later.";
    }
} else {
    // Redirect non-logged-in users to login page
    echo "<script>alert('Please log in to add items to your wishlist.');</script>";
    echo "<script>window.open('customer_login.php', '_self');</script>";
}

?>

<div id="content"><!--content start-->
    <div class="container"><!--container start-->
        <div class="col-md-12"><!--col-md-12 start-->
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Wishlist</li>
            </ul>
        </div><!--col-md-12 end-->

        <div class="col-md-12"><!--col-md-9 start-->
            <div class="breadcrumb">
                <h1>Your Wishlist</h1>
                <p>Here you can view the products you have added to your wishlist.</p>
                <?php if (isset($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
            </div>

            <div class="row"><!--row start-->
                <?php
                // Fetch products from wishlist
                $get_wishlist = "SELECT * FROM wishlist WHERE cust_id = '$cust_id'";
                $run_wishlist = mysqli_query($con, $get_wishlist);

                if ($run_wishlist) {
                    while ($row = mysqli_fetch_array($run_wishlist)) {
                        $product_id = $row['product_id'];
                        $get_product = "SELECT * FROM products WHERE product_id = '$product_id'";
                        $run_product = mysqli_query($con, $get_product);

                        if ($run_product && $product_row = mysqli_fetch_array($run_product)) {
                            $pro_id = $product_row['product_id'];
                            $pro_title = $product_row['product_title'];
                            $pro_price = $product_row['product_price'];
                            $pro_img1 = $product_row['product_img1'];
                            $pro_mrp = $product_row['mrp'];
                            $product_availability = $product_row['product_availability'];

                            $discount = calculateDiscount1($pro_mrp, $pro_price);

                            echo "
                            <div class='col-md-3 col-sm-6 center responsive'>
                            <div class='breadcrumb'>
                                <div class='product'>
                                    <a href='product-details.php?pro_id=$pro_id'>
                                        <img src='admin_area/product_images/$pro_img1' class='img-responsive' alt='product'>
                                    </a>
                                    <div class='text'>
                                        <h3><a href='product-details.php?pro_id=$pro_id'>$pro_title</a></h3>
                                        <p class='price'>
                                            ₹$pro_price 
                                            <span style='font-size:14px; text-decoration:line-through;'>₹$pro_mrp</span>";

                            if ($discount > 0) {
                                echo "<span class='discount'> ({$discount}% OFF)</span>";
                            }

                            // Show availability status
                            if ($product_availability > 0) {
                                echo "<p style='text-align: center; color: green; font-weight: bold; margin-top: 10px;'>In Stock</p>";
                            } else {
                                echo "<p style='text-align: center; color: red; font-weight: bold; margin-top: 10px;'>Sorry, this product is out of stock.</p>";
                            }

                            echo "</p>
                                        <p class='buttons'>
                                            <a href='product-details.php?pro_id=$pro_id' class='btn btn-default'>View Details</a>
                                            <a href='wishlist.php?remove=$pro_id' class='btn btn-danger'>
                                                <i class='fa-solid fa-trash'></i> Remove
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                </div>
                            </div>";
                        }
                    }
                } else {
                    $message = "Error fetching wishlist products. Please try again later.";
                }
                ?>
            </div><!--row end -->
        </div><!--col-md-9 end-->
    </div><!--container end-->
</div><!--content end-->

<!--footer include-->
<?php include("includes/footer.php"); ?>
