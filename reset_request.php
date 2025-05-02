<?php
// reset_request.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input to prevent SQL Injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists
    $query = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expires = time() + 3600; // token expires in 1 hour

        // Update user table with token and expiration
        $update = "UPDATE users SET reset_token='$token', reset_expires=$expires WHERE email='$email'";
        mysqli_query($conn, $update);

        // Generate the reset link
        $resetLink = "http://localhost/blog_project/reset_password.php?token=$token"; // Modify URL if hosted elsewhere

        // TEMPORARY: Show reset link on the page (in production, you'd email this to the user)
        echo "<p><strong>Reset link:</strong> <a href='$resetLink'>$resetLink</a></p>";
    } else {
        // If email doesn't exist
        echo "<p style='color:red;'>Email not found in the database.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
</head>
<body>
    <h2>Request Password Reset</h2>
    <form method="POST" action="reset_request.php">
        <label>Email:</label><br>
        <input type="email" name="email" required placeholder="Enter your registered email"><br><br>
        <input type="submit" value="Send Reset Link">
    </form>
</body>
</html>

