<?php
session_start();

if (isset($_SESSION['employee']) && $_SESSION['employee'] === true) {
    echo "Welcome to the Employee Login Page.";
    echo "<a href='logout.php'>Logout</a>";
} else {
    header("Location: login.php");
    exit;
}
?>

<?php
session_start();

if (isset($_SESSION['employee']) && $_SESSION['employee'] === true) {
    echo "Welcome to the Employee Login Page.";
    echo "<a href='logout.php'>Logout</a>";
} elseif (isset($_SESSION['manager']) && $_SESSION['manager'] === true) {
    echo "Welcome to the Manager Login Page.";
    echo "<a href='assign_employee.php'>Assign Employee Access</a>";
    echo "<a href='logout.php'>Logout</a>";
} else {
    header("Location: login.php");
    exit;
}
?>

<?php
session_start();

if (isset($_SESSION['manager']) && $_SESSION['manager'] === true) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
        // Process the form to assign employee access
        $selectedUserId = $_POST['user_id'];
        $stmt = $pizza_restaurant->prepare("UPDATE users SET employee = 1 WHERE id = ?");
        $stmt->bind_param("i", $selectedUserId);
        $stmt->execute();
        echo "Employee access assigned successfully!";
    } else {
        $userQuery = "SELECT id, username FROM users WHERE employee = 0"; // Fetch users who are not employees
        $result = $pizza_restaurant->query($userQuery);

        if ($result->num_rows > 0) {
            echo "<form method='post'>";
            echo "<label for='user_id'>Select User:</label>";
            echo "<select name='user_id'>";
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
            }
            echo "</select><br>";
            echo "<input type='submit' value='Assign Employee Access'>";
            echo "</form>";
        } else {
            echo "No users are available to assign employee access.";
        }
    }
} else {
    echo "You are not authorized to access this page.";
}
?>
