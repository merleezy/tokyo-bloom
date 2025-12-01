# Tokyo Bloom Architecture

This document outlines the production-ready MVC architecture and design patterns used in Tokyo Bloom.

## Architecture Overview

Tokyo Bloom follows a **modern MVC (Model-View-Controller)** pattern with clean separation of concerns, security best practices, and PSR-4 autoloading. The application uses a front controller pattern with routing, repository pattern for data access, and service layer for cross-cutting concerns.

## Design Patterns

### **1. Front Controller Pattern**

Single entry point (`public/index.php`) handles all HTTP requests, bootstraps the application, and delegates to the router.

### **2. MVC Pattern**

- **Models**: Repository classes (`MenuRepository`, `OrderRepository`, `ReservationRepository`)
- **Views**: Template files in `templates/` with master layout
- **Controllers**: Handle HTTP requests, interact with repositories, render views

### **3. Repository Pattern**

Data access abstraction layer that encapsulates database queries and provides clean API for controllers.

### **4. Service Layer**

Reusable business logic (`Validator`, `Logger`) independent of HTTP concerns.

### **5. Dependency Injection**

Controllers and repositories receive dependencies (PDO, repositories) via constructor injection.

## Project Structure

```
tokyo-bloom/
├─ public/                          # Web root (DocumentRoot)
│  ├─ .htaccess                     # URL rewriting, security headers
│  ├─ index.php                     # Front controller
│  ├─ css/
│  │  └─ style.css                  # Main stylesheet (1000+ lines)
│  ├─ js/
│  │  └─ scripts.js                 # Client-side interactions
│  ├─ images/                       # Static assets
│  └─ fonts/                        # Custom web fonts
│
├─ src/                             # Application code (PSR-4: App\)
│  ├─ Bootstrap.php                 # Application initialization
│  ├─ Router.php                    # URL routing engine
│  ├─ helpers.php                   # Global helper functions
│  │
│  ├─ Controllers/                  # HTTP request handlers
│  │  ├─ Controller.php             # Base controller with render()
│  │  ├─ HomeController.php         # Landing page
│  │  ├─ MenuController.php         # Menu display
│  │  ├─ OrderController.php        # Order page, add to cart
│  │  ├─ CartController.php         # Cart CRUD operations
│  │  ├─ CheckoutController.php     # Order placement
│  │  ├─ ReservationsController.php # Table bookings
│  │  └─ ContactController.php      # Contact form
│  │
│  ├─ Repositories/                 # Data access layer
│  │  ├─ MenuRepository.php         # Menu items CRUD
│  │  ├─ OrderRepository.php        # Orders and order_items
│  │  └─ ReservationRepository.php  # Reservations CRUD
│  │
│  ├─ Services/                     # Business logic services
│  │  ├─ Validator.php              # Input validation
│  │  └─ Logger.php                 # Monolog wrapper
│  │
│  └─ Database/
│     └─ Connection.php             # PDO factory with Dotenv
│
├─ templates/                       # View layer
│  ├─ layout.php                    # Master layout (HTML structure)
│  ├─ home.php                      # Homepage view
│  ├─ menu.php                      # Menu listing view
│  ├─ order.php                     # Order page with cart form
│  ├─ cart.php                      # Shopping cart view
│  ├─ checkout.php                  # Checkout form
│  ├─ checkout_success.php          # Order confirmation
│  ├─ reservations_form.php         # Booking form
│  ├─ reservations_success.php      # Booking confirmation
│  ├─ reservations_canceled.php     # Cancellation confirmation
│  ├─ contact_form.php              # Contact form
│  └─ contact_success.php           # Message sent confirmation
│
├─ routes/
│  └─ web.php                       # Route definitions (16 routes)
│
├─ database/
│  ├─ migrate.php                   # Migration runner
│  └─ migrations/
│     ├─ 000_create_menu_items.sql
│     ├─ 001_create_orders_tables.sql
│     └─ 002_create_reservations.sql
│
├─ logs/                            # Application logs
│  ├─ app.log                       # General application logs
│  └─ error.log                     # Error-level logs
│
├─ vendor/                          # Composer dependencies
├─ docs/                            # Documentation
├─ .env                             # Environment configuration
├─ .env.example                     # Environment template
├─ composer.json                    # PHP dependencies
└─ tokyo_bloom.sql                  # Database dump
```

## Request Lifecycle

