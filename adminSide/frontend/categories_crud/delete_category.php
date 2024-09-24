<?php
include "../../config.php";

// Get the category_id from the URL
$category_id = $_GET['id'];

// Delete query
$sql = "DELETE FROM categories WHERE category_id = $category_id";

if ($link->query($sql) === TRUE) {
    echo "Category deleted successfully.";
    header("Location: manage_category.php");  // Redirect back to the manage page
    exit();
} else {
    echo "Error deleting category: " . $link->error;
}

// Close connection
$link->close();
?>
