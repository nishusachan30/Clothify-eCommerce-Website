<?php
include("includes/db.php"); // Make sure to include your database connection

if (isset($_POST['p_cat_id'])) {
    $p_cat_id = $_POST['p_cat_id'];

    $get_categories = "SELECT * FROM categories WHERE p_cat_id='$p_cat_id'";
    $run_categories = mysqli_query($con, $get_categories);

    $categories = [];
    while ($row = mysqli_fetch_array($run_categories)) {
        $categories[] = [
            'cat_id' => $row['cat_id'],
            'cat_title' => $row['cat_title']
        ];
    }

    echo json_encode($categories);
}
?>