```
1. Browser Request
   └─> http://localhost/tokyo-bloom/public/cart

2. Apache mod_rewrite (.htaccess)
   └─> Routes to public/index.php

3. Front Controller (public/index.php)
   ├─> Loads Composer autoloader
   ├─> Bootstraps application (Dotenv, session)
   ├─> Loads route definitions (routes/web.php)
   └─> Passes control to Router

4. Router (src/Router.php)
   ├─> Matches HTTP method + path
   ├─> Resolves controller class
   └─> Invokes controller method

5. Controller (e.g., CartController::index())
   ├─> Validates CSRF token (if POST)
   ├─> Interacts with Repository
   ├─> Processes business logic
   └─> Calls render() method

6. View Rendering (Controller::render())
   ├─> Loads template file (templates/cart.php)
   ├─> Captures output buffering
   ├─> Wraps in layout (templates/layout.php)
   └─> Outputs HTML

7. Response
   └─> HTML sent to browser
```

## Security Architecture

### **CSRF Protection**

- Token generation: `csrf_token()` creates 32-byte random token
- Token storage: Stored in `$_SESSION['csrf_token']`
- Token verification: `csrf_verify()` uses `hash_equals()` for timing-safe comparison
- Forms: `csrf_field()` generates hidden input field

### **SQL Injection Prevention**

- PDO prepared statements in all repositories
- Parameter binding (`:placeholder` syntax)
- Type casting on user input

### **XSS Prevention**

- Output escaping: `htmlspecialchars($var, ENT_QUOTES, 'UTF-8')`
- Security headers in `.htaccess`:
  - `X-Content-Type-Options: nosniff`
  - `X-Frame-Options: DENY`
  - `X-XSS-Protection: 1; mode=block`

### **Input Validation**

- `Validator` service with fluent API
- Rules: required, email, min, max, numeric, integer, phone, date, time, url
- Server-side validation on all forms

### **Environment Configuration**

- Sensitive data in `.env` (not committed)
- Database credentials isolated
- SMTP credentials protected

## Data Flow Patterns

### **Example: Adding Item to Cart**

```
1. User clicks "Add to Cart" on order.php
   └─> POST /order/add
       ├─> item_id: 5
       ├─> quantity: 2
       └─> csrf_token: abc123...

2. OrderController::add()
   ├─> Validates CSRF token
   ├─> Validates item_id is integer > 0
   ├─> Validates quantity is integer > 0
   ├─> Initializes $_SESSION['cart'] if needed
   ├─> Adds/updates: $_SESSION['cart'][5] = 2
   └─> Redirects to /cart

3. CartController::index()
   ├─> Retrieves $_SESSION['cart'] = [5 => 2, 7 => 1]
   ├─> Calls hydrateCart()
   │   ├─> MenuRepository::getMenu()
   │   ├─> Fetches item details (name, price, image)
   │   └─> Returns enriched cart array
   ├─> Calls calculateTotals()
   │   ├─> Sums subtotals
   │   ├─> Applies 10% tax
   │   └─> Returns [subtotal, tax, total]
   └─> Renders cart.php template

4. Template Rendering
   ├─> cart.php receives $cart and $totals
   ├─> Loops through items
   ├─> Displays cart table
   └─> Wrapped in layout.php
```

### **Example: Creating Reservation**

```
1. User submits reservation form
   └─> POST /reservations
       ├─> name, email, phone, date, time, guests
       └─> csrf_token

2. ReservationsController::store()
   ├─> Validates CSRF token
   ├─> Validates all required fields
   ├─> Checks date/time format
   ├─> Ensures guests >= 1
   ├─> Calls ReservationRepository::create()
   │   ├─> Prepares INSERT statement
   │   ├─> Binds parameters
   │   ├─> Executes query
   │   └─> Returns lastInsertId
   └─> Redirects to /reservations/confirm?id=123

3. ReservationsController::confirm()
   ├─> Validates id parameter
   ├─> Calls ReservationRepository::findById()
   ├─> Checks reservation exists
   └─> Renders reservations_success.php
```

## Database Schema

### **menu_items**

- Stores restaurant menu with categories
- Used by: MenuRepository, OrderController, CartController

### **orders**

- Customer order headers
- Relationships: has many order_items

### **order_items**

- Individual items in each order
- Foreign key: order_id → orders.id (CASCADE DELETE)

### **reservations**

- Table bookings with date/time slots
- Unique constraint: (date, time) prevents double-booking

## Service Layer

### **Validator Service**

```php
$validator = new Validator();
$isValid = $validator->validate($data, [
    'email' => 'required|email',
    'guests' => 'required|integer|min:1|max:20'
]);

if (!$isValid) {
    $errors = $validator->errors(); // ['email' => ['email must be valid']]
}
```

