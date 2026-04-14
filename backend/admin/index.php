<?php
require_once '../config/database.php';
session_start();

// Simple Admin Auth Check (For production, implement proper login)
// For this demo, we'll just allow access or look for a session flag
$is_admin = isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1; // Assuming ID 1 is admin

try {
    // Fetch Orders
    $stmt = $pdo->query("SELECT o.*, u.name as customer_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
    $orders = $stmt->fetchAll();

    // Fetch Products
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
    $products = $stmt->fetchAll();
} catch (Exception $e) {
    die("Admin Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GreenBulk | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../frontend/css/style.css">
    <style>
        body { background: #f8f9fa; }
        .admin-card { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 30px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand brand-font">GreenBulk <span class="text-accent">Admin</span></span>
            <a href="../../frontend/index.html" class="btn btn-outline-light btn-sm">View Site</a>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <!-- Sidebar/Tabs -->
            <div class="col-md-3">
                <div class="list-group shadow-sm">
                    <a href="#orders" class="list-group-item list-group-item-action active" data-bs-toggle="list">Orders</a>
                    <a href="#products" class="list-group-item list-group-item-action" data-bs-toggle="list">Products</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="tab-content">
                    <!-- Orders Tab -->
                    <div class="tab-pane fade show active" id="orders">
                        <div class="admin-card">
                            <h3 class="fw-bold mb-4">Customer Orders</h3>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($orders as $order): ?>
                                        <tr>
                                            <td>#<?php echo $order['id']; ?></td>
                                            <td><?php echo $order['customer_name']; ?></td>
                                            <td class="fw-bold">₹<?php echo number_format($order['total_amount'], 2); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo ($order['status'] == 'Paid' ? 'success' : 'warning'); ?>">
                                                    <?php echo $order['status']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Products Tab -->
                    <div class="tab-pane fade" id="products">
                        <div class="admin-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="fw-bold mb-0">Manage Products</h3>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Add New</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($products as $p): ?>
                                        <tr>
                                            <td><?php echo $p['name']; ?></td>
                                            <td><?php echo $p['category']; ?></td>
                                            <td>₹<?php echo number_format($p['price'], 2); ?></td>
                                            <td><?php echo $p['stock']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Add Modal Placeholder -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Premium Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Form would go here to insert into `products` table.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
