<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Fetch assoc arrays by default
            PDO::ATTR_EMULATE_PREPARES => false,  // Use native prepares if possible
        ]
    );
} catch (PDOException $e) {
    // Log error for production
    error_log("Database connection error: " . $e->getMessage(), 3, 'errors.log');
    // Display generic message
    die("Database connection failed.");
}
?>

