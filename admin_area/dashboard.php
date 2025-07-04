<?php
include("includes/db.php");
include("includes/header.php");
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    ?>
    <div class="row"><!--row-1 start-->
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
            </ol>
        </div>
    </div><!--row-1 end-->

    <div class="row"><!--row-2 start-->
        <div class="col-lg-3 col-md-6"><!--col-lg-3 col-md-6 start-->
            <div class="panel panel-products"><!--panel panel-primary start-->
                <div class="panel-heading"><!--panel-heading start-->
                    <div class="row"><!--panel-heading row start-->
                        <div class="col-xs-3"><!--col-xs-3 start-->
                            <i class="fa fa-tasks fa-5x"></i>
                        </div><!--col-xs-3 end-->
                        <div class="col-xs-9 text-right"><!--col-xs-9 text-right start-->
                            <div class="huge"> <?php echo $count_pro ?> </div>
                            <div>Total Products </div>
                        </div><!--col-xs-9 text-right end-->
                    </div><!--panel-heading row end-->
                </div><!--panel-heading end-->
                <a href="index.php?view_product">
                    <div class="panel-footer"><!--panel-footer start-->
                        <span class="pull-left"> View Details </span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div><!--panel-footer end-->
                </a>
            </div><!--panel panel-primary end-->
        </div><!--col-lg-3 col-md-6 end-->

        <div class="col-lg-3 col-md-6"><!--col-lg-3 col-md-6 start-->
            <div class="panel panel-info"><!--panel panel-green start-->
                <div class="panel-heading"><!--panel-heading start-->
                    <div class="row"><!--panel-heading row start-->
                        <div class="col-xs-3"><!--col-xs-3 start-->
                            <i class="fa fa-users fa-5x"></i>
                        </div><!--col-xs-3 end-->
                        <div class="col-xs-9 text-right"><!--col-xs-9 text-right start-->
                            <div class="huge"> <?php echo $count_cust ?> </div>
                            <div>Clothify Customers </div>
                        </div><!--col-xs-9 text-right end-->
                    </div><!--panel-heading row end-->
                </div><!--panel-heading end-->
                <a href="index.php?view_customer">
                    <div class="panel-footer"><!--panel-footer start-->
                        <span class="pull-left"> View Details </span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div><!--panel-footer end-->
                </a>
            </div><!--panel panel-green end-->
        </div><!--col-lg-3 col-md-6 end-->

        <div class="col-lg-3 col-md-6"><!--col-lg-3 col-md-6 start-->
            <div class="panel panel-yellow"><!--panel panel-yellow start-->
                <div class="panel-heading"><!--panel-heading start-->
                    <div class="row"><!--panel-heading row start-->
                        <div class="col-xs-3"><!--col-xs-3 start-->
                            <i class="fa fa-list fa-5x"></i>
                        </div><!--col-xs-3 end-->
                        <div class="col-xs-9 text-right"><!--col-xs-9 text-right start-->
                            <div class="huge"><?php echo $count_p_cat ?> </div>
                            <div> Product Categories </div>
                        </div><!--col-xs-9 text-right end-->
                    </div><!--panel-heading row end-->
                </div><!--panel-heading end-->
                <a href="index.php?view_product_cat">
                    <div class="panel-footer"><!--panel-footer start-->
                        <span class="pull-left"> View Details </span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div><!--panel-footer end-->
                </a>
            </div><!--panel panel-yellow end-->
        </div><!--col-lg-3 col-md-6 end-->

        <div class="col-lg-3 col-md-6"><!--col-lg-3 col-md-6 start-->
            <div class="panel panel-pink"><!--panel panel-red start-->
                <div class="panel-heading"><!--panel-heading start-->
                    <div class="row"><!--panel-heading row start-->
                        <div class="col-xs-3"><!--col-xs-3 start-->
                            <i class="fa fa-cart-arrow-down fa-5x"></i>
                        </div><!--col-xs-3 end-->
                        <div class="col-xs-9 text-right"><!--col-xs-9 text-right start-->
                            <div class="huge"> <?php echo $count_order ?> </div>
                            <div>Total Orders </div>
                        </div><!--col-xs-9 text-right end-->
                    </div><!--panel-heading row end-->
                </div><!--panel-heading end-->
                <a href="index.php?view_order">
                    <div class="panel-footer"><!--panel-footer start-->
                        <span class="pull-left"> View Details </span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div><!--panel-footer end-->
                </a>
            </div><!--panel panel-red end-->
        </div><!--col-lg-3 col-md-6 end-->

        <div class="row">
            <div class="col-lg-3 col-md-6"><!-- col-lg-3 col-md-6 Starts -->
                <div class="panel panel-success"><!-- panel panel-red Starts -->
                    <div class="panel-heading"><!-- panel-heading Starts -->
                        <div class="row"><!-- panel-heading row Starts -->
                            <div class="col-xs-3"><!-- col-xs-3 Starts -->
                                <i class="fa fa-rupee fa-5x"> </i>
                            </div><!-- col-xs-3 Ends -->
                            <div class="col-xs-9 text-right"><!-- col-xs-9 text-right Starts -->
                                <div class="huge"> <?php echo $count_total_earnings ?? 0 ?> </div>
                                <div>Total Revenue</div>
                            </div><!-- col-xs-9 text-right Ends -->
                        </div><!-- panel-heading row Ends -->
                    </div><!-- panel-heading Ends -->
                    <a href="index.php?view_payments">
                        <div class="panel-footer"><!-- panel-footer Starts -->
                            <span class="pull-left"> View Details </span>
                            <span class="pull-right"> <i class="fa fa-arrow-circle-right"></i> </span>
                            <div class="clearfix"></div>
                        </div><!-- panel-footer Ends -->
                    </a>
                </div><!-- panel panel-red Ends -->
            </div><!-- col-lg-3 col-md-6 Ends -->

            <div class="col-lg-3 col-md-6"><!-- col-lg-3 col-md-6 Starts -->
                <div class="panel panel-warning"><!-- panel panel-red Starts -->
                    <div class="panel-heading"><!-- panel-heading Starts -->
                        <div class="row"><!-- panel-heading row Starts -->
                            <div class="col-xs-3"><!-- col-xs-3 Starts -->
                                <i class="fa fa-spinner fa-5x"> </i>
                            </div><!-- col-xs-3 Ends -->
                            <div class="col-xs-9 text-right"><!-- col-xs-9 text-right Starts -->
                                <div class="huge"> <?php echo $count_pending_orders ?> </div>
                                <div>Pending Orders</div>
                            </div><!-- col-xs-9 text-right Ends -->
                        </div><!-- panel-heading row Ends -->
                    </div><!-- panel-heading Ends -->
                    <a href="index.php?view_pending_orders">
                        <div class="panel-footer"><!-- panel-footer Starts -->
                            <span class="pull-left"> View Details </span>
                            <span class="pull-right"> <i class="fa fa-arrow-circle-right"></i> </span>
                            <div class="clearfix"></div>
                        </div><!-- panel-footer Ends -->
                    </a>
                </div><!-- panel panel-red Ends -->
            </div><!-- col-lg-3 col-md-6 Ends -->

            <div class="col-lg-3 col-md-6"><!-- col-lg-3 col-md-6 Starts -->
                <div class="panel panel-green"><!-- panel panel-red Starts -->
                    <div class="panel-heading"><!-- panel-heading Starts -->
                        <div class="row"><!-- panel-heading row Starts -->
                            <div class="col-xs-3"><!-- col-xs-3 Starts -->
                                <i class="fa fa-check fa-5x"> </i>
                            </div><!-- col-xs-3 Ends -->
                            <div class="col-xs-9 text-right"><!-- col-xs-9 text-right Starts -->
                                <div class="huge"> <?php echo $count_completed_orders ?> </div>
                                <div>Completed Orders</div>
                            </div><!-- col-xs-9 text-right Ends -->
                        </div><!-- panel-heading row Ends -->
                    </div><!-- panel-heading Ends -->
                    <a href="index.php?view_completed_orders">
                        <div class="panel-footer"><!-- panel-footer Starts -->
                            <span class="pull-left"> View Details </span>
                            <span class="pull-right"> <i class="fa fa-arrow-circle-right"></i> </span>
                            <div class="clearfix"></div>
                        </div><!-- panel-footer Ends -->
                    </a>
                </div><!-- panel panel-red Ends -->
            </div><!-- col-lg-3 col-md-6 Ends -->

            <div class="col-lg-3 col-md-6"><!-- col-lg-3 col-md-6 Starts -->
                <div class="panel panel-red"><!-- panel panel-red Starts -->
                    <div class="panel-heading"><!-- panel-heading Starts -->
                        <div class="row"><!-- panel-heading row Starts -->
                            <div class="col-xs-3"><!-- col-xs-3 Starts -->
                                <i class="fa fa-ban fa-5x"> </i>
                            </div><!-- col-xs-3 Ends -->
                            <div class="col-xs-9 text-right"><!-- col-xs-9 text-right Starts -->
                                <div class="huge"> <?php echo $count_cancelled_orders ?> </div>
                                <div>Cancelled Orders</div>
                            </div><!-- col-xs-9 text-right Ends -->
                        </div><!-- panel-heading row Ends -->
                    </div><!-- panel-heading Ends -->
                    <a href="index.php?view_cancelled_orders">
                        <div class="panel-footer"><!-- panel-footer Starts -->
                            <span class="pull-left"> View Details </span>
                            <span class="pull-right"> <i class="fa fa-arrow-circle-right"></i> </span>
                            <div class="clearfix"></div>
                        </div><!-- panel-footer Ends -->
                    </a>
                </div><!-- panel panel-red Ends -->
            </div><!-- col-lg-3 col-md-6 Ends -->
            
            <div class="col-lg-3 col-md-6"><!-- col-lg-3 col-md-6 Starts -->
                <div class="panel panel-grey"><!-- panel panel-red Starts -->
                    <div class="panel-heading"><!-- panel-heading Starts -->
                        <div class="row"><!-- panel-heading row Starts -->
                            <div class="col-xs-3"><!-- col-xs-3 Starts -->
                                <i class="fa fa-rotate-left fa-5x"> </i>
                            </div><!-- col-xs-3 Ends -->
                            <div class="col-xs-9 text-right"><!-- col-xs-9 text-right Starts -->
                                <div class="huge"> <?php echo $count_return_orders ?> </div>
                                <div>Request Return & refund Orders</div>
                            </div><!-- col-xs-9 text-right Ends -->
                        </div><!-- panel-heading row Ends -->
                    </div><!-- panel-heading Ends -->
                    <a href="index.php?view_return_refund_orders">
                        <div class="panel-footer"><!-- panel-footer Starts -->
                            <span class="pull-left"> View Details </span>
                            <span class="pull-right"> <i class="fa fa-arrow-circle-right"></i> </span>
                            <div class="clearfix"></div>
                        </div><!-- panel-footer Ends -->
                    </a>
                </div><!-- panel panel-red Ends -->
            </div><!-- col-lg-3 col-md-6 Ends -->

            <div class="col-lg-3 col-md-6"><!-- col-lg-3 col-md-6 Starts -->
                <div class="panel panel-violet"><!-- panel panel-red Starts -->
                    <div class="panel-heading"><!-- panel-heading Starts -->
                        <div class="row"><!-- panel-heading row Starts -->
                            <div class="col-xs-3"><!-- col-xs-3 Starts -->
                                <i class="fa fa-money-check-dollar fa-5x"> </i>
                            </div><!-- col-xs-3 Ends -->
                            <div class="col-xs-9 text-right"><!-- col-xs-9 text-right Starts -->
                                <div class="huge"> <?php echo $count_completed_refund ?> </div>
                                <div>Completed Return & Refund Orders</div>
                            </div><!-- col-xs-9 text-right Ends -->
                        </div><!-- panel-heading row Ends -->
                    </div><!-- panel-heading Ends -->
                    <a href="index.php?view_completed_refund">
                        <div class="panel-footer"><!-- panel-footer Starts -->
                            <span class="pull-left"> View Details </span>
                            <span class="pull-right"> <i class="fa fa-arrow-circle-right"></i> </span>
                            <div class="clearfix"></div>
                        </div><!-- panel-footer Ends -->
                    </a>
                </div><!-- panel panel-red Ends -->
            </div><!-- col-lg-3 col-md-6 Ends -->
        </div><!--row-2 end-->
        
        <div class="row"><!--row-3 start-->
            <div class="col-lg-12 col-md-12"><!--col-lg-8 start-->
                <div class="panel-panel-primary"><!--panel-panel-primary start-->
                    <div class="panel-heading"><!--panel-heading start-->
                        <h3 class="panel-title"><!--panel_title start-->
                            <i class="fa fa-money fa-fw"></i> New orders
                        </h3><!--panel_title end-->
                    </div><!--panel-heading end-->
                    <div class="panel-body"><!--panel-body start-->
                        <div class="table-responsive"><!--table-responsive start-->
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <th>Customer Email</th>
                                        <th>Invoice No</th>
                                        <th>Product_id</th>
                                        <th>Quantity</th>
                                        <th>Size</th>
                                        <th>Total (₹)</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    $get_order = "select * from customer_order order by 1 DESC LIMIT 0,10";
                                    $run_order = mysqli_query($con, $get_order);

                                    // Check if the query was successful
                                    if (!$run_order) {
                                        echo "<tr><td colspan='9' class='text-danger'>Error: Could not fetch orders. Please try again later.</td></tr>";
                                    } else {
                                        while ($row_order = mysqli_fetch_array($run_order)) {
                                            $order_id = $row_order['order_id'];
                                            $product_id = $row_order['product_id'];
                                            $cust_id = $row_order['cust_id'];
                                            $invoice_no = $row_order['invoice_no'];
                                            $qty = $row_order['qty'];
                                            $size = $row_order['size'];
                                            $total = $row_order['due_amount'];
                                            $date = $row_order['order_date'];
                                            $order_status = $row_order['order_status'];
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <?php
                                                    $get_cust = "select * from customers where cust_id='$cust_id'";
                                                    $run_cust = mysqli_query($con, $get_cust);

                                                    // Check if the customer query was successful
                                                    if (!$run_cust) {
                                                        echo "<span class='text-danger'>Error fetching customer data.</span>";
                                                    } else {
                                                        $row_customer = mysqli_fetch_array($run_cust);

                                                        // Check if customer data is retrieved
                                                        if ($row_customer) {
                                                            $customer_email = $row_customer['cust_email'];
                                                            echo $customer_email;
                                                        } else {
                                                            echo "<span class='text-warning'>Customer not found.</span>";
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($invoice_no); ?></td>
                                                <td><?php echo htmlspecialchars($product_id); ?></td>
                                                <td><?php echo htmlspecialchars($qty); ?></td>
                                                <td><?php echo htmlspecialchars($size); ?></td>
                                                <td><?php echo htmlspecialchars($total); ?></td>
                                                <td><?php echo htmlspecialchars($date); ?></td>
                                                <td><?php echo htmlspecialchars($order_status); ?></td>
                                            </tr>
                                        <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div><!--table-responsive end-->
                        <div class="text-right"><!--text-right start-->
                            <a href="index.php?view_order">View All Orders <i class="fa fa-arrow-circle-right"></i></a>
                        </div><!--text-right end-->
                    </div><!--panel-body end-->
                </div><!--panel-panel-primary end-->
            </div><!--col-lg-8 end-->
        </div><!--row-3 end-->

        <div class="col-lg-3 col-md-3"><!--col-md-4 start-->
            <div class="panel"><!--panel start-->
                <div class="panel-body"><!--panel-body start-->
                    <div class="thumb-info mb-md"><!--thumb-info start-->
                        <img src="admin_images/<?php echo $admin_image ?>" class="rounded img-responsive" width="250"
                            height="30" alt="admin_img">
                        <div class="thumb-info-title"><!--thumb-info-title start-->
                            <span class="thumb-info-inner"><?php echo $admin_name ?></span>
                            <span class="thumb-info-type"><?php echo $admin_job ?></span>
                        </div><!--thumb-info-title end-->
                        <div><!--thumb-info end-->
                            <div class="mb-md"><!--mb-md start-->
                                <div class="widget-content-expanded"><!--widget-control-expanded start-->
                                    <i class="fa fa-envelope"></i> Email: <?php echo $admin_email ?> <br>
                                    <i class="fa fa-earth"></i> Country: <?php echo $admin_country ?><br>
                                    <i class="fa fa-phone"></i> Contact: <?php echo $admin_contact ?> <br>
                                </div><!--widget-control-expanded end-->
                                <hr class="dotted short">
                                <h5 class="text-muted">About</h5>
                                <p>
                                    <?php echo $admin_about ?>
                                </p>
                            </div><!--mb-md end-->
                        </div><!--panel-body end-->
                    </div><!--panel end-->
                </div><!--col-md-4 end-->
            </div><!--row-3 end-->
        <?php } ?>