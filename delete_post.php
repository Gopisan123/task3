<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    echo "❌ No post ID provided.";
    exit();
}

$post_id = (int) $_GET['id'];

// Use prepared statement to prevent SQL injection
$query = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 0) {
        echo "❌ You do not have permission to delete this post or post does not exist.";
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    echo "❌ Database error.";
    exit();
}

// Delete the post securely
$delete_query = "DELETE FROM posts WHERE id = ? AND user_id = ?";
if ($del_stmt = mysqli_prepare($conn, $delete_query)) {
    mysqli_stmt_bind_param($del_stmt, "ii", $post_id, $user_id);
    if (mysqli_stmt_execute($del_stmt)) {
        mysqli_stmt_close($del_stmt);
        header("Location: dashboard.php?msg=Post+deleted+successfully");
        exit();
    } else {
        echo "❌ Failed to delete the post. Please try again.";
        mysqli_stmt_close($del_stmt);
        exit();
    }
} else {
    echo "❌ Database error on delete.";
    exit();
}
?>
