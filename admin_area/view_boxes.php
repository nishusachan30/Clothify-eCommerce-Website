<?php
// Start session and check admin login
if (!isset($_SESSION['admin_email'])) {
    echo "<script>alert('You must be logged in to access this page.');</script>";
    echo "<script>window.open('login.php', '_self');</script>";
    exit(); // Stop further execution
} else {
?>

<div class="row"><!--row-1 start-->
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i><a href="index.php?dashboard"> Dashboard </a>/ View Boxes
            </li>
        </ol>
    </div>
</div><!--row-1 end-->

<div class="row"><!--row-2 start-->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <div class="panel panel-default"><!--panel panel-default start-->
            <div class="panel-heading"><!--panel-heading start-->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i>Boxes
                </h3>
            </div><!--panel-heading end-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Box ID</th>
                                <th>Box Title</th>
                                <th>Box Description</th>
                                <th>Box Icon</th>
                                <th>Delete Box</th>
                                <th>Edit Box </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $get_boxes = "SELECT * FROM boxes_section";
                            $run_boxes = mysqli_query($con, $get_boxes);

                            // Error handling for query execution
                            if (!$run_boxes) {
                                echo "<tr><td colspan='6'>Error fetching boxes: " . mysqli_error($con) . "</td></tr>";
                            } else {
                                while ($row = mysqli_fetch_array($run_boxes)) {
                                    $box_id = htmlspecialchars($row['box_id']);
                                    $box_title = htmlspecialchars($row['box_title']);
                                    $box_desc = htmlspecialchars($row['box_desc']);
                                    $box_icon = htmlspecialchars($row['box_icon']);
                                    $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $box_title; ?></td>
                                <td><?php echo $box_desc; ?></td>
                                <td><?php echo $box_icon; ?></td>
                                <td><a href="index.php?delete_boxes=<?php echo $box_id; ?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a></td>
                                <td><a href="index.php?edit_boxes=<?php echo $box_id; ?>">
                                    <i class="fa fa-pencil"></i> Edit
                                </a></td>
                            </tr>
                            <?php 
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--panel panel-default end-->
    </div><!--col-lg-12 end-->
</div><!--row-2 end-->

<?php } ?>
