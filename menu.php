<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$conn = OpenCon();
?>

  <div class="container-fluid">
		<div class="row">
			<div class="menu-Padding"> 
      <?php
        $sql_categories = "SELECT id, category_name FROM category WHERE 1 ORDER BY display_order";
        $result_categories = $conn->query($sql_categories);
        $uppercase_words = array("A","And","Or","Of","Og","With");
        $lowercase_words = array("a","and","or","of","OG","with");

        if(isset($_SESSION['addedToCartMessage'])){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo '<strong>Item Added</strong> ' . $_SESSION['addedToCartMessage'];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
          echo '</div>';
          unset($_SESSION['addedToCartMessage']);
        }

        if(isset($_SESSION['failedToAdd'])){
          echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
            echo '<strong>Failed to Add Item</strong> ' . $_SESSION['failedToAdd'];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
          echo '</div>';
          unset($_SESSION['failedToAdd']);
        }

        echo '<div class="accordion accordion-flush" id="MenuAccordion">';
        if($result_categories->num_rows > 0) {
          while($row = $result_categories->fetch_assoc()){
            $category_name_display = ucwords(strtolower($row['category_name']));
            $category_name_cleaned = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $category_name_display));
            $category_target = "#" . $category_name_cleaned;
            $category_id = $row['id'];
            
            echo '<div class="accordion-item">';
              echo '<h2 class="accordion-header">';
                echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="' . $category_target . '" aria-expanded="false" aria-controls="' . $category_name_cleaned . '">';
                  echo $category_name_display;
                echo '</button>';
              echo '</h2>';
              echo '<div id="' . $category_name_cleaned . '" class="accordion-collapse collapse" data-bs-parent="#MenuAccordion">';
                echo '<div class="accordion-body">';
                  echo '<div class="row container-fluid menu-cards">';
                    $sql_item = "SELECT id, item_name, item_description, item_price FROM `item` WHERE category_id = '$category_id'";
                    $result_item = $conn->query($sql_item);
                    while($row2 = $result_item->fetch_assoc()){
                      $item_name_display = ucwords(strtolower($row2['item_name']));
                      $item_description = ucwords(strtolower($row2['item_description']));
                      $item_description_display = str_replace($uppercase_words,$lowercase_words,$item_description); 
                      $item_price = number_format((float)$row2['item_price'], 2,'.','');
                      
                      echo '<div class="col-sm-12 col-md-4">';
	                      echo '<div class="card h-100">';
	                        echo '<div class="card-body">';
	                          echo '<h5 class="card-title">'.$item_name_display.'</h5>';
                            echo '<h5 class="card-title">Price: $'.$item_price.'</h5>';
	                          echo '<p class="card-text">'.$item_description_display. '</p>';
			                      echo '<form method="post" action="add_to_cart.php">';
                            echo '<input type="hidden" id="itemName" name="itemName" value="'. $row2['item_name'] .'">';
                            echo '<input type="hidden" id="itemPrice" name="itemPrice" value="'. $row2['item_price'] .'">';
                            echo '<input type="hidden" id="categoryID" name="categoryID" value="'. $category_id .'">';
                            echo '<input type="hidden" id="itemID" name="itemID" value="'. $row2['id'] .'">';
                            echo '<button type="submit" class="btn btn-primary">Add to Cart</button>'; 
                            echo '</form>';
	                        echo '</div>';
	                      echo '</div>';
	                    echo '</div>';
                    }
                  echo '</div>';
                echo '</div>';
              echo '</div>';
            echo '</div>';
          }
        }
        echo '</div>';
        CloseCon($conn);
      ?>
			</div>
		</div>
	</div>

<h1 style="padding-bottom: 300px"></h1>
    
            
<?php
include_once 'footer.php';
?>