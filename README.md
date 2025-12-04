# Tokyo Bloom Sushi and Grill

## Project Overview

Tokyo Bloom is a fully-featured, modern Japanese restaurant. Features include a home page with Google Maps integration, an online ordering and checkout system, reservation management with real-time availability checking, contact forms with email notifications, and a comprehensive menu system.  
Made as part of a school project/learning experience.

## Key Features

### **MVC Architecture**

- **Front Controller Pattern** - Single entry point
- **Router** - Clean URL routing with RESTful conventions
- **Controllers** - Business logic separation (Home, Menu, Order, Cart, Checkout, Reservations, Contact)
- **Repositories** - Data access layer with PDO
- **Templates** - Reusable views with layout system
- **Services** - Validation, logging, and utilities
- **Composer Autoloading** - PSR-4 namespacing

### **Security Features**

- CSRF protection on all forms
- Prepared statements (SQL injection prevention)
- Input validation and sanitization
- Environment variables for sensitive data
- Secure session management
- XSS protection headers
- File access restrictions via .htaccess

### **Home Page**

- Dynamic hero section with sliding background images
- Comprehensive "About Us" with restaurant history
- Feature cards highlighting key offerings
- Interactive reservation call-to-action
- Dedicated location section with contact information
- Integrated Google Maps for easy directions
- Live operating hours display with open/closed status
- Visual section dividers with gradient effects
- Category quick-jump navigation

### **Menu Page**

- Grid card layout for easy scanning of all menu items
- Organized by categories
- Category navigation bar with smooth scroll-to-section
- Hover effects and animations
- Call-to-action to order online

### **Order Online Page**

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
- Customer information form
- Delivery address input
- Special instructions field
- Order summary with itemized breakdown
- Visual confirmation page
- Order history

### **Reservations System**

- Interactive booking form
- Date and time selection
- Party size specification
- Contact information collection
- Email confirmation
- Reservation management
- Database-backed reservation storage

### **Contact Page**

- Grid layout for clean information display
- Email integration via PHPMailer
- Confirmation page after submission
- Restaurant contact details
- Operating hours reference

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

- HTML
- CSS
- JavaScript

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

## Setup Instructions

### **Prerequisites**

- XAMPP (or similar PHP/MySQL environment)
- PHP 8.0 or higher
- MySQL
- Composer
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

## Troubleshooting

### **CSS/JS Not Loading**

- Check `APP_URL` in `.env` matches your local path
- Verify files exist in `public/css/` and `public/js/`
- Clear browser cache

### **Database Connection Failed**

- Verify MySQL service is running
- Check credentials in `.env`
- Ensure database exists

---

**Last Updated:** December 1, 2025  
**Version:** 2.0.0  
**Status:** Complete
