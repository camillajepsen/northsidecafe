<!DOCTYPE html>
<html lang="en">

<head>
    <title>Index</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="gradient-background">
    <div class="container">

        <!-- Navigation bar -->
        <header class="navbar">
            <div class="navhome">
            <a href="index.html"><img src="logos/coffee_logo.png" id="coffee-logo"></a>
                <a href="index.php">
                    <h2>Northside Café</h2>
                </a>
            </div>
            <div class="navlinks">
                <div class="adminlinks">
                    <a href="settings.html"><img src="logos/settings.png"></a>
                    <a href="report.html"><img src="logos/analytics.png"></a>
                </div>
                <div class="generallinks">
                    <a href="transactions.html"><img src="logos/print.png"></a>
                    <a href="user.html"><img src="logos/user.png"></a>
                </div>
            </div>
        </header>

        <?php
        include "../config.php";

        $sql = "SELECT * FROM categories";
        $result = $link->query($sql);
        ?>

        <div class="main">
            <div class="menu-box">
                <div class="title-bar">
                    <h1>CATEGORIES</h1>
                </div>
                <div class="menu-box-grid">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $menu_url = 'menu.php?category_id=' . $row["category_id"];

                            echo '<a href="' . $menu_url . '">';
                            echo '<div class="menu-box-item">';
                            echo '<img src="../display_image.php?id=' . $row["category_id"] . '" title="' . $row["category_name"] . '">';
                            echo '<h3>' . $row["category_name"] . '</h3>';
                            echo '</div>';
                            echo '</a>';
                        }
                    } else {
                        echo '<p>No categories found.</p>';
                    }

                    $link->close();
                    ?>
                </div>
            </div>

            <!-- Order summary -->
            <div class="order-box">
                <div class="order-box-inner">
                    <div class="order-number"></div>
                    <hr>
                    <div class="order-info"></div>
                    <hr>
                    <div class="payment-method">
                        <h2>Payment method</h2>
                        <img src="logos/cash_icon.png">
                        <img src="logos/card_icon.png">
                    </div>
                </div>
                <div class="order-button">
                    <div class="order-button-logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>