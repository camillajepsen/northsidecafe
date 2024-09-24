<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

// Check if user has the 'staff' role
if ($_SESSION['role'] !== 'staff') {
    // Optionally, redirect to an error page or show an error message
    echo "Access denied.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
</head>
<body>
    <h1>Welcome, Staff!</h1>
    <nav>
        <ul>
            <li><a href="home.php">Home Page</a></li>
            <li><a href="category_management.php">Category Management</a></li>
            <li><a href="product_management.php">Product Management</a></li>
            <li><a href="sale_management.php">Sale Management</a></li>
            <li><a href="report.php">Report</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Content for the staff dashboard -->
</body>
</html>
