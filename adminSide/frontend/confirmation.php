<?php
// confirmation.php

// Database connection details
$hostname = "localhost";
$username = "root";
$password = ""; 
$dbname = "Cafe"; 

// Create connection
$link = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Get order ID from the query string
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Fetch order details from the database
$sql = "SELECT * FROM `order` WHERE `order_id` = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the order exists
if ($result->num_rows === 0) {
    echo "<h1>Order not found</h1>";
    echo "<p>We could not find the order you are looking for.</p>";
} else {
    $order = $result->fetch_assoc();
    echo "<h1>Order Confirmation</h1>";
    echo "<p><strong>Order ID:</strong> " . htmlspecialchars($order['order_id']) . "</p>";
    echo "<p><strong>Total Amount:</strong> $" . htmlspecialchars($order['total_amount']) . "</p>";
    echo "<p><strong>Shipping Method:</strong> " . htmlspecialchars($order['shipping_method']) . "</p>";
    echo "<p><strong>Shipping Time:</strong> " . htmlspecialchars($order['shipping_time']) . "</p>";
    echo "<p><strong>Shipping Location:</strong> " . htmlspecialchars($order['shipping_location']) . "</p>";
    echo "<p><strong>Order Status:</strong> " . htmlspecialchars($order['order_status']) . "</p>";
}

$stmt->close();
$link->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="gradient-background">
    <div class="container">
        <div class="order-confirmation">
        <?php
            // Check if the order exists
            if ($result->num_rows === 0) {
                echo "<h1>Order not found</h1>";
                echo "<p>We could not find the order you are looking for.</p>";
            } else {
                $order = $result->fetch_assoc();
                echo "<h1>Order Confirmation</h1>";
                echo "<p><strong>Order ID:</strong> " . htmlspecialchars($order['order_id']) . "</p>";
                echo "<p><strong>Total Amount:</strong> $" . htmlspecialchars($order['total_amount']) . "</p>";
                echo "<p><strong>Shipping Method:</strong> " . htmlspecialchars($order['shipping_method']) . "</p>";
                echo "<p><strong>Shipping Time:</strong> " . htmlspecialchars($order['shipping_time']) . "</p>";
                echo "<p><strong>Shipping Location:</strong> " . htmlspecialchars($order['shipping_location']) . "</p>";
                echo "<p><strong>Order Status:</strong> " . htmlspecialchars($order['order_status']) . "</p>";
            }

            $stmt->close();
            $link->close();
            ?>        </div>
    </div>
</body>
</html>
