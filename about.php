<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="container py-5 mt-4">
    <div class="row g-5 align-items-center">
        <div class="col-lg-6">
            <h1 class="display-3 fw-bold mb-4">Purely <br><span style="color: var(--primary-brown);">Driven.</span></h1>
            <p class="lead text-muted mb-4">Founded in 2024, GreenBulk started with a simple mission: to eliminate the "guesswork" from performance nutrition.</p>
            <p class="text-muted mb-5 lh-lg">We believe that every athlete, from the weekender to the professional, deserves access to clean, lab-tested, and organic supplements. Our products are formulated in clinical settings and tested by elite strength coaches to ensure they actually work.</p>
            
            <div class="row g-4 mb-5">
                <div class="col-6">
                    <h2 class="fw-bold mb-0">100+</h2>
                    <p class="small fw-bold text-uppercase text-primary">Certified Labs</p>
                </div>
                <div class="col-6">
                    <h2 class="fw-bold mb-0">50K+</h2>
                    <p class="small fw-bold text-uppercase text-primary">Happy Athletes</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="rounded-5 overflow-hidden shadow-lg border">
                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800" class="img-fluid" alt="Our Story">
            </div>
        </div>
    </div>
</div>

<div class="bg-light py-5 mt-5">
    <div class="container py-5 text-center">
        <h2 class="fw-bold mb-5">Our Core <span style="color: var(--primary-brown);">Values</span></h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-5 bg-white rounded-5 shadow-sm h-100 border border-light">
                    <i class="fas fa-eye fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Transparency</h5>
                    <p class="small text-muted mb-0">Full label disclosure. No proprietary blends. You know exactly what's inside.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-5 bg-white rounded-5 shadow-sm h-100 border border-light">
                     <i class="fas fa-vial fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Lab Tested</h5>
                    <p class="small text-muted mb-0">Every batch is tested for heavy metals and purity before it leaves our facility.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-5 bg-white rounded-5 shadow-sm h-100 border border-light">
                    <i class="fas fa-leaf fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">100% Organic</h5>
                    <p class="small text-muted mb-0">Naturally sourced ingredients with zero artificial sweeteners or dyes.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
