<?php
// backend/api/check_db.php - RUN THIS IN YOUR BROWSER: http://localhost/GreenBulk/backend/api/check_db.php

header('Content-Type: application/json');

$results = [
    'step_1_apache' => 'Success (If you see this, Apache is running)',
    'step_2_mysql_connection' => 'Testing...',
    'step_3_database_exists' => 'Testing...',
    'errors' => []
];

// Configuration
$host = 'localhost';
$db   = 'greenbulk';
$user = 'root';
$pass = '';

try {
    // Test Connection
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $results['step_2_mysql_connection'] = 'Success (MySQL is connected)';
    
    // Check Database
    $stmt = $pdo->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db'");
    if ($stmt->fetchColumn()) {
        $results['step_3_database_exists'] = "Success (Database '$db' found)";
    } else {
        $results['step_3_database_exists'] = "FAILED: Database '$db' not found. Please create it in phpMyAdmin and import SQL.";
    }

} catch (PDOException $e) {
    $results['step_2_mysql_connection'] = 'FAILED';
    $results['errors'][] = $e->getMessage();
}

echo json_encode($results, JSON_PRETTY_PRINT);
?>
