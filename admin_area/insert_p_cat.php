<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script> window.open('login.php', '_self'); </script>";
} else {
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a> / Insert Products Category
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Insert Product Category
                </h3>
            </div>

            <div class="panel-body">
                <form action="" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Category Title</label>
                        <div class="col-md-6">
                            <input type="text" name="p_cat_title" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Category Description</label>
                        <div class="col-md-6">
                            <textarea name="p_cat_desc" class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- Category Dropdown -->
                    <div class="form-group">
                        <label class="col-md-3 control-label">Select Category</label>
                        <div class="col-md-6">
                            <select name="cat_id" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php
                                // Fetch categories from the database
                                $get_cats = "SELECT * FROM categories";
                                $run_cats = mysqli_query($con, $get_cats);

                                while ($row_cats = mysqli_fetch_array($run_cats)) {
                                    $cat_id = $row_cats['cat_id'];
                                    $cat_title = $row_cats['cat_title'];
                                    echo "<option value='$cat_id'>$cat_title</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                            <input type="submit" name="submit" value="Insert Product Category" class="btn btn-primary form-control">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $p_cat_title = $_POST['p_cat_title'];
    $p_cat_desc = $_POST['p_cat_desc'];
    $cat_id = $_POST['cat_id'];

    $insert_p_cat = "INSERT INTO product_category (p_cat_title, p_cat_desc, cat_id) VALUES ('$p_cat_title', '$p_cat_desc', '$cat_id')";
    $run_p_cat = mysqli_query($con, $insert_p_cat);

    if ($run_p_cat) {
        echo "<script>alert('New Product Category has been Inserted')</script>";
        echo "<script>window.open('index.php?insert_product_cat', '_self')</script>";
    }
}
?>

<?php } ?>
