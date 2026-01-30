<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', 'root');
    echo "Connected successfully\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS laravel_hms");
    echo "Database check complete\n";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
