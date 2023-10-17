<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
include_once 'current_order.php';
$itemID = $_POST['itemID'];
$conn = OpenCon();
$process = 0;

if(!isset($_SESSION['currentOrderID'])){ //Creates session variable for a user without a current order or creates a guest order
    createOrder($conn);
}

$orderID = $_SESSION['currentOrderID']; 

if(isset($_POST['processCategory'])){
    $process = $_POST['processCategory'];
}
if(isset($_POST['categoryID']) && ($_POST['categoryID'] == 1)){
    $process = 1;
}

function updateTotalPrice ($conn, $orderID, $item_ID, $itemPrice = 0, $addedCharge = 0, $toppingsTotal = 0) {
    $sql_old_total = "SELECT `order_total` FROM `order` WHERE id=$orderID;";
    $result_old_total = $conn->query($sql_old_total);
    $old_total = $result_old_total->fetch_row()[0];
    $new_total = $old_total + $itemPrice + $addedCharge + $toppingsTotal;
    $sql_new_total = "UPDATE `order` SET `order_total` = $new_total WHERE `order`.`id` = $orderID;";
    $conn->query($sql_new_total);
    $item_total = (float)$itemPrice + $addedCharge + $toppingsTotal;
    $_SESSION['itemTotal'] = $item_total;
    $item_ID_converted = (int)$item_ID;
    $_SESSION['itemid'] = $item_total;
    $sql_update_item_price = "UPDATE `order_item` SET `item_price` = $item_total WHERE `order_item`.`id` = $item_ID_converted;";
    $conn->query($sql_update_item_price);
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

function getItemID ($conn, $orderID, $itemID){
    $sql_get_item_ID = "SELECT `id` FROM `order_item` WHERE `item_id` = $itemID and `order_id` = $orderID ORDER BY `created_at` DESC LIMIT 1;";
    $result_order_id = $conn->query($sql_get_item_ID);
    $itemKey = (int)$result_order_id->fetch_row()[0];
    return $itemKey;
}

if($process == 1){
    $sql_add_appetizer = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`) VALUES (NULL, $orderID, $itemID, '1');";
    if($conn->query($sql_add_appetizer) === TRUE){
        $item_ID = getItemID($conn, $orderID, $itemID);
        updateTotalPrice($conn, $orderID, $item_ID, $_POST['itemPrice']);
        $_SESSION['addedToCartMessage']='app added price:';
    } else {
        $_SESSION['addedToCartMessage']='Failed to add appetizer';
    }
    header("Location: menu.php");
}

if($process == 2){ 
    (isset($_POST['toppings'])) ? $toppings = $_POST['toppings'] : $toppings = 0;
    $pizzaID = $_POST['processID'];
    $toppingsTotal = toppingsTotal($conn, $toppings);
    $pizzaString = $_POST['size'];
    $pizzaBasePrice = pizzaPrice($pizzaString);
    addPizzaToOrder($conn, $orderID, $pizzaID, $toppings);
    $item_ID = getItemID($conn, $orderID, $pizzaID);
    updateTotalPrice($conn, $orderID, $item_ID, $pizzaBasePrice, 0, $toppingsTotal);
    header("Location: menu.php");
}

if($process == 3){
    $kidMealID = $_POST['processID'];
    $kidMealPrice = $_POST['itemPrice'];
    $kidMealDrink = $_POST['drink'];

    $sql_add_kid_meal = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`, `drink_size`, `drink_type`) VALUES (NULL, $orderID, $kidMealID, '1', NULL, '$kidMealDrink');";
    if($conn->query($sql_add_kid_meal) === TRUE){
        $item_ID = getItemID($conn, $orderID, $kidMealID);
        updateTotalPrice($conn, $orderID, $item_ID, $kidMealPrice);
        $_SESSION['addedToCartMessage']='kids meal id: ' . $kidMealID . ' price ' . $kidMealPrice . ' drink ' . $kidMealDrink;
    } else {
        $_SESSION['addedToCartMessage']= "Failed to add kid's meal";
    }
    header("Location: menu.php");
}
//Code to process combo to cart
if($process == 4){
    $comboID = $_POST['processID'];
    $comboPrice = $_POST['itemPrice'];
    $pizzaType = $_POST['pizzaType'];
    $drinkType = $_POST['drink'];
    
    switch ($_POST['processID']){
        case 16: 
            
            $sql_add_combo1 = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`, `drink_size`, `drink_type`, `pizza_type`) VALUES (NULL, $orderID, $comboID, '1', NULL, '$drinkType', '$pizzaType');";
            if($conn->query($sql_add_combo1) === TRUE){
                $item_ID = getItemID($conn, $orderID, $comboID);
                updateTotalPrice($conn, $orderID, $item_ID, $comboPrice);
                $_SESSION['addedToCartMessage']='combo added 1 ' . $pizzaType . $drinkType;
            } else {
                $_SESSION['addedToCartMessage']= "Failed to add combo meal";
            }
            
            header("Location: menu.php");
            break;
        case 17: 

            $appetizerType = $_POST['appetizerType'];
            $sql_add_combo2 = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`, `drink_size`, `drink_type`, `pizza_type`, `appetizer_type`) VALUES (NULL, $orderID, $comboID, '1', NULL, '$drinkType', '$pizzaType', '$appetizerType');";
            if($conn->query($sql_add_combo2) === TRUE){
                $item_ID = getItemID($conn, $orderID, $comboID);
                updateTotalPrice($conn, $orderID, $item_ID, $comboPrice);
                $_SESSION['addedToCartMessage']='combo added 2 ' . $pizzaType . $drinkType;
            } else {
                $_SESSION['addedToCartMessage']= "Failed to add combo meal";
            }
            header("Location: menu.php");
            break;
        case 18:
            $appetizerType = $_POST['appetizerType'];
            $sql_add_combo3 = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`, `drink_size`, `drink_type`, `pizza_type`, `appetizer_type`) VALUES (NULL, $orderID, $comboID, '1', NULL, '$drinkType', '$pizzaType', '$appetizerType');";
            if($conn->query($sql_add_combo3) === TRUE){
                $item_ID = getItemID($conn, $orderID, $comboID);
                updateTotalPrice($conn, $orderID, $item_ID, $comboPrice);
                $_SESSION['addedToCartMessage']='combo added 3 ' . $pizzaType . $drinkType;
            } else {
                $_SESSION['addedToCartMessage']= "Failed to add combo meal";
            }
            header("Location: menu.php");
            break;
        case 19:
            $appetizerType = $_POST['appetizerType'];
            $appetizerType2 = $_POST['appetizerType2'];
            $drinkType2 = $_POST['drink2'];

            $appetizerCombined = $appetizerType . "," . $appetizerType2;
            $drinkCombined = $drinkType . "," . $drinkType2;

            $sql_add_combo3 = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`, `drink_size`, `drink_type`, `pizza_type`, `appetizer_type`) VALUES (NULL, $orderID, $comboID, '1', NULL, '$drinkCombined', '$pizzaType', '$appetizerCombined');";
            if($conn->query($sql_add_combo3) === TRUE){
                $item_ID = getItemID($conn, $orderID, $comboID);
                updateTotalPrice($conn, $orderID, $item_ID, $comboPrice);
                $_SESSION['addedToCartMessage']='combo added 4 ' . $pizzaType . $drinkCombined;
            } else {
                $_SESSION['addedToCartMessage']= "Failed to add combo meal";
            }
            header("Location: menu.php");
            break;
        default:
            echo "combo error"; //change to session message error


    header("Location: menu.php");
    }
}

