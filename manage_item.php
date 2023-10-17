<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$conn = OpenCon();

$sql_categories = "SELECT id, category_name FROM category WHERE 1 ORDER BY display_order";
$result_categories = $conn->query($sql_categories);

$sql_items = "SELECT `id`, `item_name`, `item_price`, `category_id` FROM `item`";
$result_items = $conn->query($sql_items);

//code for backend logic

?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<?php
                    echo '<form method="post" action="add_to_cart.php">';
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
                        ?>
                        <div id="appetizers" style="display: none;"> 
                            appetizers 1
                            <br>
                        </div>

                        <div id="pizza" style="display: none;">
                            pizza 2
                            <BR>
                        </div>
                        <div id="kid" style="display: none;">
                            kids meal 3
                        </div>
                        <div id="combos" style="display: none;">
                            combos 4
                        </div>
                        <div id="drinks" style="display: none;">
                            <br>
                            drinks 5
                        </div>
                        <?php
                            if($result_items->num_rows > 0){
                                while($row = $result_items->fetch_assoc()){
                                    if($row['category_id'] == 1){
                                        echo '<div class="appetizers" style="display: none;">';
                                        echo $row['item_name'];
                                        echo '</div>';
                                    }
                                    if($row['category_id'] == 2){
                                        echo '<div class="pizza" style="display: none;">';
                                        echo $row['item_name'];
                                        echo '</div>';
                                    }
                                    if($row['category_id'] == 3){
                                        echo '<div class="kid" style="display: none;">';
                                        echo $row['item_name'];
                                        echo '</div>';
                                    }
                                    if($row['category_id'] == 4){
                                        echo '<div class="combos" style="display: none;">';
                                        echo $row['item_name'];
                                        echo '</div>';
                                    }
                                    if($row['category_id'] == 5){
                                        echo '<div class="drinks" style="display: none;">';
                                        echo $row['item_name'];
                                        echo '</div>';
                                    }
                                }
                            }
                        ?>
                    <?php
                    // echo '<div class="text-center">';
                    // echo '<button type="submit" class="btn btn-light btn-lg">Confirm</button>'; 
                    // echo '</div>';
                    // echo '<input type="hidden" id="processCategory" name="processCategory" value="'. $_POST['categoryID'] .'">';
                    // echo '<input type="hidden" id="itemPrice" name="itemPrice" value="'. $_POST['itemPrice'] .'">';
                    // echo '<input type="hidden" id="processID" name="processID" value="'. $_POST['itemID'] .'">';
                    echo '</form>';
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
  // #name is always displayed
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