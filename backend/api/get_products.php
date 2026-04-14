<?php
require_once '../config/database.php';

// backend/api/get_products.php

header('Content-Type: application/json');

try {
    $category = isset($_GET['category']) ? $_GET['category'] : null;
    $min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
    $max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 999999;
    
    // Pagination params
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 12;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

    $query = "SELECT * FROM products WHERE price >= :min_price AND price <= :max_price";
    $params = [
        'min_price' => $min_price,
        'max_price' => $max_price
    ];

    if ($category) {
        $query .= " AND category = :category";
        $params['category'] = $category;
    }

    // Add ordering and pagination
    $query .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':min_price', $min_price);
    $stmt->bindValue(':max_price', $max_price);
    if ($category) $stmt->bindValue(':category', $category);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    $products = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'count' => count($products),
        'limit' => $limit,
        'offset' => $offset,
        'data' => $products
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
