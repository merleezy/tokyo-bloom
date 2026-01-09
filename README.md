# Tokyo Bloom Sushi and Grill

![Project Gif](doc-img/tokyo-bloom-hero-slider.gif) 

## Project Overview

Tokyo Bloom is a full-stack MVC web application simulating a Japanese restaurant management system. Built using PHP, MySQL, and HTML/CSS/JS to develop and demonstrate a deep understanding of core web development principles and software architecture.  
Features include a home page with Google Maps integration, an online ordering and checkout system, reservation management with real-time availability checking, contact forms with email notifications, and a comprehensive menu system.  

<!-- TODO: Add live demo or video walkthrough -->

## Technical Highlights
*   **MVC Architecture:** Implemented a front controller pattern with a custom router from scratch.
*   **Security:** Full CSRF protection, PDO prepared statements, and XSS sanitization on all inputs.
*   **RESTful Routing:** Clean URL structure handling dynamic routes and controller dispatching.
*   **Database:** Relational MySQL schema managing relationships between Orders, Items, and Reservations.

## Design System (for personal reference)

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

- PHP
- MySQL
- PHPMailer (via Composer)

### **Server**

- Apache

## Setup Instructions

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

5. **Start XAMPP services (or similar tool)**

   - Start Apache
   - Start MySQL

6. **Access the website**
   ```
   http://localhost/tokyo-bloom/public
   ```
