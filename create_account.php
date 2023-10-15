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
    $employee = isset($_POST['employee']) ? true : false;
    $line1 = $_POST['line1'];
    $line2 = $_POST['line2'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $zipcode = $_POST['zipcode'];
    

    // If validation is successful:
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO user (username, password, firstname, lastname, employee, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssb", $username, $hashed_password, $firstname, $lastname, $employee);

    if ($stmt->execute()) {
        // Insert address after the user registration is successful
        $userId = $conn->insert_id;
        $stmtAddress = $conn->prepare("INSERT INTO address (customer_id, line1, line2, city, country, zipcode, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmtAddress->bind_param("issssi", $userId, $line1, $line2, $city, $country, $zipcode);

        if ($stmtAddress->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Error occurred during registration!";
        }
    } else {
        $message = "Error occurred during registration!";
    }
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6"> <!-- Adjusted for grid responsiveness -->
            <h2>Registration</h2>
            <p class="text-danger"><?= $message; ?></p>

            <form action="create_account.php" method="POST" class="mt-3">
                <fieldset>
                    <legend>User Information</legend>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name:</label>
                        <input type="text" name="firstname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name:</label>
                        <input type="text" name="lastname" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="employee" class="form-check-input" id="employee">
                        <label for="employee" class="form-check-label">Is Employee?</label>
                    </div>
                </fieldset>

                <fieldset class="mt-4">
                    <legend>Address Information</legend>
                    <div class="mb-3">
                        <label for="line1" class="form-label">Address Line 1:</label>
                        <input type="text" name="line1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="line2" class="form-label">Address Line 2:</label>
                        <input type="text" name="line2" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City:</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country:</label>
                        <input type="text" name="country" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="zipcode" class="form-label">Zipcode:</label>
                        <input type="text" name="zipcode" class="form-control" required>
                    </div>
                </fieldset>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once 'footer.php';
?>
