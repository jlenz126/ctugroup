<?php

include_once 'session.php';
include_once 'db_connection.php'; // Includes database connection details

// Initialize a variable to store error/success messages
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Server-side validation (always ensure you validate input data)
    if (empty($username) || empty($password)) {
        $message = "All fields are required!";
    } else {
        // Fetch the user from the database using the provided username
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        // If user exists and password matches
        if ($user && password_verify($password, $user['password'])) {
            // Store user data in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to a dashboard or main page, for example
            header('Location: index.php');
            exit;
        } else {
            $message = "Invalid username or password!";
        }
    }
}

// If there's a message (e.g., error message), display it to the user
if ($message) {
    echo '<div class="alert alert-danger">' . $message . '</div>';
    // Redirect back to the login page after displaying the message
    header("Refresh:3; url=login.php");
}
?>

