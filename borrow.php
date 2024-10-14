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

    // Update the member's debt
    $sql = "UPDATE members SET total_debt = total_debt + $amount WHERE user_id = $user_id";
    if ($conn->query($sql) === TRUE) {
        // Log the transaction
        $sql = "INSERT INTO transactions (member_id, transaction_type, amount) VALUES ($user_id, 'borrow', $amount)";
        if ($conn->query($sql) === TRUE) {
            echo "Borrow successful!";
        } else {
            echo "Error logging transaction: " . $conn->error;
        }
    } else {
        echo "Error updating debt: " . $conn->error;
    }
}

$conn->close();
?>
