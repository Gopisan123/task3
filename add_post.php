<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Create New Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 40px;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }
        input[type="text"],
        textarea {
            width: 100%;
            max-width: 500px;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 8px rgba(0,123,255,0.25);
        }
        button {
            margin-top: 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 25px;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }

        .success-msg, .error-msg {
            text-align: center;
            font-weight: bold;
            padding: 10px;
            margin-top: 20px;
        }

        .success-msg {
            color: #28a745;
        }

        .error-msg {
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add New Post</h2>

    <!-- Form to create a new post -->
    <form action="add_post.php" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required />

        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="5" required></textarea>

        <button type="submit">Submit</button>
    </form>

</body>
</html>
