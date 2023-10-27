<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php'; 
$conn = OpenCon();
$deleted = 0;

// Check if admin rights commented out for testing
if(isset($_SESSION['employee'])){
    if($_SESSION['employee'] != 1){
        header('Location: index.php');
    }
}else{
    header('Location: index.php');
}

if(isset($_POST['orderID'])){
    $orderID = $_POST['orderID'];
    $sql_set_order_id = $conn->prepare("UPDATE `order` SET `cooked` = 1 WHERE `order`.`id` = ?");
    $sql_set_order_id->bind_param("i", $orderID);
    $sql_set_order_id->execute();
}

?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<?php
							$sql_get_active_orders = $conn->prepare("SELECT `id`, `customer_id`, `order_total` FROM `order` WHERE `fulfilled` = 1 and `cooked` = 0");
							$sql_get_active_orders->execute();
							$result_active_orders = $sql_get_active_orders->get_result();
							
							echo '<table class="table">';
								echo '<thead>';
									echo '<tr>';
									echo '<th scope="col">Order ID</th>';
									echo '<th scope="col">Customer ID</th>';
                                    echo '<th scope="col">Order Total</th>';
									echo '<th scope="col"></th>';
                                    echo '<th scope="col"></th>';
									echo '</tr>';
								echo '</thead>';
								echo '<tbody>';
								while ($row = $result_active_orders->fetch_assoc()){
									$orderID = $row['id'];
									echo '<tr>';
									echo '<td>' . $row['id'] . '</td>';
									echo '<td>' . $row['customer_id'] . '</td>';
                                    echo '<td>$' . number_format((float)$row['order_total'], 2,'.','') . '</td>';
									echo '<td>';
										echo '<form method="POST" action="order_details.php">';
                            			echo '<input type="hidden" id="orderID" name="orderID" value="'. $row['id'] .'">';
                            			echo '<button type="submit" class="btn btn-light">View Details</button>'; 
                            			echo '</form>';
									echo '</td>';
                                    echo '<td>';
										echo '<form method="POST" action="active_orders.php">';
                            			echo '<input type="hidden" id="orderID" name="orderID" value="'. $row['id'] .'">';
                            			echo '<button type="submit" class="btn btn-light">Cooked</button>'; 
                            			echo '</form>';
									echo '</td>';
									echo '</tr>';
								}
								echo '</tbody>';
				?>
				</table>
			</div>
		</div>
	</div>
	<div class="bottom-padding">

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