<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login.php','_self')</script>";
}else{
?>
<?php
    if(isset($_GET['delete_order'])){
        $delete_order_id=$_GET['delete_order'];
        $delete_order="delete from customer_order where order_id='$delete_order_id'";
        $run_delete=mysqli_query($con, $delete_order);
        if($run_delete){
            echo "<script> alert('One Order has been deleted')</script>";
            echo "<script> window.open('index.php?view_order','_self')</script>";
        }
    }
?>
<?php } ?>