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
// Verify ownership before deleting
$check_query = "SELECT * FROM posts WHERE id = $post_id AND user_id = $user_id";
$result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($result) == 0) {
    echo "You do not have permission to delete this post.";
    exit();
}

// Proceed with deletion
$delete_query = "DELETE FROM posts WHERE id = $post_id";
mysqli_query($conn, $delete_query);

header("Location: dashboard.php"); // or wherever your post list is
exit();
?>
