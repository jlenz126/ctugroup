<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $rating = $_POST["rating"];
    $reviewText = $_POST["review"];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=pizza_restaurant', 'pizza_user', 'pizza');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO reviews (user_name, rating, reviewText) VALUES (?, ?, ?)";
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
?>