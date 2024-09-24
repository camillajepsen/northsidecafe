<?php
require_once "../config.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Check if order ID is provided
if (!isset($_GET['order_id']) || empty(trim($_GET['order_id']))) {
    header("location: view_orders.php");
    exit;
}

$order_id = trim($_GET['order_id']);

// Prepare a statement to update the order status
$sql = "UPDATE `order` SET order_status = 'Cancelled' WHERE order_id = ?";

if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Order canceled successfully!";
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Failed to prepare the SQL statement.";
}

mysqli_close($link);
?>
