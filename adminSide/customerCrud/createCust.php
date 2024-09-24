<?php
session_start(); // Ensure session is started
?>
<?php include '../inc/dashHeader.php'; ?>
<?php
// Include config file
require_once "../config.php";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafedb";

// Create a connection
$link = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Define variables and initialize them
$user_id = $username = $points = $memberships_id = "";
$user_id_err = $username_err = $points_err = "";
$input_memberships_id = $memberships_iderr = $memberships_id = "";
$input_email = $email_err = $email = "";
$input_register_date = $register_date_err = $register_date = "";
$input_Contact_number = $Contact_number_err = $Contact_number = "";
$input_password = $password_err = $password = "";

// Function to get the next available memberships ID
function getNextAvailablemembershipsID($link) {
    $sql = "SELECT MAX(memberships_id) as max_memberships_id FROM membershipss";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $next_memberships_id = $row['max_memberships_id'] + 1;
    return $next_memberships_id;
}

// Function to get the next available Member ID
function getNextAvailableMemberID($link) {
    $sql = "SELECT MAX(user_id) as max_user_id FROM membershipships";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $next_user_id = $row['max_user_id'] + 1;
    return $next_user_id;
}

// Get the next available Member ID
$next_user_id = getNextAvailableMemberID($link);

// Get the next available memberships ID
$next_memberships_id = getNextAvailablemembershipsID($link);
?>
<head>
    <meta charset="UTF-8">
    <title>Create New membershipship</title>
    <style>
        .wrapper{ width: 1300px; padding-left: 200px; padding-top: 80px; }
        /* Style the select input */
        #memberships_id {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        /* Style the default option */
        #memberships_id option {
            color: #333;
        }

        /* Style the selected option */
        #memberships_id option:checked {
            background-color: #007bff;
            color: #fff;
        }

        /* Style the select when it's required and empty */
        #memberships_id:required:invalid {
            color: #999;
            border-color: #f00; /* Red border for validation */
        }

        /* Style the select when it's required and filled */
        #memberships_id:required:valid {
            border-color: #28a745; /* Green border for validation */
            color: #333;
        }
    </style>
</head>

<div class="wrapper">
    <h3>Create New membershipship</h3>
    <p>Please fill in membershipship Information</p>

    <form method="POST" action="success_createmembershipship.php" class="ht-600 w-50">
        
        <div class="form-group">
            <label for="user_id" class="form-label">Member ID:</label>
            <input min="1" type="number" name="user_id" placeholder="1" class="form-control <?php echo $user_id_err ? 'is-invalid' : ''; ?>" id="user_id" required value="<?php echo $next_user_id; ?>" readonly><br>
            <div class="invalid-feedback">
                Please provide a valid user_id.
            </div>
        </div>
        
        <div class="form-group">
            <label for="member_name" class="form-label">Member Name :</label>
            <input type="text" name="member_name" placeholder="Johnny Hatsoff" class="form-control <?php echo $username_err ? 'is-invalid' : ''; ?>" id="member_name" required value="<?php echo $username; ?>"><br>
            <div class="invalid-feedback">
                Please provide a valid member name.
            </div>
        </div>

        <div class="form-group">
            <label for="points">Points :</label>
            <input type="number" name="points" id="points" placeholder="1234" required class="form-control <?php echo $points_err ? 'is-invalid' : ''; ?>" value="<?php echo $points; ?>"><br>
            <div class="invalid-feedback">
                Please provide valid points.
            </div>
        </div>

        <div class="form-group">
            <label for="memberships_id" class="form-label">memberships ID:</label>
            <input min="1" type="number" name="memberships_id" placeholder="99" class="form-control <?php echo !$memberships_idErr ?: 'is-invalid'; ?>" id="memberships_id" required value="<?php echo $next_memberships_id; ?>" readonly><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                Please provide a valid memberships_id.
            </div>
        </div>
        
        <div class="form-group">
            <label for="email" class="form-label">Email :</label>
            <input type="text" name="email" placeholder="Northside  cafe@gmail.com" class="form-control <?php echo !$emailErr ?: 'is-invalid'; ?>" id="email" required value="<?php echo $email; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                Please provide a valid email.
            </div>
        </div>

        <div class="form-group">
            <label for="register_date">Register Date :</label>
            <input type="date" name="register_date" id="register_date" required class="form-control <?php echo !$register_date_err ?: 'is-invalid';?>" value="<?php echo $register_date; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                Please provide a valid register date.
            </div>
        </div>

        <div class="form-group">
            <label for="Contact number" class="form-label">Phone Number:</label>
            <input type="text" name="Contact number" placeholder="+61466152584" class="form-control <?php echo !$Contact_number_Err ?: 'is-invalid'; ?>" id="Contact number" required value="<?php echo $Contact_number; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                Please provide a valid phone number.
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password :</label>
            <input type="password" name="password" placeholder="johnny1234@" id="password" required class="form-control <?php echo !$password_err ?: 'is-invalid' ; ?>" value="<?php echo $password; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                Please provide a valid password.
            </div>
        </div>
        
        <div class="form-group mb-5">
            <input type="submit" name="submit" class="btn btn-dark" value="Create membershipship">
        </div>
    </form>
</div>

<?php include '../inc/dashFooter.php'; ?>
