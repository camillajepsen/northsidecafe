<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier/Waiter Login</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            background-size: cover;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7); /* Darker background for better contrast */
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        .close-button {
            position: absolute;
            right: 20px;
            top: 20px;
            color: white;
            font-size: 24px;
            cursor: pointer;
            text-decoration: none;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin: 15px 0;
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
            color: #fff;
            background: #007bff; /* Bootstrap primary color */
            cursor: pointer;
            margin-top: 15px;
        }

        .form-group button:hover {
            background: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <a href="../../customerSide/home/home.php" class="close-button">&times;</a>
        <h2>Cashier/Waiter Login</h2>
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
        <form action="login_process.php" method="post">
            <div class="form-group">
                <label for="user_id">User ID</label>
                <input type="number" id="user_id" name="user_id" placeholder="Enter User ID" required class="form-control <?php echo (!empty($user_id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
                <span class="invalid-feedback"><?php echo isset($user_id_err) ? $user_id_err : ''; ?></span>
            </div>
                
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            </div>
                
            <div class="form-group">
                <button type="submit" name="submit" value="Login">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
