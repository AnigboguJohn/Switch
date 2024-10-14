<?php
session_start();
$conn = new mysqli("localhost", "root", "", "switch_investments");

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");  // Redirect to login if user is not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user and member data
$sql = "SELECT members.*, users.username FROM members 
        JOIN users ON users.user_id = members.user_id 
        WHERE users.user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullname = $row['full_name'];
    $account_name = $row['account_name'];
    $balance = $row['balance'];
    $total_deposit = $row['total_deposit'];
    $total_withdrawal = $row['total_withdrawal'];
    $total_debt = $row['total_debt'];
    $location = $row['location'];
    $phone = $row['phone'];
} else {
    echo "No member found.";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SWITCH Investments - Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>SWITCH INVESTMENTS</h1>
            <div class="user-info">
                <h2>Welcome, <?php echo $fullname; ?></h2>
                <div class="balance-info">
                    <h3>Current Balance: ₦<?php echo $balance; ?></h3>
                    <p>Total Deposit: ₦<?php echo $total_deposit; ?></p>
                    <p>Total Withdrawal: ₦<?php echo $total_withdrawal; ?></p>
                    <p>Total Debt: ₦<?php echo $total_debt; ?></p>
                </div>
            </div>
        </header>
        <!-- Rest of the dashboard HTML here -->
    </div>
</body>
</html>
