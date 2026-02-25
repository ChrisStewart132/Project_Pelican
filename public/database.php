<?php
// database.php - LOGIC ONLY
require_once 'config.php';

function getDatabaseConnection() {
    global $host, $db, $user, $pass, $charset;
    
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        // Log error and return a JSON error for the API
        http_response_code(500);
        die(json_encode(['error' => 'Database connection failed.']));
    }
}