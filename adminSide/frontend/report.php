<?php
session_start();
require_once "../config.php"; // Assuming you have this file to connect to the database

// Check if user is logged in and has the correct role
if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'staff'])) {
    // If the user is not logged in or not staff/admin, redirect to the login page or an error page
    header("Location: ../stafflogin/login.php"); // Change this to your login page or error page
    exit;
}

// Initialize variables
$total_sales = 0;
$total_transactions = 0;
$transactions = [];
$user = [];
$start_date = '';
$end_date = '';
$user_selected = 'ALL';

// Fetch staff members from the database
$sql = "SELECT user_id, username FROM user";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $staff_members[] = $row;
    }
}

// Handle filtering by date and staff
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['startdate'] ? $_POST['startdate'] : '';
    $end_date = $_POST['enddate'] ? $_POST['enddate'] : '';
    $staff_selected = $_POST['userselection'];

    // Build SQL query
    $sql = "SELECT t.transaction_date, o.product_name, t.total_amount 
            FROM transactions t
            INNER JOIN orders o ON t.order_id = o.order_id
            INNER JOIN user u ON t.user_id = s.user_id
            WHERE 1=1";

    if (!empty($start_date)) {
        $sql .= " AND t.transaction_date >= '$start_date'";
    }

    if (!empty($end_date)) {
        $sql .= " AND t.transaction_date <= '$end_date'";
    }

    if ($staff_selected !== 'ALL') {
        $sql .= " AND t.user_id = '$user_selected'";
    }

    $sql .= " ORDER BY t.transaction_date DESC";

    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $transactions[] = $row;
            $total_sales += $row['total_amount'];
            $total_transactions++;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Generate Reports</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>js/script.js</script>
</head>
<body class="grey-background">
    <!-- Navigation bar -->
    <header class="navbar">
        <div class="navhome">
            <a href="index.php"><img src="logos/coffee_logo.png" id="coffee-logo"></a>
            <a href="index.php"><h2>Northside Café</h2></a>
        </div>
        <div class="navlinks">
            <div class="adminlinks">
                <a href="settings.php"><img src="logos/settings.png"></a>
                <a href="report.php"><img src="logos/analytics.png"></a>
            </div>
            <div class="generallinks">
                <a href="transactions_admin.php"><img src="logos/print.png"></a>
                <a href="user.php"><img src="logos/user.png"></a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="report-header">
            <h1>GENERATE REPORTS</h1>
        </div>

        <div class="report-summary">
            <div class="date">
                <p id="todaydate"></p>
            </div>
            <p>TOTAL SALES<br><span>$<?php echo number_format($total_sales, 2); ?></span></p>
            <p>TOTAL TRANSACTIONS<br><span><?php echo $total_transactions; ?></span></p>
        </div>

        <form method="POST" action="report.php">
            <div class="report-filter">
                <div class="form-group">
                    <label for="userselection">STAFF Member</label>
                    <select id="userselection" name="staffselection">
                        <option value="ALL">ALL</option>
                        <?php foreach ($user as $user): ?>
                            <option value="<?php echo $user['user_id']; ?>" <?php if ($user_selected == $user['user_id']) echo 'selected'; ?>>
                                <?php echo $user['username']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="startdate">START DATE:</label>
                    <input type="date" id="startdate" name="startdate" value="<?php echo $start_date; ?>">
                </div>
                <div class="form-group">
                    <label for="enddate">END DATE:</label>
                    <input type="date" id="enddate" name="enddate" value="<?php echo $end_date; ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Filter</button>
                </div>
            </div>
        </form>

        <div class="report-container">
            <div class="report-graph"></div>

            <div class="report-content">
                <h1>SALES</h1>

                <div class="filter-info">
                    <h2>STAFF: <span id="staff-output"><?php echo $user_selected !== 'ALL' ? $user_selected : 'ALL STAFF'; ?></span></h2><hr>
                    <h2>PERIOD: <span id="startdate-output"><?php echo $start_date ? $start_date : 'START DATE'; ?></span> TO 
                        <span id="enddate-output"><?php echo $end_date ? $end_date : 'END DATE'; ?></span></h2>
                </div>

                <div class="report-transactions">
                    <table>
                        <tr>
                            <th>DATE</th>
                            <th>ITEM</th>
                            <th>COST</th>
                        </tr>
                        <?php if (count($transactions) > 0): ?>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr>
                                    <td><?php echo $transaction['transaction_date']; ?></td>
                                    <td><?php echo $transaction['product_name']; ?></td>
                                    <td>$<?php echo number_format($transaction['total_amount'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No transactions found for the selected period.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Display today's date
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();
            const formattedDate = today.toLocaleDateString('en-GB', {
                day: 'numeric', month: 'long', year: 'numeric'
            });
            document.getElementById('todaydate').textContent = `${formattedDate}`;
        });
    </script>
</body>
</html>
