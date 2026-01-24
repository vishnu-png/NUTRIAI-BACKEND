-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2026 at 08:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nutriai`
--

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `calories` int(11) NOT NULL,
  `protein` float NOT NULL,
  `iron` float NOT NULL,
  `calcium` float NOT NULL,
  `carbs` double DEFAULT 0,
  `fat` double DEFAULT 0,
  `fiber` double DEFAULT 0,
  `sodium` double DEFAULT 0,
  `vitamin_d` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `food_name`, `category`, `calories`, `protein`, `iron`, `calcium`, `carbs`, `fat`, `fiber`, `sodium`, `vitamin_d`) VALUES
(1, 'White Rice (1 bowl)', 'veg', 130, 2.5, 0.5, 10, 28, 0.3, 0, 0, 0),
(2, 'Brown Rice (1 bowl)', 'veg', 110, 2.6, 0.5, 10, 23, 0.9, 0, 0, 0),
(3, 'Chapati (1 piece)', 'Staple', 120, 3, 0.5, 10, 0, 0, 0, 0, 0),
(4, 'Paratha (1 piece)', 'Staple', 220, 5, 1.2, 20, 35, 10, 0, 0, 0),
(5, 'Idli (1 piece)', 'veg', 60, 2, 0.1, 8, 8, 0.5, 0, 0, 0),
(6, 'Dosa (1 medium)', 'veg', 160, 3, 0.3, 12, 28, 4, 0, 0, 0),
(7, 'Upma (1 bowl)', 'veg', 180, 4, 0.8, 20, 30, 6, 0, 0, 0),
(8, 'Pongal (1 bowl)', 'veg', 210, 4, 1, 18, 30, 8, 0, 0, 0),
(9, 'Sambar (1 bowl)', 'veg', 100, 4, 1.8, 30, 15, 3, 0, 0, 0),
(10, 'Curd Rice (1 bowl)', 'veg', 98, 11, 0.5, 10, 3.4, 4.3, 0, 0, 0),
(11, 'Fried Rice (1 plate)', 'veg', 250, 5, 0.5, 10, 40, 9, 0, 0, 0),
(12, 'Vegetable Biryani (1 plate)', 'veg', 330, 7, 1.2, 28, 0, 0, 0, 0, 0),
(13, 'Chicken Biryani (1 plate)', 'non-veg', 200, 25, 1, 15, 0, 8, 0, 0, 5),
(14, 'Plain Dosa (1 pcs)', 'veg', 160, 3, 0.3, 12, 28, 4, 0, 0, 0),
(15, 'Masala Dosa (1 pcs)', 'veg', 160, 3, 0.5, 25, 28, 4, 0, 0, 0),
(16, 'Poori (1 piece)', 'Indian', 150, 2, 1, 10, 0, 0, 0, 0, 0),
(17, 'Upma (1 bowl)', 'veg', 180, 4, 0.8, 20, 30, 6, 0, 0, 0),
(18, 'Khichdi (1 bowl)', 'veg', 210, 6, 1.5, 35, 0, 0, 0, 0, 0),
(19, 'Pulao (1 plate)', 'Indian', 280, 5, 1.3, 22, 0, 0, 0, 0, 0),
(20, 'Curd (1 cup)', 'veg', 98, 11, 0.2, 150, 3.4, 4.3, 0, 0, 0),
(21, 'Aloo Curry (1 bowl)', 'Vegetable Curry', 170, 4, 1.2, 20, 10, 12, 0, 0, 0),
(22, 'Aloo Gobi (1 bowl)', 'Vegetable Curry', 180, 4, 1.1, 25, 0, 0, 0, 0, 0),
(23, 'Bhindi Fry (1 bowl)', 'Vegetable', 140, 3, 1, 35, 0, 0, 0, 0, 0),
(24, 'Cabbage Curry (1 bowl)', 'Vegetable', 170, 4, 0.8, 40, 10, 12, 0, 0, 0),
(25, 'Carrot Curry (1 bowl)', 'Vegetable', 170, 4, 0.6, 33, 10, 12, 0, 0, 0),
(26, 'Beans Curry (1 bowl)', 'Vegetable', 170, 4, 0.9, 38, 10, 12, 0, 0, 0),
(27, 'Brinjal Curry (1 bowl)', 'Vegetable', 170, 4, 1, 28, 10, 12, 0, 0, 0),
(28, 'Capsicum Masala (1 bowl)', 'Vegetable', 140, 3, 0.7, 22, 0, 0, 0, 0, 0),
(29, 'Tomato Curry (1 bowl)', 'Vegetable', 170, 4, 0.8, 18, 10, 12, 0, 0, 0),
(30, 'Mushroom Curry (1 bowl)', 'Vegetable', 170, 4, 1, 25, 10, 12, 0, 0, 0),
(31, 'Soya Curry (1 bowl)', 'Protein', 170, 4, 1.2, 50, 10, 12, 0, 0, 0),
(32, 'Dal Tadka (1 bowl)', 'veg', 120, 6, 2, 30, 18, 3, 0, 0, 0),
(33, 'Dal Fry (1 bowl)', 'veg', 120, 6, 2, 30, 18, 3, 0, 0, 0),
(34, 'Rajma Curry (1 bowl)', 'Indian Curry', 170, 4, 3, 60, 10, 12, 0, 0, 0),
(35, 'Chole Curry (1 bowl)', 'veg', 170, 4, 2.8, 55, 10, 12, 0, 0, 0),
(36, 'Mixed Vegetable Curry (1 bowl)', 'veg', 170, 4, 1.3, 30, 10, 12, 0, 0, 0),
(37, 'Palak Paneer (1 bowl)', 'veg', 250, 18, 0.5, 200, 5, 20, 0, 0, 0),
(38, 'Paneer Butter Masala (1 bowl)', 'veg', 100, 0, 0.5, 200, 0, 11, 0, 0, 0),
(39, 'Kadai Paneer (1 bowl)', 'veg', 250, 18, 0.5, 200, 5, 20, 0, 0, 0),
(40, 'Methi Curry (1 bowl)', 'Vegetable', 170, 4, 1.5, 40, 10, 12, 0, 0, 0),
(41, 'Apple (1 medium)', 'veg', 95, 0.5, 0.2, 10, 25, 0.3, 0, 0, 0),
(42, 'Banana (1 medium)', 'veg', 105, 1.3, 0.3, 5, 27, 0.3, 0, 0, 0),
(43, 'Orange (1 medium)', 'Fruit', 62, 1.2, 0.2, 40, 15, 0.2, 0, 0, 0),
(44, 'Mango (1 cup slices)', 'Fruit', 99, 1.4, 0.2, 11, 0, 0, 0, 0, 0),
(45, 'Papaya (1 cup)', 'Fruit', 55, 0.5, 0.6, 33, 0, 0, 0, 0, 0),
(46, 'Watermelon (1 cup)', 'Fruit', 0, 0, 0.2, 10, 0, 0, 0, 0, 0),
(47, 'Pomegranate (1 medium)', 'Fruit', 110, 2, 0.8, 13, 0, 0, 0, 0, 0),
(48, 'Grapes (1 cup)', 'Fruit', 62, 0.6, 0.4, 15, 0, 0, 0, 0, 0),
(49, 'Pineapple (1 cup)', 'veg', 95, 0.5, 0.2, 10, 25, 0.3, 0, 0, 0),
(50, 'Guava (1 medium)', 'Fruit', 68, 2.6, 0.3, 18, 0, 0, 0, 0, 0),
(51, 'Kiwi (1 fruit)', 'Fruit', 42, 0.8, 0.2, 23, 0, 0, 0, 0, 0),
(52, 'Strawberries (1 cup)', 'Fruit', 53, 1.1, 0.4, 27, 0, 0, 0, 0, 0),
(53, 'Black Grapes (1 cup)', 'Fruit', 70, 1, 0.6, 20, 0, 0, 0, 0, 0),
(54, 'Sweet Lime (1 fruit)', 'Fruit', 43, 0.8, 0.3, 25, 0, 0, 0, 0, 0),
(55, 'Custard Apple (1 medium)', 'veg', 95, 0.5, 0.2, 10, 25, 0.3, 0, 0, 0),
(56, 'Dates (3 pieces)', 'Fruit', 66, 0.5, 0.6, 15, 0, 0, 0, 0, 0),
(57, 'Dry Figs (2 pieces)', 'Fruit', 47, 0.6, 0.5, 25, 0, 0, 0, 0, 0),
(58, 'Blueberries (1 cup)', 'Fruit', 84, 1.1, 0.4, 9, 0, 0, 0, 0, 0),
(59, 'Avocado (1 fruit)', 'Fruit', 160, 2, 0.6, 12, 0, 0, 0, 0, 0),
(60, 'Chikoo (1 medium)', 'Fruit', 83, 0.5, 0.8, 21, 0, 0, 0, 0, 0),
(61, 'Spinach (1 cup cooked)', 'Leafy Green', 40, 5, 3, 100, 0, 0, 0, 0, 0),
(62, 'Fenugreek Leaves (1 cup cooked)', 'Leafy Green', 49, 4.3, 2.7, 50, 0, 0, 0, 0, 0),
(63, 'Drumstick Leaves (1 cup)', 'Leafy Green', 64, 4.5, 1.2, 350, 0, 0, 0, 0, 0),
(64, 'Coriander Leaves (1 cup)', 'Leafy Green', 23, 2.1, 1.8, 67, 0, 0, 0, 0, 0),
(65, 'Mint Leaves (1 cup)', 'Leafy Green', 52, 3.7, 1.8, 200, 0, 0, 0, 0, 0),
(66, 'Amaranth Leaves (1 cup)', 'Leafy Green', 28, 2.5, 2.9, 215, 0, 0, 0, 0, 0),
(67, 'Curry Leaves (1 cup)', 'Leafy Green', 170, 4, 4, 830, 10, 12, 0, 0, 0),
(68, 'Beetroot (1 cup)', 'Vegetable', 58, 2, 1.1, 16, 0, 0, 0, 0, 0),
(69, 'Drumstick (1 cup)', 'Vegetable', 37, 2.5, 0.6, 185, 0, 0, 0, 0, 0),
(70, 'Sweet Corn (1 cup)', 'Vegetable', 132, 5, 0.5, 3, 0, 0, 0, 0, 0),
(71, 'Cauliflower (1 cup)', 'Vegetable', 27, 2, 0.4, 20, 0, 0, 0, 0, 0),
(72, 'Broccoli (1 cup)', 'Vegetable', 55, 3.7, 1, 43, 0, 0, 0, 0, 0),
(73, 'Green Peas (1 cup)', 'Vegetable', 134, 8.6, 2.1, 36, 0, 0, 0, 0, 0),
(74, 'Lentils (1 cup cooked)', 'Protein', 230, 18, 6.6, 19, 0, 0, 0, 0, 0),
(75, 'Chickpeas Boiled (1 cup)', 'Protein', 120, 0, 4.7, 80, 0, 14, 0, 0, 0),
(76, 'Kidney Beans (1 cup)', 'Protein', 225, 15, 3.9, 50, 0, 0, 0, 0, 0),
(77, 'Green Gram (Moong Dal) 1 cup', 'veg', 120, 6, 2, 30, 18, 3, 0, 0, 0),
(78, 'Black Gram (Urad dal) 1 cup', 'veg', 120, 6, 2, 30, 18, 3, 0, 0, 0),
(79, 'Rajma Masala (1 bowl)', 'Indian Curry', 280, 10, 2.5, 65, 0, 0, 0, 0, 0),
(80, 'Sarson Ka Saag (1 bowl)', 'Leafy Green', 180, 6, 2.8, 160, 0, 0, 0, 0, 0),
(81, 'Milk (1 cup)', 'veg', 150, 8, 0.1, 300, 12, 8, 0, 0, 100),
(82, 'Curd (1 cup)', 'veg', 98, 11, 0.2, 150, 3.4, 4.3, 0, 0, 0),
(83, 'Butter (1 tbsp)', 'Dairy', 100, 0, 0, 8, 0, 11, 0, 0, 0),
(84, 'Paneer (100g)', 'veg', 250, 18, 0.5, 200, 5, 20, 0, 0, 0),
(85, 'Cheese (1 slice)', 'Dairy', 113, 7, 0.2, 200, 0, 0, 0, 0, 0),
(86, 'Ghee (1 tbsp)', 'Dairy', 120, 0, 0, 1, 0, 14, 0, 0, 0),
(87, 'Lassi (1 glass)', 'Dairy', 250, 8, 0.1, 350, 0, 0, 0, 0, 0),
(88, 'Egg (1 large)', 'non-veg', 70, 6, 1.8, 50, 0.6, 5, 0, 0, 40),
(89, 'Boiled Egg (1)', 'non-veg', 120, 0, 1.8, 50, 0, 14, 0, 0, 40),
(90, 'Omelette (1)', 'non-veg', 150, 9, 1.2, 30, 0, 0, 0, 0, 0),
(91, 'Chicken Breast (100g)', 'non-veg', 200, 25, 1, 15, 0, 8, 0, 0, 5),
(92, 'Chicken Curry (1 bowl)', 'non-veg', 170, 4, 1, 15, 10, 12, 0, 0, 5),
(93, 'Mutton Curry (1 bowl)', 'non-veg', 170, 4, 2.1, 45, 10, 12, 0, 0, 0),
(94, 'Fish Fry (1 piece)', 'non-veg', 180, 20, 0.5, 20, 0, 10, 0, 0, 400),
(95, 'Fish Curry (1 bowl)', 'non-veg', 170, 4, 0.5, 20, 10, 12, 0, 0, 400),
(96, 'Prawns (100g)', 'non-veg', 115, 24, 0.7, 64, 0, 1.7, 0, 0, 0),
(97, 'Tofu (100g)', 'Protein', 76, 8, 1.6, 350, 0, 0, 0, 0, 0),
(98, 'Soy Milk (1 cup)', 'veg', 150, 8, 0.1, 300, 12, 8, 0, 0, 100),
(99, 'Greek Yogurt (1 cup)', 'Dairy', 90, 8, 0.1, 110, 10, 3, 0, 0, 0),
(100, 'Protein Shake (1 serving)', 'Supplement', 130, 24, 1, 150, 0, 0, 0, 0, 0),
(101, 'Samosa (1 piece)', 'Snack', 260, 4, 1.2, 12, 25, 16, 0, 0, 0),
(102, 'Vada Pav (1 piece)', 'Snack', 290, 4, 1.5, 35, 0, 0, 0, 0, 0),
(103, 'Pav Bhaji (1 plate)', 'Fast Food', 400, 8, 2, 45, 0, 0, 0, 0, 0),
(104, 'Bhajiya (100g)', 'Snack', 300, 5, 1.8, 40, 0, 0, 0, 0, 0),
(105, 'Pakoda (100g)', 'Snack', 315, 6, 2, 35, 0, 0, 0, 0, 0),
(106, 'Bread (2 slices)', 'Bakery', 70, 2.5, 1, 80, 13, 1, 0, 0, 0),
(107, 'Butter Toast (2 slices)', 'Bakery', 100, 0, 1.2, 90, 0, 11, 0, 0, 0),
(108, 'Veg Sandwich (1)', 'veg', 250, 7, 1.5, 100, 0, 0, 0, 0, 0),
(109, 'Cheese Sandwich (1)', 'Snack', 320, 10, 1.8, 150, 0, 0, 0, 0, 0),
(110, 'Grilled Sandwich (1)', 'Snack', 280, 8, 1.2, 120, 0, 0, 0, 0, 0),
(111, 'Burger Veg (1)', 'veg', 450, 22, 2.1, 110, 40, 20, 0, 0, 0),
(112, 'Burger Chicken (1)', 'non-veg', 450, 22, 1, 15, 40, 20, 0, 0, 5),
(113, 'Pizza Veg Slice (1)', 'veg', 285, 12, 1, 150, 36, 10, 0, 0, 0),
(114, 'Pizza Chicken Slice (1)', 'non-veg', 285, 12, 1, 15, 36, 10, 0, 0, 5),
(115, 'French Fries (medium)', 'Fast Food', 365, 4, 1, 20, 0, 0, 0, 0, 0),
(116, 'Noodles (1 plate)', 'Chinese/Indian', 280, 6, 2.3, 40, 45, 10, 0, 0, 0),
(117, 'Manchurian (1 cup)', 'Chinese/Indian', 280, 6, 2, 60, 0, 0, 0, 0, 0),
(118, 'Pasta White Sauce (1 bowl)', 'Fast Food', 250, 8, 1.6, 180, 40, 5, 0, 0, 0),
(119, 'Pasta Red Sauce (1 bowl)', 'Fast Food', 250, 8, 1.4, 160, 40, 5, 0, 0, 0),
(120, 'Cutlet Veg (1)', 'veg', 150, 3, 1, 25, 0, 0, 0, 0, 0),
(121, 'Tea with Milk (1 cup)', 'veg', 40, 1, 0.1, 300, 8, 1, 0, 0, 100),
(122, 'Black Tea (1 cup)', 'Beverage', 40, 1, 0, 0, 8, 1, 0, 0, 0),
(123, 'Coffee with Milk (1 cup)', 'veg', 50, 1, 0.1, 300, 9, 1, 0, 0, 100),
(124, 'Black Coffee (1 cup)', 'Beverage', 50, 1, 0, 2, 9, 1, 0, 0, 0),
(125, 'Cold Coffee (1 glass)', 'Beverage', 50, 1, 0.2, 120, 9, 1, 0, 0, 0),
(126, 'Milkshake Banana (1 glass)', 'veg', 150, 8, 0.3, 5, 12, 8, 0, 0, 0),
(127, 'Milkshake Chocolate (1 glass)', 'veg', 150, 8, 0.1, 300, 12, 8, 0, 0, 100),
(128, 'Lemon Juice (1 glass)', 'Beverage', 120, 0.5, 0.2, 6, 28, 0.2, 0, 0, 0),
(129, 'Orange Juice (1 glass)', 'Beverage', 120, 0.5, 0.2, 40, 28, 0.2, 0, 0, 0),
(130, 'Sugarcane Juice (1 glass)', 'Beverage', 120, 0.5, 0.4, 15, 28, 0.2, 0, 0, 0),
(131, 'Mango Shake (1 glass)', 'Beverage', 350, 10, 0.6, 180, 0, 0, 0, 0, 0),
(132, 'Coca Cola (1 can)', 'Soft Drink', 140, 0, 0, 0, 0, 0, 0, 0, 0),
(133, 'Sprite (1 can)', 'Soft Drink', 140, 0, 0, 0, 0, 0, 0, 0, 0),
(134, 'Pepsi (1 can)', 'Soft Drink', 150, 0, 0, 0, 38, 0, 0, 0, 0),
(135, 'Red Bull (1 can)', 'Energy Drink', 112, 1, 0, 2, 0, 0, 0, 0, 0),
(136, 'Boost (1 glass)', 'Beverage', 280, 12, 1, 120, 0, 0, 0, 0, 0),
(137, 'Horlicks (1 glass)', 'Beverage', 250, 9, 1.2, 150, 0, 0, 0, 0, 0),
(138, 'Badam Milk (1 glass)', 'veg', 150, 8, 0.1, 300, 12, 8, 0, 0, 100),
(139, 'Lassi Sweet (1 glass)', 'Beverage', 300, 8, 0.3, 240, 0, 0, 0, 0, 0),
(140, 'Butter Milk (1 glass)', 'veg', 100, 0, 0.1, 300, 0, 11, 0, 0, 100),
(141, 'Gulab Jamun (1 piece)', 'Sweet', 150, 2, 0.2, 40, 0, 0, 0, 0, 0),
(142, 'Rasgulla (1 piece)', 'Sweet', 120, 4, 0.1, 80, 0, 0, 0, 0, 0),
(143, 'Kheer (1 bowl)', 'Dessert', 250, 7, 0.3, 220, 0, 0, 0, 0, 0),
(144, 'Payasam (1 bowl)', 'Dessert', 270, 6, 0.5, 200, 0, 0, 0, 0, 0),
(145, 'Laddu Besan (1 piece)', 'Sweet', 220, 3, 1, 40, 0, 0, 0, 0, 0),
(146, 'Motichoor Laddu (1 piece)', 'Sweet', 180, 2, 0.2, 35, 0, 0, 0, 0, 0),
(147, 'Jalebi (1 piece)', 'Sweet', 150, 1, 0.1, 15, 0, 0, 0, 0, 0),
(148, 'Halwa Carrot (1 bowl)', 'Dessert', 250, 3, 0.4, 90, 0, 0, 0, 0, 0),
(149, 'Sooji Halwa (1 bowl)', 'Dessert', 280, 4, 0.5, 100, 0, 0, 0, 0, 0),
(150, 'Barfi (1 piece)', 'Sweet', 130, 3, 0.2, 120, 0, 0, 0, 0, 0),
(151, 'Milk Cake (1 piece)', 'veg', 150, 8, 0.1, 300, 12, 8, 0, 0, 100),
(152, 'Mysore Pak (1 piece)', 'Sweet', 220, 2, 0.4, 45, 0, 0, 0, 0, 0),
(153, 'Peda (1 piece)', 'Sweet', 140, 3, 0.2, 110, 0, 0, 0, 0, 0),
(154, 'Ice Cream Vanilla (1 scoop)', 'Dessert', 140, 2, 0.1, 85, 0, 0, 0, 0, 0),
(155, 'Ice Cream Chocolate (1 scoop)', 'Dessert', 160, 3, 0.1, 90, 0, 0, 0, 0, 0),
(156, 'Kulfi (1 stick)', 'Dessert', 190, 4, 0.2, 150, 0, 0, 0, 0, 0),
(157, 'Chocolate (1 bar small)', 'Snack', 210, 2, 1, 50, 0, 0, 0, 0, 0),
(158, 'Cake Slice (1 piece)', 'Dessert', 280, 4, 1.1, 110, 0, 0, 0, 0, 0),
(159, 'Donut (1 piece)', 'Bakery', 300, 4, 1.2, 90, 0, 0, 0, 0, 0),
(160, 'Brownie (1 piece)', 'Dessert', 350, 4, 1.5, 100, 0, 0, 0, 0, 0),
(161, 'Poha (1 bowl)', 'Indian Breakfast', 180, 3, 1, 20, 35, 5, 0, 0, 0),
(162, 'Upma (1 bowl)', 'veg', 180, 4, 0.8, 30, 30, 6, 0, 0, 0),
(163, 'Rasam (1 bowl)', 'South Indian', 60, 1, 0.4, 10, 10, 2, 0, 0, 0),
(164, 'Curd Rice (1 bowl)', 'veg', 98, 11, 0.5, 10, 3.4, 4.3, 0, 0, 0),
(165, 'Vegetable Kurma (1 bowl)', 'veg', 220, 5, 1.4, 50, 0, 0, 0, 0, 0),
(166, 'Sambar Rice (1 bowl)', 'veg', 100, 4, 0.5, 10, 15, 3, 0, 0, 0),
(167, 'Chicken Chettinad (1 bowl)', 'non-veg', 200, 25, 1, 15, 0, 8, 0, 0, 5),
(168, 'Pesarattu (1 pcs)', 'South Indian', 160, 7, 2, 30, 0, 0, 0, 0, 0),
(169, 'Pongal (1 bowl)', 'veg', 210, 4, 1.3, 18, 30, 8, 0, 0, 0),
(170, 'Bisibele Bath (1 bowl)', 'South Indian', 360, 9, 2, 55, 0, 0, 0, 0, 0),
(171, 'Rajma Chawal (1 plate)', 'North Indian', 410, 13, 3.2, 55, 0, 0, 0, 0, 0),
(172, 'Chole Bhature (1 plate)', 'veg', 450, 14, 2.5, 80, 60, 18, 0, 0, 0),
(173, 'Dal Makhani (1 bowl)', 'veg', 120, 6, 2, 30, 18, 3, 0, 0, 0),
(174, 'Shahi Paneer (1 bowl)', 'veg', 250, 18, 0.5, 200, 5, 20, 0, 0, 0),
(175, 'Kadhi Chawal (1 plate)', 'North Indian', 420, 11, 2.2, 140, 0, 0, 0, 0, 0),
(176, 'Aloo Paratha (1 pcs)', 'North Indian', 220, 5, 1, 35, 35, 10, 0, 0, 0),
(177, 'Paneer Paratha (1 pcs)', 'veg', 220, 5, 0.5, 200, 35, 10, 0, 0, 0),
(178, 'Veg Pulao (1 plate)', 'veg', 280, 5, 1.3, 22, 0, 0, 0, 0, 0),
(179, 'Lemon Rice (1 bowl)', 'veg', 130, 2.5, 0.5, 10, 28, 0.3, 0, 0, 0),
(180, 'Tamarind Rice (Puliyogare) 1 bowl', 'veg', 130, 2.5, 0.5, 10, 28, 0.3, 0, 0, 0),
(181, 'Almonds (10 pieces)', 'Dry Fruits', 70, 3, 0.5, 75, 0, 0, 0, 0, 0),
(182, 'Cashews (10 pieces)', 'Dry Fruits', 90, 3, 1, 40, 0, 0, 0, 0, 0),
(183, 'Walnuts (5 halves)', 'Dry Fruits', 170, 6, 0.8, 30, 6, 15, 0, 0, 0),
(184, 'Pistachios (10 pieces)', 'Dry Fruits', 80, 3, 0.7, 35, 0, 0, 0, 0, 0),
(185, 'Raisins (2 tbsp)', 'Dry Fruits', 54, 0.5, 0.8, 20, 0, 0, 0, 0, 0),
(186, 'Peanuts (1 handful)', 'Nuts', 170, 6, 1.3, 40, 6, 15, 0, 0, 0),
(187, 'Peanut Butter (1 tbsp)', 'Protein Snack', 100, 0, 0.5, 15, 0, 11, 0, 0, 0),
(188, 'Chia Seeds (1 tbsp)', 'Seeds', 60, 2, 0.7, 80, 0, 0, 0, 0, 0),
(189, 'Flax Seeds (1 tbsp)', 'Seeds', 55, 1.9, 0.6, 25, 0, 0, 0, 0, 0),
(190, 'Pumpkin Seeds (1 tbsp)', 'Seeds', 57, 3, 1.1, 15, 0, 0, 0, 0, 0),
(191, 'Sunflower Seeds (1 tbsp)', 'Seeds', 51, 2, 0.9, 10, 0, 0, 0, 0, 0),
(192, 'Trail Mix (1 handful)', 'Snack', 200, 6, 1.8, 60, 0, 0, 0, 0, 0),
(193, 'Protein Bar (1 bar)', 'Protein Snack', 220, 20, 1.5, 120, 0, 0, 0, 0, 0),
(194, 'Oats (1 cup cooked)', 'veg', 150, 5, 1.7, 80, 27, 3, 0, 0, 0),
(195, 'Quinoa (1 cup cooked)', 'Healthy Food', 220, 8, 2.8, 30, 0, 0, 0, 0, 0),
(196, 'Sweet Potato (1 medium)', 'Healthy Food', 110, 2, 0.8, 40, 0, 0, 0, 0, 0),
(197, 'Avocado Toast (1 slice)', 'Healthy Snack', 250, 5, 1, 45, 0, 0, 0, 0, 0),
(198, 'Granola (1 cup)', 'Snack', 220, 6, 1.2, 65, 0, 0, 0, 0, 0),
(199, 'Fruit Salad (1 bowl)', 'veg', 80, 1, 0.8, 40, 20, 0.5, 0, 0, 0),
(200, 'Veg Salad (1 bowl)', 'veg', 60, 1, 1.2, 50, 5, 3, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `calories` int(11) NOT NULL,
  `protein` float DEFAULT 0,
  `carbohydrates` float DEFAULT 0,
  `fat` float DEFAULT 0,
  `fiber` float DEFAULT 0,
  `sodium` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `food_name`, `calories`, `protein`, `carbohydrates`, `fat`, `fiber`, `sodium`) VALUES
(1, 'Apple (Red)', 52, 0.3, 14, 0.2, 2.4, 1),
(2, 'Banana', 89, 1.1, 23, 0.3, 2.6, 1),
(3, 'Orange', 47, 0.9, 12, 0.1, 2.4, 0),
(4, 'Grapes', 69, 0.7, 18, 0.2, 0.9, 2),
(5, 'Strawberry', 32, 0.7, 7.7, 0.3, 2, 1),
(6, 'Blueberry', 57, 0.7, 14, 0.3, 2.4, 1),
(7, 'Mango', 60, 0.8, 15, 0.4, 1.6, 1),
(8, 'Watermelon', 30, 0.6, 8, 0.2, 0.4, 1),
(9, 'Pineapple', 50, 0.5, 13, 0.1, 1.4, 1),
(10, 'Papaya', 43, 0.5, 11, 0.3, 1.7, 8),
(11, 'Pomegranate', 83, 1.7, 19, 1.2, 4, 3),
(12, 'Kiwi', 61, 1.1, 15, 0.5, 3, 3),
(13, 'Guava', 68, 2.6, 14, 0.9, 5.4, 2),
(14, 'Spinach (Raw)', 23, 2.9, 3.6, 0.4, 2.2, 79),
(15, 'Broccoli (Boiled)', 35, 2.4, 7.2, 0.4, 3.3, 41),
(16, 'Carrot', 41, 0.9, 9.6, 0.2, 2.8, 69),
(17, 'Potato (Boiled)', 87, 1.9, 20, 0.1, 1.8, 4),
(18, 'Sweet Potato', 86, 1.6, 20, 0.1, 3, 55),
(19, 'Tomato', 18, 0.9, 3.9, 0.2, 1.2, 5),
(20, 'Cucumber', 15, 0.7, 3.6, 0.1, 0.5, 2),
(21, 'Onion', 40, 1.1, 9.3, 0.1, 1.7, 4),
(22, 'Bell Pepper (Red)', 31, 1, 6, 0.3, 2.1, 4),
(23, 'Cauliflower', 25, 1.9, 5, 0.3, 2, 30),
(24, 'Cabbage', 25, 1.3, 5.8, 0.1, 2.5, 18),
(25, 'Eggplant (Brinjal)', 25, 1, 5.9, 0.2, 3, 2),
(26, 'Okra (Ladies Finger)', 33, 1.9, 7.5, 0.2, 3.2, 7),
(27, 'Peas (Green)', 81, 5.4, 14, 0.4, 5.7, 5),
(28, 'Mushrooms', 22, 3.1, 3.3, 0.3, 1, 5),
(29, 'Chicken Breast (Grilled)', 165, 31, 0, 3.6, 0, 74),
(30, 'Egg (Boiled)', 155, 12.6, 1.1, 10.6, 0, 124),
(31, 'Salmon (Grilled)', 206, 22, 0, 12, 0, 59),
(32, 'Tofu', 76, 8, 1.9, 4.8, 0.3, 7),
(33, 'Paneer (Cottage Cheese)', 265, 11, 1.2, 21, 0, 20),
(34, 'Lentils (Dal - Cooked)', 116, 9, 20, 0.4, 7.9, 2),
(35, 'Chickpeas (Boiled)', 164, 8.9, 27, 2.6, 7.6, 7),
(36, 'Rice (White - Cooked)', 130, 2.7, 28, 0.3, 0.4, 1),
(37, 'Rice (Brown - Cooked)', 111, 2.6, 23, 0.9, 1.8, 5),
(38, 'Oats (Raw)', 389, 16.9, 66, 6.9, 10.6, 2),
(39, 'Almonds', 579, 21, 22, 49, 12.5, 1),
(40, 'Walnuts', 654, 15, 14, 65, 6.7, 2),
(41, 'Milk (Whole)', 61, 3.2, 4.8, 3.3, 0, 44),
(42, 'Yogurt (Curd)', 59, 3.5, 4.7, 3.3, 0, 36);

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meal_type` varchar(50) NOT NULL,
  `food_name` varchar(150) NOT NULL,
  `calories` float NOT NULL,
  `protein` float NOT NULL,
  `iron` float NOT NULL,
  `calcium` float NOT NULL,
  `date` date NOT NULL,
  `carbs` double DEFAULT 0,
  `fat` double DEFAULT 0,
  `fiber` double DEFAULT 0,
  `sodium` double DEFAULT 0,
  `is_eaten` tinyint(1) DEFAULT 0,
  `vitamin_d` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `user_id`, `meal_type`, `food_name`, `calories`, `protein`, `iron`, `calcium`, `date`, `carbs`, `fat`, `fiber`, `sodium`, `is_eaten`, `vitamin_d`) VALUES
