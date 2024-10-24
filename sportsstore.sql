-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 24, 2024 at 06:22 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportsstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

DROP TABLE IF EXISTS `donations`;
CREATE TABLE IF NOT EXISTS `donations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('card','googlepay','cod') NOT NULL,
  `payment_status` enum('Success','Failed') NOT NULL,
  `donated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `invoice_number` varchar(20) DEFAULT NULL,
  `card_number` varchar(20) DEFAULT NULL,
  `card_expiry` varchar(7) DEFAULT NULL,
  `card_cvc` varchar(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `stock` int DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Football Fifa', NULL, 900.00, 10, '2.png', '2024-10-10 05:36:06', '2024-10-10 05:36:06'),
(2, 'Running Shoe', NULL, 500.00, 6, '3.png', '2024-10-10 05:50:31', '2024-10-10 05:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `membership_plan` varchar(20) DEFAULT 'None',
  `payment_method` enum('card','googlepay','cod') DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `payment_status` enum('Success','Failed') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `dob`, `email`, `address`, `phone_number`, `password`, `membership_plan`, `payment_method`, `role`, `reset_token`, `reset_token_expiry`, `payment_status`) VALUES
(1, 'Sathyaprakash', 'P', '2004-07-08', 'sathyaprakashpprabhu@gmail.com', 'House', '8137967016', '$2y$10$UcSng82.qqYd76Wcvj.TIeX6ICJYMgFyjDTpo/zzOCHuBG4EOOEHa', 'Premium', 'card', 'admin', '298066b37f91ff00e6b827295f1d309418d4139b42c06f9a0170492f09f83ba8bebaecdc30193e70f8f29de3859e7c344e72', '2024-10-09 20:11:51', ''),
(4, 's', 'p', '2024-09-11', 'sp@gmail.com', 'asasfasfsafaf', '5987612378', '$2y$10$2V3aHGBgkrcYa.aYrPKJfeCiM1i6uqdMESTKCXjfXIK/TKmlb3UCy', 'None', NULL, 'user', NULL, NULL, NULL),
(5, 's', 'p', '2010-07-23', 'sathyap@gmail.com', 'asasfasfsafaf', '5987612378', '$2y$10$FGfnB9YAxyPP2iXAz.wSzuO65WHTPwTwNx51NQ2jpwLnDc3Mlx2VG', 'None', NULL, 'user', NULL, NULL, NULL),
(6, 'alfin', 'b', '2004-10-12', 'alfinb@gmail.com', 'asasfasfsafaf', '8712619722', '$2y$10$ITFgYIiWZKC5B8unqM70ROreMXPG.mddm2vl61SKkcggkxWyBCXcy', 'None', NULL, 'admin', NULL, NULL, NULL),
(7, 'ranimol', 'vg', '2009-02-11', 'ranimolvg@gmail.com', 'hekjlfmklml', '5348453883', '$2y$10$DkPe1x4aANBxUYdf8WsPneJkPdIR0vJEaEPHNCo8DwkHntmvPMHuC', 'None', NULL, 'user', NULL, NULL, NULL),
(8, 'Suryajith', 'S', '2002-08-26', 'suryajith08@gmail.com', 'Bla', '123456789', '$2y$10$o9qkj46ACahVsh/GXqYw1.oTxLxWtI6aGvWm1R0Kydy41ANUDSNzm', 'None', NULL, 'user', NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