### **Logger Service**

```php
Logger::info('Order placed', ['order_id' => 123]);
Logger::error('Database connection failed', ['error' => $e->getMessage()]);
```

- Monolog integration
- Rotating file handler (7-day retention)
- Separate error log for critical issues
- PSR-3 compliant

## Helper Functions

### **URL Generation**

- `base_url($path)`: Application URLs (routes)
- `asset_url($path)`: Static assets (CSS, JS, images)

### **CSRF Protection**

- `csrf_token()`: Generate/retrieve token
- `csrf_field()`: HTML hidden input
- `csrf_verify($token)`: Timing-safe validation

## Route Definitions

All routes defined in `routes/web.php`:

```php
// Home
$router->get('/', [HomeController::class, 'index']);

// Menu
$router->get('/menu', [MenuController::class, 'index']);

// Order & Cart
$router->get('/order', [OrderController::class, 'index']);
$router->post('/order/add', [OrderController::class, 'add']);
$router->get('/cart', [CartController::class, 'index']);
$router->post('/cart/update', [CartController::class, 'update']);
$router->post('/cart/remove', [CartController::class, 'remove']);
$router->post('/cart/clear', [CartController::class, 'clear']);

// Checkout
$router->get('/checkout', [CheckoutController::class, 'index']);
$router->post('/checkout', [CheckoutController::class, 'place']);

// Reservations
$router->get('/reservations', [ReservationsController::class, 'index']);
$router->post('/reservations', [ReservationsController::class, 'store']);
$router->get('/reservations/confirm', [ReservationsController::class, 'confirm']);
$router->post('/reservations/cancel', [ReservationsController::class, 'cancel']);

// Contact
$router->get('/contact', [ContactController::class, 'index']);
$router->post('/contact', [ContactController::class, 'send']);
```

## Session Management

### **Cart Storage**

```php
$_SESSION['cart'] = [
    5 => 2,  // item_id => quantity
    7 => 1,
    12 => 3
];
```

### **CSRF Token**

```php
$_SESSION['csrf_token'] = 'abc123...'; // 64-char hex
```

### **Flash Messages**

```php
$_SESSION['error'] = 'invalid_input';
// Read once, then unset
```

## Technology Stack

### **Backend**

- PHP 8.0+ (strict types, type declarations)
- Composer (autoloading, dependencies)
- PHPMailer 6.x (email notifications)
- Monolog 2.x (logging)
- vlucas/phpdotenv (environment config)

### **Database**

- MySQL 8.0 / MariaDB 10.4+
- PDO with prepared statements
- Foreign key constraints
- Migrations system

### **Frontend**

- Vanilla JavaScript (ES6+)
- CSS3 (Grid, Flexbox, Custom Properties)
- Responsive design (mobile-first)
- Progressive enhancement

### **Server**

- Apache 2.4+ with mod_rewrite
- .htaccess URL rewriting
- Security headers

## Development Workflow

### **Adding New Feature**

1. **Create Migration** (if database changes needed)

   ```sql
   -- database/migrations/003_create_feature.sql
   CREATE TABLE feature (...);
   ```

2. **Run Migration**

   ```bash
   php database/migrate.php
   ```

3. **Create Repository**

   ```php
   // src/Repositories/FeatureRepository.php
   class FeatureRepository {
       public function create(array $data): int { }
       public function findById(int $id): ?array { }
   }
   ```

4. **Create Controller**

   ```php
   // src/Controllers/FeatureController.php
   class FeatureController extends Controller {
       public function index(): void { }
       public function store(): void { }
   }
   ```

5. **Add Routes**

   ```php
   // routes/web.php
   $router->get('/feature', [FeatureController::class, 'index']);
   $router->post('/feature', [FeatureController::class, 'store']);
   ```

6. **Create Templates**
   ```php
   // templates/feature.php
   <main>...</main>
   ```

### **Testing Flow**

1. Manual testing in browser
2. Check error logs: `logs/error.log`
3. Verify database state in phpMyAdmin
4. Test CSRF protection (remove token)
5. Test validation (invalid inputs)
6. Test edge cases (empty cart, etc.)

## Performance Considerations

### **Database**

- Indexed columns: id (primary), date, time
- Foreign keys with ON DELETE CASCADE
- Query only needed columns (SELECT name, price vs SELECT \*)

### **Sessions**

- Cart stored as minimal structure (id => quantity)
- Hydration happens on-demand (CartController)
- Session cleanup on checkout completion

