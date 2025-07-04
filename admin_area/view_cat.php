<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script> window.open('login.php','_self' </script>";
}else{
?>

<div class="row"><!--row-1 start-->
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ View Categories
            </li>
        </ol>
    </div>
</div><!--row-1 end-->

<div class="row"><!--row-2 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <div class="panel panel-default"><!--panel panel-default start-->
            <div class="panel-heading"><!--panel-heading start-->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i>Categories
                </h3>
            </div><!--panel-heading end-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Title</th>
                                <th>Category Description</th>
                                <th>Delete Category</th>
                                <th>Edit Category </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=0;
                            $get_cats="select * from categories";
                            $run_cats=mysqli_query($con,$get_cats);
                            while($row=mysqli_fetch_array($run_cats)){
                                $cat_id=$row['cat_id'];
                                $cat_title=$row['cat_title'];
                                $cat_desc=$row['cat_desc'];
                                $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?> </td>
                                <td><?php echo $cat_title; ?></td>
                                <td><?php echo $cat_desc; ?></td>
                                <td><a href="index.php?delete_cat=<?php echo $cat_id ?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a></td>
                                <td><a href="index.php?edit_cat=<?php echo $cat_id ?>">
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