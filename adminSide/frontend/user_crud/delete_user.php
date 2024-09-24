<?php
include "../../config.php";

$user_id = $_GET['user_id'];

$sql = "DELETE FROM users WHERE user_id = $user_id";

if ($link->query($sql) === TRUE) {
    echo "User deleted successfully.";
    header("Location: read_user.php");  
    exit();
} else {
    echo "Error deleting user: " . $link->error;
}

$link->close();
?>
