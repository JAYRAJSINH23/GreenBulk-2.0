/**
 * GreenBulk Core Utility & Shared Logic
 */

const API_BASE_URL = 'http://localhost/GreenBulk/backend/api'; 

// Protocol Check for Development
if (window.location.protocol === 'file:') {
    console.warn("GreenBulk: Browsers block fetch requests from 'file://' to 'http://'. Please run this project via a local server (e.g. Apache in XAMPP) for products to load.");
}

document.addEventListener('DOMContentLoaded', () => {
    initApp();
});

function initApp() {
    updateCartCount();
    checkAuthStatus();
    
    // Load featured products if we are on the homepage
    const featuredContainer = document.getElementById('featured-products-container');
    if (featuredContainer) {
        loadFeaturedProducts(featuredContainer);
    }

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const nav = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });
}

/**
 * Product Logic
 */
async function loadFeaturedProducts(container) {
    try {
        const response = await fetch(`${API_BASE_URL}/get_products.php`);
        const result = await response.json();

        if (result.status === 'success') {
            const products = result.data.slice(0, 3); // Just show top 3 on home
            container.innerHTML = products.map(product => renderProductCard(product)).join('');
        } else {
            container.innerHTML = `<div class="col-12 text-center text-danger">Failed to load products.</div>`;
        }
    } catch (error) {
        console.error('Error fetching products:', error);
        container.innerHTML = `
            <div class="col-12 text-center p-5">
                <i class="fa-solid fa-circle-exclamation text-danger fa-3x mb-3"></i>
                <h3 class="text-danger">CONNECTION ERROR</h3>
                <p class="text-muted">Ensure your XAMPP Apache and MySQL are running.</p>
                <div class="alert alert-warning d-inline-block small mt-3">
                    <b>Tip:</b> If you are opening index.html as a file, the browser will block the data. <br>
                    Please use <code>http://localhost/GreenBulk/frontend/index.html</code> instead.
                </div>
            </div>
        `;
    }
}

function renderProductCard(product) {
    return `
        <div class="col-md-4">
            <div class="product-card">
                <div class="product-image-wrapper">
                    <img src="${product.image_url}" alt="${product.name}" class="img-fluid" onerror="this.src='https://placehold.co/400x400?text=${encodeURIComponent(product.name)}'">
                </div>
                <div class="card-content">
                    <span class="badge-premium mb-2 d-inline-block">${product.category}</span>
                    <h3 class="fs-5 mb-2">${product.name}</h3>
                    <p class="text-muted text-truncate">${product.description}</p>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <span class="fs-4 fw-bold text-primary">₹${parseFloat(product.price).toLocaleString('en-IN')}</span>
                        <button onclick="addToCart(${product.id}, '${product.name}', ${product.price}, '${product.image_url}')" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-plus me-2"></i>ADD
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
}

/**
 * Cart Logic (localStorage)
 */
function addToCart(id, name, price, image) {
    let cart = JSON.parse(localStorage.getItem('gb_cart')) || [];
    
    const existingIndex = cart.findIndex(item => item.id === id);
    if (existingIndex > -1) {
        cart[existingIndex].quantity += 1;
    } else {
        cart.push({ id, name, price, image, quantity: 1 });
    }
    
    localStorage.setItem('gb_cart', JSON.stringify(cart));
    updateCartCount();
    
    // Simple toast notification (using alert for now or basic feedback)
    showToast(`${name} added to cart!`);
}

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('gb_cart')) || [];
    const count = cart.reduce((total, item) => total + item.quantity, 0);
    const badge = document.getElementById('cart-count');
    if (badge) badge.innerText = count;
}

/**
 * Auth Logic
 */
function checkAuthStatus() {
    const user = JSON.parse(localStorage.getItem('gb_user'));
    const authLinks = document.getElementById('auth-links');
    
    if (user && authLinks) {
        authLinks.innerHTML = `
            <div class="dropdown">
                <button class="btn btn-outline btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-user me-2"></i>${user.name.split(' ')[0]}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="orders.html">My Orders</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#" onclick="logout()">Logout</a></li>
                </ul>
            </div>
        `;
    }
}

function logout() {
    localStorage.removeItem('gb_user');
    window.location.reload();
}

/**
 * Helpers
 */
function showToast(message) {
    // Basic implementation - can be replaced with Bootstrap Toasts
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 p-3';
    toast.style.zIndex = '1060';
    toast.innerHTML = `
        <div class="toast d-block show align-items-center text-white bg-accent border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
