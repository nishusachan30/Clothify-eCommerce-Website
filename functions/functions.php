<?php
$db = mysqli_connect("localhost", "root", "", "clothify");

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

//for getting user IP start
function getUserIP()
{
    switch (true) {
        case (!empty($_SERVER['HTTP_X_REAL_IP'])):
            return $_SERVER['HTTP_X_REAL_IP'];
        case (!empty($_SERVER['HTTP_CLIENT_IP'])):
            return $_SERVER['HTTP_CLIENT_IP'];
        case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        default:
            return $_SERVER['REMOTE_ADDR'];

    }
}

// Add to Cart Start
function addCart()
{
    global $db;

    if (isset($_GET['add_cart'])) {
        $ip_add = getUserIP();
        $p_id = $_GET['add_cart'];

        // Initialize variables for quantity, size, and color
        $product_qty = isset($_POST['product_qty']) ? $_POST['product_qty'] : 1; // Default to 1 if not set
        $product_size = isset($_POST['product_size']) ? $_POST['product_size'] : '';
        $product_color = isset($_POST['product_color']) ? $_POST['product_color'] : '';

        // Check product availability
        $availability_query = "SELECT product_availability FROM products WHERE product_id='$p_id'";
        $availability_result = mysqli_query($db, $availability_query);
        $product_data = mysqli_fetch_assoc($availability_result);

        if ($product_data && $product_data['product_availability'] > 0) {
            // Check if the customer is logged in
            if (isset($_SESSION['cust_id'])) {
                // Use cust_id as the identifier when the user is logged in
                $cust_id = $_SESSION['cust_id'];
                $check_product = "SELECT * FROM cart WHERE cust_id='$cust_id' AND p_id='$p_id'";
            } else {
                // Use IP address for guests
                $check_product = "SELECT * FROM cart WHERE ip_add='$ip_add' AND p_id='$p_id'";
            }

            $run_check = mysqli_query($db, $check_product);

            if (mysqli_num_rows($run_check) > 0) {
                echo "<script>alert('This product is already added to your cart');</script>";
                echo "<script>window.open('product-details.php?pro_id=$p_id', '_self');</script>";
            } else {
                // Decrease product availability by 1
                $update_availability_query = "UPDATE products SET product_availability = product_availability - 1 WHERE product_id='$p_id'";
                mysqli_query($db, $update_availability_query);

                if (isset($_SESSION['cust_id'])) {
                    // Insert product to the logged-in user's cart using cust_id
                    $query = "INSERT INTO cart (p_id, cust_id, qty, size, color) 
                              VALUES ('$p_id', '$cust_id', '$product_qty', '$product_size', '$product_color')";
                } else {
                    // Insert product to the guest's cart using IP address
                    $query = "INSERT INTO cart (p_id, ip_add, qty, size, color) 
                              VALUES ('$p_id', '$ip_add', '$product_qty', '$product_size', '$product_color')";
                }

                // Execute the query
                if (mysqli_query($db, $query)) {
                    // Show alert for successful addition to cart
                    echo "<script>alert('Product added to cart successfully!');</script>";
                } else {
                    // Optionally handle insertion error
                    echo "<script>alert('Error adding product to cart: " . mysqli_error($db) . "');</script>";
                }

                // Redirect to the product details page
                echo "<script>window.open('product-details.php?pro_id=$p_id', '_self');</script>";
            }
        } else {
            // Product is out of stock
            echo "<script>alert('Sorry, this product is out of stock.');</script>";
            echo "<script>window.open('product-details.php?pro_id=$p_id', '_self');</script>";
        }
    }
}

//Calculate Discount Start
function calculateDiscount1($p_mrp, $p_price)
{
    if ($p_mrp > $p_price) {
        $discount = (($p_mrp - $p_price) / $p_mrp) * 100;
        return round($discount, 0); // Rounded to 2 decimal places
    }
    return 0; // No discount if MRP <= price
}

//Calculate Discount End
function calculateDiscount($pro_mrp, $pro_price)
{
    if ($pro_mrp > $pro_price) {
        $discount = (($pro_mrp - $pro_price) / $pro_mrp) * 100;
        return round($discount, 0); // Rounded to 2 decimal places
    }
    return 0; // No discount if MRP <= price
}

