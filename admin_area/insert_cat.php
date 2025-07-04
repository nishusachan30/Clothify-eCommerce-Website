<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script> window.open('login.php','_self' </script>";
}else{
?>
<div class="row"><!--row-1 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <ol class="breadcrumb"><!--breadcrumb start-->
            <li class="active">
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ Insert Category
            </li>
        </ol><!--breadcrumb end-->
    </div><!--col-lg-12 end-->
</div><!--row-1 end-->

<div class="row"><!--row-2 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <div class="panel panel-default"><!--panel panel-heading start-->
            <div class="panel-heading"><!--panel-heading start-->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Insert Category
                </h3>
            </div><!--panel-heading end-->

            <div class="panel-body"><!--panel-body start-->
                <form action="" method="post" class="form-horizontal"><!--form-horizontal start-->
                    <div class="form-group"><!--form-group-1 start-->
                        <label class="col-md-3 control-label">Category Title</label>
                        <div class="col-md-6">
                            <input type="text" name="cat_title" class="form-control">
                        </div>
                    </div><!--form-group-1 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Category Description</label>
                        <div class="col-md-6">
                            <textarea name="cat_desc" type="text" class="form-control"></textarea>
                        </div>
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-3 start-->
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                            <input type="submit" name="submit" value="Insert Category" class="btn btn-primary form-control">
                        </div>
                    </div><!--form-group-3 end-->
                </form><!--form-horizontal end-->
            </div><!--panel-body end-->
        </div><!--panel panel-heading end-->
    </div><!--col-lg-12 end-->
</div><!--row-2 end-->

<?php
if(isset($_POST['submit'])){
    $cat_title=$_POST['cat_title'];
    $cat_desc=$_POST['cat_desc'];
    $insert_cat="insert into categories (cat_title, cat_desc) values('$cat_title','$cat_desc')";
    $run_cat=mysqli_query($con, $insert_cat);

    if($run_cat){
        echo "<script> alert('New Category has been inserted') </script>";
        echo "<script> window.open('index.php?insert_categories','_self') </script>";
    }
}

?>

<?php } ?>