<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script> window.open('login.php', '_self'); </script>";
} else {
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a> / View Product Categories
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Product Categories
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Product Category ID</th>
                                <th>Product Category Title</th>
                                <th>Product Category Description</th>
                                <th>Gender</th>
                                <th>Delete Product Category</th>
                                <th>Edit Product Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            // Join query to fetch cat_title from categories table based on cat_id in product_category
                            $get_p_cats = "
                                SELECT pc.p_cat_id, pc.p_cat_title, pc.p_cat_desc, c.cat_title
                                FROM product_category AS pc
                                JOIN categories AS c ON pc.cat_id = c.cat_id
                            ";
                            $run_p_cats = mysqli_query($con, $get_p_cats);
                            while ($row = mysqli_fetch_array($run_p_cats)) {
                                $p_cat_id = $row['p_cat_id'];
                                $p_cat_title = $row['p_cat_title'];
                                $p_cat_desc = $row['p_cat_desc'];
                                $cat_title = $row['cat_title']; // Fetch cat_title from categories table
                                $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $p_cat_title; ?></td>
                                <td><?php echo $p_cat_desc; ?></td>
                                <td><?php echo $cat_title; ?></td> <!-- Display category title (Gender) -->
                                <td>
                                    <a href="index.php?delete_p_cat=<?php echo $p_cat_id; ?>">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a>
                                </td>
                                <td>
                                    <a href="index.php?edit_p_cat=<?php echo $p_cat_id; ?>">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>
