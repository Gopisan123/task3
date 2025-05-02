<?php
// Step 1: Include the database connection
include 'db.php';

// Step 2: Fetch posts from the database
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

// Step 3: Check if there are any posts
if (mysqli_num_rows($result) > 0) {
    // Step 4: Loop through and display each post
    while($row = mysqli_fetch_assoc($result)) {
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        echo "<small>Posted on: " . $row['created_at'] . "</small><br><br>";
    }
} else {
    echo "No posts available.";
}

// Step 5: Close the database connection
mysqli_close($conn);
?>
<?php
// Check if there are any posts
if (mysqli_num_rows($result) > 0) {
    // Loop through and display each post
    while($row = mysqli_fetch_assoc($result)) {
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        echo "<small>Posted on: " . $row['created_at'] . "</small><br>";
        
        // Add Edit and Delete links
        echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a> | ";
        echo "<a href='delete_post.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this post?\")'>Delete</a><br><br>";
    }
} else {
    echo "No posts available.";
}
?>
<?php
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM posts ORDER BY created_at DESC");

echo "<h2>All Blog Posts</h2>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
    echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
    echo "<small>Posted on: " . $row['created_at'] . "</small><br>";
    
    // Add Edit and Delete links:
    echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a> | ";
    echo "<a href='delete_post.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this post?');\">Delete</a><hr>";
}
?>
