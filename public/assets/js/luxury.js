/**
 * Maison d'Orient Parfums - Master Client Engine
 * High-performance Vanilla JS, Swiper & Alpine.js bridges for Hostinger shared hosting
 */

document.addEventListener('DOMContentLoaded', () => {
    initHeaderScroll();
    initSwiperSliders();
    initCartDrawer();
    initBackToTop();
    initScentQuiz();
    initDeliveryEstimator();
    initSearchModal();
    initQuickView();
    initPDPGallery();
    initMobileNav();
});

// 1. Header scroll blur
function initHeaderScroll() {
    const header = document.querySelector('.site-header');
    if (!header) return;
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
}

// 2. Swiper Hero & Product Sliders
function initSwiperSliders() {
    // Hero Slider
    if (document.querySelector('.hero-swiper') && typeof Swiper !== 'undefined') {
        new Swiper('.hero-swiper', {
            loop: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 1200,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    }

    // Bestsellers / Featured Collection Carousel
    if (document.querySelector('.bestsellers-swiper') && !document.querySelector('.bestsellers-swiper').swiper && typeof Swiper !== 'undefined') {
        new Swiper('.bestsellers-swiper', {
            slidesPerView: 1.35,
            spaceBetween: 14,
            speed: 800,
            grabCursor: true,
            resistance: true,
            resistanceRatio: 0.75,
            touchRatio: 1.15,
            touchAngle: 45,
            threshold: 4,
            watchSlidesProgress: true,
            lazyPreloadPrevNext: 2,
            pagination: {
                el: '.bestsellers-swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.bestseller-next',
                prevEl: '.bestseller-prev',
            },
            breakpoints: {
                480: { slidesPerView: 1.8, spaceBetween: 16 },
                576: { slidesPerView: 2.2, spaceBetween: 18 },
                768: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 24 }
            }
        });
    }

    // Related Products / You May Also Like Carousel
    if (document.querySelector('.related-products-swiper') && !document.querySelector('.related-products-swiper').swiper && typeof Swiper !== 'undefined') {
        new Swiper('.related-products-swiper', {
            slidesPerView: 1.35,
            spaceBetween: 14,
            speed: 800,
            grabCursor: true,
            resistance: true,
            resistanceRatio: 0.75,
            touchRatio: 1.15,
            touchAngle: 45,
            threshold: 4,
            watchSlidesProgress: true,
            lazyPreloadPrevNext: 2,
            pagination: {
                el: '.related-swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.related-next',
                prevEl: '.related-prev',
            },
            breakpoints: {
                480: { slidesPerView: 1.8, spaceBetween: 16 },
                576: { slidesPerView: 2.2, spaceBetween: 18 },
                768: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 24 }
            }
        });
    }

    // Testimonials Carousel
    if (document.querySelector('.testimonials-swiper') && typeof Swiper !== 'undefined') {
        new Swiper('.testimonials-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            speed: 850,
            grabCursor: true,
            resistance: true,
            resistanceRatio: 0.75,
            watchSlidesProgress: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.testimonials-pagination', clickable: true },
            breakpoints: {
                768: { slidesPerView: 2, spaceBetween: 30 },
                1200: { slidesPerView: 3, spaceBetween: 30 }
            }
        });
    }
}

// 3. Back to Top Button
function initBackToTop() {
    const backBtn = document.getElementById('backToTopBtn');
    if (!backBtn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            backBtn.classList.add('visible');
        } else {
            backBtn.classList.remove('visible');
        }
    });

    backBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// 4. Toast Notification Dispatcher
