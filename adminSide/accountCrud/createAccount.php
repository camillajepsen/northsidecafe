<?php 
include '../inc/dashHeader.php'; 

// Include config file
require_once "../config.php";

// Define encryption key for email encryption
$encryption_key = getenv('ENCRYPTION_KEY'); // Key stored in php.ini

// Encryption function for email
function encrypt_email($email, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($email, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

$input_user_id = $user_iderr = $user_id = "";
$input_email = $email_err = $email = "";
$input_Contact_number = $Contact_number_err = $Contact_number = "";
$input_password = $password_err = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate user_id
    if(empty(trim($_POST["user_id"]))) {
        $user_id_err = "Please enter a valid user ID.";
    } else {
        $user_id = trim($_POST["user_id"]);
    }
    
    // Validate email
    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
        // Encrypt the email before storing it
        $encrypted_email = encrypt_email($email, $encryption_key);
    }
    
    // Validate contact number
    if(empty(trim($_POST["Contact_number"]))) {
        $Contact_number_err = "Please enter a phone number.";
    } else {
        $Contact_number = trim($_POST["Contact_number"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        // Hash the password before storing it
        $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
    }
    
    // Check for errors before inserting into the database
    if(empty($user_id_err) && empty($email_err) && empty($Contact_number_err) && empty($password_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO users (user_id, email, Contact_number, password) VALUES (?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isss", $param_user_id, $param_email, $param_Contact_number, $param_password);
            
            // Set parameters
            $param_user_id = $user_id;
            $param_email = $encrypted_email;
            $param_Contact_number = $Contact_number;
            $param_password = $password;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                // Redirect to success page
                header("location: success_create_staff_memberships.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}

// Close connection
mysqli_close($link);
?>

<head>
    <meta charset="UTF-8">
    <title>Create New memberships</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper { width: 1300px; padding-left: 200px; padding-top: 80px; }
    </style>
</head>

<div class="wrapper">
    <h1>CAFE Northside cafe</h1>
    <h3>Create New users</h3>
    <p>Please fill in users Information Properly</p>

    <form method="POST" action="" class="ht-600 w-50">
        
        <div class="form-group">
            <label for="user_id" class="form-label">Users ID:</label>
            <input min=1 type="number" name="user_id" placeholder="99" class="form-control <?php echo !empty($user_id_err) ? 'is-invalid' : ''; ?>" id="user_id" required value="<?php echo $user_id; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                <?php echo $user_id_err; ?>
            </div>
        </div>
        
        <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="text" name="email" placeholder="Northsidecafe.com" class="form-control <?php echo !empty($email_err) ? 'is-invalid' : ''; ?>" id="email" required value="<?php echo $email; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                <?php echo $email_err; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="Contact number" class="form-label">Phone Number:</label>
            <input type="text" name="Contact_number" placeholder="+60101231234" class="form-control <?php echo !empty($Contact_number_err) ? 'is-invalid' : ''; ?>" id="Contact_number" required value="<?php echo $Contact_number; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                <?php echo $Contact_number_err; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="johnny1234@" id="password" required class="form-control <?php echo !empty($password_err) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                <?php echo $password_err; ?>
            </div>
        </div>
        
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-dark" value="Create memberships">
        </div>
    </form>
</div>

<?php include '../inc/dashFooter.php'; ?>
