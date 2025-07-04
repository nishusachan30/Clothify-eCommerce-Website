<?php
$con = mysqli_connect("localhost", "root", "", "clothify");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>