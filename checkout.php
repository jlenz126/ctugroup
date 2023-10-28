<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
include_once 'db_connection.php';
$conn = OpenCon();
$activeOrderID = 0;

if (isset($_SESSION['currentOrderID'])) {
    $activeOrderID = $_SESSION['currentOrderID'];
}

if (!isset($_SESSION['user_id'])) {
    header('Location: guest_checkout.php');
}

echo '<script>
    function toggleCardForm() {
        var paymentMethod = document.getElementById("paymentMethod").value;
        var cardForm = document.getElementById("cardForm");
        if (paymentMethod === "credit") {
            cardForm.style.display = "block";
        } else {
            cardForm.style.display = "none";
        }
    }
</script>';
?>

<!-- Main container of page -->
<div class="container-fluid">
    <div class="row">
        <div class="main-view paymentPadding">
            <form action="checkout_processor.php" method="POST">
                <div class="form-element">
                    <label for="paymentMethod">Payment Method</label>
                    <select id="paymentMethod" name="paymentMethod" onchange="toggleCardForm()">
                        <option value="cash">Cash</option>
                        <option value="credit">Credit Card</option>
                    </select>
                </div>
                <div class="form-element">
                    <label for="deliveryMethod">Delivery Method</label>
                    <select id="deliveryMethod" name="deliveryMethod">
                        <option value="pickup">Pickup</option>
                        <option value="delivery">Delivery</option>
                    </select>
                </div>

                <!-- Card form - initially hidden, will be displayed via JavaScript -->
                <div id="cardForm" style="display: none;">
                    <div class="form-element">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" id="cardNumber" name="cardNumber" class="form-control">
                    </div>
                    <div class="form-element">
                        <label for="exp">Expiration Date</label>
                        <input type="month" id="exp" name="exp" class="form-control">
                    </div>
                    <div class="form-element">
                        <label for="cvc">CVC Number</label>
                        <input type="text" id="cvc" name="cvc" class="form-control">
                    </div>
                </div>
                <div class="form-button text-center">
                    <input type="submit" value="Pay" class="btn btn-light btn-lg">
                    <input type="reset" value="Clear" class="btn btn-light btn-lg">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End main container -->
<style>
		body {
			background-image: none;			
		}
	</style>
    <script text="text/javascript">
		window.onload = () => alert('Please do not enter valid credit card information, this form is for testing purposes. You are welcome to enter fake info.');
	</script>
<?php
include_once 'footer.php';
?>