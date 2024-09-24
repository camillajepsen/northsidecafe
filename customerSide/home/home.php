<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'Cafe');

// Create Connection
$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check Connection
if ($link->connect_error) {
    die('Connection Failed: ' . $link->connect_error); // terminate execution
}

// SQL Query to get items for 'Tea' category
$sqlTea = "
    SELECT p.product_name, p.description, p.price
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_name = 'tea'
    ORDER BY p.product_name;
";
$resultTea = mysqli_query($link, $sqlTea);
$teaItems = mysqli_fetch_all($resultTea, MYSQLI_ASSOC);

// SQL Query to get items for 'Coffee' category
$sqlCoffee = "
    SELECT p.product_name, p.description, p.price
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_name = 'coffee'
    ORDER BY p.product_name;
";
$resultCoffee = mysqli_query($link, $sqlCoffee);
$coffeeItems = mysqli_fetch_all($resultCoffee, MYSQLI_ASSOC);

// SQL Query to get items for 'Soft Drinks' category
$sqlSoftDrinks = "
    SELECT p.product_name, p.description, p.price
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_name = 'soft drinks'
    ORDER BY p.product_name;
";
$resultSoftDrinks = mysqli_query($link, $sqlSoftDrinks);
$softDrinksItems = mysqli_fetch_all($resultSoftDrinks, MYSQLI_ASSOC);

// SQL Query to get items for 'Ice Drink' category
$sqlIceDrinks = "
    SELECT p.product_name, p.description, p.price
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE c.category_name = 'ice drink'
    ORDER BY p.product_name;
";
$resultIceDrinks = mysqli_query($link, $sqlIceDrinks);
$iceDrinksItems = mysqli_fetch_all($resultIceDrinks, MYSQLI_ASSOC);

// Check if the user is logged in
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    echo '<div class="user-profile">';
    echo 'Welcome, ' . $_SESSION["member_name"] . '!';
    echo '<a href="../customerProfile/profile.php">Profile</a>';
    echo '</div>';
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  

  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script><!-- importing javascript library for the function to work -->
<!-- Chatbot stylesheet and script -->
<link rel="stylesheet" href="https://www.gstatic.com/dialogflow-console/fast/df-messenger/prod/v1/themes/df-messenger-default.css">
    <script src="https://www.gstatic.com/dialogflow-console/fast/df-messenger/prod/v1/df-messenger.js"></script>
   

  <title>Northside  CAFE</title>
</head>

<body>
 <!-- Header -->
 
<section id="header">
  <div class="header container">
    <div class="nav-bar">
      <div class="brand">
          <a class="nav-link" href="../home/home.php#hero">
          </a>
          <!-- Logo Header -->
          <style>
        header img {
    display: block;  /* Ensures the image is treated as a block element */
    margin: 0 auto;  /* Centers the image horizontally */
    padding: 20px;
    background-color: #faf0e6; /* A light background color for better contrast */
    width: 100px;  /* Increased size for better visibility */
    height: 100px; /* Same width and height to keep it circular */
    border-radius: 50%; /* Ensures the image is round */
    object-fit: cover; /* Scales the image inside the circular container */
    border: 5px solid #8b4513; /* A darker, visible border for better contrast */
}

/* Optional styling for the header */
/*header {
    text-align: center;
    padding: 20px;
    background-color: #e3dac9; /* Soft background to complement the logo */



        

        
        </style>
    <header>
        <img src="../image/logo.png" alt="Logo">
    </header>

      </div>
      <div class="nav-list">
        <div class="hamburger">
          <div class="bar"></div>
        </div>
          <div class="navbar-container">
            
              <div class="navbar">
        <ul>
          <li><a href="#hero" data-after="Home">Home</a></li>
          
          <li><a href="#menu" data-after="menu">Menu</a></li>
          <li><a href="#about" data-after="About">About</a></li>
          <li><a href="#contact" data-after="Contact">Contact</a></li>
          <li class="dropdown">
  <a href="#" class="dropbtn">Users</a>
  <div class="dropdown-content">
    <a href="../../adminSide/StaffLogin/login.php">Staff</a>
    <a href="../../adminSide/AdminLogin/login.php">Admin</a>
    <a href="../../adminSide/CashierLogin/login.php">Cashier/Waiter</a>
    <a href="../customerLogin/login.php">Customer</a>
  </div>
