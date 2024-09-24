<?php
require_once "../config.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Check if cart is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("location: view_cart.php");
    exit;
}

// Define variables for order
$total_amount = $shipping_method = $shipping_time = $shipping_location = "";
$shipping_method_err = $shipping_time_err = $shipping_location_err = "";

// Process the order form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate shipping method
    if (empty(trim($_POST["shipping_method"]))) {
        $shipping_method_err = "Please select a shipping method.";
    } else {
        $shipping_method = trim($_POST["shipping_method"]);
    }

    // Validate shipping time
    if (empty(trim($_POST["shipping_time"]))) {
        $shipping_time_err = "Please select a shipping time.";
    } else {
        $shipping_time = trim($_POST["shipping_time"]);
    }

    // Validate shipping location
    if (empty(trim($_POST["shipping_location"]))) {
        $shipping_location_err = "Please enter a shipping location.";
    } else {
        $shipping_location = trim($_POST["shipping_location"]);
    }

    // Calculate total amount (Replace this with actual calculation based on cart items)
    $total_amount = 0.00; // Calculate total based on cart items

    // Check input errors before inserting into database
    if (empty($shipping_method_err) && empty($shipping_time_err) && empty($shipping_location_err)) {
        $sql = "INSERT INTO `order` (total_amount, shipping_method, shipping_time, shipping_location, order_status) VALUES (?, ?, ?, ?, 'Pending')";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "dsss", $total_amount, $shipping_method, $shipping_time, $shipping_location);

            if (mysqli_stmt_execute($stmt)) {
                $order_id = mysqli_insert_id($link); // Get the last inserted order ID
                $return_url = "http://yourdomain.com/thank_you.php"; // Redirect URL after payment
                $cancel_url = "http://yourdomain.com/cancel_order.php"; // Redirect URL if payment is cancelled

                // PayPal button code
                echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="your_paypal_email@example.com"> <!-- Replace with your PayPal email -->
                    <input type="hidden" name="item_name" value="Order ID ' . $order_id . '">
                    <input type="hidden" name="amount" value="' . number_format($total_amount, 2) . '">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="return" value="' . $return_url . '">
                    <input type="hidden" name="cancel_return" value="' . $cancel_url . '">
                    <input type="submit" value="Pay with PayPal">
                </form>';
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <div class="dashboard_wrapper">
        <h2>Place an Order</h2>
        <form action="place_order.php" method="post">
            <div class="form-group">
                <label>Shipping Method</label>
                <select name="shipping_method" class="form-control">
                    <option value="">Select</option>
                    <option value="pick up">Pick Up</option>
                    <option value="deliver">Deliver</option>
                </select>
                <span class="text-danger"><?php echo $shipping_method_err; ?></span>
            </div>
            <div class="form-group">
                <label>Shipping Time</label>
                <input type="datetime-local" name="shipping_time" class="form-control" required>
                <span class="text-danger"><?php echo $shipping_time_err; ?></span>
            </div>
            <div class="form-group">
                <label>Shipping Location</label>
                <input type="text" name="shipping_location" class="form-control" placeholder="Enter shipping location" required>
                <span class="text-danger"><?php echo $shipping_location_err; ?></span>
            </div>
            <button class="btn" type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($link);
?>
