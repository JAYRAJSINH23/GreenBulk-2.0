<?php
require_once 'includes/db.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $productId = $_POST['product_id'] ?? 0;
    
    if ($action === 'add') {
        $quantity = $_POST['quantity'] ?? 1;
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    } elseif ($action === 'remove') {
        unset($_SESSION['cart'][$productId]);
    } elseif ($action === 'update') {
        $quantity = $_POST['quantity'] ?? 1;
        if ($quantity > 0) {
            $_SESSION['cart'][$productId] = $quantity;
        } else {
            unset($_SESSION['cart'][$productId]);
        }
    }
    
    header("Location: cart.php");
    exit();
}

include 'includes/header.php';

// Fetch items for display
$cartItems = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
    $productIds = implode(',', array_keys($_SESSION['cart']));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($productIds)");
    $products = $stmt->fetchAll();
    
    foreach ($products as $p) {
        $qty = $_SESSION['cart'][$p['id']];
        $subtotal = $p['price'] * $qty;
        $total += $subtotal;
        $cartItems[] = array_merge($p, ['qty' => $qty, 'subtotal' => $subtotal]);
    }
}
?>

<h2 style="margin-bottom: 40px; color: var(--primary-brown);">Your Shopping Cart</h2>

<?php if (empty($cartItems)): ?>
    <div style="text-align: center; padding: 100px; background: var(--beige-accent); border-radius: 20px;">
        <i class="fas fa-shopping-basket" style="font-size: 4rem; color: #ccc; margin-bottom: 25px;"></i>
        <h3>Your cart is empty</h3>
        <p style="color: var(--text-light); margin-bottom: 30px;">Looks like you haven't added anything yet.</p>
        <a href="products.php" class="btn btn-primary">Start Shopping</a>
    </div>
<?php else: ?>
    <div style="display: flex; gap: 40px; align-items: flex-start;">
        <!-- Cart Table -->
        <div style="flex: 2;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee;">
                        <th style="text-align: left; padding: 15px 0;">Product</th>
                        <th style="padding: 15px 0;">Price</th>
                        <th style="padding: 15px 0;">Quantity</th>
                        <th style="padding: 15px 0;">Total</th>
                        <th style="padding: 15px 0;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 20px 0; display: flex; align-items: center; gap: 20px;">
                                <div style="width: 80px; height: 80px; background: var(--beige-accent); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <img src="<?php echo $item['image_url'] ?? 'assets/images/placeholder.jpg'; ?>" style="max-width: 80%; max-height: 80%;">
                                </div>
                                <div>
                                    <h4 style="margin: 0;"><?php echo $item['name']; ?></h4>
                                    <p style="font-size: 0.8rem; color: var(--text-light); margin: 5px 0;"><?php echo $item['category']; ?></p>
                                </div>
                            </td>
                            <td style="text-align: center;">$<?php echo number_format($item['price'], 2); ?></td>
                            <td style="text-align: center;">
                                <form action="cart.php" method="POST" style="display: inline-flex; border: 1px solid #ddd; border-radius: 5px;">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['qty']; ?>" onchange="this.form.submit()" style="width: 45px; border: none; padding: 8px; text-align: center; outline: none;">
                                </form>
                            </td>
                            <td style="text-align: center; font-weight: 700;">$<?php echo number_format($item['subtotal'], 2); ?></td>
                            <td style="text-align: center;">
                                <form action="cart.php" method="POST">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" style="color: #ff4d4d; border: none; background: none; cursor: pointer; font-size: 1.1rem;"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div style="margin-top: 30px;">
                <a href="products.php" style="color: var(--primary-brown); text-decoration: none; font-weight: 600;"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
            </div>
        </div>

        <!-- Summary -->
        <div style="flex: 0.8; background: var(--beige-accent); padding: 30px; border-radius: 15px; position: sticky; top: 100px;">
            <h3 style="margin-bottom: 25px;">Order Summary</h3>
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span>Subtotal</span>
                <span>$<?php echo number_format($total, 2); ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span>Shipping</span>
                <span style="color: #1e7e34; font-weight: 600;">FREE</span>
            </div>
            <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 30px; font-size: 1.2rem; font-weight: 700;">
                <span>Total</span>
                <span style="color: var(--primary-brown);">$<?php echo number_format($total, 2); ?></span>
            </div>
            <a href="checkout.php" class="btn btn-primary" style="width: 100%; padding: 18px; font-size: 1.1rem; text-decoration: none; display: block; text-align: center;">Proceed to Checkout</a>
            <div style="text-align: center; margin-top: 20px; font-size: 0.8rem; color: var(--text-light); display: flex; justify-content: center; gap: 10px;">
                <i class="fab fa-cc-visa"></i>
                <i class="fab fa-cc-mastercard"></i>
                <i class="fab fa-cc-paypal"></i>
                <i class="fab fa-cc-apple-pay"></i>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
