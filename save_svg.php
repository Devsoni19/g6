<?php
header('Content-Type: text/plain'); // Set response type

include('connect.php'); // Include database connection

// Get SVG data from POST request
$svgData = isset($_POST['data']) ? $_POST['data'] : '';

if (empty($svgData)) {
  die("Error: No SVG data received.");
}

// Prepare SQL statement to insert data
$stmt = $conn->prepare("INSERT INTO myoborders (file) VALUES (?)");
$stmt->bind_param("s", $svgData);

// Execute and check result
if ($stmt->execute()) {
  echo "SVG data saved successfully!";
} else {
  echo "Error saving data: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>