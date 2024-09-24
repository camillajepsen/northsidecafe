<?php
session_start(); // Ensure session is started

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','Cafe');

// Create Connection
$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check Connection
if ($link->connect_error) { 
    die('Connection Failed: ' . $link->connect_error); // kills the Connection
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // User-provided input
    $provided_user_id = $_POST['user_id'];
    $provided_password = $_POST['password'];

    // Prepared statement to fetch user record based on provided user_id
    $stmt = $link->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $provided_user_id); // Bind user_id as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];
        $user_role = $row['role']; // Fetch user role from the database

        // Check password
        if ($provided_password === $stored_password) {
            // Password matches, login successful

            // Store user information in session
            $_SESSION['logged_user_id'] = $provided_user_id;
            $_SESSION['logged_username'] = $row['username']; // Fetch username
            $_SESSION['role'] = $user_role; // Store user role

            // Redirect based on role
            if ($user_role === 'staff') {
                header("Location: ../frontend/staff_dashboard.php"); // Staff dashboard
            } elseif ($user_role === 'admin') {
                header("Location: ../frontend/admin_dashboard.php"); // Admin dashboard
            } elseif ($user_role === 'cashier') {
                header("Location: ../frontend/cashier_dashboard.php"); // Cashier dashboard
            } else {
                header("Location: ../frontend/customer_dashboard.php"); // Customer dashboard
            }
            exit; // Exit after redirection
        } else {
            $message = "Incorrect password.<br>Please try again.";
        }
    } else {
        $message = "Staff ID not found.<br>Please try again.";
    }
}

// Display any messages to the user
if (isset($message)) {
    echo "<div class='alert-danger'>$message</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
        /* Your custom CSS styles for the success message card here */
        body {
            text-align: center;
            padding: 40px 0;
            background: #EBF0F5;
        }
        h1 {
            color: #88B04B;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }
        p {
            color: #404F5E;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size: 20px;
            margin: 0;
        }
        i.checkmark {
            color: #9ABC66;
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }
        .card {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }
        .alert-danger {
            background-color: #FFA7A7; /* Custom background color for error */
        }
    </style>
</head>
<body>
    <div class="card">
        <h1><?php echo isset($message) ? 'Error' : 'Success'; ?></h1>
        <p><?php echo isset($message) ? $message : 'Login successful!'; ?></p>
    </div>

    <script>
        // Redirect logic can be placed here if needed
    </script>
</body>
</html>
