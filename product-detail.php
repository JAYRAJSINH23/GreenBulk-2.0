<?php
require_once 'includes/db.php';
include 'includes/header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: products.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    
    if (!$product) {
        die("Product not found.");
    }
} catch (Exception $e) {
    die("Error fetching product.");
}

// Check if in wishlist
$inWishlist = false;
if(isset($_SESSION['user_id'])) {
    $checkWish = $pdo->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
    $checkWish->execute([$_SESSION['user_id'], $id]);
    $inWishlist = $checkWish->fetch();
}
?>

<div class="container py-5 mt-4">
    <div class="row g-5 align-items-start">
        <!-- Product Image -->
        <div class="col-lg-5 text-center">
            <div class="p-5 rounded-5 shadow-sm overflow-hidden" style="background: var(--beige-accent); min-height: 500px; display: flex; align-items: center; justify-content: center; position: relative;">
                <img src="<?php echo $product['image_url'] ?? 'assets/images/placeholder.jpg'; ?>" class="img-fluid" style="max-height: 400px; transform: scale(1); transition: 0.5s;" id="mainProductImg">
                <div class="position-absolute top-0 end-0 p-3">
                     <span class="badge bg-white text-dark shadow-sm border px-3 py-2 rounded-pill">100% Genuine</span>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-7">
            <div class="ps-lg-4 text-center text-lg-start">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center justify-content-lg-start mb-3">
                        <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="products.php?category=<?php echo $product['category']; ?>" class="text-decoration-none text-muted"><?php echo $product['category']; ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $product['name']; ?></li>
                    </ol>
                </nav>

                <h1 class="display-4 fw-bold mb-3"><?php echo $product['name']; ?></h1>
                
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-3 mb-4">
                    <span class="h1 fw-bold m-0" style="color: var(--primary-brown);">$<?php echo number_format($product['price'], 2); ?></span>
                    <div class="vr mx-2 d-none d-sm-block"></div>
                    <div class="text-warning h5 m-0">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <span class="text-muted small fw-normal ms-2">(125 Reviews)</span>
                    </div>
                </div>

                <p class="lead text-muted mb-5 lh-lg"><?php echo $product['description'] ?? 'Pure clinical strength nutrition for high-intensity training. This product is engineered for zero bloating and maximum muscle synthesis.'; ?></p>
                
                <!-- ACTIONS ROW -->
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start align-items-center">
                    <form action="cart.php" method="POST" class="d-flex gap-3">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="action" value="add">
                        
                        <!-- Fixed Quantity Selector -->
                        <div class="input-group" style="width: 140px; border: 1.5px solid #ddd; border-radius: 50px; overflow: hidden; height: 55px;">
                            <button type="button" class="btn btn-link text-decoration-none text-dark border-0 px-3" onclick="this.nextElementSibling.stepDown()"><i class="fas fa-minus"></i></button>
                            <input type="number" name="quantity" value="1" min="1" class="form-control text-center border-0 fw-bold" style="box-shadow: none;">
                            <button type="button" class="btn btn-link text-decoration-none text-dark border-0 px-3" onclick="this.previousElementSibling.stepUp()"><i class="fas fa-plus"></i></button>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill fw-bold shadow-sm" style="height: 55px;">
                            <i class="fas fa-shopping-bag me-2"></i> ADD TO CART
                        </button>
                    </form>

                    <!-- WISHLIST BUTTON -->
                    <button class="btn btn-outline-danger btn-lg rounded-circle d-flex align-items-center justify-content-center <?php echo $inWishlist ? 'active bg-danger text-white' : ''; ?>" 
                            style="width: 55px; height: 55px;" 
                            onclick="toggleWishlist(<?php echo $product['id']; ?>, this)">
                        <i class="<?php echo $inWishlist ? 'fas' : 'far'; ?> fa-heart"></i>
                    </button>
                </div>

                <div class="row g-4 mt-5 pt-4 border-top">
                    <div class="col-4 text-center">
                        <div class="bg-light p-3 rounded-4">
                            <i class="fas fa-rotate text-primary fa-lg mb-2 d-xl-block"></i>
                            <span class="small fw-bold">Free Returns</span>
                        </div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="bg-light p-3 rounded-4">
                            <i class="fas fa-microscope text-primary fa-lg mb-2 d-xl-block"></i>
                            <span class="small fw-bold">Lab Verified</span>
                        </div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="bg-light p-3 rounded-4">
                            <i class="fas fa-bolt text-primary fa-lg mb-2 d-xl-block"></i>
                            <span class="small fw-bold">Fast Delivery</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABS -->
    <div class="mt-5 pt-5">
        <ul class="nav nav-pills mb-4 justify-content-center gap-2" id="pills-tab" role="tablist">
            <li class="nav-item"><button class="nav-link active rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#p-desc" type="button">Description</button></li>
            <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#p-nutri" type="button">Nutrition</button></li>
            <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#p-seller" type="button">Seller Info</button></li>
        </ul>
        <div class="tab-content border rounded-5 p-4 bg-white shadow-sm" id="pills-tabContent">
            <div class="tab-pane fade show active" id="p-desc" role="tabpanel">
                <p class="lead mb-0 p-lg-4 text-muted"><?php echo $product['description']; ?> Engineered for peak performance, our formula ensures rapid nutrient delivery to muscle tissues for optimal results and minimal fatigue recovery time.</p>
            </div>
            <div class="tab-pane fade" id="p-nutri" role="tabpanel">
                <div class="mx-auto py-4" style="max-width: 400px;">
                    <h3 class="fw-bold border-bottom border-dark border-4 pb-2">Supplement Facts</h3>
                    <div class="d-flex justify-content-between py-2 border-bottom"><span>Serving Size: 1 Scoop</span> <strong>33g</strong></div>
                    <div class="d-flex justify-content-between py-2 border-bottom"><span>Protein</span> <strong>25g</strong></div>
                    <div class="d-flex justify-content-between py-2 border-bottom"><span>Net Carbs</span> <strong>3g</strong></div>
                </div>
            </div>
            <div class="tab-pane fade" id="p-seller" role="tabpanel">
                 <div class="p-lg-4">
                    <h5 class="fw-bold text-primary mb-3">GreenBulk Registered Seller: Bright Nutricare</h5>
                    <p class="text-muted mb-0">Wing C, 2nd Floor, Tower-B, The Presidency, Anamika Enclave, Sector-14, Mehrauli Gurgaon Road, Opposite Govt. Girls College, Gurugram, Haryana-122001</p>
                 </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleWishlist(productId, btn) {
    fetch('ajax/toggle-wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'product_id=' + productId
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'added') {
            btn.classList.add('active', 'bg-danger', 'text-white');
            btn.querySelector('i').className = 'fas fa-heart';
        } else if(data.status === 'removed') {
            btn.classList.remove('active', 'bg-danger', 'text-white');
            btn.querySelector('i').className = 'far fa-heart';
        } else if(data.status === 'login') {
            window.location.href = 'login.php';
        }
    });
}
</script>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
