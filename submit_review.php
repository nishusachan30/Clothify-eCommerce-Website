<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("includes/db.php");

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $product_id = $_POST['product_id'];
    $reviewer_name = $_POST['reviewer_name'];
    $review_text = mysqli_real_escape_string($con, $_POST['review_text']);
    $review_rating = (int) $_POST['review_rating'];
    $review_date = date("Y-m-d H:i:s");

    // Input validation
    if (empty($product_id) || empty($reviewer_name) || empty($review_text) || empty($review_rating)) {
        echo "<script>
                alert('Please fill in all the fields.');
                window.location.href='product-details.php?pro_id=$product_id';
              </script>";
        exit;
    }

    // Check if the rating is within the valid range (1 to 5)
    if ($review_rating < 1 || $review_rating > 5) {
        echo "<script>
                alert('Rating must be between 1 and 5.');
                window.location.href='product-details.php?pro_id=$product_id';
              </script>";
        exit;
    }

    // Insert the review into the database
    $insert_review = "INSERT INTO product_reviews (product_id, reviewer_name, review_text, review_rating, review_date) 
                      VALUES ('$product_id', '$reviewer_name', '$review_text', '$review_rating', '$review_date')";
    $run_review = mysqli_query($con, $insert_review);

    // Check if the query executed successfully
    if ($run_review) {
        // Success: Show success message and redirect to the product details page
        echo "<script>
                alert('Review submitted successfully!');
                window.location.href='product-details.php?pro_id=$product_id';
              </script>";
    } else {
        // Error: Show error message and redirect back to the product details page
        echo "<script>
                alert('Error submitting review. Please try again later.');
                window.location.href='product-details.php?pro_id=$product_id';
              </script>";
    }
} else {
    // Error: The script should only run when the form is submitted via POST
    echo "<script>
            alert('Invalid request method. Please submit the form.');
            window.location.href='product-details.php?pro_id=$product_id';
          </script>";
}
?>
