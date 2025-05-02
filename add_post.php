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
    $user_id = $_SESSION['user_id']; // use logged-in user ID

    $query = "INSERT INTO posts (title, content, user_id) VALUES ('$title', '$content', $user_id)";

    if (mysqli_query($conn, $query)) {
        echo "✅ Post added. <a href='dashboard.php'>Go to Dashboard</a>";
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>

<h2>Add New Post</h2>
<form method="post">
    Title: <input type="text" name="title" required><br><br>
    Content:<br>
    <textarea name="content" rows="5" cols="40" required></textarea><br><br>
    <input type="submit" value="Add Post">
</form>
