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

    <div class="row container-fluid serviceCards landingPadding">
	<?php
        foreach ($reviews as $row){
        echo '<div class="col-sm-12 col-md-4">';
        echo '<div class="card h-100">';
            echo '<div class="card-header custom-colors">';
                echo 'Review ID: ' . $row['id'];
            echo '</div>';
            echo '<div class="card-body custom-colors">';
                echo '<h5 class="card-title">'. $row['rating'] .' stars</h5>';
                echo '<p class="card-text">'. $row['reviewText'] .'</p>';
            echo '</div>';
            
	    echo '</div>';
        
	  echo '</div>';
        }
      ?>
    </div>

    <div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">

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
    <div class="row container-fluid serviceCards">
	  <div class="col-sm-12 col-md-4">
	    <div class="card h-100">
            <div class="card-header custom-colors">
                Header
            </div>
	      <div class="card-body custom-colors">
	        <h5 class="card-title">Featured Item 1</h5>
	        <p class="card-text">description of item</p>
			<!-- <a href="featured1.php" class="btn btn-light">Add to Cart</a> -->
	      </div>
	    </div>
	  </div>
    </div>

<?php
include_once 'footer.php';
?>