<?php
include_once 'footer.php';

$pdo = new PDO('mysql:host=localhost;dbname=pizza_restaurant', 'your_username', 'your_password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$reviewsPerPage = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($page - 1) * $reviewsPerPage;

$query = "SELECT * FROM reviews ORDER BY rating DESC LIMIT $offset, $reviewsPerPage";

$reviews = $pdo->query($query);

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

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=pizza_restaurant', 'your_username', 'your_password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO reviews (name, rating, reviewText) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $rating, $reviewText]);

        header("Location: reviews.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: review_form.php");
    exit;
}

