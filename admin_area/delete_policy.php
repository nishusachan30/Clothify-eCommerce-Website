<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    ?>
    <?php
    if (isset($_GET['delete_policy'])) {
        $delete_id = $_GET['delete_policy'];
        $delete_policy = "delete from policy_details where policy_id='$delete_id'";
        $run_policy = mysqli_query($con, $delete_policy);
        if ($run_policy) {
            echo "<script>alert(' One Policy Box Has Been Deleted ')</script>";
            echo "<script>window.open('index.php?view_policy','_self')</script>";
        }
    }
?>
<?php } ?>