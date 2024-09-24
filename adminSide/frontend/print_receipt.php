<?php
require_once "../config.php";

$order_id = $_GET['order_id'];

$sql = "SELECT * FROM orders WHERE order_id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($order = mysqli_fetch_assoc($result)) {
        // Generate receipt view (HTML)
        echo "<h1>Receipt for Order #" . $order_id . "</h1>";
        echo "<p>Order Date: " . $order['order_date'] . "</p>";
        echo "<p>Total: $" . $order['total_amount'] . "</p>";
        // Add other details like products, quantities, etc.
    }

    mysqli_stmt_close($stmt);
}
?>
