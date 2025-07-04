<?php
date_default_timezone_set('Asia/Kolkata');
$con = mysqli_connect("localhost", "root", "", "clothify");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>