<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Items</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <script src="../js/script.js"></script>
    <div class="container">

        <!-- Navigation bar -->
        <header class="navbar">
            <div class="navhome">
                <a href="index.html"><img src="../logos/coffee_logo.png" id="coffee-logo"></a>
                <a href="index.php"><h2>Northside Café</h2></a>
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
                <img src="../logos/items.png">
                <h1>MANAGE ITEMS</h1>
                <a href="add_items.php"><button type="button" class="action-button">ADD ITEM</button></a>
            </div>
            <div>
            </div>
            <hr>

            <!-- Table displaying items from product table -->
            <div class="manage-table">
                <table id="item-table">
                    <tr>
                        <th>PRODUCT ID</th>
                        <th>NAME</th>
                        <th>DESCRIPTION</th>
                        <th>PRICE</th>
                        <th>CATEGORY ID</th>
                        <th>ACTIONS</th>
                    </tr>
                    
                    <?php
                    include "../../config.php";
                    
                    // Fetch items from product table
                    $sql = "SELECT product_id, product_name, Description, Price, category_id FROM products";
                    $result = $link->query($sql);

                    // Check if there are results and display
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["product_id"] . "</td>";
                            echo "<td>" . $row["product_name"] . "</td>";
                            echo "<td>" . $row["Description"] . "</td>";
                            echo "<td>$" . number_format($row["Price"], 2) . "</td>";
                            echo "<td>" . $row["category_id"] . "</td>";
                            echo '<td>
                                    <a href="products_crud/edit_items.php?id=' . $row["product_id"] . '">EDIT</a> 
                                    <a href="products_crud/delete_item.php?id=' . $row["product_id"] . '">DELETE</a>
                                  </td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No items found</td></tr>";
                    }

                    // Close connection
                    $link->close();
                    ?>

                </table>
            </div>
        </div>
    </div>
</body>

</html>
