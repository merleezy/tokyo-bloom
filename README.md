# Tokyo Bloom
Topic: Japanese Restaurant Website  
Site Name: Tokyo Bloom  
Due Date: December 1, 2025  

## Project Overview
Tokyo Bloom is a modern Japanese restaurant website that showcases the menu, allows online reservations, and provides information about the restaurant. The site will feature a clean, minimalist design with a focus on high-quality images of the dishes and an easy-to-navigate layout.

## Features
- Home Page: Introduction to the restaurant with a hero image, brief description, and call-to-action buttons.
- Menu Page: Display of the restaurant's menu items categorized by appetizers, main courses, desserts, and drinks. Each item will have a name, description, price, and image.
- Reservations Page: Online reservation form allowing users to select date, time, and number of guests.
- Online Order Page: Option for users to place takeout orders directly from the website.
- Contact Page: Contact information, location map, and social media links.

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