// Transfer Cart to User on Login start
function transferCartToUser($cust_id)
{
    global $db;
    $ip_add = getUserIP();

    // Update the cart from IP-based to cust_id-based
    $query = "UPDATE cart SET cust_id='$cust_id', ip_add=NULL WHERE ip_add='$ip_add'";
    mysqli_query($db, $query);

    // Optional: Remove duplicate cart items
    $delete_duplicates = "DELETE c1 FROM cart c1 
                          INNER JOIN cart c2 ON c1.p_id = c2.p_id AND c1.cust_id = c2.cust_id 
                          WHERE c1.ip_add IS NULL";
    mysqli_query($db, $delete_duplicates);
}


// Clear cart on logout start
function clearCartOnLogout()
{
    global $db;

    if (isset($_SESSION['cust_id'])) {
        $cust_id = $_SESSION['cust_id'];
        $query = "DELETE FROM cart WHERE cust_id='$cust_id'";
        mysqli_query($db, $query);
    }
}


// Update cart for removing items start
function update_cart()
{
    global $db;

    if (isset($_POST['update'])) {
        // Loop through selected items to remove
        if (isset($_POST['remove'])) {
            foreach ($_POST['remove'] as $remove_id) {
                $delete_product = "DELETE FROM cart WHERE p_id='$remove_id'";
                mysqli_query($db, $delete_product);
            }

            // After removing the item, refresh the cart page to reflect changes
            echo "<script>alert('Cart has been updated')</script>";
            echo "<script>window.open('cart.php','_self')</script>";
        }
    }
}

//items count start
function item()
{
    global $db;
    $ip_add = getUserIp();
    $get_items = "select * from cart where ip_add='$ip_add'";
    $run_item = mysqli_query($db, $get_items);
    $count = mysqli_num_rows($run_item);
    echo $count;
}

//total price start
function totalPrice()
{
    global $db;
    $ip_add = getUserIp();
    $total = 0;
    $select_cat = "select * from cart where ip_add='$ip_add'";
    $run_cart = mysqli_query($db, $select_cat);

    while ($record = mysqli_fetch_array($run_cart)) {
        $pro_id = $record['p_id'];
        $pro_qty = $record['qty'];
        $get_price = "select * from products where product_id='$pro_id'";
        $run_price = mysqli_query($db, $get_price);

        while ($row = mysqli_fetch_array($run_price)) {
            $item_price = $row['product_price'];
            $tax = $item_price * 0.01; // 1% tax
            $sub_total = $item_price * $pro_qty;
            $total += $sub_total + $tax;
        }
    }

    // Add shipping charges if total is greater than 0 but less than 799
    if ($total > 0 && $total < 499) {
        $total += 99;
    }

    echo $total;
}