</li>

          
      </div>
    </div>
  </div>
          
   

       
  <?php

// Get the user_id from the query parameters
$user_id = $_SESSION['user_id'] ?? null; // Change this to the way you obtain the member ID

// Check if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $user_id != null) {
    $query = "SELECT username FROM users WHERE user_id = $user_id";

    // Execute the query
    $result = mysqli_query($link, $query);
    
    // Check if the query was successful
    if ($result) {
        // Fetch the user's information
        $row = mysqli_fetch_assoc($result);
        
        if ($row) {
            $username = $row['username'];
            
            // Output the user's information
            echo "<p class='logout-link' style='font-size:1.3em; margin-left:15px; padding:5px; color:white;'>$username</p>";
        } else {
            echo "User not found.";
        }
    } else {
        echo "Error: " . mysqli_error($link);
    }

    echo '<a class="logout-link" style="color: white; font-size:1.3em;" href="../customerLogin/logout.php">Logout</a>';
}


// Close the database connection
mysqli_close($link);
?>

     
    </div>
  </div> 
        </ul>
          </div>
          </div>
      </div>
    </div>
  </div>
</section>
<!-- End Header -->





<!-- Hero Section with Video Background and Text Overlay -->
<section id="hero" style="position: relative;">
    <video autoplay loop muted playsinline poster="your-poster-image.jpg" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
        <source src="../image/coffeepour.mp4" type="video/mp4">
        
    </video>
    <div class="hero container" style="position: relative; z-index: 1;">
        <div>
            <h1><strong><h1 class="text-center" style="font-family:Copperplate; color:brown;"> Northside </h1><span></span></strong></h1>
            <h1><strong style="color:brown;">CAFE<span></span></strong></h1>
            <ul><li><a type="button" class="cta" href="../customerLogin/login.php"> Login to Order</a>
</li>
          <li> <a type="button" class ="cta" href="../customerLogin/register.php">New user? Click here to Sign up</a></p>
          </li> </ul>
            <script>
function myFunction() {
  var r = confirm("Please login first!");
  if (r == true) {
    // Forward to login page
    window.location.href = "../customerLogin/login.php";
  } else {
    // Stay on the current page
    // No action needed
  }
}
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
        </div>
    </div>
