<div id="footer"> <!--footer start -->
    <div class="container"><!--container start -->
        <div class="row"> <!--row start-->
            <div class="col-md-3 col-sm-6"><!--col-md-3 start-->
                <h4>Pages</h4>
                <ul>
                    <li><a href="../cart.php">Shopping Cart</a></li>
                    <li><a href="../contact.php">Contact Us</a></li>
                    <li><a href="../shop.php">Shop</a></li>
                    <li><a href="account.php">My Account</a></li>
                </ul>
                <hr class="hidden-md hidden-lg hidden-sm">
                <h4>Users Section</h4>
                <ul>
                    <li><a href="../login.php">Login</a></li>
                    <li><a href="../customer_registration.php">Register</a></li>
                </ul>
                <hr class="hidden-md hidden-lg hidden-sm">
            </div><!--col-md-3 end-->

            <div class="col-md-3 col-sm-6"><!--col-md-3 start-->
                <h4>Top Product Categories</h4>
                <ul>
                <?php
                        $get_p_cats="select * from product_category";
                        $run_p_cats=mysqli_query($con, $get_p_cats);
                        while($row_p_cat=mysqli_fetch_array($run_p_cats)){
                            $p_cat_id=$row_p_cat['p_cat_id'];
                            $p_cat_title=$row_p_cat['p_cat_title'];
                            echo "<li><a href='shop.php?p_cat=$p_cat_id'> $p_cat_title</a></li>";
                        }
                    ?>
                </ul>
                <hr class="hidden-md hidden-lg">
            </div><!--col-md-3 end-->

            <div class="col-md-3 col-sm-6"> <!--col-md-3 start-->
                <h4>Where to Find Us</h4>
                <p>
                    <strong>Clothify.com</strong>
                    <br>Kishan Nagar
                    <br>Kanpur
                    <br>Uttar Pradesh
                    <br>clothifyinfo@gmail.com
                    <br>+91 953-344-4444
                </p>
                <a href="contact.php">Goto Contact Us Page</a>
                <hr class="hidden-md hidden-lg">
            </div><!--col-md-3 end-->
            
            <div class="col-md-3 col-sm-6"><!--col-md-3 start-->
                <h4>Get the News</h4>
                <p class="text-muted">
                    Subscribe here for getting news of clothify
                </p>
                <form action="" method="post">
                    <div class="input-group">
                        <input type="text" name="email" class="form-control">
                        <span class="input-group-btn">
                            <input type="submit" class="btn btn-default" value="Subscribe">
                        </span>
                    </div>
                </form>
                <h4>Stay in Touch</h4>
                <p class="social">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-x"></i></a>
                    <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#"><i class="fa-solid fa-envelope"></i></a>
                </p>
            </div><!--col-md-3 end-->
        </div><!--row end-->
    </div><!--container end -->
</div><!--footer end -->
        
<div id="copyright"><!--copyright section start-->
    <div class="container">
        <div class="col-md-6">
                <p class="pull-left">
                    &copy; 2024  Clothify
                </p>
        </div>
        <div class="col-md-6">
                <p class="pull-right">
                    Tamplate By: <a href="www.clothify.com">Clothify.com</a>
                </p>
        </div>
    </div>
</div><!--copyright section end-->