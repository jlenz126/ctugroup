<?php
global $conn;
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';  // Ensure this includes your database connection info

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Server-side validation
    if (empty($username) || empty($password) || empty($email)) {
        $message = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } else {
        // Check for unique username
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Username already exists!";
        } else {
            // Password complexity check using regex (at least one number, one uppercase, one lowercase, and 8 characters)
            if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password)) {
                $message = "Password must have at least one number, one uppercase letter, one lowercase letter, and be at least 8 characters!";
            } else {
                // Hashing the password and inserting into the database
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $hashed_password, $email);
                if ($stmt->execute()) {
                    $message = "Registration successful!";
                } else {
                    $message = "Error occurred during registration!";
                }
            }
        }
    }
}
?>


<style>
    body {
        padding-top: 275px;  /* Adjusted based on navbar height */
    }

</style>

<div class="container-fluid">
    <div class="row">
        <div class="main-view landingPadding">

            <?php echo $message; ?>

            <form action="" method="POST">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div>
                    <input type="submit" value="Register">
                </div>
            </form>

        </div>
    </div>
</div>

<?php
include_once 'footer.php';
?>

