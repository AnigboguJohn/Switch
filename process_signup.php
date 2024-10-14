<?php
if (empty($_POST["firstname"])) {
    die("FirstName is required");
}

if (empty($_POST["lastname"])) {
    die("LastName is required");
}

if (! filter_var ($_POST["email"], FILTER_VALDATE_EMAIL)) {
    die("valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("password must be at least 8 characters");
}

if ( ! preg_match ("/[a-z]/i", $_POST["password"])) {
    die("password must contain at least one letter");
}
if ( ! preg_match ("/[0-9]/i", $_POST["password"])) {
    die("password must contain at least one number");
}
print_r($_POST);

?>