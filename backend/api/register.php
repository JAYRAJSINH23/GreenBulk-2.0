<?php
require_once '../config/database.php';

// backend/api/register.php

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Only POST method is allowed");
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception("Invalid JSON input");
    }

    $name = trim($input['name'] ?? '');
    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        throw new Exception("All fields (name, email, password) are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format");
    }

    // Check if user already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        throw new Exception("Email already registered");
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $password_hash]);

    echo json_encode([
        'status' => 'success',
        'message' => 'User registered successfully'
    ]);

} catch (Exception $e) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
