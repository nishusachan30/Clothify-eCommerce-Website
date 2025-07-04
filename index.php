<?php
// Initialize session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
include("includes/db.php"); // Database connection
include("functions/functions.php"); // Utility functions
include("includes/main.php"); // Main configuration
include("includes/header.php"); // Header content
?>



<!-- Slider Section -->
<div class="container" id="slider"> <!-- container starts -->
    <div class="col-md-12 col-sm-12"> <!--col-md-12 start -->
        <div class="carousel slider" id="myCarousel" data-ride="carousel">
            <!-- Carousel Indicators -->
            <ol class="carousel-indicators">
                <li data-target="myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="myCarousel" data-slide-to="1"></li>
                <li data-target="myCarousel" data-slide-to="2"></li>
                <li data-target="myCarousel" data-slide-to="3"></li>
            </ol>

            <!-- Carousel Inner (Slider Images) -->
            <div class="carousel-inner"> <!-- carousel-inner starts -->
                <?php
                // Fetch and display the first slider image as active
                $get_slider = "SELECT * FROM slider LIMIT 0,1";
                $run_slider = mysqli_query($con, $get_slider);
                if ($run_slider) {
                    while ($row = mysqli_fetch_array($run_slider)) {
                        $slider_image = $row['slider_image'];
                        $slider_url = $row['slider_url'];
                        $slider_season = $row['slider_season'];
                        $slider_text = $row['slider_text'];

                        echo "<div class='item active'>
                         <a href='$slider_url'>
                            <section class='main-home' style='background-image: url(admin_area/slider_images/$slider_image);'>
                                <div class='main-text'>";

                        // Conditionally render the text elements
                        if (!empty($slider_season)) {
                            echo "<h5>$slider_season collection</h5>";
                            echo "<h1>new $slider_season <br> collection</h1>";
                        }

                        if (!empty($slider_text)) {
                            echo "<p>$slider_text</p>";
                            echo "<a href='$slider_url' class='main-btn'>Shop Now</a>";
                        }

                        echo "  </div>
                            </section>
                            </a>
                        </div>";
                    }
                }
                ?>

                <?php
                // Fetch and display the remaining slider images
                $get_slider = "SELECT * FROM slider LIMIT 1,3";
                $run_slider = mysqli_query($con, $get_slider);
                if ($run_slider) {
                    while ($row = mysqli_fetch_array($run_slider)) {
                        $slider_image = $row['slider_image'];
                        $slider_url = $row['slider_url'];
                        $slider_season = $row['slider_season'];
                        $slider_text = $row['slider_text'];

                        echo "<div class='item'>
                         <a href='$slider_url'>
                            <section class='main-home' style='background-image: url(admin_area/slider_images/$slider_image);'>
                                <div class='main-text'>";

                        // Conditionally render the text elements
                        if (!empty($slider_season)) {
                            echo "<h5>$slider_season collection</h5>";
                            echo "<h1>new $slider_season <br> collection</h1>";
                        }

                        if (!empty($slider_text)) {
                            echo "<p>$slider_text</p>";
                            echo "<a href='$slider_url' class='main-btn'>Shop Now</a>";
                        }

                        echo "  </div>
                            </section>
                            </a>
                        </div>";
                    }
                }
                ?>
            </div> <!-- carousel-inner ends -->

            <!-- Carousel Controls -->
            <a href="#myCarousel" class="left carousel-control" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a href="#myCarousel" class="right carousel-control" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div> <!--col-md-12 ends-->
</div> <!-- container ends -->

<!-- Advantage Section -->
<div id="advantage"> <!-- advantage section starts -->
    <div class="container"> <!-- container starts -->
        <div class="same-height-row"> <!-- same-height-row starts -->
            <?php
            // Fetch and display advantage boxes
            $get_boxes = "SELECT * FROM boxes_section";
            $run_box = mysqli_query($con, $get_boxes);
            if ($run_box) {
                while ($row = mysqli_fetch_array($run_box)) {
                    $box_title = htmlspecialchars($row['box_title']);
                    $box_desc = htmlspecialchars($row['box_desc']);
                    $box_icon = htmlspecialchars($row['box_icon']);
                    ?>
                    <a href="terms.php">
                        <div class="col-sm-3"> <!-- col-sm-4 starts -->
                            <div class="breadcrumb"> <!-- breadcrumb starts -->
                                <div class="icon"> <!-- icon starts -->
                                    <i class="<?php echo $box_icon; ?>"></i>
                                </div> <!-- icon ends -->
                                <h3><strong><a href="#"><?php echo $box_title; ?></a></strong></h3>
                                <p><strong><?php echo $box_desc; ?></strong></p>
                            </div> <!-- breadcrumb ends -->
                        </div> <!-- col-sm-4 ends -->
                    </a>
                <?php }
            } ?>
        </div> <!-- same-height-row ends -->
    </div> <!-- container ends -->
</div> <!-- advantage section ends -->

<!-- Latest Products Section -->
<div class="container" id="content"> <!-- container starts -->
    <div class="col-md-12 col-sm-12"> <!-- col-md-12 col-sm-12 starts -->
        <div id="row" class="breadcrumb"> <!-- breadcrumb starts -->
            <h3 class="text-center">LATEST THIS WEEK</h3>
        </div> <!-- breadcrumb ends -->
    </div> <!-- col-md-12 col-sm-12 ends -->
</div> <!-- container ends -->

<div id="content" class="container"> <!-- content container starts -->
    <div class="col-md-12"> <!-- col-md-12 starts -->
        <div class="row"> <!-- row starts -->
            <?php
            // Fetch and display products dynamically
            try {
                getPro();
            } catch (Exception $e) {
                echo "<p class='text-danger'>Error fetching products: " . $e->getMessage() . "</p>";
            }
            ?>
        </div> <!-- row ends -->
    </div> <!-- col-md-12 ends -->
</div> <!-- content container ends -->

<!-- Footer -->
<?php include("includes/footer.php"); ?>