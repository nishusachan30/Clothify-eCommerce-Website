<?php
/**
 * policy and Conditions Page
 * 
 * This script displays the policy and Conditions section of the website. It dynamically fetches
 * policy and their descriptions from the database and displays them in a tabbed layout for user-friendly navigation.
 * 
 * Features:
 * - Breadcrumb navigation for ease of use.
 * - Dynamic rendering of policy as navigation links and content.
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
                <li>Policies</li>
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
                    $get_policy = "SELECT * FROM policy_details LIMIT 0,1";
                    $run_policy = mysqli_query($con, $get_policy);

                    if (!$run_policy) {
                        echo "<script>alert('Error fetching policy data. Please try again later.');</script>";
                        exit;
                    }

                    if (mysqli_num_rows($run_policy) > 0) {
                        while ($row_policy = mysqli_fetch_array($run_policy)) {
                            $policy_title = $row_policy['policy_title'];
                            $policy_link = $row_policy['policy_link'];
                            ?>
                            <li class="active">
                                <!-- Set the first term as active -->
                                <a data-toggle="pill" href="#<?php echo $policy_link; ?>">
                                    <?php echo $policy_title; ?>
                                </a>
                            </li>
                        <?php }
                    } else {
                        echo "<script>alert('No policies found.'); window.history.back();</script>";
                        exit;
                    }

                    // Fetch remaining policy for navigation
                    $count_policy = "SELECT * FROM policy_details";
                    $run_count = mysqli_query($con, $count_policy);

                    if (!$run_count) {
                        echo "<script>alert('Error counting policy entries.');</script>";
                        exit;
                    }

                    $count = mysqli_num_rows($run_count);

                    $get_policy = "SELECT * FROM policy_details LIMIT 1,$count";
                    $run_policy = mysqli_query($con, $get_policy);

                    if (!$run_policy) {
                        echo "<script>alert('Error fetching policies for navigation.');</script>";
                        exit;
                    }

                    while ($row_policy = mysqli_fetch_array($run_policy)) {
                        $policy_title = $row_policy['policy_title'];
                        $policy_link = $row_policy['policy_link'];
                        ?>
                        <li>
                            <a data-toggle="pill" href="#<?php echo $policy_link; ?>">
                                <?php echo $policy_title; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul><!-- Navigation pills end -->
            </div><!-- Box end -->
        </div><!-- Sidebar end -->

        <div class="col-md-9"><!-- Main content section start -->
            <div class="box"><!-- Box start -->
                <div class="tab-content"><!-- Tab content start -->
                    <?php
                    // Fetch the first term content for default active tab
                    $get_policy = "SELECT * FROM policy_details LIMIT 0,1";
                    $run_policy = mysqli_query($con, $get_policy);

                    if (!$run_policy) {
                        echo "<script>alert('Error fetching policy data. Please try again later.');</script>";
                        exit;
                    }

                    if (mysqli_num_rows($run_policy) > 0) {
                        while ($row_policy = mysqli_fetch_array($run_policy)) {
                            $policy_title = $row_policy['policy_title'];
                            $policy_desc = $row_policy['policy_desc'];
                            $policy_link = $row_policy['policy_link'];
                            $policy_version = $row_policy['policy_version'];
                            $effective_date = $row_policy['effective_date'];
                            ?>
                            <div id="<?php echo $policy_link; ?>" class="tab-pane fade in active">
                                <h1><?php echo $policy_title; ?></h1>
                                <h4>Policy Version: <?php echo $policy_version; ?></h4>
                                <p>Policy Effective Date: <?php echo $effective_date; ?></p>
                                <p><?php echo $policy_desc; ?></p>
                            </div>
                        <?php }
                    } else {
                        echo "<script>alert('No policies available for display.');</script>";
                        exit;
                    }

                    // Fetch remaining term content for other tabs
                    $get_policy = "SELECT * FROM policy_details LIMIT 1,$count";
                    $run_policy = mysqli_query($con, $get_policy);

                    if (!$run_policy) {
                        echo "<script>alert('Error fetching policies for additional tabs.');</script>";
                        exit;
                    }

                    while ($row_policy = mysqli_fetch_array($run_policy)) {
                        $policy_title = $row_policy['policy_title'];
                        $policy_desc = $row_policy['policy_desc'];
                        $policy_link = $row_policy['policy_link'];
                        $policy_version = $row_policy['policy_version'];
                        $effective_date = $row_policy['effective_date'];
                        ?>
                        <div id="<?php echo $policy_link; ?>" class="tab-pane fade in">
                            <h1><?php echo $policy_title; ?></h1>
                            <h4>Policy Version: <?php echo $policy_version; ?></h4>
                            <p>Policy Effective Date: <?php echo $effective_date; ?></p>
                            <p><?php echo $policy_desc; ?></p>
                        </div>
                    <?php } ?>
                </div><!-- Tab content end -->
            </div><!-- Box end -->
        </div><!-- Main content section end -->
    </div><!-- Container end -->
</div><!-- Main content section end -->

<!-- Footer include -->
<?php include("includes/footer.php"); ?>
