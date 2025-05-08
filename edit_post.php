<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    echo "No post ID provided.";
    exit();
}

$post_id = (int) $_GET['id'];
$query = "SELECT * FROM posts WHERE id = $post_id AND user_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Post not found or access denied.";
    exit();
}

$row = mysqli_fetch_assoc($result);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated post data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    // Update the post in the database
    $update_query = "UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, 'ssii', $title, $content, $post_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Redirect back to the dashboard after successful update
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating post.";
    }
} else {
    // Show the form only if the request method is GET (i.e., when the page is loaded initially)
?>

<!-- HTML Form to Edit Post -->
<form method="POST" action="edit.php?id=<?= $post_id ?>">
    <label for="title">Title:</label><br>
    <input type="text" name="title" id="title" value="<?= htmlspecialchars($row['title']) ?>" required><br>

    <label for="content">Content:</label><br>
    <textarea name="content" id="content" required><?= htmlspecialchars($row['content']) ?></textarea><br>

    <button type="submit">Update Post</button>
</form>

<?php
}
?>
