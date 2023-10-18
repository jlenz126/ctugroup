<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';

$pdo = new PDO('mysql:host=localhost;dbname=pizza_restaurant', 'pizza_user', 'pizza');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$reviewsPerPage = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($page - 1) * $reviewsPerPage;

$query = "SELECT * FROM reviews ORDER BY rating DESC LIMIT $offset, $reviewsPerPage";

$reviews = $pdo->query($query);
?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
			<?php
    foreach ($reviews as $row) {
        echo "Review ID: " . $row['id'] . "<br>";
        echo "Rating: " . $row['rating'] . " stars<br>";
        echo "Review: " . $row['reviewText'] . "<br><br>";
    }
    ?>

    <!-- Pagination links -->
    <div class="pagination">
        <?php
        
        $totalReviewsQuery = "SELECT COUNT(*) AS total FROM reviews";
        $totalReviewsResult = $pdo->query($totalReviewsQuery);
        $totalReviews = $totalReviewsResult->fetch(PDO::FETCH_ASSOC)['total'];

        
        $totalPages = ceil($totalReviews / $reviewsPerPage);

       
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='?page=$i'>$i</a> ";
        }
        ?>
    </div>

    <!-- Button to take customers to the review form -->
    <a href="review_form.php">Leave a Review</a>
			</div>
		</div>
	</div>
	<!-- End main container -->


<?php
include_once 'footer.php';
?>