# Tokyo Bloom Sushi and Grill

**Modern Japanese Restaurant Website with MVC Architecture**

![Status](https://img.shields.io/badge/Status-Production%20Ready-success)
![Mobile](https://img.shields.io/badge/Mobile-Responsive-blue)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4)
![Architecture](https://img.shields.io/badge/Architecture-MVC-orange)

## Project Overview

Tokyo Bloom is a fully-featured, modern Japanese restaurant website built with clean MVC architecture. Features include online ordering with session-based cart, reservation management with real-time availability checking, contact forms with email notifications, and a comprehensive menu system. The site showcases authentic Japanese cuisine with an elegant, responsive design optimized for both desktop and mobile experiences.

---

## Key Features

### **MVC Architecture**

- **Front Controller Pattern** - Single entry point (`public/index.php`)
- **Router** - Clean URL routing with RESTful conventions
- **Controllers** - Business logic separation (Home, Menu, Order, Cart, Checkout, Reservations, Contact)
- **Repositories** - Data access layer with PDO
- **Templates** - Reusable views with layout system
- **Services** - Validation, logging, and utilities
- **Composer Autoloading** - PSR-4 namespacing (`App\` namespace)

### **Security Features**

- CSRF protection on all forms
- Prepared statements (SQL injection prevention)
- Input validation and sanitization
- Environment variables (`.env`) for sensitive data
- Secure session management
- XSS protection headers
- File access restrictions via `.htaccess`

### **Home Page**

- Dynamic hero section with sliding background images
- Comprehensive "About Us" with restaurant history (est. 2018)
- Feature cards highlighting key offerings (Fresh Ingredients, Expert Chefs, Authentic Experience, Private Events)
- Interactive reservation call-to-action
- Dedicated location section with contact information
- Integrated Google Maps for easy directions
- Live operating hours display with open/closed status
- Visual section dividers with gradient effects
- Category quick-jump navigation

### **Menu Page** (Browse-Only)

- **Grid card layout** for easy scanning of all menu items
- Organized by categories (Appetizers, Sushi, Main Courses, Desserts, Drinks)
- Category navigation bar with smooth scroll-to-section
- High-quality food photography
- Detailed descriptions and pricing
- Hover effects and animations
- Call-to-action to order online

### **Order Online Page** (E-Commerce)

- Full shopping cart functionality
- Add items with quantity selection
- Real-time cart updates
- Item-by-item quantity modification
- Individual item removal
- Dynamic price calculations
- Session-based cart persistence
- Detailed product cards with images

### **Shopping Cart**

- Comprehensive order summary
- Update quantities for all items
- Remove individual items
- Clear entire cart option
- Continue shopping functionality
- Prominent checkout button
- Real-time total calculations
- Mobile-optimized table view

### **Checkout Process**

- Professional order review interface
- Customer information form (name, email, phone)
- Delivery address input
- Special instructions field
- Order summary with itemized breakdown
- Visual confirmation page
- Order history (session-based)

### **Reservations System**

- Interactive booking form
- Date and time selection
- Party size specification
- Contact information collection
- Email confirmation
- Reservation management (view/cancel)
- Beautiful confirmation pages
- Database-backed reservation storage

### **Contact Page**

- Styled contact form with dark theme
- Grid layout for clean information display
- Email integration via PHPMailer
- Confirmation page after submission
- Restaurant contact details
- Operating hours reference

---

## Design System

### **Color Palette**

```
Primary Colors:
├─ Crimson Red      #C91818  → Main accent / CTA buttons
├─ Sakura Pink      #F5B7C3  → Highlights / borders
├─ Charcoal Black   #1E1E1E  → Headers / dark sections
└─ Pure White       #FFFFFF  → Text / light backgrounds

Supporting Colors:
├─ Slate Gray       #3A3A3A  → Body text / descriptions
├─ Warm Beige       #F9E8D9  → Page background
└─ Deep Cherry      #A00E1A  → Hover / active states
```

### **Typography**

- **Headings:** Lulo Clean (Bold, Display)
- **Body Text:** Sohne Buch (Regular, Sans-serif)
- **Fallback:** System UI fonts for optimal performance

### **Design Patterns**

- White content cards with soft shadows
- Pink accent borders on interactive elements
- Gradient section dividers
- Rounded corners (8px-18px)
- Smooth hover transitions (0.3s ease)
- Consistent spacing (1rem base unit)

---

## Database Schema

### **orders**

```sql
id                INT PRIMARY KEY AUTO_INCREMENT
customer_name     VARCHAR(255) NOT NULL
customer_email    VARCHAR(255) NOT NULL
customer_phone    VARCHAR(50) NOT NULL
customer_address  TEXT NOT NULL
created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP
```

### **order_items**

```sql
id            INT PRIMARY KEY AUTO_INCREMENT
order_id      INT NOT NULL
item_id       INT NOT NULL
name          VARCHAR(255) NOT NULL
price         DECIMAL(10,2) NOT NULL
quantity      INT NOT NULL
FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
```

### **menu_items**

```sql
id            INT PRIMARY KEY AUTO_INCREMENT
name          VARCHAR(255) NOT NULL
description   TEXT
price         DECIMAL(10,2) NOT NULL
category      VARCHAR(100) NOT NULL
image_url     VARCHAR(255)
created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
```

### **reservations**

```sql
id            INT PRIMARY KEY AUTO_INCREMENT
name          VARCHAR(255) NOT NULL
email         VARCHAR(255) NOT NULL
phone         VARCHAR(20) NOT NULL
date          DATE NOT NULL
time          TIME NOT NULL
guests        INT NOT NULL
created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
```

---

## Technical Stack

### **Frontend**

- HTML5 (Semantic markup)
- CSS3 (Custom properties, Grid, Flexbox)
- Vanilla JavaScript (ES6+)
- Dynamic hero image slider
- Form validation

### **Backend**

- PHP 8.x
- MySQL/MariaDB 10.4+
- PDO for database queries
- Session management
- PHPMailer 6.x (via Composer)
- Composer dependency management
- Monolog logging
- Dotenv for configuration

### **Server**

- Apache (XAMPP)
- mod_rewrite enabled
- PHP mail configuration

---

## Project Structure

```
tokyo-bloom/
├── public/                           # Web root (point Apache here)
│   ├── index.php                     # Front controller
│   ├── .htaccess                     # URL rewriting & security
│   ├── css/
│   │   └── style.css                 # Main stylesheet
│   ├── js/
│   │   └── scripts.js                # Interactive features
│   ├── images/                       # Static assets
│   └── fonts/                        # Custom fonts
├── src/                              # Application code
│   ├── Bootstrap.php                 # Application initialization
│   ├── Router.php                    # URL routing
│   ├── helpers.php                   # Global helper functions
│   ├── Controllers/                  # Request handlers
│   │   ├── Controller.php            # Base controller
│   │   ├── HomeController.php
│   │   ├── MenuController.php
│   │   ├── OrderController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── ReservationsController.php
│   │   └── ContactController.php
│   ├── Repositories/                 # Data access layer
│   │   ├── MenuRepository.php
│   │   ├── OrderRepository.php
│   │   └── ReservationRepository.php
│   ├── Services/                     # Business logic
│   │   ├── Validator.php             # Input validation
│   │   └── Logger.php                # Monolog wrapper
│   └── Database/
│       └── Connection.php            # PDO connection
├── templates/                        # View files
│   ├── layout.php                    # Master layout
│   ├── home.php
│   ├── menu.php
│   ├── order.php
│   ├── cart.php
│   ├── checkout.php
│   ├── checkout_success.php
│   ├── reservations_form.php
│   ├── reservations_success.php
│   ├── reservations_canceled.php
│   ├── contact_form.php
│   └── contact_success.php
├── routes/
│   └── web.php                       # Route definitions
├── database/
│   ├── migrate.php                   # Migration runner
│   └── migrations/
│       ├── 000_create_menu_items.sql
│       ├── 001_create_orders_tables.sql
│       └── 002_create_reservations.sql
├── logs/                             # Application logs
│   ├── app.log                       # General logs
│   └── error.log                     # Error logs
├── vendor/                           # Composer dependencies
├── .env                              # Environment configuration
├── .env.example                      # Environment template
├── composer.json                     # PHP dependencies
├── tokyo_bloom.sql                   # Database dump
└── README.md                         # This file
```

---

## Setup Instructions

### **Prerequisites**

- **XAMPP** (or similar PHP/MySQL environment)
- PHP 8.0 or higher
- MySQL/MariaDB
- Composer (PHP dependency manager)
- Modern web browser

### **Installation**

1. **Clone the repository**

   ```bash
   cd C:\xampp\htdocs\
   git clone https://github.com/merleezy/tokyo-bloom.git
   cd tokyo-bloom
   ```

2. **Import the database**

   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create database: `tokyo_bloom`
   - Import `tokyo_bloom.sql`

   **OR** run migrations:

   ```bash
   C:\xampp\php\php.exe database\migrate.php
   ```

3. **Install PHP dependencies**

   ```bash
   php composer.phar install
   ```

4. **Configure environment variables**

   Copy `.env.example` to `.env`:

   ```bash
   copy .env.example .env
   ```

   Edit `.env` with your settings:

   ```env
   APP_URL=http://localhost/tokyo-bloom/public
   DB_HOST=localhost
   DB_NAME=tokyo_bloom
   DB_USER=root
   DB_PASS=
   MAIL_HOST=localhost
   MAIL_PORT=1025
   MAIL_FROM_ADDRESS=info@tokyobloom.com
   ```

5. **Start XAMPP services**

   - Start Apache
   - Start MySQL

6. **Access the website**
   ```
   http://localhost/tokyo-bloom/public
   ```

### **Important Commands**

```bash
# Install dependencies
composer install

# Run database migrations
C:\xampp\php\php.exe database\migrate.php

# Update dependencies
composer update

# Dump autoload files
composer dump-autoload
```

### **Configuration Notes**

- **Document Root**: Point Apache to `public/` directory for production
- **URL Rewriting**: Requires `mod_rewrite` enabled in Apache
- **PHP Extensions**: Ensure `pdo_mysql`, `mbstring`, `openssl` are enabled
- **Permissions**: Logs directory needs write permissions (755)
- **Email**: Configure SMTP settings in `.env` for contact form
- **Sessions**: PHP session.save_path must be writable

---

## Development

### **Adding New Routes**

Edit `routes/web.php`:

```php
$router->get('/your-route', [YourController::class, 'method']);
$router->post('/your-route', [YourController::class, 'store']);
```

### **Validation Example**

```php
use App\Services\Validator;

$validator = new Validator();
if ($validator->validate($_POST, [
   'name' => 'required|min:2',
   'email' => 'required|email',
   'guests' => 'required|integer|min:1|max:20',
])) {
   // Process valid data
   $errors = $validator->errors();
}
```

### **Logging Example**

```php
use App\Services\Logger;

Logger::info('Order placed', ['order_id' => $orderId]);
Logger::error('Payment failed', ['error' => $e->getMessage()]);
```

---

## API Endpoints

All endpoints are accessed via clean URLs:

- `GET /` - Home page
- `GET /menu` - Menu listing
- `GET /order` - Order page
- `POST /order/add` - Add item to cart
- `GET /cart` - View cart
- `POST /cart/update` - Update cart quantities
- `POST /cart/remove` - Remove cart item
- `POST /cart/clear` - Clear cart
- `GET /checkout` - Checkout form
- `POST /checkout` - Place order
- `GET /reservations` - Reservation form
- `POST /reservations` - Create reservation
- `GET /reservations/confirm` - Confirmation page
- `POST /reservations/cancel` - Cancel reservation
- `GET /contact` - Contact form
- `POST /contact` - Send message

---

## User Workflows

### **Browse & Order**

1. Visit home page
2. Click "Order Online" or navigate to Menu
3. Browse menu items by category
4. Add items to cart with quantity
5. Review cart and update as needed
6. Proceed to checkout
7. Enter delivery information
8. Confirm order

### **Make Reservation**

1. Navigate to Reservations page
2. Fill out form (date, time, party size, contact info)
3. Submit reservation
4. View confirmation with details
5. Option to cancel if needed

### **Contact Restaurant**

1. Navigate to Contact page
2. Fill out contact form
3. Submit message
4. Receive confirmation

---

## Configuration

### **Hours Settings**

Edit in `js/scripts.js`:

```javascript
const hours = {
  monday: { open: "11:00", close: "22:00" },
  // ... etc
};
```

### **Menu Items**

Add items via phpMyAdmin or create a seeder:

```sql
INSERT INTO menu_items (name, description, price, category, image_url)
VALUES ('California Roll', 'Fresh avocado and crab', 12.99, 'Sushi', 'images/menu/california-roll.jpg');
```

### **Images**

- Hero images: `images/`
- Menu items: `images/menu/`
- Store assets in `public/` directory

---

## Troubleshooting

### **CSS/JS Not Loading**

- Check `APP_URL` in `.env` matches your local path
- Verify files exist in `public/css/` and `public/js/`
- Clear browser cache

### **Database Connection Failed**

- Verify MySQL service is running
- Check credentials in `.env`
- Ensure database exists

### **404 on Routes**

- Enable `mod_rewrite` in Apache
- Check `.htaccess` exists in `public/`
- Verify document root points to `public/`

### **CSRF Token Mismatch**

- Ensure sessions are working (check `session.save_path`)
- Clear browser cookies
- Check `csrf_field()` is in all forms

### **Email Not Sending**

- Configure SMTP settings in `.env`
- Check PHP `mail()` configuration
- Test with local mail server (MailHog, Mailpit)

---

**Last Updated:** December 1, 2025  
**Version:** 2.0.0  
**Status:** Production Ready  
**Architecture:** MVC with PSR-4 Autoloading  
