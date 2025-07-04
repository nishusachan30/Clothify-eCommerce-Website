<?php
if(!isset($_SESSION['admin_email'])){
    echo "<script> window.open('login.php','_self' </script>";
}else{
?>

<?php
    if(isset($_GET['delete_payment'])){
        $delete_payment_id=$_GET['delete_payment'];
        $delete_payment="delete from payments where payid='$delete_payment_id'";
        $run_delete=mysqli_query($con, $delete_payment);
        if($run_delete){
            echo "<script> alert('One Payment has been deleted')</script>";
            echo "<script> window.open('index.php?view_payments','_self')</script>";
        }
    }
?>

<?php } ?>