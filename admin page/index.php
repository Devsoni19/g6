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

    <div class="order-details">
      <?php
      // Define table headers in an array
      $tableHeaders = ["Sr", "Username", "File", "Quantity", "Color", "Download", "Date", "Time"];

      // Count the number of columns
      $colspan = count($tableHeaders);
      ?>

      <table>
        <thead>
          <tr>
            <?php foreach ($tableHeaders as $header): ?>
              <th><?php echo $header; ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody id="ordersTable">
          <tr>
            <td colspan="<?php echo $colspan; ?>">Select a user to see orders</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <script src="user-select.js"></script>
</body>

</html>