<?php
// Include database connections
include 'connect_log_in_info.php';

// Get POST data
$userID = $_POST['userID'];
$timestamp = $_POST['timestamp'];
$ipAddress = $_POST['ipAddress'];
$macID = $_POST['macID'];

// Prepare and execute SQL query to save IP address
$sql_log = $conn_log->prepare("INSERT INTO logininfo (UserID, TimeStamp, IPAddress, MacID) VALUES (?, ?, ?, ?)");
$sql_log->bind_param("isss", $userID, $timestamp, $ipAddress, $macID);

if ($sql_log->execute()) {
    error_log("Login record created successfully for UserID: $userID");
} else {
    error_log("Error logging login: " . $sql_log->error);
}

$sql_log->close();
$conn_log->close();
?>
