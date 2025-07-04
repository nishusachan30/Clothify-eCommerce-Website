<?php

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files (DB connection, functions, header, and main)
include("includes/db.php");
include("functions/functions.php");
include("includes/main.php");
include("includes/header.php");
?>

<!-- Navigation and menu bar start -->
<?php include("includes/header.php"); ?>
<!-- Navigation and menu bar end -->

<div id="content"><!-- content start -->
    <div class="container"><!-- container start -->
        <div class="col-md-12"><!-- col-md-12 start -->
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Shop</li>
            </ul>
        </div><!-- col-md-12 end -->

        <div class="col-md-12"><!-- col-md-12 start -->
                <?php
                // Display introductory text if no category or product category is selected
                if (!isset($_GET['p_cat']) && !isset($_GET['cat_id'])) {
                    echo "<div class='breadcrumb'>
                <h1>Shop</h1>
                <p>Here you can checkout our variety of products.</p>
                </div>
                ";
                }
                ?>

            <div class="row"><!-- row start -->
                <?php
                // Pagination and fetching products
                if (!isset($_GET['p_cat']) && !isset($_GET['cat_id'])) {
                    $per_page = 10; // Number of products per page
                    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page
                    $start_from = ($page - 1) * $per_page; // Offset for pagination
                
                    // Query to fetch products randomly for display
                    $get_product = "SELECT * FROM products ORDER BY rand() LIMIT $start_from, $per_page";
                    $run_pro = mysqli_query($con, $get_product);

                    // Loop through and display each product
                    while ($row = mysqli_fetch_array($run_pro)) {
                        $pro_id = $row['product_id'];
                        $pro_title = $row['product_title'];
                        $pro_price = $row['product_price'];
                        $pro_img1 = $row['product_img1'];
                        $pro_mrp = $row['mrp'];
                        $pro_label = $row['product_label'];
                        $product_availability = $row['product_availability'];

                        // Fetch manufacturer details
                        $manufacturer_id = $row['manufacturer_id'];
                        $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
                        $run_manufacturer = mysqli_query($db, $get_manufacturer);
                        $row_manufacturer = mysqli_fetch_array($run_manufacturer);
                        $manufacturer_name = $row_manufacturer['manufacturer_title'];

                        // Get product reviews and average rating
                        $get_rating = "SELECT AVG(review_rating) as average_rating, COUNT(review_id) as rating_count, 
                                       COUNT(CASE WHEN review_text IS NOT NULL AND review_text != '' THEN 1 END) AS review_count 
                                       FROM product_reviews WHERE product_id='$pro_id'";
                        $run_rating = mysqli_query($con, $get_rating);

                        // Handle cases where no reviews are available
                        if ($run_rating) {
                            $rating_data = mysqli_fetch_array($run_rating);
                            $average_rating = round($rating_data['average_rating'], 1);
                            $rating_count = $rating_data['rating_count'];
                            $review_count = $rating_data['review_count'];
                        } else {
                            $average_rating = 0;
                            $review_count = 0;
                            $rating_count = 0;
                        }

                        // Price display with or without discount
                        $product_price = $pro_label == "Sale" || $pro_label == "Gift"
                            ? "<del> $$pro_price </del> | $$pro_mrp"
                            : "$$pro_price";

                        $discount = calculateDiscount1($pro_mrp, $pro_price); // Calculate discount
                
                        // Product label display
                        $product_label = $pro_label
                            ? "<a class='label sale' href='#' style='color:black;'>
                            <div class='thelabel'>$pro_label</div>
                            <div class='label-background'> </div>
                        </a>"
                            : "";

                        // Display product information
                        echo "
                        <div class='col-md-3 col-sm-6 center responsive'>
                        <div class='breadcrumb'>
                        <center>
                            <div class='product'>
                                <a href='product-details.php?pro_id=$pro_id'>
                                    <img src='admin_area/product_images/$pro_img1' class='img-responsive' alt='product'>
                                </a>
                                <div class='text'>
                                <center><p class='btn btn-warning'> $manufacturer_name </p></center>
                                <br>
                                <div class='star text-center' style='color:gold;'>";

                        // Display dynamic stars based on the average rating
                        for ($i = 1; $i <= 5; $i++) {
                            $star_class = ($i <= $average_rating) ? 'fas fa-star' : 'far fa-star'; // Use 'far' class for empty stars
                            echo "<i class='$star_class'></i>";
                        }

                        echo "
                                </div></div>
                                    <h3><a href='product-details.php?pro_id=$pro_id'>$pro_title</a></h3>
                                    <p class='price'>
                                        ₹$pro_price 
                                        <span>₹$pro_mrp</span>";

                        if ($discount > 0) {
                            echo "<span class='discount'> ({$discount}% OFF)</span>";
                        }

                        // Availability messages
                        if ($product_availability > 10) {
                            echo "<p style='text-align: center; color: green; font-weight: bold; margin-top: 10px;'>In Stocks</p>";
                        } elseif ($product_availability > 0 && $product_availability <= 10) {
                            echo "<p style='text-align: center; color: orange; font-weight: bold; margin-top: 10px;'>Only a few left, hurry up!</p>";
                        } else {
                            echo "<p style='text-align: center; color: magenta; font-weight: bold; margin-top: 10px;'>Available Soon</p>";
                        }
                        echo "</p>
                                    <p class='buttons'>
                                        <a href='product-details.php?pro_id=$pro_id'></a>";

                        // Add to cart button based on availability
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
                                </div>
                                </center>
                                   $product_label
                            </div>
                        </div>";
                    }
                }
                ?>
            </div><!-- row end -->

            <?php
            // Fetch and display products based on category and manufacturer
            getPcatPro();
            getCatPro();
            ?>

        </div><!-- col-md-12 end -->

        <!-- Pagination for product listing -->
        <center>
            <ul class="pagination">
                <?php
                // Pagination for product listing
                $per_page = 10;
                $query = "SELECT * FROM products";
                $result = mysqli_query($con, $query);
                $total_record = mysqli_num_rows($result);
                if ($total_record > 0) {
                    $total_pages = ceil($total_record / $per_page);

                    // Display pagination links
                    echo "<li><a href='shop.php?page=1'>First Page</a></li>";

                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li><a href='shop.php?page=" . $i . "'>" . $i . "</a></li>";
                    }

                    echo "<li><a href='shop.php?page=$total_pages'>Last Page</a></li>";
                } else {
                    echo "<p>No products found.</p>";
                }
                ?>
            </ul>
        </center>
    </div><!-- container end -->
