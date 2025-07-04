<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login.php','_self')</script>";
} else {
    include("includes/db.php"); // Ensure you include your database connection file

    // Check if slide ID is set
    if(isset($_GET['edit_slide'])){
        $slide_id = $_GET['edit_slide'];

        // Fetch the slide details
        $get_slide = "SELECT * FROM slider WHERE id='$slide_id'";
        $run_slide = mysqli_query($con, $get_slide);
        $row_slide = mysqli_fetch_array($run_slide);

        $slide_name = $row_slide['slider_name'];
        $slide_image = $row_slide['slider_image'];
        $slide_url = $row_slide['slider_url'];
        $slide_season = $row_slide['slider_season'];
        $slide_text = $row_slide['slider_text'];
    }
?>

<div class="row"><!--row-1 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <ol class="breadcrumb"><!--breadcrumb start-->
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Edit Slide
            </li>
        </ol><!--breadcrumb end-->
    </div><!--col-lg-12 end-->
</div><!--row-1 end-->

<div class="row"><!--row-2 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <div class="panel panel-default"><!--panel panel-default start-->
            <div class="panel-heading"><!--panel-heading start-->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Edit Slide
                </h3>
            </div><!--panel-heading end-->

            <div class="panel-body"><!--panel-body start-->
                <form action="" method="post" class="form-horizontal" enctype="multipart/form-data"><!--form-horizontal start-->
                    <div class="form-group"><!--form-group-1 start-->
                        <label class="col-md-3 control-label">Slide Name</label>
                        <div class="col-md-6"><!--col-md-6 start-->
                            <input type="text" name="slide_name" class="form-control" value="<?php echo $slide_name; ?>" required>
                        </div><!--col-md-6 end-->
                    </div><!--form-group-1 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Slide Url</label>
                        <div class="col-md-6"><!--col-md-6 start-->
                            <input type="text" name="slide_url" class="form-control" value="<?php echo $slide_url; ?>">
                        </div><!--col-md-6 end-->
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Slide Season</label>
                        <div class="col-md-6"><!--col-md-6 start-->
                            <input type="text" name="slide_season" class="form-control" value="<?php echo $slide_season; ?>">
                        </div><!--col-md-6 end-->
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Slide Text</label>
                        <div class="col-md-6"><!--col-md-6 start-->
                            <input type="text" name="slide_text" class="form-control" value="<?php echo $slide_text; ?>">
                        </div><!--col-md-6 end-->
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-3 start-->
                        <label class="col-md-3 control-label">Slide Image</label>
                        <div class="col-md-6"><!--col-md-6 start-->
                            <input type="file" name="slide_image" class="form-control">
                            <br>
                            <img src="slider_images/<?php echo $slide_image; ?>" width="100" alt="Current Image">
                        </div><!--col-md-6 end-->
                    </div><!--form-group-3 end-->

                    <div class="form-group"><!--form-group-4 start-->
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                            <input type="submit" name="update_slide" value="Update Slide" class="btn btn-primary form-control">
                        </div>
                    </div><!--form-group-4 end-->

                </form><!--form-horizontal end-->
            </div><!--panel-body end-->
        </div><!--panel panel-default end-->
    </div><!--col-lg-12 end-->
</div><!--row-2 end-->

<?php
if(isset($_POST['update_slide'])){
    $new_slide_name = $_POST['slide_name'];
    $new_slide_url = $_POST['slide_url'];
    $new_slide_season = $_POST['slide_season'];
    $new_slide_text = $_POST['slide_text'];
    $new_slide_image = $_FILES['slide_image']['name'];
    $temp_name = $_FILES['slide_image']['tmp_name'];

    // Prepare the update query
    if(!empty($new_slide_image)){
        // If a new image is uploaded, move it to the directory and update the record
        move_uploaded_file($temp_name, "slider_images/$new_slide_image");
        $update_slide = "UPDATE slider SET slider_name='$new_slide_name', slider_url='$new_slide_url', slider_image='$new_slide_image', slider_season='$new_slide_season', slider_text='$new_slide_text' WHERE id='$slide_id'";
    } else {
        // If no new image is uploaded, keep the old image in the database
        $update_slide = "UPDATE slider SET slider_name='$new_slide_name', slider_url='$new_slide_url', slider_season='$new_slide_season', slider_text='$new_slide_text' WHERE id='$slide_id'";
    }

    // Execute the update query
    $run_update = mysqli_query($con, $update_slide);
    if($run_update){
        echo "<script>alert('Slide has been updated successfully.')</script>";
        echo "<script>window.open('index.php?view_slider','_self')</script>";
    } else {
        echo "<script>alert('Error updating slide. Please try again.')</script>";
    }
}
?>

<?php } ?>
