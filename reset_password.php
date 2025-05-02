<?php
// reset_password.php

if (isset($_GET['token'])) {
    include 'db.php';
    
    $token = $_GET['token'];
    
    // Check if the token exists in the database
    $query = "SELECT * FROM users WHERE reset_token = '$token' AND reset_expires > " . date("U");
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = $_POST['password'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update the password in the database
            $update_query = "UPDATE users SET password = '$hashed_password', reset_token = NULL, reset_expires = NULL WHERE reset_token = '$token'";
            mysqli_query($conn, $update_query);
            
            echo "Your password has been reset successfully.";
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<form method="POST" action="">
    Enter your new password:<br>
    <input type="password" name="password" required><br><br>
    <input type="submit" value="Reset Password">
</form>
