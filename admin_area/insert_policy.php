<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    ?>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector: 'textarea' });</script>
    <div class="row"><!-- 1 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / Insert Policy
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 1 row Ends -->
    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title"><!-- panel-title Starts -->
                        <i class="fa fa-money fa-fw"></i> Insert Policy
                    </h3><!-- panel-title Ends -->
                </div><!-- panel-heading Ends -->
                <div class="panel-body"><!-- panel-body Starts -->
                    <form class="form-horizontal" action="" method="post"><!-- form-horizontal Starts -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Policy Title </label>
                            <div class="col-md-6"><!-- col-md-6 Starts -->
                                <input type="text" name="policy_title" class="form-control">
                            </div><!-- col-md-6 Ends -->
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Policy Version </label>
                            <div class="col-md-6"><!-- col-md-6 Starts -->
                                <input type="text" name="policy_version" class="form-control">
                            </div><!-- col-md-6 Ends -->
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Policy Effective Date </label>
                            <div class="col-md-6"><!-- col-md-6 Starts -->
                                <input type="date" id="date" name="policy_eff_date" class="form-control">
                            </div><!-- col-md-6 Ends -->
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Policy Description </label>
                            <div class="col-md-6"><!-- col-md-6 Starts -->
                                <textarea id="default" name="policy_desc" 
                                    class="form-control"></textarea>
                            </div><!-- col-md-6 Ends -->
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Policy Link </label>
                            <div class="col-md-6"><!-- col-md-6 Starts -->
                                <input type="text" name="policy_link" class="form-control">
                            </div><!-- col-md-6 Ends -->
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> </label>
                            <div class="col-md-6"><!-- col-md-6 Starts -->
                                <input type="submit" name="submit" value="Insert Policy"
                                    class="btn btn-primary form-control">
                            </div><!-- col-md-6 Ends -->
                        </div><!-- form-group Ends -->
                    </form><!-- form-horizontal Ends -->
                </div><!-- panel-body Ends -->
            </div><!-- panel panel-default Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 2 row Ends -->
    <?php
    if (isset($_POST['submit'])) {
        $policy_title = mysqli_real_escape_string($con, $_POST['policy_title']);
        $policy_version = mysqli_real_escape_string($con, $_POST['policy_version']);
        $policy_eff_date = mysqli_real_escape_string($con, $_POST['policy_eff_date']);
        $policy_desc = mysqli_real_escape_string($con, $_POST['policy_desc']);
        $policy_link = mysqli_real_escape_string($con, $_POST['policy_link']);
        $insert_policy = "insert into policy_details (policy_title,policy_version,effective_date,policy_link,policy_desc,created_at) values ('$policy_title','$policy_version','$policy_eff_date','$policy_link','$policy_desc', NOW() ) ";
        $run_policy = mysqli_query($con, $insert_policy);
        if ($run_policy) {
            echo "<script>alert('New Policy Has Been Inserted')</script>";
            echo "<script>window.open('index.php?insert_policy','_self')</script>";
        }
    }
?>
<?php } ?>
