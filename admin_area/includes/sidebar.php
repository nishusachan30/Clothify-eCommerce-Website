<?php

// Include database connection
include("includes/db.php");
include_once("includes/header.php");

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    ?>
    <nav class="col-md-12 col-sm-12 navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle Navigation</span>
            </button>
            <a href="index.php?dashboard" class="navbar-brand">Admin Panel</a>
        </div>
        <ul class="nav navbar-right top-nav"><!--nav navbar-top-right start-->
            <li class="dropdown"><!--dropdown start-->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                    <i class="fa fa-user"></i> <?php echo $admin_name ?>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="index.php?user_profile?id=<?php echo $admin_id ?>">
                            <i class="fa fa-fw fa-user"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a href="index.php?view_product">
                            <i class="fa fa-fw fa-box"></i> Products
                            <span class="badge"><?php echo $count_pro ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?view_customer">
                            <i class="fa fa-fw fa-users"></i> Customer
                            <span class="badge"><?php echo $count_cust ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?view_product_cat">
                            <i class="fa fa-fw fa-gear"></i> Product Categories
                            <span class="badge"><?php echo $count_p_cat ?></span>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="logout.php">Logout
                            <i class="fa fa-fw fa-power-off"></i>
                        </a>
                    </li>
                </ul>
            </li><!--dropdown end-->
        </ul><!--nav navbar-top-right end-->
        <div class="collapse navbar-collapse navbar-ex1-collapse"><!--collaps navbar-collapse start-->
            <ul class="nav navbar-nav side-nav">
                <li><!--li dashboard start-->
                    <a href="index.php?dashboard"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li><!--li dashboard end-->
                <li><!--li product start-->
                    <a href="#products" data-toggle="collapse" data-target="#products">
                        <i class="fa fa-fw fa-table"></i> Product<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul class="collapse" id="products">
                        <li>
                            <a href="index.php?insert_product">Insert Product</a>
                        </li>
                        <li>
                            <a href="index.php?view_product">View Product</a>
                        </li>
                    </ul>
                </li><!--li product end-->
                <li><!--li product start-->
                    <a href="#product_cat" data-toggle="collapse" data-target="#product_cat">
                        <i class="fa fa-fw fa-table"></i> Product Categories<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul class="collapse" id="product_cat">
                        <li>
                            <a href="index.php?insert_product_cat">Insert Product categories</a>
                        </li>
                        <li>
                            <a href="index.php?view_product_cat">View Product Categories</a>
                        </li>
                    </ul>
                </li><!--li product end-->
                <li><!--li product start-->
                    <a href="#category" data-toggle="collapse" data-target="#category">
                        <i class="fa fa-fw fa-table"></i> Categories<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul class="collapse" id="category">
                        <li>
                            <a href="index.php?insert_categories">Insert Categories</a>
                        </li>
                        <li>
                            <a href="index.php?view_categories">View Categories</a>
                        </li>
                    </ul>
                </li><!--li product end-->
                <li><!--li product start-->
                    <a href="#maufacturers" data-toggle="collapse" data-target="#manufacturers">
                        <i class="fa fa-fw fa-table"></i> Manufacturers<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul class="collapse" id="manufacturers">
                        <li>
                            <a href="index.php?insert_manufacturers">Insert Manufacturers</a>
                        </li>
                        <li>
                            <a href="index.php?view_manufacturers">View Manufacturers</a>
                        </li>
                    </ul>
                </li><!--li product end-->
                <li><!--li product start-->
                    <a href="#slider" data-toggle="collapse" data-target="#slider">
                        <i class="fa fa-fw fa-table"></i> Slider<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul class="collapse" id="slider">
                        <li>
                            <a href="index.php?insert_slider">Insert Slider</a>
                        </li>
                        <li>
                            <a href="index.php?view_slider">View Slider</a>
                        </li>
                    </ul>
                </li><!--li product end-->
                <li><!--li product start-->
                    <a href="#boxes" data-toggle="collapse" data-target="#boxes">
                        <i class="fa fa-fw fa-table"></i> Boxes<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul class="collapse" id="boxes">
                        <li>
                            <a href="index.php?insert_boxes">Insert Boxes</a>
                        </li>
                        <li>
                            <a href="index.php?view_boxes">View Boxes</a>
                        </li>
                    </ul>
                </li><!--li product end-->
                <li><!-- contact us li Starts -->
                    <a href="#" data-toggle="collapse" data-target="#contact_us"><!-- anchor Starts -->
                        <i class="fa fa-fw fa-pencil"> </i> Contact Us Section
                        <i class="fa fa-fw fa-caret-down"></i>
                    </a><!-- anchor Ends -->
                    <ul id="contact_us" class="collapse">
                        <li>
                            <a href="index.php?edit_contact_us"> Edit Contact Us </a>
                        </li>
                        <li>
                            <a href="index.php?insert_enquiry"> Insert Enquiry Type </a>
                        </li>
                        <li>
                            <a href="index.php?view_enquiry"> View Enquiry Types </a>
                        </li>
                    </ul>
                </li><!-- contact us li Ends -->
                <li>
                    <a href="index.php?view_customer">
                        <i class="fa fa-fw fa-edit"></i> View Customer
                    </a>
                </li>
                <li>
                    <a href="index.php?view_order">
                        <i class="fa fa-fw fa-list"></i> View Order
                    </a>
                </li>
                <li>
                    <a href="index.php?view_payments">
                        <i class="fa fa-fw fa-pencil"></i> View Payments
                    </a>
                </li>
                <li><!-- terms li Starts -->
                    <a href="#terms" data-toggle="collapse" data-target="#terms"><!-- anchor Starts -->
                        <i class="fa fa-fw fa-table"></i> Terms
                        <i class="fa fa-fw fa-caret-down"></i>
                    </a><!-- anchor Ends -->
                    <ul id="terms" class="collapse"><!-- ul collapse Starts -->
                        <li>
                            <a href="index.php?insert_term"> Insert Terms </a>
                        </li>
                        <li>
                            <a href="index.php?view_terms"> View Terms </a>
                        </li>
                    </ul><!-- ul collapse Ends -->
                </li><!-- terms li Ends -->
                <li><!-- terms li Starts -->
                    <a href="#policy" data-toggle="collapse" data-target="#policy"><!-- anchor Starts -->
                        <i class="fa fa-fw fa-table"></i> Privacy & Policy
                        <i class="fa fa-fw fa-caret-down"></i>
                    </a><!-- anchor Ends -->
                    <ul id="policy" class="collapse"><!-- ul collapse Starts -->
                        <li>
                            <a href="index.php?insert_policy"> Insert Policy </a>
                        </li>
                        <li>
                            <a href="index.php?view_policy"> View Policy </a>
                        </li>
                    </ul><!-- ul collapse Ends -->
                </li><!-- terms li Ends -->
                <li><!-- terms li Starts -->
                    <a href="#edit_about_us" data-toggle="collapse" data-target="#edit_about_us"><!-- anchor Starts -->
                        <i class="fa fa-fw fa-table"></i> About Us
                        <i class="fa fa-fw fa-caret-down"></i>
                    </a><!-- anchor Ends -->
                    <ul id="edit_about_us" class="collapse"><!-- ul collapse Starts -->
                        <li>
                            <a href="index.php?edit_about_us"> Edit About Us </a>
                        </li>
                    </ul><!-- ul collapse Ends -->
                </li><!-- terms li Ends -->
                <li><!--li user start-->
                    <a href="#admin" data-toggle="collapse" data-target="#admin">
                        <i class="fa fa-fw fa-table"></i> Admins<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul class="collapse" id="admin">
                        <li>
                            <a href="index.php?insert_admin">Insert Admin</a>
                        </li>
                        <li>
                            <a href="index.php?view_admin">View Admin</a>
                        </li>
                    </ul>
                </li><!--li user end-->
            </ul>
        </div><!--collapse navbar-collapse end-->
    </nav>
<?php } ?>