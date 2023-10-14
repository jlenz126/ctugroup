<?php

include_once 'session.php';
include_once 'db_connection.php'; // Includes database connection details
$conn = OpenCon();

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
        $sql_get_password = "SELECT `password` FROM `user` WHERE username = '$username'";
        $result_get_password = $conn->query($sql_get_password);
        $result_password_string = $result_get_password->fetch_row()[0];

        if(password_verify($password, $result_password_string)){
            $sql_get_ID = "SELECT `id` FROM `user` WHERE username = '$username'";
            $result_get_ID = $conn->query($sql_get_ID);
            $userID = $result_get_ID->fetch_row()[0];
            
            $_SESSION['user_id'] = $userID;
            $_SESSION['username'] = $username;

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
