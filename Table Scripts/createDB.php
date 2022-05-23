<?php
$servername = "localhost";
$username = "risk_test";
$password = "[D6tzxRidIY0LDGI";
$dbname = "risk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// $sql = "CREATE DATABASE risk";
// if($conn->query($sql) === TRUE) {
//     echo "Database Created Successfully";
// } else {
//     echo "Error creating database: " . $conn->error;
// }

// $query = "CREATE TABLE users (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     firstname VARCHAR(30) NOT NULL,
//     lastname VARCHAR(30) NOT NULL,
//     username VARCHAR(30) NOT NULL,
//     password VARCHAR(200) NOT NULL
// );";

// if($conn->query($query) === TRUE) {
//     echo "Table Users successfully created";
// } else {
//     echo "Error creating table: " . $conn->error;
// }


$conn->close()
?>