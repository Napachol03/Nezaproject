-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2026 at 11:15 AM
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
-- Database: `nexasupplypremium`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nexa_category`
--

CREATE TABLE `tbl_nexa_category` (
  `category_id` int(8) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `parent_id` int(8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nexa_product`
--

CREATE TABLE `tbl_nexa_product` (
  `product_id` int(8) NOT NULL COMMENT 'รหัสสินค้า',
  `product_name` varchar(255) NOT NULL COMMENT 'ชื่อสินค้า',
  `description` text DEFAULT NULL COMMENT 'รายละเอียดสินค้า',
  `category_id` int(8) NOT NULL,
  `attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'ใช้ JSONB ถ้าเป็น PostgreSQL เพราะเร็วกว่าและ query ได้ดีกว่า JSON ธรรมดา' CHECK (json_valid(`attributes`)),
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='อาจมีสินค้าที่หลากหลายเพื่อให้';

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nexa_product_image`
--

CREATE TABLE `tbl_nexa_product_image` (
  `image_id` int(8) NOT NULL,
  `product_id` int(8) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_nexa_category`
--
ALTER TABLE `tbl_nexa_category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `idx_parent` (`parent_id`);

--
-- Indexes for table `tbl_nexa_product`
--
ALTER TABLE `tbl_nexa_product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_name` (`product_name`),
  ADD KEY `idx_category` (`category_id`);

--
-- Indexes for table `tbl_nexa_product_image`
--
ALTER TABLE `tbl_nexa_product_image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `idx_product` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_nexa_category`
--
ALTER TABLE `tbl_nexa_category`
  MODIFY `category_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_nexa_product_image`
--
ALTER TABLE `tbl_nexa_product_image`
  MODIFY `image_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_nexa_category`
--
ALTER TABLE `tbl_nexa_category`
  ADD CONSTRAINT `fk_category_parent` FOREIGN KEY (`parent_id`) REFERENCES `tbl_nexa_category` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `tbl_nexa_product`
--
ALTER TABLE `tbl_nexa_product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `tbl_nexa_category` (`category_id`);

--
-- Constraints for table `tbl_nexa_product_image`
--
ALTER TABLE `tbl_nexa_product_image`
  ADD CONSTRAINT `fk_image_product` FOREIGN KEY (`product_id`) REFERENCES `tbl_nexa_product` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
