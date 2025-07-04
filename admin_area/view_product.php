<?php
include("includes/db.php");
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
?>

<div class="row"><!--row-1 start-->
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ View Product
            </li>
        </ol>
    </div>
</div><!--row-1 end-->

<div class="row"><!--row-2 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <div class="panel panel-default"><!--panel panel-default start-->
            <div class="panel-heading"><!--panel-heading start-->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i>Products
                </h3>
            </div><!--panel-heading end-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Title</th>
                                <th>Product Image</th>
                                <th>Product Price</th>
                                <th>Product MRP</th>
                                <th>Product Available</th>
                                <th>Manufacturer</th>
                                <th>Product Keyword</th>
                                <th>Product Insert Date</th>
                                <th>Gender</th> <!-- New Gender Column -->
                                <th>Product Delete</th>
                                <th>Product Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $get_product = "SELECT * FROM products";
                            $run_p = mysqli_query($con, $get_product);
                            while ($row = mysqli_fetch_array($run_p)) {
                                $pro_id = $row['product_id'];
                                $product_title = $row['product_title'];
                                $product_img1 = $row['product_img1'];
                                $product_price = $row['product_price'];
                                $product_keywords = $row['product_keyword'];
                                $date = $row['p_date'];
                                $product_mrp = $row['mrp'];
                                $manufacturer_id = $row['manufacturer_id'];
                                $product_availability = $row['product_availability'];
                                $cat_id = $row['cat_id']; // Fetching cat_id

                                // Fetching manufacturer name
                                $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
                                $run_manufacturer = mysqli_query($con, $get_manufacturer);
                                $row_manufacturer = mysqli_fetch_array($run_manufacturer);
                                $manufacturer_name = $row_manufacturer['manufacturer_title'];

                                // Fetching category title
                                $get_category = "SELECT cat_title FROM categories WHERE cat_id='$cat_id'";
                                $run_category = mysqli_query($con, $get_category);
                                $row_category = mysqli_fetch_array($run_category);
                                $cat_title = $row_category['cat_title']; // Fetching cat_title based on cat_id

                                $i++;
                            ?>
                            <tr>
                                <td><?php echo $i ?> </td>
                                <td><?php echo $product_title ?></td>
                                <td><img src="product_images/<?php echo $product_img1 ?>" width="40" height="50"></td>
                                <td><?php echo $product_price ?></td>
                                <td><?php echo $product_mrp ?></td>
                                <td><?php echo $product_availability ?></td>
                                <td><?php echo $manufacturer_name ?></td>
                                <td><?php echo $product_keywords ?></td>
                                <td><?php echo $date ?></td>
                                <td><?php echo $cat_title; ?></td> <!-- Displaying cat_title in Gender Column -->
                                <td><a href="index.php?delete_product=<?php echo $pro_id ?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a></td>
                                <td><a href="index.php?edit_product=<?php echo $pro_id ?>">
                                    <i class="fa fa-pencil"></i> Edit
                                </a></td>
                            </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div><!--panel panel-default end-->
    </div><!--col-lg-12 end-->
</div><!--row-2 end-->

<?php } ?>