</section>
<!-- End Hero Section -->
  
  
<section id="menu">
  <div class="menu-section">
    <div class="menu-category" style="display: flex; justify-content: space-around;">
      <div class="category" style="flex-basis: 20%;">
        <h2>Coffee</h2>
        <ul>
          <li onclick="showPrice('latte-price')">Latte</li>
          <li onclick="showPrice('americano-price')">Americano</li>


          <li onclick="showPrice('espresso-price')">Espresso</li>
          <li onclick="showPrice('cappuccino-price')">Cappuccino</li>
        </ul>
        <div id="latte-price" class="price" style="display: none;">Price: $5.50</div>
        <div id="americano-price" class="price" style="display: none;">Price: $4.75</div>

        <div id="espresso-price" class="price" style="display: none;">Price: $3.50</div>
        <div id="cappuccino-price" class="price" style="display: none;">Price: $5.25</div>
      </div>

      <div class="category" style="flex-basis: 20%;">
        <h2>Iced Drinks</h2>
        <ul>
          <li onclick="showPrice('iced-latte-price')">Iced Latte</li>
          <li onclick="showPrice('iced-tea-price')">Iced Tea</li>
          <li onclick="showPrice('iced-matcha-price')">Iced Matcha</li>
          <li onclick="showPrice('hot-chocolate-price')">Hot Chocolate</li>
        </ul>
        <div id="iced-latte-price" class="price" style="display: none;">Price: $5.75</div>
        <div id="iced-tea-price" class="price" style="display: none;">Price: $4.00</div>
        <div id="cold-matcha-price" class="price" style="display: none;">Price: $5.50</div>
        <div id="hot-chocolate-price" class="price" style="display: none;">Price: $4.75</div>
      </div>

      <div class="category" style="flex-basis: 20%;">
        <h2>Teas</h2>
        <ul>
          <li onclick="showPrice('herbal-tea-price')">Herbal Tea</li>
          <li onclick="showPrice('black-tea-price')">Black Tea</li>

          <li onclick="showPrice('green-tea-price')">Green Tea</li>
          <li onclick="showPrice('milk-tea-price')">Milk Tea</li>
        </ul>
        <div id="herbal-tea-price" class="price" style="display: none;">Price: $5.00</div>
        <div id="black-tea-price" class="price" style="display: none;">Price: $4.50</div>

        <div id="green-tea-price" class="price" style="display: none;">Price: $4.75</div>
        <div id="milk-tea-price" class="price" style="display: none;">Price: $5.25</div>
      </div>

      <div class="category" style="flex-basis: 20%;">
        <h2>Soft Drinks</h2>
        <ul>
          <li onclick="showPrice('Juices-price')">Juiced</li>
          <li onclick="showPrice('Sodas-price')">Sodas</li>
          <li onclick="showPrice('Bottled-water-price')">Bottled water</li>
          <li onclick="showPrice('Kombucha-price')">Kombucha</li>
        </ul>
        <div id="Juices-price" class="price" style="display: none;">Price: $3.00</div>
        <div id="Sodas-price" class="price" style="display: none;">Price: $2.50</div>
        <div id="Bottled-water-price" class="price" style="display: none;">Price: $1.50</div>
        <div id="Kombucha-price" class="price" style="display: none;">Price: $4.00</div>
      </div>
    </div>
  </div>
</section>

  <!-- End menu Section -->


  
  <!-- About Section -->
<section id="about" >
  <div class="about container">
    <div class="col-right">
        <h1 class="section-title" >About <span>Us</span></h1>
        <h2>Northside  Company History:</h2>
 <p>Northside  was founded in 2009 by Fleur Studd and Jason Scheltus. It's hard to fathom now, but at that time, finding fresh, in-season, traceable, high quality coffee in Melbourne (or Australia) was practically impossible. We wanted to help address that and, in doing so, ignite positive change in the industry by redefining what coffee was and could be, and to build a market for, and appreciation of, high quality specialty coffee.</p>
 <p>We built our first shop and roastery in the wonderful, bustling Prahran Market. We fell in love with this location for many reasons, the most important being that it allows us to engage with a community of shoppers who are seeking out quality produce, and who care about seasonality and provenance. Over the last decade and a half we have slowly grown to six shops, each located in very special neighbourhoods in Melbourne - from Carlton to the Queen Victoria Market, South Melbourne to the 'Paris end' of Collins Street. In each of these locations, we have built meaningful, ongoing relationships with the area's unique community, and we've made hundreds of beautiful coffees for thousands of wonderful customers.</p>
 <p>We realised early on that we wanted to deliver Melbourne's best coffee experience and to do this, we needed to put all our energy into sourcing, roasting and sharing the very best coffee we could find. Our goal was to make these coffees accessible and exciting, easy to understand and appreciate, and simple to brew and enjoy.</p>
 <p>All our coffees are produced by dedicated farmers, many of who we have been lucky to work with, year after year. These producers' talent, hard work and unwavering commitment to quality - and to supporting their local communities - blows us away every time we visit them and reinforces all the reasons we do what we do. It makes us even more determined to celebrate and showcase their coffees, and to tell their stories. We know our job is done when a customer gets excited to see a specific coffee on our shelves, or asks us when it will be back on offer.</p>
 
 
    
      </div>
    </div>
  </section>
  <!-- End About Section -->

  
  
  
  
 <!-- Contact Section -->
