<?php
require_once 'includes/db.php';
require_once 'includes/razorpay-config.php';

// Force Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=checkout.php");
    exit();
}

include 'includes/header.php';

// If cart is empty, redirect back
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$total = 0;
$productIds = implode(',', array_keys($_SESSION['cart']));
$stmt = $pdo->query("SELECT * FROM products WHERE id IN ($productIds)");
$products = $stmt->fetchAll();

foreach ($products as $p) {
    $total += $p['price'] * $_SESSION['cart'][$p['id']];
}

// Convert USD to INR (Approx 1 USD = 83 INR for testing)
$totalINR = $total * 83;
?>

<div style="max-width: 1000px; margin: 0 auto; padding: 40px 20px;">
    <h2 style="margin-bottom: 40px; color: var(--primary-brown); text-align: center;"><i class="fas fa-shield-alt"></i> Finalize Your Order</h2>

    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px;">
        <!-- Left: Details -->
        <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow);">
            
            <h3 style="margin-bottom: 25px;"><i class="fas fa-shipping-fast" style="color: var(--primary-brown);"></i> Delivery Information</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="text" id="billing_mobile" class="form-control" placeholder="9876543210" required>
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" id="billing_city" class="form-control" placeholder="Mumbai" required>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Full Address</label>
                    <textarea id="billing_address" class="form-control" rows="3" placeholder="Flat, House no, Building, Street, Area" required></textarea>
                </div>
            </div>

            <h3 style="margin-bottom: 25px;"><i class="fas fa-credit-card" style="color: var(--primary-brown);"></i> Payment Method</h3>
            <div style="background: #fdfdfd; padding: 25px; border: 1.5px solid var(--skin-nude); border-radius: 15px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <img src="https://razorpay.com/assets/razorpay-glyph.svg" style="height: 30px; vertical-align: middle; margin-right: 15px;">
                    <span style="font-weight: 700;">Razorpay Secure Payment</span>
                </div>
                <div style="color: #4CAF50; font-size: 0.8rem; font-weight: 700;">
                    <i class="fas fa-check-circle"></i> SELECTED
                </div>
            </div>
            <p style="font-size: 0.8rem; color: var(--text-light); margin-top: 15px;">You will be redirected to Razorpay to complete the payment via UPI, Card, or Netbanking.</p>
        </div>

        <!-- Right: Order Summary -->
        <div>
            <div style="background: var(--beige-accent); padding: 30px; border-radius: 20px; position: sticky; top: 100px;">
                <h3 style="margin-bottom: 25px;">Order Summary</h3>
                <div style="max-height: 250px; overflow-y: auto; margin-bottom: 20px; padding-right: 10px;">
                    <?php foreach ($products as $p): ?>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.9rem;">
                            <span><?php echo $_SESSION['cart'][$p['id']]; ?>x <?php echo $p['name']; ?></span>
                            <span style="font-weight: 600;">$<?php echo number_format($p['price'] * $_SESSION['cart'][$p['id']], 2); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 1.3rem; font-weight: 700;">
                    <span>Total</span>
                    <span style="color: var(--primary-brown);">$<?php echo number_format($total, 2); ?></span>
                </div>

                <!-- RAZORPAY BUTTON -->
                <button id="rzp-button1" class="btn btn-primary" style="width: 100%; margin-top: 10px; padding: 20px; font-size: 1.1rem; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i class="fas fa-lock"></i> Securely Pay ₹<?php echo number_format($totalINR, 2); ?>
                </button>
                
                <img src="https://cdn0.iconfinder.com/data/icons/payment-method-1/64/_visa-512.png" style="height: 25px; margin: 20px auto 0; display: block; opacity: 0.6;">
            </div>
        </div>
    </div>
</div>

<!-- Razorpay Checkout Library -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('rzp-button1').onclick = function(e){
    const address = document.getElementById('billing_address').value;
    const mobile = document.getElementById('billing_mobile').value;
    
    if(!address || !mobile) {
        alert("Please fill shipping details first!");
        return;
    }

    var options = {
        "key": "<?php echo RAZORPAY_KEY_ID; ?>", // Enter the Key ID generated from the Dashboard
        "amount": "<?php echo $totalINR * 100; ?>", // Amount in paise
        "currency": "INR",
        "name": "GreenBulk Nutrition",
        "description": "Premium Supplements Purchase",
        "image": "https://img.icons8.com/clouds/100/leaf.png",
        "handler": function (response){
            // Success handler
            window.location.href = `verify-payment.php?order_id=<?php echo time(); ?>&payment_id=${response.razorpay_payment_id}&total=<?php echo $total; ?>`;
        },
        "prefill": {
            "name": "<?php echo $_SESSION['user_name']; ?>",
            "email": "<?php echo $_SESSION['user_email'] ?? 'customer@example.com'; ?>",
            "contact": mobile
        },
        "theme": {
            "color": "#6F4E37"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
}
</script>

<?php include 'includes/footer.php'; ?>
