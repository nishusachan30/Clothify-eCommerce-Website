<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    ?>
    <?php
    if (isset($_GET['edit_admin']) && !empty($_GET['edit_admin'])) {
        $edit_admin_id = $_GET['edit_admin'];
        $edit_admin_query = "SELECT * FROM admins WHERE admin_id='$edit_admin_id'";
        $run_edit = mysqli_query($con, $edit_admin_query);

        if ($run_edit && mysqli_num_rows($run_edit) > 0) {
            $row_edit = mysqli_fetch_array($run_edit);
            $admin_id = $row_edit['admin_id'];
            $admin_name = $row_edit['admin_name'];
            $admin_contact = $row_edit['admin_contact'];
            $admin_job = $row_edit['admin_job'];
            $admin_country = $row_edit['admin_country'];
            $admin_email = $row_edit['admin_email'];
            $admin_image = $row_edit['admin_image'];
        } else {
            die('Admin not found or invalid Admin ID.');
        }
    } else {
        die('Invalid request: Admin ID not provided.');
    }

    ?>

    <div class="row"><!--row-1 start-->
        <div class="col-lg-12"><!--col-lg-12 start-->
            <ol class="breadcrumb"><!--breadcrumb start-->
                <li class="active">
                    <i class="fa fa-dashboard"></i><a href="index.php?dashboard">Dashboard </a> / Edit Admin Profile
                </li>
            </ol><!--breadcrumb end-->
        </div><!--col-lg-12 end-->
    </div><!--row-1 end-->

    <div class="row"><!--row-2 start-->
        <div class="col-lg-12"><!--col-lg-12 start-->
            <div class="panel panel-default"><!--panel panel-default start-->
                <div class="panel-heading"><!--panel-heading start-->
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i>Edit Admin Profile
                    </h3>
                </div><!--panel-heading end-->
                <div class="panel-body"><!--panel-body start-->
                    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <!--form-horizontal start-->
                        <div class="form-group"><!--form-group-1 start-->
                            <label class="col-md-3 control-label">Admin Name</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <input type="text" name="admin_name" class="form-control"
                                    value="<?php echo $admin_name; ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-1 end-->

                        <div class="form-group"><!--form-group-1 start-->
                            <label class="col-md-3 control-label">Admin Email</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <input type="text" name="admin_email" class="form-control"
                                    value="<?php echo $admin_email; ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-1 end-->

                        <div class="form-group"><!--form-group-2 start-->
                            <label class="col-md-3 control-label">Admin Contact</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <input type="text" name="admin_contact" class="form-control"
                                    value="<?php echo $admin_contact; ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-2 end-->

                        <div class="form-group"><!--form-group-3 start-->
                            <label class="col-md-3 control-label">Admin Country</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <input type="text" name="admin_country" class="form-control"
                                    value="<?php echo $admin_country; ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-3 end-->

                        <div class="form-group"><!--form-group-3 start-->
                            <label class="col-md-3 control-label">Admin Job</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <input type="text" name="admin_job" class="form-control" value="<?php echo $admin_job; ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-3 end-->

                        <div class="form-group"><!--form-group-6 start-->
                            <label for="" class="col-md-3 control-label">Admin Image</label>
                            <div class="col-md-6"><!--col-md-6 start-->
                                <input type="file" name="admin_image" class="form-control">
                                <br><img src="admin_images/<?php echo $admin_image; ?>" width="70" height="70">
                                <input type="hidden" name="existing_image" value="<?php echo $admin_image; ?>">
                            </div><!--col-md-6 end-->
                        </div><!--form-group-6 end-->

                        <div class="form-group">
                            <label class="col-md-3 control-label">Old Password</label>
                            <div class="col-md-6">
                                <input type="password" name="oldpass" class="form-control" placeholder="Enter old password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">New Password</label>
                            <div class="col-md-6">
                                <input type="password" name="newpass" class="form-control" placeholder="Enter new password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Confirm New Password</label>
                            <div class="col-md-6">
                                <input type="password" name="cnfnewpass" class="form-control"
                                    placeholder="Confirm new password">
                            </div>
                        </div>

                        <div class="form-group"><!--form-group-3 start-->
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-6">
                                <input type="submit" name="update" value="Update Admin"
                                    class="btn btn-primary form-control">
                            </div>
                        </div><!--form-group-3 end-->

                    </form><!--form-horizontal end-->
                </div><!--panel-body end-->
            </div><!--panel panel-default end-->
        </div><!--col-lg-12 end-->
    </div><!--row-2 end-->


    <?php
    if (isset($_POST['update'])) {
        $admin_name = $_POST['admin_name'];
        $admin_contact = $_POST['admin_contact'];
        $admin_country = $_POST['admin_country'];
        $admin_job = $_POST['admin_job'];
        $admin_email = $_POST['admin_email'];
        $admin_image = $_FILES['admin_image']['name'];
        $temp_admin_image = $_FILES['admin_image']['tmp_name'];
    
        $oldpass = $_POST['oldpass'];
        $newpass = $_POST['newpass'];
        $cnfnewpass = $_POST['cnfnewpass'];
    
        // Use existing image if no new one is uploaded
        if (empty($admin_image)) {
            $admin_image = $_POST['existing_image'];
        }
        move_uploaded_file($temp_admin_image, "admin_images/$admin_image");
    
        // Fetch current hashed password from the database
        $query = "SELECT admin_pass FROM admins WHERE admin_id='$admin_id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $current_hashed_password = $row['admin_pass'];
    
        // Validate and update password if necessary
        if (!empty($oldpass) || !empty($newpass) || !empty($cnfnewpass)) {
            // Check if all password fields are filled
            if (empty($oldpass) || empty($newpass) || empty($cnfnewpass)) {
                echo "<script>alert('All password fields are required if you want to change the password.')</script>";
                exit();
            }
    
            // Verify the old password
            if (!password_verify($oldpass, $current_hashed_password)) {
                echo "<script>alert('The old password is incorrect.')</script>";
                exit();
            }
    
            // Ensure new password and confirm password match
            if ($newpass !== $cnfnewpass) {
                echo "<script>alert('New password and confirm password do not match.')</script>";
                exit();
            }
    
            // Hash the new password
            $new_hashed_password = password_hash($newpass, PASSWORD_DEFAULT);
    
            // Include the password update in the query
            $update_password_query = ", admin_pass='$new_hashed_password'";
        } else {
            // Skip password update
            $update_password_query = "";
        }
    
        // Update admin details, including password if provided
        $update_admin = "UPDATE admins 
                         SET admin_name='$admin_name', 
                             admin_contact='$admin_contact', 
                             admin_image='$admin_image', 
                             admin_country='$admin_country', 
                             admin_job='$admin_job', 
                             admin_email='$admin_email'
                             $update_password_query
                         WHERE admin_id='$admin_id'";
    
        $run_update = mysqli_query($con, $update_admin);
    
        if ($run_update) {
            // Check if the email has changed
            if ($_SESSION['admin_email'] !== $admin_email) {
                echo "<script>alert('Email has been changed. Please log in again.')</script>";
                session_destroy(); // Destroy the session
                echo "<script>window.open('login.php', '_self')</script>";
                exit();
            }
    
            echo "<script>alert('Admin Profile has been updated successfully.')</script>";
            echo "<script>window.open('index.php?view_admin', '_self')</script>";
        } else {
            echo "<script>alert('Error updating profile. Please try again.')</script>";
        }
    }
    

    ?>


<?php } ?>