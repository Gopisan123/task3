<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO posts (title, content, user_id) VALUES ('$title', '$content', $user_id)";

    if (mysqli_query($conn, $query)) {
        echo "<div class='container'><p class='success-msg'>✅ Post added successfully. <a href='dashboard.php'>Go to Dashboard</a></p></div>";
        exit();
    } else {
        echo "<div class='container'><p class='error-msg'>❌ Error: " . mysqli_error($conn) . "</p></div>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f3f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            transition: 0.3s;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 6px rgba(0,123,255,0.3);
        }

        textarea {
            resize: vertical;
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

        .success-msg, .error-msg {
            text-align: center;
            font-weight: bold;
            padding: 10px;
            margin-top: 20px;
        }

        .success-msg {
            color: #28a745;
        }

        .error-msg {
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add New Post</h2>
    <form method="post">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>

        <label for="content">Content</label>
        <textarea name="content" id="content" rows="6" required></textarea>

        <input type="submit" value="Add Post">
    </form>
</div>

</body>
</html>
