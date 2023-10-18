<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$conn = OpenCon();

$caseID = null;
$totalItems = 0;

if(isset($_POST)){
    
    $sql_total_items = "SELECT MAX(`id`) FROM `item`";
    $result_total_items = $conn->query($sql_total_items);
    $totalItems = $result_total_items->fetch_row()[0];

    for($i = 0; $i <= $totalItems; $i++){
        if(isset($_POST[$i])){
            $caseID = $i;
        }
    }

    if(isset($_POST['newAppetizer'])){
        $caseID = 'newAppetizer';
    }
    if(isset($_POST['newPizza'])){
        $caseID = 'newPizza';
    }
    if(isset($_POST['newKid'])){
        $caseID = 'newKid';
    }
    if(isset($_POST['newCombo'])){
        $caseID = 'newCombo';
    }
    if(isset($_POST['newDrink'])){
        $caseID = 'newDrink';
    }
}
?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<!-- Content here -->
                <?php 
                switch((string)$caseID){
                    case 'newAppetizer':
                        echo $caseID;
                        break;
                    case 'newPizza':
                        echo $caseID;
                        break;
                    case 'newKid':
                        echo $caseID;
                        break;
                    case 'newCombo':
                        echo $caseID;
                        break;
                    case 'newDrink':
                        echo $caseID;
                        break;
                    default:
                        echo $caseID;
                        echo 'default';
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
