<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files for database connection, functions, and main structure
include("includes/db.php");
include("functions/functions.php");
include("includes/main.php");
include("includes/header.php");
?>

<!-- Content area starts -->
<div id="content">
    <!-- Main container starts -->
    <div class="container">
        <!-- Breadcrumb for navigation -->
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Search</li>
            </ul>
        </div>
        <!-- End of breadcrumb -->

        <?php
        // Check if there is a search query provided by the user
        if (isset($_GET['query'])) {
            // Sanitize user input to prevent SQL injection
            $search_query = mysqli_real_escape_string($con, $_GET['query']);

            // Fetch matching products based on title, description, or keywords
            $get_products = "SELECT * FROM products WHERE product_title LIKE '%$search_query%' 
                             OR product_desc LIKE '%$search_query%' OR product_keyword LIKE '%$search_query%'";
            $run_products = mysqli_query($con, $get_products);

            // Check if query executed successfully
            if (!$run_products) {
                echo "<div class='col-md-12'><h1>Error fetching products: " . mysqli_error($con) . "</h1></div>";
                exit;
            }

            // Check if any product matches the search criteria
            if ($row_product = mysqli_fetch_array($run_products)) {
                $p_cat_id = $row_product['p_cat_id'];
                $cat_id = $row_product['cat_id'];

                // Get the title of the product category based on p_cat_id
                $get_p_cat_title = "SELECT p_cat_title FROM product_category WHERE p_cat_id = '$p_cat_id'";
                $run_p_cat_title = mysqli_query($con, $get_p_cat_title);

                // Check if query executed successfully
                if (!$run_p_cat_title) {
                    echo "<div class='col-md-12'><h1>Error fetching product category title: " . mysqli_error($con) . "</h1></div>";
                    exit;
                }
                $row_p_cat_title = mysqli_fetch_array($run_p_cat_title);
                $p_cat_title = $row_p_cat_title['p_cat_title'];

                // Get the title of the category based on cat_id
                $get_cat = "SELECT cat_title FROM categories WHERE cat_id = '$cat_id'";
                $run_cat = mysqli_query($con, $get_cat);

                // Check if query executed successfully
                if (!$run_cat) {
                    echo "<div class='col-md-12'><h1>Error fetching category title: " . mysqli_error($con) . "</h1></div>";
                    exit;
                }
                $row_cat = mysqli_fetch_array($run_cat);
                $cat_title = $row_cat['cat_title'];

                // Display the search result category and subcategory in an H1 tag
                echo "<div class='col-md-12'><ul class='breadcrumb'><h1>Search Result : $cat_title > $p_cat_title</h1></ul></div>";
            } else {
                // If no products are found, display a message
                echo "<div class='col-md-12'><ul class='breadcrumb'><h1>No results found for $search_query</h1></ul></div>";
            }
        }
        ?>

        <!-- Row to display product results -->
        <div class="row">
            <?php
            // Loop through each matching product and display details
            while ($row_product = mysqli_fetch_array($run_products)) {
                $pro_id = $row_product['product_id'];
                $pro_title = $row_product['product_title'];
                $pro_price = $row_product['product_price'];
                $pro_img1 = $row_product['product_img1'];
                $pro_mrp = $row_product['mrp'];
                $product_availability = $row_product['product_availability'];
                $pro_label = $row_product['product_label'];
                $manufacturer_id = $row_product['manufacturer_id'];

                // Fetch manufacturer details
                $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
                $run_manufacturer = mysqli_query($con, $get_manufacturer);

                // Check if query executed successfully
                if (!$run_manufacturer) {
                    echo "<div class='col-md-12'><h1>Error fetching manufacturer details: " . mysqli_error($con) . "</h1></div>";
                    exit;
                }

                $row_manufacturer = mysqli_fetch_array($run_manufacturer);
                $manufacturer_name = $row_manufacturer['manufacturer_title'];

                // Calculate discount percentage if applicable
                $discount = calculateDiscount1($pro_mrp, $pro_price);

                // Determine price display based on product label (e.g., Sale, Gift)
                $pro_price_display = $pro_label == "Sale" || $pro_label == "Gift"
                    ? "<del> ₹$pro_price </del> | ₹$pro_mrp"
                    : "₹$pro_price";

                // Prepare product label for display if it exists
                $product_label = $pro_label
                    ? "<a class='label sale' href='#' style='color:black;'>
                        <div class='thelabel'>$pro_label</div>
                        <div class='label-background'></div>
                      </a>"
                    : "";

                // Get the average rating for the product
                $average_rating = getAverageRating($pro_id, $db);

                // HTML structure for each product card
                echo "
                <div class='col-lg-2 col-sm-4 col-6 single'>
                <div class='breadcrumb'>
                    <div class='product'>
                        <a href='product-details.php?pro_id=$pro_id'>
                            <img src='admin_area/product_images/$pro_img1' class='img-responsive'>
                        </a>
                        <div class='text'>
                            <center><p class='btn btn-warning'>$manufacturer_name</p></center>
                            <br>
                            <div class='star text-center' style='color:gold;'>";

                // Display star ratings based on the average rating value
                for ($i = 1; $i <= 5; $i++) {
                    $star_class = ($i <= $average_rating) ? 'fas fa-star' : 'far fa-star';
                    echo "<i class='$star_class'></i>";
                }

                echo "
                            </div>
                            <h3><a href='product-details.php?pro_id=$pro_id'>$pro_title</a></h3>
                            <p class='price'>
                                $pro_price_display
                                <span>₹$pro_mrp</span>";

                // Display discount information if applicable
                if ($discount > 0) {
                    echo "<span class='discount'> ($discount% OFF)</span>";
                }

                // Display availability status based on stock level
                if ($product_availability > 10) {
                    echo "<p style='text-align: center; color: green; font-weight: bold; margin-top: 10px;'>In Stock</p>";
                } elseif ($product_availability > 0 && $product_availability <= 10) {
                    echo "<p style='text-align: center; color: orange; font-weight: bold; margin-top: 10px;'>Only a few left, hurry up!</p>";
                } else {
                    echo "<p style='text-align: center; color: magenta; font-weight: bold; margin-top: 10px;'>Available Soon</p>";
                }

                echo "</p>
    <p class='buttons'>
        <a href='product-details.php?pro_id=$pro_id'></a>";

                // Display "Add to Cart" button if product is in stock, otherwise "Out of Stock" button
                if ($product_availability > 0) {
                    echo "<a href='product-details.php?pro_id=$pro_id' class='btn btn-primary'>
    <i class='fa-solid fa-cart-shopping'></i> Add to Cart
  </a>";
                } else {
                    echo "<button class='btn btn-danger disabled'>
    Out of Stock
  </button>";
                }

                // Display button to add product to wishlist
                echo "<a href='wishlist.php?add_wishlist=$pro_id' class='btn btn-primary'>
<i class='fa-solid fa-heart'></i>
</a>";

                echo "</p>
</div></div>
                        $product_label
                    </div>
                </div>";
            }
            ?>
        </div>
        <!-- End of row displaying products -->
    </div>
    <!-- End of main container -->
</div>
<!-- End of content area -->

<?php include("includes/footer.php"); ?>