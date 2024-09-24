<?php

// Include functions.php to use custom functions
include '../functions.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Categories</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="manage-body">
    <script src="js/script.js"></script>
    <div class="container">
        <!-- Navigation bar -->
        <header class="navbar">
            <div class="navhome">
                <a href="index.html"><img src="../logos/coffee_logo.png" id="coffee-logo"></a>
                <a href="index.html"><h2>Northside Café</h2></a>
            </div>
            <div class="navlinks">
                <div class="adminlinks">
                    <a href="settings.html"><img src="../logos/settings.png"></a>
                    <a href="report.html"><img src="../logos/analytics.png"></a>
                </div>
                <div class="generallinks">
                    <a href="transactions_admin.html"><img src="../logos/print.png"></a>
                    <a href="user.html"><img src="../logos/user.png"></a>
                </div>
            </div>
        </header>

        <div class="main-manage">
            <div class="manage-header">
                <img src="../logos/categories.png">
                <h1>MANAGE CATEGORIES</h1>
                <a href="add_category.php"><button class="action-button">ADD CATEGORY</button></a>
            </div>
            <hr>
            <div class="manage-table">
                <table id="category-table">
                    <tr>
                        <th>NAME</th>
                        <th>DESCRIPTION</th>
                        <th>IMAGE</th>
                        <th>ACTIONS</th>
                    </tr>

                    <?php
                    include '../config.php'; 

                    // Fetch categories from the database
                    $sql = "SELECT * FROM categories";
                    $result = $link->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='menu-item'>";
                            echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                            echo "<td>" . '<img src="../display_image.php?id=' . $row["category_id"] . '" title="' . $row["category_name"] . '" style="width: 100px; height: 100px;">' . "</td>";
                            echo "<td>";
                            echo "<a href='categories_crud/edit_category.php?id=" . $row['category_id'] . "' class='action-button'>Edit</a> | ";
                            echo "<a href='categories_crud/delete_category.php?id=" . $row['category_id'] . "' class='action-button' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No categories found</td></tr>";
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>
</body>

</html>