### **Assets**

- Single CSS file (minimize HTTP requests)
- Images served directly by Apache (no PHP overhead)
- Deferred JavaScript loading
- Lazy loading on images (`loading="lazy"`)

### **Caching Opportunities** (future)

- Menu items (rarely change)
- Compiled templates
- Route cache
- Autoloader optimization (`composer dump-autoload -o`)

## Scalability Patterns

### **Current State**

- Monolithic MVC architecture
- Single server deployment
- Session-based cart (file storage)

### **Future Enhancements**

- **Database**: Read replicas, connection pooling
- **Sessions**: Redis/Memcached for distributed sessions
- **Cache**: Redis for menu items, availability slots
- **Queue**: Background jobs for email sending
- **CDN**: Static assets (CSS, JS, images)
- **Load Balancer**: Multiple PHP-FPM instances
- **Microservices**: Split order/reservation services

## Security Best Practices

### **Implemented**

✅ CSRF tokens on all state-changing operations  
✅ Prepared statements (SQL injection prevention)  
✅ Output escaping (XSS prevention)  
✅ Type declarations and validation  
✅ Secure session configuration  
✅ Environment variable isolation  
✅ Security headers via .htaccess  
✅ Input sanitization

### **Recommended Additions**

- Rate limiting (login attempts, API calls)
- Content Security Policy (CSP) header
- HTTPS enforcement in production
- Password hashing (if adding user authentication)
- File upload validation (if adding image uploads)
- API authentication (OAuth2, JWT)

## Migration History

### **Phase 1: Initial Setup** ✅

- Front controller pattern
- Router implementation
- Composer autoloading
- Dotenv configuration

### **Phase 2: Home & Menu** ✅

- HomeController with dynamic hero
- MenuController with repository
- Template system with layout
- Asset management

### **Phase 3: Reservations** ✅

- ReservationsController (CRUD)
- ReservationRepository
- CSRF protection
- Email confirmations

### **Phase 4: Contact** ✅

- ContactController
- PHPMailer integration
- Form validation
- Success/error handling

### **Phase 5: E-Commerce** ✅

- Order/Cart/Checkout controllers
- Session-based cart
- OrderRepository
- Order/order_items schema
- Cart hydration logic
- Tax calculation

### **Phase 6: Enhancements** ✅

- Validator service
- Logger service (Monolog)
- Static assets moved to public/
- Enhanced .htaccess security
- Real-time availability checking

### **Phase 7: Cleanup** ✅

- Removed legacy pages/ directory
- Removed api.php, dbconnect.php
- Updated all asset URLs
- Documentation updates

## Maintenance

### **Regular Tasks**

- Review logs weekly (`logs/app.log`, `logs/error.log`)
- Monitor disk space (logs directory)
- Update Composer dependencies monthly
- Backup database weekly
- Test reservation system functionality

### **Monitoring**

- Check for PHP errors in logs
- Monitor database query performance
- Verify email delivery (contact/reservations)
- Test critical user flows (order, booking)

### **Deployment Checklist**

- [ ] Run migrations on production DB
- [ ] Update `.env` with production values
- [ ] Set `APP_DEBUG=false`
- [ ] Configure SMTP for production
- [ ] Set proper file permissions (logs/ writable)
- [ ] Enable HTTPS and update APP_URL
- [ ] Test all forms (CSRF tokens)
- [ ] Verify asset URLs load correctly
- [ ] Run `composer install --no-dev --optimize-autoloader`

## Code Quality Standards

### **PHP Standards**

- PSR-4 autoloading
- PSR-12 coding style
- Strict types (`declare(strict_types=1);`)
- Type hints on all methods
- DocBlocks for complex logic

### **Database Standards**

- Normalized schema (3NF)
- Foreign keys with constraints
- Meaningful column names
- Migration-based schema changes

### **Security Standards**

- Never trust user input
- Validate on server side
- Escape on output
- Use prepared statements
- HTTPS in production

## Future Roadmap

### **Short Term**

- User authentication (admin panel)
- Order history for customers
- Email receipts for orders
- Reservation reminders (cron job)
- Admin dashboard for orders/reservations

### **Medium Term**

- Payment integration (Stripe)
- Real-time order tracking
- Push notifications
- Mobile app (API first)
- Multi-language support

### **Long Term**

- Loyalty program
- Table management system
- Staff scheduling
- Inventory management
- Analytics dashboard

---

**Document Version:** 2.0  
**Last Updated:** December 1, 2025  
**Status:** Production Ready  
