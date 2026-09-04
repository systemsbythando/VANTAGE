<?php
// VANTAGE database connection. Keep local credentials here for the demo;
// move them to environment variables before production deployment.
$host = '127.0.0.1';
$port = '3306';
$dbname = 'vantage_db';
$username = 'root';
$password = 'mysql';

try {
    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    die('VANTAGE database connection failed. Check config/database.php and your MySQL server.');
}
