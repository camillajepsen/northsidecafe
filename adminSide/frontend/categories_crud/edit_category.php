<?php
include "../../config.php";

// Get the category_id from the URL
$category_id = $_GET['id'];

// Fetch the category details
$sql = "SELECT * FROM categories WHERE category_id = $category_id";
$result = $link->query($sql);
$category = $result->fetch_assoc();

// Handle form submission for updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $description = $_POST['description'];
    $category_id = $_POST['id'];

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];
        $imageContent = addslashes(file_get_contents($image));
        $updateQuery = "UPDATE categories SET category_name='$category_name', Description='$description', category_id='$category_id', image='$imageContent' WHERE category_id=$category_id";
    } else {
        $updateQuery = "UPDATE categories SET category_name='$category_name', Description='$description', category_id='$category_id' WHERE category_id=$category_id";
    }

    if ($link->query($updateQuery) === TRUE) {
        echo "category updated successfully.";
        header("Location: manage_category.php");  // Redirect back to the manage page
        exit();
    } else {
        echo "Error updating category: " . $link->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
</head>
<body>
    <h1>Edit Category</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $category['category_id']; ?>">
        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($category['Description']); ?></textarea><br>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image"><br>
        <img src="<?php echo htmlspecialchars($category['image']); ?>" alt="<?php echo htmlspecialchars($category['category_name']); ?>" width="100"><br>
        <input type="submit" value="Update Category">
    </form>
</body>
</html>
