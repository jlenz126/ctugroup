<?php
include_once 'heaader.php';
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


<?php
include_once 'footer.php';
?>