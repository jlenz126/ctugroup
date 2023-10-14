<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$itemID = $_POST['itemID'];
$conn = OpenCon();
$orderID = 1; //temporay test variable to add to test order create function based off of session variable

function updateTotalPrice ($conn, $orderID, $itemPrice = 0, $addedCharge = 0, $toppingsTotal = 0) {
    $sql_old_total = "SELECT `order_total` FROM `order` WHERE id=$orderID;";
    $result_old_total = $conn->query($sql_old_total);
    $old_total = $result_old_total->fetch_row()[0];
    $new_total = $old_total + $itemPrice + $addedCharge + $toppingsTotal;
    $sql_new_total = "UPDATE `order` SET `order_total` = $new_total WHERE `order`.`id` = $orderID;";
    $conn->query($sql_new_total);
}

function toppingsTotal ($conn, $toppings){
    if ($toppings == 0){
        return 0;
    } else {
        $toppingsTotal = count($toppings);
        $sql_toppings = "SELECT id FROM topping WHERE premium_topping=1;";
        $result_toppings = $conn->query($sql_toppings);

        if($result_toppings->num_rows > 0){
            while($row = $result_toppings->fetch_assoc()){
                if(in_array($row['id'], $toppings)){
                    $toppingsTotal = $toppingsTotal + .5;
                }
            }
        }
        return $toppingsTotal;
        }
}

function pizzaPrice($size){
    switch ($size){
        case 'medium':
            return 12;
        case 'large':
            return 14;
        default:
            return 10;
    }
}

function addPizzaToOrder ($conn, $orderID, $pizzaID, $toppings){
    $sql_add_pizza = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`, `drink_size`, `drink_type`) VALUES (NULL, $orderID, $pizzaID, '1', NULL, NULL);";
    if($conn->query($sql_add_pizza) === TRUE){
        $_SESSION['addedToCartMessage']='pizza added';
    } else {
        $_SESSION['addedToCartMessage']='Failed to add pizza';
    }
    if($toppings != 0){
        $sql_get_order_ID = "SELECT `id` FROM `order_item` WHERE `item_id` = $pizzaID and `order_id` = $orderID ORDER BY `created_at` DESC LIMIT 1;";
        $result_order_id = $conn->query($sql_get_order_ID);
        $orderKey = $result_order_id->fetch_row()[0];
        foreach ($toppings as $value){
            $sql_add_topping = "INSERT INTO `order_topping` (`id`, `topping_id`, `order_id`, `orderitem_id`) VALUES (NULL, $value, $orderID, $orderKey);";
            if($conn->query($sql_add_topping) === TRUE){
                $_SESSION['addedToCartMessage']= $_SESSION['addedToCartMessage'] . ' toppings added';
            } else {
                $_SESSION['addedToCartMessage'] = $_SESSION['addedToCartMessage'] . ' Failed to add toppings';
            }
        }
    }
}

if($_POST['categoryID'] == 1){
    $sql_add_appetizer = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`) VALUES (NULL, $orderID, $itemID, '1');";
    if($conn->query($sql_add_appetizer) === TRUE){
        updateTotalPrice($conn, $orderID, $_POST['itemPrice']);
        $_SESSION['addedToCartMessage']='app added price:';
    } else {
        $_SESSION['addedToCartMessage']='Failed to add appetizer';
    }
    header("Location: menu.php");
}

if($_POST['processCategory'] == 2){ 
    (isset($_POST['toppings'])) ? $toppings = $_POST['toppings'] : $toppings = 0;
    $pizzaID = $_POST['processID'];
    $toppingsTotal = toppingsTotal($conn, $toppings);
    $pizzaString = $_POST['size'];
    $pizzaBasePrice = pizzaPrice($pizzaString);
    addPizzaToOrder($conn, $orderID, $pizzaID, $toppings); 
    updateTotalPrice($conn, $orderID, $pizzaBasePrice, 0, $toppingsTotal);
    header("Location: menu.php");
}

