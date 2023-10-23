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

    <div class="row container-fluid serviceCards">
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

    <div class="container-fluid bottom-padding">
		<div class="row">
			<div class="text-center">
                    <?php
                    
                    $totalReviewsQuery = "SELECT COUNT(*) AS total FROM reviews";
                    $totalReviewsResult = $pdo->query($totalReviewsQuery);
                    $totalReviews = $totalReviewsResult->fetch(PDO::FETCH_ASSOC)['total'];

                    
                    $totalPages = ceil($totalReviews / $reviewsPerPage);

                
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a class='btn btn-light btn-sm' href='?page=$i'>$i</a> ";
                    }
                    ?>
                <!-- Button to take customers to the review form -->
                <br>
                <a class="btn btn-light" href="review_form.php" role="button">Leave a Review</a>
			</div>
		</div>
	</div>

<?php
include_once 'footer.php';
?>