<section id="contact">
  <div class="contact container">
    <div>
      <h1 class="section-title">Contact <span>info</span></h1>
    </div>
    <div class="contact-items">
      <div class="contact-item contact-item-bg">
        <div class="contact-info">
          <div class='icon'><img src="../image/icons8-phone-100.png" alt=""/></div>
          <h1>Phone</h1>
          <h2>+61 235 4789</h2>
        </div>
      </div>
      
      <div class="contact-item contact-item-bg"> 
        <div class="contact-info">
          <div class='icon'><img src="../image/icons8-email-100.png" alt=""/></div>
          <h1>Email</h1>
          <h2>Northsidecafe@gmail.com</h2> 
        </div>
      </div>
      
      <div class="contact-item contact-item-bg">
        <div class="contact-info">
          <div class='icon'> <img src="../image/icons8-home-address-100.png" alt=""/></div>
          <h1>Address</h1>
          <h2>Northside , Street Level, 201 Spencer St, Docklands VIC 3008</h2>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Contact Section -->


  

  
  
  
  
  <!-- Footer -->
  <section id="footer">
    <div class="footer container">
        <h2>Follow our Socials</h2>
      <div class="social-icon">
        <div class="social-item">
          <a href="https://www.facebook.com"><img src="https://img.icons8.com/color/48/facebook.png" alt="facebook"/></a>
        </div>
        <div class="social-item">
          <a href="https://www.instagram.com"><img src="https://img.icons8.com/color/48/instagram-new.png" alt="instagram-new"/></a>
        </div>
          <div class="social-item">
          <a href="https://www.pinterest.com"><img src="https://img.icons8.com/color/48/pinterest.png" alt="pinterest-new"/></a>
        </div>
          <div class="social-item">
          <a href="https://www.tiktok.com"><img src="https://img.icons8.com/color/48/tiktok.png" alt="tiktok-new"/></a>
        </div>
          <div class="social-item">
          <a href="https://www.youtube.com"><img src="https://img.icons8.com/color/48/youtube-play.png" alt="youtube-new"/></a>
        </div>
          
        
      </div>
      <p>© 2023 Northside </p>
      
      
    </div>
  </section>
  <!-- End Footer -->
  <script src="../js/app.js"></script>
   <style type="text/css">
       
       .navbar-container {
  width: 100%;
  padding: 0;
  margin: 0;
}

      .msg {
        font-family: 'Montserrat', sans-serif;
        margin-top: 25px;
        padding: 25px;
        display: none;
        color: black;
      }
      .yellow {
        background: #fff;
      }
      .green {
        background: #fff;
      }
      .red {
        background: #fff;
      }

      /* Styling the select button */
      

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

    
      
    .item-name {
  display: inline-block; /* Ensure items are displayed on separate lines */
  width: 100%; /* Adjust the width as needed */
  float: left;
}

.item-price {
  display: inline-block; /* Ensure prices are displayed on separate lines */
  width: 30%; /* Adjust the width as needed */
  float: right;
}

.user-profile {
    display: flex;
    align-items: center;
    color: white;
    margin-right: 20px;
}

.user-profile a {
    margin-left: 10px;
    color: white;
    text-decoration: none;
}

/* Style for the profile link */
.profile-link {
  border: 1px solid #fff; /* Smaller border style and color */
  padding: 3px 8px; /* Smaller padding inside the border */
  border-radius: 3px; /* Rounded corners for the border */
  text-decoration: none; /* Remove the default underline */
  color: #fff; /* Text color */
  margin-left: auto; /* Automatically push the link to the right */
  margin-right: 10px; /* Add a small right margin for spacing */
}


#contact .col-right h2 {
  font-size: 24px; /* Adjust the font size */
  color: white; /* Text color for the right column */
}

#contact .col-right p {
  font-size: 18px; /* Adjust the font size */
  color: white; /* Text color for the right column */
}

/* Style for the contact-item containers */
.contact-item-bg {
  background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black background */
  padding: 20px;
  border-radius: 5px;
  margin-bottom: 20px; /* Add margin between contact items */
}

