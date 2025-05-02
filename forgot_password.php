<?php
// forgot_password.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php';
    
    // Sanitize the input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Generate a unique reset token
        $token = bin2hex(random_bytes(50));
        $expires = date("U") + 1800; // Token expires in 30 minutes
        
        // Insert the token into the database
        $update_query = "UPDATE users SET reset_token = '$token', reset_expires = '$expires' WHERE email = '$email'";
        mysqli_query($conn, $update_query);
        
        // Send reset email (using PHP's mail function)
        $reset_link = "http://yourdomain.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:\n$reset_link";
        $headers = "From: noreply@yourdomain.com";
        
        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email.";
        } else {
            echo "Error sending email.";
        }
    } else {
        echo "No account found with that email.";
    }
}
?>

<form method="POST" action="">
    Enter your email to reset your password:<br>
    <input type="email" name="email" required><br><br>
    <input type="submit" value="Send Reset Link">
</form>
