<?php
require_once "../config.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
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

    // Check input errors before inserting into database
    if (empty($shipping_method_err) && empty($shipping_time_err) && empty($shipping_location_err)) {
        $total_amount = 0.00; // Calculate or fetch total amount based on the cart or selection

        $sql = "INSERT INTO `order` (total_amount, shipping_method, shipping_time, shipping_location, order_status) VALUES (?, ?, ?, ?, 'Confirmed')";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "dsss", $total_amount, $shipping_method, $shipping_time, $shipping_location);

            if (mysqli_stmt_execute($stmt)) {
                echo "Order placed successfully!";
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
        body {
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .dashboard_wrapper {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .text-danger {
            font-size: 13px;
            color: red;
        }
        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #444;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="datetime-local"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
    <script>
        function updateShippingLocation() {
            const shippingMethod = document.querySelector('select[name="shipping_method"]').value;
            const shippingLocationField = document.querySelector('input[name="shipping_location"]');
            
            if (shippingMethod === 'pick up') {
                shippingLocationField.value = 'In Store';
                shippingLocationField.disabled = true; // Optionally disable the field to prevent user edits
            } else {
                shippingLocationField.disabled = false; // Enable if the user selects another shipping method
            }
        }

        function setMinShippingTime() {
            const now = new Date();
            const isoString = now.toISOString().split('.')[0]; // Remove milliseconds
            const datetimeInput = document.querySelector('input[name="shipping_time"]');
            datetimeInput.setAttribute('min', isoString);
        }

        // Set minimum shipping time on page load
        window.onload = setMinShippingTime;
    </script>
</head>
<body>
    <div class="dashboard_wrapper">
        <h2>Place an Order</h2>
        <form action="dashboard.php" method="post">
            <div class="form-group">
                <label>Shipping Method</label>
                <select name="shipping_method" class="form-control" onchange="updateShippingLocation()">
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