//Get featured products
function getPro()
{
    global $db;
    // Update the query to only select products that are in stock
    $get_product = "SELECT * FROM products WHERE product_availability > 0 order by rand() LIMIT 0,8";
    $run_products = mysqli_query($db, $get_product);

    if (!$run_products) {
        echo "Error: " . mysqli_error($db);
        return;
    }

    while ($row_product = mysqli_fetch_array($run_products)) {
        $pro_id = $row_product['product_id'];
        $pro_title = $row_product['product_title'];
        $pro_price = $row_product['product_price'];
        $pro_img1 = $row_product['product_img1'];
        $pro_mrp = $row_product['mrp'];
        $product_availability = $row_product['product_availability']; // Fetch availability
        $pro_label = $row_product['product_label'];
        $manufacturer_id = $row_product['manufacturer_id'];

        $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
        $run_manufacturer = mysqli_query($db, $get_manufacturer);
        $row_manufacturer = mysqli_fetch_array($run_manufacturer);
        $manufacturer_name = $row_manufacturer['manufacturer_title'];

        $discount = calculateDiscount1($pro_mrp, $pro_price); // Calculate discount

        $pro_price = $pro_label == "Sale" || $pro_label == "Gift"
            ? "<del> ₹$pro_price </del> | ₹$pro_mrp"
            : "₹$pro_price";

        $product_label = $pro_label
            ? "<a class='label sale' href='#' style='color:black;'>
                <div class='thelabel'>$pro_label</div>
                <div class='label-background'> </div>
               </a>"
            : "";

        // Get average rating for the product
        $average_rating = getAverageRating($pro_id, $db);

        // Start outputting the HTML
        echo "
            <div class='col-md-3 col-sm-6 col-xs-6 center-responsive'>
            <div class='breadcrumb'>
                <div class='product'>
                    <a href='product-details.php?pro_id=$pro_id'>
                        <img src='admin_area/product_images/$pro_img1' class='img-responsive'>
                    </a>
                    <div class='text'>
                       <center><p class='btn btn-warning'> $manufacturer_name </p></center>
                       <br>
                        <div class='star text-center' style='color:gold;'>
        ";
        // Display dynamic stars based on the average rating
        for ($i = 1; $i <= 5; $i++) {
            $star_class = ($i <= $average_rating) ? 'fas fa-star' : 'far fa-star'; // Use 'far' class for empty stars
            echo "<i class='$star_class'></i>";
        }

        echo "
                        </div>
                        <h3><a href='product-details.php?pro_id=$pro_id'>$pro_title</a></h3>
                        <p class='price'>
                            $pro_price 
                            <span>₹$pro_mrp</span>";

        // Display discount if applicable
        if ($discount > 0) {
            echo "<span class='discount'> ($discount% OFF)</span>";
        }

        // Show "In Stock" or "Only a few left" message based on availability
        if ($product_availability > 10) {
            echo "<p style='text-align: center; color: green; font-weight: bold; margin-top: 10px;'>In Stock</p>";
        } elseif ($product_availability > 0 && $product_availability <= 10) {
            echo "<p style='text-align: center; color: orange; font-weight: bold; margin-top: 10px;'>Only a few left, hurry up!</p>";
        } else {
            echo "<p style='text-align: center; color: magenta; font-weight: bold; margin-top: 10px;'>Available Soon</p>";
        }

        // Display either "Add to Cart" button since all products are in stock
        echo "<p class='buttons'>
                    <a href='product-details.php?pro_id=$pro_id' class='btn btn-primary'><i class='fa fa-cart-shopping'></i> Add to Cart</a>
                    <a href='wishlist.php?add_wishlist=$pro_id' class='btn btn-primary'><i class='fa-solid fa-heart'></i></a>
                  </p>
                  </div>
                  </div>
                  $product_label
                </div>
            </div>";
    }
}

// Function to fetch product categories
function getPCats($cat_id)
{
    global $db;
    // Fetch product categories from product_category table where cat_id matches
    $get_p_cats = "SELECT * FROM product_category WHERE cat_id = '$cat_id'";
    $run_p_cats = mysqli_query($db, $get_p_cats);

    if (!$run_p_cats) {
        echo "Error: " . mysqli_error($db);
        return;
    }

    // Display each product category in the dropdown menu
    while ($row_p_cats = mysqli_fetch_array($run_p_cats)) {
        $p_cat_id = $row_p_cats['p_cat_id'];
        $p_cat_title = $row_p_cats['p_cat_title'];
        echo "<li><a href='shop.php?p_cat=$p_cat_id'>$p_cat_title</a></li>";
    }
}

// Function to fetch categories
function getCat()
{
    global $db;
    $get_cat = "SELECT * FROM categories";
    $run_cat = mysqli_query($db, $get_cat);

    if (!$run_cat) {
        echo "Error: " . mysqli_error($db);
        return;
    }

    while ($row_cat = mysqli_fetch_array($run_cat)) {
        $cat_id = $row_cat['cat_id'];
        $cat_title = $row_cat['cat_title'];
        echo "<li><a href='shop.php?cat_id=$cat_id'>$cat_title</a></li>";
    }
}

// Function to fetch categories
function getCats()
{
    global $db;
    $get_cat = "SELECT * FROM categories";
    $run_cat = mysqli_query($db, $get_cat);

    if (!$run_cat) {
        echo "Error: " . mysqli_error($db);
        return;
    }

    while ($row_cat = mysqli_fetch_array($run_cat)) {
        $cat_id = $row_cat['cat_id'];
        $cat_title = $row_cat['cat_title'];
        echo "<li><a href='shop.php?cat_id=$cat_id'>$cat_title</a></li>";
    }
}

