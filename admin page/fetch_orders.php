<?php
include "../connect.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"])) {
  $username = $_POST["username"];

  $sql = "SELECT * FROM myoborders WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<tr id='row-{$row['id']}'>";
      echo "<td>{$row['id']}</td>";
      echo "<td>{$row['username']}</td>";
      echo "<td class='svg'><img src='data:image/svg+xml;base64," . base64_encode($row['file']) . "' alt='Order Image'></td>";
      echo "<td>{$row['quantity']}</td>";
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='4'>No orders found for this user</td></tr>";
  }
}
?>