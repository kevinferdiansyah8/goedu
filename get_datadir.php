<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $stmt = $pdo->query('SHOW VARIABLES LIKE "datadir"');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "DATADIR: " . $row['Value'] . "\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