if($process == 5){
    $drinkID = $_POST['drink'];
    $drinkSize = $_POST['size'];
    $drinkPrice = $_POST['drinkPrice'];
    $sql_add_drink = "INSERT INTO `order_item` (`id`, `order_id`, `item_id`, `quantity`, `drink_size`, `drink_type`) VALUES (NULL, $orderID, $drinkID, '1', '$drinkSize', NULL);";

    if($conn->query($sql_add_drink) === TRUE){
        if($drinkSize == "2liter"){
            $drinkPrice = $drinkPrice + 3;
        } 
        $item_ID = getItemID($conn, $orderID, $drinkID);
        updateTotalPrice($conn, $orderID, $item_ID, $drinkPrice);
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
			<div class="main-view landingPadding"> <!--fix css for different screen sizes -->
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
                                case 16: 
                                    $sql_pizza_types = "SELECT id, item_name FROM item WHERE category_id = 2;";
                                    $result_pizza_type = $conn->query($sql_pizza_types);
                                    $sql_drinks = "SELECT id, item_name FROM item WHERE category_id = 5";
                                    $result_drinks = $conn->query($sql_drinks);

                                    echo '<form method="post" action="add_to_cart.php">';
                                        echo '<select id="pizza-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="pizzaType">';
                                        echo '<option></option>';
                                            if($result_pizza_type->num_rows > 0){
                                                while($row = $result_pizza_type->fetch_assoc()){
                                                    $pizza_name_display = ucwords(strtolower($row['item_name']));
                                                    echo '<option value="'. $row['item_name'] .'">'. $pizza_name_display .'</option>';
                                                }
                                            }
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
                                    echo '<input type="hidden" id="processCategory" name="processCategory" value="'. $_POST['categoryID'] .'">';
                                    echo '<input type="hidden" id="itemPrice" name="itemPrice" value="'. $_POST['itemPrice'] .'">';
                                    echo '<input type="hidden" id="processID" name="processID" value="'. $_POST['itemID'] .'">';
                                    echo '</form>';
                                    break;
                                case 17: //combo 2: 1 small pizza, 1 large drink, 1 appetizer
                                    $sql_pizza_types = "SELECT id, item_name FROM item WHERE category_id = 2;";
                                    $result_pizza_type = $conn->query($sql_pizza_types);
                                    $sql_drinks = "SELECT id, item_name FROM item WHERE category_id = 5";
                                    $result_drinks = $conn->query($sql_drinks);
                                    $sql_appetizer_types = "SELECT id, item_name FROM item WHERE category_id = 1;";
                                    $result_appetizer_types = $conn->query($sql_appetizer_types);

                                    echo '<form method="post" action="add_to_cart.php">';
                                        echo '<select id="pizza-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="pizzaType">';
                                        echo '<option></option>';
                                            if($result_pizza_type->num_rows > 0){
                                                while($row = $result_pizza_type->fetch_assoc()){
                                                    $pizza_name_display = ucwords(strtolower($row['item_name']));
                                                    echo '<option value="'. $row['item_name'] .'">'. $pizza_name_display .'</option>';
                                                }
                                            }
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
                                        echo '<select id="drink-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="appetizerType">';
                                        echo '<option></option>';
                                            if($result_appetizer_types->num_rows > 0){
                                                while($row = $result_appetizer_types->fetch_assoc()){
                                                    $appetizer_name_display = ucwords(strtolower($row['item_name']));
                                                    echo '<option value="'. $row['item_name'] .'">'. $appetizer_name_display .'</option>';
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
                                case 18: //combo 3: 1 medium pizza, 1 large drink, 1 appetizer
                                    $sql_pizza_types = "SELECT id, item_name FROM item WHERE category_id = 2;";
                                    $result_pizza_type = $conn->query($sql_pizza_types);
                                    $sql_drinks = "SELECT id, item_name FROM item WHERE category_id = 5";
                                    $result_drinks = $conn->query($sql_drinks);
                                    $sql_appetizer_types = "SELECT id, item_name FROM item WHERE category_id = 1;";
                                    $result_appetizer_types = $conn->query($sql_appetizer_types);

                                    echo '<form method="post" action="add_to_cart.php">';
                                        echo '<select id="pizza-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="pizzaType">';
                                        echo '<option></option>';
                                            if($result_pizza_type->num_rows > 0){
                                                while($row = $result_pizza_type->fetch_assoc()){
                                                    $pizza_name_display = ucwords(strtolower($row['item_name']));
                                                    echo '<option value="'. $row['item_name'] .'">'. $pizza_name_display .'</option>';
                                                }
                                            }
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
                                        echo '<select id="drink-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="appetizerType">';
                                        echo '<option></option>';
                                            if($result_appetizer_types->num_rows > 0){
                                                while($row = $result_appetizer_types->fetch_assoc()){
                                                    $appetizer_name_display = ucwords(strtolower($row['item_name']));
                                                    echo '<option value="'. $row['item_name'] .'">'. $appetizer_name_display .'</option>';
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
                                case 19: //combo 4: 1 large pizza, 2 large drinks, 2 appetizers
                                    $sql_pizza_types = "SELECT id, item_name FROM item WHERE category_id = 2;";
                                    $result_pizza_type = $conn->query($sql_pizza_types);
                                    $sql_drinks = "SELECT id, item_name FROM item WHERE category_id = 5";
                                    $result_drinks = $conn->query($sql_drinks);
                                    $result_drinks_2 = $conn->query($sql_drinks);
                                    $sql_appetizer_types = "SELECT id, item_name FROM item WHERE category_id = 1;";
                                    $result_appetizer_types = $conn->query($sql_appetizer_types);
                                    $result_appetizer_types_2 = $conn->query($sql_appetizer_types);

                                    echo '<form method="post" action="add_to_cart.php">';
                                        echo '<select id="pizza-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="pizzaType">';
                                        echo '<option></option>';
                                            if($result_pizza_type->num_rows > 0){
                                                while($row = $result_pizza_type->fetch_assoc()){
                                                    $pizza_name_display = ucwords(strtolower($row['item_name']));
                                                    echo '<option value="'. $row['item_name'] .'">'. $pizza_name_display .'</option>';
                                                }
                                            }
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
                                        echo '<select id="drink-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="drink2">';
                                        echo '<option></option>';
                                            if($result_drinks_2->num_rows > 0){
                                                while($row = $result_drinks_2->fetch_assoc()){
                                                    $drink_name_display = ucwords(strtolower($row['item_name']));
                                                    echo '<option value="'. $row['item_name'] .'">'. $drink_name_display .'</option>';
                                                }
                                            }
                                        echo '</select>';
                                        echo '<select id="drink-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="appetizerType">';
                                        echo '<option></option>';
                                            if($result_appetizer_types->num_rows > 0){
                                                while($row = $result_appetizer_types->fetch_assoc()){
                                                    $appetizer_name_display = ucwords(strtolower($row['item_name']));
                                                    echo '<option value="'. $row['item_name'] .'">'. $appetizer_name_display .'</option>';
                                                }
                                            }
                                        echo '</select>';
                                        echo '<select id="drink-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="appetizerType2">';
                                        echo '<option></option>';
                                            if($result_appetizer_types_2->num_rows > 0){
                                                while($row = $result_appetizer_types_2->fetch_assoc()){
                                                    $appetizer_name_display = ucwords(strtolower($row['item_name']));
                                                    echo '<option value="'. $row['item_name'] .'">'. $appetizer_name_display .'</option>';
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