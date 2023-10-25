<?php
include_once 'db_connection.php';
$conn = OpenCon();

(isset($_POST['itemID'])) ? $itemID = $_POST['itemID'] : $itemID = 0;
(isset($_POST['itemQuantity'])) ? $itemQuantity = $_POST['itemQuantity'] : $itemQuantity = 0;

$sql_update_quantity = $conn->prepare("UPDATE `item` SET `quantity` = ? WHERE `item`.`id` = ?");
$sql_update_quantity->bind_param("ii", $itemQuantity, $itemID);
$sql_update_quantity->execute();

header('Location: manage_inventory.php');
CloseCon($conn);
?>