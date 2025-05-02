<?php
// Step 1: Include the database connection
include 'db.php';

// Step 2: Check if a post ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Step 3: Fetch the post details from the database
    $sql = "SELECT * FROM posts WHERE id = $id";
    $result = mysqli_query($conn, $sql);

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
<html>
<head>
    <title>Edit Post</title>
</head>
<body>

<h2>Edit Post</h2>

<form action="update_post.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    
    <label>Title:</label><br>
    <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required><br><br>

    <label>Content:</label><br>
    <textarea name="content" rows="5" cols="40" required><?php echo htmlspecialchars($row['content']); ?></textarea><br><br>

    <button type="submit">Update Post</button>
</form>

</body>
</html>

<?php
mysqli_close($conn);
?>
