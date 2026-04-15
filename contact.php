<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold">Get In <span style="color: var(--primary-brown);">Touch</span></h1>
                <p class="text-muted">Have questions about our products? We're here to help you reach your goals.</p>
                <div class="divider mx-auto"></div>
            </div>

            <div class="row g-5 align-items-stretch">
                <!-- Info Cards -->
                <div class="col-lg-5">
                    <div class="bg-primary p-5 rounded-5 text-white h-100 shadow-lg" style="background: var(--primary-brown) !important;">
                        <h4 class="fw-bold mb-4">Contact Information</h4>
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <i class="fas fa-map-marker-alt mt-1"></i>
                            <p class="m-0 small opacity-75">Bright Nutricare, Sector-14, Mehrauli Gurgaon Road, Gurugram, Haryana-122001</p>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <i class="fas fa-phone-alt"></i>
                            <p class="m-0 small opacity-75">+91 98765 43210</p>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-5">
                            <i class="fas fa-envelope"></i>
                            <p class="m-0 small opacity-75">support@greenbulk.com</p>
                        </div>

                        <h6 class="fw-bold text-uppercase ls-2 mb-3 small">Social Connect</h6>
                        <div class="d-flex gap-3">
                            <a href="#" class="btn btn-outline-light rounded-circle border-0 bg-white-50" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-outline-light rounded-circle border-0 bg-white-50" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-outline-light rounded-circle border-0 bg-white-50" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="bg-white p-5 rounded-5 border shadow-sm">
                        <form action="#" class="row g-4 text-center text-lg-start">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" class="form-control rounded-pill border-0 bg-light p-3 px-4" placeholder="Your Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control rounded-pill border-0 bg-light p-3 px-4" placeholder="Email@example.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Message Subject</label>
                                <input type="text" class="form-control rounded-pill border-0 bg-light p-3 px-4" placeholder="How can we help?">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Your Message</label>
                                <textarea class="form-control rounded-4 border-0 bg-light p-4" rows="5" placeholder="Tell us more..."></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">SEND MESSAGE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
