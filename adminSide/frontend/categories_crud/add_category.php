<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
</head>
<body>
    <h1>Add New Category</h1>
    <form method="post" enctype="multipart/form-data" action="insert_category.php">
        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name" required><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" required><br>
        <input type="submit" value="Add Category">
    </form>
</body>
</html>
