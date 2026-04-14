<?php
require_once '../config/database.php';

// backend/api/get_reviews.php?id=X

header('Content-Type: application/json');

try {
    if (!isset($_GET['id'])) {
        throw new Exception("Product ID is required");
    }

    $id = intval($_GET['id']);
    
    // Fetch average rating and reviews
    $stmt = $pdo->prepare("SELECT r.*, u.name as user_name 
                           FROM reviews r 
                           JOIN users u ON r.user_id = u.id 
                           WHERE r.product_id = ? 
                           ORDER BY r.created_at DESC");
    $stmt->execute([$id]);
    $reviews = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'count' => count($reviews),
        'data' => $reviews
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
