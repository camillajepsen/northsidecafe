<?php
require_once "../config.php";

$email = $password = "";
$email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);

            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt)) {
                echo "Registration successful.";
            } else {
                echo "Something went wrong. Please try again.";
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
    <title>Registration Form</title>
  
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0; /* Remove default margin */
            background-color:black;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
        }
        .background-video { 
            position: fixed;
             top: 0;
            left: 0; 
            width: 100%;
            height: 100%; 
            z-index: -1; 
            overflow: hidden;
         }
          .background-video video 
          {
            position: absolute;
            top: 50%;
            left: 50%; 
            min-width: 100%;
            min-height: 100%; 
            transform: translate(-50%, -50%); 
            object-fit: cover;
         }

        .register-container {
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            padding: 20px;
            width: 400px;
            max-width: 90%;
    
        }

        .register-container a {
            text-decoration: none;
        }

        h1, h2, p {
            text-align: center;
            font-family: 'Montserrat', serif;
        }

        .form-group {
            margin-bottom: 15px; /* Add space between form elements */
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

       

        .form-group button {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: none;
    }

    .btn-dark{
            color: white;
           
        }
    </style>
    <?php
// ... existing PHP code ...
$email_err = $username_err = $password_err = $Contact_number_err = "";

// Check if the form was submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... existing PHP code ...
} else {
    // Initialize error variables if the form was not submitted
    $email_err = $username_err = $password_err = $Contact_number_err = "";
}

?>
</head>
<body>
<div class="background-video">
    <video autoplay muted loop>
        <source src="../image/coffeebeans.mp4" type="video/mp4"></video></div>
    <div class="register-container">
        <a class="nav-link" href="../home/home.php#hero"> <h1 style="font-family:Copperplate; color:white;">Northside </h1><span class="sr-only"></span></a><br>
       
        <form action="register.php" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                                <span class="text-danger"><?php echo $email_err; ?></span>
            </div>

            <div class="form-group">
                <label> User Name</label>
                <input type="text" name="member_name" class="form-control" placeholder="Enter user Name" required>
                                <span class="text-danger"><?php echo $username_err; ?></span>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                                <span class="text-danger"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="Contact number" class="form-control" placeholder="Enter Phone Number" required>
                                <span class="text-danger"><?php echo $Contact_number_err; ?></span>
            </div>

            <button style="background-color:black;" class="btn-dark" type="submit" name="register" value="Register">Register</button>
        </form>

        <p style="margin-top:1em; color:white;">Already have an memberships? <a href="../customerLogin/login.php" >Proceed to Login</a></p>
    </div>
</body>
</html>
