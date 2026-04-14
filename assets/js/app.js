document.addEventListener('DOMContentLoaded', () => {
    // 1. LOADER
    const loader = document.querySelector('.loader-wrapper');
    if (loader) {
        setTimeout(() => {
            loader.style.opacity = '0';
            setTimeout(() => loader.remove(), 500);
        }, 800);
    }

    // 2. USER DROPDOWN (CLICK BASED)
    const userBtn = document.getElementById('userBtn');
    const dropdownList = document.getElementById('dropdownList');

    if (userBtn && dropdownList) {
        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownList.classList.toggle('show');
        });

        // Close when clicking outside
        document.addEventListener('click', () => {
            dropdownList.classList.remove('show');
        });

        // Prevent closing when clicking inside
        dropdownList.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }

    // 3. HERO SLIDER
    const slides = document.querySelectorAll('.slide');
    const nextBtn = document.querySelector('.slider-nav .next');
    const prevBtn = document.querySelector('.slider-nav .prev');
    let currentSlide = 0;
    let slideInterval;

    if (slides.length > 0) {
        const showSlide = (n) => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (n + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
        };

        const nextSlide = () => showSlide(currentSlide + 1);
        const prevSlide = () => showSlide(currentSlide - 1);

        if (nextBtn) nextBtn.addEventListener('click', () => {
            nextSlide();
            resetInterval();
        });
        
        if (prevBtn) prevBtn.addEventListener('click', () => {
            prevSlide();
            resetInterval();
        });

        const resetInterval = () => {
            clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, 3000);
        };

        slideInterval = setInterval(nextSlide, 3000);
    }

    // 4. ANIMATE ON SCROLL (SUBTLE)
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.product-card, .trust-item, .strip-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 1s ease-out';
        observer.observe(el);
    });
});

// GLOBAL WISHLIST TOGGLE
function toggleWishlist(productId, btn) {
    fetch('ajax/toggle-wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'product_id=' + productId
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'added') {
            btn.classList.add('active');
            const icon = btn.querySelector('i');
            if(icon) icon.className = 'fas fa-heart';
        } else if(data.status === 'removed') {
            btn.classList.remove('active');
            const icon = btn.querySelector('i');
            if(icon) icon.className = 'far fa-heart';
        } else if(data.status === 'login') {
            window.location.href = 'login.php';
        }
    })
    .catch(err => console.error('Error:', err));
}
