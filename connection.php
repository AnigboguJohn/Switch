<?php

$host = "localhost";
$dbname = "switch_investments";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli ->connect_error) {
    die("connection error: " .  $mysqli->connect_error);
}

return $mysqli;
?>