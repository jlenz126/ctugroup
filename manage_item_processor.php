<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$conn = OpenCon();

// Check if admin rights
if(isset($_SESSION['employee'])){
    if($_SESSION['employee'] != 1){
        header('Location: index.php');
    }
}else{
    header('Location: index.php');
}

$caseID = null;
$addedAlert = null;
$totalItems = 0;
$itemID = null;

if(isset($_POST['process'])){
    (isset($_POST['itemName'])) ? $itemName = $_POST['itemName'] : $itemName = "";
    (isset($_POST['itemDescription'])) ? $itemDescription = $_POST['itemDescription'] : $itemDescription = "";
    (isset($_POST['itemPrice'])) ? $itemPrice = $_POST['itemPrice'] : $itemPrice = 0;
    (isset($_POST['categoryID'])) ? $categoryID = $_POST['categoryID'] : $categoryID = null;
    (isset($_POST['defaultTopping'])) ? $defaultTopping = $_POST['defaultTopping'] : $defaultTopping = "";
    (isset($_POST['itemID'])) ? $itemID = $_POST['itemID'] : $itemID = null;

    switch($_POST['process']){
        case 1:
            $insert_new_item = $conn->prepare("INSERT INTO item (item_name, item_description, item_price, category_id, default_topping) VALUES (?,?,?,?,?)");
            $insert_new_item->bind_param("ssdis", $itemName, $itemDescription, $itemPrice, $categoryID, $defaultTopping);
            $insert_new_item->execute();
            $addedAlert = $itemName . " added";
            header("Refresh:3; url=manage_item.php");
            break;
        case 2: 
            $toppingString = null;

            foreach($defaultTopping as $topping){
                if($toppingString == null){
                    $toppingString = $topping;
                    $pizzaDescription = $topping;
                } else {
                    $toppingString = $toppingString . ',' . $topping;
                    $pizzaDescription = $pizzaDescription . " " . $topping;
                }
            }
            
            $toppingsTotal = count($defaultTopping);
            $sql_toppings = "SELECT topping_name FROM topping WHERE premium_topping=1;";
            $result_toppings = $conn->query($sql_toppings);

            if($result_toppings->num_rows > 0){
                while($row = $result_toppings->fetch_assoc()){
                    if(in_array($row['topping_name'], $defaultTopping)){
                        $toppingsTotal = (float)$toppingsTotal + .5;
                    }
                }
            }
            $itemPrice = (float)$itemPrice + $toppingsTotal;

            $insert_new_pizza = $conn->prepare("INSERT INTO item (item_name, item_description, item_price, category_id, default_topping) VALUES (?,?,?,?,?)");
            $insert_new_pizza->bind_param("ssdis", $itemName, $pizzaDescription, $itemPrice, $categoryID, $toppingString);
            $insert_new_pizza->execute();

            $addedAlert = "Pizza added";
            header("Refresh:10; url=manage_item.php");
            break;
        case 3:
            $insert_kid_meal = $conn->prepare("INSERT INTO item (item_name, item_description, item_price, category_id, default_topping) VALUES (?,?,?,?,?)");
            $insert_kid_meal->bind_param("ssdis", $itemName, $itemDescription, $itemPrice, $categoryID, $defaultTopping);
            $insert_kid_meal->execute();
            $addedAlert = $itemName . " added";
            header("Refresh:3; url=manage_item.php");
            break;
        case 4:
            $sql_edit_item = $conn->prepare("UPDATE item SET item_name=?, item_description=?, item_price=?, default_topping=? WHERE id=?");
            $sql_edit_item->bind_param("ssdsi", $itemName, $itemDescription, $itemPrice, $defaultTopping, $itemID);
            $sql_edit_item->execute();
            $addedAlert = $itemName . " edited";
            header("Refresh:3; url=manage_item.php");
            break;
        case 5:
            $sql_delete_item = $conn->prepare("DELETE FROM item WHERE id=?");
            $sql_delete_item->bind_param("i", $itemID);
            $sql_delete_item->execute();
            $addedAlert = $itemName . " deleted";
            header("Refresh:3; url=manage_item.php");
            break;
        default:
            $addedAlert = "Failed to add item will redirect";
            header("Refresh:3; url=manage_item.php");
    }


}

