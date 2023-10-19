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

if (isset($_POST['username']) && isset($_POST['password'])) {
      
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pizza_restaurant->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        if ($row['employee'] == 1) {
            $_SESSION['employee'] = true;
            header("Location: index.php");
            exit;
        } else {
            echo "You are not authorized as an employee.";
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Login</title>
</head>
<body>
    <h1>Employee Login</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Login">
    </form>
</body>
</html>

<?php
session_start();
session_destroy();

header("Location: login.php");
exit;
?>
