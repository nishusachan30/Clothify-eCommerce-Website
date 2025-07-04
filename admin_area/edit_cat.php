<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    ?>
    <?php
    if (isset($_GET['edit_cat'])) {
        $edit_cat_id = $_GET['edit_cat'];
        $edit_cat_query = "select * from categories where cat_id='$edit_cat_id'";
        $run_edit = mysqli_query($con, $edit_cat_query);
        $row_edit = mysqli_fetch_array($run_edit);
        $cat_id = $row_edit['cat_id'];
        $cat_title = $row_edit['cat_title'];
        $cat_desc = $row_edit['cat_desc'];
    }
    ?>

    <div class="row"><!--row-1 start-->
        <div class="col-lg-12"><!--col-lg-12 start-->
            <ol class="breadcrumb"><!--breadcrumb start-->
                <li class="active">
                    <i class="fa fa-dashboard"></i><a href="index.php?dashboard">Dashboard </a> / Edit Category
                </li>
            </ol><!--breadcrumb end-->
        </div><!--col-lg-12 end-->
    </div><!--row-1 end-->

    <div class="row"><!--row-2 start-->
        <div class="col-lg-12"><!--col-lg-12 start-->
            <div class="panel panel-default"><!--panel panel-default start-->
                <div class="panel-heading"><!--panel-heading start-->
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i>Edit Category
                    </h3>
                </div><!--panel-heading end-->
                <div class="panel-body"><!--panel-body start-->
                    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <!--form-horizontal start-->
                        <div class="form-group"><!--form-group-1 start-->
                            <label class="col-md-3 control-label">Category Title</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <input type="text" name="cat_title" class="form-control" value="<?php echo $cat_title; ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-1 end-->

                        <div class="form-group"><!--form-group-2 start-->
                            <label class="col-md-3 control-label">Category Description</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <textarea name="cat_desc" type="text" class="form-control">
                                        <?php echo $cat_desc; ?>
                                    </textarea>
                            </div><!--col-md-6 end-->
                        </div><!--form-group-2 end-->

                        <div class="form-group"><!--form-group-3 start-->
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-6">
                                <input type="submit" name="update" value="Update Category"
                                    class="btn btn-primary form-control">
                            </div>
                        </div><!--form-group-3 end-->

                    </form><!--form-horizontal end-->
                </div><!--panel-body end-->
            </div><!--panel panel-default end-->
        </div><!--col-lg-12 end-->
    </div><!--row-2 end-->


    <?php
    if (isset($_POST['update'])) {
        $cat_title = $_POST['cat_title'];
        $cat_desc = $_POST['cat_desc'];

        $update_cat = "update categories set cat_title='$cat_title',cat_desc='$cat_desc' where cat_id='$cat_id' ";

        $run_product = mysqli_query($con, $update_cat);

        if ($run_product) {
            echo "<script> alert('Category has been updated') </script>";
            echo "<script> window.open('index.php?view_categories', '_self') </script>";
        }
    }
    ?>


<?php } ?>