(1, 0, 'break fast', 'idili', 120, 4, 1, 30, '2025-11-27', 0, 0, 0, 0, 0, 0),
(5, 2, 'breakfast', '', 200, 10, 2, 50, '2025-11-29', 0, 0, 0, 0, 0, 0),
(6, 1, 'dinner', 'testmeal', 200, 10, 2, 50, '2025-11-29', 0, 0, 0, 0, 0, 0),
(7, 1, 'lunch', 'Idli (1 piece)', 70, 2.5, 0.1, 8, '2025-11-29', 0, 0, 0, 0, 0, 0),
(953, 28, 'breakfast', 'Lemon Juice (1 glass) (x4.6)', 549.25, 2.28854, 0, 0, '2026-01-19', 128.15833333333333, 0.9154166666666668, 0, 0, 0, 0),
(954, 28, 'lunch', 'Cheese (1 slice) (x6.8)', 768.95, 47.6341, 0, 0, '2026-01-19', 0, 0, 0, 0, 0, 0),
(955, 28, 'dinner', 'Milk Cake (1 piece) (x4.4)', 659.1, 35.152, 0, 0, '2026-01-19', 52.727999999999966, 35.15199999999998, 0, 0, 0, 0),
(956, 28, 'snack', 'Protein Shake (1 serving) (Lg)', 219.7, 40.56, 0, 0, '2026-01-19', 0, 0, 0, 0, 0, 0),
(963, 26, 'breakfast', 'Barfi (1 piece) (x4.2)', 549.25, 12.675, 0, 0, '2026-01-22', 0, 0, 0, 0, 0, 0),
(964, 26, 'lunch', 'Milkshake Chocolate (1 glass) (x5.1)', 768.95, 41.0107, 0, 0, '2026-01-22', 61.516000000000005, 41.01066666666667, 0, 0, 0, 0),
(965, 26, 'dinner', 'Protein Bar (1 bar) (x3)', 659.1, 59.9182, 0, 0, '2026-01-22', 0, 0, 0, 0, 0, 0),
(966, 26, 'snack', 'Khichdi (1 bowl)', 219.7, 6.27714, 0, 0, '2026-01-22', 0, 0, 0, 0, 0, 0),
(968, 29, 'breakfast', 'Boiled Egg (1) (x4)', 485.25, 0, 0, 0, '2026-01-22', 0, 56.612500000000004, 0, 0, 1, 0),
(969, 29, 'lunch', 'Lentils (1 cup cooked) (x3)', 679.35, 53.1665, 0, 0, '2026-01-22', 0, 0, 0, 0, 1, 0),
(970, 29, 'dinner', 'Pumpkin Seeds (1 tbsp) (x10.2)', 582.3, 30.6474, 0, 0, '2026-01-22', 0, 0, 0, 0, 1, 0),
(971, 29, 'snack', 'Mint Leaves (1 cup) (x3.7)', 194.1, 13.811, 0, 0, '2026-01-22', 0, 0, 0, 0, 1, 0),
(972, 29, 'Snack', 'Whey Protein Scoop', 120, 25, 0, 0, '2026-01-21', 2, 1, 0, 0, 1, 0),
(973, 29, 'Snack', 'Greek Yogurt (1 cup)', 100, 10, 0, 0, '2026-01-21', 6, 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `weight` float NOT NULL,
  `height` float NOT NULL,
  `diet_preference` enum('veg','non-veg','keto','vegan') DEFAULT 'veg',
  `target_calories` int(11) DEFAULT 2000,
  `target_protein` decimal(5,2) DEFAULT 150.00,
  `target_carbs` decimal(5,2) DEFAULT 250.00,
  `target_fat` decimal(5,2) DEFAULT 70.00,
  `last_synced` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `age`, `weight`, `height`, `diet_preference`, `target_calories`, `target_protein`, `target_carbs`, `target_fat`, `last_synced`) VALUES
