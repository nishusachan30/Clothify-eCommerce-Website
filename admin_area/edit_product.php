<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login.php','_self')</script>";
}else{
?>
<?php
    if(isset($_GET['edit_product'])){
        $edit_id= $_GET['edit_product'];
        $get_p="select * from products where product_id='$edit_id'";
        $run_edit=mysqli_query($con, $get_p);
        $row_edit=mysqli_fetch_array($run_edit);
        $p_id=$row_edit['product_id'];
        $p_title=$row_edit['product_title'];
        $p_cat=$row_edit['p_cat_id'];
        $cat=$row_edit['cat_id'];
        $p_image1=$row_edit['product_img1'];
        $p_image2=$row_edit['product_img2'];
        $p_image3=$row_edit['product_img3'];
        $p_price=$row_edit['product_price'];
        $p_desc=$row_edit['product_desc'];
        $p_keywords=$row_edit['product_keyword'];
        $p_avail=$row_edit['product_availability'];
        $p_mrp=$row_edit['mrp'];
    }
    $get_p_cat="select * from product_category where p_cat_id='$p_cat'";
    $run_p_cat=mysqli_query($con, $get_p_cat);
    $row_p_cat=mysqli_fetch_array($run_p_cat);
    $p_cat_title=$row_p_cat['p_cat_title'];
    $get_cat="select * from categories where cat_id='$cat'";
    $run_cat=mysqli_query($con, $get_cat);
    $row_cat=mysqli_fetch_array($run_cat);
    $cat_title=$row_cat['cat_title'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Products</title>
    <script src="https://cdn.tiny.cloud/1/jhfvkn2bmbbiv96nqqkmdr9naukqn68wx5ywsxhaqgoqdxio/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
        });
    </script>
</head>
<body>
    <div class="row"><!--row-1 start-->
        <div class="col-lg-12"><!--col-lg-12 start-->
            <ol class="breadcrumb"><!--breadcrumb start-->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / Edit Products
                </li>
            </ol><!--breadcrumb end-->
        </div><!--col-lg-12 end-->
    </div><!--row-1 end-->

    <div class="row"><!--row-2 start-->
        <div class="col-lg-12"><!--col-lg-12 start-->
            <div class="panel panel-default"><!--panel panel-default start-->
                <div class="panel-heading"><!--panel-heading start-->
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i>Edit Products
                    </h3>
                </div><!--panel-heading end-->
                <div class="panel-body"><!--panel-body start-->
                    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data"><!--form-horizontal start-->
                        <div class="form-group"><!--form-group-1 start-->
                            <label class="col-md-3 control-label">Product Title</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <input type="text" name="product_title" class="form-control" required value="<?php echo $p_title ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-1 end-->

                        <div class="form-group"><!--form-group-2 start-->
                            <label class="col-md-3 control-label">Product Category</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <select name="product_cat" class="form-control">
                                    <option value="<?php echo $p_cat; ?>"> <?php echo $p_cat_title; ?></option>
                                    <?php
                                        $get_p_cats="select * from product_category";
                                        $run_p_cats=mysqli_query($con, $get_p_cats);
                                        while ($row_p_cats=mysqli_fetch_array($run_p_cats)){
                                            $p_cat_id=$row_p_cats['p_cat_id'];
                                            $p_cat_title=$row_p_cats['p_cat_title'];
                                            echo "<option value='$p_cat_id'>$p_cat_title </option>";
                                        }
                                    ?>
                                </select>
                            </div><!--col-md-6 end-->
                        </div><!--form-group-2 end-->

                        <div class="form-group"><!--form-group-3 start-->
                            <label for="" class="col-md-3 control-label">Category</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <select name="cat" class="form-control">
                                    <option value="<?php echo $cat; ?>"> <?php echo $cat_title; ?></option>
                                    <?php
                                        $get_cat="select * from categories";
                                        $run_cat=mysqli_query($con, $get_cat);
                                        while ($row_cat=mysqli_fetch_array($run_cat)){
                                            $cat_id=$row_cat['cat_id'];
                                            $cat_title=$row_cat['cat_title'];
                                            echo "<option value='$cat_id'>$cat_title </option>";
                                        }
                                    ?>
                                </select>
                            </div><!--col-md-6 end-->
                        </div><!--form-group-3 end-->

                        <div class="form-group"><!--form-group-4 start-->
                            <label for="" class="col-md-3 control-label">Product Image 1</label>
                            <div class="col-md-6"><!--col-md-6 start-->                               
                                <input type="file" name="product_img1" class="form-control">
                                <br><img src="product_images/<?php echo $p_image1; ?>" width="70" height="70">
                                <input type="hidden" name="existing_image1" value="<?php echo $p_image1; ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-4 end-->

                        <div class="form-group"><!--form-group-5 start-->
                            <label for="" class="col-md-3 control-label">Product Image 2</label>
                            <div class="col-md-6"><!--col-md-6 start-->                               
                                <input type="file" name="product_img2" class="form-control">
                                <br><img src="product_images/<?php echo $p_image2; ?>" width="70" height="70">
                                <input type="hidden" name="existing_image2" value="<?php echo $p_image2; ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-5 end-->

                        <div class="form-group"><!--form-group-6 start-->
                            <label for="" class="col-md-3 control-label">Product Image 3</label>
                            <div class="col-md-6"><!--col-md-6 start-->                               
                                <input type="file" name="product_img3" class="form-control">
                                <br><img src="product_images/<?php echo $p_image3; ?>" width="70" height="70">
                                <input type="hidden" name="existing_image3" value="<?php echo $p_image3; ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-6 end-->

                        <div class="form-group"><!--form-group-7 start-->
                            <label class="col-md-3 control-label">Product Price</label>
                            <div class="col-md-6">
                                <input type="text" name="product_price" class="form-control" value="<?php echo $p_price ?>" required>
                            </div>
                        </div><!--form-group-7 end-->
                        
                        <div class="form-group"><!--form-group-7 start-->
                            <label class="col-md-3 control-label">Product MRP</label>
                            <div class="col-md-6">
                                <input type="text" name="product_mrp" class="form-control" value="<?php echo $p_mrp ?>" required>
                            </div>
                        </div><!--form-group-7 end-->
                        
                        <div class="form-group"><!--form-group-7 start-->
                            <label class="col-md-3 control-label">Product Availability</label>
                            <div class="col-md-6">
                                <input type="text" name="product_availability" class="form-control" value="<?php echo $p_avail ?>" required>
                            </div>
                        </div><!--form-group-7 end-->

                        <div class="form-group"><!--form-group-8 start-->
                            <label class="col-md-3 control-label">Product Keywords</label>
                            <div class="col-md-6">
                                <input type="text" name="product_keyword" class="form-control" value="<?php echo $p_keywords; ?>" required>
                            </div>
                        </div><!--form-group-8 end-->

                        <div class="form-group"><!--form-group-9 start-->
                            <label class="col-md-3 control-label">Product Description</label>
                            <div class="col-md-6">
                                <textarea name="product_desc" class="form-control" rows="10" required><?php echo $p_desc; ?></textarea>
                            </div>
                        </div><!--form-group-9 end-->

                        <div class="form-group"><!--form-group-10 start-->
                            <div class="col-md-6 col-md-offset-3"><!--col-md-6 start-->
                                <input type="submit" name="update" value="Update Product" class="btn btn-primary form-control">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-10 end-->

                    </form><!--form-horizontal end-->
                </div><!--panel-body end-->
            </div><!--panel panel-default end-->
        </div><!--col-lg-12 end-->
    </div><!--row-2 end-->
