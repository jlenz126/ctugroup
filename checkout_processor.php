<?php
include_once 'session.php';
include_once 'header.php';
include_once 'db_connection.php';
$conn = OpenCon();
$paymentType = null;
$displayMessage = 'null';
$orderID = 1; //test set to 1 set to null for deployment
$checkoutDetails = [];

// commented out for testing purposes
// if(isset($_SESSION['currentOrderID'])){
// 	$orderID = $_SESSION['currentOrderID'];
// } else {
//     header('Location: index.php'); // redirect if no orderID
// }

$sql_get_order_details = "SELECT * FROM `order` WHERE id=$orderID";
$result_order = $conn->query($sql_get_order_details);

if(isset($_POST['paymentType'])){ //gets payment type
    switch($_POST['paymentType']){
        case 'cash':
            $paymentType = 'cash';
            break;
        case 'card':
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


?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<!-- Content here -->
                <?php
                echo $displayMessage .  '<br>';
                echo print_r($checkoutDetails);
                //header("Refresh:3; url=index.php");
                ?>
			</div>
		</div>
	</div>
	<!-- End main container -->


<?php
CloseCon($conn);
include_once 'footer.php';
?>