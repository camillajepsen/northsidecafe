<?php
// Define database connection constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'Cafe');

// Create connection
$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($link->connect_error) { // If connection fails
    die('Connection failed: ' . $link->connect_error); // Kill the script and display an error message
}

// Optional: Set the character set to utf8 (common practice)
$link->set_charset("utf8");

