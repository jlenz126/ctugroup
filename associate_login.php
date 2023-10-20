<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define your credentials here (replace 'your_username' and 'your_password' with actual values)
    $valid_username = 'your_username';
    $valid_password = 'your_password';

    // Get the posted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the credentials are valid
    if ($username === $valid_username && $password === $valid_password) {
        // Redirect to the associate dashboard or any other page after successful login
        header("Location: associate_dashboard.php");
        exit();
    } else {
        // Show an error message for invalid credentials
        echo "Invalid username or password. Please try again.";
    }
}
?>