<?php
// Step 1: Include the database connection
include 'db.php';

// Step 2: Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 3: Get the form values
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    // Step 4: Update the post in the database
    $sql = "UPDATE posts SET title = '$title', content = '$content' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Post updated successfully. <a href='read.php'>View Posts</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Step 5: Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request!";
}
?>
