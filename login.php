<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
?>

<style>
    /* Additional CSS for better presentation */

    body {
        padding-top: 275px; /* Adjusted based on navbar's height */
    }
    .main-view {
        max-width: 600px;
        margin: 0 auto; /* Vertically centered and horizontally centered */
        padding: 15px;  /* Some padding for better spacing */
    }
    .form-element,
    .form-button,
    .register-link {
        margin-bottom: 15px;
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
                <div class="form-button text-center">
                    <input type="submit" value="Login" class="btn btn-light btn-lg">
					<input type="reset" value="Clear" class="btn btn-light btn-lg">
                </div>
				<div class="form-button text-center">
					<a class="btn btn-light btn-lg" href="create_account.php" role="button">Create an Account</a>
				</div>
            </form>
        </div>
    </div>
</div>
<!-- End main container -->
<style>
    body {
        background-image: none;			
    }
</style>
<?php
include_once 'footer.php';
?>