<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script> window.open('login.php','_self' </script>";
}else{
?>
<div class="row"><!--row-1 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <ol class="breadcrumb"><!--breadcrumb start-->
            <li class="active">
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ Insert Boxes
            </li>
        </ol><!--breadcrumb end-->
    </div><!--col-lg-12 end-->
</div><!--row-1 end-->

<div class="row"><!--row-2 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <div class="panel panel-default"><!--panel panel-heading start-->
            <div class="panel-heading"><!--panel-heading start-->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Insert Title
                </h3>
            </div><!--panel-heading end-->

            <div class="panel-body"><!--panel-body start-->
                <form action="" method="post" class="form-horizontal"><!--form-horizontal start-->
                    <div class="form-group"><!--form-group-1 start-->
                        <label class="col-md-3 control-label">Box Title</label>
                        <div class="col-md-6">
                            <input type="text" name="box_title" class="form-control">
                        </div>
                    </div><!--form-group-1 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Box Description</label>
                        <div class="col-md-6">
                            <textarea name="box_desc" type="text" class="form-control"></textarea>
                        </div>
                    </div><!--form-group-2 end-->
                    <div class="form-group"><!--form-group-3 start-->
                        <label class="col-md-3 control-label">Box Icon</label>
                        <div class="col-md-6">
                            <input name="box_icon" type="text" class="form-control"></input>
                        </div>
                    </div><!--form-group-3 end-->

                    <div class="form-group"><!--form-group-4 start-->
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                            <input type="submit" name="submit" value="Insert Box" class="btn btn-primary form-control">
                        </div>
                    </div><!--form-group-4 end-->
                </form><!--form-horizontal end-->
            </div><!--panel-body end-->
        </div><!--panel panel-heading end-->
    </div><!--col-lg-12 end-->
</div><!--row-2 end-->

<?php
if(isset($_POST['submit'])){
    $box_title=$_POST['box_title'];
    $box_desc=$_POST['box_desc'];
    $box_icon=$_POST['box_icon'];
    $insert_box="insert into boxes_section (box_title, box_desc, box_icon) values('$box_title','$box_desc','$box_icon')";
    $run_box=mysqli_query($con, $insert_box);

    if($run_box){
        echo "<script> alert('New Box has been inserted') </script>";
        echo "<script> window.open('index.php?insert_boxes','_self') </script>";
    }
}

?>

<?php } ?>