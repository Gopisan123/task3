<?php
session_start();
include 'db.php';

$error = "";

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
            $error = "❌ Incorrect password.";
        }
    } else {
        $error = "❌ User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px 40px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 6px rgba(0,123,255,0.3);
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-msg {
            color: #dc3545;
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        .forgot-link a {
            text-decoration: none;
            color: #007bff;
        }

        .forgot-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
        <p class="error-msg"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Login">
    </form>

    <div class="forgot-link">
        <a href="reset_request.php">Forgot Password?</a>
    </div>
</div>

</body>
</html>
