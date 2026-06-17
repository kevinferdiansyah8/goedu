<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->exec('DROP DATABASE IF EXISTS goedu_db');
    $pdo->exec('CREATE DATABASE goedu_db');
    echo "Database recreated successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