</div><!-- content end -->

<!-- footer include -->
<?php include("includes/footer.php"); ?>
<style>
  /* General Product Styling */
.product {
    width: 100%; /* Full width of the container */
    margin-bottom: 10px; /* Reduce space between product cards */
    padding: 10px; /* Reduce internal padding */
    object-fit: cover; /* Maintain aspect ratio and avoid stretching */
    text-align: center;
    height: auto; /* Allow the height to adapt to content */
}

/* Product Image Styling */
.product img {
    max-width: 180px; /* Set a smaller maximum width */
    max-height: 220px; /* Set a fixed height for images */
    object-fit: cover; /* Maintain aspect ratio and avoid stretching */
    margin: 0 auto 10px; /* Center image and reduce spacing below */
}

/* Adjust Columns */
.col-md-3.col-sm-6 {
    width: 20%; /* Default column width for larger screens */
    height: 20%;
    padding: 10px; /* Add spacing between items */
    margin-bottom: 10px; /* Reduce spacing below the image */
}

/* Responsive Adjustments for Smaller Screens */
@media (max-width: 768px) {
    .col-md-3.col-sm-6 {
        width: 40%; /* Reduce to 2 columns for medium screens */
    }

    .product img {
        max-width: 200px; /* Slightly reduce image size on smaller screens */
        height: 180px; /* Adjust height */
    }
}

@media (max-width: 576px) {
    .col-md-3.col-sm-6 {
        width: 50%; /* Reduce to 1 column for extra small screens */
    }

    .product img {
        max-width: 160px; /* Reduce image size further for very small screens */
        height: 160px; /* Adjust height for very small screens */
    }
}

/* Compact Product Details */
.product .text h3,
.product .price,
.product p {
    margin: 5px 0; /* Reduce margin for compact spacing */
    line-height: 1.2; /* Tighter line spacing */
}
.product .text{
    padding: 20px;
}

/* Compact Stars */
.product .star {
    margin: 5px 0; /* Reduce spacing around stars */
    padding: 0; /* Remove additional padding */
}

/* Button Spacing */
.product .buttons {
    margin-top: 5px; /* Adjust spacing above buttons */
    padding: 0; /* Remove padding */
}

/* Default Product Label Styling */
.product .label {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #f39c12;
    color: white;
    padding: 5px 10px;
    font-size: 14px;
    font-weight: bold;
    text-transform: uppercase;
    border-radius: 3px;
    z-index: 10;
}


</style>