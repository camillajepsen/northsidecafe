<?php
require_once "../config.php";

$token = $_GET['token'] ?? '';
$new_password = "";
$new_password_err = "";

// Verify the token
if (isset($token)) {
    $sql = "SELECT email FROM password_resets WHERE token = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_token);
        $param_token = $token;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Token is valid
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Validate new password
                    if (empty(trim($_POST["new_password"]))) {
                        $new_password_err = "Please enter your new password.";
                    } else {
                        $new_password = trim($_POST["new_password"]);
                    }

                    if (empty($new_password_err)) {
                        // Update the user's password
                        $sql_update = "UPDATE users SET password = ? WHERE email = (SELECT email FROM password_resets WHERE token = ?)";

                        if ($stmt_update = mysqli_prepare($link, $sql_update)) {
                            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt_update, "ss", $hashed_password, $param_token);

                            if (mysqli_stmt_execute($stmt_update)) {
                                // Delete the token
                                $sql_delete = "DELETE FROM password_resets WHERE token = ?";

                                if ($stmt_delete = mysqli_prepare($link, $sql_delete)) {
                                    mysqli_stmt_bind_param($stmt_delete, "s", $param_token);
                                    mysqli_stmt_execute($stmt_delete);
                                    echo "Your password has been reset successfully.";
                                }
                            } else {
                                echo "Error updating password. Please try again later.";
                            }
                        }
                    }
                }
            } else {
                echo "Invalid token.";
            }
        }
    }
} else {
    echo "No token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password Form</title>
    <!-- Add your styles here -->
</head>
<body>
    <div class="login_wrapper">
        <h2>Set New Password</h2>
        <form action="reset-password-form.php?token=<?php echo htmlspecialchars($token); ?>" method="post">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                <span class="text-danger"><?php echo $new_password_err; ?></span>
            </div>
            <button class="btn btn-dark" type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
