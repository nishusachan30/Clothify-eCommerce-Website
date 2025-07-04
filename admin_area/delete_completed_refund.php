<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login.php','_self')</script>";
}else{
?>
<?php
    if(isset($_GET['delete_completed_refund'])){
        $delete_refund_id=$_GET['delete_completed_refund'];
        $delete_order="delete from return_refund where return_refund_id='$delete_refund_id'";
        $run_delete=mysqli_query($con, $delete_order);
        if($run_delete){
            echo "<script> alert('One Record has been deleted')</script>";
            echo "<script> window.open('index.php?view_completed_refund','_self')</script>";
        }
    }
?>
<?php } ?>