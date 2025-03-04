<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin page";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define column names (key = database field, value = display name)
//you can reorder the columns as you want by default it will display in the order you have defined here
$columns = [
    "sr_no" => "SR No",
    "order_name" => "Order Name",
    "order_description" => "Description",
    "color" => "Color",
    "quantity" => "Quantity",
    "order_image" => "Image",
    "download_file" => "Download File",
    "comment" => "Comment",
    "order_status" => "Status"
];

// Create SQL query dynamically based on column keys
$sql = "SELECT " . implode(", ", array_keys($columns)) . " FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h2>Orders List</h2>

    <table>
        <tr>
            <?php
            // Generate table headers dynamically
            foreach ($columns as $db_field => $display_name) {
                echo "<th>{$display_name}</th>";
            }
            ?>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";

                // Loop through columns dynamically and display data
                foreach ($columns as $db_field => $display_name) {
                    if ($db_field === "order_image") {
                        // Handle image field separately
                        if (!empty($row[$db_field])) {
                            if (strpos($row[$db_field], "<svg") !== false) {
                                echo "<td>{$row[$db_field]}</td>"; // Directly render inline SVG
                            } else {
                                echo "<td><img src='data:image/svg+xml;base64," . base64_encode($row[$db_field]) . "' alt='Order Image' width='100'></td>";
                            }
                        } else {
                            echo "<td>No Image</td>";
                        }
                    } elseif ($db_field === "download_file") {
                        // Handle download file field
                        echo !empty($row[$db_field]) ? "<td><a href='{$row[$db_field]}' download>Download</a></td>" : "<td>No File</td>";

                    } elseif ($db_field === "order_status") {
                        // Handle status field
                        $status = $row[$db_field] ?? "N/A";

                        // Define status options
                        $status_options = ["Cutting", "Printing", "Ready to Ship", "Delivery"];

                        echo "<td>";
                        echo "<select class='order-status'>";

                        // Generate dropdown options
                        foreach ($status_options as $option) {
                            $selected = ($status === $option) ? "selected" : "";
                            echo "<option value='{$option}' {$selected}>{$option}</option>";
                        }

                        echo "</select>";
                        echo "</td>";
                    } else {
                        // Display all other fields normally
                        echo "<td>" . htmlspecialchars($row[$db_field] ?? "N/A") . "</td>";
                    }
                }

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='" . count($columns) . "'>No orders found</td></tr>";
        }
        ?>

    </table>
    <script src="status_span_width_changer.js"></script> <!-- Include custom JavaScript for status dropdown -->

</body>

</html>

<?php
$conn->close();
?>