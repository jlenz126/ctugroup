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
        $sql_get_id_password = $conn->prepare("SELECT `id`,`password`,`employee` FROM `user` WHERE username = ?");
        $sql_get_id_password->bind_param("s", $username);
        $sql_get_id_password->execute();
        $result = $sql_get_id_password->get_result();
        $row = $result->fetch_assoc();


        if(password_verify($password, $row['password'])){
            
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            $_SESSION['employee'] = $row['employee'];

            if(isset($_SESSION['currentOrderID'])){
                $userID = (int)$_SESSION['user_id'];
                $orderID = (int)$_SESSION['currentOrderID'];
                $sql_set_order_id = $conn->prepare("UPDATE `order` SET `customer_id` = ? WHERE `order`.`id` = ?");
                $sql_set_order_id->bind_param("ii", $userID, $orderID);
                $sql_set_order_id->execute();
            }

            // Redirect to a dashboard or main page, for example
            if($_SESSION['employee'] == 1){
                header('Location: management_dashboard.php');
            } else{
                header('Location: index.php');
            }
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
