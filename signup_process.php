<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "switch_investments";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User input (from form)
$firstname = $_POST['firstname'] ?? ''; // Use null coalescing to avoid undefined index error
$lastname = $_POST['lastname'] ?? '';
$email = $_POST['email'] ?? '';
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

// Debug: Check the incoming POST data
var_dump($_POST);

// Insert user data into 'users' table
$sql = "INSERT INTO users (firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Signup successful!"; // Debug message for successful insert
} else {
    echo "Error: " . $sql . "<br>" . $conn->error; // Display error if insertion fails
}

$conn->close();
?>
