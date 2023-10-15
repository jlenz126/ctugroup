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
            $stmtAddress = $conn->prepare("INSERT INTO address (customer_id, line1, line2, city, country, zipcode, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmtAddress->bind_param("issssi", $userId, $line1, $line2, $city, $country, $zipcode);

            if ($stmtAddress->execute()) {
                $message = "<span style='font-size: 1.5em; color: white;'>Registration successful! <a href='login.php'>Click here to login.</a></span>"; // Informing the user to proceed to the login page
            } else {
                $message = "Error occurred during registration!";
            }
        } else {
            $message = "Error occurred during registration!";
        }
    }
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6"> <!-- Adjusted for grid responsiveness -->
            <h2>Create Account</h2>
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
                    <legend>Home Address</legend>
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

                <div class="mb-3 form-check">
                    <input type="checkbox" id="differentBillingAddress" class="form-check-input">
                    <label for="differentBillingAddress" class="form-check-label">Billing address is different from shipping address</label>
                </div>

                <fieldset class="mt-4" id="billingAddressFields" style="display: none;">
                    <legend>Billing Address</legend>
                    <div class="mb-3">
                        <label for="billingLine1" class="form-label">Address Line 1:</label>
                        <input type="text" name="billingLine1" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="billingLine2" class="form-label">Address Line 2:</label>
                        <input type="text" name="billingLine2" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="billingCity" class="form-label">City:</label>
                        <input type="text" name="billingCity" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="billingCountry" class="form-label">Country:</label>
                        <input type="text" name="billingCountry" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="billingZipcode" class="form-label">Zipcode:</label>
                        <input type="text" name="billingZipcode" class="form-control">
                    </div>
                </fieldset>

                <script>
                    // Using plain JavaScript
                    document.getElementById('differentBillingAddress').addEventListener('change', function() {
                        var billingFields = document.getElementById('billingAddressFields');
                        if (this.checked) {
                            billingFields.style.display = 'block';
                        } else {
                            billingFields.style.display = 'none';
                        }
                    });
                </script>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>

    /* Additional CSS for better presentation */

    body {
        padding-top: 75px; /* Adjusted based on navbar's height */
        padding-bottom: 75px;
    }
    .main-view {
        max-width: 600px;
        margin: 0 auto; /* Vertically centered and horizontally centered */
        padding: 5px;  /* Some padding for better spacing */
    }
</style>

<?php
include_once 'footer.php';
?>
