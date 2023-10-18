<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$conn = OpenCon();

if(isset($_POST)){
    
    for($i = 0; $i < 25; $i++){
        if(isset($_POST[$i])){
            echo 'item id: ' . $i;
        }
    }

    if(isset($_POST['newDrink'])){
        echo 'newDrink';
    }
    if(isset($_POST['newPizza'])){
        echo 'pizza';
    }
}
?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<!-- Content here -->
			</div>
		</div>
	</div>
	<!-- End main container -->


<?php
CloseCon($conn);
include_once 'footer.php';
?>
