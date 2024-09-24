<?php
// Database connection
include '../config.php';

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the order details from POST request
    $orderNumber = $_POST['orderNumber'];
    $selectionName = $_POST['selectionName'];
    $size = $_POST['size'];
    $milk = $_POST['milk'];
    $takeaway = $_POST['takeaway'];
    $sugar = $_POST['sugar'];
    $cost = $_POST['cost'];

    // Retrieve the shipping details
    $shippingMethod = $_POST['shippingMethod'];
    $shippingTime = $_POST['shippingTime'];
    $shippingLocation = $_POST['shippingLocation'];
    $orderStatus = $_POST['orderStatus']; // Default is 'unfulfilled'

    echo $orderStatus;
    // Start transaction
    $link->begin_transaction();

    try {
        // Insert order into the orders table
        $stmt = $link->prepare("
            INSERT INTO `order` (shipping_method, shipping_time, shipping_location, total_amount, order_status) 
            VALUES (?, ?, ?, ?, ?)");

        if (!$stmt) {
            // Output error if the statement preparation failed
            throw new Exception("Order statement preparation failed: " . $link->error);
        }

        $totalCost = $cost;  // Assuming total cost is the cost of the item
        $stmt->bind_param("sssds", $shippingMethod, $shippingTime, $shippingLocation, $totalCost, $orderStatus);
        $stmt->execute();


        // Get the last inserted order ID
        $orderId = $link->insert_id;

        // Insert order details into the order_details table
        $stmt = $link->prepare("
    INSERT INTO `order_detail` (order_id, size) 
    VALUES (?, ?)");

        if (!$stmt) {
            // Output error if the statement preparation failed
            throw new Exception("Order details statement preparation failed: " . $link->error);
        }

        $stmt->bind_param("is", $orderId,   $size);  // "iss" = integer, string, string
        $stmt->execute();

        // Commit the transaction
        $link->commit();

        // Redirect to a confirmation page or display success
        // header('Location: index.php');
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $link->rollback();
        echo "Failed to place the order: " . $e->getMessage();
    }
}

$link->close();
