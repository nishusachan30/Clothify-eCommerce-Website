<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("includes/db.php");
include("functions/functions.php");
include("includes/main.php");
include("includes/header.php");


$p_title = '';
$p_cat_id = '';
$p_cat_title = '';
$p_seller = '';
$p_company = '';
$discount = 0;
$product_availability = 0;
$manufacturer_name = '';
$average_rating = 0;
$rating_count = 0;
$review_count = 0;

if (isset($_GET['pro_id'])) {
    $pro_id = $_GET['pro_id'];
    $get_product = "SELECT * FROM products WHERE product_id='$pro_id'";
    $run_product = mysqli_query($con, $get_product);
    if (!$run_product) {
        echo "Error: " . mysqli_error($con);
        exit; // Stop further execution on error
    }
    if (mysqli_num_rows($run_product) > 0) {
        $row_product = mysqli_fetch_array($run_product);
        $p_cat_id = $row_product['p_cat_id'];
        $p_title = $row_product['product_title'];
        $p_price = $row_product['product_price'];
        $manufacturer_id = $row_product['manufacturer_id'];
        $p_mrp = $row_product['mrp'];
        $p_desc = $row_product['product_desc'];
        $p_img1 = $row_product['product_img1'];
        $p_img2 = $row_product['product_img2'];
        $p_img3 = $row_product['product_img3'];
        $product_availability = $row_product['product_availability'];
        $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
        $run_manufacturer = mysqli_query($db, $get_manufacturer);
        $row_manufacturer = mysqli_fetch_array($run_manufacturer);
        $manufacturer_name = $row_manufacturer['manufacturer_title'];
        $get_p_cat = "SELECT * FROM product_category WHERE p_cat_id='$p_cat_id'";
        $run_p_cat = mysqli_query($con, $get_p_cat);

        $get_rating = "SELECT AVG(review_rating) as average_rating, COUNT(review_id) as rating_count, COUNT(CASE WHEN review_text IS NOT NULL AND review_text != '' THEN 1 END) AS review_count FROM product_reviews WHERE product_id='$pro_id'";
        $run_rating = mysqli_query($con, $get_rating);

        if ($run_rating) {
            $rating_data = mysqli_fetch_array($run_rating);
            $average_rating = round($rating_data['average_rating'], 1); //
            $rating_count = $rating_data['rating_count'];
            $review_count = $rating_data['review_count'];
        } else {
            $average_rating = 0;
            $review_count = 0;
            $rating_count = 0;
        }

        if (!$run_p_cat) {
            echo "Error: " . mysqli_error($con);
            exit; // Stop further execution on error
        }
        if (mysqli_num_rows($run_p_cat) > 0) {
            $row_p_cat = mysqli_fetch_array($run_p_cat);
            $p_cat_id = $row_p_cat['p_cat_id'];
            $p_cat_title = $row_p_cat['p_cat_title'];
        } else {
            echo "<p>Product category not found.</p>";
            exit;
        }
    } else {
        echo "<p>Product not found.</p>";
        exit;
    }
}
?>
<style>
    .thumbnail-img {
        width: 100%;
        height: 320px;
        object-fit: cover;
        border: 1px solid #ddd;
        margin-top: 10px;
    }
