<?php
include ("includes/db.php");
if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login.php','_self')</script>";
}else{
?>
<?php
if(isset($_GET['customer_delete'])){
    $delete_id=$_GET['customer_delete'];
    $delete_customer="delete from customers where cust_id='$delete_id'";
    $run_delete=mysqli_query($con, $delete_customer);
    if($run_delete){
        echo "<script> alert ('Customer has been deleted') </script>";
        echo "<script> window.open('index.php?view_customer', '_self') </script>";
    }
}
?>
<?php } ?>