window.showLuxuryToast = function(message, type = 'success') {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = 'luxury-toast';
    const icon = type === 'success' ? 'fa-gem' : (type === 'info' ? 'fa-compass' : 'fa-bell');
    
    toast.innerHTML = `
        <i class="fas ${icon}" style="color: var(--gold-primary); font-size: 1.1rem;"></i>
        <div>
            <div style="font-family: var(--font-heading); font-size: 0.85rem; font-weight: 700; color: #92400e;">RAVAHA PARFUMS</div>
            <div style="font-size: 0.82rem; color: #1f2937;">${message}</div>
        </div>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.transition = 'all 0.4s ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 400);
    }, 3800);
};

// 5. Cart Drawer AJAX Engine
function initCartDrawer() {
    const trigger = document.getElementById('cartDrawerTrigger');
    const drawer = document.getElementById('luxuryCartDrawer');
    const overlay = document.getElementById('cartDrawerOverlay');
    const closeBtn = document.getElementById('closeCartDrawer');

    if (!drawer) return;

    const openDrawer = () => {
        refreshCartDrawer();
        drawer.classList.add('active');
        if (overlay) overlay.classList.add('active');
    };

    const closeDrawer = () => {
        drawer.classList.remove('active');
        if (overlay) overlay.classList.remove('active');
    };

    if (trigger) trigger.addEventListener('click', (e) => { e.preventDefault(); openDrawer(); });
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (overlay) overlay.addEventListener('click', closeDrawer);
}

window.refreshCartDrawer = function() {
    fetch('/cart/drawer')
        .then(res => res.json())
        .then(data => {
            renderCartUI(data);
        })
        .catch(err => console.error('Cart drawer fetch failed', err));
};

function renderCartUI(data) {
    // Update badge counts
    document.querySelectorAll('.cart-count-badge').forEach(b => b.innerText = data.count);

    const body = document.getElementById('cartDrawerItems');
    const subtotalEl = document.getElementById('cartDrawerSubtotal');
    const countEl = document.getElementById('cartDrawerHeaderCount');
    const footerEl = document.getElementById('cartDrawerFooter');

    if (countEl) countEl.innerText = `${data.count} items`;
    if (subtotalEl) subtotalEl.innerText = data.subtotal;

    if (!body) return;

    if (data.items.length === 0) {
        if (footerEl) footerEl.style.display = 'none';
        body.innerHTML = `
            <div style="text-align: center; padding: 60px 20px; color: #6b7280;">
                <i class="fas fa-shopping-bag" style="font-size: 2.5rem; margin-bottom: 16px; display: block; color: #d97706;"></i>
                <h4 style="font-size: 1.15rem; margin-bottom: 8px; color: #111827; font-weight: 600;">Your Fragrance Bag is Empty</h4>
                <p style="font-size: 0.85rem; margin-bottom: 20px;">Explore our handcrafted impressions with 14+ hours longevity.</p>
                <a href="/collections/all" class="btn-gold" style="padding: 10px 24px; font-size: 0.8rem; text-decoration: none;">EXPLORE IMPRESSIONS</a>
            </div>
        `;
        return;
    }

    if (footerEl) footerEl.style.display = 'block';

    body.innerHTML = data.items.map(item => `
        <div style="display: flex; gap: 14px; padding: 14px 0; border-bottom: 1px solid #E5E7EB; align-items: center;">
            <img src="${item.image}" alt="${item.name}" style="width: 64px; height: 64px; object-fit: contain; background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 6px; padding: 4px;">
            <div style="flex-grow: 1;">
                <a href="${item.url}" style="font-family: var(--font-heading); font-size: 0.95rem; font-weight: 600; color: #111827; text-decoration: none; display: block; line-height: 1.3;">${item.name}</a>
                <span style="font-size: 0.75rem; color: #B8860B; font-weight: 600;">${item.variant}</span>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                    <div style="display: flex; align-items: center; border: 1px solid #D1D5DB; border-radius: 4px; background: #F9FAFB;">
                        <button onclick="updateCartItemQty(${item.id}, ${item.quantity - 1})" style="background: transparent; border: none; color: #374151; padding: 2px 8px; cursor: pointer; font-weight: bold;">-</button>
                        <span style="font-size: 0.8rem; padding: 0 6px; font-weight: 700; color: #111827;">${item.quantity}</span>
                        <button onclick="updateCartItemQty(${item.id}, ${item.quantity + 1})" style="background: transparent; border: none; color: #374151; padding: 2px 8px; cursor: pointer; font-weight: bold;">+</button>
                    </div>
                    <span style="font-family: var(--font-heading); font-weight: 700; color: #111827; font-size: 1rem;">${item.total}</span>
                </div>
            </div>
            <button onclick="removeCartItem(${item.id})" style="background: transparent; border: none; color: #9CA3AF; cursor: pointer; padding: 6px;" title="Remove" onmouseover="this.style.color='#DC2626'" onmouseout="this.style.color='#9CA3AF'">
                <i class="fas fa-trash-alt" style="font-size: 0.85rem;"></i>
            </button>
        </div>
    `).join('');
}

window.addToCartAjax = function(productId, quantity = 1, variantId = null) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity, variant_id: variantId })
    })
    .then(res => res.json())
    .then(data => {
        renderCartUI(data);
        const drawer = document.getElementById('luxuryCartDrawer');
        const overlay = document.getElementById('cartDrawerOverlay');
        if (drawer) drawer.classList.add('active');
        if (overlay) overlay.classList.add('active');
        window.showLuxuryToast('Flacon added to your private collection', 'success');
    })
    .catch(err => console.error(err));
};

window.addBundleToCart = function(bundleId) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ bundle_id: bundleId, quantity: 1 })
    })
    .then(res => res.json())
    .then(data => {
        renderCartUI(data);
        const drawer = document.getElementById('luxuryCartDrawer');
        const overlay = document.getElementById('cartDrawerOverlay');
        if (drawer) drawer.classList.add('active');
        if (overlay) overlay.classList.add('active');
        window.showLuxuryToast('Luxury Bundle added to your cart!', 'success');
    })
    .catch(err => console.error(err));
};

window.updateCartItemQty = function(itemId, qty) {
    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ item_id: itemId, quantity: qty })
    })
    .then(res => res.json())
    .then(data => renderCartUI(data));
};

window.removeCartItem = function(itemId) {
    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ item_id: itemId })
    })
    .then(res => res.json())
    .then(data => {
        renderCartUI(data);
        window.showLuxuryToast('Item removed from cart', 'info');
    });
};

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

// 6. Delivery Estimator
function initDeliveryEstimator() {
    const citySelect = document.getElementById('cityDeliverySelect');
    const resultBox = document.getElementById('deliveryEstimateResult');
    if (!citySelect || !resultBox) return;

    const deliverySchedule = {
        'Lahore': { time: 'Same-Day / 24 Hours', courier: 'TCS VIP Express / Courier Rider', cost: 'Complimentary' },
        'Karachi': { time: '24-48 Hours (Air Express)', courier: 'TCS Express Air Freight', cost: 'Complimentary' },
        'Islamabad': { time: '24 Hours (Air Cargo)', courier: 'Leopard / TCS Air Express', cost: 'Complimentary' },
        'Rawalpindi': { time: '24 Hours', courier: 'TCS Express Cargo', cost: 'Complimentary' },
        'Faisalabad': { time: '24-48 Hours', courier: 'TCS / Call Courier', cost: 'Complimentary' },
        'Peshawar': { time: '48 Hours', courier: 'TCS Overnight Air', cost: 'Complimentary' },
        'Multan': { time: '24-48 Hours', courier: 'Leopard Courier Express', cost: 'Complimentary' },
        'Sialkot': { time: '24 Hours', courier: 'TCS Direct Rider', cost: 'Complimentary' },
        'Quetta': { time: '48-72 Hours', courier: 'TCS Air Cargo Overland', cost: 'Complimentary' },
    };

    citySelect.addEventListener('change', (e) => {
        const city = e.target.value;
        const info = deliverySchedule[city] || { time: '48-72 Hours', courier: 'TCS Express Pakistan', cost: 'Complimentary' };
        
        resultBox.innerHTML = `
            <div style="background: rgba(201, 162, 75, 0.1); border: 1px solid var(--border-gold); padding: 12px 16px; border-radius: 6px; margin-top: 12px;">
                <div style="color: var(--gold-champagne); font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-bolt text-gold"></i> Estimated Delivery to ${city}:
                </div>
                <div style="font-size: 0.82rem; color: var(--text-ivory); margin-top: 4px;">
                    <strong>${info.time}</strong> via <em>${info.courier}</em> (${info.cost})
                </div>
            </div>
        `;
    });
}

// 7. Scent Finder Quiz
function initScentQuiz() {
    const openBtns = document.querySelectorAll('.open-scent-quiz-trigger');
    const modal = document.getElementById('scentQuizModal');
    const closeBtn = document.getElementById('closeScentQuizBtn');
    if (!modal) return;

    openBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            modal.classList.add('active');
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', () => modal.classList.remove('active'));
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.remove('active');
    });

    const quizForm = document.getElementById('scentQuizForm');
    if (quizForm) {
        quizForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const occasion = quizForm.querySelector('input[name="quiz_occasion"]:checked')?.value || 'royal';
            const resultsBox = document.getElementById('quizResults');
            if (resultsBox) {
                let recTitle = 'Oud Royale 1947 Extrait';
                let recSlug = 'oud-royale-1947-extrait';
                let recNotes = 'Aged Cambodian Agarwood, Kashmiri Saffron, Smoked Leather';

                if (occasion === 'summer') {
                    recTitle = 'Murree Mist & Silver Bergamot';
                    recSlug = 'murree-mist-silver-bergamot';
                    recNotes = 'Himalayan Pine Needles, Italian Bergamot, White Musk';
                } else if (occasion === 'wedding') {
                    recTitle = 'Noor-e-Gulab Rose Absolute';
                    recSlug = 'noor-e-gulab-rose-absolute';
                    recNotes = 'Taif Rose Dew, Saffron Supreme, Golden Ambergris';
                }

                resultsBox.innerHTML = `
                    <div style="background: rgba(18, 10, 13, 0.95); border: 1px solid var(--border-gold); padding: 20px; border-radius: 8px; text-align: center; margin-top: 20px;">
                        <span class="badge-luxury" style="margin-bottom: 10px; display: inline-block;">YOUR OLFACTORY MATCH</span>
                        <h4 style="font-size: 1.3rem; margin: 10px 0; color: var(--gold-champagne); font-family: var(--font-heading);">${recTitle}</h4>
                        <p style="font-family: var(--font-serif); color: var(--text-sub); font-size: 0.95rem; margin-bottom: 16px;">${recNotes}</p>
                        <a href="/perfume/${recSlug}" class="btn-gold" style="width: 100%;">EXPERIENCE FLACON</a>
                    </div>
                `;
            }
        });
    }
}

// 8. Search Modal
function initSearchModal() {
    const searchTrigger = document.getElementById('searchModalTrigger');
    const modal = document.getElementById('searchModal');
    const closeBtn = document.getElementById('closeSearchModal');
    const input = document.getElementById('luxurySearchInput');
    const results = document.getElementById('liveSearchResults');

    if (!searchTrigger || !modal) return;

    searchTrigger.addEventListener('click', (e) => {
        e.preventDefault();
        modal.classList.add('active');
        if (input) input.focus();
    });

    if (closeBtn) closeBtn.addEventListener('click', () => modal.classList.remove('active'));
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.remove('active');
    });

    if (input && results) {
        input.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            if (query.length < 2) {
                results.innerHTML = '<div style="text-align: center; color: var(--text-muted); padding: 20px;">Type at least 2 characters to explore our vault...</div>';
                return;
            }

            const cards = document.querySelectorAll('.product-card');
            let found = [];
            cards.forEach(card => {
                const title = card.querySelector('.product-title')?.innerText || '';
                const notes = card.querySelector('.product-notes-preview')?.innerText || '';
                const conc = card.querySelector('.product-concentration')?.innerText || '';
                const link = card.querySelector('.product-title a')?.getAttribute('href') || '#';
                const img = card.querySelector('.product-primary-img')?.getAttribute('src') || '';
                const price = card.querySelector('.current-price')?.innerText || '';

                if (title.toLowerCase().includes(query) || notes.toLowerCase().includes(query) || conc.toLowerCase().includes(query)) {
                    found.push({ title, notes, link, img, price });
                }
            });

            if (found.length === 0) {
                results.innerHTML = `<div style="text-align: center; color: var(--text-muted); padding: 20px;">No flacon matching "<em>${query}</em>" found in current page view. Press Enter for full database search.</div>`;
            } else {
                results.innerHTML = found.map(item => `
                    <a href="${item.link}" style="display: flex; align-items: center; gap: 16px; padding: 12px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-subtle); border-radius: 6px; text-decoration: none; margin-bottom: 10px; transition: var(--transition-smooth);">
                        <img src="${item.img}" style="width: 50px; height: 50px; object-fit: contain;">
                        <div style="flex-grow: 1;">
                            <div style="font-family: var(--font-heading); color: var(--text-ivory); font-weight: 600; font-size: 0.95rem;">${item.title}</div>
                            <div style="font-family: var(--font-serif); color: var(--text-muted); font-size: 0.82rem;">${item.notes}</div>
                        </div>
                        <div style="font-family: var(--font-heading); color: var(--gold-champagne); font-weight: 700;">${item.price}</div>
                    </a>
                `).join('');
            }
        });
    }
}

// 9. Quick View
function initQuickView() {
    const quickViewBtns = document.querySelectorAll('.quick-view-btn');
    const modal = document.getElementById('quickViewModal');
    const closeBtn = document.getElementById('closeQuickView');
    if (!modal) return;

    if (closeBtn) closeBtn.addEventListener('click', () => modal.classList.remove('active'));
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.remove('active');
    });

    quickViewBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const name = btn.dataset.name;
            const concentration = btn.dataset.concentration;
            const price = btn.dataset.price;
            const img = btn.dataset.img;
            const notes = btn.dataset.notes;
            const desc = btn.dataset.desc;
            const url = btn.dataset.url;
            const id = btn.dataset.id;

            const modalBody = document.getElementById('quickViewBody');
            if (modalBody) {
                modalBody.innerHTML = `
                    <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 30px; align-items: center;">
                        <div style="background: radial-gradient(circle, rgba(201,162,75,0.1) 0%, rgba(8,3,4,0.6) 80%); padding: 20px; border-radius: 8px; text-align: center;">
                            <img src="${img}" alt="${name}" style="max-height: 280px; width: auto;">
                        </div>
                        <div>
                            <span class="badge-luxury" style="margin-bottom: 8px; display: inline-block;">${concentration}</span>
                            <h3 style="font-size: 1.6rem; margin-bottom: 8px; color: var(--text-ivory); font-family: var(--font-heading);">${name}</h3>
                            <div style="font-family: var(--font-heading); font-size: 1.4rem; color: var(--gold-champagne); font-weight: 700; margin-bottom: 14px;">${price}</div>
                            <p style="font-family: var(--font-serif); color: var(--text-sub); font-size: 0.95rem; line-height: 1.6; margin-bottom: 16px;">${desc}</p>
                            <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 20px;">
                                <strong>Olfactory Notes:</strong> <em>${notes}</em>
                            </div>
                            <div style="display: flex; gap: 12px;">
                                <a href="${url}" class="btn-gold" style="flex-grow: 1;">EXPERIENCE FLACON</a>
                                <button onclick="addToCartAjax(${id}, 1)" class="btn-outline-gold"><i class="fas fa-shopping-bag"></i></button>
                            </div>
                        </div>
                    </div>
                `;
                modal.classList.add('active');
            }
        });
    });
}

// 10. PDP Gallery
function initPDPGallery() {
    const thumbs = document.querySelectorAll('.pdp-thumb-img');
    const mainImg = document.getElementById('pdpMainImage');
    if (!mainImg || thumbs.length === 0) return;

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', () => {
            thumbs.forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
            mainImg.src = thumb.dataset.fullSrc || thumb.src;
        });
    });
}

// 11. Mobile Nav Drawer & Accordion
function initMobileNav() {
    const menuBtn = document.getElementById('mobileMenuToggle');
    const navDrawer = document.getElementById('mobileNavDrawer');
    const closeBtn = document.getElementById('closeMobileNav');

    if (!menuBtn || !navDrawer) return;

    menuBtn.addEventListener('click', () => navDrawer.classList.add('active'));
    if (closeBtn) closeBtn.addEventListener('click', () => navDrawer.classList.remove('active'));
}
