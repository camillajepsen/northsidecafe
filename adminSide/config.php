// Define database connection constants
define('DB_HOST', 'cafe.czm0q4sccu05.ap-southeast-2.rds.amazonaws.com');  
define('DB_USER', 'admin');  
define('DB_PASS', 'Northsidecafekent2024'); 
define('DB_NAME', 'cafe');  

// Create connection
$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($link->connect_error) {
    die('Connection failed: ' . $link->connect_error);
}

// Optional: Set the character set to utf8
$link->set_charset("utf8");
