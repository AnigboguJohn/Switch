<?php
session_start();
$conn = new mysqli("localhost", "root", "", "switch_investments");

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $user_id = $_SESSION['user_id'];

    // Ensure the member has enough balance for withdrawal
    $sql = "SELECT balance FROM members WHERE user_id = $user_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row['balance'] >= $amount) {
        // Update balance and total withdrawal
        $sql = "UPDATE members SET balance = balance - $amount, total_withdrawal = total_withdrawal + $amount WHERE user_id = $user_id";
        if ($conn->query($sql) === TRUE) {
            // Log the transaction
            $sql = "INSERT INTO transactions (member_id, transaction_type, amount) VALUES ($user_id, 'withdrawal', $amount)";
            if ($conn->query($sql) === TRUE) {
                echo "Withdrawal successful!";
            } else {
                echo "Error logging transaction: " . $conn->error;
            }
        } else {
            echo "Error updating balance: " . $conn->error;
        }
    } else {
        echo "Insufficient balance.";
    }
}

$conn->close();
?>
