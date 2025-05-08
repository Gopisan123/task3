<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Pagination settings
$limit = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search handling
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$search_condition = $search ? "AND (title LIKE '%$search%' OR content LIKE '%$search%')" : '';

// Count total posts for pagination
$count_sql = "SELECT COUNT(*) FROM posts WHERE user_id = $user_id $search_condition";
$total_posts = mysqli_fetch_row(mysqli_query($conn, $count_sql))[0];
$total_pages = ceil($total_posts / $limit);

// Fetch posts
$post_sql = "SELECT * FROM posts WHERE user_id = $user_id $search_condition ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $post_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Blog Posts</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .post { border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; }
        .pagination a { margin: 0 5px; text-decoration: none; }
        .pagination strong { margin: 0 5px; }
        form { margin-bottom: 20px; }
    </style>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
<p>You are logged in with ID: <?php echo $user_id; ?></p>

<a href="add_post.php">Add New Post</a> | 
<a href="logout.php">Logout</a>

<!-- Search Form -->
<form method="GET" action="dashboard.php">
    <input type="text" name="search" placeholder="Search posts..." value="<?php echo htmlspecialchars($search); ?>" required>
    <input type="submit" value="Search">
</form>

<h3>Your Blog Posts</h3>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='post'>";
        echo "<strong>" . htmlspecialchars($row['title']) . "</strong><br>";
        echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        echo "<small>Posted on: " . $row['created_at'] . "</small><br>";
        echo "<a href='edit_post.php?id=" . $row['id'] . "'>Edit</a> | ";
        echo "<a href='delete_post.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this post?')\">Delete</a>";
        echo "</div>";
    }

    // Pagination links
    echo "<div class='pagination'>";
    echo "Pages: ";
    for ($i = 1; $i <= $total_pages; $i++) {
        $link = "dashboard.php?page=$i";
        if ($search) $link .= "&search=" . urlencode($search);
        if ($i == $page) {
            echo "<strong>$i</strong>";
        } else {
            echo "<a href='$link'>$i</a>";
        }
    }
    echo "</div>";
} else {
    echo "<p>No posts found.</p>";
}
?>

</body>
</html>
