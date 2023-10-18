<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$conn = OpenCon();

// if (isset($_POST['name'])) {
//     // $name = $_POST['name'];
//     // $rating = $_POST['rating'];
//     // $reviewText = $_POST['review'];

//     // $name = '';
//     // $rating = 0;
//     // $reviewText = '';

//     if(isset($_POST['name'])){
//         $name = $_POST['name'];
//     }
//     if(isset($_POST['rating'])){
//         $rating = $_POST['rating'];
//     }
//     if(isset($_POST['review'])){
//         $reviewText = $_POST['review'];
//     }

//     try {
//         $pdo = new PDO('mysql:host=localhost;dbname=pizza_restaurant', 'pizza_user', 'pizza');
//         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//         $query = "INSERT INTO reviews (user_name, rating, reviewText) VALUES (?, ?, ?)";
//         $stmt = $pdo->prepare($query);
//         $stmt->execute([$name, $rating, $reviewText]);

//         header("Location: reviews.php");
//         exit;
//     } catch (PDOException $e) {
//         echo "Error: " . $e->getMessage();
//     }
// } else {
//     //echo $reviewError = 'Error saving review';
//     exit;
// }
?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
                <h1>Leave a Review</h1>

                <form action="review_processor.php" method="post">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="rating">Rating (1-5):</label>
                    <input type="number" id="rating" name="rating" min="1" max="5" required>

                    <label for="review">Review:</label>
                    <textarea id="review" name="review" rows="4" required></textarea>

                    <input type="submit" value="Submit Review">
                </form>
			</div>
		</div>
	</div>
	<!-- End main container -->


<?php
CloseCon($conn);
include_once 'footer.php';
?>