.contact-item-bg h1,
.contact-item-bg h2 {
  color: white; /* Text color for the contact items */
}

.contact-item-bg i {
  color: #fff; /* Icon color */
}

.contact-item-bg .icon img {
  width: 80px; /* Adjust the width of the icon images */
  height: 80px; /* Adjust the height of the icon images */
}



.navbar {
  overflow: hidden;
  
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: right;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 17px;  
  border: none;
  outline: none;
  color: white;
  padding: 13.9px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
  margin-top: 6px;
}

 .dropdown:hover .dropbtn {
  color: blue;
  
}

.dropdown-content {
  display: none;
  position: absolute;
    background-color: rgba(0, 0, 0, 0.5);
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  color: black;
}

.dropdown-content a {
  float: none;
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}
/* Style for the dropdown content text */
.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

/* Hover effect for dropdown content text */
.dropdown-content a:hover {
  background-color: #ddd;
  color: black; /* Set the text color to black on hover if needed */
}

.dropdown:hover .dropdown-content {
  display: block;
}

 .tooltip {
    display: none;
    position: absolute;
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 5px;
    border-radius: 3px;
    font-size: 0.9em;
    margin-top: 50px; /* Add margin to move the tooltip below the element */
    left: 0; /* Set left to 0 to align with the element */
    width: 100%; /* Make the tooltip span the width of the element */
    text-align: center; /* Center the text within the tooltip */
  }

    </style>
    <!-- Java-Ol-->
    <script type="text/javascript">
    $(document).ready(function(){
        $("select").change(function(){
            $(this).find("option:selected").each(function(){
                var val = $(this).attr("value");
                if(val){
                    $(".msg").not("." + val).hide();
                    $("." + val).show();
                } else{
                    $(".msg").hide();
                }
            });
        }).change();
    });
    
    
    
    
    
    

  $(document).ready(function(){
    // Function to filter menu items based on search input
    function filterMenuItems(searchTerm) {
      $(".item-name").each(function() {
        var itemName = $(this).text().toLowerCase();
        if (itemName.includes(searchTerm)) {
          $(this).closest(".msg").show();
        } else {
          $(this).closest(".msg").hide();
        }
      });
    }
    
    // Search button click event
    $("#search-button").click(function() {
      var searchTerm = $("#search-input").val().toLowerCase();
      filterMenuItems(searchTerm);
    });
    
    // Search input keyup event
    $("#search-input").keyup(function() {
      var searchTerm = $(this).val().toLowerCase();
      filterMenuItems(searchTerm);
    });
  });

$(document).ready(function() {
    $('.dropdown-toggle').dropdown();
});

    </script>
<!-- jQuery Ol -->


<!-- CSS Ol Popper js -->

<script>
  $(document).ready(function () {
    $('.logout-link').hover(function () {
      var $tooltip = $(this).find('.tooltip');
      var elementHeight = $(this).height();
      $tooltip.css('top', elementHeight + 10 + 'px'); // Position the tooltip below the element
      $tooltip.css('display', 'block');
    }, function () {
      $(this).find('.tooltip').css('display', 'none');
    });
  });
</script>
    <!-- Add the Chatbot at the end of the body -->

<df-messenger
        project-id="northside-coffee-435302"
        agent-id="67b8533a-f517-4c00-bb98-d09f2c68976c"
        language-code="en"
        max-query-length="-1">
        <df-messenger-chat-bubble
            chat-title="NorthsideCoffeeAgent">
        </df-messenger-chat-bubble>
    </df-messenger>
    <style>
  df-messenger {
    z-index: 999;
    position: fixed;
    --df-messenger-font-color: #000;
    --df-messenger-font-family: Google Sans;
    --df-messenger-chat-background: #f3f6fc;
    --df-messenger-message-user-background: #d3e3fd;
    --df-messenger-message-bot-background: #fff;
    bottom: 16px;
    right: 16px;
  }
</style>
</body>

</html>

