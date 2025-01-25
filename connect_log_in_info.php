<?php
// Database configuration
$servername = "localhost"; // Change if your server is not localhost
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "g6myob"; // Ensure this is the correct database name

// Create connection
$conn_log = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn_log->connect_error) {
    die("Connection failed: " . $conn_log->connect_error);
}
?>