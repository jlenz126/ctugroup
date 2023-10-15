<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<!-- List ten reviews per page, default order from best to worst -->
			</div>
		</div>
	</div>
	<!-- End main container -->


<?php
include_once 'footer.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Reviews</title>
</head>
<body>
    <h1>Restaurant Reviews</h1>
    
    <!-- Display existing reviews here -->
    <?php
    // Replace this with code to fetch and display existing reviews from a database
    echo "Existing Review 1: 5 stars - Excellent service, highly recommended!";
    echo "Existing Review 2: 4 stars - Good food, but the service could improve.";
    // ...
    ?>

    <!-- Button to take customers to the review form -->
    <a href="review_form.php">Leave a Review</a>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Leave a Review</title>
</head>
<body>
    <h1>Leave a Review</h1>
    
    <form action="submit_review.php" method="post">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="rating">Rating (1-5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>

        <label for="review">Review:</label>
        <textarea id="review" name="review" rows="4" required></textarea>

        <input type="submit" value="Submit Review">
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $rating = $_POST["rating"];
    $reviewText = $_POST["review"];

    // Save the review to a database (you need to implement this part)

    // Redirect back to the initial reviews page
    header("Location: reviews.php");
    exit;
}
?>
