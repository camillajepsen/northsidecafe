<?php
require_once "../config.php";

$sql = "SELECT transaction_date, total_amount, staff_id, order_id FROM transactions";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['transaction_date'] . "</td>
                <td>Order #" . $row['order_id'] . "</td>
                <td>$" . $row['total_amount'] . "</td>
                <td>Staff ID: " . $row['staff_id'] . "</td>
                <td><a href='print_receipt.php?order_id=" . $row['order_id'] . "'>Print</a></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No transactions found</td></tr>";
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		
		<title>Transactions (Admin)</title>
		<link rel="stylesheet" href="css/styles.css">

	</head>

	<body class="manage-body">
        <script src="js/script.js"></script>
        <div class="container">

            <!--Navigation bar-->
            <header class="navbar">
                <div class="navhome">
                    <a href="index.html"><img src="logos/coffee_logo.png" id="coffee-logo"></a>
                    <a href="index.html"><h2>Northside Café</h2></a>
                </div>
                <div class="navlinks">
                    <div class="adminlinks">
                        <a href="settings.html"><img src="logos/settings.png"></a>
                        <a href="report.html"><img src="logos/analytics.png"></a>
                    </div>
                    <div class="generallinks">
                        <a href="transactions_admin.html"><img src="logos/print.png"></a>
                        <a href="user.html"><img src="logos/user.png"></a>
                    </div>
                </div>
            </header>

            <div class="main-manage">

                <div class="manage-header">
                    <h1>SALES TRANSACTIONS</h1>
                    
                </div>
                <hr>
                <div class="manage-table">
                    <table id="transaction-table">
                        <tr>
                            <th>DATE</th>
                            <th>ORDER</th>
                            <th>PRICE</th>
                            <th>STAFF</th>
                            <th>PRINT RECEIPT</th>
                            <th></th>
                        </tr>


                        
                    </table>
                </div>
            
            </div>
        </div>
        <!-- Script path -->
        <script src="js/transactions.js"></script>
        <script>
            generateTransReports();
        </script>
    </body>
</html>
