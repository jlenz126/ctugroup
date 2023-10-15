<?php
include_once 'session.php';
include_once 'header.php';
include_once 'navbar.php';
?>

	<!-- Main container of page -->
	<div class="container-fluid">
		<div class="row">
			<div class="main-view landingPadding">
				<!-- cart display here -->
			</div>
		</div>
	</div>
	<!-- End main container -->


<?php
include_once 'footer.php';
?>

<?php
// Define an array of pizza names and their prices
$pizzas = [
    "Pepperoni Pizza" => 10.99,
    "Meatzilla" => 12.99,
    "Veggie Pizza" => 11.99,
    "The Godfather" => 14.99,
    "Queen Bee" => 13.99,
    "The OG" => 15.99,
];

// Define an array of appetizers and their prices
$appetizers = [
    "Cheesy Bread Sticks" => 4.99,
    "Fries" => 3.99,
    "Chips and Dips" => 5.99,
    "Fried Pickles" => 4.49,
    "Mac n Cheese" => 6.99,
    "Salad" => 4.99,
];

// Define the price of drinks
$drinkPrice = 1.99;

// Define any promotion prices or discounts
$promotionPrice = 20.99;
$discount = 2.00;

// Initialize cart items
$cart = [];

// Check if the user has added items to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data and add items to the cart
    if (isset($_POST["pizza"])) {
        $pizza = $_POST["pizza"];
        $quantity = $_POST["pizza_quantity"];
        $cart[] = ["item" => $pizza, "price" => $pizzas[$pizza], "quantity" => $quantity];
    }

    if (isset($_POST["appetizer"])) {
        $appetizer = $_POST["appetizer"];
        $quantity = $_POST["appetizer_quantity"];
        $cart[] = ["item" => $appetizer, "price" => $appetizers[$appetizer], "quantity" => $quantity];
    }

    if (isset($_POST["drink"])) {
        $quantity = $_POST["drink_quantity"];
        $cart[] = ["item" => "Drink", "price" => $drinkPrice, "quantity" => $quantity];
    }

    if (isset($_POST["combo"])) {
        $cart[] = ["item" => "Combo (Pizza, Drink, Appetizer)", "price" => $promotionPrice];
    }

    if (isset($_POST["kid_combo"])) {
        $cart[] = ["item" => "Kid's Combo (Pizza, Drink, Appetizer)", "price" => $promotionPrice - $discount];
    }
}

// Calculate the cart total
$total = 0;
foreach ($cart as $item) {
    $total += $item["price"] * $item["quantity"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart Page</title>
</head>
<body>
    <h1>Cart</h1>

    <!-- Display the cart items -->
    <table>
        <tr>
            <th>Item</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        <?php foreach ($cart as $item) : ?>
            <tr>
                <td><?php echo $item["item"]; ?></td>
                <td>$<?php echo number_format($item["price"], 2); ?></td>
                <td><?php echo $item["quantity"]; ?></td>
                <td>$<?php echo number_format($item["price"] * $item["quantity"], 2); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">Total:</td>
            <td>$<?php echo number_format($total, 2); ?></td>
        </tr>
    </table>

    <!-- Cart items form -->
    <form method="post">
        <h2>Add Items to Cart</h2>
        <label for="pizza">Pizza:</label>
        <select name="pizza" id="pizza">
            <?php foreach ($pizzas as $pizzaName => $pizzaPrice) : ?>
                <option value="<?php echo $pizzaName; ?>"><?php echo $pizzaName; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="pizza_quantity" value="1" min="1">

        <label for="appetizer">Appetizer:</label>
        <select name="appetizer" id="appetizer">
            <?php foreach ($appetizers as $appetizerName => $appetizerPrice) : ?>
                <option value="<?php echo $appetizerName; ?>"><?php echo $appetizerName; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="appetizer_quantity" value="1" min="1">

        <label for="drink">Drink:</label>
        <input type="number" name="drink_quantity" value="1" min="1">

        <input type="submit" value="Add to Cart">
    </form>

    <!-- Special offers -->
    <h2>Special Offers</h2>
    <form method="post">
        <label for="combo">Combo (Pizza, Drink, Appetizer) - $<?php echo number_format($promotionPrice, 2); ?></label>
        <input type="submit" name="combo" value="Add to Cart">

        <label for="kid_combo">Kid's Combo (Pizza, Drink, Appetizer) - $<?php echo number_format($promotionPrice - $discount, 2); ?></label>
        <input type="submit" name="kid_combo" value="Add to Cart">
    </form>
</body>
</html>
