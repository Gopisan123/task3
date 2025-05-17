<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    echo "<p style='color:red;'>No post ID provided.</p>";
    exit();
}

$post_id = (int) $_GET['id'];

// Verify ownership and fetch post
$query = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'ii', $post_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo "<p style='color:red;'>Post not found or access denied.</p>";
    exit();
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    // Use prepared statement for update
    $update_query = "UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?";
    $stmt_update = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt_update, 'ssii', $title, $content, $post_id, $user_id);

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: dashboard.php?msg=Post updated successfully");
        exit();
    } else {
        echo "<p style='color:red;'>Error updating post: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            padding: 30px;
        }
        form {
            max-width: 600px;
            background: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        label {
            font-weight: bold;
            margin-top: 12px;
            display: block;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        button {
            margin-top: 20px;
            background-color: #007bff;
            border: none;
            padding: 12px 20px;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h2>Edit Post</h2>
<form method="POST" action="edit.php?id=<?= htmlspecialchars($post_id) ?>">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="<?= htmlspecialchars($row['title']) ?>" required>

    <label for="content">Content:</label>
    <textarea name="content" id="content" required><?= htmlspecialchars($row['content']) ?></textarea>

    <button type="submit">Update Post</button>
</form>

</body>
</html>

