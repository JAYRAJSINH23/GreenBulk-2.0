<?php
require_once 'includes/db.php';
include 'includes/header.php';

// Fetch User Wishlist IDs if logged in
$wishlistIds = [];
if(isset($_SESSION['user_id'])) {
    $wishStmt = $pdo->prepare("SELECT product_id FROM wishlist WHERE user_id = ?");
    $wishStmt->execute([$_SESSION['user_id']]);
    $wishlistIds = $wishStmt->fetchAll(PDO::FETCH_COLUMN);
}

// Fetch Featured Products
try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 8");
    $featuredProducts = $stmt->fetchAll();
} catch (Exception $e) {
    $featuredProducts = [];
}
?>

<!-- PREMIUM HERO SLIDER (Responsive) -->
<div class="hero-slider">
    <div class="slides">
        <div class="slide active" style="background-image: url('assets/images/image%201.jpeg');">
            <div class="container h-100 d-flex align-items-center">
                <div class="hero-content text-start">
                    <span class="badge mb-3">GreenBulk Nutrition</span>
                    <h1 class="display-3 fw-bold">Pure <br><span style="color: var(--skin-nude);">Excellence.</span></h1>
                    <p class="lead mb-4">Clean nutrition for the elite athlete. Lab tested, Zero fillers.</p>
                    <a href="products.php" class="btn btn-primary btn-lg px-5 rounded-pill shadow">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="slide" style="background-image: url('assets/images/image%202.jpeg');">
            <div class="container h-100 d-flex align-items-center">
                <div class="hero-content text-start">
                    <h1>Nitro Whey <span style="color: var(--skin-nude);">Isolate</span></h1>
                    <p class="lead mb-4">Maximum absorption. Minimum bloating. Only Pure Gains.</p>
                    <a href="products.php?category=Proteins" class="btn btn-primary btn-lg px-5 rounded-pill shadow">Try Isolate</a>
                </div>
            </div>
        </div>
        <div class="slide" style="background-image: url('assets/images/image%203.jpeg');">
            <div class="container h-100 d-flex align-items-center">
                <div class="hero-content text-start text-white">
                    <h1>Strength <span style="color: var(--skin-nude);">Unleashed</span></h1>
                    <p class="lead mb-4">Quality creatine for raw power and endurance.</p>
                    <a href="products.php?category=Creatines" class="btn btn-primary btn-lg px-5 rounded-pill shadow">Shop Creatine</a>
                </div>
            </div>
        </div>
        <div class="slide" style="background-image: url('assets/images/image%204.jpg');">
            <div class="container h-100 d-flex align-items-center">
                <div class="hero-content text-start text-white">
                    <h1>Elite <br><span style="color: var(--skin-nude);">Apparel.</span></h1>
                    <p class="lead mb-4">Look good, train harder. Premium gym wear.</p>
                    <a href="products.php?category=Gym Clothes" class="btn btn-primary btn-lg px-5 rounded-pill shadow">Explore Apparel</a>
                </div>
            </div>
        </div>
        <div class="slide" style="background-image: url('assets/images/image%205.jpg');">
            <div class="container h-100 d-flex align-items-center">
                <div class="hero-content text-start text-white">
                    <h1>GreenBulk <br><span style="color: var(--skin-nude);">Community.</span></h1>
                    <p class="lead mb-4">Join thousands of athletes worldwide. Shared goals, pure nutrition.</p>
                    <a href="register.php" class="btn btn-primary btn-lg px-5 rounded-pill shadow">Join Now</a>
                </div>
            </div>
        </div>
    </div>
    <div class="slider-nav">
        <button class="prev"><i class="fas fa-chevron-left"></i></button>
        <button class="next"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>

<!-- SHOP BY CATEGORY -->
<section class="container py-5 text-center">
    <div class="mb-5">
        <h2 class="fw-bold">Shop By <span style="color: var(--primary-brown);">Category</span></h2>
        <div class="divider mx-auto"></div>
    </div>
    <div class="row g-4 justify-content-center">
        <?php 
        $cats = [
            ['name' => 'Proteins', 'icon' => 'fa-dna'],
            ['name' => 'Creatines', 'icon' => 'fa-flask'],
            ['name' => 'Preworkout', 'icon' => 'fa-bolt'],
            ['name' => 'Fit Foods', 'icon' => 'fa-apple-alt'],
            ['name' => 'Accessories', 'icon' => 'fa-shaker'],
            ['name' => 'Gym Clothes', 'icon' => 'fa-tshirt']
        ];
        foreach($cats as $c): ?>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="products.php?category=<?php echo $c['name']; ?>" class="cat-item text-decoration-none text-dark d-block">
                    <div class="circle-cat mx-auto">
                        <i class="fas <?php echo $c['icon']; ?>"></i>
                    </div>
                    <h6 class="fw-bold mt-2"><?php echo $c['name']; ?></h6>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- AMBEDKAR JAYANTI ROLLER -->
