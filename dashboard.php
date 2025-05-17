<?php
session_start();
require 'config.php'; // include your PDO config file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Pagination setup
$limit = 5;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Search setup
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_condition = '';
$search_param = '';

if ($search !== '') {
    $search_condition = "AND (title LIKE :search OR content LIKE :search)";
    $search_param = '%' . $search . '%';
}

// Count total posts
$count_sql = "SELECT COUNT(*) FROM posts WHERE user_id = :user_id $search_condition";
$count_stmt = $pdo->prepare($count_sql);
$count_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
if ($search !== '') {
    $count_stmt->bindValue(':search', $search_param, PDO::PARAM_STR);
}
$count_stmt->execute();
$total_posts = $count_stmt->fetchColumn();
$total_pages = ceil($total_posts / $limit);

// Fetch paginated posts
$post_sql = "SELECT * FROM posts WHERE user_id = :user_id $search_condition 
             ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$post_stmt = $pdo->prepare($post_sql);
$post_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
if ($search !== '') {
    $post_stmt->bindValue(':search', $search_param, PDO::PARAM_STR);
}
$post_stmt->execute();
$posts = $post_stmt->fetchAll(PDO::FETCH_ASSOC);
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
<p>You are logged in with ID: <?php echo htmlspecialchars($user_id); ?></p>

<a href="add_post.php">Add New Post</a> |
<a href="logout.php">Logout</a>

<!-- Search Form -->
<form method="GET" action="dashboard.php">
    <input type="text" name="search" placeholder="Search posts..." value="<?php echo htmlspecialchars($search); ?>">
    <input type="submit" value="Search">
</form>

<h3>Your Blog Posts</h3>

<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <strong><?php echo htmlspecialchars($post['title']); ?></strong><br>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <small>Posted on: <?php echo htmlspecialchars($post['created_at']); ?></small><br>
            <a href="edit_post.php?id=<?php echo $post['id']; ?>">Edit</a> |
            <a href="delete_post.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
        </div>
    <?php endforeach; ?>

    <!-- Pagination -->
    <div class="pagination">Pages:
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <?php
            $link = "dashboard.php?page=$i";
            if ($search) $link .= "&search=" . urlencode($search);
            ?>
            <?php if ($i == $page): ?>
                <strong><?php echo $i; ?></strong>
            <?php else: ?>
                <a href="<?php echo $link; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>
<?php else: ?>
    <p>No posts found.</p>
<?php endif; ?>

</body>
</html>

