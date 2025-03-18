<?php
header('Content-Type: text/plain'); // Set response type

session_start(); // Start session to access username
include('connect.php'); // Include database connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
  die("Error: User not logged in.");
}

$username = $_SESSION['username']; // Get username from session
$svgData = isset($_POST['data']) ? $_POST['data'] : ''; // Get SVG data from POST request

if (empty($svgData)) {
  die("Error: No SVG data received.");
}

// Step 1: Find the most recent entry (last inserted row) for this user
$findRecent = $conn->prepare("SELECT id, file, quantity FROM myoborders WHERE username = ? ORDER BY id DESC LIMIT 1");
$findRecent->bind_param("s", $username);
$findRecent->execute();
$result = $findRecent->get_result();
$row = $result->fetch_assoc();
$findRecent->close();

if ($row) {
  $lastInsertedId = $row['id'];
  $existingFile = $row['file'];
  $existingQuantity = $row['quantity'];

  if ($existingFile === $svgData) {
    // Step 2: If the same file exists, increment quantity
    $newQuantity = $existingQuantity + 1;
    $updateStmt = $conn->prepare("UPDATE myoborders SET quantity = ? WHERE id = ?");
    $updateStmt->bind_param("ii", $newQuantity, $lastInsertedId);

    if ($updateStmt->execute()) {
      echo "Quantity updated successfully!";
    } else {
      echo "Error updating quantity: " . $updateStmt->error;
    }

    $updateStmt->close();
  } else {
    // Step 3: Insert a new row if file is different
    $insertStmt = $conn->prepare("INSERT INTO myoborders (username, file, quantity) VALUES (?, ?, 1)");
    $insertStmt->bind_param("ss", $username, $svgData);

    if ($insertStmt->execute()) {
      echo "New SVG data saved successfully!";
    } else {
      echo "Error inserting data: " . $insertStmt->error;
    }

    $insertStmt->close();
  }
} else {
  // If no record exists, insert a new row
  $insertStmt = $conn->prepare("INSERT INTO myoborders (username, file, quantity) VALUES (?, ?, 1)");
  $insertStmt->bind_param("ss", $username, $svgData);

  if ($insertStmt->execute()) {
    echo "New SVG data saved successfully!";
  } else {
    echo "Error inserting data: " . $insertStmt->error;
  }

  $insertStmt->close();
}

$conn->close();
?>