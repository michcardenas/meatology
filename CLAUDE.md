# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is **Meatology**, a Laravel 12 e-commerce application for premium meat products with advanced shopping cart, order management, and Square payment integration. The application features product catalogs with certifications, dynamic shipping calculations, discount systems, and multi-location tax/shipping support.

## Development Commands

### Laravel Commands
```bash
# Development server with concurrency (includes queue, logs, and Vite)
composer run dev

# Standard development server
php artisan serve

# Testing
composer run test
# OR
php artisan test

# Cache management (important after route/config changes)
php artisan route:clear
php artisan config:clear
php artisan cache:clear

# Database operations
php artisan migrate
php artisan db:seed

# Queue operations (for background jobs)
php artisan queue:work
php artisan queue:listen --tries=1

# Storage link (required for product images)
php artisan storage:link
```

### Frontend Commands
```bash
npm run dev      # Development build with hot reload
npm run build    # Production build
```

## Core Architecture

### E-commerce Flow
1. **Catalog (`ShopController`)** → Product browsing with filters, categories, country-based filtering
2. **Shopping Cart (`CartController`)** → Uses `anayarojo/shoppingcart` package for session-based cart management
3. **Checkout (`ShopController::checkout`)** → Complex checkout with shipping calculation, discount codes, tips, product-specific savings
4. **Payment Gateway (`ShopController::paymentGateway`)** → Square integration for payment processing
5. **Order Management** → Complete order lifecycle with status tracking

### Key Models & Relationships

**Product System:**
- `Product` → belongs to `Category`, has many `ProductImage`, has `certification` (JSON array)
- Product pricing: base `price` + regional `interest` + `descuento` (discount percentage)
- Certifications: stored as JSON array [1,2,3] referencing certification image files

**Location & Pricing:**
- `Country` → has many `City`, has `shipping` cost
- `City` → belongs to `Country`, has `tax` percentage
- `Price` → polymorphic pricing by product/country/city combinations
- Shipping calculated by `Country.shipping`, tax by `City.tax`

**Order System:**
- `Order` → has many `OrderItem`, belongs to `Country`/`City`
- Order fields: `subtotal`, `tax_amount`, `shipping_amount`, `total_amount`, `discount_amount`, `tip_amount`, `product_savings`
- Payment integration with Square using `payment_transaction_id`

### Controllers Architecture

**ShopController (Primary):**
- `index()` → Product catalog with filtering/sorting
- `checkout()` → Complex checkout calculation with product discounts
- `calculateCosts()` → AJAX endpoint for shipping/tax calculation
- `processOrder()` → Order creation with all pricing components
- `paymentGateway()` → Square payment interface
- `processPayment()` → Square payment processing

**Admin Controllers:**
- `Admin/ProductController` → Product CRUD with image/certification management
- `Admin/LocationController` → Country/city management for shipping/tax
- `CartController` → Shopping cart operations

### Database Schema Highlights

**Products Table:**
- Core fields: `name`, `description`, `price`, `stock`, `avg_weight`
- Pricing: `interest` (regional markup), `descuento` (discount %)
- Location: `pais` (country filter), `category_id`
- Features: `certification` (JSON array of cert IDs)

**Orders Table:**
- Customer: `customer_name`, `customer_email`, `customer_phone`, `customer_address`
- Location: `country_id`, `city_id`
- Pricing breakdown: `subtotal`, `tax_amount`, `shipping_amount`, `discount_amount`, `tip_amount`, `product_savings`, `total_amount`
- Status: `status` (pending/completed/cancelled), `payment_status` (pending/paid/failed)

**Countries/Cities:**
- `countries.shipping` → shipping cost per state/country
- `cities.tax` → tax percentage per city

## Critical Configuration

### Square Payment Integration
Environment variables required in `.env`:
```
SQUARE_ENVIRONMENT=production  # or sandbox
SQUARE_APPLICATION_ID=sq0idp-...
SQUARE_ACCESS_TOKEN=EAAA...
SQUARE_LOCATION_ID=L98G...
```

Configuration in `config/square.php` maps these to application settings.

### File Storage
Product images stored in `storage/app/public/products/` via Laravel's storage system. Certification images are static files in `public/images/[1-3].webp`.

**Important:** Run `php artisan storage:link` for image access.

### Shopping Cart
Uses `anayarojo/shoppingcart` package. Cart data includes:
- Product options: `image`, `category_name`, `descuento`, `original_price`, `discount_amount`
- Automatic discount calculation when adding products

## Key Features & Logic

### Checkout Calculation System
Complex multi-step calculation in `resources/views/shop/checkout.blade.php`:

1. **Product Discounts** → Applied when adding to cart based on `Product.descuento`
2. **Additional Discounts** → Promo codes via `AdminDiscountController`
3. **Tips** → Percentage or fixed amount on subtotal
4. **Shipping** → Based on selected `Country.shipping`
5. **Tax** → Based on selected `City.tax` (optional)

JavaScript handles real-time calculation via `/checkout/calculate` endpoint.

### Certification System
Products can have certifications (1, 2, 3) stored as JSON array. Display logic:
- Admin: Checkboxes with preview images in `admin/products/_form.blade.php`
- Public: Certification badges in `products/show.blade.php`
- Images: `public/images/1.webp`, `public/images/2.webp`, `public/images/3.webp`

### Payment Gateway Integration
Two-step process:
1. **Order Creation** → `ShopController::processOrder()` creates pending order with all pricing
2. **Payment Processing** → `ShopController::paymentGateway()` displays Square payment form, `processPayment()` handles completion

Payment gateway shows complete order breakdown including all discounts, shipping, tips, and savings.

## Common Issues & Solutions

### Route Caching
After adding/modifying routes, always run:
```bash
php artisan route:clear
php artisan config:clear
```

### Image Storage
If product images don't display:
```bash
php artisan storage:link
```

### Checkout Errors
If checkout calculation fails:
1. Check Laravel logs: `tail -f storage/logs/laravel.log`
2. Verify `Countries` table has `shipping` values set
3. Ensure CSRF token in checkout form
4. Check `/checkout/calculate` route exists

### Square Payment Issues
- Verify environment (production vs sandbox) matches credentials
- Check `config/square.php` configuration
- Ensure all required environment variables are set

## Testing Considerations

When testing checkout flow:
1. Add products with discounts to cart
2. Test shipping calculation by country selection
3. Verify discount codes work
4. Test tip calculation (percentage and fixed)
5. Ensure order totals match payment gateway display
6. Test Square payment integration (use test cards in sandbox)

## File Organization

- **Controllers**: Main business logic in `ShopController`, admin operations in `Admin/` namespace
- **Views**: Checkout flow in `shop/`, payment in `payment/`, admin in `admin/`
- **Models**: Key models are `Product`, `Order`, `Country`, `City` with proper relationships
- **Migrations**: Incremental schema changes, recent additions include shipping/certification features
- **Frontend**: Tailwind CSS + Alpine.js, complex JavaScript for checkout calculations