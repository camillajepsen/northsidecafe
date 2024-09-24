<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add New Item</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Add New Item</h1>
        <form action="insert_item.php" method="POST" enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>

            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" required><br>

            <label for="category_id">Category ID:</label>
            <input type="number" id="category_id" name="category_id" required><br>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" ><br><br>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>

</html>