function getProducts()
{
    global $db;
    if (!isset($_GET['p_cat']) && !isset($_GET['cat_id'])) {
        $per_page = 6;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start_from = ($page - 1) * $per_page;

        $get_product = "SELECT * FROM products ORDER BY 1 DESC LIMIT $start_from, $per_page";
        $run_pro = mysqli_query(mysql: $db, query: $get_product);

        while ($row = mysqli_fetch_array($run_pro)) {
            $pro_id = $row['product_id'];
            $pro_title = $row['product_title'];
            $pro_price = $row['product_price'];
            $pro_img1 = $row['product_img1'];
            $pro_mrp = $row['mrp'];
            $pro_label = $row['product_label'];
            $product_availability = $row['product_availability']; // Fetch availability
            $product_price = $pro_label == "Sale" || $pro_label == "Gift"
                ? "<del> $$pro_price </del> | $$pro_mrp"
                : "$$pro_price";


            $discount = calculateDiscount1($pro_mrp, $pro_price); // Calculate discount

            $product_label = $pro_label
                ? "<a class='label sale' href='#' style='color:black;'>
                            <div class='thelabel'>$pro_label</div>
                            <div class='label-background'> </div>
                           </a>"
                : "";

            echo "
                        <div class='col-md-4 col-sm-6 center responsive'>
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

            // Show "In Stock" or "Only few left" message based on availability
            if ($product_availability > 10) {
                echo "<p style='text-align: center; color: green; font-weight: bold; margin-top: 10px;'>In Stocks</p>";
            } elseif ($product_availability > 0 && $product_availability <= 10) {
                echo "<p style='text-align: center; color: orange; font-weight: bold; margin-top: 10px;'>Only a few left, hurry up!</p>";
            } else {
                echo "<p style='text-align: center; color: magenta; font-weight: bold; margin-top: 10px;'>Available Soon</p>";
            }
            echo "</p>
                                    <p class='buttons'>
                                        <a href='product-details.php?pro_id=$pro_id' class='btn btn-default'>Details</a>";

            // Check availability and modify button accordingly
            if ($product_availability > 0) {
                echo "<a href='product-details.php?pro_id=$pro_id' class='btn btn-primary'>
                                    <i class='fa-solid fa-cart-shopping'></i> Add to Cart
                                  </a>";
            } else {
                echo "<button class='btn btn-danger disabled'>
                                    Out of Stock
                                  </button>";
            }

            echo "<a href='wishlist.php?add_wishlist=$pro_id' class='btn btn-primary'>
                                <i class='fa-solid fa-heart'></i>
                              </a>";


            echo "</p>
                                </div></div>
                                   $product_label
                            </div>
                        </div>";
        }
    }

}

// Function to fetch products by product category
function getPcatPro()
{
    global $db;
    if (isset($_GET['p_cat'])) {
        $p_cat_id = $_GET['p_cat'];
        $get_p_cat = "SELECT * FROM product_category WHERE p_cat_id='$p_cat_id'";
        $run_p_cat = mysqli_query($db, $get_p_cat);

        if (!$run_p_cat) {
            echo "Error: " . mysqli_error($db);
            return;
        }

        $row_p_cat = mysqli_fetch_array($run_p_cat);
        $p_cat_title = $row_p_cat['p_cat_title'];
        $p_cat_desc = $row_p_cat['p_cat_desc'];

        $get_products = "SELECT * FROM products WHERE p_cat_id='$p_cat_id'";
        $run_products = mysqli_query($db, $get_products);

        if (!$run_products) {
            echo "Error: " . mysqli_error($db);
            return;
        }

        if (mysqli_num_rows($run_products) == 0) {
            echo "<div class='breadcrumb'><h1>No Product Found In This Product Category</h1></div>";
        } else {
            echo "<div class='breadcrumb'><h1>$p_cat_title</h1><p>$p_cat_desc</p></div>";
            while ($row_products = mysqli_fetch_array($run_products)) {
                displayProduct($row_products);
            }
        }
    }
}

