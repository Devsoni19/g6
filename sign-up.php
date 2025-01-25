<?php
include 'connect.php'; // Include database connection

$message = ''; // Feedback message for users

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs to prevent SQL injection
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']); // Store password as plain string
    $mobile_number = $conn->real_escape_string($_POST['mobile_number']);

    // Check if username already exists
    $check_username = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $result = $check_username->get_result();

    if ($result->num_rows > 0) {
        $message = "Username already exists. Please choose a different username.";
    } else {
        // SQL query to insert user details
        $sql = $conn->prepare("INSERT INTO users (first_name, last_name, username, password, mobile_number) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("sssss", $first_name, $last_name, $username, $password, $mobile_number);

        if ($sql->execute()) {
            $message = "Signup successful. <a href='login.php'>Click here to login</a>";
        } else {
            $message = "Error: " . $sql->error;
        }

        $sql->close();
    }

    $check_username->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f7fb;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .signup-container {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .signup-container h2 {
      margin: 0 0 20px;
      text-align: center;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    .form-group input:focus {
      border-color: #007bff;
      outline: none;
    }

    .signup-btn {
      width: 100%;
      padding: 10px;
      background: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    .signup-btn:hover {
      background: #0056b3;
    }

    .signup-container p {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
      color: #555;
    }

    .signup-container p a {
      color: #007bff;
      text-decoration: none;
    }

    .signup-container p a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="signup-container">
    <h2>Sign Up</h2>
    <?php if (!empty($message)) echo "<p style='color: green; text-align: center;'>$message</p>"; ?>
    <form action="" method="POST">
      <div class="form-group">
        <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
      </div>
      <div class="form-group">
        <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
      </div>
      <div class="form-group">
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
      </div>
      <div class="form-group">
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <div class="form-group">
        <input type="text" id="mobile_number" name="mobile_number" placeholder="Enter your mobile number" required>
      </div>
      <button type="submit" class="signup-btn">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
