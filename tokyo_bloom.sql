-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2025 at 08:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokyo_bloom`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `description`, `price`, `category`, `image_url`) VALUES
(1, 'Edamame', 'Steamed soybeans with sea salt.', 5.50, 'Appetizers', 'images/menu/edamame.jpeg'),
(2, 'Gyoza Dumplings', 'Pan-seared pork and vegetable dumplings with citrus soy.', 8.50, 'Appetizers', 'images/menu/gyoza-dumplings2.jpeg'),
(3, 'Agedashi Tofu', 'Crispy fried tofu in a light dashi broth.', 7.50, 'Appetizers', 'images/menu/agedashi-tofu.jpeg'),
(4, 'Tokyo Bloom Roll', 'Signature roll with tuna, salmon, avocado, cucumber, and spicy aioli.', 16.00, 'Sushi Rolls', 'images/menu/tokyo-bloom-roll.jpeg'),
(5, 'California Roll', 'Crab, avocado, and cucumber with sesame seeds.', 10.00, 'Sushi Rolls', 'images/menu/california-roll.jpeg\r\n'),
(6, 'Spicy Tuna Roll', 'Fresh tuna with spicy mayo and scallions.', 12.00, 'Sushi Rolls', 'images/menu/spicy-tuna-roll.jpeg'),
(7, 'Dragon Roll', 'Shrimp tempura roll topped with eel and avocado.', 18.00, 'Sushi Rolls', 'images/menu/dragon-roll.jpeg'),
(8, 'Salmon Nigiri (2 pc)', 'Fresh Atlantic salmon over sushi rice.', 7.00, 'Nigiri & Sashimi', 'images/menu/salmon-nigiri.jpeg'),
(9, 'Tuna Nigiri (2 pc)', 'Lean tuna over seasoned sushi rice.', 8.00, 'Nigiri & Sashimi', 'images/menu/tuna-nigiri.jpeg'),
(10, 'Chef\'s Sashimi Platter', 'Assorted chef’s selection of sashimi (12 pieces).', 28.00, 'Nigiri & Sashimi', 'images/menu/sashimi-platter.jpeg'),
(11, 'Shoyu Ramen', 'Soy-based broth, chashu pork, soft-boiled egg, and scallions.', 15.50, 'Ramen & Entrees', 'images/menu/shoyu-ramen.jpeg'),
(12, 'Tonkotsu Ramen', 'Rich pork bone broth with chashu, bamboo shoots, and nori.', 16.50, 'Ramen & Entrees', 'images/menu/tonkotsu-ramen.jpeg'),
(13, 'Chicken Katsu Plate', 'Crispy panko chicken cutlet with rice, cabbage, and curry sauce.', 17.00, 'Ramen & Entrees', 'images/menu/chicken-katsu.jpeg'),
(14, 'Teriyaki Salmon', 'Grilled salmon glazed with teriyaki sauce, served with rice and vegetables.', 20.00, 'Ramen & Entrees', 'images/menu/teriyaki-salmon.jpeg'),
(15, 'Matcha Cheesecake', 'Creamy green tea cheesecake with graham crust.', 8.00, 'Desserts', 'images/menu/matcha-cheesecake.jpeg'),
(16, 'Mochi Ice Cream Trio', 'Assorted mochi ice cream flavors.', 7.50, 'Desserts', 'images/menu/mochi-trio.jpeg'),
(17, 'Hot Green Tea', 'Traditional Japanese sencha.', 3.00, 'Drinks', 'images/menu/green-tea.jpeg'),
(18, 'Ramune Soda', 'Japanese marble soda, assorted flavors.', 4.50, 'Drinks', 'images/menu/ramune-soda.jpeg'),
(19, 'Yuzu Lemonade', 'House-made lemonade with yuzu citrus.', 5.00, 'Drinks', 'images/menu/yuzu-lemonade.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `guests` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `email`, `phone`, `date`, `time`, `guests`) VALUES
(1, 'John Doe', 'johndoe@gmail.com', '1234567890', '2025-11-26', '11:00:00', 1),
(2, 'Jane Doe', 'janedoe@gmail.com', '1234567890', '2025-11-27', '11:00:00', 1),
(4, 'Bob Smith', 'bobsmith@gmail.com', '1234567890', '2025-11-26', '12:30:00', 1),
(5, 'Alice Johnson', 'alicejohnson@gmail.com', '1234567890', '2025-11-21', '11:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_slot` (`date`,`time`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
