<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$conn = OpenCon();

$caseID = 0;
$outputMessage = null;

$_SESSION['employee'] = 1; // Remove after testing

// Check if admin rights
if(isset($_SESSION['employee'])){
    if($_SESSION['employee'] != 1){
        header('Location: index.php');
    }
}else{
    header('Location: index.php');
}

if(isset($_POST['manageActivity'])){
    $outputMessage = $_POST['manageActivity'];
    $caseID = 3;
}
?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<!-- Content here -->
                <?php
                    switch($caseID){
                        case 0:
                            ?>
                                <form action="management_dashboard.php" method="post">
                                    <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="manageActivity">
                                        <option value="activeOrders" selcted>Active Orders</option>
                                        <option value="manageItem">Edit Item</option>
                                        <option value="manageInventory">Inventory</option>
                                        <option value="managePrivileges">Manage Privileges</option>
                                    </select>
                                    <div class="form-button text-center">
                                        <input type="submit" value="Access" class="btn btn-light btn-lg">
                                    </div>
                                    <!-- <input type="hidden" id="itemDescription" name="itemDescription" value="">
                                    <input type="hidden" id="itemPrice" name="itemPrice" value="10">
                                    <input type="hidden" id="categoryID" name="categoryID" value="2">
                                    <input type="hidden" id="process" name="process" value="2"> -->
                                    <?php
                            break;
                        default:
                            echo 'default <br>';
                            echo $outputMessage; //test output
                            header("Refresh:3; url=management_dashboard.php");
                    }
                ?>
			</div>
		</div>
	</div>
	<!-- End main container -->


<?php
CloseCon($conn);
include_once 'footer.php';
?>