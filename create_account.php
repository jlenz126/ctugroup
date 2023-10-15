<?php
global $conn;
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $employee = isset($_POST['employee']) ? 1 : 0;
    $line1 = $_POST['line1'];
    $line2 = $_POST['line2'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $zipcode = $_POST['zipcode'];

    // Check if username already exists in the database
    $checkUsername = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $checkUsername->bind_param("s", $username);
    $checkUsername->execute();
    $result = $checkUsername->get_result();

    if ($result->num_rows > 0) {
        // Username already exists
        $message = "<span style='font-size: 1.5em; color: white;'>Username is already taken!</span>";
    } else {
        // If validation is successful:
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO user (username, password, firstname, lastname, employee, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssi", $username, $hashed_password, $firstname, $lastname, $employee);

        if ($stmt->execute()) {
            // Insert address after the user registration is successful
            $userId = $conn->insert_id;

            // Insert the shipping address
            $stmtAddress = $conn->prepare("INSERT INTO address (customer_id, line1, line2, city, country, zipcode, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmtAddress->bind_param("issssi", $userId, $line1, $line2, $city, $country, $zipcode);

            if ($stmtAddress->execute()) {
                $message = "<span style='font-size: 1.5em; color: white;'>Registration successful! <a href='login.php'>Click here to login.</a></span>";

                // Check if billing address is different and insert it
                if (isset($_POST['billingLine1']) && !empty($_POST['billingLine1'])) {
                    $billingLine1 = $_POST['billingLine1'];
                    $billingLine2 = $_POST['billingLine2'];
                    $billingCity = $_POST['billingCity'];
                    $billingCountry = $_POST['billingCountry'];
                    $billingZipcode = $_POST['billingZipcode'];

                    $stmtBillingAddress = $conn->prepare("INSERT INTO address (customer_id, line1, line2, city, country, zipcode, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
                    $stmtBillingAddress->bind_param("issssi", $userId, $billingLine1, $billingLine2, $billingCity, $billingCountry, $billingZipcode);

                    if (!$stmtBillingAddress->execute()) {
                        $message .= " However, there was an error saving your billing address.";
                    }
                }
            } else {
                $message = "Error occurred during registration!";
            }
        } else {
            $message = "Error occurred during registration!";
        }
    }
}