(26, 'Vishnu. K', 'animafuture1gaming@gmail.com', '$2y$10$2/YRmNJ9ba/4yDsQhJrXZ.2jSqqAHUzmtMk5M4zdBBQqj4iQVuPuC', 19, 60, 174, '', 2197, 126.00, 252.00, 56.00, '2026-01-06 14:34:00'),
(27, 'abhigna', 'abhignachilaka25@gmail.com', '$2y$10$u3wK.4JBYMs2JoKZxnj5PeNkLxKtlk/mFJab/n/bEMWU9ZnnoizdG', 25, 65, 170, 'veg', 2211, 138.00, 276.00, 61.00, '2026-01-09 13:12:20'),
(28, 'srinu', 'srinivasachari2005@gmail.com', '$2y$10$.yDq3z8ta56tqW1tBeDGHOKrc8rMpgM/8W.DjJg2AmhaUfiW5NxJG', 19, 60, 174, '', 2197, 137.00, 274.00, 61.00, '2026-01-09 21:31:13'),
(29, 'harsha', 'kundavishnuvardhan@gmail.com', '$2y$10$c6TzyQLZmZY4RVpgqWgx/u0Bsoxxu5Bqw.Nn6hyqbdmNcPWczhmta', 20, 65, 170, 'non-veg', 1941, 121.00, 242.00, 53.00, '2026-01-22 00:27:21');

