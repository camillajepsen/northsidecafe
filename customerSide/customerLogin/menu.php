<?php
session_start();
require_once "../config.php";

// Initialize cart in session if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Fetch items from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($link, $sql);

// Create an array to hold menu items by category
$menu_items = array();

// Process the results
while ($row = mysqli_fetch_assoc($result)) {
    $category_id = $row['category_id'];
    $product_id = $row['product_id'];
    $product_name = $row['product_name'];
    $price = $row['Price'];
    
    // Initialize category if not already done
    if (!isset($menu_items[$category_id])) {
        $menu_items[$category_id] = array();
    }
    
    // Add the product to the appropriate category
    $menu_items[$category_id][] = array('id' => $product_id, 'name' => $product_name, 'price' => $price);
}

// Define categories (this could be dynamically fetched too)
$categories = array(
    1 => 'Coffee',
    2 => 'Iced Drinks',
    3 => 'Teas',
    4 => 'Soft Drinks'
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        /* General styling for the Menu Section */
        #menu {
            background-color: #f8f8f8; /* Light background */
            padding: 60px 20px; /* Add padding for spacing */
            text-align: center;
        }

        #menu h1 {
            font-size: 36px; /* Increase the font size for the main title */
            color: #333; /* Darker color for the title */
            font-family: 'Copperplate', sans-serif; /* Apply the same font family */
            margin-bottom: 40px; /* Add some space below the title */
        }

        .menu-category {
            margin-bottom: 50px; /* Add space between the categories */
        }

        .menu-category h2 {
            font-size: 28px; /* Larger font size for the category name */
            color: #b5651d; /* A soft brown color that fits the cafe theme */
            margin-bottom: 20px; /* Space below the category heading */
            font-family: 'Montserrat', sans-serif; /* Stylish font */
        }

        .menu-category ul {
            list-style-type: none; /* Remove bullet points */
            padding: 0;
            margin: 0;
        }

        .menu-category li {
            font-size: 20px; /* Font size for menu items */
            color: #555; /* Darker text color for visibility */
            padding: 10px 0; /* Space between items */
            border-bottom: 1px solid #ddd; /* Line between items */
        }

        .menu-category li:last-child {
            border-bottom: none; /* Remove the bottom border for the last item */
        }

        .menu-category li:hover {
            color: #b5651d; /* Change the color on hover to the brown theme */
            cursor: pointer; /* Add pointer cursor on hover */
            background-color: #f0e4d7; /* Soft background color on hover */
            transition: background-color 0.3s ease, color 0.3s ease; /* Smooth hover effect */
        }

        /* Grid layout for Menu Categories */
        .menu-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive grid */
            gap: 20px; /* Space between grid items */
            max-width: 1200px; /* Maximum width for the section */
            margin: 0 auto; /* Center the section */
        }

        .menu-category {
            padding: 20px;
            background-color: #fff; /* White background for each category */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            border-radius: 8px; /* Slightly rounded corners */
        }

        .menu-category h2 {
            border-bottom: 2px solid #b5651d; /* Brown line under the category name */
            padding-bottom: 10px; /* Space below the category name */
        }

        .menu-category ul {
            padding-left: 0; /* Remove default padding */
        }

        /* Styling for the container of the entire section */
        .menu-section {
            margin: 50px auto;
            max-width: 1000px;
        }

        /* Styling the list items within the category */
        .menu-category ul li {
            padding: 10px;
            border-bottom: 1px solid #ddd; /* Add a border between items */
        }

        /* On hover, change the background and text color */
        .menu-category ul li:hover {
            background-color: #f7e7d3;
            color: #b5651d;
            cursor: pointer;
        }

        /* Styling for price display */
        .price {
            font-size: 1.5em; /* Increase font size */
            font-weight: bold; /* Make font bold */
            color: #b5651d; /* Use a contrasting color, like a brown shade */
            padding: 10px; /* Add some padding for spacing */
            background-color: #f0e4d7; /* Light background color for better contrast */
            border-radius: 5px; /* Rounded corners for the background */
            margin-top: 10px; /* Space above the price */
            display: inline-block; /* Ensure it fits its content */
        }

        .add-to-cart {
            display: inline-block;
            background-color: #b5651d; /* Button background color */
            color: #fff; /* Button text color */
            padding: 10px 20px; /* Button padding */
            border: none; /* Remove default border */
            border-radius: 5px; /* Rounded corners for the button */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Font size for the button */
            margin-top: 10px; /* Space above the button */
            text-decoration: none; /* Remove underline */
        }

        .add-to-cart:hover {
            background-color: #a04d0b; /* Darker color on hover */
        }
    </style>
    <script>
        function showPrice(priceId) {
            // Hide all prices first
            var prices = document.getElementsByClassName('price');
            for (var i = 0; i < prices.length; i++) {
                prices[i].style.display = 'none';
            }

            // Show the selected price
            var priceElement = document.getElementById(priceId);
            if (priceElement) {
                priceElement.style.display = 'block';
            }
        }
    </script>
</head>
<body>
    <section id="menu">
        <h1>Northside Cafe Menu</h1>
        <div class="menu-section">
            <?php foreach ($categories as $category_id => $category_name): ?>
                <div class="menu-category">
                    <h2><?php echo htmlspecialchars($category_name); ?></h2>
                    <ul>
                        <?php if (isset($menu_items[$category_id])): ?>
                            <?php foreach ($menu_items[$category_id] as $item): ?>
                                <li onclick="showPrice('<?php echo htmlspecialchars($item['id']); ?>')">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                    <form method="post" action="add_to_cart.php" style="display:inline;">
                                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                        <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                                    </form>
                                </li>
                                <div id="<?php echo htmlspecialchars($item['id']); ?>" class="price" style="display: none;">
                                    Price: $<?php echo htmlspecialchars(number_format($item['price'], 2)); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No items available</li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</body>
</html>
