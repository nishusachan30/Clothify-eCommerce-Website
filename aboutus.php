<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");
?>

<div id="content"><!-- content start -->
    <div class="container"><!-- container start -->
        <div class="col-md-12"><!-- col-md-12 start -->
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Shop</li>
            </ul>
        </div><!-- col-md-12 end -->
    </div><!-- container end -->
</div><!-- content end -->

<div id="content"><!-- content start -->
    <div class="container"><!-- container start -->
        <div class="col-md-12"><!-- col-md-12 start -->
            <div class="box"><!-- box start -->
                <?php
                // Fetch 'About Us' data from the database
                $get_about_us = "SELECT * FROM about_us";
                $run_about_us = mysqli_query($con, $get_about_us);

                if (!$run_about_us) {
                    // Query failed, display an error message
                    echo "<p class='error'>Error fetching data: " . mysqli_error($con) . "</p>";
                } else {
                    // Check if any data is returned
                    $row_about_us = mysqli_fetch_array($run_about_us);
                    if ($row_about_us) {
                        // Extract heading and descriptions from the database result
                        $about_heading = $row_about_us['about_heading'];
                        $about_short_desc = $row_about_us['about_short_desc'];
                        $about_desc = $row_about_us['about_desc'];

                        // Display About Us content
                        echo "<h1>" . htmlspecialchars($about_heading) . "</h1>";
                        echo "<p class='lead'>" . htmlspecialchars($about_short_desc) . "</p>";
                        echo "<p>" . nl2br(htmlspecialchars($about_desc)) . "</p>";
                    } else {
                        // No data found
                        echo "<p class='error'>No 'About Us' data found.</p>";
                    }
                }
                ?>
            </div><!-- box end -->
        </div><!-- col-md-12 end -->
    </div><!-- container end -->
</div><!-- content end -->

<?php
// Include footer file (e.g., contact info, social links)
include("includes/footer.php");
?>
