<?php
$host = "localhost";
$username = "root";
$password = ""; // default password for XAMPP MySQL is empty
$database = "blog";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
