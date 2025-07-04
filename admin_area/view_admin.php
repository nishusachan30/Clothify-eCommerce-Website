<?php
include ("includes/db.php");
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login.php','_self')</script>";
}else{
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ View Admin
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Clothify Admins
                </h3>
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Admin ID</th>
                                <th>Admin Name</th>
                                <th>Admin Email ID</th>
                                <th>Admin Contact</th>
                                <th>Admin Image</th>
                                <th>Admin Country</th>
                                <th>Admin Job</th>
                                <th>Edit Admin</th>
                                <th>Delete Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=0;
                                $get_admin="select * from admins";
                                $run_admin=mysqli_query($con, $get_admin);
                                while($row_admin=mysqli_fetch_array($run_admin)){
                                    $admin_id=$row_admin['admin_id'];
                                    $admin_name=$row_admin['admin_name'];
                                    $admin_email=$row_admin['admin_email'];
                                    $admin_contact=$row_admin['admin_contact'];
                                    $admin_image=$row_admin['admin_image'];
                                    $admin_country=$row_admin['admin_country'];
                                    $admin_job=$row_admin['admin_job'];
                                    $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $admin_name; ?></td>
                                <td><?php echo $admin_email; ?></td>
                                <td><?php echo $admin_contact; ?></td>
                                <td> <img src="admin_images/<?php echo $admin_image ?>" width="60" height="60"></td>
                                <td><?php echo $admin_country; ?></td>
                                <td><?php echo $admin_job; ?></td>
                                <td><a href="index.php?edit_admin=<?php echo $admin_id ?>">
                                    <i class="fa fa-pencil"></i> Edit
                                </a></td>
                                <td>
                                    <a href="index.php?delete_admin=<?php echo $admin_id ?>">
                                        <i class="fa fa-trash-o"></i> Delete
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