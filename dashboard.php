<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Blog Posts</title>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
<p>You are logged in with ID: <?php echo $user_id; ?></p>

<h3>Your Blog Posts</h3>
<a href="add_post.php">Add New Post</a><br><br>

<?php
$query = "SELECT * FROM posts WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<strong>" . htmlspecialchars($row['title']) . "</strong><br>";
        echo nl2br(htmlspecialchars($row['content'])) . "<br>";
        echo "<small>Posted on: " . $row['created_at'] . "</small><br>";
        echo "<a href='edit_post.php?id=" . $row['id'] . "'>Edit</a> | ";
        echo "<a href='delete_post.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this post?')\">Delete</a>";
        echo "<hr>";
    }
} else {
    echo "<p>No posts found.</p>";
}
?>

<a href="logout.php">Logout</a>

</body>
</html>
