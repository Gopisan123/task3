<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "❌ Incorrect password.";
        }
    } else {
        echo "❌ User not found.";
    }
}
?>

<h2>Login</h2>
<form method="POST">
    Username: <br>
    <input type="text" name="username" required><br><br>
    Password: <br>
    <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>

<p><a href="reset_request.php">Forgot Password?</a></p>
