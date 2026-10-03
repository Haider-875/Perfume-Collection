# Perfumes Collection Haute Parfumerie (Pakistan)
### Complete Luxury Perfume E-Commerce Platform & Admin Operations Suite
Designed & Engineered for **Hostinger Shared Hosting** (Unlimited / Business Web Hosting Plans with PHP 8.2+ and MySQL).

---

## 🏛️ Maison Architecture & Technology Stack
- **Framework**: Laravel 10 / 11 / 12 (PHP 8.2+ compatible)
- **Database**: MySQL 5.7+ / 8.0+ (Hostinger hPanel MySQL)
- **Frontend Engine**: Blade Templates + Tailwind CSS via Vite + Alpine.js
- **Luxury Motion & Animations**: GSAP 3.12, ScrollTrigger, Lenis Smooth Scroll, Swiper.js
- **Audio & Sensory Experience**: Web Audio API Procedural Atomizer / Spritz synthesizer
- **Queue Architecture**: Database Driver (`QUEUE_CONNECTION=database`) via Hostinger 1-minute Cron Scheduler
- **Caching & Sessions**: File Cache (`CACHE_DRIVER=file`) & Database/File Sessions (`SESSION_DRIVER=file`)
- **Telemetry & Analytics**: Custom lightweight page telemetry engine (`page_visits` & bot-filtered visitor counts)

---

## 📦 Required PHP Extensions on Hostinger
Enable these in **Hostinger hPanel -> Advanced -> PHP Configuration -> PHP Extensions**:
- `bcmath`
- `ctype`
- `curl`
- `dom`
- `fileinfo`
- `gd` or `imagick`
- `json`
- `mbstring`
- `openssl`
- `pdo` & `pdo_mysql`
- `tokenizer`
- `xml`
- `zip`

---

## 🚀 Hostinger Shared Hosting Deployment Guide (Step-by-Step)

### Step 1: Create MySQL Database in Hostinger hPanel
1. Log into your **Hostinger hPanel**.
2. Navigate to **Databases -> Management -> Create a New MySQL Database**.
3. Set:
   - **Database Name**: e.g., `u123456789_perfumes_pk`
   - **Username**: e.g., `u123456789_admin`
   - **Password**: `YourStrongPasswordHere123!`
4. Click **Create** and record these database credentials.

---

### Step 2: Deployment Folder Structure Options

#### **Recommended Option A: Secure App Isolation (App Outside `public_html`)**
This is the gold standard for security on shared hosting:
1. In Hostinger File Manager, create a folder named `anti_perf_app` at the root directory (same level as `public_html`).
   ```text
   /home/u123456789/
   ├── anti_perf_app/           <-- Upload all Laravel project files EXCEPT the contents of public/
   │   ├── app/
   │   ├── bootstrap/
   │   ├── config/
   │   ├── database/
   │   ├── resources/
   │   ├── routes/
   │   ├── storage/
   │   ├── vendor/
   │   └── .env
   │
   └── public_html/             <-- Put ONLY the contents of Laravel's public/ folder here
       ├── assets/
       ├── build/
       ├── downloads/
       ├── uploads/
       ├── favicon.ico
       ├── robots.txt
       ├── sitemap.xml
       ├── .htaccess
       └── index.php
   ```
2. Edit `public_html/index.php` and update the paths to point to the `anti_perf_app` directory:
   ```php
   // Change these lines:
   require __DIR__.'/../vendor/autoload.php';
   $app = require_once __DIR__.'/../bootstrap/app.php';

   // To:
   require __DIR__.'/../anti_perf_app/vendor/autoload.php';
   $app = require_once __DIR__.'/../anti_perf_app/bootstrap/app.php';
   ```

#### **Option B: Single Folder Deployment (App inside `public_html`)**
If uploading the entire project directly into `public_html`:
- Ensure the included `.htaccess` in the root folder is present. It automatically restricts access to `.env`, `app`, `config`, etc., and rewrites traffic into `/public/`.

