<?php
include '../config.php'; 

// Check the connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the image ID from the query parameter
$id = $_GET['id'];

// Prepare and execute the SQL statement
$sql = "SELECT image FROM categories WHERE category_id = ?";
$stmt = $link->prepare($sql);

// Check if the prepare() call failed
if ($stmt === false) {
    die("Error preparing the SQL statement: " . $link->error);
}

// Bind the parameter and execute
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($imageData);
$stmt->fetch();
$stmt->close();

// Set the correct content type for the image
header("Content-Type: image/jpeg"); // Change to the appropriate type if needed

// Output the image data
echo $imageData;
?>
