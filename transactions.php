<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "switch_investments");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assume session is active, and member ID is available
$member_id = 1;

// Function to handle deposit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deposit'])) {
        $amount = $_POST['amount'];
        $sql = "UPDATE members SET balance = balance + $amount, total_deposit = total_deposit + $amount WHERE id = $member_id";
        if ($conn->query($sql) === TRUE) {
            echo "Deposit successful!";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    // Similar logic for withdrawal, borrow, transfer, etc.
}
$conn->close();
?>
