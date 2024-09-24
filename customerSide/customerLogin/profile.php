<?php
// Include your database connection code here
include('../config.php'); // Ensure this file initializes $link

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirect to the login page if not logged in
    exit;
}

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    die('Error: User ID not found in session.');
}

// Fetch the user's profile information
$user_id = $_SESSION['user_id']; 

// Prepare SQL query
$query = "SELECT username, password, role, email, contact_number
          FROM users
          WHERE user_id = ?";

// Prepare statement
$stmt = $link->prepare($query);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($link->error));
}

// Bind parameters and execute
$stmt->bind_param('i', $user_id);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die('No user found with the provided ID.');
    }
} else {
    echo 'Error: ' . htmlspecialchars($stmt->error);
    // Handle the error gracefully
}

// Close the database connection
$stmt->close();
$link->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
    <h2>User Profile</h2>
    <p>Welcome, <?php echo htmlspecialchars($row['username']); ?>!</p>
    <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
    <p>Contact Number: <?php echo htmlspecialchars($row['contact_number']); ?></p>
    <p>Role: <?php echo htmlspecialchars($row['role']); ?></p>
    <!-- Password is not typically shown in profile pages for security reasons -->
    <!-- <p>Password: <?php echo htmlspecialchars($row['password']); ?></p> -->
    <a href="logout.php">Logout</a>
</body>
</html>
