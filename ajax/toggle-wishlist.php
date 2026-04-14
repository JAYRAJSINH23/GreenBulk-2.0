<?php
require_once '../includes/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'login']);
    exit();
}

$userId = $_SESSION['user_id'];
$productId = $_POST['product_id'] ?? null;

if (!$productId) {
    echo json_encode(['status' => 'error']);
    exit();
}

try {
    // Check if exists
    $stmt = $pdo->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $exists = $stmt->fetch();

    if ($exists) {
        // Remove
        $del = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
        $del->execute([$userId, $productId]);
        echo json_encode(['status' => 'removed']);
    } else {
        // Add
        $ins = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
        $ins->execute([$userId, $productId]);
        echo json_encode(['status' => 'added']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