</style>
<div id="content">
    <div class="container">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="shop.php?p_cat=<?php echo $p_cat_id; ?>"><?php echo $p_cat_title ?></a></li>
                <li><?php echo $p_title; ?></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="row" id="productmain">
                <div class="col-sm-6">
                    <div id="mainimage">
                        <div id="myCarousel" class="carousel slider" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <center>
                                        <img src="admin_area/product_images/<?php echo $p_img1 ?>"
                                            class="img-responsive" alt="">
                                    </center>
                                </div>
                                <div class="item">
                                    <center>
                                        <img src="admin_area/product_images/<?php echo $p_img2 ?>"
                                            class="img-responsive" alt="">
                                    </center>
                                </div>
                                <div class="item">
                                    <center>
                                        <img src="admin_area/product_images/<?php echo $p_img3 ?>"
                                            class="img-responsive" alt="">
                                    </center>
                                </div>
                            </div>
                            <a href="#myCarousel" class="left carousel-control" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a href="#myCarousel" class="right carousel-control" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="breadcrumb" style="text-align:left;">
                        <div class="box">
                            <div class="row align-items-center seller-company-info">
                                <div class="col-sm-6">
                                    <p class="company">Manufacturer: <?php echo $manufacturer_name; ?></p>
                                </div>
                            </div>
                            <p class="title"><?php echo $p_title ?></p>
                            <!-- Average rating and review count -->
                            <div id="rating">
                                <div class="rating-box">
                                    <span><?php echo $average_rating; ?></span>
                                    <span>
                                        <i class="fa-solid fa-star"></i>
                                    </span>
                                </div>
                                <span style="font-size: 14px; margin-left: 10px;"><?php echo $rating_count; ?> Ratings &
                                    <?php echo $review_count; ?> Reviews</span>
                            </div>
                            <?php addcart(); ?>
                            <form action="product-details.php?add_cart=<?php echo $pro_id ?>" method="post"
                                class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Product Quantity</label>
                                    <div class="col-md-7">
                                        <select name="product_qty" class="form-control">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Product Size</label>
                                    <div class="col-md-7">
                                        <select name="product_size" class="form-control" required>
                                            <option value="">Select Size</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                            <option value="XXL">XXL</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="special">Special Price</p>
                                <?php $discount = calculateDiscount($p_mrp, $p_price); ?>
                                <p class="price" style="margin-bottom: 5px;">
                                    ₹<?php echo $p_price ?>
                                    <span>₹<?php echo $p_mrp ?></span>
                                    <?php if ($discount > 0) { ?>
                                        <span class="discount">(<?php echo $discount; ?>% OFF)</span>
                                    <?php } ?>
                                </p>
                                <center>
                                    <?php
                                    if ($product_availability > 10) { ?>
                                        <p style="color: green; font-weight: bold; margin-top: 10px;">In Stocks</p>
                                    <?php } elseif ($product_availability > 0 && $product_availability <= 10) { ?>
                                        <p style="color: orange; font-weight: bold; margin-top: 10px;">Only a few left,
                                            hurry up!</p>
                                    <?php } else { ?>
                                        <p style="color: magenta; font-weight: bold; margin-top: 10px;">Available Soon</p>
                                    <?php } ?>

                                    <p class="text-center">
                                        <?php if ($product_availability > 0) { ?>
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa-solid fa-cart-shopping"></i> Add to cart
                                            </button>
                                        <?php } else { ?>
                                            <span class="btn btn-danger disabled">Out of Stock</span>
                                        <?php } ?>

                                        <!-- Wishlist Button -->
                                        "<a href='wishlist.php?add_wishlist=<?php echo $pro_id; ?>' class='btn btn-primary'>
                                            <i class='fa-solid fa-heart'></i>
                                        </a>"

                                </center>
                                </p>
                            </form>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px; cursor: pointer;">
                        <div class="col-md-4 col-sm-4">
                            <img src="admin_area/product_images/<?php echo $p_img1 ?>"
                                class="img-responsive thumbnail-img" alt="" data-target="#myCarousel" data-slide-to="0">
                        </div>
                        <div class="col-md-4  col-sm-4">
                            <img src="admin_area/product_images/<?php echo $p_img2 ?>"
                                class="img-responsive thumbnail-img" alt="" data-target="#myCarousel" data-slide-to="1">
                        </div>
                        <div class="col-md-4  col-sm-4">
                            <img src="admin_area/product_images/<?php echo $p_img3 ?>"
                                class="img-responsive thumbnail-img" alt="" data-target="#myCarousel" data-slide-to="2">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" id="details"><!--col-md-6 start-->
                <div class="box">
                    <h4>Product Details</h4>
                    <p><?php echo $p_desc ?> </p>
                </div>
            </div><!--col-md-6 end-->
            <div id="row same-height-row"><!-- row same-height-row Starts -->
                <div class="col-md-12 col-sm-12">
                    <!---Include product reviews section-->
                    <?php include('product_reviews.php'); ?>
                    <!--Include product reviews end-->
                </div>
            </div><!-- row same-height-row Ends -->
            <div class="col-md-12 col-sm-12">
                <div id="row" class="breadcrumb"><!-- row same-height-row Starts -->
                    <h3 class="text-center">Similar Products</h3>
                </div>
                <?php getSuggestion(); ?>
            </div>
        </div><!-- col-md-9 Ends -->
    </div><!--content end-->
</div>

<!-- Footer section -->
<?php include("includes/footer.php"); ?>