<?php
// Include database connection
include 'connect.php';

// Handle form submission
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username'] ?? '');

    if (!empty($username)) {
        // SQL query to retrieve user details
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Generate a unique token
            $token = bin2hex(random_bytes(50));

            // Store the token in the database with an expiration time
            $sql = "UPDATE users SET reset_token = '$token', reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE username = '$username'";
            if ($conn->query($sql) === TRUE) {
                // Send email with reset link (for simplicity, we'll just display the link)
                $resetLink = "http://localhost/rutvi%20ht/reset-password.php?token=$token";
                $message = "Password reset link: <a href='$resetLink'>$resetLink</a>";
            } else {
                $message = "Error: " . $conn->error;
            }
        } else {
            $message = "User not found.";
        }
    } else {
        $message = "Please enter the required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .message {
            margin-bottom: 15px;
            color: red;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left; /* Align the form group to the left */
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-btn:hover {
            background: #0056b3;
        }
        .forgot-password-message {
            display: none;
            color: #555;
            margin-top: 15px;
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .login-container p {
            margin-top: 20px;
            text-align: center;
        }
        .login-container a {
            color: #007bff;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
        .back-to-login {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
        .back-to-login:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function showForgotPassword() {
            document.getElementById('username-container').style.display = 'none';
            document.querySelector('.login-btn').style.display = 'none';
            document.getElementById('forgot-password-message').style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="login-container">
        <h2>Forgot Password</h2>
        <?php if (!empty($message)) { echo "<div class='message'>" . htmlspecialchars($message) . "</div>"; } ?>
        <form action="" method="POST">
            <div id="username-container" class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" pattern="[A-Za-z]+" title="Username should only contain letters." placeholder="Enter your username" required>
            </div>
            <button type="submit" class="login-btn">Submit</button>
        </form>
        <div id="forgot-password-message" class="forgot-password-message">
            Please contact support or reset your password using the email linked to your account.
        </div>
        <a href="login.php" class="back-to-login">Back to Login</a>
    </div>
</body>
</html>