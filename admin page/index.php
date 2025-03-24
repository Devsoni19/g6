<?php
include '../connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="index.css">
  <script src="download_svg.js"></script>

</head>

<body>
  <div class="main">
    <div class="status-bar">
      <h2>Orders</h2>
      <select id="userDropdown" onchange="fetchOrders()" class="username-select">
        <option value="">Select a User</option>
        <?php
        // Fetch distinct usernames
        $sql = "SELECT DISTINCT username FROM myoborders";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['username']}'>{$row['username']}</option>";
          }
        }
        ?>
      </select>

    </div>

    <table>
      <thead>
        <tr>
          <th>SR</th>
          <th>Username</th>
          <th>File</th>
          <th>Quantity</th>
          <th>Color</th>
          <th>Download</th>
        </tr>
      </thead>
      <tbody id="ordersTable">
        <tr>
          <td colspan="6">Select a user to see orders</td>
        </tr>
        <script src="download_svg.js"></script>

      </tbody>
    </table>
  </div>
  <script src="user-select.js"></script>
  <script src="download_svg.js"></script>
</body>

</html>