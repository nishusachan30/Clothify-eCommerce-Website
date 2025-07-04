<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    ?>
    <div class="row"><!-- 1 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / View Policy
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 1 row Ends -->
    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i> View Policy
                    </h3>
                </div><!-- panel-heading Ends -->
                <div class="panel-body"><!-- panel-body Starts -->
                    <?php
                    $counter=0;
                    $get_policy = "select * from policy_details";
                    $run_policy = mysqli_query($con, $get_policy);
                    while ($row_policy = mysqli_fetch_array($run_policy)) {
                        if ($counter % 3 == 0) {
                            echo '<div class="row">'; 
                        }
                        $policy_id = $row_policy['policy_id'];
                        $policy_version = $row_policy['policy_version'];
                        $effective_date = $row_policy['effective_date'];
                        $policy_title = $row_policy['policy_title'];
                        $policy_desc = substr($row_policy['policy_desc'], 0, 400);
                        ?>
                        <div class="col-lg-4 col-md-4"><!-- col-lg-4 col-md-4 Starts -->
                            <div class="panel panel-primary"><!-- panel panel-primary Starts -->
                                <div class="panel-heading"><!-- panel-heading Starts -->
                                    <h3 class="panel-title" align="center"><!-- panel-title Starts -->
                                        <?php echo $policy_title; ?>
                                        <?php echo $policy_version; ?>
                                    </h3><!-- panel-title Ends -->
                                </div><!-- panel-heading Ends -->
                                <div class="panel-body"><!-- panel-body Starts -->
                                    <?php echo $policy_desc; ?>
                                </div><!-- panel-body Ends -->
                                <div class="panel-footer"><!-- panel-footer Starts -->
                                    <a href="index.php?delete_policy=<?php echo $policy_id; ?>" class="pull-left">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a>
                                    <a href="index.php?edit_policy=<?php echo $policy_id; ?>" class="pull-right">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                    <div class="clearfix"> </div>
                                </div><!-- panel-footer Ends -->
                            </div><!-- panel panel-primary Ends -->
                        </div><!-- col-lg-4 col-md-4 Ends -->
                        <?php
                        $counter++; // Increment counter
                        
                        if ($counter % 3 == 0) { // Close the row after every 3 items
                            echo '</div>'; // Close the row
                        }
                    }
                     

                    // Close any remaining open row
                    if ($counter % 3 != 0) {
                        echo '</div>'; // Close the last row if needed
                    }
                    ?>
                 
                </div><!-- panel-body Ends -->
            </div><!-- panel panel-default Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 2 row Ends -->
<?php } ?>