// Function to fetch products by category
function getCatPro()
{
    global $db;
    if (isset($_GET['cat_id'])) {
        $cat_id = $_GET['cat_id'];
        $get_cat = "SELECT * FROM categories WHERE cat_id='$cat_id'";
        $run_cats = mysqli_query($db, $get_cat);

        if (!$run_cats) {
            echo "Error: " . mysqli_error($db);
            return;
        }

        $row_cat = mysqli_fetch_array($run_cats);
        $cat_title = $row_cat['cat_title'];
        $cat_desc = $row_cat['cat_desc'];
        $get_products = "SELECT * FROM products WHERE cat_id='$cat_id'";
        $run_products = mysqli_query($db, $get_products);

        if (!$run_products) {
            echo "Error: " . mysqli_error($db);
            return;
        }

        if (mysqli_num_rows($run_products) == 0) {
            echo "<div class='breadcrumb'><h1>No Product Found In This Category</h1></div>";
        } else {
            echo "<div class='breadcrumb'><h1>$cat_title</h1><p>$cat_desc</p></div>";
            while ($row_products = mysqli_fetch_array($run_products)) {
                displayProduct($row_products);
            }
        }
    }
}

// Function to display individual product
function displayProduct($row_products)
{
    global $db;
    $pro_id = $row_products['product_id'];
    $pro_title = $row_products['product_title'];
    $pro_price = $row_products['product_price'];
    $pro_img1 = $row_products['product_img1'];
    $pro_mrp = $row_products['mrp'];
    $product_availability = $row_products['product_availability']; // Fetch availability
    $pro_label = $row_products['product_label'];
    $manufacturer_id = $row_products['manufacturer_id'];

    $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
    $run_manufacturer = mysqli_query($db, $get_manufacturer);
    $row_manufacturer = mysqli_fetch_array($run_manufacturer);
    $manufacturer_name = $row_manufacturer['manufacturer_title'];

    $discount = calculateDiscount1($pro_mrp, $pro_price); // Calculate discount

    $pro_price = $pro_label == "Sale" || $pro_label == "Gift"
        ? "<del> ₹$pro_price </del> | ₹$pro_mrp"
        : "₹$pro_price";

    $product_label = $pro_label
        ? "<a class='label sale' href='#' style='color:black;'>
                <div class='thelabel'>$pro_label</div>
                <div class='label-background'> </div>
               </a>"
        : "";

    // Get average rating for the product
    $average_rating = getAverageRating($pro_id, $db);

    // Start outputting the HTML
    echo "
            <div class='col-lg-3 col-md-6 col-sm-6 col-xs-12 center responsive'>
            <div class='breadcrumb'>
                <div class='product'>
                    <a href='product-details.php?pro_id=$pro_id'>
                        <img src='admin_area/product_images/$pro_img1' class='img-responsive'>
                    </a>
                    <div class='text'>
                       <center><p class='btn btn-warning'> $manufacturer_name </p></center>
                       <br>
                        <div class='star text-center' style='color:gold;'>
        ";
    // Display dynamic stars based on the average rating
    for ($i = 1; $i <= 5; $i++) {
        $star_class = ($i <= $average_rating) ? 'fas fa-star' : 'far fa-star'; // Use 'far' class for empty stars
        echo "<i class='$star_class'></i>";
    }

    echo "
                        </div>
                        <h3><a href='product-details.php?pro_id=$pro_id'>$pro_title</a></h3>
                        <p class='price'>
                            $pro_price 
                            <span>₹$pro_mrp</span>";

    // Display discount if applicable
    if ($discount > 0) {
        echo "<span class='discount'> ($discount% OFF)</span>";
    }

    // Show "In Stock" or "Only a few left" message based on availability
    if ($product_availability > 10) {
        echo "<p style='text-align: center; color: green; font-weight: bold; margin-top: 10px;'>In Stock</p>";
    } elseif ($product_availability > 0 && $product_availability <= 10) {
        echo "<p style='text-align: center; color: orange; font-weight: bold; margin-top: 10px;'>Only a few left, hurry up!</p>";
    } else {
        echo "<p style='text-align: center; color: magenta; font-weight: bold; margin-top: 10px;'>Available Soon</p>";
    }

    // Display either "Add to Cart" button since all products are in stock
    echo "</p>
    <p class='buttons'>
        <a href='product-details.php?pro_id=$pro_id'></a>";

    // Check availability and modify button accordingly
    if ($product_availability > 0) {
        echo "<a href='product-details.php?pro_id=$pro_id' class='btn btn-primary'>
    <i class='fa-solid fa-cart-shopping'></i> Add to Cart
  </a>";
    } else {
        echo "<button class='btn btn-danger disabled'>
    Out of Stock
  </button>";
    }

    echo "<a href='wishlist.php?add_wishlist=$pro_id' class='btn btn-primary'>
<i class='fa-solid fa-heart'></i>
</a>";

    echo "</p>
</div></div>
   $product_label
</div>
</div>";
}

