-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jan 28, 2024 at 06:42 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `benha_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `cafe_orders`
--

CREATE TABLE `cafe_orders` (
  `id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cafe_orders`
--

INSERT INTO `cafe_orders` (`id`, `total_price`, `user_id`, `created_at`, `updated_at`) VALUES
(51, 200, 2, '2024-01-23 01:43:34', '2024-01-23 01:43:34'),
(54, 206, 2, '2024-01-23 23:55:03', '2024-01-23 23:55:03'),
(55, 161, 3, '2024-01-26 23:46:07', '2024-01-26 23:46:07'),
(56, 35, 3, '2024-01-27 17:51:11', '2024-01-27 17:51:11');

-- --------------------------------------------------------

--
-- Table structure for table `cafe_products`
--

CREATE TABLE `cafe_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(191) NOT NULL,
  `product_price` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL COMMENT 'whose the admin that create or update the products',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cafe_products`
--

INSERT INTO `cafe_products` (`id`, `product_name`, `product_price`, `admin_id`, `updated_at`, `created_at`) VALUES
(1, 'قهوة', 12, NULL, '2024-01-05 03:06:58', '2024-01-05 03:06:58'),
(2, 'شاي ', 7, NULL, '2024-01-05 03:06:58', '2024-01-05 03:06:58'),
(3, 'زجاجة ماء ', 7, NULL, '2024-01-05 03:06:58', '2024-01-05 03:06:58'),
(4, 'كارت نت', 2, NULL, '2024-01-05 03:06:58', '2024-01-05 03:06:58'),
(5, 'مانجو', 25, NULL, '2024-01-05 03:41:35', '2024-01-05 03:41:35'),
(6, 'حلبة حليب', 15, NULL, '2024-01-05 03:46:45', '2024-01-05 03:46:45'),
(7, 'فراولة', 25, NULL, '2024-01-05 03:46:45', '2024-01-05 03:46:45'),
(8, 'سموزي بطيخ', 30, NULL, '2024-01-05 03:46:45', '2024-01-05 03:46:45'),
(9, 'شويبس ', 20, NULL, '2024-01-05 03:46:45', '2024-01-05 03:46:45'),
(10, 'فيروز ', 20, NULL, '2024-01-05 03:46:45', '2024-01-05 03:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `cafe_products_orders`
--

CREATE TABLE `cafe_products_orders` (
  `id` int(11) NOT NULL,
  `cafe_product_id` int(11) DEFAULT NULL,
  `food_product_id` int(11) DEFAULT NULL,
  `cafe_order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'Quantity for each product',
  `each_price` int(11) NOT NULL COMMENT 'Each price for product',
  `total_price` int(11) NOT NULL COMMENT 'total price for quantity of the product',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cafe_products_orders`
--

INSERT INTO `cafe_products_orders` (`id`, `cafe_product_id`, `food_product_id`, `cafe_order_id`, `quantity`, `each_price`, `total_price`, `created_at`, `update_at`) VALUES
(75, 6, NULL, 51, 2, 15, 30, '2024-01-23 01:43:34', '2024-01-23 01:43:34'),
(76, 9, NULL, 51, 1, 20, 20, '2024-01-23 01:43:34', '2024-01-23 01:43:34'),
(77, NULL, 1, 51, 1, 50, 50, '2024-01-23 01:43:34', '2024-01-23 01:43:34'),
(78, NULL, 6, 51, 1, 100, 100, '2024-01-23 01:43:34', '2024-01-23 01:43:34'),
(85, 1, NULL, 54, 3, 12, 36, '2024-01-23 23:55:03', '2024-01-23 23:55:03'),
(86, 4, NULL, 54, 1, 2, 2, '2024-01-23 23:55:03', '2024-01-23 23:55:03'),
(87, NULL, 1, 54, 1, 50, 50, '2024-01-23 23:55:03', '2024-01-23 23:55:03'),
(88, 4, NULL, 54, 1, 2, 2, '2024-01-24 00:05:21', '2024-01-24 00:05:21'),
(89, 2, NULL, 54, 1, 7, 7, '2024-01-24 00:27:57', '2024-01-24 00:27:57'),
(90, 2, NULL, 54, 1, 7, 7, '2024-01-24 00:29:26', '2024-01-24 00:29:26'),
(91, 1, NULL, 54, 1, 12, 12, '2024-01-24 01:38:51', '2024-01-24 01:38:51'),
(92, NULL, 9, 54, 1, 90, 90, '2024-01-24 02:20:58', '2024-01-24 02:20:58'),
(93, 3, NULL, 55, 23, 7, 161, '2024-01-26 23:46:07', '2024-01-26 23:46:07'),
(94, 12, NULL, 56, 5, 7, 35, '2024-01-27 17:51:11', '2024-01-27 17:51:11');

-- --------------------------------------------------------

--
-- Table structure for table `foodcar_products`
--

CREATE TABLE `foodcar_products` (
  `id` int(11) NOT NULL,
  `food_name` varchar(200) NOT NULL,
  `food_price` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL COMMENT 'Admin Id which created or update the food product',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foodcar_products`
