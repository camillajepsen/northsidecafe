<?php
require_once "../config.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Fetch orders from the database
$sql = "SELECT * FROM `order` WHERE order_status = 'Confirmed'"; // Adjust the query based on your needs
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders</title>
    <style>
        /* Add your styles here */
        .order-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            background-color: #f9f9f9;
        }
        .order-item p {
            margin: 5px 0;
        }
        .order-item a {
            color: #b5651d; /* Link color */
            text-decoration: none;
            font-weight: bold;
        }
        .order-item a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Your Orders</h2>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='order-item'>";
            echo "<p><strong>Order ID:</strong> " . htmlspecialchars($row['order_id']) . "</p>";
            echo "<p><strong>Total Amount:</strong> $" . htmlspecialchars($row['total_amount']) . "</p>";
            echo "<p><strong>Shipping Method:</strong> " . htmlspecialchars($row['shipping_method']) . "</p>";
            echo "<p><strong>Shipping Time:</strong> " . htmlspecialchars($row['shipping_time']) . "</p>";
            echo "<p><strong>Shipping Location:</strong> " . htmlspecialchars($row['shipping_location']) . "</p>";
            echo "<p><strong>Status:</strong> " . htmlspecialchars($row['order_status']) . "</p>";
            
            // Display cancel link if the order is confirmed
            if ($row['order_status'] === 'Confirmed') {
                echo "<p><a href='cancel_order.php?order_id=" . htmlspecialchars($row['order_id']) . "' onclick=\"return confirm('Are you sure you want to cancel this order?');\">Cancel Order</a></p>";
            }
            
            echo "</div>";
        }
    } else {
        echo "<p>No orders to display.</p>";
    }
    ?>

</body>
</html>

<?php
mysqli_close($link);
?>
