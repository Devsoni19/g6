<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connections
include 'connect.php';
include 'connect_log_in_info.php';

// Start session
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Prepare and execute SQL query to retrieve user details
    $sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Compare password as plain string
        if ($password === $row['password']) {
            // Set session variable
            $_SESSION['username'] = $username;

            // Insert username into 'myoborders' table
            $insertSql = $conn->prepare("INSERT INTO myoborders (username) VALUES (?)");
            $insertSql->bind_param("s", $username);
            if ($insertSql->execute()) {
                // Success message (optional)
            } else {
                $_SESSION['error'] = "Failed to update myoborders: " . $conn->error;
            }
            $insertSql->close();

            // Prepare login details
            $userID = $row['id'];
            date_default_timezone_set('Asia/Kolkata');
            $timestamp = date('Y-m-d H:i:s'); // Full date and time in dd-mm-yyyy format in Asia/Kolkata timezone
            $macID = 'Unavailable'; // Replace with proper logic if MAC is critical

            // Remove code to store IP address in the database
            // $ipAddress = $_SERVER['REMOTE_ADDR'];
            // $sql_ip = $conn->prepare("//INSERT INTO ip_addresses (user_id, ip_address, timestamp) VALUES (?, ?, ?)");
            // $sql_ip->bind_param("iss", $userID, $ipAddress, $timestamp);
            // $sql_ip->execute();
            // $sql_ip->close();

            // Redirect to button.php after successful login
            // window.location.href
            header("Location: users.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid username or password.";
        }
    } else {
        $_SESSION['error'] = "Invalid username or password.";
    }

    $sql->close();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        /* General Reset and Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fb;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
            color: #333;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        /* Outer Box Styling */
        .outer-box {
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
            /* Subtle gradient for depth */
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-shadow:
                inset 0px 1px 2px rgba(255, 255, 255, 0.6),
                /* Inner highlight */
                0px 4px 6px rgba(0, 0, 0, 0.1),
                /* Outer shadow */
                0px 1px 3px rgba(0, 0, 0, 0.08);
            /* Additional depth */
            color: #333;
            font-size: 16px;
            font-weight: 500;
            text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
            /* Subtle text depth */
            max-width: 90%;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        /* Login Container Styling */
        .login-container {
            background-color: #fff;
            padding: 30px 25px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            /* Enhanced shadow */
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 26px;
            color: #333;
            text-align: center;
        }

        .login-container p {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #555;
        }

        .login-container a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .login-container a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        /* Alert Box Styling */
        .alert {
            border-radius: 10px;
            padding: 12px 18px;
            margin-bottom: 15px;
            font-size: 14px;
            background-color: #f8d7da;
            /* Example alert background */
            color: #721c24;
            /* Example alert text */
            border: 1px solid #f5c6cb;
            transition: all 0.3s ease;
        }

        .alert:hover {
            background-color: #f5c6cb;
            color: #491217;
        }

        /* Form Group Styling */
        .form-group {
            margin-bottom: 20px;
            /* Increased spacing */
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
            color: #444;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            /* Improved padding for usability */
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
            /* Focus effect */
        }

        /* Button Styling */
        .login-btn {
            width: 100%;
            padding: 14px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .login-btn:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .outer-box {
                padding: 15px;
            }

            .login-container {
                padding: 20px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                /* Lighter shadow for smaller screens */
            }

            .login-container h2 {
                font-size: 22px;
            }

            .login-container p {
                font-size: 13px;
            }

            .login-btn {
                font-size: 14px;
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 15px;
            }

            .login-container h2 {
                font-size: 20px;
            }

            .form-group input {
                padding: 10px;
            }

            .login-btn {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <?php if (!empty($_SESSION['error'])) { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>username or password is incorrect</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php } ?>
    <div class="outer-box">
        <div class="login-container">
            <h2>Login</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label class="lablelline" for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label class="lablelline" for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
            <p>Don't have an account? <a href="sign-up.php">Sign up</a></p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j6f3y4x9pvvF4+h7K7E"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>