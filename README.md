# Perfumes Collection — Haute Parfumerie (Pakistan)
### Luxury Fragrance E-Commerce Platform | Extrait de Parfum & Artisanal Dehn al Oud

A state-of-the-art luxury fragrance e-commerce web application tailored specifically for the Pakistani market, operating on high-performance Extrait formulations, Pakistani Rupee (PKR) pricing, domestic courier logistics (TCS Express Air / Leopards), and multi-tier payments (Cash on Delivery, JazzCash, EasyPaisa, Raast, Bank Alfalah).

---

## 💎 Design System & Aesthetic Foundation
- **Deep Obsidian Canvas**: `#080304` and `#0E0507` luxury dark palette.
- **Imperial Gold Accents**: Gradient from `#C9A24B` to `#E6C77A` with 24K gold foil borders.
- **Royal Maroon Highlights**: `#4A0E17` for privilege badges and discounts.
- **Warm Ivory Typography**: `#F5EFE6` body text for maximum legibility.
- **Official Brand Mark**: Vintage gold atomizer with circular double frame and *PC / Perfume Collection* typography.
- **Typography Stack**:
  - Headings & Monograms: `Cormorant Garamond` & `Playfair Display`
  - Body & UI: `Inter` & `Jost`
- **Dynamic Interactions**: Swiper.js full-screen hero slider, Alpine.js reactive UI states, slide-in cart drawer with live subtotal calculation, fragrance note pyramid, longevity benchmark meters, and 1-click WhatsApp concierge integration.

---

## 🏛️ Database Architecture & Schemas (Complete Project-Wide)
1. `users` — Administrator & patron authentication, roles, WhatsApp numbers, Pakistani city preferences.
2. `categories` — House taxonomy (Royal Oud, Imperial Floral, Leather & Tobacco, Attars, Discovery Sets).
3. `collections` — Curated reserves (`exclusive`, `men`, `women`, `unisex`, `oriental-heritage`, `collaborations`).
4. `brands` — Artisanal ateliers and parent brand references.
5. `fragrance_families` & `scent_notes` — Multi-tier olfactory ontology (Top, Heart, Base notes).
6. `products` — 26+ pre-seeded master formulations with PKR pricing, concentration (35%–40%), longevity ratings, sillage metrics, and WhatsApp direct ordering links.
7. `product_variants` — Milliliter sizing (12ml attar, 50ml, 100ml flacons).
8. `product_images` — High-resolution crystal flacon and velvet presentation box visuals.
9. `bundles` & `bundle_items` — Curated fragrance pairing sets and discovery coffrets with automatic discount math.
10. `carts` & `cart_items` — Session and user-persistent shopping bags.
11. `orders`, `order_items` & `payments` — Multi-payment processing (COD, JazzCash, EasyPaisa, Raast).
12. `addresses` — Pakistani provincial and city addresses (Lahore, Karachi, Islamabad, Peshawar, Quetta, Multan, etc.).
13. `reviews` — Verified patron rating engine with star ratings, Pakistani cities, and olfactory feedback.
14. `coupons` — Promotional codes (e.g., `ROYAL10` for 10% privilege discount).
15. `blogs` — The Olfactory Chronicles (SEO-optimized fragrance journal).
16. `hero_slides` — Database-driven dynamic homepage slider.
17. `settings` & `inquiries` — Store configurations, WhatsApp numbers, VIP consultation leads.

---

## 🔐 Admin Authentication Credentials (For Demonstration)
- **Admin Portal**: Accessible via `/admin` (Filament Panel integration)
- **Email**: `admin@perfumescollection.pk`
- **Password**: `admin123456`
> **Important:** Change default administrator credentials immediately upon production deployment!

---

## 🚀 Hostinger Shared Hosting Deployment Architecture
This application is purposefully engineered for **Hostinger Unlimited Shared Hosting (cPanel / hPanel)** with zero Node.js daemon dependencies on the production server.

### Required PHP Extensions:
- `PHP >= 8.1` (8.1, 8.2, or 8.3 fully supported)
- `BCMath`, `Ctype`, `cURL`, `DOM`, `Fileinfo`, `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `PDO_MySQL`, `Tokenizer`, `XML`

### Hostinger Directory Layout:
```
/home/u123456789/
├── anti_perf_app/          <-- Place the entire Laravel application here (outside public_html)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── routes/
│   ├── storage/
│   └── ...
└── public_html/            <-- ONLY the contents of Laravel's 'public/' directory go here
    ├── assets/
    ├── index.php           <-- Update paths to ../anti_perf_app/bootstrap/app.php
    ├── .htaccess           <-- Apache optimization & security rules
    └── robots.txt
```

### Fixing `public_html/index.php`:
```php
require __DIR__.'/../anti_perf_app/vendor/autoload.php';
$app = require_once __DIR__.'/../anti_perf_app/bootstrap/app.php';
```

### Storage Symlink Fallback (If Symlinks are Restricted):
If symlinks are disallowed on shared hosting, create a storage disk redirect or run:
```bash
php artisan storage:link
```
Or configure `config/filesystems.php` to write uploads directly to `public_html/storage`.

### Cron Job for Shared Hosting Scheduler:
Set the following cron job in Hostinger hPanel to execute every minute:
```bash
* * * * * cd /home/u123456789/anti_perf_app && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📦 Local Installation & Setup
1. **Clone repository & enter directory**:
   ```bash
   cd e:/Anti-Perf-Web
   ```
2. **Install composer dependencies**:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```
3. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Database Migration & Seeding**:
   ```bash
   php artisan migrate:fresh --seed
   ```
5. **Start Local Development Server**:
   ```bash
   php artisan serve
   ```
   Visit: `http://localhost:8000`

---

## 🌟 Deliverables Summary for Part 1
- ✅ **Design System Tokens**: Fully implemented in `public/assets/css/luxury.css` with responsive Tailwind utilities.
- ✅ **Database & Models**: Complete schema and Eloquent models for all 18 tables with relations, PKR accessors, and seeders.
- ✅ **Storefront Views**:
  - `home.blade.php`: Swiper hero slider, category tiles, bestsellers, new arrivals, bundles spotlight, testimonials, brand story.
  - `collection-detail.blade.php`: 2-col/4-col grid, fragrance family / note / price / volume filters, sorting, breadcrumbs.
  - `bundles.blade.php`: BuyRawaha-inspired bundle cards with included items preview, savings amount, and instant add-to-cart.
  - `product-detail.blade.php`: High-res gallery, note pyramid, longevity/sillage meters, tabs, review form, mobile sticky bar.
  - `blogs.blade.php` & `blog-detail.blade.php`: Fragrance journal articles with author bios.
  - `collaborations.blade.php`, `about.blade.php`, `contact.blade.php`, `faq.blade.php`, `search.blade.php`, and policy pages.
- ✅ **Interactive Slide-in Cart Drawer**: Quantity controls, dynamic subtotal, and WhatsApp checkout integration.
- ✅ **Zero Broken Routes**: Verified all 21 core GET endpoints returning HTTP 200 OK.