</body>
</html>
<?php
if(isset($_POST['update'])){
    $product_title = $_POST['product_title'];
    $product_cat = $_POST['product_cat'];
    $cat = $_POST['cat'];
    $product_price = $_POST['product_price'];
    $product_mrp = $_POST['product_mrp'];
    $product_availability = $_POST['product_availability'];
    $product_keyword = $_POST['product_keyword'];
    $product_desc = $_POST['product_desc'];
    

    // Image upload handling
    $product_img1 = $_FILES['product_img1']['name'];
    $product_img2 = $_FILES['product_img2']['name'];
    $product_img3 = $_FILES['product_img3']['name'];
    
    $temp_name1 = $_FILES['product_img1']['tmp_name'];
    $temp_name2 = $_FILES['product_img2']['tmp_name'];
    $temp_name3 = $_FILES['product_img3']['tmp_name'];

    if(empty($product_img1)){
        $product_img1 = $_POST['existing_image1'];
    }
    if(empty($product_img2)){
        $product_img2 = $_POST['existing_image2'];
    }
    if(empty($product_img3)){
        $product_img3 = $_POST['existing_image3'];
    }

    // Move uploaded images to the correct directory
    move_uploaded_file($temp_name1, "product_images/$product_img1");
    move_uploaded_file($temp_name2, "product_images/$product_img2");
    move_uploaded_file($temp_name3, "product_images/$product_img3");

    // Update the product in the database
    $update_product = "update products set 
        product_title='$product_title',
        p_cat_id='$product_cat',
        cat_id='$cat',
        product_price='$product_price',
        mrp='$product_mrp',
        product_availability='$product_availability',
        product_img1='$product_img1',
        product_img2='$product_img2',
        product_img3='$product_img3',
        product_desc='$product_desc',
        product_keyword='$product_keyword'
        where product_id='$p_id'";

    $run_update = mysqli_query($con, $update_product);
    if($run_update){
        echo "<script>alert('Product has been updated successfully')</script>";
        echo "<script>window.open('index.php?view_product','_self')</script>";
    }
}
?>
<?php } ?>
