<?php
require_once 'includes/db.php';
try {
    // Get all products
    $products = $pdo->query("SELECT id FROM products")->fetchAll(PDO::FETCH_COLUMN);
    $users = $pdo->query("SELECT id FROM users LIMIT 3")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($users)) {
        // Create a dummy user if none exist
        $pdo->exec("INSERT INTO users (name, email, password, role) VALUES ('Arjun Sharma', 'arjun@example.com', '123456', 'client')");
        $users = [$pdo->lastInsertId()];
    }

    $comments = [
        "Amazing results! I saw muscle growth in just 2 weeks. Highly recommended.",
        "The taste is surprisingly good for an organic product. No bloating at all.",
        "Best supplement I've ever used. Delivery was very fast too.",
        "Quality is top-notch. Love the transparent ingredient list.",
        "Mixes really well without any lumps. Perfect for my post-workout shake."
    ];

    $stmt = $pdo->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    
    foreach ($products as $pid) {
        // Add 2 reviews for each product
        for ($i = 0; $i < 2; $i++) {
            $stmt->execute([
                $pid, 
                $users[array_rand($users)], 
                rand(4, 5), 
                $comments[array_rand($comments)]
            ]);
        }
    }
    echo "Seed reviews added successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
