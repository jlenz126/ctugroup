<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$itemID = $_POST['itemID'];

if(!isset($_POST['itemName']) && !isset($_POST['itemID'])){
    header("Location: menu.php");
}

if($_POST['itemID'] == 1){
    //code to add appetizer straight to cart
    //redirect back to menu
}
?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
                <?php
                $conn = OpenCon();

                switch ($_POST['categoryID']){
                    case 2:
                        $sql_toppings = "SELECT id, topping_name, premium_topping FROM topping";
                        $result_toppings = $conn->query($sql_toppings);
                        $sql_default_toppings = "SELECT default_topping FROM item WHERE id = $itemID";
                        $result_default_toppings = $conn->query($sql_default_toppings);
                        $toppings_string = $result_default_toppings->fetch_row()[0];
                        
                        echo '<form method="post" action="add_to_cart.php">';
                            if($result_toppings->num_rows >0){
                                while($row = $result_toppings->fetch_assoc()){
                                    $topping_name_display = ucwords(strtolower($row['topping_name']));
                                    $checked = null;
                                    if(str_contains($toppings_string, $row['topping_name'])){
                                        $checked = 'checked=""';
                                    }

                                    echo '<div class="form-check">';
                                        echo '<input class="form-check-input" type="checkbox" name="flexcheck" id="'. $row['topping_name'] .'" value="'. $row['topping_name'] .'" '. $checked .'>';
                                        echo '<label class="form-check-label" for="'. $row['topping_name'] .'">';
                                        echo $topping_name_display;
                                        echo '</label>';
                                    echo '</div>';
                                }
                            }
                        echo '</form>';
                        break;
                    case 3:
                        echo "kid meal";
                        break;
                    case 4:
                        echo "combo";
                        break;
                    case 5:
                        echo "drink";
                        break;
                    default:
                        echo "default";
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