<div class="offer-roller">
    <div class="roller-text">
        <span>🎉 CELEBRATING AMBEDKAR JAYANTI! GET EXTRA 20% FLAT OFF ON ALL PROTEINS & CREATINES! USE CODE: <strong style="color: #ffeb3b;">AMBEDKAR20</strong> ⚡</span>
        <span>🎉 LIMITED TIME OFFER - FUEL YOUR AMBITION WITH GREENBULK ⚡</span>
    </div>
</div>

<!-- BRAND STORY -->
<section class="container my-5">
    <div class="brand-story row align-items-center justify-content-center m-0 shadow">
        <div class="col-lg-10 text-center py-5">
            <span class="text-uppercase fw-bold ls-2" style="color: var(--skin-nude);">Our Philosophy</span>
            <h2 class="display-4 fw-bold mt-3">Stronger Every Day.</h2>
            <p class="lead mb-4">GreenBulk isn't just a supplement company. We are a community of athletes who believe in clean, transparent, and lab-tested nutrition.</p>
            <a href="about.php" class="btn btn-outline-light border-2 px-5 py-3 rounded-pill fw-bold text-decoration-none">Our Mission</a>
        </div>
    </div>
</section>

<!-- NEW ARRIVALS GRID -->
<section class="container py-5 text-center">
    <div class="mb-5">
        <h2 class="fw-bold">New <span style="color: var(--primary-brown);">Arrivals</span></h2>
        <div class="divider mx-auto"></div>
    </div>
    <div class="row g-4 justify-content-center">
        <?php foreach($featuredProducts as $index => $product): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                <div class="product-card w-100 shadow-sm border-0">
                    <?php if($index < 2): ?>
                        <div class="product-badge badge-new">New</div>
                    <?php endif; ?>
                    
                    <!-- WISHLIST HEART ICON -->
                    <button class="wishlist-btn-card <?php echo in_array($product['id'], $wishlistIds) ? 'active' : ''; ?>" 
                            onclick="toggleWishlist(<?php echo $product['id']; ?>, this)">
                        <i class="<?php echo in_array($product['id'], $wishlistIds) ? 'fas' : 'far'; ?> fa-heart"></i>
                    </button>

                    <div class="card-img-container">
                        <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                        <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="quick-view">Details</a>
                    </div>
                    <div class="card-content">
                        <div class="meta mb-2 small opacity-75 text-uppercase">
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
    </div>
</section>

<!-- TRUST SECTION -->
<section class="bg-light py-5">
    <div class="container overflow-hidden">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <i class="fas fa-certificate fa-3x mb-3 text-primary"></i>
                    <h5 class="fw-bold">100% Authentic</h5>
                    <p class="small text-muted mb-0">Direct from certified global labs.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <i class="fas fa-flask-vial fa-3x mb-3 text-primary"></i>
                    <h5 class="fw-bold">Purity Guaranteed</h5>
                    <p class="small text-muted mb-0">Zero additives, Zero hidden sugars.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <i class="fas fa-rocket fa-3x mb-3 text-primary"></i>
                    <h5 class="fw-bold">Express Shipping</h5>
                    <p class="small text-muted mb-0">Dispatched within 12 hours of order.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="container py-5 mb-5">
    <div class="bg-dark text-white p-5 rounded-5 shadow-lg row align-items-center m-0" style="background: var(--primary-brown) !important;">
        <div class="col-lg-7 mb-4 mb-lg-0 text-center text-lg-start">
            <h2 class="display-5 fw-bold mb-2">Join the Elite Club</h2>
            <p class="lead opacity-75 mb-0">Get exclusive deals and fitness insights.</p>
        </div>
        <div class="col-lg-5">
            <div class="input-group">
                <input type="email" class="form-control border-0 rounded-pill-start py-3 px-4" placeholder="Email address...">
                <button class="btn btn-warning fw-bold px-4 rounded-pill-end shadow" style="background: var(--skin-nude); border:none; color: var(--primary-brown);">JOIN</button>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
