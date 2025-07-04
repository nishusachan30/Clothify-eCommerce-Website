<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    if (isset($_GET['edit_p_cat'])) {
        $edit_p_cat_id = $_GET['edit_p_cat'];
        $edit_p_cat_query = "SELECT * FROM product_category WHERE p_cat_id='$edit_p_cat_id'";
        $run_edit = mysqli_query($con, $edit_p_cat_query);
        $row_edit = mysqli_fetch_array($run_edit);
        $p_cat_id = $row_edit['p_cat_id'];
        $p_cat_title = $row_edit['p_cat_title'];
        $p_cat_desc = $row_edit['p_cat_desc'];
        $cat_id = $row_edit['cat_id']; // Fetch the current cat_id for the product category
    }
?>

<div class="row"><!--row-1 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <ol class="breadcrumb"><!--breadcrumb start-->
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Edit Product Category
            </li>
        </ol><!--breadcrumb end-->
    </div><!--col-lg-12 end-->
</div><!--row-1 end-->

<div class="row"><!--row-2 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <div class="panel panel-default"><!--panel panel-default start-->
            <div class="panel-heading"><!--panel-heading start-->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i>Edit Product Category
                </h3>
            </div><!--panel-heading end-->
            <div class="panel-body"><!--panel-body start-->
                <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <!--form-horizontal start-->
                    <div class="form-group"><!--form-group-1 start-->
                        <label class="col-md-3 control-label">Product Category Title</label>
                        <div class="col-md-6"><!--col-md-6 start-->
                            <input type="text" name="p_cat_title" class="form-control" value="<?php echo $p_cat_title; ?>">
                        </div><!--col-md-6 end-->
                    </div><!--form-group-1 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Product Category Description</label>
                        <div class="col-md-6"><!--col-md-6 start-->
                            <textarea name="p_cat_desc" type="text" class="form-control"><?php echo $p_cat_desc; ?></textarea>
                        </div><!--col-md-6 end-->
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-3 start-->
                        <label class="col-md-3 control-label">Gender</label>
                        <div class="col-md-6"><!--col-md-6 start-->
                            <select name="cat_id" class="form-control">
                                <option value="">Select Category</option>
                                <?php
                                // Fetching categories to populate the dropdown
                                $get_categories = "SELECT * FROM categories";
                                $run_categories = mysqli_query($con, $get_categories);
                                while ($row_category = mysqli_fetch_array($run_categories)) {
                                    $cat_id_option = $row_category['cat_id'];
                                    $cat_title_option = $row_category['cat_title'];
                                    // Check if this category is the current one and mark it as selected
                                    $selected = ($cat_id == $cat_id_option) ? 'selected' : '';
                                    echo "<option value='$cat_id_option' $selected>$cat_title_option</option>";
                                }
                                ?>
                            </select>
                        </div><!--col-md-6 end-->
                    </div><!--form-group-3 end-->

                    <div class="form-group"><!--form-group-4 start-->
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                            <input type="submit" name="update" value="Update Product Category" class="btn btn-primary form-control">
                        </div>
                    </div><!--form-group-4 end-->

                </form><!--form-horizontal end-->
            </div><!--panel-body end-->
        </div><!--panel panel-default end-->
    </div><!--col-lg-12 end-->
</div><!--row-2 end-->

<?php
if (isset($_POST['update'])) {
    $p_cat_title = $_POST['p_cat_title'];
    $p_cat_desc = $_POST['p_cat_desc'];
    $cat_id = $_POST['cat_id']; // Get the selected cat_id from the dropdown

    $update_p_cat = "UPDATE product_category SET p_cat_title='$p_cat_title', p_cat_desc='$p_cat_desc', cat_id='$cat_id' WHERE p_cat_id='$p_cat_id'";

    $run_product = mysqli_query($con, $update_p_cat);

    if ($run_product) {
        echo "<script> alert('Product Category has been updated') </script>";
        echo "<script> window.open('index.php?view_product_cat', '_self') </script>";
    }
}
?>

<?php } ?>
