# Tokyo Bloom Sushi and Grill

<!-- ![Project Screenshot](path/to/screenshot.png)  -->
<!-- TODO: Add a real image here -->

## Project Overview

Tokyo Bloom is a custom-built, full-stack MVC web application simulating a Japanese restaurant management system. Built using PHP, MySQL, and HTML/CSS/JS to develop and demonstrate a deep understanding of core web development principles and software architecture.  
Features include a home page with Google Maps integration, an online ordering and checkout system, reservation management with real-time availability checking, contact forms with email notifications, and a comprehensive menu system.  

<!-- TODO: Add live demo or video walkthrough -->

## Technical Highlights
*   **Custom MVC Architecture:** Implemented a Front Controller pattern with a custom Router from scratch.
*   **Security First:** Full CSRF protection, PDO prepared statements, and XSS sanitization on all inputs.
*   **RESTful Routing:** Clean URL structure handling dynamic routes and controller dispatching.
*   **Database Design:** Relational MySQL schema managing complex relationships between Orders, Items, and Reservations.

## Tech Stack
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=flat&logo=mysql&logoColor=white)
![HTML](https://img.shields.io/badge/HTML-23628F?style=flat&logo=html5&logoColor=white)
![CSS](https://img.shields.io/badge/CSS-1572B6?style=flat&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630?style=flat&logo=composer&logoColor=white)
![XAMPP](https://img.shields.io/badge/XAMPP-000000?style=flat&logo=xampp&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-000000?style=flat&logo=apache&logoColor=white)
![Git](https://img.shields.io/badge/Git-000000?style=flat&logo=git&logoColor=white)

## Key Challenges and Solutions
*   **Challenge:** [to be added]
*   **Solution:** [to be added]

## Features

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

### **Responsive Design**

- Responsive layout for all pages
- Mobile-optimized navigation
- Touch-friendly buttons and forms
- Hamburger menu for mobile devices
- Proper scaling and spacing for all devices

## Design System

### **Color Palette**

```
Primary Colors:
  Crimson Red      #C91818 -> Main accent / CTA buttons
  Sakura Pink      #F5B7C3 -> Highlights / borders
  Charcoal Black   #1E1E1E -> Headers / dark sections
  Pure White       #FFFFFF -> Text / light backgrounds

Supporting Colors:
  Slate Gray       #3A3A3A -> Body text / descriptions
  Warm Beige       #F9E8D9 -> Page background
  Deep Cherry      #A00E1A -> Hover / active states
```

### **Typography**

```
Primary Font: Lulo Clean
Secondary Font: Sohne Buch
```

## Full Technical Stack

### **Frontend**

- HTML
- CSS
- JavaScript

### **Backend**

- PHP 8.x
- MySQL 10.4+
- PDO for database queries
- Session management
- PHPMailer 6.x (via Composer)
- Composer dependency management
- Monolog logging
- Dotenv for configuration

### **Server**

- Apache (XAMPP)
- mod_rewrite enabled

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

3. **Install PHP dependencies**

   ```bash
   php composer.phar install
   ```

4. **Configure environment variables**

   Copy `.env.example` to `.env`:

   ```bash
   copy .env.example .env
   ```

   Edit `.env` with your settings (if necessary)

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

```

**Last Updated:** December 4, 2025  
**Version:** 2.0.1  
**Status:** In Progress  
**Author (me):** Merleezy  