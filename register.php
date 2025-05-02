<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username or email already exists
    $check = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $res = mysqli_query($conn, $check);

    if (mysqli_num_rows($res) > 0) {
        echo "❌ Username or Email already taken.";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        if (mysqli_query($conn, $sql)) {
            echo "✅ Registered successfully! <a href='login.php'>Login</a>";
        } else {
            echo "❌ Error: " . mysqli_error($conn);
        }
    }
}
?>

<!-- Registration Form -->
<h2>Register</h2>
<form method="POST" action="">
    Username: <input type="text" name="username" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" value="Register">
</form>


