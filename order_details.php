<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php'; 
$conn = OpenCon();
(isset($_POST['orderID'])) ? $orderID = $_POST['orderID'] : $orderID = 0;

// Check if admin rights 
if(isset($_SESSION['employee'])){
    if($_SESSION['employee'] != 1){
        header('Location: index.php');
    }
}else{
    header('Location: index.php');
}

?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<?php
							$sql_order_items = $conn->prepare("SELECT `item_id`, `quantity`, `drink_size`, `drink_type`, `pizza_type`, `appetizer_type` FROM `order_item` WHERE order_id = ?");
							$sql_order_items->bind_param("i", $orderID);
                            $sql_order_items->execute();
							$result_order_items = $sql_order_items->get_result();

                            $sql_get_item_names = $conn->prepare("SELECT `id`, `item_name` FROM `item`");
							$sql_get_item_names->execute();
							$result_item_names = $sql_get_item_names->get_result();
							$array_item_name = [];
							$total = 0;
				
							while($row = $result_item_names->fetch_assoc()){
								$array_item_name[$row['id']] = $row['item_name'];
							}
							
							echo '<table class="table">';
								echo '<thead>';
									echo '<tr>';
									echo '<th scope="col">Item Name</th>';
									echo '<th scope="col">Quantity</th>';
                                    echo '<th scope="col">Drink Size</th>';
									echo '<th scope="col">Drink Type</th>';
                                    echo '<th scope="col">Pizza Type</th>';
                                    echo '<th scope="col">Appetizer Type</th>';
									echo '</tr>';
								echo '</thead>';
								echo '<tbody>';
								while ($row = $result_order_items->fetch_assoc()){
									$item_name_display = ucwords(strtolower($array_item_name[$row['item_id']]));
									echo '<tr>';
									echo '<td>' . $item_name_display . '</td>';
									echo '<td>' . $row['quantity'] . '</td>';
                                    echo '<td>' . $row['drink_size'] . '</td>';
                                    echo '<td>' . $row['drink_type'] . '</td>';
									echo '<td>' . $row['pizza_type'] . '</td>';
                                    echo '<td>' . $row['appetizer_type'] . '</td>';
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