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

$sql_categories = "SELECT id, category_name FROM category WHERE 1 ORDER BY display_order";
$result_categories = $conn->query($sql_categories);

$sql_items = "SELECT `id`, `item_name`, `item_price`, `category_id` FROM `item`";
$result_items = $conn->query($sql_items);

?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
                <?php
                    echo '<form >';
                        echo '<select id="category" class="form-select form-select-lg mb-3" aria-label="Large select example" name="drink">';
                        echo '<option></option>';
                            if($result_categories->num_rows > 0){
                                while($row = $result_categories->fetch_assoc()){
                                    $category_name_display = ucwords(strtolower($row['category_name']));
                                    if($row['id'] != 3){
                                        echo '<option value="'. $row['category_name'] .'">'. $category_name_display .'</option>';
                                    } else {
                                        echo '<option value="kid">'. $category_name_display .'</option>';
                                    }
                                }
                            }
                        echo '</select>';
                        echo '</form>';

                        echo '<div class="row">';
                        echo '<form method="post" action="manage_item_processor.php">';
                        echo '<div class="form-check appetizers" style="display: none;">';
                            echo '<input type="radio" id="newAppetizer" name="newAppetizer" value="newAppetizer">';
                            echo '<label for="newAppetizer">Add new appetizer</label>';
                            echo '<br>';
                        echo '</div>';
                        echo '<div class="form-check pizza" style="display: none;">';
                            echo '<input type="radio" id="newPizza" name="newPizza" value="newPizza">';
                            echo '<label for="newPizza">Add new pizza</label>';
                            echo '<br>';
                        echo '</div>';
                        echo '<div class="form-check kid" style="display: none;">';
                            echo '<input type="radio" id="newKid" name="newKid" value="newKid">';
                            echo '<label for="newKid">Add new Kid\'s meal</label>';
                            echo '<br>';
                        echo '</div>';
                        echo '<div class="form-check combos" style="display: none;">';
                            echo '<input type="radio" id="newCombo" name="newCombo" value="newCombo">';
                            echo '<label for="newCombo">Add new combo</label>';
                            echo '<br>';
                        echo '</div>';
                        echo '<div class="form-check drinks" style="display: none;">';
                            echo '<input type="radio" id="newDrink" name="newDrink" value="newDrink">';
                            echo '<label for="newDrink">Add new drink</label>';
                            echo '<br>';
                        echo '</div>';
                                    
                                        if($result_items->num_rows > 0){
                                            while($row = $result_items->fetch_assoc()){
                                                switch ($row['category_id']){
                                                    case 1:
                                                        $divClass = "appetizers";
                                                        break;
                                                    case 2:
                                                        $divClass = "pizza";
                                                        break;
                                                    case 3:
                                                        $divClass = "kid";
                                                        break;
                                                    case 4:
                                                        $divClass = "combos";
                                                        break;
                                                    case 5:
                                                        $divClass = "drinks";
                                                        break;
                                                    default:
                                                        $divClass = "error";
                                                        echo 'Category not found';
                                                }
                                                echo '<div class="'. $divClass .' form-check" style="display: none;">';
                                                echo '<input type="radio" id="'. $row['item_name'] .'" name="'. $row['id'] .'" >';
                                                echo '<label for="' . $row['item_name'] . '">'. $row['item_name'] . '</label><br>';
                                                echo '</div>';
                                            }
                                        }
                                    
                    
                    echo '<div class="text-center">';
                    echo '<button type="submit" class="btn btn-light btn-lg">Confirm</button>'; 
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                ?>
			</div>
		</div>
	</div>
	<!-- End main container -->
<script>
function toggle(ev) {
// get the input elements, and convert the results into an array
var inputs = Array.prototype.slice.call(document.querySelectorAll('input'));

// clear values from all inputs
// (that way the user doesn't accidentally enter a value, switch options, and upload unwanted data)
inputs.forEach(input => input.value = '');

// hide/display fields depending on which option is selected
const appetizerList = document.querySelectorAll(".appetizers");
const pizzaList = document.querySelectorAll(".pizza");
const combosList = document.querySelectorAll(".combos");
const kidList = document.querySelectorAll(".kid");
const drinksList = document.querySelectorAll(".drinks");

function displayItemList (listToDisplay){
for (let i = 0; i < appetizerList.length; i++){
    appetizerList[i].style.display = 'none';
    }
    for (let i = 0; i < pizzaList.length; i++){
        pizzaList[i].style.display = 'none';
    }
    for (let i = 0; i < combosList.length; i++){
        combosList[i].style.display = 'none';
    }
    for (let i = 0; i < kidList.length; i++){
        kidList[i].style.display = 'none';
    }
    for (let i = 0; i < drinksList.length; i++){
        drinksList[i].style.display = 'none';
    }
    for (let i = 0; i < listToDisplay.length; i++){
        listToDisplay[i].style.display = 'block';
    }
}

switch (ev.target.value) {
    case 'appetizers':
        displayItemList(appetizerList);
        document.querySelector('#appetizers').style.display = 'block';
        document.querySelector('#pizza').style.display = 'none';
        document.querySelector('#combos').style.display = 'none';
        document.querySelector('#kid').style.display = 'none';
        document.querySelector('#drinks').style.display = 'none';
        break;
    case 'pizzas':
        displayItemList(pizzaList);
        document.querySelector('#appetizers').style.display = 'none';
        document.querySelector('#pizza').style.display = 'block';
        document.querySelector('#combos').style.display = 'none';
        document.querySelector('#kid').style.display = 'none';
        document.querySelector('#drinks').style.display = 'none';
        break;
    case 'combos':
        displayItemList(combosList);
        document.querySelector('#appetizers').style.display = 'none';
        document.querySelector('#pizza').style.display = 'none';
        document.querySelector('#combos').style.display = 'block';
        document.querySelector('#kid').style.display = 'none';
        document.querySelector('#drinks').style.display = 'none';
        break;
    case "kid":
        displayItemList(kidList);
        document.querySelector('#appetizers').style.display = 'none';
        document.querySelector('#pizza').style.display = 'none';
        document.querySelector('#combos').style.display = 'none';
        document.querySelector('#kid').style.display = 'block';
        document.querySelector('#drinks').style.display = 'none';
        break;
    case 'drinks':
        displayItemList(drinksList);
        document.querySelector('#appetizers').style.display = 'none';
        document.querySelector('#pizza').style.display = 'none';
        document.querySelector('#combos').style.display = 'none';
        document.querySelector('#kid').style.display = 'none';
        document.querySelector('#drinks').style.display = 'block';
        break;
    }
}

document.querySelector('select').addEventListener('change', toggle);
</script>

<?php
CloseCon($conn);
include_once 'footer.php';
?>