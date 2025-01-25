<?php
// Include database connection
include 'connect.php'; // Adjust path to your database connection file

// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user info
$username = $_SESSION['username']; // Assume username is stored in the session
date_default_timezone_set('Asia/Kolkata'); // Set timezone
$timestamp = date('Y-m-d H:i:s'); // Current timestamp
$ip_address = $_SERVER['REMOTE_ADDR']; // Get user IP address
$macID = 'Unavailable'; // Replace with proper logic if MAC is critical

// Insert login info into the database
$sql = $conn->prepare("INSERT INTO login_info (user_name, ip, login_time, mac_id) VALUES (?, ?, ?, ?)");
$sql->bind_param("ssss", $username, $ip_address, $timestamp, $macID);

if ($sql->execute()) {
    // Redirect to button.php after successful insertion
    header("Location: button.php");
    exit();
} else {
    // Handle errors
    $_SESSION['error'] = "Failed to record login info. Please try again.";
    header("Location: login.php");
    exit();
}

// Close connection
$sql->close();
$conn->close();
?>
<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Close PHP tag before HTML content
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button Page</title>
</head>

<body>
    <button onclick="alert('Button Clicked!')">Click Me</button>
</body>

</html>