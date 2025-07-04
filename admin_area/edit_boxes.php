<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    ?>
    <?php
    if (isset($_GET['edit_boxes'])) {
        $edit_box_id = $_GET['edit_boxes'];
        $edit_box_query = "select * from boxes_section where box_id='$edit_box_id'";
        $run_edit = mysqli_query($con, $edit_box_query);
        $row_edit = mysqli_fetch_array($run_edit);
        $box_id = $row_edit['box_id'];
        $box_title = $row_edit['box_title'];
        $box_desc = $row_edit['box_desc'];
        $box_icon = $row_edit['box_icon'];
    }
    ?>

    <div class="row"><!--row-1 start-->
        <div class="col-lg-12"><!--col-lg-12 start-->
            <ol class="breadcrumb"><!--breadcrumb start-->
                <li class="active">
                    <i class="fa fa-dashboard"></i><a href="index.php?dashboard">Dashboard </a> / Edit Box
                </li>
            </ol><!--breadcrumb end-->
        </div><!--col-lg-12 end-->
    </div><!--row-1 end-->

    <div class="row"><!--row-2 start-->
        <div class="col-lg-12"><!--col-lg-12 start-->
            <div class="panel panel-default"><!--panel panel-default start-->
                <div class="panel-heading"><!--panel-heading start-->
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i>Edit Box
                    </h3>
                </div><!--panel-heading end-->
                <div class="panel-body"><!--panel-body start-->
                    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <!--form-horizontal start-->
                        <div class="form-group"><!--form-group-1 start-->
                            <label class="col-md-3 control-label">Box Title</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <input type="text" name="box_title" class="form-control" value="<?php echo $box_title; ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-1 end-->

                        <div class="form-group"><!--form-group-2 start-->
                            <label class="col-md-3 control-label">Box Description</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <textarea name="box_desc" type="text" class="form-control">
                                            <?php echo $box_desc; ?>
                                        </textarea>
                            </div><!--col-md-6 end-->
                        </div><!--form-group-2 end-->

                        <div class="form-group"><!--form-group-3 start-->
                            <label class="col-md-3 control-label">Box Icon</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <input name="box_icon" type="text" class="form-control">
                                <?php echo $box_icon; ?>
                                </input>
                            </div><!--col-md-6 end-->
                        </div><!--form-group-3 end-->

                        <div class="form-group"><!--form-group-4 start-->
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-6">
                                <input type="submit" name="update" value="Update Box" class="btn btn-primary form-control">
                            </div>
                        </div><!--form-group-4 end-->

                    </form><!--form-horizontal end-->
                </div><!--panel-body end-->
            </div><!--panel panel-default end-->
        </div><!--col-lg-12 end-->
    </div><!--row-2 end-->


    <?php
    if (isset($_POST['update'])) {
        $box_title = $_POST['box_title'];
        $box_desc = $_POST['box_desc'];
        $box_icon = $_POST['box_icon'];

        $update_box = "update boxes_section set box_title='$box_title',box_desc='$box_desc', box_icon='$box_icon' where box_id='$box_id' ";

        $run_box = mysqli_query($con, $update_box);

        if ($run_box) {
            echo "<script> alert('Box has been updated') </script>";
            echo "<script> window.open('index.php?view_boxes', '_self') </script>";
        }
    }
    ?>


<?php } ?>