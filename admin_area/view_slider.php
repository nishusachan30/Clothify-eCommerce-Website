<?php
// Check if the admin session exists
if (!isset($_SESSION['admin_email'])) {
    echo "<script>alert('You are not logged in! Redirecting to login page.');</script>";
    echo "<script>window.open('login.php', '_self');</script>";
    exit();
} else {
    ?>

    <div class="row"><!--row-1 start-->
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ View Slider
                </li>
            </ol>
        </div>
    </div><!--row-1 end-->

    <div class="row"><!--row-2 start-->
        <div class="col-lg-12"><!--col-lg-12 start-->
            <div class="panel panel-default"><!--panel panel-default start-->
                <div class="panel-heading"><!--panel-heading start-->
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i> Slides
                    </h3>
                </div><!--panel-heading end-->

                <div class="panel-body"><!--panel-body start-->
                    <?php
                    // Fetch slides from the database
                    $get_slides = "SELECT * FROM slider";
                    $run_slides = mysqli_query($con, $get_slides);

                    if (!$run_slides) {
                        echo "<div class='alert alert-danger'>Error: Unable to fetch slides. " . mysqli_error($con) . "</div>";
                    } else {
                        if (mysqli_num_rows($run_slides) == 0) {
                            echo "<div class='alert alert-warning'>No slides found in the database.</div>";
                        } else {
                            while ($row_slides = mysqli_fetch_array($run_slides)) {
                                $slide_id = $row_slides['id'];
                                $slide_name = $row_slides['slider_name'];
                                $slide_image = $row_slides['slider_image'];
                                $slide_season = $row_slides['slider_season'];
                                $slide_text = $row_slides['slider_text'];
                                ?>

                                <div class="col-lg-3 col-md-3"><!--col-lg-3 start-->
                                    <div class="panel panel-primary"><!--panel panel-primary start-->
                                        <div class="panel-heading"><!--panel-heading start-->
                                            <h3 class="panel-title" align="center">
                                                <?php echo htmlspecialchars($slide_name); ?>
                                            </h3>
                                        </div><!--panel-heading end-->

                                        <div class="panel-body"><!--panel-body start-->
                                            <img src="slider_images/<?php echo htmlspecialchars($slide_image); ?>" class="img-responsive" alt="Slide Image">
                                        </div><!--panel-body end-->
                                        <div class="panel-body"><!--panel-body start-->
                                            <?php echo htmlspecialchars($slide_season); ?>
                                        </div><!--panel-body end-->
                                        <div class="panel-body"><!--panel-body start-->
                                            <?php echo htmlspecialchars($slide_text); ?>
                                        </div><!--panel-body end-->

                                        <div class="panel-footer"><!--panel-footer start-->
                                            <center>
                                                <a href="index.php?delete_slide=<?php echo $slide_id; ?>" class="pull-left">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </a>
                                                <a href="index.php?edit_slide=<?php echo $slide_id; ?>" class="pull-right">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <div class="clearfix"></div>
                                            </center>
                                        </div><!--panel-footer end-->
                                    </div><!--panel panel-primary end-->
                                </div><!--col-lg-3 end-->

                            <?php }
                        }
                    }
                    ?>
                </div> <!--panel-body ends-->
            </div><!--panel panel-default end-->
        </div><!--col-lg-12 end-->
    </div><!--row-2 end-->

<?php } ?>
