<?php
require_once "../config.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Initialize variables
$cart_items = [];
$total_amount = 0.00;

// Fetch product details for items in the cart
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart_ids = implode(',', array_map('intval', $_SESSION['cart'])); // Convert cart items to comma-separated string
    $sql = "SELECT * FROM products WHERE product_id IN ($cart_ids)";
    $result = mysqli_query($link, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cart_items[] = $row;
            $total_amount += $row['Price']; // Assuming 'Price' is the column name for the price
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Cart</title>
    <style>
        /* Add your styles here */
        .cart-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            background-color: #f9f9f9;
        }
        .cart-item p {
            margin: 5px 0;
        }
        .cart-item h3 {
            margin: 0 0 10px;
        }
        .btn {
            background-color: #b5651d;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #a04d1c;
        }
    </style>
</head>
<body>
    <h2>Your Cart</h2>

    <?php
    if (!empty($cart_items)) {
        foreach ($cart_items as $item) {
            echo "<div class='cart-item'>";
            echo "<h3>" . htmlspecialchars($item['product_name']) . "</h3>";
            echo "<p><strong>Description:</strong> " . htmlspecialchars($item['Description']) . "</p>";
            echo "<p><strong>Price:</strong> $" . htmlspecialchars($item['Price']) . "</p>";
            echo "</div>";
        }
        echo "<div class='cart-item'>";
        echo "<h3>Total Amount: $" . number_format($total_amount, 2) . "</h3>";
        echo "</div>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>

    <a href="place_order.php" class="btn">Proceed to Checkout</a>

    <form action="clear_cart.php" method="post">
        <button type="submit" class="btn">Clear Cart</button>
    </form>
</body>
</html>

<?php
mysqli_close($link);
?>
