<?php

// Move Logins to env
// echo $_SERVER['HTTP_MY_VARIABLE'];

// Data Source Name : AZURE
$servername = getenv("SERVER");
$username = getenv("USERNAME");
$password = getenv("PASSWORD");

$conn = new mysqli($servername, $username, $password);

if ($conn -> connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// echo "Connection Successful";

?>