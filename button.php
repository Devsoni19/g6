<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next and Back Buttons</title>
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

        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 300px;
        }

        .button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .button:hover {
            background: #0056b3;
        }

        .button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <button id="back-btn" class="button">Back</button>
        <button id="next-btn" class="button">Next</button>
    </div>

    <script>
        const backBtn = document.getElementById('back-btn');
        const nextBtn = document.getElementById('next-btn');

        let currentPage = 1;
        const totalPages = 5; // Example total pages

        function updateButtons() {
            backBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;
        }

        backBtn.addEventListener('click', () => {
            window.location.href = 'login.php';
        });

        nextBtn.addEventListener('click', () => {
            window.location.href = 'users.php';
        });
    </script>
</body>
</html>
