<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$conn = OpenCon();

$sql_categories = "SELECT id, category_name FROM category WHERE 1 ORDER BY display_order";
$result_categories = $conn->query($sql_categories);
?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<?php
                    echo '<form method="post" action="add_to_cart.php">';
                        echo '<select id="drink-select" class="form-select form-select-lg mb-3" aria-label="Large select example" name="drink">';
                        echo '<option></option>';
                            if($result_categories->num_rows > 0){
                                while($row = $result_categories->fetch_assoc()){
                                    $category_name_display = ucwords(strtolower($row['category_name']));
                                    echo '<option value="'. $row['category_name'] .'">'. $category_name_display .'</option>';
                                }
                            }
                        echo '</select>';
                    echo '<div class="text-center">';
                    echo '<button type="submit" class="btn btn-light btn-lg">Confirm</button>'; 
                    echo '</div>';
                    // echo '<input type="hidden" id="processCategory" name="processCategory" value="'. $_POST['categoryID'] .'">';
                    // echo '<input type="hidden" id="itemPrice" name="itemPrice" value="'. $_POST['itemPrice'] .'">';
                    // echo '<input type="hidden" id="processID" name="processID" value="'. $_POST['itemID'] .'">';
                    echo '</form>';
                ?>
			</div>
		</div>
	</div>
	<!-- End main container -->


<?php
CloseCon($conn);
include_once 'footer.php';
?>