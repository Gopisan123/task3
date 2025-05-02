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

// Show the form here with the post data
?>

