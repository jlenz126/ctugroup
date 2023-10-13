<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$itemID = $_POST['itemID'];
$conn = OpenCon();
$orderID = 1; //temporay test variable to add to test order

function updateTotalPrice ($conn, $orderID) {
    $sql_old_total = "SELECT `order_total` FROM `order` WHERE id=$orderID;";
    $result_old_total = $conn->query($sql_old_total);
    $old_total = $result_old_total->fetch_row()[0];
    $new_total = $old_total + $_POST['itemPrice'];
    $sql_new_total = "UPDATE `order` SET `order_total` = $new_total WHERE `order`.`id` = $orderID;";
    $conn->query($sql_new_total);
}

if($_POST['categoryID'] == 1){
    $sql_add_appetizer = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`) VALUES (NULL, $orderID, $itemID, '1');";
    if($conn->query($sql_add_appetizer) === TRUE){
        updateTotalPrice($conn, $orderID);
        $_SESSION['addedToCartMessage']='app added price:';
    } else {
        $_SESSION['addedToCartMessage']='Failed to add appetizer';
    }

    header("Location: menu.php");
}

if($_POST['processCategory'] == 2){ //code to process pizza to cart
    $_SESSION['addedToCartMessage']='pizza added';
    header("Location: menu.php");
}

//Code to process kids meal to cart
if($_POST['processCategory'] == 3){
    $_SESSION['addedToCartMessage']='kids meal added';
    header("Location: menu.php");
}
//Code to process combo to cart
if($_POST['processCategory'] == 4){
    $_SESSION['addedToCartMessage']='combo added';
    header("Location: menu.php");
}
//Code to process drink to cart
if($_POST['processCategory'] == 5){
    $_SESSION['addedToCartMessage']='drink added';
    header("Location: menu.php");
}
?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
                <?php

                if(isset($_POST['categoryID'])){
                    switch ($_POST['categoryID']){
                        case 2:
                            $sql_toppings = "SELECT id, topping_name, premium_topping FROM topping";
                            $result_toppings = $conn->query($sql_toppings);
                            $sql_default_toppings = "SELECT default_topping FROM item WHERE id = $itemID";
                            $result_default_toppings = $conn->query($sql_default_toppings);
                            $toppings_string = $result_default_toppings->fetch_row()[0];

                            echo '<form method="post" action="add_to_cart.php">';
                                echo '<select class="form-select form-select-lg mb-3" aria-label="Large select example" name="size">';
                                    echo '<option value="small" selected>Small</option>';
                                    echo '<option value="medium">Medium +$2.00</option>';
                                    echo '<option value="large">Large +$4.00</option>';
                                echo '</select>';
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
                                echo '<div class="text-center">';
                                echo '<button type="submit" class="btn btn-light btn-lg">Confirm</button>'; 
                                echo '</div>';
                                echo '<input type="hidden" id="processID" name="processID" value="'. $_POST['itemID'] .'">';
                                echo '<input type="hidden" id="processCategory" name="processCategory" value="'. $_POST['categoryID'] .'">';
                            echo '</form>';
                            break;
                        case 3:
                            $sql_drinks = "SELECT item_name FROM item WHERE category_id = 5";
                            $result_drinks = $conn->query($sql_drinks);
                            
                            echo '<form method="post" action="add_to_cart.php">';
                                echo '<select id="drink-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="drink">';
                                echo '<option></option>';
                                    if($result_drinks->num_rows > 0){
                                        while($row = $result_drinks->fetch_assoc()){
                                            $drink_name_display = ucwords(strtolower($row['item_name']));
                                            echo '<option value="'. $row['item_name'] .'">'. $drink_name_display .'</option>';
                                        }
                                    }
                                echo '</select>';
                            echo '<div class="text-center">';
                            echo '<button type="submit" class="btn btn-light btn-lg">Confirm</button>'; 
                            echo '</div>';
                            echo '<input type="hidden" id="processID" name="processID" value="'. $_POST['itemID'] .'">';
                            echo '</form>';
                            break;
                        case 4:
                            echo "combo";
                            break;
                        case 5:
                            $sql_drinks = "SELECT item_name FROM item WHERE category_id = 5";
                            $result_drinks = $conn->query($sql_drinks);
                            
                            echo '<form method="post" action="add_to_cart.php">';
                                echo '<select class="form-select form-select-lg mb-3" aria-label="Large select example" name="size">';
                                    echo '<option value="can" selected>20oz Bottle</option>';
                                    echo '<option value="2liter">2 Liter +$3.00</option>';
                                echo '</select>';
                                echo '<select id="drink-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="drink">';
                                echo '<option></option>';
                                    if($result_drinks->num_rows > 0){
                                        while($row = $result_drinks->fetch_assoc()){
                                            $drink_name_display = ucwords(strtolower($row['item_name']));
                                            echo '<option value="'. $row['item_name'] .'">'. $drink_name_display .'</option>';
                                        }
                                    }
                                echo '</select>';
                            echo '<div class="text-center">';
                            echo '<button type="submit" class="btn btn-light btn-lg">Confirm</button>'; 
                            echo '</div>';
                            echo '<input type="hidden" id="processID" name="processID" value="'. $_POST['itemID'] .'">';
                            echo '</form>';
                            break;
                        default:
                            echo "default";
                    }
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