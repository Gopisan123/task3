<!DOCTYPE html>
<html>
<head>
    <title>Create New Post</title>
</head>
<body>

    <h2>Add New Post</h2>

    <!-- Form to create a new post -->
    <form action="add_post.php" method="POST">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" rows="5" cols="40" required></textarea><br><br>

        <button type="submit">Submit</button>
    </form>

</body>
</html>
