<?php
include "../../config.php";

// Get the product_id from the URL
$product_id = $_GET['id'];

// Fetch the product details
$sql = "SELECT * FROM products WHERE product_id = $product_id";
$result = $link->query($sql);
$product = $result->fetch_assoc();

// Handle form submission for updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];
        $imageContent = addslashes(file_get_contents($image));
        $updateQuery = "UPDATE products SET product_name='$product_name', Description='$description', Price='$price', category_id='$category_id', image='$imageContent' WHERE product_id=$product_id";
    } else {
        $updateQuery = "UPDATE products SET product_name='$product_name', Description='$description', Price='$price', category_id='$category_id' WHERE product_id=$product_id";
    }

    if ($link->query($updateQuery) === TRUE) {
        echo "Product updated successfully.";
        header("Location: manage_items.php");  // Redirect back to the manage page
        exit();
    } else {
        echo "Error updating product: " . $link->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Item</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Edit Product</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required><br>

        <label>Description:</label>
        <textarea name="description" required><?php echo $product['Description']; ?></textarea><br>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="<?php echo $product['Price']; ?>" required><br>

        <label>Category ID:</label>
        <input type="number" name="category_id" value="<?php echo $product['category_id']; ?>" required><br>

        <label>Image (optional):</label>
        <input type="file" name="image"><br>

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