if(isset($_POST)){
    
    $sql_total_items = "SELECT MAX(`id`) FROM `item`";
    $result_total_items = $conn->query($sql_total_items);
    $totalItems = $result_total_items->fetch_row()[0];

    for($i = 1; $i <= $totalItems; $i++){
        if(isset($_POST[$i])){
            $caseID = 6;
            $itemID = $i;
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
                        ?>
                        <form action="manage_item_processor.php" method="POST">
                            <div class="form-element">
                                <label for="itemName">Name:</label>
                                <input type="text" id="itemName" name="itemName" required class="form-control">
                            </div>
                            <div class="form-element">
                                <label for="itemPrice">Price:</label>
                                <input type="number" id="itemPrice" name="itemPrice" class="form-control">
                            </div>
                            <div class="form-button text-center">
                                <input type="submit" value="Add Item" class="btn btn-light btn-lg">
                                <input type="reset" value="Clear" class="btn btn-light btn-lg">
                            </div>
                            <input type="hidden" id="itemDescription" name="itemDescription" value="">
                            <input type="hidden" id="defaultTopping" name="defaultTopping" value="">
                            <input type="hidden" id="categoryID" name="categoryID" value="1">
                            <input type="hidden" id="process" name="process" value="1">
                        </form>
                        <?php
                        break;
                    case 'newPizza':
                        ?>
                        <form action="manage_item_processor.php" method="POST">
                            <div class="form-element">
                                <label for="itemName">Name:</label>
                                <input type="text" id="itemName" name="itemName" required class="form-control">
                            </div>
                            <?php
                            $sql_toppings = "SELECT id, topping_name, premium_topping FROM topping";
                            $result_toppings = $conn->query($sql_toppings);

                            if($result_toppings->num_rows >0){
                                while($row = $result_toppings->fetch_assoc()){
                                    $topping_name_display = ucwords(strtolower($row['topping_name']));

                                    echo '<div class="form-check">';
                                        echo '<input class="form-check-input" type="checkbox" name="defaultTopping[]" id="'. $row['id'] .'" value="'. $row['topping_name'] .'">';
                                        echo '<label class="form-check-label" for="'. $row['id'] .'">';
                                        echo $topping_name_display;
                                        echo '</label>';
                                    echo '</div>';
                                }
                            }
                            ?>
                            <div class="form-button text-center">
                                <input type="submit" value="Add Item" class="btn btn-light btn-lg">
                                <input type="reset" value="Clear" class="btn btn-light btn-lg">
                            </div>
                            <input type="hidden" id="itemDescription" name="itemDescription" value="">
                            <input type="hidden" id="itemPrice" name="itemPrice" value="10">
                            <input type="hidden" id="categoryID" name="categoryID" value="2">
                            <input type="hidden" id="process" name="process" value="2">
                        </form>
                        <?php
                        break;
                    case 'newKid':
                        ?>
                        <form action="manage_item_processor.php" method="POST">
                            <div class="form-element">
                                <label for="itemName">Name:</label>
                                <input type="text" id="itemName" name="itemName" required class="form-control">
                            </div>
                            <div class="form-element">
                                <label for="itemPrice">Price:</label>
                                <input type="number" id="itemPrice" name="itemPrice" class="form-control">
                            </div>
                            <div class="form-element">
                                <label for="itemDescription">Description:</label>
                                <input type="text" id="itemDescription" name="itemDescription" class="form-control">
                            </div>
                            <div class="form-button text-center">
                                <input type="submit" value="Add Item" class="btn btn-light btn-lg">
                                <input type="reset" value="Clear" class="btn btn-light btn-lg">
                            </div>
                            <input type="hidden" id="defaultTopping" name="defaultTopping" value="">
                            <input type="hidden" id="categoryID" name="categoryID" value="3">
                            <input type="hidden" id="process" name="process" value="1">
                        </form>
                        <?php
                        break;
                    case 'newCombo':
                        echo 'unable to add new combo';
                        header("Refresh:3; url=manage_item.php");
                        break;
                    case 'newDrink':
                        ?>
                        <form action="manage_item_processor.php" method="POST">
                            <div class="form-element">
                                <label for="itemName">Drink:</label>
                                <input type="text" id="itemName" name="itemName" required class="form-control">
                            </div>
                            <div class="form-element">
                                <label for="itemPrice">Price:</label>
                                <input type="number" id="itemPrice" name="itemPrice" class="form-control">
                            </div>
                            <div class="form-button text-center">
                                <input type="submit" value="Add Item" class="btn btn-light btn-lg">
                                <input type="reset" value="Clear" class="btn btn-light btn-lg">
                            </div>
                            <input type="hidden" id="itemDescription" name="itemDescription" value="">
                            <input type="hidden" id="defaultTopping" name="defaultTopping" value="">
                            <input type="hidden" id="categoryID" name="categoryID" value="5">
                            <input type="hidden" id="process" name="process" value="1">
                        </form>
                        <?php
                        break;
                    case 6:
                        $sql_get_item = "SELECT * FROM `item` WHERE `id`=$itemID";
                        $result_get_item = $conn->query($sql_get_item);
                        $item = $result_get_item->fetch_assoc();
                        
                        echo '<form action="manage_item_processor.php" method="POST">';
                            echo '<div class="form-element">';
                                echo '<label for="itemName">Name:</label>';
                                echo '<input type="text" id="itemName" name="itemName" required class="form-control" value="'. $item['item_name'] .'">';
                            echo '</div>';
                            if($item['category_id'] == 3){
                                echo '<div class="form-element">';
                                    echo '<label for="itemDescription">Description:</label>';
                                    echo '<input type="text" id="itemDescription" name="itemDescription" required class="form-control" value="'. $item['item_description'] .'">';
                                echo '</div>';
                            } else {
                                echo '<input type="hidden" id="itemDescription" name="itemDescription" value="">';
                            }
                            echo '<div class="form-element">';
                                echo '<label for="itemPrice">Price:</label>';
                                echo '<input type="number" id="itemPrice" name="itemPrice" required class="form-control" value="'. $item['item_price'] .'">';
                            echo '</div>';
                            if($item['category_id'] == 2){
                                //load toppings
                            } else {
                                echo '<input type="hidden" id="defaultTopping" name="defaultTopping" value="">';
                            }
                            echo '<input type="hidden" id="categoryID" name="categoryID" value="'. $item['category_id'] .'">';
                            echo '<input type="hidden" id="itemID" name="itemID" value="'. $item['id'] .'">';
                            echo '<input type="hidden" id="process" name="process" value="4">';
                            echo '<div class="form-button text-center">';
                                echo '<input type="submit" value="Confirm Change" class="btn btn-light btn-lg">';
                            echo '</div>';
                        echo '</form>';
                        echo '<form action="manage_item_processor.php" method="POST">';
                            echo '<input type="hidden" id="itemID" name="itemID" value="'. $item['id'] .'">';
                            echo '<input type="hidden" id="itemName" name="itemName" value="'. $item['item_name'] .'">';
                            echo '<input type="hidden" id="process" name="process" value="5">';
                            echo '<div class="form-button text-center">';
                                echo '<input type="submit" value="Delete Item" class="btn btn-light btn-lg">';
                            echo '</div>';
                        echo '</form>';

                        //echo $item['category_id'];
                        break;
                    
                    default:
                        echo $addedAlert; //set redirect
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