--

INSERT INTO `foodcar_products` (`id`, `food_name`, `food_price`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 'سندوتشات برجر لحم', 50, NULL, '2024-01-05 18:21:05', '2024-01-05 18:21:05'),
(2, 'سندوتشات برجر الفراخ', 55, NULL, '2024-01-05 18:21:05', '2024-01-05 18:21:05'),
(3, 'سندوتش البرجر بالجبنه', 60, NULL, '2024-01-05 18:21:05', '2024-01-05 18:21:05'),
(4, 'سندوتش برجر دوبل', 65, NULL, '2024-01-05 18:21:05', '2024-01-05 18:21:05'),
(5, 'سندوتش برجر تربل', 75, NULL, '2024-01-05 18:21:05', '2024-01-05 18:21:05'),
(6, 'ساندوتش اولد سكول', 100, NULL, '2024-01-05 18:21:05', '2024-01-05 18:21:05'),
(7, 'ساندوتش اكس ارين', 60, NULL, '2024-01-05 18:21:05', '2024-01-05 18:21:05'),
(8, 'ساندوتش ترافل بيف برجر', 120, NULL, '2024-01-05 18:21:05', '2024-01-05 18:21:05'),
(9, 'ساندوتش كيتو ملفوف الخس', 90, NULL, '2024-01-05 18:21:05', '2024-01-05 18:21:05'),
(10, 'ساندوتش كيتو شيتاكي مشروم', 110, NULL, '2024-01-05 18:21:05', '2024-01-05 18:21:05');

-- --------------------------------------------------------

--
-- Table structure for table `food_orders`
--

CREATE TABLE `food_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ended_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_orders`
--

