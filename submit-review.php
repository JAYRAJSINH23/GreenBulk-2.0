<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $productId = $_POST['product_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    try {
        $stmt = $pdo->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->execute([$productId, $userId, $rating, $comment]);
        
        header("Location: product-detail.php?id=$productId&success=1");
    } catch (Exception $e) {
        die("Error submitting review: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
}
?>
