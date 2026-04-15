<?php
require_once 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$msg = "";

// Handle Update
if (isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    try {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$name, $email, $userId]);
        $_SESSION['name'] = $name;
        $_SESSION['user_email'] = $email;
        $msg = "<div class='alert alert-success rounded-pill px-4'>Profile updated successfully!</div>";
    } catch (Exception $e) {
        $msg = "<div class='alert alert-danger rounded-pill px-4'>Error: Email already exists or connection failed.</div>";
    }
}

// Fetch current info
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();
?>

<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-white shadow rounded-5 overflow-hidden border">
                <div class="row g-0">
                    <!-- Sidebar info -->
                    <div class="col-md-4 p-5 d-flex flex-column align-items-center justify-content-center text-center text-white" style="background: var(--primary-brown);">
                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center mb-4 shadow" style="width: 120px; height: 120px; font-size: 3.5rem; color: var(--primary-brown) !important;">
                            <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                        </div>
                        <h2 class="fw-bold mb-1"><?php echo $user['name']; ?></h2>
                        <span class="badge bg-light text-dark mb-4 px-3 py-1 rounded-pill">Premium Member</span>
                        
                        <div class="w-100 mt-2 border-top border-light pt-4 opacity-75 small fw-bold text-uppercase ls-1">
                            <p class="mb-2"><i class="fas fa-calendar-check me-2"></i> Member since <?php echo date('M Y', strtotime($user['created_at'])); ?></p>
                            <p class="mb-0"><i class="fas fa-shopping-bag me-2"></i> Shopping with G-Bulk</p>
                        </div>
                    </div>

                    <!-- Main Form -->
                    <div class="col-md-8 p-5">
                        <div class="mb-5 d-flex justify-content-between align-items-center">
                            <h2 class="fw-bold m-0 text-center text-md-start">Profile Settings</h2>
                            <i class="fas fa-cog text-muted opacity-25 fa-2x"></i>
                        </div>

                        <?php echo $msg; ?>

                        <form action="profile.php" method="POST" class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control rounded-pill border-0 shadow-sm p-3" value="<?php echo $user['name']; ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control rounded-pill border-0 shadow-sm p-3" value="<?php echo $user['email']; ?>" required>
                            </div>
                            <div class="col-12 mt-5">
                                <button type="submit" name="update_profile" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">
                                    SAVE PROFILE CHANGES
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 border-top pt-5">
                            <h5 class="fw-bold mb-4">Quick Links</h5>
                            <div class="row g-3">
                                <div class="col-6 col-md-4">
                                    <a href="orders.php" class="btn btn-light w-100 text-decoration-none py-3 rounded-4 shadow-sm border border-secondary-subtle">
                                        <i class="fas fa-box d-block mb-1 text-primary"></i> My Orders
                                    </a>
                                </div>
                                <div class="col-6 col-md-4">
                                    <a href="wishlist.php" class="btn btn-light w-100 text-decoration-none py-3 rounded-4 shadow-sm border border-secondary-subtle">
                                        <i class="fas fa-heart d-block mb-1 text-danger"></i> Wishlist
                                    </a>
                                </div>
                                <div class="col-6 col-md-4 mx-auto">
                                    <a href="logout.php" class="btn btn-light w-100 text-decoration-none py-3 rounded-4 shadow-sm border border-secondary-subtle">
                                        <i class="fas fa-sign-out-alt d-block mb-1 text-dark"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
