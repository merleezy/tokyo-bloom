# Tokyo Bloom Sushi and Grill

**Modern Japanese Restaurant Website**

![Status](https://img.shields.io/badge/Status-Complete-success)
![Mobile](https://img.shields.io/badge/Mobile-Responsive-blue)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4)

## Project Overview

Tokyo Bloom is a fully-featured, modern Japanese restaurant website with a complete online ordering system, reservation management, and contact features. The site showcases authentic Japanese cuisine with an elegant, user-friendly design optimized for both desktop and mobile experiences.

---

## Key Features

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
- MySQL/MariaDB
- PDO for database queries
- Session management
- PHPMailer for email notifications

### **Server**

- Apache (XAMPP)
- mod_rewrite enabled
- PHP mail configuration

---

## Project Structure

```
tokyo-bloom/
├── pages/
│   ├── index.html                    # Home page
│   ├── menu.php                      # Browse menu (grid view)
│   ├── order.php                     # Order online (with cart)
│   ├── cart.php                      # Shopping cart
│   ├── checkout.php                  # Checkout process
│   ├── reservations.php              # Reservation form
│   ├── reservationsconfirmation.php  # Booking confirmation
│   ├── reservationscancel.php        # Cancel reservation
│   ├── contact.html                  # Contact form
│   ├── contactconfirmation.html      # Message sent confirmation
│   ├── contactsystem.php             # Contact form handler
│   └── reservationssystem.php        # Reservation handler
├── css/
│   └── style.css                     # Main stylesheet (1000+ lines)
├── js/
│   └── scripts.js                    # Interactive features
├── images/
│   ├── menu/                         # Food photography
│   └── [hero images]                 # Background images
├── fonts/
│   ├── LuloCleanW01-OneBold.otf
│   └── Sohne-Buch.otf
├── PHPMailer/                        # Email library
├── dbconnect.php                     # Database connection
├── api.php                           # API endpoints
├── tokyo_bloom.sql                   # Database dump
└── README.md                         # This file
```

---

## Setup Instructions

### **Prerequisites**

- XAMPP (or similar PHP/MySQL environment)
- PHP 8.0 or higher
- MySQL/MariaDB
- Modern web browser

### **Installation**

1. **Clone or download the project**

   ```bash
   cd C:\xampp\htdocs\
   git clone https://github.com/merleezy/tokyo-bloom.git
   ```

2. **Import the database**

   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create database: `tokyo_bloom`
   - Import `tokyo_bloom.sql`

3. **Configure database connection**
   Edit `dbconnect.php`:

   ```php
   $host = 'localhost';
   $dbname = 'tokyo_bloom';
   $username = 'root';
   $password = '';
   ```

4. **Configure PHPMailer** (optional)
   Edit `contactsystem.php` with your SMTP credentials

5. **Start XAMPP services**

   - Start Apache
   - Start MySQL

6. **Access the website**
   ```
   http://localhost/tokyo-bloom/pages/index.html
   ```

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

Managed via MySQL database or phpMyAdmin interface

### **Images**

- Hero images: `images/`
- Menu items: `images/menu/`
- Recommended: WebP or AVIF for performance

---

**Last Updated:** December 1, 2025  
**Version:** 1.0.0  
**Status:** Production Ready 
