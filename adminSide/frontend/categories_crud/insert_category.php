<?php
include '../../config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $description = $_POST['description'];

// Image upload handling
$image = $_FILES['image']['tmp_name'];

// Check if the image file is valid
$check = getimagesize($image);
if ($check === false) {
    die("File is not an image.");
}

// Read image content as binary
$imageContent = addslashes(file_get_contents($image));


        $sql = "INSERT INTO categories (category_name, description, image) VALUES ('$category_name', '$description', '$imageContent')";
        if ($link->query($sql) === TRUE) {
            header("Location: manage_category.php");
        } else {
            echo "Error: " . $link->error;
        }
    }

?>