if($_POST['processCategory'] == 3){
    $kidMealID = $_POST['processID'];
    $kidMealPrice = $_POST['itemPrice'];
    $kidMealDrink = $_POST['drink'];

    $sql_add_kid_meal = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`, `drink_size`, `drink_type`) VALUES (NULL, $orderID, $kidMealID, '1', NULL, '$kidMealDrink');";
    if($conn->query($sql_add_kid_meal) === TRUE){
        updateTotalPrice($conn, $orderID, $kidMealPrice);
        $_SESSION['addedToCartMessage']='kids meal id: ' . $kidMealID . ' price ' . $kidMealPrice . ' drink ' . $kidMealDrink;
    } else {
        $_SESSION['addedToCartMessage']= "Failed to add kid's meal";
    }
    header("Location: menu.php");
}
//Code to process combo to cart
// if($_POST['processCategory'] == 4){
//     $_SESSION['addedToCartMessage']='combo added';
//     header("Location: menu.php");
// }

if(isset($_POST['processCategory']) == 5){
    $drinkID = $_POST['drink'];
    $drinkSize = $_POST['size'];
    $drinkPrice = $_POST['drinkPrice'];
    $sql_add_drink = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`, `drink_size`, `drink_type`) VALUES (NULL, $orderID, $drinkID, '1', '$drinkSize', NULL);";

    if($conn->query($sql_add_drink) === TRUE){
        if($drinkSize == "2liter"){
            $drinkPrice = $drinkPrice + 3;
        } 
        updateTotalPrice($conn, $orderID, $drinkPrice);
        $_SESSION['addedToCartMessage']='drink added type: '. $_POST['drink'] . " size " . $_POST['size'];
    } else {
        $_SESSION['addedToCartMessage']= "Failed to add drink";
    }
    
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
                                            echo '<input class="form-check-input" type="checkbox" name="toppings[]" id="'. $row['id'] .'" value="'. $row['id'] .'" '. $checked .'>';
                                            echo '<label class="form-check-label" for="'. $row['id'] .'">';
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
                            $sql_drinks = "SELECT id, item_name FROM item WHERE category_id = 5";
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
                            echo '<input type="hidden" id="processCategory" name="processCategory" value="'. $_POST['categoryID'] .'">';
                            echo '<input type="hidden" id="itemPrice" name="itemPrice" value="'. $_POST['itemPrice'] .'">';
                            echo '<input type="hidden" id="processID" name="processID" value="'. $_POST['itemID'] .'">';
                            echo '</form>';
                            break;
                        case 4: //create code for combos
                            switch ($_POST['itemID']){
                                case 16: //combo 1: 1 slice pizza and 1 small drink
                                    echo "16";
                                    break;
                                case 17: //combo 2: 1 small pizza, 1 large drink, 1 appetizer
                                    echo "17"
                                    break;
                                case 18: //combo 3: 1 medium pizza, 1 large drink, 1 appetizer
                                    echo "18";
                                    break;
                                case 19: //combo 4: 1 large pizza, 2 large drinks, 2 appetizers
                                    echo "19";
                                    break;
                                default:
                                    echo "combo error"; //change to session message error
                            }
                            break;
                        case 5:
                            echo '<form method="post" action="add_to_cart.php">';
                                echo '<select class="form-select form-select-lg mb-3" aria-label="Large select example" name="size">';
                                    echo '<option value="bottle" selected>20oz Bottle</option>';
                                    echo '<option value="2liter">2 Liter +$3.00</option>';
                                echo '</select>';
                            echo '<div class="text-center">';
                            echo '<button type="submit" class="btn btn-light btn-lg">Confirm</button>'; 
                            echo '</div>';
                            echo '<input type="hidden" id="processCategory" name="processCategory" value="'. $_POST['categoryID'] .'">';
                            echo '<input type="hidden" id="drink" name="drink" value="'. $_POST['itemID'] .'">';
                            echo '<input type="hidden" id="drinkPrice" name="drinkPrice" value="'. $_POST['itemPrice'] .'">';
                            echo '</form>';
                            break;
                        default:
                            echo "default"; //change to session error message
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