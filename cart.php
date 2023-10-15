<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php'; 
$conn = OpenCon();
$activeOrderID = 0;
$deleted = "";

if(isset($_SESSION['currentOrderID'])){
	$activeOrderID = $_SESSION['currentOrderID'];
}

if(isset($_POST['itemID'])){
	$itemID = (int)$_POST['itemID'];
	$sql_delete_item = "DELETE FROM `order_item` WHERE `id` = $itemID";
	if($conn->query($sql_delete_item) === TRUE){
		$deleted = "success";
	} else {
		$deleted = "failed";
	}
	//header('Location: cart.php');
}

?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<?php
					switch ($activeOrderID){
						case 0:
							echo "Shopping Cart Empty";
							break;
						default:
							$sql_get_order_items = $conn->prepare("SELECT `id`,`item_id`, `item_price` FROM `order_item` WHERE order_id = ?");
							$sql_get_order_items->bind_param("i", $activeOrderID);
							$sql_get_order_items->execute();
							$result_order_items = $sql_get_order_items->get_result();

							$sql_get_item_names = $conn->prepare("SELECT `id`, `item_name` FROM `item`");
							$sql_get_item_names->execute();
							$result_item_names = $sql_get_item_names->get_result();
							$array_item_name = [];
							$total = 0;
							//echo $itemID;
							while($row = $result_item_names->fetch_assoc()){
								$array_item_name[$row['id']] = $row['item_name'];
							}
							echo '<table class="table">';
								echo '<thead>';
									echo '<tr>';
									echo '<th scope="col">Item</th>';
									echo '<th scope="col">Price</th>';
									echo '<th scope="col"></th>';
									echo '</tr>';
								echo '</thead>';
								echo '<tbody>';
								while ($row = $result_order_items->fetch_assoc()){
									$item_name_display = ucwords(strtolower($array_item_name[$row['item_id']]));
									$item_price = number_format((float)$row['item_price'], 2,'.','');
									$total = $total + $row['item_price'];
									echo '<tr>';
									echo '<td>' . $item_name_display . '</td>';
									echo '<td>$' . $item_price . '</td>';
									echo '<td>';
										echo '<form method="post" action="cart.php">';
                            			echo '<input type="hidden" id="itemID" name="itemID" value="'. $row['id'] .'">';
                            			echo '<button type="submit" class="btn btn-light">Remove from Cart</button>'; 
                            			echo '</form>';
									echo '</td>';
									echo '</tr>';
								}
									echo '<tr>';
									echo '<th scope="row">' . 'Total' . '</th>';
									echo '<td>$' . number_format((float)$total, 2,'.','') . '</td>';
									echo '<td>';
										echo '<form method="post" action="checkout.php">';
                            			echo '<button type="submit" class="btn btn-light">Checkout</button>'; 
                            			echo '</form>';
									echo '</td>';
								echo '</tbody>';
					}
				?>
				</table>
			</div>
		</div>
	</div>
	<!-- End main container -->


<?php
include_once 'footer.php';
?>