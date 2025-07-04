<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php', '_self')</script>";
} else {
    ?>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i> <a href="index.php?dashboard">Dashboard</a> / Insert Product
                </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Insert Product</h3>
                </div>
                <div class="panel-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <!-- Product Title -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Title</label>
                            <div class="col-md-6">
                                <input type="text" name="product_title" class="form-control" required>
                            </div>
                        </div>

                        <!-- Product Category -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Category</label>
                            <div class="col-md-6">
                                <select name="product_cat" class="form-control" required>
                                    <option value="">Select a product category</option>
                                    <?php
                                    $get_p_cats = "SELECT * FROM product_category";
                                    $run_p_cats = mysqli_query($con, $get_p_cats);
                                    while ($row = mysqli_fetch_array($run_p_cats)) {
                                        echo "<option value='{$row['p_cat_id']}'>{$row['p_cat_title']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Category</label>
                            <div class="col-md-6">
                                <select name="cat" class="form-control" required>
                                    <option value="">Select category</option>
                                    <?php
                                    $get_cats = "SELECT * FROM categories";
                                    $run_cats = mysqli_query($con, $get_cats);
                                    while ($row = mysqli_fetch_array($run_cats)) {
                                        echo "<option value='{$row['cat_id']}'>{$row['cat_title']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Manufacturer -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Manufacturer</label>
                            <div class="col-md-6">
                                <select name="manufacturer" class="form-control" required>
                                    <option value="">Select Manufacturer</option>
                                    <?php
                                    $get_man = "SELECT * FROM manufacturers";
                                    $run_man = mysqli_query($con, $get_man);
                                    while ($row = mysqli_fetch_array($run_man)) {
                                        echo "<option value='{$row['manufacturer_id']}'>{$row['manufacturer_title']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Product Images -->
                        <?php
                        $image_labels = ['Product Image 1', 'Product Image 2', 'Product Image 3'];
                        for ($i = 1; $i <= 3; $i++) { ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?= $image_labels[$i - 1] ?></label>
                                <div class="col-md-6">
                                    <input type="file" name="product_img<?= $i ?>" class="form-control" required>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Product Price -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Price</label>
                            <div class="col-md-6">
                                <input type="number" name="product_price" class="form-control" required>
                            </div>
                        </div>

                        <!-- Product MRP -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product MRP</label>
                            <div class="col-md-6">
                                <input type="number" name="product_mrp" class="form-control" required>
                            </div>
                        </div>

                        <!-- Product Label -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Label</label>
                            <div class="col-md-6">
                                <input type="text" name="product_label" class="form-control" required>
                            </div>
                        </div>

                        <!-- Product Availability -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Availability</label>
                            <div class="col-md-6">
                                <input type="number" name="product_availability" class="form-control" required>
                            </div>
                        </div>

                        <!-- Product Keyword -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Keyword</label>
                            <div class="col-md-6">
                                <input type="text" name="product_keyword" class="form-control" required>
                            </div>
                        </div>

                        <!-- Product Description -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Description</label>
                            <div class="col-md-6">
                                <textarea name="product_desc" class="form-control" rows="6"></textarea>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-6">
                                <input type="submit" name="submit" value="Insert Product" class="btn btn-primary form-control">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $product_title = $_POST['product_title'];
        $product_cat = $_POST['product_cat'];
        $cat = $_POST['cat'];
        $product_price = $_POST['product_price'];
        $product_desc = $_POST['product_desc'];
        $product_keyword = $_POST['product_keyword'];
        $product_mrp = $_POST['product_mrp'];
        $product_label = $_POST['product_label'];
        $manufacturer = $_POST['manufacturer'];
        $product_availability = $_POST['product_availability'];

        // Allowed image formats
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];

        $images = [];
        for ($i = 1; $i <= 3; $i++) {
            $file = $_FILES["product_img$i"];
            if (!in_array($file['type'], $allowed_types)) {
                echo "<script>alert('Invalid file format for Product Image $i')</script>";
                exit;
            }
            $file_name = $file['name'];
            $temp_name = $file['tmp_name'];
            move_uploaded_file($temp_name, "product_images/$file_name");
            $images[] = $file_name;
        }

        // Insert product into database
        $insert_product = "INSERT INTO products (p_cat_id, cat_id, p_date, product_title, product_img1, product_img2, product_img3, product_price, product_desc, product_keyword, mrp, product_label, product_availability, manufacturer_id) 
        VALUES ('$product_cat', '$cat', NOW(), '$product_title', '$images[0]', '$images[1]', '$images[2]', '$product_price', '$product_desc', '$product_keyword', '$product_mrp', '$product_label', '$product_availability', '$manufacturer')";

        if (mysqli_query($con, $insert_product)) {
            echo "<script>alert('Product inserted successfully!')</script>";
            echo "<script>window.open('index.php?insert_product', '_self')</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "')</script>";
        }
    }
    ?>

<?php } ?>
