<?php
/**
 * Terms and Conditions Page
 * 
 * This script displays the Terms and Conditions section of the website. It dynamically fetches
 * terms and their descriptions from the database and displays them in a tabbed layout for user-friendly navigation.
 * 
 * Features:
 * - Breadcrumb navigation for ease of use.
 * - Dynamic rendering of terms as navigation links and content.
 * - Bootstrap-based design for responsiveness and styling.
 * - Includes essential components like header, footer, and main navigation.
 */

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection and required layout files
include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");
?>

<div id="content"><!-- Content section start -->
    <div class="container"><!-- Container start -->
        <div class="col-md-12"><!-- Breadcrumb start -->
            <ul class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Terms</li>
            </ul>
        </div><!-- Breadcrumb end -->
    </div>
</div>

<div id="content"><!-- Main content section start -->
    <div class="container"><!-- Container start -->
        <div class="col-md-3"><!-- Sidebar start -->
            <div class="box"><!-- Box start -->
                <ul class="nav nav-pills nav-stacked"><!-- Navigation pills start -->
                    <?php
                    // Fetch the first term for default active tab
                    $get_terms = "SELECT * FROM terms LIMIT 0,1";
                    $run_terms = mysqli_query($con, $get_terms);

                    if (!$run_terms) {
                        echo "<div class='alert alert-danger'>Error fetching terms from the database.</div>";
                    } else {
                        while ($row_terms = mysqli_fetch_array($run_terms)) {
                            $term_title = $row_terms['term_title'];
                            $term_link = $row_terms['term_link'];
                            ?>
                            <li class="active">
                                <!-- Set the first term as active -->
                                <a data-toggle="pill" href="#<?php echo $term_link; ?>">
                                    <?php echo $term_title; ?>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php
                    // Fetch remaining terms for navigation
                    $count_terms = "SELECT * FROM terms";
                    $run_count = mysqli_query($con, $count_terms);
                    if (!$run_count) {
                        echo "<div class='alert alert-danger'>Error fetching the count of terms from the database.</div>";
                    } else {
                        $count = mysqli_num_rows($run_count);

                        $get_terms = "SELECT * FROM terms LIMIT 1,$count";
                        $run_terms = mysqli_query($con, $get_terms);

                        if (!$run_terms) {
                            echo "<div class='alert alert-danger'>Error fetching additional terms from the database.</div>";
                        } else {
                            while ($row_terms = mysqli_fetch_array($run_terms)) {
                                $term_title = $row_terms['term_title'];
                                $term_link = $row_terms['term_link'];
                                ?>
                                <li>
                                    <a data-toggle="pill" href="#<?php echo $term_link; ?>">
                                        <?php echo $term_title; ?>
                                    </a>
                                </li>
                            <?php }
                        }
                    }
                    ?>
                </ul><!-- Navigation pills end -->
            </div><!-- Box end -->
        </div><!-- Sidebar end -->

        <div class="col-md-9"><!-- Main content section start -->
            <div class="box"><!-- Box start -->
                <div class="tab-content"><!-- Tab content start -->
                    <?php
                    // Fetch the first term content for default active tab
                    $get_terms = "SELECT * FROM terms LIMIT 0,1";
                    $run_terms = mysqli_query($con, $get_terms);

                    if (!$run_terms) {
                        echo "<div class='alert alert-danger'>Error fetching the first term content from the database.</div>";
                    } else {
                        while ($row_terms = mysqli_fetch_array($run_terms)) {
                            $term_title = $row_terms['term_title'];
                            $term_desc = $row_terms['term_desc'];
                            $term_link = $row_terms['term_link'];
                            ?>
                            <div id="<?php echo $term_link; ?>" class="tab-pane fade in active">
                                <h1><?php echo $term_title; ?></h1>
                                <p><?php echo $term_desc; ?></p>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <?php
                    // Fetch remaining term content for other tabs
                    $get_terms = "SELECT * FROM terms LIMIT 1,$count";
                    $run_terms = mysqli_query($con, $get_terms);

                    if (!$run_terms) {
                        echo "<div class='alert alert-danger'>Error fetching additional term content from the database.</div>";
                    } else {
                        while ($row_terms = mysqli_fetch_array($run_terms)) {
                            $term_title = $row_terms['term_title'];
                            $term_desc = $row_terms['term_desc'];
                            $term_link = $row_terms['term_link'];
                            ?>
                            <div id="<?php echo $term_link; ?>" class="tab-pane fade in">
                                <h1><?php echo $term_title; ?></h1>
                                <p><?php echo $term_desc; ?></p>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div><!-- Tab content end -->
            </div><!-- Box end -->
        </div><!-- Main content section end -->
    </div><!-- Container end -->
</div><!-- Main content section end -->

<!-- Footer include -->
<?php include("includes/footer.php"); ?>
