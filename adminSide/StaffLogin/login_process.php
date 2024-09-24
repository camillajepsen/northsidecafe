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
           // } else {
               // header("Location: ../frontend/customer_dashboard.php"); // Customer dashboard
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
<body>
    <div class="card <?php echo $cardClass; ?>" style="display: none;">
        <div style="border-radius: 200px; height: 200px; width: 200px; background: #F8FAF5; margin: 0 auto;">
            <?php if ($iconClass === 'fa-check-circle'): ?>
                <i class="checkmark">✓</i>
            <?php else: ?>
                <i class="custom-x" style="font-size: 100px; line-height: 200px;">✘</i>
            <?php endif; ?>
        </div>
        <h1><?php echo ($cardClass === 'alert-success') ? 'Success' : 'Error'; ?></h1>
        <p><?php echo $message; ?></p>
    </div>

    <div style="text-align: center; margin-top: 20px;">Redirecting back in <span id="countdown">3</span></div>

    <script>
        //Declare the direction of login success and fail 
        var direction = "<?php echo $direction; ?>";
        
        // Function to show the message card as a pop-up and start the countdown
        function showPopup() {
            var messageCard = document.querySelector(".card");
            messageCard.style.display = "block";

            var i = 3;
            var countdownElement = document.getElementById("countdown");
            var countdownInterval = setInterval(function() {
                i--;
                countdownElement.textContent = i;
                if (i <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = direction;
                }
            }, 1000); // 1000 milliseconds = 1 second
        }

        // Show the message card and start the countdown when the page is loaded
        window.onload = showPopup;

        // Function to hide the message card after a delay
        function hidePopup() {
            var messageCard = document.querySelector(".card");
            messageCard.style.display = "none";
            // Redirect to another page after hiding the pop-up (adjust the delay as needed)
            setTimeout(function () {
                window.location.href = direction; // Replace with your desired URL
            }, 3000); // 3000 milliseconds = 3 seconds
        }

        // Hide the message card after 3 seconds (adjust the delay as needed)
        setTimeout(hidePopup, 3000);
    </script>
</body>
</html>
</head>
</html>