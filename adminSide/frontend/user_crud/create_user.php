<?php
// Include database configuration
require_once '../../config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form inputs
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $role = mysqli_real_escape_string($link, $_POST['role']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $contact_number = mysqli_real_escape_string($link, $_POST['contact_number']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert new user
    $sql = "INSERT INTO users (username, password, role, Email, Contact_number) VALUES (?, ?, ?, ?, ?)";

    // Prepare and execute statement
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssss", $username, $hashed_password, $role, $email, $contact_number);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "User created successfully!";
        } else {
            echo "Error: " . mysqli_error($link);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Adjust the path if necessary -->
</head>
<body>
    <div class="container">
        <h2>Create New User</h2>
        <a href="read_user.php"><button class="action-button">Back</button></a>

        <form action="create_user.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="Admin">Admin</option>
                <option value="Staff">Staff</option>
                <option value="Cashier">Cashier</option>
                <option value="customer">Customer</option>
            </select>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" required>
            
            <input type="submit" value="Create User">
        </form>
    </div>
</body>
</html>
