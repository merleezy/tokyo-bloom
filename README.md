# Tokyo Bloom
Topic: Japanese Restaurant Website  
Site Name: Tokyo Bloom  
Due Date: December 1, 2025  

## Pages:
  - [ ] Home
  - [ ] Menu
  - [ ] Order Online
  - [ ] Reservations
  - [ ] Contact

### Home Page
  - [x] about section
    - [ ] mention reviews and history
  - [x] reservation section
    - [x] link to reservations page
  - [x] hours section
    - [ ] JS script to show "Open Now" or "Closed" based on current time
  - [ ] add an image carousel that switches images every 5 secs
  - [x] footer
    - [ ] add address information
    - [x] copyright info

### Menu Page
  - [ ] Store menu items in a table in MySQL
  - [ ] Write PHP with MySQL to create DB, table, and read/write to it
  - [ ] Display menu items dynamically from DB

### Online Order Page
  - [ ] Implement online ordering system
    - [ ] Read menu items from DB
    - [ ] Display items with "Add to Cart" buttons
    - [ ] Allow users to add items to a cart, view cart, and checkout

### Reservations Page
  - [ ] Make time, and number of guests drop down menus (30 min increments)
  - [x] Separate by personal info (left side) and reservation info (right side)
  - [ ] Implement / figure out logic for backend
    - [ ] Ability to cancel a reservation and have it appear back in the list of available times
    - [ ] Can't reserve the same time spot twice
    - [ ] When you reserve a spot, that time disappears from the list for other users
    - [ ] Confirmation page after submission with reservation details

### Contact Page
  - [ ] Contact form with name, email, subject, message


Use WebP or AVIF image files for better performance.

## Database Schema
### Menu Items Table
  - id (INT, Primary Key, Auto Increment)
  - name (VARCHAR)
  - description (TEXT)
  - price (DECIMAL)
  - category (VARCHAR) — e.g., Appetizers, Main Courses, Desserts, Drinks
  - image_url (VARCHAR)

### Reservations Table
  - id (INT, Primary Key, Auto Increment)
  - name (VARCHAR)
  - email (VARCHAR)
  - phone (VARCHAR)
  - date (DATE)
  - time (TIME)
  - guests (INT)

## Style Guide
### Primary Colors
Crimson Red — #C91818 → main accent / logo red  
Sakura Pink — #F5B7C3 → soft highlight / hover or subtle background  
Charcoal Black — #1E1E1E → main background or nav bar  
Pure White — #FFFFFF → text or contrasting sections  

### Secondary / Supporting Colors
Slate Gray — #3A3A3A → secondary text / sub-headings  
Warm Beige — #F9E8D9 → background for content or menu areas  
Deep Cherry — #A00E1A → hover / active states for buttons and links  

### Usage Guidelines
Header / Nav → background #1E1E1E, text #FFFFFF, hover #C91818  
Body background → #F9E8D9 (warm, inviting tone)  
Buttons → background #C91818, text #FFFFFF, hover #A00E1A  
Links → text #3A3A3A, hover #C91818  
Section dividers / highlights → #F5B7C3  

### Typography
Headings → Lulo Clean / ??  
Body Text → Sohne-Buch / ??

## Inspo / References:
  - https://www.themonroetlh.com/
  - https://bowdenscollegetown.com/
  - https://haywardhousetlh.com/
  - https://www.sakurafl.com/
