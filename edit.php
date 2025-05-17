<?php
// Include DB connection
include 'db.php';

// Validate and sanitize input
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Prepare statement to fetch post
    $stmt = mysqli_prepare($conn, "SELECT * FROM posts WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "Invalid post ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
</head>
<body>

<h2>Edit Post</h2>

<form action="update_post.php" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
    
    <label>Title:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required><br><br>

    <label>Content:</label><br>
    <textarea name="content" rows="5" cols="40" required><?= htmlspecialchars($row['content']) ?></textarea><br><br>

    <button type="submit">Update Post</button>
</form>

</body>
</html>

<?php mysqli_close($conn); ?>

