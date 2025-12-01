# Tokyo Bloom - Interview Preparation Guide

## Table of Contents

1. [Project Overview](#project-overview)
2. [Tech Stack Summary](#tech-stack-summary)
3. [Architectural Concepts](#architectural-concepts)
4. [Security Implementation](#security-implementation)
5. [Design Patterns](#design-patterns)
6. [Database Architecture](#database-architecture)
7. [Development Practices](#development-practices)
8. [Interview Talking Points](#interview-talking-points)
9. [Practice Questions & Answers](#practice-questions--answers)

---

## Project Overview

**Tokyo Bloom** is a full-stack restaurant web application built with vanilla PHP 8, featuring reservation management, online ordering, cart functionality, and contact forms. The project demonstrates production-ready architecture with security best practices, proper separation of concerns, and modern PHP development standards.

**Key Features:**

- Table reservation system with email confirmations
- Online menu ordering with shopping cart
- Contact form with email notifications
- Admin-ready logging infrastructure
- CSRF protection on all forms
- SQL injection prevention via prepared statements
- XSS protection through output escaping

---

## Tech Stack Summary

### Backend

- **PHP 8.0+** with strict types and modern syntax
- **Composer** for dependency management and PSR-4 autoloading
- **Monolog 2.x** for application logging (rotating files, 7-day retention)
- **PHPMailer 6.x** for transactional emails
- **phpdotenv** for environment configuration

### Database

- **MySQL 8.0 / MariaDB 10.4+**
- Database migrations for version control
- Foreign keys with CASCADE deletes
- Normalized schema (menu_items, orders, order_items, reservations)

### Frontend

- Vanilla **JavaScript** (ES6+)
- **CSS3** with custom styling
- Responsive design
- Hero image slider with smooth transitions

### Infrastructure

- **Apache 2.4** with mod_rewrite
- `.htaccess` security headers and URL rewriting
- Public webroot pattern (`public/` directory)
- Session-based state management

---

## Architectural Concepts

### 1. MVC Architecture (Model-View-Controller)

**What it is:**
A design pattern that separates application logic into three interconnected components:

- **Model** (Repositories): Data access layer
- **View** (Templates): Presentation layer
- **Controller**: Business logic and request handling

**How I implemented it:**

```
src/Controllers/     → Handle HTTP requests, orchestrate logic
src/Repositories/    → Database queries using PDO
templates/           → PHP templates for HTML rendering
```

**Why this matters:**

- Separation of concerns makes code maintainable
- Each layer can be modified independently
- Teams can work on different layers simultaneously
- Easier to test individual components

**Interview talking point:**
"I used MVC to keep my business logic separate from presentation. For example, `CartController` handles cart operations while `templates/cart.php` focuses purely on display. This meant when I needed to change the cart UI, I didn't touch any business logic."

---

### 2. Front Controller Pattern

**What it is:**
A single entry point (`public/index.php`) handles ALL HTTP requests and routes them to appropriate controllers.

**How I implemented it:**

```php
// public/index.php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/helpers.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Start session for cart and CSRF
session_start();

// Route the request
$router = new App\Router();
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
```

**Why this matters:**

- Centralizes request handling
- Enables consistent security checks (session start, CSRF)
- Makes logging and debugging easier
- Allows middleware pattern (authentication, rate limiting)

**Interview talking point:**
"Every request goes through `public/index.php`, which gives me a single place to initialize dependencies, start sessions, and apply security middleware. This is how modern frameworks like Laravel work under the hood."

---

### 3. Custom Router

**What it is:**
Maps HTTP requests (method + URI) to specific controller actions.

**How I implemented it:**

```php
// src/Router.php
public function get($path, $controller, $method) {
    $this->routes['GET'][$path] = [$controller, $method];
}

public function post($path, $controller, $method) {
    $this->routes['POST'][$path] = [$controller, $method];
}

public function dispatch($requestMethod, $requestUri) {
    // Match route and invoke controller method
}
```

**Registration example:**

```php
$router->get('/', HomeController::class, 'index');
$router->get('/menu', OrderController::class, 'index');
$router->post('/cart/add', CartController::class, 'add');
```

**Why this matters:**

- RESTful URL design
- Clear mapping between URLs and code
- Easy to add new routes without .htaccess changes
- Supports HTTP verb-based routing

**Interview talking point:**
"I built a custom router that maps clean URLs like `/cart/add` to controller methods. It respects HTTP verbs—GET for display, POST for actions. This is the foundation of how routing works in frameworks like Symfony."

---

### 4. PSR-4 Autoloading

**What it is:**
PHP Standard Recommendation for autoloading classes based on namespace and directory structure.

**How I implemented it:**

```json
// composer.json
"autoload": {
    "psr-4": {
        "App\\": "src/"
    }
}
```

This means:

- `App\Controllers\CartController` → `src/Controllers/CartController.php`
- `App\Repositories\MenuRepository` → `src/Repositories/MenuRepository.php`

**Why this matters:**

- No manual `require` statements
- Classes load automatically when first used
- Industry standard (used by Laravel, Symfony, WordPress packages)
- Clean, predictable file organization

**Interview talking point:**
"I used PSR-4 autoloading with Composer, so I never write `require` for my own classes. This is the standard in modern PHP—it's how packages on Packagist work together."

---

### 5. Repository Pattern

**What it is:**
Centralizes all database queries in dedicated Repository classes, abstracting data access from business logic.

**How I implemented it:**

```php
// src/Repositories/MenuRepository.php
class MenuRepository {
    private $db;

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM menu_items WHERE available = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM menu_items WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
```

**Why this matters:**

- Controllers don't write SQL queries
- Database logic is reusable
- Easier to swap databases or add caching
- Testable with mock repositories

**Interview talking point:**
"I used the Repository pattern to separate data access from business logic. `MenuRepository` handles all menu queries, so if I need to add Redis caching or switch to PostgreSQL, I only change one file."

---

### 6. CSRF Protection (Cross-Site Request Forgery)

**What it is:**
Security mechanism that prevents malicious websites from submitting forms on behalf of authenticated users.

**How I implemented it:**

```php
// Generate token (in session)
function csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Output hidden field
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

// Verify submission
function csrf_verify() {
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}
```

**Usage in forms:**

```php
<form method="POST" action="/cart/add">
    <?php echo csrf_field(); ?>
    <!-- other fields -->
</form>
```

**Usage in controllers:**

```php
if (!csrf_verify()) {
    Logger::warning('CSRF verification failed');
    return $this->redirect('/');
}
```

**Why this matters:**

- Prevents unauthorized form submissions
- Required for PCI compliance
- Standard security practice (Laravel, Django, Rails all use it)
- Uses `hash_equals()` to prevent timing attacks

**Interview talking point:**
"Every form in Tokyo Bloom includes a CSRF token. When a user submits a reservation, I verify the token server-side using timing-safe comparison. This prevents attackers from tricking users into submitting forms from malicious sites."

---

### 7. SQL Injection Prevention

**What it is:**
Preventing attackers from manipulating database queries by injecting malicious SQL code.

**How I implemented it:**

```php
// ❌ VULNERABLE (never do this)
$sql = "SELECT * FROM menu_items WHERE id = " . $_POST['id'];

// ✅ SECURE (always use prepared statements)
$stmt = $this->db->prepare("SELECT * FROM menu_items WHERE id = ?");
$stmt->execute([$_POST['id']]);
```

**100% coverage:**

- Every query uses PDO prepared statements
- User input NEVER concatenated into SQL
- Named or positional placeholders for all variables

**Why this matters:**

- #1 web application vulnerability (OWASP Top 10)
- Can lead to data breaches, data loss
- PDO automatically escapes input
- Required for any production application

**Interview talking point:**
"I prevent SQL injection by using PDO prepared statements for every single query. User input goes through placeholders, never string concatenation. This is non-negotiable for security."

---

### 8. XSS Prevention (Cross-Site Scripting)

**What it is:**
Preventing attackers from injecting malicious JavaScript into pages viewed by other users.

**How I implemented it:**

```php
// In templates - always escape output
<h1><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
<p><?php echo htmlspecialchars($reservation['name'], ENT_QUOTES, 'UTF-8'); ?></p>
```

**Strategy:**

- Escape ALL user-generated content on output
- Use `htmlspecialchars()` with ENT_QUOTES flag
- Never trust user input (even from database)

**Why this matters:**

- Prevents JavaScript injection attacks
- Protects users from session hijacking
- Required for secure applications
- Default in modern frameworks (Laravel Blade auto-escapes)

**Interview talking point:**
"I prevent XSS by escaping all user-generated content with `htmlspecialchars()`. Even data from the database gets escaped because I follow the principle: never trust input, always sanitize output."

---

### 9. Session Management

**What it is:**
Server-side storage that persists user data across HTTP requests (which are stateless by default).

**How I implemented it:**

```php
// Started in public/index.php
session_start();

// Cart storage
$_SESSION['cart'][$item_id] = $quantity;  // Store as [id => qty]

// CSRF token storage
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Flash messages
$_SESSION['success'] = 'Order placed successfully!';
```

**Why this matters:**

- Enables shopping cart persistence
- Stores CSRF tokens securely
- No need for cookies or local storage
- Server-side = more secure than client-side

**Interview talking point:**
"I use PHP sessions to store the cart server-side. When a user adds an item, it's stored as `$_SESSION['cart'][$id] = $quantity`. This is more secure than cookies and persists until checkout."

---

### 10. Cart Hydration Pattern

**What it is:**
Converting lightweight session data (just IDs and quantities) into full item details by querying the database.

**How I implemented it:**

```php
// Session cart (lightweight)
$_SESSION['cart'] = [
    5 => 2,   // item_id => quantity
    12 => 1
];

// Hydrate into full details
private function hydrateCart() {
    $sessionCart = $_SESSION['cart'] ?? [];
    $cartItems = [];

    foreach ($sessionCart as $itemId => $quantity) {
        $item = $this->menuRepo->findById($itemId);
        if ($item) {
            $item['quantity'] = $quantity;
            $item['subtotal'] = $item['price'] * $quantity;
            $cartItems[] = $item;
        }
    }

    return $cartItems;
}
```

**Why this matters:**

- Sessions stay small (just IDs)
- Prices/names always fresh from database
- Prevents price manipulation
- Clear separation of storage vs. presentation

**Interview talking point:**
"The session stores minimal data—just item IDs and quantities. When displaying the cart, I 'hydrate' it by fetching current prices from the database. This prevents users from manipulating prices in session storage."

---

### 11. Environment Configuration (Dotenv)

**What it is:**
Storing configuration (database credentials, API keys) in `.env` file instead of hardcoding in source code.

**How I implemented it:**

```php
// .env (not committed to Git)
DB_HOST=localhost
DB_NAME=tokyo_bloom
DB_USER=root
DB_PASS=secret
APP_URL=http://localhost/tokyo-bloom
MAIL_FROM=noreply@tokyobloom.com

// Load in public/index.php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Access anywhere
$host = $_ENV['DB_HOST'];
$appUrl = $_ENV['APP_URL'];
```

**.gitignore entry:**

```
.env
```

**Why this matters:**

- Secrets never committed to version control
- Different configs for dev/staging/production
- Industry standard (Laravel, Node.js, Python all use it)
- Easy to change without code modifications

**Interview talking point:**
"I use phpdotenv to keep secrets out of Git. Database credentials and API keys live in `.env`, which is gitignored. This is the standard approach—you'll see it in Laravel, Express, Django, everywhere."

---

### 12. Database Migrations

**What it is:**
Version-controlled SQL scripts that create/modify database schema, allowing reproducible database setup.

**How I implemented it:**

```sql
-- tokyo_bloom.sql
CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100),
    available BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20),
    total DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id)
);
```

**Why this matters:**

- Database schema is version controlled
- New developers can set up DB instantly
- Easy to see schema evolution over time
- Required for team development

**Interview talking point:**
"I created a migration file that defines the entire database schema. Any developer can clone the repo, run the migration, and have an identical database structure. This is essential for team collaboration."

---

### 13. Application Logging (Monolog)

**What it is:**
Systematic recording of application events for debugging, auditing, and monitoring.

**How I implemented it:**

```php
// src/Services/Logger.php
use Monolog\Logger as MonologLogger;
use Monolog\Handler\RotatingFileHandler;

class Logger {
    private static $logger = null;

    private static function getLogger() {
        if (self::$logger === null) {
            self::$logger = new MonologLogger('tokyo-bloom');

            // Main log: rotates daily, keeps 7 days
            $mainHandler = new RotatingFileHandler(
                __DIR__ . '/../../logs/app.log',
                7,
                MonologLogger::DEBUG
            );

            // Error log: only errors and above
            $errorHandler = new RotatingFileHandler(
                __DIR__ . '/../../logs/error.log',
                7,
                MonologLogger::ERROR
            );

            self::$logger->pushHandler($mainHandler);
            self::$logger->pushHandler($errorHandler);
        }

        return self::$logger;
    }

    public static function info($message, array $context = []) {
        self::getLogger()->info($message, $context);
    }

    public static function warning($message, array $context = []) {
        self::getLogger()->warning($message, $context);
    }

    public static function error($message, array $context = []) {
        self::getLogger()->error($message, $context);
    }
}
```

**Usage in controllers:**

```php
// Log CSRF failures
Logger::warning('CSRF verification failed', [
    'controller' => 'CartController',
    'action' => 'add'
]);

// Log successful operations
Logger::info('Item added to cart', [
    'item_id' => $itemId,
    'quantity' => $quantity,
    'total_items' => count($_SESSION['cart'])
]);

// Log errors
Logger::error('Database error creating order', [
    'error' => $e->getMessage(),
    'customer' => $validatedData['customer_name']
]);
```

**Why this matters:**

- Production debugging without var_dump
- Audit trail for compliance
- Performance monitoring
- Automatic log rotation (prevents disk fill)

**Interview talking point:**
"I integrated Monolog for production-ready logging. All cart operations, CSRF failures, and database errors are logged with context. Logs rotate daily and keep 7 days. This is how you debug production issues without disturbing users."

---

### 14. Input Validation Service

**What it is:**
Centralized validation logic with fluent API for consistent data validation across controllers.

**How I implemented it:**

```php
// src/Services/Validator.php
class Validator {
    private $data = [];
    private $rules = [];
    private $errors = [];

    public function __construct($data) {
        $this->data = $data;
    }

    public function field($name) {
        $this->currentField = $name;
        return $this;
    }

    public function required() {
        if (empty($this->data[$this->currentField])) {
            $this->errors[$this->currentField] = "This field is required";
        }
        return $this;
    }

    public function email() {
        if (!filter_var($this->data[$this->currentField], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$this->currentField] = "Invalid email format";
        }
        return $this;
    }

    public function validate() {
        return empty($this->errors);
    }

    public function errors() {
        return $this->errors;
    }
}
```

**Usage:**

```php
$validator = new Validator($_POST);
$validator->field('name')->required()
          ->field('email')->required()->email()
          ->field('phone')->required();

if (!$validator->validate()) {
    $errors = $validator->errors();
    return $this->render('contact_form', ['errors' => $errors]);
}
```

**Why this matters:**

- Consistent validation across all forms
- Fluent API is readable and maintainable
- Centralized error messages
- Easy to add new validation rules

**Interview talking point:**
"I built a Validator service with a fluent API. Instead of if-statements scattered across controllers, I chain validation rules: `->field('email')->required()->email()`. This keeps validation logic centralized and testable."

---

### 15. Asset URL Management

**What it is:**
Centralized functions for generating URLs to CSS, JS, and images, handling environment differences (dev/production).

**How I implemented it:**

```php
// src/helpers.php
function base_url($path = '') {
    $appUrl = rtrim($_ENV['APP_URL'], '/');
    return $appUrl . '/' . ltrim($path, '/');
}

function asset_url($path = '') {
    return base_url('public/' . ltrim($path, '/'));
}
```

**Usage in templates:**

```php
<!-- CSS -->
<link rel="stylesheet" href="<?php echo asset_url('css/style.css'); ?>">

<!-- JS -->
<script src="<?php echo asset_url('js/scripts.js'); ?>"></script>

<!-- Images -->
<img src="<?php echo asset_url('images/sushi-plate.avif'); ?>">

<!-- Links -->
<a href="<?php echo base_url('/menu'); ?>">View Menu</a>
```

**JavaScript integration:**

```php
<!-- Inject base URL for JS -->
<script>
    window.ASSET_BASE = "<?php echo rtrim(asset_url(''), '/'); ?>/";
</script>
```

```javascript
// Use in JS
const images = [
  ASSET_BASE + "images/sushi_background.avif",
  ASSET_BASE + "images/kitchen-interior.avif",
];
```

**Why this matters:**

- Environment-agnostic code
- Easy to switch from localhost to production
- CDN integration becomes trivial
- No hardcoded URLs in templates

**Interview talking point:**
"I created helper functions for URL generation so there are no hardcoded paths. `asset_url('css/style.css')` works in dev and production because it reads from `.env`. This makes deployment seamless."

---

### 16. URL Rewriting (.htaccess)

**What it is:**
Apache configuration that routes all requests through `public/index.php` while allowing static files to be served directly.

**How I implemented it:**

```apache
# public/.htaccess
RewriteEngine On

# If file/directory exists, serve it directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# Otherwise, route through index.php
RewriteRule ^(.*)$ index.php [QSA,L]

# Security headers
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "SAMEORIGIN"
Header set X-XSS-Protection "1; mode=block"
```

**Root .htaccess (redirect to public/):**

```apache
# .htaccess (root)
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(.*)$ public/$1 [L]
```

**Why this matters:**

- Clean URLs (`/menu` instead of `/public/index.php?route=menu`)
- Security headers protect against common attacks
- Static assets served efficiently by Apache
- Standard pattern for PHP applications

**Interview talking point:**
"I configured Apache URL rewriting so all requests go through `public/index.php` unless they're static files. This enables clean URLs and adds security headers. It's the same pattern Symfony and Laravel use."

---

### 17. Helper Functions

**What it is:**
Global utility functions available throughout the application for common tasks.

**How I implemented it:**

```php
// src/helpers.php (loaded in public/index.php)

// URL helpers
function base_url($path = '') { /* ... */ }
function asset_url($path = '') { /* ... */ }

// CSRF helpers
function csrf_token() { /* ... */ }
function csrf_field() { /* ... */ }
function csrf_verify() { /* ... */ }

// Utility helpers
function redirect($url) {
    header("Location: " . base_url($url));
    exit;
}

function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}
```

**Why this matters:**

- DRY principle (Don't Repeat Yourself)
- Consistent behavior across application
- Easy to update globally
- Common in frameworks (Laravel has 100+ helpers)

**Interview talking point:**
"I created helper functions for repetitive tasks like `redirect()` and `csrf_field()`. This keeps controllers clean and ensures consistency. Laravel popularized this pattern—it's practical and maintainable."

---

### 18. Foreign Key Constraints with CASCADE

**What it is:**
Database-level relationships that automatically maintain referential integrity and clean up related records.

**How I implemented it:**

```sql
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,

    -- Foreign keys with CASCADE
    FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE CASCADE,

    FOREIGN KEY (menu_item_id)
        REFERENCES menu_items(id)
        ON DELETE RESTRICT
);
```

**What CASCADE does:**

- `ON DELETE CASCADE`: When order is deleted, all its order_items automatically delete
- `ON DELETE RESTRICT`: Prevents deleting menu_item if orders reference it

**Why this matters:**

- Data integrity enforced at database level
- No orphaned records
- Prevents bugs from manual cleanup code
- Required for production databases

**Interview talking point:**
"I used foreign keys with CASCADE deletes. When an order is deleted, all its order_items automatically delete too. This prevents orphaned records and enforces referential integrity at the database level, which is more reliable than application code."

---

## Security Implementation

### Defense-in-Depth Strategy

Tokyo Bloom implements multiple security layers:

1. **Input Validation**

   - All form inputs validated with Validator service
   - Type checking (email, phone, numeric)
   - Required field enforcement

2. **CSRF Protection**

   - Tokens on all POST forms
   - Timing-safe comparison with `hash_equals()`
   - Regenerated per session

3. **SQL Injection Prevention**

   - 100% PDO prepared statements
   - No raw SQL concatenation
   - Parameterized queries only

4. **XSS Prevention**

   - All output escaped with `htmlspecialchars()`
   - ENT_QUOTES flag for attribute protection
   - Never trust database content

5. **Session Security**

   - HTTPOnly cookies (default in PHP)
   - Server-side storage
   - Session regeneration on login (if auth added)

6. **Error Handling**

   - Production errors logged, not displayed
   - Generic error messages to users
   - Stack traces hidden from output

7. **Security Headers**
   - X-Content-Type-Options: nosniff
   - X-Frame-Options: SAMEORIGIN
   - X-XSS-Protection: 1; mode=block

---

## Design Patterns

### Patterns Implemented

1. **MVC (Model-View-Controller)**

   - Separation of data, logic, and presentation

2. **Front Controller**

   - Single entry point for all requests

3. **Repository Pattern**

   - Data access abstraction

4. **Service Layer**

   - Shared business logic (Logger, Validator)

5. **Template Method**

   - Base Controller with shared render/redirect

6. **Dependency Injection**

   - Repositories injected into controllers

7. **Singleton (Logger)**
   - Single logger instance shared globally

---

## Database Architecture

### Schema Overview

**Tables:**

1. **menu_items** - Restaurant menu with prices and availability
2. **orders** - Customer orders with contact info and totals
3. **order_items** - Line items linking orders to menu items
4. **reservations** - Table reservations with date/time/guests

**Relationships:**

- `orders` → `order_items` (one-to-many, CASCADE delete)
- `menu_items` → `order_items` (one-to-many, RESTRICT delete)

**Indexing Strategy:**

- Primary keys on all tables (AUTO_INCREMENT)
- Foreign key indexes automatically created
- Consider adding index on `reservations.reservation_date` for queries

**Data Integrity:**

- NOT NULL constraints on required fields
- DECIMAL(10,2) for precise currency values
- TIMESTAMP for audit trails
- BOOLEAN for flags (available, confirmed)

---

## Development Practices

### Code Quality Standards

1. **Strict Types**

   ```php
   declare(strict_types=1);
   ```

   - All files use strict type checking
   - Prevents type coercion bugs

2. **Type Declarations**

   ```php
   public function findById(int $id): ?array
   ```

   - Return types on all methods
   - Parameter types declared

3. **PSR Standards**

   - PSR-4 autoloading
   - PSR-3 logging interface (Monolog)
   - Following PSR-12 code style (consider adding PHP_CodeSniffer)

4. **Error Handling**

   - Try-catch blocks around database operations
   - Logged errors with context
   - User-friendly error messages

5. **Documentation**
   - README.md with setup instructions
   - ARCHITECTURE.md with technical details
   - Code comments for complex logic

---

## Interview Talking Points

### 1. Project Complexity

"Tokyo Bloom demonstrates full-stack capabilities—I built a custom MVC framework with routing, implemented security best practices like CSRF and prepared statements, integrated third-party services like PHPMailer and Monolog, and created a shopping cart with session management."

### 2. Security Focus

"Security was a priority. I implemented CSRF tokens on all forms using timing-safe comparison, prevented SQL injection with PDO prepared statements, escaped all output to prevent XSS, and added security headers via .htaccess."

### 3. Modern PHP Practices

"I used PHP 8 with strict types, Composer for dependency management, PSR-4 autoloading, and phpdotenv for configuration. This is how modern PHP is written—it's closer to Laravel than legacy PHP."

### 4. Design Patterns

"I applied several design patterns: MVC for separation of concerns, Repository pattern for data access, Front Controller for request handling, and Service Layer for shared logic like logging and validation."

### 5. Scalability Considerations

"The architecture is ready to scale. I can add Redis caching in repositories, implement a queue for emails, add admin authentication middleware, and optimize with database indexing—all without major refactoring."

### 6. Problem-Solving Examples

"When the cart remove button failed, I diagnosed it as nested forms (invalid HTML). I refactored to use HTML5's `formaction` attribute, which reuses the parent form's CSRF token. This required understanding both HTML standards and security implications."

### 7. Production Readiness

"I implemented production-grade logging with Monolog (rotating files, 7-day retention), environment-based configuration, database migrations for reproducibility, and comprehensive error handling. This isn't a toy app—it's deployable."

### 8. Learning & Growth

"This project taught me that security is non-negotiable, proper architecture saves time later, and understanding fundamentals (like routing and sessions) makes learning frameworks much easier."

---

## Practice Questions & Answers

### Technical Questions

**Q: How does your routing system work?**
**A:** "Every request goes through `public/index.php`, which loads the Router. The router matches the HTTP method and URI against registered routes (like `POST /cart/add`), then instantiates the appropriate controller and calls its method. Static assets bypass routing via .htaccess conditions."

**Q: How do you prevent SQL injection?**
**A:** "I use PDO prepared statements for every database query. User input goes through placeholders—either positional (`?`) or named (`:id`)—which PDO escapes automatically. I never concatenate user input into SQL strings."

**Q: Explain your cart implementation.**
**A:** "The cart is stored in `$_SESSION['cart']` as an array mapping item IDs to quantities. When displaying the cart, I 'hydrate' it by fetching full item details from the database. This keeps sessions small and ensures prices are always current from the database, preventing price manipulation."

**Q: What's the difference between base_url() and asset_url()?**
**A:** "`base_url()` is for internal links like `/menu` or `/cart`. `asset_url()` is for static assets and includes the `/public` directory, like `public/css/style.css`. Both read from `APP_URL` in .env, so they work in any environment."

**Q: How does CSRF protection work?**
**A:** "When a session starts, I generate a random 32-byte token and store it in `$_SESSION['csrf_token']`. Every form includes this token as a hidden field via `csrf_field()`. On submission, I verify it matches using `hash_equals()` to prevent timing attacks. Mismatches are logged and rejected."

**Q: Why use the Repository pattern?**
**A:** "It separates data access from business logic. Controllers don't write SQL—they call repository methods like `findById()` or `create()`. This makes the code testable (I can mock repositories) and maintainable (changing queries doesn't affect controllers)."

**Q: How do you handle errors in production?**
**A:** "I wrap risky operations in try-catch blocks, log exceptions with Monolog (including context like user IDs), and show generic error messages to users. Stack traces never reach the browser. The `error.log` file gives me detailed debugging info."

**Q: What's the benefit of PSR-4 autoloading?**
**A:** "No manual `require` statements. Classes load automatically when first used, based on namespace-to-directory mapping. This is the standard in modern PHP—it's how Composer packages work, and it makes codebases much cleaner."

### Behavioral Questions

**Q: Tell me about a challenging bug you fixed.**
**A:** "The contact form was rejecting all submissions with CSRF errors. I debugged by logging the POST data and session, and found the form sent `_token` but the controller checked for `csrf_token`. I aligned them and updated all controllers to use consistent naming. This taught me the importance of standardized helpers."

**Q: How do you ensure code quality?**
**A:** "I use strict types in PHP 8, declare return types on all methods, follow PSR-4 standards, write descriptive variable names, and implement comprehensive logging. I also document architecture decisions in markdown files for future maintainers."

**Q: Describe your development workflow.**
**A:** "I start by understanding requirements, then design the database schema. I implement features incrementally—controllers, repositories, templates—testing each part. I use Git for version control and write documentation as I go. For debugging, I rely on logs rather than var_dump in production code."

**Q: How do you approach learning new technologies?**
**A:** "I build projects like Tokyo Bloom. Reading docs is helpful, but implementing concepts like MVC, routing, and security from scratch teaches me _why_ frameworks make certain choices. Now when I use Laravel, I understand what's happening under the hood."

---

## Key Achievements Summary

### Technical Implementation

✅ Custom MVC framework with routing and dependency injection  
✅ Repository pattern for data access abstraction  
✅ CSRF protection with timing-safe comparison  
✅ SQL injection prevention via PDO prepared statements  
✅ XSS protection with output escaping  
✅ Session-based cart with hydration pattern  
✅ Production logging with Monolog (rotating files)  
✅ Input validation service with fluent API  
✅ Environment configuration with phpdotenv  
✅ Database migrations with foreign key constraints  
✅ Email integration with PHPMailer  
✅ Apache URL rewriting with security headers  
✅ PSR-4 autoloading with Composer  
✅ Strict types and modern PHP 8 syntax

### Business Features

✅ Table reservation system with email confirmations  
✅ Online ordering with shopping cart  
✅ Menu display with categories and availability  
✅ Contact form with email notifications  
✅ Order persistence with line items  
✅ Reservation cancellation workflow

### Production Readiness

✅ Comprehensive error handling and logging  
✅ Security best practices throughout  
✅ Environment-agnostic configuration  
✅ Database schema version control  
✅ Documentation for developers  
✅ Clean, maintainable codebase

---

## Final Interview Script

**"Tell me about Tokyo Bloom."**

"Tokyo Bloom is a full-stack restaurant web application I built with vanilla PHP 8 to demonstrate production-ready architecture and security practices. It features online ordering with a shopping cart, table reservations with email confirmations, and a contact form.

What makes it interesting from an engineering perspective is that I built it from scratch—no framework. I implemented a custom MVC architecture with routing, created a Repository pattern for data access, and built services for logging and validation.

Security was a major focus. I implemented CSRF protection on all forms, prevented SQL injection with PDO prepared statements, and added XSS protection through output escaping. I also integrated Monolog for production logging with rotating files.

The cart system is particularly interesting—I use sessions to store item IDs and quantities, then 'hydrate' the cart by fetching current prices from the database. This keeps sessions small and prevents price manipulation.

I used modern PHP practices throughout: Composer for dependencies, PSR-4 autoloading, strict types, phpdotenv for configuration, and Apache URL rewriting with security headers.

The project taught me that proper architecture pays off, security is non-negotiable, and understanding fundamentals makes learning frameworks much easier. It's deployable as-is, and the architecture would scale with Redis caching, queue-based emails, and admin authentication."

---

## Resources for Continued Learning

### Books

- _PHP Objects, Patterns, and Practice_ by Matt Zandstra
- _Modern PHP_ by Josh Lockhart
- _Refactoring_ by Martin Fowler

### Online Resources

- PHP: The Right Way (phptherightway.com)
- OWASP Top 10 (owasp.org)
- PSR Standards (php-fig.org)

### Next Steps

- Add unit tests with PHPUnit
- Implement admin panel with authentication
- Add Redis caching for menu items
- Deploy to production with HTTPS
- Set up CI/CD pipeline with GitHub Actions
- Add code quality tools (PHP_CodeSniffer, PHPStan)

---

_This guide is a living document. Update it as you add features, refactor code, or learn new concepts._
