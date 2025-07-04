<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script> window.open('login.php','_self' </script>";
}else{
?>
<div class="row"><!--row-1 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <ol class="breadcrumb"><!--breadcrumb start-->
            <li>
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ Insert Slider
            </li>
        </ol><!--breadcrumb end-->
    </div><!--col-lg-12 end-->
</div><!--row-1 end-->

<div class="row"><!--row-2 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <div class="panel panel-default"><!--panel panel-heading start-->
            <div class="panel-heading"><!--panel-heading start-->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Insert Slide
                </h3>
            </div><!--panel-heading end-->

            <div class="panel-body"><!--panel-body start-->
                <form action="" method="post" class="form-horizontal" enctype="multipart/form-data"><!--form-horizontal start-->
                    <div class="form-group"><!--form-group-1 start-->
                        <label class="col-md-3 control-label">Slide Name: </label>
                        <div class="col-md-6">
                            <input type="text" name="slider_name" class="form-control">
                        </div>
                    </div><!--form-group-1 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Slide Url: </label>
                        <div class="col-md-6">
                            <input type="text" name="slider_url" class="form-control">
                        </div>
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-3 start-->
                        <label class="col-md-3 control-label">Slider Image: </label>
                        <div class="col-md-6">
                        <input type="file" name="slider_image" class="form-control">
                        </div>
                    </div><!--form-group-3 end-->

                    <div class="form-group"><!--form-group-3 start-->
                        <label class="col-md-3 control-label">Slider Season: </label>
                        <div class="col-md-6">
                        <input type="text" name="slider_season" class="form-control">
                        </div>
                    </div><!--form-group-3 end-->

                    <div class="form-group"><!--form-group-3 start-->
                        <label class="col-md-3 control-label">Slider Text: </label>
                        <div class="col-md-6">
                        <input type="text" name="slider_text" class="form-control">
                        </div>
                    </div><!--form-group-3 end-->

                    <div class="form-group"><!--form-group-3 start-->
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                            <input type="submit" name="submit" value="Insert Slide" class="btn btn-primary form-control">
                        </div>
                    </div><!--form-group-3 end-->
                </form><!--form-horizontal end-->
            </div><!--panel-body end-->
        </div><!--panel panel-heading end-->
    </div><!--col-lg-12 end-->
</div><!--row-2 end-->


<?php
if(isset($_POST['submit'])){
    $slide_name = $_POST['slider_name'];
    $slide_url = $_POST['slider_url'];
    $slide_season = $_POST['slider_season'];
    $slide_text = $_POST['slider_text'];
    $slide_image = $_FILES['slider_image']['name'];
    $temp_name = $_FILES['slider_image']['tmp_name'];
    
    // Fetch all slides
    $view_slides = "select * from slider";
    $view_run_slides = mysqli_query($con, $view_slides);
    $count = mysqli_num_rows($view_run_slides);
    
    // Only allow slide insertion if there are fewer than 4 slides
    if($count < 4){
        move_uploaded_file($temp_name, "slider_images/$slide_image");
        
        // Insert the slide into the database
        $insert_slide = "insert into slider (slider_name, slider_image, slider_season, slider_text) values('$slide_name','$slide_url','$slide_image','$slider_season','$slider_text')";
        $run_slide = mysqli_query($con, $insert_slide);
        
        if($run_slide){
            echo "<script>alert('New Slide has been inserted');</script>";
            echo "<script>window.open('index.php?view_slider', '_self');</script>";
        }
    } else {
        // Display an error message if the limit is reached
        echo "<script>alert('Maximum number of slides (4) has already been reached');</script>";
    }
}
?>




<?php } ?>