//Function to calculate average rating
function getAverageRating($product_id, $db)
{
    $query = "SELECT AVG(review_rating) AS average_rating FROM product_reviews WHERE product_id='$product_id'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return round($row['average_rating']);
    }
    return 0;
}

//TO SHOW SUGGESTIONS PRODUCTS
function getSuggestion()
{
    global $db;
    $get_products = "select * from products where product_availability > 0 order by rand() LIMIT 0,4";
    $run_products = mysqli_query($db, $get_products);

    while ($row_products = mysqli_fetch_array($run_products)) {
        $pro_id = $row_products['product_id'];
        $pro_title = $row_products['product_title'];
        $pro_price = $row_products['product_price'];
        $pro_img1 = $row_products['product_img1'];
        $pro_label = $row_products['product_label'];
        $manufacturer_id = $row_products['manufacturer_id'];
        $product_availability = $row_products['product_availability'];
        $pro_mrp = $row_products['mrp'];

        // Fetch manufacturer name
        $get_manufacturer = "select * from manufacturers where manufacturer_id='$manufacturer_id'";
        $run_manufacturer = mysqli_query($db, $get_manufacturer);
        $row_manufacturer = mysqli_fetch_array($run_manufacturer);
        $manufacturer_name = $row_manufacturer['manufacturer_title'];

        // Check for discount
        $discount = calculateDiscount($pro_mrp, $pro_price);

        // Set pricing labels based on whether product is on sale or not
        if ($pro_label == "Sale" || $pro_label == "Gift") {
            $product_price = "<del> ₹$pro_price </del>";
            $product_mrp = "| ₹$pro_mrp";
        } else {
            $product_mrp = "";
            $product_price = "₹$pro_price";
        }

        // Product label for Sale/Gift
        $product_label = ($pro_label != "") ? "<a class='label sale' href='#' style='color:black;'>
                <div class='thelabel'>$pro_label</div>
                <div class='label-background'></div>
            </a>" : "";

        // Calculate the average rating
        $average_rating = getAverageRating($pro_id, $db);

        // Generate HTML for product display
        echo "
        <div class='col-md-3 col-sm-6 col-xs-12 center-responsive'>
         <div class='breadcrumb'>
            <div class='product'>
                <a href='product-details.php?pro_id=$pro_id'>
                    <img src='admin_area/product_images/$pro_img1' class='img-responsive'>
                </a>
                <div class='text'>
                    <center>
                        <p class='btn btn-warning'>$manufacturer_name</p>
                    </center>
                    <br>
                    <div class='star text-center' style='color:gold;'>";
        // Display dynamic stars based on the average rating
        for ($i = 1; $i <= 5; $i++) {
            $star_class = ($i <= $average_rating) ? 'fas fa-star' : 'far fa-star';
            echo "<i class='$star_class'></i>";
        }
        echo "
                    </div>
                    <h3><a href='product-details.php?pro_id=$pro_id'>$pro_title</a></h3>
                    <p class='price'>$product_price <span>₹$pro_mrp</span>";

        // Display discount if applicable
        if ($discount > 0) {
            echo "<span class='discount'> ($discount% OFF)</span>";
        }

        // Show "In Stock" or "Only a few left" message based on availability
        if ($product_availability > 10) {
            echo "<p style='text-align: center; color: green; font-weight: bold; margin-top: 10px;'>In Stock</p>";
        } elseif ($product_availability > 0 && $product_availability <= 10) {
            echo "<p style='text-align: center; color: orange; font-weight: bold; margin-top: 10px;'>Only a few left, hurry up!</p>";
        } else {
            echo "<p style='text-align: center; color: magenta; font-weight: bold; margin-top: 10px;'>Available Soon</p>";
        }

        // Add to Cart and Wishlist buttons
        echo "<p class='buttons'>
                            <a href='product-details.php?pro_id=$pro_id' class='btn btn-primary'><i class='fa fa-cart-shopping'></i> Add to Cart</a>
                            <a href='wishlist.php?add_wishlist=$pro_id' class='btn btn-primary'><i class='fa-solid fa-heart'></i></a>
                        </p>
                </div>
                $product_label
            </div>
            </div>
        </div>";
    }
}



?>