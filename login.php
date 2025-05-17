<?php
session_start();
include 'db.php'; // ensures $conn is included

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect by role
                if ($user['role'] === 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit();
            } else {
                $error = "❌ Incorrect password.";
            }
        } else {
            $error = "❌ User not found.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "❌ Database error: Unable to process request.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <style>
      body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #6b73ff 0%, #000dff 100%);
        margin: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #333;
      }

      .container {
        background: #fff;
        padding: 40px 50px;
        border-radius: 12px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        width: 100%;
        max-width: 400px;
      }

      h2 {
        margin-bottom: 30px;
        font-weight: 700;
        color: #1a1a1a;
        text-align: center;
      }

      label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #555;
      }

      input[type="text"],
      input[type="password"] {
        width: 100%;
        padding: 14px 15px;
        margin-bottom: 25px;
        border-radius: 8px;
        border: 1.5px solid #ccc;
        font-size: 16px;
        transition: border-color 0.3s ease;
      }

      input[type="text"]:focus,
      input[type="password"]:focus {
        border-color: #000dff;
        outline: none;
        box-shadow: 0 0 8px rgba(0, 13, 255, 0.3);
      }

      input[type="submit"] {
        width: 100%;
        padding: 14px;
        background: #000dff;
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: 700;
        font-size: 17px;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      input[type="submit"]:hover {
        background: #3a44ff;
      }

      .error-msg {
        background: #ffe1e1;
        border: 1px solid #ff5c5c;
        color: #d8000c;
        padding: 12px;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 20px;
        font-weight: 600;
      }

      .forgot-link {
        text-align: center;
        margin-top: 15px;
      }

      .forgot-link a {
        color: #000dff;
        text-decoration: none;
        font-weight: 600;
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
        <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required autofocus />

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required />

        <input type="submit" value="Login" />
    </form>

    <div class="forgot-link">
        <a href="reset_request.php">Forgot Password?</a>
    </div>
</div>

</body>
</html>
