<?php
include "../../config.php";

// Get form data
$product_name = $_POST['product_name'];
$description = $_POST['description'];
$price = $_POST['price'];
$category_id = $_POST['category_id'];

// Image upload handling
$image = $_FILES['image']['tmp_name'];

// Check if the image file is valid
$check = getimagesize($image);
if ($check === false) {
    die("File is not an image.");
}

// Read image content as binary
$imageContent = addslashes(file_get_contents($image));

// Insert query
$sql = "INSERT INTO products (product_name, Description, Price, category_id, image)
        VALUES ('$product_name', '$description', '$price', '$category_id', '$imageContent')";

// Execute query
if ($link->query($sql) === TRUE) {
    echo "New item added successfully.";
    header("Location: manage_items.php");  // Redirect back to the manage page
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
}

// Close connection
$link->close();
?>
