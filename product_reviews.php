<?php
include("includes/db.php");
?>

<!-- Rating and Review Section -->
<div class="box" id="reviews">
    <h4>Customer Ratings & Reviews</h4>

    <!-- Display Ratings and Reviews -->
    <div class="reviews-container" id="display-reviews">
        <?php
        // Check if the product_id is set to prevent SQL injection and undefined variable errors
        if (isset($pro_id)) {
            $get_reviews = "SELECT * FROM product_reviews WHERE product_id='$pro_id' ORDER BY review_date DESC";
            $run_reviews = mysqli_query($con, $get_reviews);

            if (!$run_reviews) {
                // Display error if the query fails
                echo "<p>Sorry, we couldn't fetch reviews at the moment. Please try again later.</p>";
            } else {
                $total_reviews = mysqli_num_rows($run_reviews);
                $count = 0;

                if ($total_reviews > 0) {
                    while ($row_reviews = mysqli_fetch_array($run_reviews)) {
                        $reviewer_name = $row_reviews['reviewer_name'];
                        $review_text = $row_reviews['review_text'];
                        $review_rating = (int)$row_reviews['review_rating'];
                        $review_date = $row_reviews['review_date'];

                        // Only display the first 4 reviews initially
                        $count++;
                        $display_style = ($count > 4) ? 'style="display:none;"' : '';

                        echo "
                        <div class='review-box' $display_style>
                            <div class='rating'>";

                        // Loop to display stars
                        for ($i = 1; $i <= 5; $i++) {
                            $starClass = $i <= $review_rating ? 'star filled' : 'star';
                            echo "<span class='$starClass'>&#9733;</span>";
                        }

                        echo "</div>
                            <p><strong>$reviewer_name</strong></p>
                            <p>$review_text</p>
                            <small class='review-date'>Reviewed on: $review_date</small>
                        </div>";
                    }
                } else {
                    echo "<p>No reviews yet. Be the first to review this product!</p>";
                }
            }
        } else {
            echo "<p>Product ID is missing. Unable to fetch reviews.</p>";
        }
        ?>
    </div>

    <!-- View More Button -->
    <?php if (isset($total_reviews) && $total_reviews > 4): ?>
        <button id="view-more-btn" class="btn btn-secondary">View More</button>
    <?php endif; ?>

    <!-- Write Review Section -->
    <div id="write-review">
        <h5>Write a Review</h5>
        <form action="submit_review.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($pro_id); ?>">

            <!-- Name Input -->
            <div class="form-group">
                <label for="reviewer_name">Your Name:</label>
                <input type="text" name="reviewer_name" id="reviewer_name" class="form-control" required>
            </div>

            <!-- Star Rating Input -->
            <div class="form-group">
                <label for="rating">Rating:</label>
                <div id="rating-stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <input type="radio" name="review_rating" value="<?php echo $i; ?>" id="star-<?php echo $i; ?>" required>
                        <label for="star-<?php echo $i; ?>" class="star">&#9733;</label>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Review Text Input -->
            <div class="form-group">
                <label for="review_text">Review:</label>
                <textarea name="review_text" id="review_text" class="form-control" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>
</div>
<!-- End of Rating and Review Section -->
