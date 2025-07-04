<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    ?>
    <?php
    if (isset($_GET['edit_policy'])) {
        $edit_id = $_GET['edit_policy'];
        $get_policy = "select * from policy_details where policy_id='$edit_id'";
        $run_policy = mysqli_query($con, $get_policy);
        $row_policy = mysqli_fetch_array($run_policy);
        $policy_id = $row_policy['policy_id'];
        $policy_version = $row_policy['policy_version'];
        $effective_date = $row_policy['effective_date'];
        $policy_title = $row_policy['policy_title'];
        $policy_link = $row_policy['policy_link'];
        $policy_desc = $row_policy['policy_desc'];
    }
    ?>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector: 'textarea' });</script>
    <div class="row"><!-- 1 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / Edit Policy
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 1 row Ends -->
    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title"><!-- panel-title Starts -->
                        <i class="fa fa-money fa-fw"></i> Edit Policy
                    </h3><!-- panel-title Ends -->
                </div><!-- panel-heading Ends -->
                <div class="panel-body"><!-- panel-body Starts -->
                    <form class="form-horizontal" action="" method="post"><!-- form-horizontal Starts -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Policy Title </label>
                            <div class="col-md-6"><!-- col-md-6 Starts -->
                                <input type="text" name="policy_title" class="form-control"
                                    value="<?php echo $policy_title; ?>">
                            </div><!-- col-md-6 Ends -->
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Policy Version </label>
                            <div class="col-md-6"><!-- col-md-6 Starts -->
                                <input type="text" name="policy_version" class="form-control"
                                    value="<?php echo $policy_version; ?>">
                            </div><!-- col-md-6 Ends -->
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Policy Description </label>
                            <div class="col-md-6"><!-- col-md-6 Starts -->
                                <textarea name="policy_desc" class="form-control" rows="6" cols="19">
        <?php echo $policy_desc; ?>
        </textarea>
                            </div><!-- col-md-6 Ends -->
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Policy Link </label>
                            <div class="col-md-6"><!-- col-md-6 Starts -->
                                <input type="text" name="policy_link" class="form-control"
                                    value="<?php echo $policy_link; ?>">
                            </div><!-- col-md-6 Ends -->
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> </label>
                            <div class="col-md-6"><!-- col-md-6 Starts -->
                                <input type="submit" name="update" value="Update Policy"
                                    class="btn btn-primary form-control">
                            </div><!-- col-md-6 Ends -->
                        </div><!-- form-group Ends -->
                    </form><!-- form-horizontal Ends -->
                </div><!-- panel-body Ends -->
            </div><!-- panel panel-default Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 2 row Ends -->
    <?php
    if (isset($_POST['update'])) {
        $policy_title = mysqli_real_escape_string($con, $_POST['policy_title']);
        $policy_version = mysqli_real_escape_string($con, $_POST['policy_version']);
        $policy_eff_date = mysqli_real_escape_string($con, $_POST['policy_eff_date']);
        $policy_desc = mysqli_real_escape_string($con, $_POST['policy_desc']);
        $policy_link = mysqli_real_escape_string($con, $_POST['policy_link']);
        $update_policy = "update policy_details set policy_title='$policy_title',policy_version='$policy_version',policy_link='$policy_link',policy_desc='$policy_desc',updated_at=NOW() where policy_id='$policy_id'";
        $run_policy = mysqli_query($con, $update_policy);
        if ($run_policy) {
            echo "<script>alert('One policy Box Has Been Updated ')</script>";
            echo "<script>window.open('index.php?view_policy','_self')</script>";
        }
    }
?>
<?php } ?>