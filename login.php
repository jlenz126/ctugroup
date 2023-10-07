<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
?>

	<!-- Main container of page -->
<div class="container-fluid">
    <div class="row">
        <div class="main-view landingPadding">
            <!-- Login form with fields for username and password -->
            <form action="your_login_script.php" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <!-- Link to create a new account -->
            <p>Don't have an account? <a href="register.php">Create a new account</a></p>
        </div>
    </div>
</div>
	<!-- End main container -->
<?php
include_once 'footer.php';
?>
