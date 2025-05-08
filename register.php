<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 450px;
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
        input[type="email"],
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
        input[type="email"]:focus,
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

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Register</h2>

    <?php if (!empty($message)): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Register">
    </form>

    <p style="text-align:center; margin-top: 15px;">
        Already registered? <a href="login.php">Login here</a>
    </p>
</div>

</body>
</html>