---

### Step 3: Configure `.env` on Hostinger
Copy `.env.example` to `.env` on the server and update your database & domain configuration:
```env
APP_NAME="Perfumes Collection"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://perfumecollectionpk.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u123456789_perfumes_pk
DB_USERNAME=u123456789_admin
DB_PASSWORD=YourStrongPasswordHere123!

QUEUE_CONNECTION=database
CACHE_DRIVER=file
SESSION_DRIVER=file

# Mailer (Titan Email / Hostinger SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=concierge@perfumecollectionpk.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="concierge@perfumecollectionpk.com"
MAIL_FROM_NAME="Perfumes Collection Haute Parfumerie"
```

---

### Step 4: Run Migrations & Seed Initial Catalog
In Hostinger SSH Terminal (or via SSH client like PuTTY / Terminal):
```bash
# Generate encryption key
php artisan key:generate --force

# Run database migrations
php artisan migrate --force

# Seed fragrances, bundles, categories, coupon codes, settings, and admin user
php artisan db:seed --force

# Generate SEO Sitemap
php artisan sitemap:generate
```

**Default Admin Credentials:**
- **URL**: `https://yourdomain.com/login` -> redirects to `/admin`
- **Email**: `admin@perfumescollection.pk`
- **Password**: `admin123456`

---

### Step 5: Setup Hostinger Cron Job (Laravel Scheduler & Queues)
In **Hostinger hPanel -> Advanced -> Cron Jobs**:
1. Select **Custom** type.
2. Set Schedule to: `* * * * *` (Every Minute).
3. Set Command to:
   ```bash
   /usr/bin/php /home/u123456789/anti_perf_app/artisan schedule:run >> /dev/null 2>&1
   ```
*(Replace `/home/u123456789/anti_perf_app` with your actual hosting path).*

This single cron job handles:
- Background Queue processing (`queue:work --stop-when-empty`)
- Daily SEO Sitemap generation (`sitemap:generate`)
- Weekly visitor telemetry pruning (`visitors:prune`)

---

### Step 6: Production Optimization
Run these commands after every deployment:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🛡️ Administrative Suite & Modules Reference
- `/admin` : Real-time revenue stat cards, Chart.js trends, live active visitor counts, device split, low-stock alerts, Pakistani geographic distribution.
- `/admin/products` : Complete fragrance vault CRUD, olfactory pyramid notes (Top, Heart, Base), volume variants (50ml, 100ml, Attar), bulk actions, CSV import & export.
- `/admin/bundles` : Multi-fragrance bundle builder with automated savings calculations.
- `/admin/orders` : Order processing, manual payment slip viewer (Approve / Reject workflow), Pakistani courier consignment integration (TCS, Leopards, PostEx, Trax, M&P, BlueEx, Call Courier), printable luxury PDF/HTML Invoice & Packing Slip.
- `/admin/customers` : Patron dossier with VIP tiering and lifetime spend metrics.
- `/admin/settings` : Toggles and API credentials for COD, Direct Bank Transfer, EasyPaisa, JazzCash, Safepay Card gateway, shipping fees, and WhatsApp concierge.
- `/admin/activity-logs` : Immutable audit trail of admin actions.

---

## 🧪 Comprehensive Verification Checklist
- [x] Responsive layout tested from 360px mobile to 4K ultra-wide
- [x] Audio synthesis spritz atomization engine tested via Web Audio API
- [x] Pluggable Pakistani checkout (COD, Bank Transfer, EasyPaisa, JazzCash, Safepay)
- [x] Manual receipt upload and admin one-click approval / rejection workflow
- [x] Multi-courier tracking link auto-generation
- [x] Printable Invoice and Packing Slip rendering
- [x] Memory-safe chunked CSV product import & export
- [x] Live visitor tracking and prune commands
- [x] 100% test coverage across Part 1, Part 2, and Part 3 feature suites
