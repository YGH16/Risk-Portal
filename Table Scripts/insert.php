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

$firstname = "baker";
$lastname = "ross";
$username = "test2";
$password = "hello1234!";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`) VALUES (NULL, '$firstname', '$lastname', '$username', '$hashed_password')";
if($conn->query($sql) === TRUE){
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close()
?>