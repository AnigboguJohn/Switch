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

    // Ensure the member has enough debt to pay back
    $sql = "SELECT total_debt FROM members WHERE user_id = $user_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row['total_debt'] >= $amount) {
        // Update debt
        $sql = "UPDATE members SET total_debt = total_debt - $amount WHERE user_id = $user_id";
        if ($conn->query($sql) === TRUE) {
            // Log the transaction
            $sql = "INSERT INTO transactions (member_id, transaction_type, amount) VALUES ($user_id, 'payback', $amount)";
            if ($conn->query($sql) === TRUE) {
                echo "Payback successful!";
            } else {
                echo "Error logging transaction: " . $conn->error;
            }
        } else {
            echo "Error updating debt: " . $conn->error;
        }
    } else {
        echo "Amount exceeds current debt.";
    }
}

$conn->close();
?>
