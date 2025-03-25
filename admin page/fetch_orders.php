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
      $svgBase64 = base64_encode($row['file']);
      echo "<tr id='row-{$row['id']}'>";
      echo "<td>{$row['id']}</td>";
      echo "<td>{$row['username']}</td>";
      echo "<td class='svg-container'>
                <img src='data:image/svg+xml;base64,{$svgBase64}' alt='SVG Image' class='svg-img' data-uri='{$svgBase64}'>
              </td>";
      echo "<td>{$row['quantity']}</td>";
      echo "<td>{$row['color']}</td>";
      echo "<td><button class='download-btn' data-id='{$row['id']}'>Download</button></td>";
      echo "<td>" . date("d-m-Y", strtotime($row['date'])) . "</td>";
      echo "<td>" . date("h:i A", strtotime($row['time'])) . "</td>";
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='8'>No orders found for this user</td></tr>";
  }
}
?>