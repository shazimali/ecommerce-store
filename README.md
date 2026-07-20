<p align="center">
  <h1 align="center">🛍️ Everyday Shops — Modern E-Commerce Platform</h1>
  <p align="center">
    A robust, high-performance Full-Stack E-Commerce & Admin API Platform built with Laravel 11, Livewire 3, Tailwind CSS, Docker, and GitHub Actions CI/CD.
  </p>
</p>

---

## 🌟 Key Features

### 🛒 Storefront & Customer Experience
* **Dynamic Multi-Currency Pricing:** Country-specific pricing engine with real-time currency conversions and promotional discount calculation.
* **Product Catalog & Bundles:** Support for single products, multi-color variations, gallery images, subcategories, and promotional bundle packages.
* **Cookie-Backed Cart Engine:** High-performance, session-resilient shopping cart supporting quantity adjustments, bundle additions, and dynamic tax/discount calculations.
* **Instant Checkout & Order Tracking:** Streamlined checkout workflow with order detail lookup, Cash on Delivery (COD) processing, and real-time status updates.
* **Interactive Frontend:** Responsive Livewire 3 components and Blade templates styled with Tailwind CSS for fast, seamless page transitions.

### 🛡️ Admin Headless REST API (Vue.js Frontend Integration)
* **Decoupled Vue.js Admin SPA:** Serves as a headless backend API for a separate **Vue.js Single Page Application (SPA)** admin dashboard.
* **Role-Based Access Control (RBAC):** Granular permission and role management for administrative users via Sanctum authentication.
* **Comprehensive Resource APIs:** Sanctum-authenticated RESTful endpoints for managing Products, Categories, Collections, Bundles, Coupons, Customers, Facilities, Pages, Roles, Suppliers, and Site Settings.
* **Order Management & Shipping:** Centralized order booking, status updates, invoice retrieval, and supplier tracking.

### ⚙️ Architecture & Code Quality
* **Layered Service-Interface Architecture:** Clean separation of concerns (Controllers ➔ Form Requests ➔ Interfaces ➔ Services ➔ API Resources ➔ Eloquent Models).
* **N+1 Query Optimization:** Eager-loaded relationships (`with(['sub_categories', 'price_detail', 'colors'])`) to guarantee optimal database query performance.
* **Database Transactions:** Atomic operations using `DB::transaction(...)` blocks for data integrity during bulk updates and deletions.
* **Type-Safe Validation:** Fluent validation rules (`Rule::unique(...)`) and strict PHP 8.3 typing.

---

## 🛠️ Technology Stack

* **Backend Framework:** Laravel 11 (PHP 8.3)
* **Storefront Frontend:** Livewire 3, Alpine.js, Blade, Tailwind CSS, Vite
* **Admin Panel Frontend:** Decoupled Vue.js Single Page Application (SPA) consuming Sanctum REST API
* **Database:** MySQL 8.0 (Production) / SQLite in-memory (Testing)
* **API Architecture:** Headless RESTful JSON APIs, Eloquent API Resources, Sanctum Authentication
* **Containerization & Deployment:** Docker, Docker Compose, GitHub Actions (CI/CD Pipeline), Docker Hub

---

## 🚀 Getting Started

### Prerequisites
* PHP >= 8.3
* Composer >= 2.x
* Node.js >= 18.x & NPM
* Docker & Docker Compose *(Optional for containerized setup)*

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

4. **Database Migration & Seeding:**
   Update your database credentials in `.env`, then run:
   ```bash
   php artisan migrate --seed
   ```

5. **Link Storage & Run Development Server:**
   ```bash
   php artisan storage:link
   php artisan serve
   ```
   Visit `http://localhost:8000` in your browser.

---

## 🐳 Docker Setup

Run the application locally using Docker Compose:

```bash
# Start all services (App & Worker)
docker-compose up -d --build

# View logs
docker-compose logs -f
```

---

## 🧪 Automated Testing

The project includes unit and feature test suites configured with SQLite in-memory database execution:

```bash
# Run all tests
php artisan test
```

---

## 🚢 CI/CD Deployment Pipeline

This repository uses **GitHub Actions** (`.github/workflows/deploy.yml`) for continuous integration and automated deployment:

1. **Automated Testing:** Runs `php artisan test` against a MySQL test service container on every commit to `main`.
2. **Containerization:** Builds a cached multi-stage Docker image and pushes it to **Docker Hub** (`shazimali/everyday-shop:latest`).
3. **Automated VPS Deployment:** Connects securely over SSH to the production server, pulls the latest image, runs database optimization/cache clear commands, and restarts containers with zero downtime.

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).
