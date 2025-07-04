<?php
    $db=mysqli_connect("localhost", "root", "", "clothify");
    function getPro(){
        global $db;
        $get_product="select * from products order by 1 DESC LIMIT 0,6";
        $run_products=mysqli_query($db, $get_product);
        while($row_product=mysqli_fetch_array($run_products)){
            $pro_id=$row_product['product_id'];
            $pro_title=$row_product['product_title'];
            $pro_price=$row_product['product_price'];
            $pro_img1=$row_product['product_img1'];

            echo  "<div class='col-sm-4 col-sm-6 single'>
            <div class='product'>
            <a href='product-details.php?pro_id=$pro_id'>
                    <img src='admin_area/product_images/$pro_img1' class='img-responsive'>
                    </a>
                    <div class='text'>
                        <h3> <a href='product-details.php?pro_id'>$pro_title </a> </h3>
                        <p class='price'> ₹ $pro_price </p>
                        <p class='buttons'>
                            <a href='product-details.php?pro_id' class='btn btn-default'>View Details </a> 
                            <a href='product-details.php?pro_id' class='btn btn-primary'><i class='fa fa-cart-shopping'></i>Add to Cart </a> 
                        </p>
                </div>
            </div>
        </div>";
     }
    }

    
?>
       