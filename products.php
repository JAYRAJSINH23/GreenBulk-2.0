<?php
require_once 'includes/db.php';
include 'includes/header.php';

$category = $_GET['category'] ?? null;
$search = $_GET['q'] ?? null;

// Fetch User Wishlist IDs if logged in
$wishlistIds = [];
if(isset($_SESSION['user_id'])) {
    $wishStmt = $pdo->prepare("SELECT product_id FROM wishlist WHERE user_id = ?");
    $wishStmt->execute([$_SESSION['user_id']]);
    $wishlistIds = $wishStmt->fetchAll(PDO::FETCH_COLUMN);
}

try {
    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];
    if ($category) {
        $sql .= " AND category = :category";
        $params['category'] = $category;
    }
    if ($search) {
        $sql .= " AND (name LIKE :search OR description LIKE :search)";
        $params['search'] = "%$search%";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();
} catch (Exception $e) {
    $products = [];
}
?>

<div class="container py-5">
    <div class="row g-5">
        <!-- Sidebar Filter (Centered look) -->
        <aside class="col-lg-3 d-none d-lg-block text-center text-lg-start">
            <div class="bg-light p-4 rounded-4 sticky-top shadow-sm" style="top: 100px; border: 1px solid #eee;">
                <h4 class="fw-bold mb-4 border-bottom pb-3">Categories</h4>
                <div class="nav flex-column gap-2">
                    <a href="products.php" class="nav-link p-2 px-3 rounded-pill d-flex justify-content-between align-items-center <?php echo !$category ? 'bg-primary text-white' : 'text-dark hover-effect'; ?>">
                        <span>All Collections</span> <i class="fas fa-chevron-right small opacity-50"></i>
                    </a>
                    <?php 
                    $navCats = ['Proteins', 'Creatines', 'Preworkout', 'Fit Foods', 'Accessories', 'Gym Clothes'];
                    foreach($navCats as $nc): ?>
                        <a href="products.php?category=<?php echo $nc; ?>" class="nav-link p-2 px-3 rounded-pill d-flex justify-content-between align-items-center <?php echo $category == $nc ? 'bg-primary text-white shadow-sm' : 'text-dark hover-effect'; ?>">
                            <span><?php echo $nc; ?></span> <i class="fas fa-chevron-right small opacity-50"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </aside>

        <!-- Product Listing -->
        <div class="col-lg-9">
            <div class="text-center text-lg-start mb-5">
                <h1 class="display-5 fw-bold"><?php echo $category ?: 'Explore Supplements'; ?></h1>
                <p class="text-muted">High-performance nutrition curated for the elite. (<?php echo count($products); ?> items)</p>
                <div class="divider ms-lg-0 mx-auto"></div>
            </div>

            <div class="row g-4 justify-content-center">
                <?php if(empty($products)): ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-search fa-4x text-muted mb-3 opacity-25"></i>
                        <h3>Empty Results</h3>
                        <p class="text-muted">Try adjusting your filters.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($products as $product): ?>
                        <div class="col-12 col-sm-6 col-md-4 d-flex">
                            <div class="product-card h-100 mb-0 shadow-sm border-0 w-100">
                                <!-- WISHLIST HEART ICON -->
                                <button class="wishlist-btn-card <?php echo in_array($product['id'], $wishlistIds) ? 'active' : ''; ?>" 
                                        onclick="toggleWishlist(<?php echo $product['id']; ?>, this)">
                                    <i class="<?php echo in_array($product['id'], $wishlistIds) ? 'fas' : 'far'; ?> fa-heart"></i>
                                </button>

                                <div class="card-img-container rounded-top-4">
                                    <img src="<?php echo $product['image_url'] ?? 'assets/images/placeholder.jpg'; ?>" alt="<?php echo $product['name']; ?>">
                                    <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="quick-view">Shop Now</a>
                                </div>
                                <div class="card-content text-center">
                                    <div class="meta text-uppercase mb-2 small opacity-75 fw-bold">
                                        <span><?php echo $product['category']; ?></span>
                                    </div>
                                    <h6 class="card-title fw-bold mb-3"><?php echo $product['name']; ?></h6>
                                    <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top">
                                        <span class="h6 fw-bold m-0 text-primary">$<?php echo number_format($product['price'], 2); ?></span>
                                        <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="btn-buy-pill shadow-sm py-1 px-3">
                                            <i class="fas fa-shopping-bag small"></i> Buy
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
