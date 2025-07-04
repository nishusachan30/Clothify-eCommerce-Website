<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login.php','_self')</script>";
}else{
?>
<?php
    if(isset($_GET['delete_return_order'])){
        $delete_return_id=$_GET['delete_return_order'];
        $delete_return="delete from return_refund where return_refund_id='$delete_return_id'";
        $run_delete=mysqli_query($con, $delete_return);
        if($run_delete){
            echo "<script> alert('One Record has been deleted')</script>";
            echo "<script> window.open('index.php?view_return_refund_orders','_self')</script>";
        }
    }
?>
<?php } ?>