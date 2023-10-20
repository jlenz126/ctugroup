<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$conn = OpenCon();

$caseID = 0;
$outputMessage = null;

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

    switch($_POST['manageActivity']){
        case 'activeOrders':
            $caseID = $_POST['manageActivity'];
            break;
        case 'manageItem':
            header('Location: manage_item.php');
            break;
        case 'manageInventory':
            header('Location: manage_inventory.php');
            break;
        case 'managePrivileges':
            $caseID = $_POST['manageActivity'];
            break;
        case 'addRights':
            $selectedUserId = $_POST['user_id'];
            $stmt = $conn->prepare("UPDATE user SET employee = 1 WHERE id = ?");
            $stmt->bind_param("i", $selectedUserId);
            $stmt->execute();
            $outputMessage = 'Rights Granted';
            $caseID = 12;
            break;
        default:
            $outputMessage = 'error manageactivity';
            $caseID = 'error';
    }
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
                                    <?php
                            break;
                        case 'activeOrders':
                            echo 'will display active orders'; // add active orders feature
                            header("Refresh:3; url=management_dashboard.php"); //temp for testing
                            break;
                        case 'managePrivileges':
                            $userQuery = "SELECT id, lastname, firstname FROM user WHERE employee = 0"; // Fetch users who are not employees
                            $result = $conn->query($userQuery);

                            if ($result->num_rows > 0) {
                                echo '<form action="management_dashboard.php" method="post">';
                                echo "<label for='user_id'>Select User:</label>";
                                echo "<select  class='form-select form-select-lg mb-3' aria-label='Large select example' name='user_id'>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['lastname'] . ", " . $row['firstname'] ."</option>";
                                }
                                echo "</select><br>";
                                echo '<div class="form-button text-center">';
                                        echo '<input type="submit" value="Grant Employee Access" class="btn btn-light btn-lg">';
                                echo '</div>';
                                echo '<input type="hidden" id="manageActivity" name="manageActivity" value="addRights">';
                                echo "</form>";
                            } else {
                                echo "No users are available to assign employee access.";
                                header("Refresh:3; url=management_dashboard.php");
                            }
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