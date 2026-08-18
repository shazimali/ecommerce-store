<p align="center">
  <h1 align="center">🛍️ Everyday Shops — Modern E-Commerce Platform</h1>
  <p align="center">
    A high-performance Full-Stack E-Commerce & Admin API Platform built with Laravel 11, Livewire 3, Tailwind CSS, Redis, Laravel Horizon, Docker, and GitHub Actions CI/CD.
  </p>
</p>

---

## 🌟 Key Features

### 🛒 Storefront & Customer Experience
* **Dynamic Multi-Currency Pricing:** Country-specific pricing engine with real-time currency conversions and promotional discount calculations.
* **Product Catalog & Bundles:** Support for single products, multi-color variations, gallery images, subcategories, and promotional bundle packages.
* **Cookie-Backed Cart Engine:** High-performance, session-resilient shopping cart supporting quantity adjustments, bundle additions, and dynamic tax/discount calculations.
* **Instant Checkout & Order Tracking:** Streamlined checkout workflow with order detail lookup, Cash on Delivery (COD) processing, and real-time status updates.
* **Interactive Frontend:** Responsive Livewire 3 components and Blade templates styled with Tailwind CSS & DaisyUI for fast, seamless page transitions.

### ⚡ Speed & Caching Optimizations
* **In-Memory Redis Layer:** High-speed Redis for caching, sessions, and asynchronous queue management.
* **Multi-Project Redis Isolation:** Custom isolated database indices (`REDIS_DB=2` for queues/default, `REDIS_CACHE_DB=3` for cache) and app-specific key prefixing (`eshop_`) to prevent key collisions across shared VPS Redis instances.
* **Layered Query Caching:**
  * `website()`: Multi-tenant domain & website lookup cached for 10 minutes.
  * `getSettingVal()`: Bulk settings map loaded in a single query and cached for 30 minutes.
  * `HomeController`: Home page dataset (trending, featured, new products, collections) cached for 15 minutes.
  * Product details & reviews cached for 30 / 15 minutes.
  * Shop filter taxonomy (categories & colors) cached for 30 minutes.
* **Automatic Cache Invalidation:** `ProductHeadObserver` automatically purges stale product and home page caches whenever inventory or catalog data is updated/deleted.
* **Composite Database Indexes:** Optimized B-Tree composite indexes for frequent query paths (`[status, is_new, order]`, `[status, is_trending, order]`, `[status, is_featured, order]`, `[country_id, key]`, `[status, domain]`).
* **Vite Rollup Chunk Splitting:** Independent vendor chunks (`vendor-alpine`, `vendor-swiper`) to maximize browser asset caching across deploys.

### 📊 Laravel Horizon Queue Supervision
* **Real-time Queue Dashboard:** Live metrics, throughput, failed job tracking, and auto-scaling worker supervision at `/horizon`.
* **Secret Token Authentication:** Secure dashboard access via URL query token (`/horizon?token=...`) with persistent session authorization and RBAC fallback for admin users.
* **Containerized Horizon Worker:** Automated background queue handling supervised directly inside the `everyday_shop_worker` Docker container.

### 🛡️ Admin Headless REST API (Vue.js Frontend Integration)
* **Decoupled Vue.js Admin SPA:** Serves as a headless backend API for a separate **Vue.js Single Page Application (SPA)** admin dashboard.
* **Role-Based Access Control (RBAC):** Granular permission and role management for administrative users via Sanctum authentication.
* **Comprehensive Resource APIs:** Sanctum-authenticated RESTful endpoints for managing Products, Categories, Collections, Bundles, Coupons, Customers, Facilities, Pages, Roles, Suppliers, and Site Settings.
* **Order Management & Shipping:** Centralized order booking, status updates, invoice retrieval, and supplier tracking.

---

## 🛠️ Technology Stack

* **Backend Framework:** Laravel 11 (PHP 8.2+)
* **Queue & Supervision:** Laravel Horizon, Redis (`phpredis` extension), PCNTL / POSIX process handling
* **Storefront Frontend:** Livewire 3, Alpine.js, Blade, Tailwind CSS, DaisyUI, Swiper.js, Vite
* **Admin Panel Backend:** Headless RESTful JSON APIs, Eloquent API Resources, Sanctum Authentication
* **Database & Caching:** MySQL 8.0, Redis (Alpine)
* **Containerization & Deployment:** Multi-stage Dockerfile, Docker Compose, GitHub Actions (CI/CD Pipeline), Docker Hub

---

## 🚀 Getting Started

### Prerequisites
* PHP >= 8.2
* Composer >= 2.x
* Node.js >= 18.x & NPM
* Redis Server *(or Docker)*
* MySQL 8.0 *(or SQLite for testing)*

---

### Local Installation Guide

1. **Clone the repository:**
   ```bash
   git clone https://github.com/shazimali/everyday-shops.git
   cd everyday-shops
   ```

2. **Install PHP & Node dependencies:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Redis & Horizon in `.env`:**
   ```env
   SESSION_DRIVER=redis
   QUEUE_CONNECTION=redis
   CACHE_STORE=redis

   REDIS_CLIENT=phpredis
   REDIS_HOST=127.0.0.1
   REDIS_PORT=6379
   REDIS_DB=2
   REDIS_CACHE_DB=3
   REDIS_PREFIX=eshop_

   HORIZON_NAME="Everyday Shop"
   HORIZON_TOKEN=your_secure_secret_token_here
   ```

5. **Database Migration & Seeding:**
   ```bash
   php artisan migrate --seed
   ```

6. **Link Storage & Run Development Server:**
   ```bash
   php artisan storage:link
   php artisan serve
   ```
   Visit `http://localhost:8000` in your browser.

---

## 🐳 Docker Deployment Setup

The application is containerized with a production multi-stage `Dockerfile` (including `pcntl`, `posix`, `intl`, `gd`, and `phpredis` extensions).

### 1. Build and Push Container Image
```bash
docker build -t shazimali/everyday-shop:latest .
docker push shazimali/everyday-shop:latest
```

### 2. Run on VPS with Docker Compose
```bash
# Pull latest image and restart services with zero data loss
docker-compose pull
docker-compose up -d
```

### 3. Accessing Horizon Dashboard
Visit in browser:
```
https://everydayplastic.co/horizon?token=your_secure_secret_token_here
```

### 4. Check Horizon via Docker CLI:
```bash
docker exec -it everyday_shop_worker php artisan horizon:status
docker logs -f everyday_shop_worker
```

---

## 🧪 Automated Testing

```bash
# Run feature and unit tests with in-memory SQLite execution
php artisan test
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).
