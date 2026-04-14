<?php
require_once '../includes/vendor_only.php';
include '../includes/dashboard_layout.php';
?>

<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px;">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-boxes"></i></div>
        <div class="stat-info">
            <h3>42</h3>
            <p>My Products</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        <div class="stat-info">
            <h3>$3,450</h3>
            <p>Total Revenue</p>
        </div>
    </div>
</div>

<div style="margin-top: 50px; display: flex; justify-content: space-between; align-items: center;">
    <h3>Active Orders</h3>
    <a href="add-product.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Product</a>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>#ORD-7721</td>
            <td>John Doe</td>
            <td>$120.00</td>
            <td>Apr 14, 2026</td>
            <td><span class="badge badge-success">Shipped</span></td>
        </tr>
        <tr>
            <td>#ORD-7725</td>
            <td>Alice Cooper</td>
            <td>$45.50</td>
            <td>Apr 13, 2026</td>
            <td><span class="badge badge-pending">Processing</span></td>
        </tr>
    </tbody>
</table>

</div> <!-- Close main-content -->
</body>
</html>
