<?php
require_once 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=wishlist.php");
    exit();
}

$userId = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT p.* FROM products p JOIN wishlist w ON p.id = w.product_id WHERE w.user_id = ? ORDER BY w.created_at DESC");
    $stmt->execute([$userId]);
    $wishlistItems = $stmt->fetchAll();
} catch (Exception $e) {
    $wishlistItems = [];
}
?>

<div class="container py-5 mt-4 text-center text-lg-start">
    <div class="mb-5 text-center">
        <h1 class="display-4 fw-bold">My <span style="color: var(--primary-brown);">Wishlist</span></h1>
        <p class="text-muted lead">Your curated collection of premium nutrition essentials.</p>
        <div class="divider mx-auto"></div>
    </div>

    <div class="row g-4 justify-content-center">
        <?php if (empty($wishlistItems)): ?>
            <div class="col-12 text-center py-5">
                <div class="mb-4">
                    <i class="far fa-heart fa-5x text-muted opacity-25"></i>
                </div>
                <h3>Your wishlist is empty</h3>
                <p class="text-muted mb-4">Save products you're interested in for later.</p>
                <a href="products.php" class="btn btn-primary btn-lg rounded-pill px-5 shadow">Explore Products</a>
            </div>
        <?php else: ?>
            <?php foreach ($wishlistItems as $product): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex" id="wish-item-<?php echo $product['id']; ?>">
                    <div class="product-card h-100 mb-0 shadow-sm border-0 w-100">
                        <!-- REMOVE BUTTON -->
                        <button class="wishlist-btn-card active" onclick="removeFromWishlist(<?php echo $product['id']; ?>, this)">
                            <i class="fas fa-times"></i>
                        </button>

                        <div class="card-img-container">
                            <img src="<?php echo $product['image_url'] ?? 'assets/images/placeholder.jpg'; ?>" alt="<?php echo $product['name']; ?>">
                            <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="quick-view">Shop Now</a>
                        </div>
                        <div class="card-content text-center">
                            <div class="meta text-uppercase mb-2 small opacity-75 fw-bold">
                                <span><?php echo $product['category']; ?></span>
                            </div>
                            <h6 class="card-title fw-bold mb-3"><?php echo $product['name']; ?></h6>
                            <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top">
                                <span class="h5 fw-bold m-0" style="color: var(--primary-brown);">$<?php echo number_format($product['price'], 2); ?></span>
                                <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="btn-buy-pill shadow-sm">
                                    <i class="fas fa-shopping-bag me-1"></i> Buy
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
function removeFromWishlist(productId, btn) {
    if(confirm('Remove this item from your wishlist?')) {
        fetch('ajax/toggle-wishlist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'product_id=' + productId
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'removed') {
                const item = document.getElementById('wish-item-' + productId);
                item.style.transition = '0.5s';
                item.style.opacity = '0';
                item.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    item.remove();
                    if(document.querySelectorAll('.product-card').length === 0) {
                        location.reload();
                    }
                }, 500);
            }
        });
    }
}
</script>

<?php include 'includes/footer.php'; ?>
