<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=lms_gagni', 'root', '');
    $pdo->exec('TRUNCATE TABLE migrations');
    echo "Migrations table cleared successfully!\n";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?> 