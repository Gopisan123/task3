<?php
// reset_password.php
include 'db.php';
date_default_timezone_set('Asia/Kolkata');

$tokenValid = false;
$message = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists and is still valid
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        $tokenValid = true;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Check if passwords match
            if ($new_password !== $confirm_password) {
                $message = "❌ Passwords do not match.";
            } elseif (strlen($new_password) < 8) {
                $message = "❌ Password must be at least 8 characters long.";
            } else {
                // Hash the new password before storing it
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password and clear the reset token
                $update = mysqli_prepare($conn, "UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
                mysqli_stmt_bind_param($update, 'ss', $hashed, $token);
                if (mysqli_stmt_execute($update)) {
                    // Redirect to login page with success message
                    header("Location: login.php?reset=success");
                    exit;
                } else {
                    $message = "❌ There was an issue resetting your password. Please try again.";
                }
            }
        }
    } else {
        $message = "❌ Invalid or expired token.";
    }
} else {
    $message = "❌ No token provided.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .reset-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 350px;
        }
        h2 {
            margin-top: 0;
            color: #333;
        }
        input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        input[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 18px;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="reset-box">
    <h2>Reset Your Password</h2>
    <?php if (!$tokenValid): ?>
        <p class="error"><?php echo htmlspecialchars($message); ?></p>
    <?php else: ?>
        <form method="POST" action="">
            <label for="password">New Password:</label><br>
            <input type="password" name="password" required placeholder="Enter new password"><br>
            
            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" name="confirm_password" required placeholder="Confirm new password"><br>

            <input type="submit" value="Reset Password">
        </form>
    <?php endif; ?>
</div>

</body>
</html>
