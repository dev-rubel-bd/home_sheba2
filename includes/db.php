<?php
$host = "localhost"; // Database host
$user = "root";      // Database username
$pass = "mysql";          // Database password
$dbname = "home_sheba"; // Database name

// Create a connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
