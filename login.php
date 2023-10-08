<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
?>

<style>
    /* Additional CSS for better presentation */
    .main-view {
        max-width: 400px;
        margin: 50px auto; /* Vertically and horizontally centered */
    }
    .form-element,
    .form-button,
    .register-link {
        margin-bottom: 20px;
    }
</style>

<!-- Main container of page -->
<div class="container-fluid">
    <div class="row">
        <div class="main-view landingPadding">

            <!-- Login Form -->
            <form action="login_processor.php" method="POST">
                <div class="form-element">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required class="form-control">
                </div>
                <div class="form-element">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required class="form-control">
                </div>
                <div class="form-button">
                    <input type="submit" value="Login" class="btn btn-primary">
                </div>
            </form>

            <!-- Link to create a new account -->
            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Create one now</a>.</p>
            </div>

        </div>
    </div>
</div>
<!-- End main container -->

<?php
include_once 'footer.php';
?>
