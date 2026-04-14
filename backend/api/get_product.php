<?php
require_once '../config/database.php';

// backend/api/get_product.php?id=X

header('Content-Type: application/json');

try {
    if (!isset($_GET['id'])) {
        throw new Exception("Product ID is required");
    }

    $id = intval($_GET['id']);
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if ($product) {
        echo json_encode([
            'status' => 'success',
            'data' => $product
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => 'Product not found'
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
