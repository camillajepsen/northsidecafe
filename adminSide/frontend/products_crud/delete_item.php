<?php
include "../../config.php";

// Get the product_id from the URL
$product_id = $_GET['id'];

// Delete query
$sql = "DELETE FROM products WHERE product_id = $product_id";

if ($link->query($sql) === TRUE) {
    echo "Product deleted successfully.";
    header("Location: manage_items.php");  // Redirect back to the manage page
    exit();
} else {
    echo "Error deleting product: " . $link->error;
}

// Close connection
$link->close();
?>
