<?php
include_once 'session.php';
include_once 'header.php';
include_once 'db_connection.php';
$conn = OpenCon();
$paymentType = null;
$displayMessage = 'Order Placed Remember this is a fake restaurant';
$orderID = null; //test set to 1 set to null for deployment
$checkoutDetails = [];

if(isset($_SESSION['currentOrderID'])){
	$orderID = $_SESSION['currentOrderID'];
} else {
    header('Location: index.php'); // redirect if no orderID
}

$sql_get_order_details = "SELECT * FROM `order` WHERE id=$orderID";
$result_order = $conn->query($sql_get_order_details);

if(isset($_POST['paymentMethod'])){ //gets payment type
    switch($_POST['paymentMethod']){
        case 'cash':
            $paymentType = 'cash';
            break;
        case 'credit':
            $paymentType = 'card';
            (isset($_POST['cardNumber'])) ? $checkoutDetails['cardNumber'] = $_POST['cardNumber'] :  $checkoutDetails['cardNumber'] = '';
            (isset($_POST['exp'])) ? $checkoutDetails['exp'] = $_POST['exp'] :  $checkoutDetails['exp'] = '';
            (isset($_POST['cvc'])) ? $checkoutDetails['cvc'] = $_POST['cvc'] :  $checkoutDetails['cvc'] = '';
            break;
        default:
            $displayMessage = 'error';
    }
}

if(isset($_SESSION['user_id'])){
    $userID = $_SESSION['user_id'];
    $sql_get_user = "SELECT `firstname`,`lastname` FROM `user` WHERE id= $userID";
    $result_user = $conn->query($sql_get_user);
    $user = $result_user->fetch_assoc();

    $checkoutDetails['firstname'] = $user['firstname'];
    $checkoutDetails['lastname'] = $user['lastname'];

    $sql_get_address = "SELECT `line1`,`line2`,`city`,`country`,`zipcode` FROM `address` WHERE customer_id=$userID";
    $result_address = $conn->query($sql_get_address);
    $address = $result_address->fetch_assoc();

    $checkoutDetails['line1'] = $address['line1'];
    $checkoutDetails['line2'] = $address['line2'];
    $checkoutDetails['city'] = $address['city'];
    $checkoutDetails['country'] = $address['country'];
    $checkoutDetails['zipcode'] = $address['zipcode'];
} else {
    (isset($_POST['name'])) ? $checkoutDetails['name'] = $_POST['name'] :  $checkoutDetails['name'] = '';
    (isset($_POST['address'])) ? $checkoutDetails['address'] = $_POST['address'] :  $checkoutDetails['address'] = '';
    (isset($_POST['zip'])) ? $checkoutDetails['zip'] = $_POST['zip'] :  $checkoutDetails['zip'] = '';
    (isset($_POST['state'])) ? $checkoutDetails['state'] = $_POST['state'] :  $checkoutDetails['state'] = '';
    (isset($_POST['phone'])) ? $checkoutDetails['phone'] = $_POST['phone'] :  $checkoutDetails['phone'] = '';
    (isset($_POST['email'])) ? $checkoutDetails['email'] = $_POST['email'] :  $checkoutDetails['email'] = '';
}

// Code to send payment info to third party payment processing
// will be completed when deployed and processing party is picked

json_encode($checkoutDetails);

//Code to transfer order to management dashoboard

//Code to update quantity

$sql_order_items = "SELECT `item_id` FROM `order_item` WHERE `order_id` = $orderID";
$result_order_item = $conn->query($sql_order_items);

if($result_order_item->num_rows > 0){
    while ($row = $result_order_item->fetch_assoc()){
        $itemID = $row['item_id'];
        $sql_item_quantity = "SELECT `quantity` FROM `item` WHERE `id` = $itemID";
        $result_item_quantity = $conn->query($sql_item_quantity);
        $itemQuantity = ($result_item_quantity->fetch_row()[0]) - 1;
        $sql_update_quantity = $conn->prepare("UPDATE `item` SET `quantity` = ? WHERE `item`.`id` = ?");
        $sql_update_quantity->bind_param("ii", $itemQuantity, $itemID);
        $sql_update_quantity->execute();
    }
}

$sql_set_order_id = $conn->prepare("UPDATE `order` SET `fulfilled` = 1 WHERE `order`.`id` = ?");
$sql_set_order_id->bind_param("i", $orderID);
$sql_set_order_id->execute();
?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<!-- Content here -->
                <?php
                echo $displayMessage .  '<br>';
                //echo print_r($checkoutDetails);
                header("Refresh:3; url=index.php");
                ?>
			</div>
		</div>
	</div>
	<!-- End main container -->

    <style>
    body {
        background-image: none;			
    }
    </style>
<?php
CloseCon($conn);
include_once 'footer.php';
?>