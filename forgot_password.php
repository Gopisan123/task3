<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php';

    // Validate email format
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        echo "Please enter a valid email address.";
        exit;
    }

    // Prepare statement to check if email exists
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Email exists, generate token and update DB
        $token = bin2hex(random_bytes(50));
        $expires = time() + 1800; // 30 minutes from now

        $update_stmt = mysqli_prepare($conn, "UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        mysqli_stmt_bind_param($update_stmt, "sis", $token, $expires, $email);
        mysqli_stmt_execute($update_stmt);

        // Compose email
        $reset_link = "https://yourdomain.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "To reset your password, please click the link below:\n\n$reset_link\n\nIf you did not request a password reset, please ignore this email.";
        $headers = "From: noreply@yourdomain.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        mail($email, $subject, $message, $headers);
    }

    // Always show this message to avoid revealing whether email exists
    echo "If an account with that email exists, a password reset link has been sent.";
}
?>

<form method="POST" action="">
    Enter your email to reset your password:<br>
    <input type="email" name="email" required><br><br>
    <input type="submit" value="Send Reset Link">
</form>
