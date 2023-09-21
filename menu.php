<?php
include_once 'header.php';
include_once 'navbar.php';
?>

    <div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
                <?php
                include_once 'db_connection.php';
                $conn = OpenCon();
                
                $sql = "SELECT DISTINCT category FROM item";
                $result = $conn->query($sql);
                ?>
                

                        <?php
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $category = ucwords(strtolower($row['category']));

                            echo "category " . $category. "<br>";
                            $sql2 = "SELECT item_name, item_description, item_price FROM item WHERE category='$category'";
                            $result2 = $conn->query($sql2);
                            while($row2 = $result2->fetch_assoc()){
                                echo "Item Name: " . $row2["item_name"]. " Description: " . $row2["item_description"]. " Price: $" . $row2["item_price"]. "<br>";
                            }
                        }
                        } else {
                        echo "0 results";
                        }
                        
                        CloseCon($conn);
                        ?>
			</div>
		</div>
	</div>

    <div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
                <p>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Button with data-target
                    </button>
                </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                </div>
            </div>
			</div>
		</div>
	</div>

    <div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          Collapsible Group Item #1
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
      <div class="card-body">
      <div class="row container-fluid serviceCards">
	  <div class="col-sm-12 col-md-4">
	    <div class="card h-100">
	      <div class="card-body custom-colors">
	        <h5 class="card-title">Featured Item 1</h5>
	        <p class="card-text">description of item</p>
			<a href="featured1.php" class="btn btn-light">Add to Cart</a>
	      </div>
	    </div>
	  </div>
	  <div class="col-sm-12 col-md-4">
	    <div class="card h-100">
	      <div class="card-body custom-colors">
	        <h5 class="card-title">Specials</h5>
	        <p class="card-text">Current deals and specials</p>
			<a href="specials.php" class="btn btn-light">Specials</a>
	      </div>
	    </div>
	  </div>
	  <div class="col-sm-12 col-md-4">
	    <div class="card h-100">
	      <div class="card-body custom-colors">
	        <h5 class="card-title">Featured Item 2</h5>
	        <p class="card-text">description of item</p>
			<a href="featured2.php" class="btn btn-light">Add to Cart</a>
	      </div>
	    </div>
	  </div>
        </div>
      </div>
    </div>
  </div>
</div>

<h1 style="padding-bottom: 600px"></h1>
    
            
<?php
include_once 'footer.php';
?>