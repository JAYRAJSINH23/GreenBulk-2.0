<?php
require_once '../config/database.php';

// backend/api/login.php

header('Content-Type: application/json');
session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Only POST method is allowed");
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception("Invalid JSON input");
    }

    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';

    if (empty($email) || empty($password)) {
        throw new Exception("Email and password are required");
    }

    // Fetch user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Log in successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        // Return user info (excluding password hash)
        unset($user['password_hash']);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $user
        ]);
    } else {
        throw new Exception("Invalid email or password");
    }

} catch (Exception $e) {
    http_response_code(401); // Unauthorized
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
