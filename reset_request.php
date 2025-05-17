<?php
// reset_request.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Basic email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color:red;'>Invalid email format.</p>";
    } else {
        // Check if email exists in the database
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Generate a unique reset token and set expiration time
            $token = bin2hex(random_bytes(50));
            $expires = date('Y-m-d H:i:s', time() + 3600); // valid for 1 hour

            // Update reset token and expiry time in the database
            $update = "UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
            $stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($stmt, 'sss', $token, $expires, $email);
            if (mysqli_stmt_execute($stmt)) {
                // Generate reset link
                $resetLink = "http://localhost/your_project_folder/reset_password.php?token=$token";

                // Provide the reset link to the user
                echo "<p style='color:green;'>✅ A reset link has been sent to your email address. <br>";
                echo "<strong>Reset Link:</strong> <a href='$resetLink' target='_blank'>$resetLink</a></p>";
            } else {
                echo "<p style='color:red;'>Error occurred while updating the database. Please try again.</p>";
            }
        } else {
            echo "<p style='color:red;'>❌ Email not found in the database.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        form {
            margin-top: 20px;
        }
        input[type=email], input[type=submit] {
            padding: 10px;
            margin: 10px 0;
            width: 300px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>🔐 Request Password Reset</h2>
    <p>If you have forgotten your password, enter your email address below, and we will send you a password reset link.</p>
    <form method="POST" action="">
        <label for="email">Enter your email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <input type="submit" value="Send Reset Link">
    </form>
</body>
</html>