INSERT INTO `food_orders` (`id`, `user_id`, `total_price`, `table_id`, `created_at`, `updated_at`, `ended_at`) VALUES
(9, 2, 50, 1, '2024-01-24 08:23:31', '2024-01-24 08:23:31', NULL),
(10, 2, 62, 4, '2024-01-24 08:24:17', '2024-01-24 08:24:17', NULL),
(11, 2, 180, NULL, '2024-01-24 08:35:19', '2024-01-24 08:35:19', '2024-01-26 04:17:19'),
(13, 2, 200, NULL, '2024-01-25 15:18:46', '2024-01-25 15:18:46', '2024-01-26 02:57:55'),
(14, 3, 50, 3, '2024-01-28 16:31:38', '2024-01-28 16:31:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `food_products_order`
--

CREATE TABLE `food_products_order` (
  `id` int(11) NOT NULL,
  `food_product_id` int(11) DEFAULT NULL,
  `cafe_product_id` int(11) DEFAULT NULL,
  `food_order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `each_price` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_products_order`
--

INSERT INTO `food_products_order` (`id`, `food_product_id`, `cafe_product_id`, `food_order_id`, `quantity`, `each_price`, `total_price`, `created_at`, `update_at`) VALUES
(14, 1, NULL, 9, 1, 50, 50, '2024-01-24 08:23:31', '2024-01-24 08:23:31'),
(15, NULL, 1, 10, 1, 12, 12, '2024-01-24 08:24:17', '2024-01-24 08:24:17'),
(16, 1, NULL, 10, 1, 50, 50, '2024-01-24 08:24:17', '2024-01-24 08:24:17'),
(17, NULL, 8, 11, 1, 30, 30, '2024-01-24 08:35:19', '2024-01-24 08:35:19'),
(18, 3, NULL, 11, 2, 60, 120, '2024-01-24 08:35:19', '2024-01-24 08:35:19'),
(19, NULL, 9, 13, 1, 20, 20, '2024-01-25 15:18:46', '2024-01-25 15:18:46'),
(20, 2, NULL, 13, 3, 55, 165, '2024-01-25 15:18:46', '2024-01-25 15:18:46'),
(24, NULL, 8, 11, 1, 30, 30, '2024-01-26 04:17:06', '2024-01-26 04:17:06'),
(25, 1, NULL, 14, 1, 50, 50, '2024-01-28 16:31:38', '2024-01-28 16:31:38');

-- --------------------------------------------------------

--
-- Table structure for table `playstation_configuration`
--

CREATE TABLE `playstation_configuration` (
  `id` int(11) NOT NULL,
  `playstation_type` enum('ps4','ps5') NOT NULL,
  `controllers_type` enum('single','multi') NOT NULL,
  `price_per_hour` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playstation_configuration`
--

INSERT INTO `playstation_configuration` (`id`, `playstation_type`, `controllers_type`, `price_per_hour`) VALUES
(1, 'ps4', 'single', 20),
(2, 'ps4', 'multi', 30),
(3, 'ps5', 'single', 45),
(4, 'ps5', 'multi', 50);

-- --------------------------------------------------------

--
-- Table structure for table `playstation_orders`
--

CREATE TABLE `playstation_orders` (
  `id` int(11) NOT NULL,
  `playstation_session_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `order_price` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playstation_orders`
--

INSERT INTO `playstation_orders` (`id`, `playstation_session_id`, `room_id`, `order_price`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 12, 0, 976, 2, '2024-01-19 15:05:00', '2024-01-19 15:05:00'),
(6, 14, 0, 781, 2, '2024-01-19 15:08:45', '2024-01-19 15:08:45'),
(7, 15, 0, 532, 2, '2024-01-19 23:31:15', '2024-01-19 23:31:15'),
(8, 16, 0, 627, 2, '2024-01-19 23:32:05', '2024-01-19 23:32:05'),
(9, 17, 0, 419, 2, '2024-01-20 12:59:50', '2024-01-20 12:59:50'),
(10, 19, 0, 33, 2, '2024-01-20 22:25:07', '2024-01-20 22:25:07'),
(11, 20, 0, 67, 2, '2024-01-22 08:17:25', '2024-01-22 08:17:25'),
(12, 21, 0, 484, 2, '2024-01-23 13:53:44', '2024-01-23 13:53:44'),
(13, 22, 0, 153, 2, '2024-01-24 00:30:01', '2024-01-24 00:30:01'),
(14, 23, 0, 264, 2, '2024-01-24 01:24:12', '2024-01-24 01:24:12'),
(15, 24, 0, 318, 2, '2024-01-26 02:09:57', '2024-01-26 02:09:57'),
(16, 25, 0, 130, 2, '2024-01-27 23:35:15', '2024-01-27 23:35:15'),
(17, 26, 0, 0, 2, '2024-01-27 23:37:03', '2024-01-27 23:37:03'),
(18, 27, 0, 0, 2, '2024-01-27 23:37:08', '2024-01-27 23:37:08'),
(19, 28, 0, 0, 2, '2024-01-27 23:37:15', '2024-01-27 23:37:15'),
(20, 29, 1, 0, 2, '2024-01-28 00:55:10', '2024-01-28 00:55:10'),
(21, 30, 3, 0, 2, '2024-01-28 00:59:31', '2024-01-28 00:59:31'),
(22, 31, 4, 39, 3, '2024-01-28 16:34:30', '2024-01-28 16:34:30'),
(23, 32, 2, 110, 3, '2024-01-28 16:50:34', '2024-01-28 16:50:34');

-- --------------------------------------------------------

--
-- Table structure for table `playstation_product_order`
--

CREATE TABLE `playstation_product_order` (
  `id` int(11) NOT NULL,
  `playstation_session_id` int(11) NOT NULL,
  `cafe_product_id` int(11) DEFAULT NULL,
  `foodcar_product_id` int(11) DEFAULT NULL,
  `qunatity` int(11) DEFAULT NULL,
  `each_price` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playstation_product_order`
--

INSERT INTO `playstation_product_order` (`id`, `playstation_session_id`, `cafe_product_id`, `foodcar_product_id`, `qunatity`, `each_price`, `total_price`, `created_at`, `updated_at`) VALUES
(6, 14, 1, NULL, 3, 12, 36, '2024-01-19 15:08:44', '2024-01-19 15:08:44'),
(7, 14, 2, NULL, 2, 7, 14, '2024-01-19 15:08:45', '2024-01-19 15:08:45'),
(8, 14, NULL, 10, 1, 110, 110, '2024-01-19 15:08:45', '2024-01-19 15:08:45'),
(9, 15, 6, NULL, 3, 15, 45, '2024-01-19 23:31:15', '2024-01-19 23:31:15'),
(10, 17, 5, NULL, 3, 25, 75, '2024-01-20 12:59:50', '2024-01-20 12:59:50'),
(11, 17, 8, NULL, 1, 30, 30, '2024-01-20 12:59:50', '2024-01-20 12:59:50'),
(12, 17, NULL, 1, 1, 50, 50, '2024-01-20 12:59:50', '2024-01-20 12:59:50'),
(13, 17, NULL, 3, 1, 60, 60, '2024-01-20 12:59:50', '2024-01-20 12:59:50'),
(14, 15, 9, NULL, 1, 20, 20, '2024-01-20 16:31:41', '2024-01-20 16:31:41'),
(15, 12, 5, NULL, 3, 25, 75, '2024-01-20 16:37:40', '2024-01-20 16:37:40'),
(16, 16, 10, NULL, 1, 20, 20, '2024-01-20 16:38:03', '2024-01-20 16:38:03'),
(17, 16, NULL, 1, 3, 50, 150, '2024-01-20 16:38:03', '2024-01-20 16:38:03'),
(18, 17, 10, NULL, 1, 20, 20, '2024-01-20 22:13:26', '2024-01-20 22:13:26'),
(19, 20, 2, NULL, 3, 7, 21, '2024-01-22 08:17:25', '2024-01-22 08:17:25'),
(20, 21, 2, NULL, 2, 7, 14, '2024-01-23 13:54:42', '2024-01-23 13:54:42'),
(21, 21, NULL, 4, 1, 65, 65, '2024-01-23 13:54:42', '2024-01-23 13:54:42'),
(22, 21, 1, NULL, 1, 12, 12, '2024-01-24 00:07:08', '2024-01-24 00:07:08'),
(23, 21, 1, NULL, 3, 12, 36, '2024-01-24 00:07:27', '2024-01-24 00:07:27'),
(24, 21, NULL, 1, 1, 50, 50, '2024-01-24 00:07:27', '2024-01-24 00:07:27'),
(25, 22, 1, NULL, 2, 12, 24, '2024-01-24 00:30:01', '2024-01-24 00:30:01'),
(26, 22, NULL, 1, 1, 50, 50, '2024-01-24 00:30:01', '2024-01-24 00:30:01'),
(27, 22, 1, NULL, 1, 12, 12, '2024-01-24 00:30:16', '2024-01-24 00:30:16'),
(28, 22, NULL, 1, 1, 50, 50, '2024-01-24 01:22:09', '2024-01-24 01:22:09'),
(29, 23, 1, NULL, 2, 12, 24, '2024-01-24 01:24:12', '2024-01-24 01:24:12'),
(30, 23, 2, NULL, 1, 7, 7, '2024-01-24 01:24:12', '2024-01-24 01:24:12'),
(31, 23, 8, NULL, 3, 30, 90, '2024-01-24 01:24:12', '2024-01-24 01:24:12'),
(32, 23, NULL, 1, 1, 50, 50, '2024-01-24 01:24:12', '2024-01-24 01:24:12'),
(33, 23, NULL, 1, 1, 50, 50, '2024-01-24 01:24:12', '2024-01-24 01:24:12'),
(34, 23, 8, NULL, 1, 30, 30, '2024-01-24 01:24:30', '2024-01-24 01:24:30'),
(35, 23, 1, NULL, 1, 12, 12, '2024-01-24 01:25:32', '2024-01-24 01:25:32'),
(36, 24, 1, NULL, 1, 12, 12, '2024-01-26 02:09:57', '2024-01-26 02:09:57'),
(37, 24, NULL, 3, 1, 60, 60, '2024-01-26 02:09:57', '2024-01-26 02:09:57'),
(38, 25, 10, NULL, 1, 20, 20, '2024-01-27 23:35:15', '2024-01-27 23:35:15'),
(39, 25, NULL, 10, 1, 110, 110, '2024-01-27 23:35:15', '2024-01-27 23:35:15'),
(40, 31, 1, NULL, 3, 12, 36, '2024-01-28 16:34:30', '2024-01-28 16:34:30'),
(41, 32, NULL, 10, 1, 110, 110, '2024-01-28 16:50:34', '2024-01-28 16:50:34');

-- --------------------------------------------------------

--
-- Table structure for table `playstation_session`
--

CREATE TABLE `playstation_session` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL DEFAULT current_timestamp(),
  `end_time` datetime NOT NULL,
  `controllers_type` varchar(50) NOT NULL,
  `playstation_type` varchar(50) NOT NULL,
  `base_price_for_this_confgurations` int(11) NOT NULL,
  `total_price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playstation_session`
--

INSERT INTO `playstation_session` (`id`, `room_id`, `start_time`, `end_time`, `controllers_type`, `playstation_type`, `base_price_for_this_confgurations`, `total_price`) VALUES
(12, 0, '2024-01-19 17:05:00', '2024-01-20 23:06:25', 'multi', 'ps4', 30, '901'),
(14, 0, '2024-01-19 17:08:44', '2024-01-21 00:12:39', 'single', 'ps4', 20, '621'),
(15, 0, '2024-01-20 01:31:15', '2024-01-21 00:52:52', 'single', 'ps4', 20, '467'),
(16, 0, '2024-01-20 01:32:05', '2024-01-21 00:24:08', 'single', 'ps4', 20, '457'),
(17, 0, '2024-01-20 14:59:50', '2024-01-21 00:13:31', 'single', 'ps4', 20, '184'),
(18, 0, '2024-01-20 22:53:19', '2024-01-21 00:53:00', 'single', 'ps4', 20, '0'),
(19, 0, '2024-01-21 00:25:07', '2024-01-21 01:31:08', 'multi', 'ps4', 30, '33'),
(20, 0, '2024-01-22 10:17:25', '2024-01-22 12:34:27', 'single', 'ps4', 20, '46'),
(21, 0, '2024-01-23 15:53:44', '2024-01-24 02:07:43', 'multi', 'ps4', 30, '307'),
(22, 0, '2024-01-24 02:30:01', '2024-01-24 03:22:46', 'single', 'ps4', 20, '17'),
(23, 0, '2024-01-24 03:24:12', '2024-01-24 03:25:38', 'multi', 'ps4', 30, '1'),
(24, 0, '2024-01-26 04:09:57', '2024-01-26 16:28:17', 'single', 'ps4', 20, '246'),
(25, 0, '2024-01-28 01:35:15', '2024-01-28 01:36:20', 'single', 'ps4', 20, '0'),
(26, 0, '2024-01-28 01:37:03', '0000-00-00 00:00:00', 'single', 'ps4', 20, '0'),
(27, 0, '2024-01-28 01:37:08', '0000-00-00 00:00:00', 'multi', 'ps5', 50, '0'),
(28, 0, '2024-01-28 01:37:15', '0000-00-00 00:00:00', 'multi', 'ps4', 30, '0'),
(29, 1, '2024-01-28 02:55:10', '0000-00-00 00:00:00', 'multi', 'ps4', 30, '0'),
(30, 3, '2024-01-28 02:59:31', '0000-00-00 00:00:00', 'single', 'ps4', 20, '0'),
(31, 4, '2024-01-28 18:34:30', '2024-01-28 18:42:33', 'single', 'ps4', 20, '3'),
(32, 2, '2024-01-28 18:50:34', '2024-01-28 18:50:53', 'multi', 'ps5', 50, '0');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_name` varchar(191) NOT NULL,
  `room_number` int(11) NOT NULL,
  `is_available` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_name`, `room_number`, `is_available`, `created_at`) VALUES
(1, 'room 1', 1, 0, '2024-01-28 00:34:52'),
(2, 'room 2', 2, 1, '2024-01-28 00:34:52'),
(3, 'room 3', 3, 0, '2024-01-28 00:34:52'),
(4, 'room 4', 4, 1, '2024-01-28 00:37:57'),
(5, 'room 5', 5, 1, '2024-01-28 00:37:57'),
(6, 'room 6', 6, 1, '2024-01-28 00:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `product_name` varchar(191) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_price` int(11) NOT NULL,
  `type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_name`, `quantity`, `product_price`, `type`, `created_at`) VALUES
(5, 'لبن عادة', 10, 5, 'البان ', '2024-01-26 05:34:17'),
(6, 'فينو', 40, 5, '--', '2024-01-26 06:44:37');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `table_number` int(11) NOT NULL,
  `is_available` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `capacity`, `table_number`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 0, '2024-01-24 02:36:19', '2024-01-24 02:36:19'),
(2, 4, 2, 1, '2024-01-24 02:36:19', '2024-01-24 02:36:19'),
(3, 2, 3, 0, '2024-01-24 02:36:19', '2024-01-24 02:36:19'),
(4, 3, 4, 0, '2024-01-24 02:36:19', '2024-01-24 02:36:19'),
(5, 4, 5, 1, '2024-01-25 15:28:40', '2024-01-25 15:28:40'),
(6, 2, 6, 1, '2024-01-25 15:28:40', '2024-01-25 15:28:40'),
(7, 1, 7, 1, '2024-01-25 15:28:40', '2024-01-25 15:28:40'),
(8, 6, 8, 1, '2024-01-25 15:28:40', '2024-01-25 15:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `is_admin` int(11) NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`, `is_active`, `created_at`) VALUES
(3, 'adminadmin', '', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, '2024-01-26 14:37:11'),
(5, 'ابو فلة القلة زعبولا', 'karamila@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 0, '2024-01-27 02:08:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cafe_orders`
--
ALTER TABLE `cafe_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cafe_products`
--
ALTER TABLE `cafe_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cafe_products_orders`
--
ALTER TABLE `cafe_products_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foodcar_products`
--
ALTER TABLE `foodcar_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_orders`
--
ALTER TABLE `food_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_products_order`
--
ALTER TABLE `food_products_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playstation_configuration`
--
ALTER TABLE `playstation_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playstation_orders`
--
ALTER TABLE `playstation_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playstation_product_order`
--
ALTER TABLE `playstation_product_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playstation_session`
--
ALTER TABLE `playstation_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `table_number` (`table_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cafe_orders`
--
ALTER TABLE `cafe_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `cafe_products`
--
ALTER TABLE `cafe_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cafe_products_orders`
--
ALTER TABLE `cafe_products_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `foodcar_products`
--
ALTER TABLE `foodcar_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `food_orders`
--
ALTER TABLE `food_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `food_products_order`
--
ALTER TABLE `food_products_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `playstation_configuration`
--
ALTER TABLE `playstation_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `playstation_orders`
--
ALTER TABLE `playstation_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `playstation_product_order`
--
ALTER TABLE `playstation_product_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `playstation_session`
--
ALTER TABLE `playstation_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
