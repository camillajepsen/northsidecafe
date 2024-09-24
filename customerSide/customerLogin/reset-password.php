<?php
require_once "../config.php";

// Define variables for email and new password
$email = "";
$email_err = "";
$new_password = "";
$new_password_err = "";

// Check if the form was submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
        
        // Check if the email exists in the database
        $sql = "SELECT user_id FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Process the new password
                    if (isset($_POST["new_password"])) {
                        $new_password = trim($_POST["new_password"]);
                        $new_password_confirm = trim($_POST["new_password_confirm"]);

                        // Validate new password
                        if (empty($new_password)) {
                            $new_password_err = "Please enter a new password.";
                        } elseif ($new_password !== $new_password_confirm) {
                            $new_password_err = "Passwords do not match.";
                        } else {
                            // Hash the new password
                            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                            // Update the password in the database
                            $sql_update = "UPDATE users SET password = ? WHERE email = ?";

                            if ($stmt_update = mysqli_prepare($link, $sql_update)) {
                                mysqli_stmt_bind_param($stmt_update, "ss", $hashed_password, $email);

                                if (mysqli_stmt_execute($stmt_update)) {
                                    echo "Password has been reset successfully.";
                                } else {
                                    echo "Something went wrong. Please try again later.";
                                }

                                mysqli_stmt_close($stmt_update);
                            }
                        }
                    }
                } else {
                    $email_err = "No account found with this email.";
                }
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
    <title>Reset Password</title>
    <!-- Add your styles here -->
</head>
<body>
    <div class="login_wrapper">
        <h2>Reset Password</h2>
        <form action="reset-password.php" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                <span class="text-danger"><?php echo $email_err; ?></span>
            </div>

            <?php if ($email && empty($email_err)): ?>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                    <span class="text-danger"><?php echo $new_password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="new_password_confirm" class="form-control" placeholder="Confirm new password" required>
                    <span class="text-danger"><?php echo $new_password_err; ?></span>
                </div>
                <button class="btn btn-dark" type="submit">Reset Password</button>
            <?php else: ?>
                <button class="btn btn-dark" type="submit">Send Reset Link</button>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
