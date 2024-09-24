<?php
// process_order.php

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





// Calculate total amount based on item and quantity (example logic)
$prices = [
    'coffee' => 5.00,
    'iced_drink' => 4.00,
    'tea' => 3.00,
    'soft_drink' => 2.00
];
$total_amount = $prices[$item] * $quantity;

// Set default values for shipping method, time, location, and status
$shipping_method = 'pick up'; // Default shipping method
$shipping_time = date('Y-m-d H:i:s'); // Current time
$shipping_location = 'N/A'; // Default location
$order_status = 'Confirmed'; // Default order status

// Insert order into the database
$sql = "INSERT INTO `order` (total_amount, shipping_method, shipping_time, shipping_location, order_status) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $link->prepare($sql);
$stmt->bind_param("dssss", $total_amount, $shipping_method, $shipping_time, $shipping_location, $order_status);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id; // Get the ID of the inserted order
    // Redirect to the confirmation page with the order ID
    header("Location: confirmation.php?order_id=$order_id");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$link->close();
?>