-- --------------------------------------------------------

--
-- Table structure for table `user_bmi_records`
--

CREATE TABLE `user_bmi_records` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `bmi_value` decimal(5,2) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `date_recorded` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_bmi_records`
--

INSERT INTO `user_bmi_records` (`id`, `user_id`, `bmi_value`, `status`, `date_recorded`) VALUES
(1, 'user_123', 23.50, 'Normal', '2026-01-06 13:54:56'),
(6, '26', 23.10, 'Normal', '2026-01-09 00:26:40'),
(7, '26', 23.10, 'Normal', '2026-01-09 00:53:14'),
(8, '26', 23.10, 'Normal', '2026-01-09 01:08:31'),
(9, '26', 23.10, 'Normal', '2026-01-09 01:23:09'),
(10, '26', 23.10, 'Normal', '2026-01-09 01:23:52'),
(11, '26', 23.10, 'Normal', '2026-01-09 01:24:20'),
(12, '26', 23.10, 'Normal', '2026-01-09 01:24:51'),
(13, '26', 23.10, 'Normal', '2026-01-09 01:31:37'),
(14, '26', 23.10, 'Normal', '2026-01-09 01:42:26'),
(15, '26', 23.10, 'Normal', '2026-01-09 01:42:42'),
(16, '27', 22.50, 'Normal', '2026-01-09 13:12:20'),
(17, '28', 19.80, 'Normal', '2026-01-09 21:31:13'),
(18, '28', 19.80, 'Normal', '2026-01-09 23:36:32'),
(19, '26', 19.80, 'Normal', '2026-01-09 23:44:25'),
(20, '26', 19.80, 'Normal', '2026-01-09 23:44:41'),
(21, '26', 19.80, 'Normal', '2026-01-09 23:44:58'),
(22, '26', 19.80, 'Normal', '2026-01-10 00:01:51'),
(23, '26', 19.80, 'Normal', '2026-01-10 00:02:16'),
(24, '26', 19.80, 'Normal', '2026-01-10 00:14:38'),
(25, '26', 19.80, 'Normal', '2026-01-10 00:15:08'),
(26, '26', 19.80, 'Normal', '2026-01-10 00:47:18'),
(27, '26', 19.80, 'Normal', '2026-01-19 08:24:48'),
(28, '28', 19.80, 'Normal', '2026-01-19 22:47:36'),
(29, '28', 19.80, 'Normal', '2026-01-19 22:47:55'),
(30, '26', 19.80, 'Normal', '2026-01-22 00:25:57'),
(31, '29', 22.50, 'Normal', '2026-01-22 00:27:21');

-- --------------------------------------------------------

--
-- Table structure for table `user_deficiency_reports`
--

CREATE TABLE `user_deficiency_reports` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `nutrient_name` varchar(50) NOT NULL,
  `deficiency_level` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `trend` varchar(20) DEFAULT NULL,
  `date_recorded` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_deficiency_reports`
--

INSERT INTO `user_deficiency_reports` (`id`, `user_id`, `nutrient_name`, `deficiency_level`, `status`, `trend`, `date_recorded`) VALUES
(1, 'user_123', 'Iron', 'Moderate', 'Low', 'down', '2026-01-06 13:54:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user_bmi_records`
--
ALTER TABLE `user_bmi_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_deficiency_reports`
--
ALTER TABLE `user_deficiency_reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=974;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_bmi_records`
--
ALTER TABLE `user_bmi_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_deficiency_reports`
--
ALTER TABLE `user_deficiency_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
