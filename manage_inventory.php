<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$conn = OpenCon();

$sql_items = "SELECT `id`, `item_name`, `category_id`, `quantity` FROM `item`";
$result_items = $conn->query($sql_items);
?>

    <!-- Main container of page -->
    <div class="container mt-5"> <!-- Adjusted container and added margin top -->
        <div class="row justify-content-center">
            <div class="main-view">
                <div class="card"> <!-- Wrapped table inside a card -->
                    <div class="card-header bg-primary text-white"> <!-- Added a card header with color -->
                        <i class="bi bi-table"></i> Inventory <!-- Added an icon -->
                    </div>
                    <div class="card-body">
                        <?php
                        if($result_items->num_rows > 0){
                            echo '<table class="table table-striped">'; // Used striped table for better readability
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th scope="col">Item Name</th>';
                            echo '<th scope="col">Quantity</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody id="inventoryTable">';
                            while($row = $result_items->fetch_assoc()){
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['item_name']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo '<div class="alert alert-warning" role="alert">'; // Warning alert for no items
                            echo 'No items available in the inventory.';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End main container -->

    <style>
        body {
            padding-top: 500px;
            padding-bottom: 500px;
        }

        .main-view {
            max-width: 800px;
            width: 100%;
        }
    </style>

<?php
CloseCon($conn);
include_once 'footer.php';
?>
