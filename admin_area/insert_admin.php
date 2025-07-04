<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script> window.open('login.php','_self' </script>";
}else{
?>
<div class="row"><!--row-1 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <ol class="breadcrumb"><!--breadcrumb start-->
            <li>
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ Insert Admin
            </li>
        </ol><!--breadcrumb end-->
    </div><!--col-lg-12 end-->
</div><!--row-1 end-->

<div class="row"><!--row-2 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <div class="panel panel-default"><!--panel panel-heading start-->
            <div class="panel-heading"><!--panel-heading start-->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Insert Admin
                </h3>
            </div><!--panel-heading end-->

            <div class="panel-body"><!--panel-body start-->
                <form action="" method="post" class="form-horizontal" enctype="multipart/form-data"><!--form-horizontal start-->
                    <div class="form-group"><!--form-group-1 start-->
                        <label class="col-md-3 control-label">Admin Name</label>
                        <div class="col-md-6">
                            <input type="text" name="admin_name" class="form-control" required>
                        </div>
                    </div><!--form-group-1 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Email</label>
                        <div class="col-md-6">
                        <input type="email" name="admin_email" class="form-control" required>
                        </div>
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Password</label>
                        <div class="col-md-6">
                        <input type="password" name="admin_pass" class="form-control" required>
                         
                        </div>
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Country</label>
                        <div class="col-md-6">
                        <input type="text" name="admin_country" class="form-control" required>
                        </div>
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Admin Job</label>
                        <div class="col-md-6">
                            <textarea name="admin_job" type="text" class="form-control"></textarea>
                        </div>
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Contact</label>
                        <div class="col-md-6">
                            <input type="text" name="admin_contact" class="form-control" required>
                        </div>
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">About</label>
                        <div class="col-md-6">
                            <textarea name="admin_about" rows="3" class="form-control"></textarea>
                        </div>
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-2 start-->
                        <label class="col-md-3 control-label">Image</label>
                        <div class="col-md-6">
                        <input type="file" name="admin_image" class="form-control">
                            
                        </div>
                    </div><!--form-group-2 end-->

                    <div class="form-group"><!--form-group-3 start-->
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                            <input type="submit" name="submit" value="Insert Admin" class="btn btn-primary form-control">
                        </div>
                    </div><!--form-group-3 end-->
                </form><!--form-horizontal end-->
            </div><!--panel-body end-->
        </div><!--panel panel-heading end-->
    </div><!--col-lg-12 end-->
</div><!--row-2 end-->

<?php
if (isset($_POST['submit'])) {
    $admin_name = $_POST['admin_name'];
    $admin_email = $_POST['admin_email'];
    $admin_pass = $_POST['admin_pass'];
    $admin_country = $_POST['admin_country'];
    $admin_job = $_POST['admin_job'];
    $admin_contact = $_POST['admin_contact'];
    $admin_about = $_POST['admin_about'];
    $admin_image = $_FILES['admin_image']['name'];
    $temp_admin_image = $_FILES['admin_image']['tmp_name'];

    // Hash the password
    $hashed_password = password_hash($admin_pass, PASSWORD_DEFAULT);

    // Move the uploaded image to the admin_images directory
    move_uploaded_file($temp_admin_image, "admin_images/$admin_image");

    // Insert the admin details into the database
    $insert_admin = "INSERT INTO admins (
        admin_name, admin_email, admin_pass, admin_image, admin_contact, admin_country, admin_job, admin_about
    ) VALUES (
        '$admin_name', '$admin_email', '$hashed_password', '$admin_image', '$admin_contact', '$admin_country', '$admin_job', '$admin_about'
    )";

    $run_admin = mysqli_query($con, $insert_admin);

    if ($run_admin) {
        echo "<script> alert('New Admin has been added successfully') </script>";
        echo "<script> window.open('index.php?view_admin', '_self') </script>";
    } else {
        echo "<script> alert('Error: Could not add the admin. Please try again.') </script>";
    }
}
?>
<?php } ?>