-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 30, 2026 at 12:55 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quotation_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE `accessories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `accessory_name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`id`, `category_id`, `accessory_name`, `category`, `unit`, `price`, `status`, `created_at`) VALUES
(1, 4, 'Cutlery Tray 450mm', 'Cutlery', '1', 1920.00, 'active', '2026-06-04 05:07:43'),
(2, 4, 'Cutlery Tray 600mm', 'Cutlery', '1', 2100.00, 'active', '2026-06-04 05:13:43'),
(3, 4, 'Cutlery Tray 900mm', 'Cutlery', '1', 3550.00, 'active', '2026-06-04 08:35:30'),
(4, 4, 'Cutlery Tray 1200mm', 'Cutlery', '1', 3630.00, 'active', '2026-06-04 08:35:52'),
(5, 6, 'Dishrack 600mm', 'Dishrack', '1', 14700.00, 'active', '2026-06-04 08:36:36'),
(6, 6, 'Dishrack 900mm', 'Dishrack', '1', 16275.00, 'active', '2026-06-04 08:37:14'),
(7, 2, 'BPO (Bottle pull out) 150mm', 'BPO', '1', 11025.00, 'active', '2026-06-04 08:37:53'),
(8, 2, 'BPO (Bottle pull out) 300mm', 'BPO', '1', 19425.00, 'active', '2026-06-04 08:38:17'),
(9, 15, 'Wasteboy Dustbin (Steel 15L)', 'Wasteboy Dustbin', '1', 9608.00, 'active', '2026-06-04 08:39:04'),
(10, 15, 'Wasteboy Dustbin (Pull Out) 400mm', 'Wasteboy Dustbin', '1', 12180.00, 'active', '2026-06-04 08:39:31'),
(11, 16, 'Wicker Basket 450mm', 'Wicker Basket', '1', 10868.00, 'active', '2026-06-04 08:40:23'),
(12, 16, 'Wicker Basket 600mm', 'Wicker Basket', '1', 12317.00, 'active', '2026-06-04 08:40:46'),
(13, 8, 'Larder Unit 300mm (Height 1900-2200mm)', 'Larder Unit', '1', 50400.00, 'active', '2026-06-04 08:41:29'),
(14, 8, 'Larder Unit 400mm (Height 1900-2200mm)', 'Larder Unit', '1', 54075.00, 'active', '2026-06-04 08:42:06'),
(15, 10, 'Pantry Unit 450mm (Height 1900-2200mm)', 'Pantry Unit', '1', 75075.00, 'active', '2026-06-04 08:42:45'),
(16, 10, 'Pantry Unit 60mm (Height 1900-2200mm)', 'Pantry Unit', '1', 78225.00, 'active', '2026-06-04 08:43:12'),
(17, 5, 'Detergent Rack 300mm', 'Detergent rack', '1', 8200.00, 'active', '2026-06-04 08:43:46'),
(18, 3, 'Corner Fitting (Lava grey : Right door) 450mm', 'Corner Fitting ', '1', 123391.00, 'active', '2026-06-04 08:44:16'),
(19, 3, 'Corner Fitting (Lava grey : Left door) 450mm', 'Corner Fitting ', '1', 122515.00, 'active', '2026-06-04 08:44:42'),
(20, 3, 'Corner Fitting (Lava grey : Right door) 600mm', 'Corner Fitting ', '1', 135016.00, 'active', '2026-06-04 08:45:38'),
(21, 3, 'Corner Fitting (Lava grey : Left door) 600mm', 'Corner Fitting ', '1', 129209.00, 'active', '2026-06-04 08:46:03'),
(22, 7, 'DISPENSA VVS Anthracite (Pantry unit) 300mm', 'DISPENSA VVS Anthracite ', '1', 71114.00, 'active', '2026-06-05 04:32:44'),
(23, 7, 'DISPENSA VVS Anthracite (Pantry unit) 400mm', 'DISPENSA VVS Anthracite ', '1', 75686.00, 'active', '2026-06-05 04:33:14'),
(24, 1, ' DISPENSA VVS 300 Arenapure (pantry unit) 300mm', ' DISPENSA VVS 300 Arenapure', '1', 71114.00, 'active', '2026-06-05 04:34:02'),
(25, 1, ' DISPENSA VVS 300 Arenapure (pantry unit) 400mm', ' DISPENSA VVS 300 Arenapure', '1', 73023.00, 'active', '2026-06-05 04:34:24'),
(26, 13, 'Tandem pantry chrome 450mm x 1100mm', 'Tandem pantry chrome', '1', 72006.00, 'active', '2026-06-05 04:35:27'),
(27, 13, 'Tandem pantry chrome 450mm x 1700mm', 'Tandem pantry chrome', '1', 93129.00, 'active', '2026-06-05 04:35:55'),
(28, 11, 'TANDEM Pantry Anthracite 450mm x 1700mm', 'TANDEM Pantry Anthracite', '1', 91835.00, 'active', '2026-06-05 04:36:31'),
(29, 11, 'TANDEM Pantry Anthracite 600mm x 1700mm', 'TANDEM Pantry Anthracite', '1', 105552.00, 'active', '2026-06-05 04:37:47'),
(30, 13, 'TANDEM Pantry Chrome 600mm x 1100mm', 'Tandem pantry chrome', '1', 84207.00, 'active', '2026-06-05 04:38:28'),
(31, 13, 'TANDEM Pantry Chrome 600mm x 1700mm', 'Tandem pantry chrome', '1', 107039.00, 'active', '2026-06-05 04:38:50'),
(32, 12, 'TANDEM Pantry ArenaPure 600mm x 1700mm', 'Tandem pantry Arenapure', '1', 108596.00, 'active', '2026-06-05 04:41:05'),
(33, 14, 'TANDEM Side Arenapure 600mm x 1700mm', 'TANDEM Side Arenapure', '1', 108596.00, 'active', '2026-06-05 04:42:22'),
(34, 9, 'LeMans || 450mm RH', 'LeMans', '1', 48154.00, 'active', '2026-06-05 04:44:28'),
(35, 9, 'LeMans || 450mm LH', 'LeMans', '1', 48154.00, 'active', '2026-06-05 04:45:12'),
(36, 9, 'LeMans || 600mm RH', 'LeMans', '1', 53336.00, 'active', '2026-06-05 04:45:34'),
(37, 9, 'LeMans || 600mm LH', 'LeMans', '1', 53336.00, 'active', '2026-06-05 04:46:16'),
(38, 9, 'LeMans II 450mm RH Anthracite', 'LeMans', '1', 47486.00, 'active', '2026-06-05 04:47:48'),
(39, 9, 'LeMans || 450mm LH Anthracite', 'LeMans', '1', 47486.00, 'active', '2026-06-05 04:48:30'),
(40, 9, 'LeMans || 600mm RH Anthracite', 'LeMans', '1', 52604.00, 'active', '2026-06-05 04:50:02'),
(41, 9, 'LeMans || 600mm LH Anthracite', 'LeMans', '1', 52604.00, 'active', '2026-06-05 04:50:46'),
(42, 9, 'LeMans || 450mm RH arena pure', 'LeMans', '1', 47484.00, 'active', '2026-06-05 04:52:47'),
(43, 9, 'LeMans || 450mm LH arena pure', 'LeMans', '1', 47484.00, 'active', '2026-06-05 04:53:13'),
(44, 9, 'LeMans || 600mm RH arena pure', 'LeMans', '1', 52428.00, 'active', '2026-06-05 04:53:43'),
(45, 9, 'LeMans || 600mm LH arena pure', '9', '1', 52428.00, 'active', '2026-06-05 04:54:18');

-- --------------------------------------------------------

--
-- Table structure for table `accessory_categories`
--

CREATE TABLE `accessory_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accessory_categories`
--

INSERT INTO `accessory_categories` (`id`, `category_name`, `status`, `created_at`) VALUES
(1, ' DISPENSA VVS 300 Arenapure', 1, '2026-06-30 04:40:11'),
(2, 'BPO', 1, '2026-06-30 04:40:11'),
(3, 'Corner Fitting ', 1, '2026-06-30 04:40:11'),
(4, 'Cutlery', 1, '2026-06-30 04:40:11'),
(5, 'Detergent rack', 1, '2026-06-30 04:40:11'),
(6, 'Dishrack', 1, '2026-06-30 04:40:11'),
(7, 'DISPENSA VVS Anthracite ', 1, '2026-06-30 04:40:11'),
(8, 'Larder Unit', 1, '2026-06-30 04:40:11'),
(9, 'LeMans', 1, '2026-06-30 04:40:11'),
(10, 'Pantry Unit', 1, '2026-06-30 04:40:11'),
(11, 'TANDEM Pantry Anthracite', 1, '2026-06-30 04:40:11'),
(12, 'Tandem pantry Arenapure', 1, '2026-06-30 04:40:11'),
(13, 'Tandem pantry chrome', 1, '2026-06-30 04:40:11'),
(14, 'TANDEM Side Arenapure', 1, '2026-06-30 04:40:11'),
(15, 'Wasteboy Dustbin', 1, '2026-06-30 04:40:11'),
(16, 'Wicker Basket', 1, '2026-06-30 04:40:11');

-- --------------------------------------------------------

--
-- Table structure for table `carcass_categories`
--

CREATE TABLE `carcass_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carcass_categories`
--

INSERT INTO `carcass_categories` (`id`, `category_name`, `status`, `created_at`) VALUES
(1, 'Base Units Carcass 600MM Deep (Without Any shelf  & drawer)', 1, '2026-06-01 05:14:06'),
(2, 'Tall Cabinet Carcass 600MM Deep (Without Any Shelves & Drawers)', 1, '2026-06-01 05:16:15'),
(3, 'Wall Units Carcass 350MM Deep (Without Any Shelves & Drawers)', 1, '2026-06-01 05:16:24'),
(4, 'Loft Cabinet Carcass 350MM Deep (Without Any Shelves & Drawers)', 1, '2026-06-29 06:27:49'),
(5, 'Loft Cabinet Carcass more than 350MM Deep (Without Any Shelves & Drawers)', 1, '2026-06-29 06:28:10');

-- --------------------------------------------------------

--
-- Table structure for table `carcass_materials`
--

CREATE TABLE `carcass_materials` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `material_name` varchar(255) NOT NULL,
  `price_per_sqft` decimal(10,2) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carcass_materials`
--

INSERT INTO `carcass_materials` (`id`, `category_id`, `material_name`, `price_per_sqft`, `status`, `created_at`) VALUES
(14, 1, 'Full White SUD Laminate, Inside and Outside', 3150.00, 1, '2026-06-01 05:16:47'),
(15, 1, 'Non-Textured Fabric Finish Laminate, Inside and Outside ', 3350.00, 1, '2026-06-01 05:17:01'),
(16, 1, 'Premium SUD Laminate Outside and White Laminate Inside', 3550.00, 0, '2026-06-01 05:17:17'),
(17, 1, 'Premium SUD Laminate Outside and Fabric Laminate Inside', 3650.00, 0, '2026-06-01 05:17:34'),
(18, 1, 'Premium SUD Non-Textured Woodgrain Laminate Outside and Inside', 4000.00, 0, '2026-06-01 05:17:46'),
(21, 2, 'Full White SUD Laminate, Inside and Outside', 3150.00, 1, '2026-06-01 05:20:39'),
(22, 2, 'Non-Textured Fabric Finish Laminate, Inside and Outside ', 3350.00, 1, '2026-06-01 05:20:59'),
(23, 2, 'Premium SUD Laminate Outside and White Laminate Inside', 3550.00, 0, '2026-06-01 05:21:19'),
(24, 2, 'Premium SUD Laminate Outside and Fabric Laminate Inside', 3650.00, 0, '2026-06-01 05:21:34'),
(25, 2, 'Premium SUD Non-Textured Woodgrain Laminate Outside and Inside', 4000.00, 0, '2026-06-01 05:21:49'),
(26, 3, 'Full White SUD Laminate, Inside and Outside', 2900.00, 1, '2026-06-01 05:22:17'),
(27, 3, 'Non-Textured Fabric Finish Laminate, Inside and Outside ', 3100.00, 1, '2026-06-01 05:22:27'),
(28, 3, 'Premium SUD Laminate Outside and White Laminate Inside', 3300.00, 0, '2026-06-01 05:22:41'),
(29, 3, 'Premium SUD Laminate Outside and Fabric Laminate Inside', 3400.00, 0, '2026-06-01 05:23:04'),
(30, 3, 'Premium SUD Non-Textured Woodgrain Laminate Outside and Inside', 3750.00, 0, '2026-06-01 05:23:18'),
(31, 4, 'Full White SUD Laminate, Inside and Outside', 2900.00, 1, '2026-06-29 06:28:50'),
(32, 4, 'Non-Textured Fabric Finish Laminate, Inside and Outside', 3100.00, 1, '2026-06-29 06:31:20'),
(33, 5, 'Full White SUD Laminate, Inside and Outside', 3150.00, 1, '2026-06-29 06:31:51'),
(34, 5, 'Non-Textured Fabric Finish Laminate, Inside and Outside', 3350.00, 1, '2026-06-29 06:32:08'),
(35, 1, 'Premium SUD Laminate Outside and Inside', 4000.00, 1, '2026-06-30 06:03:15'),
(36, 2, 'Premium SUD Laminate Outside and Inside', 4000.00, 1, '2026-06-30 06:03:41'),
(37, 5, 'Premium SUD Laminate Outside and Inside', 4000.00, 1, '2026-06-30 06:04:04'),
(38, 3, 'Premium SUD Laminate Outside and Inside', 3750.00, 1, '2026-06-30 06:04:32'),
(39, 4, 'Premium SUD Laminate Outside and Inside', 3750.00, 1, '2026-06-30 06:04:46');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gst_number` varchar(50) DEFAULT NULL,
  `pan_number` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `address`, `gst_number`, `pan_number`, `email`, `phone`, `shipping_address`, `created_at`, `updated_at`) VALUES
(1, 'F&R KITCHENS AND WARDROBES PRIVATE LIMITED', 'Unit L 5 and L 6, Shree Raj Laxmi Hitech Textile Park, Kalyan Bhiwandi Junction,Kalyan,THANE Place of Supply: MAHARASHTRA 421302 MAHARASHTRA', '27AAFCF8498K1ZT', 'AAFCF8498K', '', '', 'Unit L 5 and L 6, Shree Raj Laxmi Hitech Textile Park, Kalyan Bhiwandi Junction,Kalyan,THANE Place of Supply: MAHARASHTRA 421302 MAHARASHTRA', '2026-06-03 07:14:38', '2026-06-03 07:33:23'),
(2, 'craftreD Designs Pvt. Ltd', 'L-5/L-6,Shree Raj Laxmi Hi-Tech Textile Park, Village - Sonale,\r\nTaluka- Bhiwandi, Thane - 421302', '27AADCC3846L1ZE', '', 'shilpa@craftred.in', '', 'L-5/L-6,Shree Raj Laxmi Hi-Tech Textile Park, Village - Sonale,\r\nTaluka- Bhiwandi, Thane - 421302', '2026-06-03 07:14:38', '2026-06-03 07:33:04'),
(179, 'Rishi', '                                                                                                                                                                                                                            ', '', '', '', '', '', '2026-06-24 06:48:20', '2026-06-26 06:56:12'),
(180, 'Yadav Rishi', 'Pratap Nagar Rd, , Mumbai, Maharashtra                                                                                                                                                                                                                                                                                                                                                                                                                ', '27AADCC3846L1ZE', 'AAFCF8498K', 'itsrishi8687@gmail.com', '07738443562', 'Pratap Nagar Rd, , Mumbai, Maharashtra', '2026-06-24 11:48:17', '2026-06-26 07:08:34'),
(188, 'r', '                                                                                                    ', '', '', '', '', '', '2026-06-26 05:59:01', '2026-06-26 06:36:01'),
(189, '', '                                                                                                                                                                                                                            ', '', '', '', '', '', '2026-06-26 07:33:43', '2026-06-26 09:14:34'),
(190, 'r', 'Pratap Nagar Rd, , Mumbai, Uttar Pradesh                                        ', '27AADCC3846L1ZE', 'aaaa', 'itsrishi8687@gmail.com', '07738443562', '50, 2nd Floor, Shreeji Bhavan, Mangaldas Road, Kalbadevi, Mumbai, Maharashtra         ', '2026-06-26 11:52:08', '2026-06-27 05:12:31'),
(205, '', '                    ', '', '', '', '', '', '2026-06-30 04:58:34', '2026-06-30 08:26:37'),
(206, '', '                                                                                                    ', '', '', '', '', '', '2026-06-30 08:50:42', '2026-06-30 09:57:51'),
(207, '', '', '', '', '', '', '', '2026-06-30 09:43:04', '2026-06-30 09:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `registered_address` text DEFAULT NULL,
  `admin_address` text DEFAULT NULL,
  `pan_number` varchar(50) DEFAULT NULL,
  `gst_number` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `landline_number` varchar(50) DEFAULT NULL,
  `cin_number` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `registered_address`, `admin_address`, `pan_number`, `gst_number`, `email`, `landline_number`, `cin_number`, `created_at`, `updated_at`) VALUES
(1, 'F&R KITCHEN AND WARDROBES PVT LTD', 'L-5/L-6,Shree Raj Laxmi Hi-Tech Textile Park, Village - Sonale,\r\nTaluka- Bhiwandi, Thane - 421302', '', '', '27AAFCF8498K1ZT', 'operations@frindia.com', '02522-280036 / 86', 'U36101MH2008PTC182248', '2026-06-01 12:44:50', '2026-06-18 11:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `drawers_data`
--

CREATE TABLE `drawers_data` (
  `id` int(11) NOT NULL,
  `assigned_unit_id` varchar(100) DEFAULT NULL,
  `drawer_categories_id` int(11) DEFAULT NULL,
  `drawer_materials_id` int(11) DEFAULT NULL,
  `width_mm` decimal(10,2) DEFAULT NULL,
  `width_ft` decimal(10,2) DEFAULT NULL,
  `height_mm` decimal(10,2) DEFAULT NULL,
  `height_ft` decimal(10,2) DEFAULT NULL,
  `sqft` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drawers_data`
--

INSERT INTO `drawers_data` (`id`, `assigned_unit_id`, `drawer_categories_id`, `drawer_materials_id`, `width_mm`, `width_ft`, `height_mm`, `height_ft`, `sqft`, `price`, `total`, `quotation_id`, `quantity`) VALUES
(90, 'Tall_1', 14, 344, 600.00, 1.97, 600.00, 1.97, 0.00, 11890.00, 11890.00, 192, 1),
(91, 'Tall_1', 14, 344, 600.00, 1.97, 600.00, 1.97, 0.00, 11890.00, 11890.00, 193, 1),
(292, 'E1_Tall_1', 3, 45, 600.00, 1.97, 600.00, 1.97, 0.00, 18300.00, 18300.00, 257, 1),
(295, 'E1_Tall_1', 1, 12, 600.00, 1.97, 150.00, 0.49, 0.00, 18820.00, 56460.00, 248, 3),
(296, 'E1_Tall_1', 16, 395, 800.00, 2.62, 800.00, 2.62, 0.00, 39880.00, 119640.00, 248, 3),
(430, 'E1_Tall_1', 1, 2, 600.00, 1.97, 150.00, 0.49, 0.00, 17080.00, 51240.00, 259, 3),
(431, 'E1_Tall_3', 5, 83, 600.00, 1.97, 400.00, 1.31, 0.00, 24480.00, 73440.00, 259, 3),
(432, 'E1_Bottom_2', 3, 44, 600.00, 1.97, 200.00, 0.66, 0.00, 19200.00, 38400.00, 259, 2),
(433, 'E1_Loft_2', 3, 29, 600.00, 1.97, 200.00, 0.66, 0.00, 17710.00, 70840.00, 259, 4);

-- --------------------------------------------------------

--
-- Table structure for table `drawer_categories`
--

CREATE TABLE `drawer_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drawer_categories`
--

INSERT INTO `drawer_categories` (`id`, `category_name`, `status`, `created_at`) VALUES
(1, '600 x 150 @30kg', 1, '2026-05-30 05:26:30'),
(3, '600 x 200 @30kg', 1, '2026-05-30 05:56:28'),
(4, '600 x 400 @30kg', 1, '2026-05-30 05:56:56'),
(5, '600 x 400 @65kg', 1, '2026-05-30 05:57:57'),
(6, '750 x 150 @30kg', 1, '2026-05-30 05:58:22'),
(7, '750 x 200 @30kg', 1, '2026-05-30 05:59:00'),
(8, '750 x 400 @30kg', 1, '2026-05-30 05:59:23'),
(9, '750 x 400 @65kg', 1, '2026-05-30 05:59:38'),
(10, '900 x 150 @30kg', 1, '2026-05-30 06:00:46'),
(11, '900 x 200 @30kg', 1, '2026-05-30 06:00:55'),
(12, '900 x 400 @30kg', 1, '2026-05-30 06:01:06'),
(13, '900 x 400 @65kg', 1, '2026-05-30 06:01:16'),
(14, '1200 x 150 @30kg', 1, '2026-05-30 06:01:42'),
(15, '1200 x 200 @30kg', 1, '2026-05-30 06:01:51'),
(16, '1200 x 400 @30kg', 1, '2026-05-30 06:02:02'),
(17, '1200 x 400 @65kg', 1, '2026-05-30 06:02:10');

-- --------------------------------------------------------

--
-- Table structure for table `drawer_materials`
--

CREATE TABLE `drawer_materials` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `material_name` varchar(255) DEFAULT NULL,
  `price_per_sqft` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drawer_materials`
--

INSERT INTO `drawer_materials` (`id`, `category_id`, `material_name`, `price_per_sqft`, `status`, `created_at`) VALUES
(1, 1, 'Laminate @ INR 1200 / Sheet with matching edgeband', 16900.00, 1, '2026-05-30 05:27:29'),
(2, 1, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 17080.00, 1, '2026-05-30 06:03:04'),
(3, 1, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 17310.00, 1, '2026-05-30 06:03:37'),
(4, 1, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 17550.00, 1, '2026-05-30 06:04:08'),
(5, 1, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 18000.00, 1, '2026-05-30 06:04:52'),
(6, 1, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 18470.00, 1, '2026-05-30 06:05:11'),
(7, 1, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 18940.00, 1, '2026-05-30 06:05:35'),
(8, 1, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 19400.00, 1, '2026-05-30 06:07:03'),
(9, 1, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 19870.00, 1, '2026-05-30 06:07:34'),
(10, 1, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 17620.00, 1, '2026-05-30 06:08:55'),
(11, 1, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 17650.00, 1, '2026-05-30 06:09:17'),
(12, 1, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 18820.00, 1, '2026-05-30 06:09:41'),
(13, 1, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 19020.00, 1, '2026-05-30 06:10:00'),
(14, 1, 'Ceramic Tile Shutter with Black Profile', 20950.00, 1, '2026-05-30 06:12:14'),
(15, 1, 'Color Matt PU (Without Handle)', 17000.00, 1, '2026-05-30 06:12:56'),
(16, 1, 'Color Matt PU PANELLED (Without Handle)', 17320.00, 1, '2026-05-30 06:14:26'),
(17, 1, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 18020.00, 1, '2026-05-30 06:15:01'),
(18, 1, 'Color Glossy PU (Without Handle)', 17220.00, 1, '2026-05-30 06:15:44'),
(19, 1, 'Color Glossy PU PANELLED (Without Handle)', 17550.00, 1, '2026-05-30 06:16:07'),
(20, 1, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 18230.00, 1, '2026-05-30 06:16:49'),
(21, 1, 'Metallic PU - 1 Color (Without Handle)', 19140.00, 1, '2026-05-30 06:18:06'),
(22, 1, 'Metallic PU - Ombre (Without Handle)', 19910.00, 1, '2026-05-30 06:18:33'),
(23, 1, 'Metallic PU - Textured (Without Handle)', 20460.00, 1, '2026-05-30 06:18:56'),
(24, 1, 'Veneer @150 per sqft Shutter with matching Edgeband', 19160.00, 1, '2026-05-30 06:19:17'),
(25, 1, 'Veneer @400 per sqft Shutter with matching Edgeband', 20830.00, 1, '2026-05-30 06:19:36'),
(26, 1, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 22230.00, 1, '2026-05-30 06:20:07'),
(27, 1, '5mm Thick Flutted Wood Shutters with matching Edgeband', 23650.00, 1, '2026-05-30 06:20:26'),
(28, 3, 'Laminate @ INR 1200 / Sheet with matching edgeband', 17450.00, 1, '2026-05-30 06:48:30'),
(29, 3, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 17710.00, 1, '2026-05-30 06:48:54'),
(30, 3, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 18010.00, 1, '2026-05-30 06:51:32'),
(31, 3, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 18330.00, 1, '2026-05-30 06:51:51'),
(32, 3, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 18940.00, 1, '2026-05-30 06:52:35'),
(33, 3, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 19560.00, 1, '2026-05-30 06:52:55'),
(34, 3, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 20190.00, 1, '2026-05-30 06:53:11'),
(35, 3, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 20800.00, 1, '2026-05-30 06:53:41'),
(36, 3, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 21430.00, 1, '2026-05-30 06:54:09'),
(37, 3, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 18320.00, 1, '2026-05-30 06:54:27'),
(38, 3, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 18350.00, 1, '2026-05-30 06:54:56'),
(39, 3, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 19920.00, 1, '2026-05-30 06:56:03'),
(40, 3, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 20190.00, 1, '2026-05-30 06:56:21'),
(41, 3, 'Ceramic Tile Shutter with Black Profile', 22200.00, 1, '2026-05-30 06:56:38'),
(42, 3, 'Color Matt PU (Without Handle)', 18000.00, 1, '2026-05-30 06:57:19'),
(43, 3, 'Color Matt PU PANELLED (Without Handle)', 18440.00, 1, '2026-05-30 06:57:43'),
(44, 3, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 19200.00, 1, '2026-05-30 06:58:04'),
(45, 3, 'Color Glossy PU (Without Handle)', 18300.00, 1, '2026-05-30 06:58:45'),
(46, 3, 'Color Glossy PU PANELLED (Without Handle)', 18740.00, 1, '2026-05-30 06:59:03'),
(47, 3, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 19480.00, 1, '2026-05-30 06:59:26'),
(48, 3, 'Metallic PU - 1 Color (Without Handle)', 20560.00, 1, '2026-05-30 06:59:57'),
(49, 3, 'Metallic PU - Ombre (Without Handle)', 21590.00, 1, '2026-05-30 07:00:20'),
(50, 3, 'Metallic PU - Textured (Without Handle)', 22320.00, 1, '2026-05-30 07:00:54'),
(51, 3, 'Veneer @150 per sqft Shutter with matching Edgeband', 20660.00, 1, '2026-05-30 07:01:09'),
(52, 3, 'Veneer @400 per sqft Shutter with matching Edgeband', 22890.00, 1, '2026-05-30 07:01:24'),
(53, 3, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 24760.00, 1, '2026-05-30 07:01:40'),
(54, 3, '5mm Thick Flutted Wood Shutters with matching Edgeband', 26650.00, 1, '2026-05-30 07:01:52'),
(55, 4, 'Laminate @ INR 1200 / Sheet with matching edgeband', 22300.00, 1, '2026-05-30 07:02:20'),
(56, 4, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 22830.00, 1, '2026-05-30 07:02:46'),
(57, 4, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 23470.00, 1, '2026-05-30 07:03:09'),
(58, 4, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 24130.00, 1, '2026-05-30 07:03:25'),
(59, 4, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 26730.00, 1, '2026-05-30 07:03:53'),
(60, 4, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 25430.00, 1, '2026-05-30 07:04:22'),
(61, 4, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 28040.00, 1, '2026-05-30 07:04:39'),
(62, 4, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 29340.00, 1, '2026-05-30 07:04:56'),
(63, 4, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 30650.00, 1, '2026-05-30 07:05:15'),
(64, 4, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 23770.00, 1, '2026-05-30 07:05:32'),
(65, 4, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 23820.00, 1, '2026-05-30 07:05:49'),
(66, 4, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 27110.00, 1, '2026-05-30 07:06:02'),
(67, 4, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 27690.00, 1, '2026-05-30 07:06:18'),
(68, 4, 'Ceramic Tile Shutter with Black Profile', 30100.00, 1, '2026-05-30 07:06:33'),
(69, 4, 'Color Matt PU (Without Handle)', 24760.00, 1, '2026-05-30 07:06:51'),
(70, 4, 'Color Matt PU PANELLED (Without Handle)', 25680.00, 1, '2026-05-30 07:07:08'),
(71, 4, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 26740.00, 1, '2026-05-30 07:07:31'),
(72, 4, 'Color Glossy PU (Without Handle)', 25380.00, 1, '2026-05-30 07:08:10'),
(73, 4, 'Color Glossy PU PANELLED (Without Handle)', 26300.00, 1, '2026-05-30 07:08:26'),
(74, 4, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 27340.00, 1, '2026-05-30 07:08:50'),
(75, 4, 'Metallic PU - 1 Color (Without Handle)', 29170.00, 1, '2026-05-30 07:09:14'),
(76, 4, 'Metallic PU - Ombre (Without Handle)', 31330.00, 1, '2026-05-30 07:10:47'),
(77, 4, 'Metallic PU - Textured (Without Handle)', 32870.00, 1, '2026-05-30 07:11:09'),
(78, 4, 'Veneer @150 per sqft Shutter with matching Edgeband', 29620.00, 1, '2026-05-30 07:11:49'),
(79, 4, 'Veneer @400 per sqft Shutter with matching Edgeband', 34310.00, 1, '2026-05-30 07:12:02'),
(80, 4, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 38230.00, 1, '2026-05-30 07:12:15'),
(81, 4, '5mm Thick Flutted Wood Shutters with matching Edgeband', 42190.00, 1, '2026-05-30 07:12:29'),
(82, 5, 'Laminate @ INR 1200 / Sheet with matching edgeband', 23950.00, 1, '2026-05-30 07:13:41'),
(83, 5, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 24480.00, 1, '2026-05-30 07:13:59'),
(84, 5, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 25120.00, 1, '2026-05-30 07:14:16'),
(85, 5, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 25780.00, 1, '2026-05-30 07:14:41'),
(86, 5, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 27080.00, 1, '2026-05-30 07:15:04'),
(87, 5, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 28380.00, 1, '2026-05-30 07:15:24'),
(88, 5, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 29690.00, 1, '2026-05-30 07:15:46'),
(89, 5, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 30990.00, 1, '2026-05-30 07:16:02'),
(90, 5, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 32300.00, 1, '2026-05-30 07:16:21'),
(91, 5, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 25420.00, 1, '2026-05-30 07:16:41'),
(92, 5, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 25470.00, 1, '2026-05-30 07:17:04'),
(93, 5, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 28760.00, 1, '2026-05-30 07:17:23'),
(94, 5, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 29340.00, 1, '2026-05-30 07:17:41'),
(95, 5, 'Ceramic Tile Shutter with Black Profile', 31750.00, 1, '2026-05-30 07:19:55'),
(96, 5, 'Color Matt PU (Without Handle)', 26410.00, 1, '2026-05-30 07:20:17'),
(97, 5, 'Color Matt PU PANELLED (Without Handle)', 27330.00, 1, '2026-05-30 07:20:34'),
(98, 5, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 28390.00, 1, '2026-05-30 07:20:58'),
(99, 5, 'Color Glossy PU (Without Handle)', 27030.00, 1, '2026-05-30 07:21:33'),
(100, 5, 'Color Glossy PU PANELLED (Without Handle)', 27950.00, 1, '2026-05-30 07:21:55'),
(101, 5, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 28990.00, 1, '2026-05-30 07:22:15'),
(102, 5, 'Metallic PU - 1 Color (Without Handle)', 30820.00, 1, '2026-05-30 07:22:31'),
(103, 5, 'Metallic PU - Ombre (Without Handle)', 32980.00, 1, '2026-05-30 07:22:46'),
(104, 5, 'Metallic PU - Textured (Without Handle)', 34520.00, 1, '2026-05-30 07:23:00'),
(105, 5, 'Veneer @150 per sqft Shutter with matching Edgeband', 31270.00, 1, '2026-05-30 07:23:14'),
(106, 5, 'Veneer @400 per sqft Shutter with matching Edgeband', 35960.00, 1, '2026-05-30 07:23:27'),
(107, 5, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 39880.00, 1, '2026-05-30 07:23:47'),
(108, 5, '5mm Thick Flutted Wood Shutters with matching Edgeband', 43840.00, 1, '2026-05-30 07:24:06'),
(109, 6, 'Laminate @ INR 1200 / Sheet with matching edgeband', 18380.00, 1, '2026-05-30 07:31:13'),
(110, 6, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 18620.00, 1, '2026-05-30 07:31:30'),
(111, 6, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 18900.00, 1, '2026-05-30 07:31:50'),
(112, 6, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 19200.00, 1, '2026-05-30 07:32:07'),
(113, 6, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 19780.00, 1, '2026-05-30 07:32:44'),
(114, 6, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 20360.00, 1, '2026-05-30 07:33:19'),
(115, 6, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 20950.00, 1, '2026-05-30 07:33:37'),
(116, 6, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 21530.00, 1, '2026-05-30 07:33:57'),
(117, 6, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 22110.00, 1, '2026-05-30 07:34:13'),
(118, 6, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 19280.00, 1, '2026-05-30 07:56:19'),
(119, 6, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 19300.00, 1, '2026-05-30 07:56:49'),
(120, 6, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 20770.00, 1, '2026-05-30 07:57:07'),
(121, 6, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 21030.00, 1, '2026-05-30 07:57:29'),
(122, 6, 'Ceramic Tile Shutter with Black Profile', 23290.00, 1, '2026-05-30 07:57:46'),
(123, 6, 'Color Matt PU (Without Handle)', 18580.00, 1, '2026-05-30 07:58:04'),
(124, 6, 'Color Matt PU PANELLED (Without Handle)', 19000.00, 1, '2026-05-30 07:58:33'),
(125, 6, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 19870.00, 1, '2026-05-30 07:58:47'),
(126, 6, 'Color Glossy PU (Without Handle)', 18860.00, 1, '2026-05-30 07:59:16'),
(127, 6, 'Color Glossy PU PANELLED (Without Handle)', 19270.00, 1, '2026-05-30 08:00:17'),
(128, 6, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 20150.00, 1, '2026-05-30 08:02:07'),
(129, 6, 'Metallic PU - 1 Color (Without Handle)', 21200.00, 1, '2026-05-30 08:02:26'),
(130, 6, 'Metallic PU - Ombre (Without Handle)', 22160.00, 1, '2026-05-30 08:02:40'),
(131, 6, 'Metallic PU - Textured (Without Handle)', 22860.00, 1, '2026-05-30 08:03:00'),
(132, 6, 'Veneer @150 per sqft Shutter with matching Edgeband', 21240.00, 1, '2026-05-30 08:03:44'),
(133, 6, 'Veneer @400 per sqft Shutter with matching Edgeband', 23340.00, 1, '2026-05-30 08:03:56'),
(134, 6, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 25080.00, 1, '2026-05-30 08:04:10'),
(135, 6, '5mm Thick Flutted Wood Shutters with matching Edgeband', 26850.00, 1, '2026-05-30 08:04:25'),
(136, 7, 'Laminate @ INR 1200 / Sheet with matching edgeband', 19080.00, 1, '2026-05-30 08:06:25'),
(137, 7, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 19400.00, 1, '2026-05-30 08:06:44'),
(138, 7, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 19780.00, 1, '2026-05-30 08:07:12'),
(139, 7, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 20180.00, 1, '2026-05-30 08:08:09'),
(140, 7, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 20940.00, 1, '2026-05-30 08:08:41'),
(141, 7, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 21720.00, 1, '2026-05-30 08:09:00'),
(142, 7, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 22500.00, 1, '2026-05-30 08:09:26'),
(143, 7, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 23280.00, 1, '2026-05-30 08:09:51'),
(144, 7, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 24050.00, 1, '2026-05-30 08:10:20'),
(145, 7, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 20140.00, 1, '2026-05-30 08:10:38'),
(146, 7, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 20170.00, 1, '2026-05-30 08:14:13'),
(147, 7, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 22130.00, 1, '2026-05-30 08:14:47'),
(148, 7, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 22480.00, 1, '2026-05-30 08:15:07'),
(149, 7, 'Ceramic Tile Shutter with Black Profile', 24850.00, 1, '2026-05-30 08:16:04'),
(150, 7, 'Color Matt PU (Without Handle)', 19820.00, 1, '2026-05-30 08:16:22'),
(151, 7, 'Color Matt PU PANELLED (Without Handle)', 20380.00, 1, '2026-05-30 08:16:41'),
(152, 7, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 21320.00, 1, '2026-05-30 08:17:06'),
(153, 7, 'Color Glossy PU (Without Handle)', 20190.00, 1, '2026-05-30 08:17:39'),
(154, 7, 'Color Glossy PU PANELLED (Without Handle)', 20740.00, 1, '2026-05-30 08:17:56'),
(155, 7, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 21680.00, 1, '2026-05-30 08:18:15'),
(156, 7, 'Metallic PU - 1 Color (Without Handle)', 22950.00, 1, '2026-05-30 08:19:22'),
(157, 7, 'Metallic PU - Ombre (Without Handle)', 24230.00, 1, '2026-05-30 08:19:37'),
(158, 7, 'Metallic PU - Textured (Without Handle)', 25160.00, 1, '2026-05-30 08:19:53'),
(159, 7, 'Veneer @150 per sqft Shutter with matching Edgeband', 23090.00, 1, '2026-05-30 08:20:09'),
(160, 7, 'Veneer @400 per sqft Shutter with matching Edgeband', 25890.00, 1, '2026-05-30 08:20:24'),
(161, 7, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 28210.00, 1, '2026-05-30 08:20:52'),
(162, 7, '5mm Thick Flutted Wood Shutters with matching Edgeband', 30570.00, 1, '2026-05-30 08:21:08'),
(163, 8, 'Laminate @ INR 1200 / Sheet with matching edgeband', 24510.00, 1, '2026-05-30 08:21:45'),
(164, 8, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 25170.00, 1, '2026-05-30 08:21:58'),
(165, 8, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 25980.00, 1, '2026-05-30 08:22:11'),
(166, 8, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 26810.00, 1, '2026-05-30 08:22:30'),
(167, 8, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 28430.00, 1, '2026-05-30 08:22:50'),
(168, 8, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 30060.00, 1, '2026-05-30 08:23:11'),
(169, 8, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 31690.00, 1, '2026-05-30 08:23:31'),
(170, 8, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 33320.00, 1, '2026-05-30 08:23:53'),
(171, 8, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 34950.00, 1, '2026-05-30 08:24:21'),
(172, 8, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 26300.00, 1, '2026-05-30 08:24:36'),
(173, 8, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 26360.00, 1, '2026-05-30 08:24:50'),
(174, 8, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 30460.00, 1, '2026-05-30 08:25:06'),
(175, 8, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 31200.00, 1, '2026-05-30 08:25:20'),
(176, 8, 'Ceramic Tile Shutter with Black Profile', 34050.00, 1, '2026-05-30 08:26:03'),
(177, 8, 'Color Matt PU (Without Handle)', 27620.00, 1, '2026-05-30 08:26:33'),
(178, 8, 'Color Matt PU PANELLED (Without Handle)', 28780.00, 1, '2026-05-30 08:26:54'),
(179, 8, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 30020.00, 1, '2026-05-30 08:27:43'),
(180, 8, 'Color Glossy PU (Without Handle)', 28390.00, 1, '2026-05-30 08:28:10'),
(181, 8, 'Color Glossy PU PANELLED (Without Handle)', 29540.00, 1, '2026-05-30 08:28:31'),
(182, 8, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 30790.00, 1, '2026-05-30 08:28:58'),
(183, 8, 'Metallic PU - 1 Color (Without Handle)', 32980.00, 1, '2026-05-30 08:29:19'),
(184, 8, 'Metallic PU - Ombre (Without Handle)', 35680.00, 1, '2026-05-30 08:29:40'),
(185, 8, 'Metallic PU - Textured (Without Handle)', 37610.00, 1, '2026-05-30 08:30:08'),
(186, 8, 'Veneer @150 per sqft Shutter with matching Edgeband', 33580.00, 1, '2026-05-30 08:30:37'),
(187, 8, 'Veneer @400 per sqft Shutter with matching Edgeband', 39450.00, 1, '2026-05-30 08:30:54'),
(188, 8, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 44340.00, 1, '2026-05-30 08:31:35'),
(189, 8, '5mm Thick Flutted Wood Shutters with matching Edgeband', 49290.00, 1, '2026-05-30 08:32:15'),
(190, 9, 'Laminate @ INR 1200 / Sheet with matching edgeband', 26160.00, 1, '2026-05-30 08:33:14'),
(191, 9, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 26820.00, 1, '2026-05-30 08:33:32'),
(192, 9, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 27630.00, 1, '2026-05-30 08:34:13'),
(193, 9, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 28460.00, 1, '2026-05-30 08:34:58'),
(194, 9, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 30080.00, 1, '2026-05-30 08:35:12'),
(195, 9, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 31710.00, 1, '2026-05-30 08:35:57'),
(196, 9, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 33340.00, 1, '2026-05-30 08:36:17'),
(197, 9, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 34970.00, 1, '2026-05-30 08:36:39'),
(198, 9, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 36600.00, 1, '2026-05-30 08:36:59'),
(199, 9, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 27950.00, 1, '2026-05-30 08:37:20'),
(200, 9, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 28010.00, 1, '2026-05-30 08:37:36'),
(201, 9, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 32110.00, 1, '2026-05-30 08:37:52'),
(202, 9, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 32850.00, 1, '2026-05-30 08:38:08'),
(203, 9, 'Ceramic Tile Shutter with Black Profile', 35700.00, 1, '2026-05-30 08:38:51'),
(204, 9, 'Color Matt PU (Without Handle)', 29270.00, 1, '2026-05-30 08:40:16'),
(205, 9, 'Color Matt PU PANELLED (Without Handle)', 30430.00, 1, '2026-05-30 08:41:11'),
(206, 9, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 31670.00, 1, '2026-05-30 08:41:40'),
(207, 9, 'Color Glossy PU (Without Handle)', 30040.00, 1, '2026-05-30 08:42:20'),
(208, 9, 'Color Glossy PU PANELLED (Without Handle)', 31190.00, 1, '2026-05-30 08:43:11'),
(209, 9, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 32440.00, 1, '2026-05-30 08:43:32'),
(210, 9, 'Metallic PU - 1 Color (Without Handle)', 34630.00, 1, '2026-05-30 08:43:54'),
(211, 9, 'Metallic PU - Ombre (Without Handle)', 37330.00, 1, '2026-05-30 08:44:06'),
(212, 9, 'Metallic PU - Textured (Without Handle)', 39260.00, 1, '2026-05-30 08:44:41'),
(213, 9, 'Veneer @150 per sqft Shutter with matching Edgeband', 35230.00, 1, '2026-05-30 08:44:56'),
(214, 9, 'Veneer @400 per sqft Shutter with matching Edgeband', 41100.00, 1, '2026-05-30 08:45:15'),
(215, 9, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 45990.00, 1, '2026-05-30 08:45:29'),
(216, 9, '5mm Thick Flutted Wood Shutters with matching Edgeband', 50940.00, 1, '2026-05-30 08:45:44'),
(217, 10, 'Laminate @ INR 1200 / Sheet with matching edgeband', 19870.00, 1, '2026-05-30 08:46:35'),
(218, 10, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 20150.00, 1, '2026-05-30 08:46:48'),
(219, 10, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 20500.00, 1, '2026-05-30 08:47:02'),
(220, 10, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 20850.00, 1, '2026-05-30 08:47:16'),
(221, 10, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 21550.00, 1, '2026-05-30 08:47:36'),
(222, 10, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 22250.00, 1, '2026-05-30 08:47:55'),
(223, 10, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 22950.00, 1, '2026-05-30 08:48:19'),
(224, 10, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 23650.00, 1, '2026-05-30 08:48:41'),
(225, 10, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 24350.00, 1, '2026-05-30 08:49:59'),
(226, 10, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 20950.00, 1, '2026-05-30 08:52:00'),
(227, 10, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 20960.00, 1, '2026-05-30 08:52:13'),
(229, 10, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 22720.00, 1, '2026-05-30 08:52:44'),
(230, 10, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 23040.00, 1, '2026-05-30 08:52:57'),
(231, 10, 'Ceramic Tile Shutter with Black Profile', 25620.00, 1, '2026-05-30 08:53:11'),
(232, 10, 'Color Matt PU (Without Handle)', 20180.00, 1, '2026-05-30 08:53:35'),
(233, 10, 'Color Matt PU PANELLED (Without Handle)', 20660.00, 1, '2026-05-30 08:53:51'),
(234, 10, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 21730.00, 1, '2026-05-30 08:54:12'),
(235, 10, 'Color Glossy PU (Without Handle)', 20500.00, 1, '2026-05-30 08:54:51'),
(236, 10, 'Color Glossy PU PANELLED (Without Handle)', 20990.00, 1, '2026-05-30 08:55:09'),
(237, 10, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 22060.00, 1, '2026-05-30 08:55:22'),
(238, 10, 'Metallic PU - 1 Color (Without Handle)', 23270.00, 1, '2026-05-30 08:55:38'),
(239, 10, 'Metallic PU - Ombre (Without Handle)', 24430.00, 1, '2026-05-30 08:55:51'),
(240, 10, 'Metallic PU - Textured (Without Handle)', 25250.00, 1, '2026-05-30 08:56:11'),
(241, 10, 'Veneer @150 per sqft Shutter with matching Edgeband', 23330.00, 1, '2026-05-30 08:56:25'),
(242, 10, 'Veneer @400 per sqft Shutter with matching Edgeband', 25840.00, 1, '2026-05-30 08:56:37'),
(243, 10, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 27940.00, 1, '2026-05-30 08:56:54'),
(244, 10, '5mm Thick Flutted Wood Shutters with matching Edgeband', 30060.00, 1, '2026-05-30 08:57:05'),
(245, 11, 'Laminate @ INR 1200 / Sheet with matching edgeband', 20710.00, 1, '2026-05-30 08:57:32'),
(246, 11, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 21090.00, 1, '2026-05-30 08:57:51'),
(247, 11, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 21550.00, 1, '2026-05-30 08:58:38'),
(248, 11, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 22010.00, 1, '2026-05-30 08:59:09'),
(249, 11, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 22950.00, 1, '2026-05-30 08:59:26'),
(250, 11, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 23880.00, 1, '2026-05-30 08:59:41'),
(251, 11, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 24810.00, 1, '2026-05-30 09:00:01'),
(252, 11, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 25740.00, 1, '2026-05-30 09:00:17'),
(253, 11, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 26670.00, 1, '2026-05-30 09:00:34'),
(254, 11, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 21970.00, 1, '2026-05-30 09:01:09'),
(255, 11, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 22000.00, 1, '2026-05-30 09:01:20'),
(256, 11, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 24340.00, 1, '2026-05-30 09:01:33'),
(257, 11, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 24760.00, 1, '2026-05-30 09:01:52'),
(258, 11, 'Ceramic Tile Shutter with Black Profile', 27480.00, 1, '2026-05-30 09:02:06'),
(259, 11, 'Color Matt PU (Without Handle)', 21650.00, 1, '2026-05-30 09:02:19'),
(260, 11, 'Color Matt PU PANELLED (Without Handle)', 22300.00, 1, '2026-05-30 09:02:35'),
(261, 11, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 23440.00, 1, '2026-05-30 09:02:52'),
(262, 11, 'Color Glossy PU (Without Handle)', 22100.00, 1, '2026-05-30 09:03:12'),
(263, 11, 'Color Glossy PU PANELLED (Without Handle)', 22740.00, 1, '2026-05-30 09:03:46'),
(264, 11, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 23880.00, 1, '2026-05-30 09:04:03'),
(265, 11, 'Metallic PU - 1 Color (Without Handle)', 25340.00, 1, '2026-05-30 09:04:23'),
(266, 11, 'Metallic PU - Ombre (Without Handle)', 26880.00, 1, '2026-05-30 09:04:38'),
(267, 11, 'Metallic PU - Textured (Without Handle)', 27980.00, 1, '2026-05-30 09:04:50'),
(268, 11, 'Veneer @150 per sqft Shutter with matching Edgeband', 25530.00, 1, '2026-05-30 09:05:09'),
(269, 11, 'Veneer @400 per sqft Shutter with matching Edgeband', 28880.00, 1, '2026-05-30 09:05:26'),
(270, 11, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 31670.00, 1, '2026-05-30 09:05:57'),
(271, 11, '5mm Thick Flutted Wood Shutters with matching Edgeband', 34500.00, 1, '2026-05-30 09:06:24'),
(272, 12, 'Laminate @ INR 1200 / Sheet with matching edgeband', 26330.00, 1, '2026-05-30 09:13:29'),
(273, 12, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 27520.00, 1, '2026-05-30 09:14:01'),
(274, 12, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 28490.00, 1, '2026-05-30 09:14:55'),
(275, 12, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 29470.00, 1, '2026-05-30 09:15:10'),
(276, 12, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 31430.00, 1, '2026-05-30 09:15:29'),
(277, 12, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 33380.00, 1, '2026-05-30 09:15:48'),
(278, 12, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 35340.00, 1, '2026-05-30 09:16:06'),
(279, 12, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 37300.00, 1, '2026-05-30 09:16:25'),
(280, 12, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 39250.00, 1, '2026-05-30 09:16:42'),
(281, 12, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 28830.00, 1, '2026-05-30 09:17:05'),
(282, 12, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 28900.00, 1, '2026-05-30 09:17:20'),
(283, 12, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 33820.00, 1, '2026-05-30 09:17:49'),
(284, 12, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 34710.00, 1, '2026-05-30 09:18:08'),
(285, 12, 'Ceramic Tile Shutter with Black Profile', 38000.00, 1, '2026-05-30 09:19:03'),
(286, 12, 'Color Matt PU (Without Handle)', 30490.00, 1, '2026-05-30 09:19:41'),
(287, 12, 'Color Matt PU PANELLED (Without Handle)', 31860.00, 1, '2026-05-30 09:20:02'),
(288, 12, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 33310.00, 1, '2026-05-30 09:20:15'),
(289, 12, 'Color Glossy PU (Without Handle)', 31420.00, 1, '2026-05-30 09:20:36'),
(290, 12, 'Color Glossy PU PANELLED (Without Handle)', 32790.00, 1, '2026-05-30 09:20:57'),
(291, 12, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 34230.00, 1, '2026-05-30 09:21:14'),
(292, 12, 'Metallic PU - 1 Color (Without Handle)', 36790.00, 1, '2026-05-30 09:21:39'),
(293, 12, 'Metallic PU - Ombre (Without Handle)', 40030.00, 1, '2026-05-30 09:21:53'),
(294, 12, 'Metallic PU - Textured (Without Handle)', 42340.00, 1, '2026-05-30 09:22:07'),
(295, 12, 'Veneer @150 per sqft Shutter with matching Edgeband', 37540.00, 1, '2026-05-30 09:22:19'),
(296, 12, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 50650.00, 1, '2026-05-30 09:22:39'),
(298, 12, 'Veneer @400 per sqft Shutter with matching Edgeband', 44580.00, 1, '2026-05-30 09:23:29'),
(299, 12, '5mm Thick Flutted Wood Shutters with matching Edgeband', 56400.00, 1, '2026-05-30 09:23:55'),
(300, 13, 'Laminate @ INR 1200 / Sheet with matching edgeband', 28380.00, 1, '2026-05-30 09:24:19'),
(301, 13, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 29170.00, 1, '2026-05-30 09:24:40'),
(302, 13, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 30140.00, 1, '2026-05-30 09:25:01'),
(303, 13, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 31120.00, 1, '2026-05-30 09:25:21'),
(304, 13, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 33080.00, 1, '2026-05-30 09:25:35'),
(305, 13, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 35030.00, 1, '2026-05-30 09:26:09'),
(306, 13, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 36990.00, 1, '2026-05-30 09:26:27'),
(307, 13, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 38950.00, 1, '2026-05-30 09:26:46'),
(308, 13, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 40900.00, 1, '2026-05-30 09:27:02'),
(309, 13, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 30480.00, 1, '2026-05-30 09:27:24'),
(310, 13, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 31450.00, 1, '2026-05-30 09:27:50'),
(311, 13, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 35470.00, 1, '2026-05-30 09:28:06'),
(312, 13, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 36360.00, 1, '2026-05-30 09:28:32'),
(313, 13, 'Ceramic Tile Shutter with Black Profile', 39650.00, 1, '2026-05-30 09:29:37'),
(314, 13, 'Color Matt PU (Without Handle)', 32140.00, 1, '2026-05-30 09:29:56'),
(315, 13, 'Color Glossy PU PANELLED (Without Handle)', 33510.00, 1, '2026-05-30 09:30:13'),
(316, 13, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 34960.00, 1, '2026-05-30 09:30:31'),
(317, 13, 'Color Glossy PU (Without Handle)', 33070.00, 1, '2026-05-30 09:31:08'),
(318, 13, 'Color Glossy PU PANELLED (Without Handle)', 34440.00, 1, '2026-05-30 09:31:23'),
(319, 13, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 35880.00, 1, '2026-05-30 09:31:45'),
(320, 13, 'Metallic PU - 1 Color (Without Handle)', 38440.00, 1, '2026-05-30 09:32:00'),
(321, 13, 'Metallic PU - Ombre (Without Handle)', 41680.00, 1, '2026-05-30 09:32:13'),
(322, 13, 'Metallic PU - Textured (Without Handle)', 43990.00, 1, '2026-05-30 09:32:26'),
(323, 13, 'Veneer @150 per sqft Shutter with matching Edgeband', 39190.00, 1, '2026-05-30 09:32:46'),
(324, 13, 'Veneer @400 per sqft Shutter with matching Edgeband', 46230.00, 1, '2026-05-30 09:33:01'),
(325, 13, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 52300.00, 1, '2026-05-30 09:33:15'),
(326, 13, '5mm Thick Flutted Wood Shutters with matching Edgeband', 58050.00, 1, '2026-05-30 09:33:27'),
(327, 14, 'Laminate @ INR 1200 / Sheet with matching edgeband', 22870.00, 1, '2026-05-30 09:40:14'),
(328, 14, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 23240.00, 1, '2026-05-30 09:40:29'),
(329, 14, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 23700.00, 1, '2026-05-30 09:40:42'),
(330, 14, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 24180.00, 1, '2026-05-30 09:40:55'),
(331, 14, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 25100.00, 1, '2026-05-30 09:41:21'),
(332, 14, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 26030.00, 1, '2026-05-30 09:41:42'),
(333, 14, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 26960.00, 1, '2026-05-30 09:41:56'),
(334, 14, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 27900.00, 1, '2026-05-30 09:42:14'),
(335, 14, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 28830.00, 1, '2026-05-30 09:42:33'),
(336, 14, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 24250.00, 1, '2026-05-30 09:42:52'),
(337, 14, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 24290.00, 1, '2026-05-30 09:43:06'),
(338, 14, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 26630.00, 1, '2026-05-30 09:43:23'),
(339, 14, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 27050.00, 1, '2026-05-30 09:43:50'),
(340, 14, 'Ceramic Tile Shutter with Black Profile', 30300.00, 1, '2026-05-30 09:44:24'),
(341, 14, 'Color Matt PU (Without Handle)', 23350.00, 1, '2026-05-30 09:44:42'),
(342, 14, 'Color Matt PU PANELLED (Without Handle)', 24000.00, 1, '2026-05-30 09:44:58'),
(343, 14, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 25440.00, 1, '2026-05-30 09:45:14'),
(344, 14, 'Color Glossy PU (Without Handle)', 23780.00, 1, '2026-05-30 09:45:39'),
(345, 14, 'Color Glossy PU PANELLED (Without Handle)', 24440.00, 1, '2026-05-30 09:45:58'),
(346, 14, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 25880.00, 1, '2026-05-30 09:46:20'),
(347, 14, 'Metallic PU - 1 Color (Without Handle)', 27400.00, 1, '2026-05-30 09:46:41'),
(348, 14, 'Metallic PU - Ombre (Without Handle)', 28940.00, 1, '2026-05-30 09:47:02'),
(349, 14, 'Metallic PU - Textured (Without Handle)', 50050.00, 1, '2026-05-30 09:47:18'),
(350, 14, 'Veneer @150 per sqft Shutter with matching Edgeband', 27500.00, 1, '2026-05-30 09:47:34'),
(351, 14, 'Veneer @400 per sqft Shutter with matching Edgeband', 30850.00, 1, '2026-05-30 09:47:48'),
(352, 14, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 33650.00, 1, '2026-05-30 09:48:22'),
(353, 14, '5mm Thick Flutted Wood Shutters with matching Edgeband', 36470.00, 1, '2026-05-30 09:49:02'),
(354, 15, 'Laminate @ INR 1200 / Sheet with matching edgeband', 23970.00, 1, '2026-05-30 09:49:49'),
(355, 15, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 24470.00, 1, '2026-05-30 09:50:08'),
(356, 15, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 25080.00, 1, '2026-05-30 09:50:22'),
(357, 15, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 25720.00, 1, '2026-05-30 09:50:43'),
(358, 15, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 26950.00, 1, '2026-05-30 09:51:04'),
(359, 15, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 28190.00, 1, '2026-05-30 09:51:55'),
(360, 15, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 29430.00, 1, '2026-05-30 09:52:08'),
(361, 15, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 30680.00, 1, '2026-05-30 09:52:38'),
(362, 15, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 31920.00, 1, '2026-05-30 09:53:15'),
(363, 15, 'Ceramic Tile Shutter with Black Profile', 32760.00, 1, '2026-05-30 09:53:41'),
(364, 15, 'Color Matt PU (Without Handle)', 25300.00, 1, '2026-05-30 09:54:13'),
(365, 15, 'Color Matt PU PANELLED (Without Handle)', 26170.00, 1, '2026-05-30 09:54:55'),
(366, 15, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 27680.00, 1, '2026-05-30 09:55:24'),
(367, 15, 'Color Glossy PU (Without Handle)', 25880.00, 1, '2026-05-30 09:56:18'),
(368, 15, 'Color Glossy PU PANELLED (Without Handle)', 26750.00, 1, '2026-05-30 09:57:03'),
(369, 15, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 28270.00, 1, '2026-05-30 09:57:29'),
(370, 15, 'Metallic PU - 1 Color (Without Handle)', 30120.00, 1, '2026-05-30 09:58:18'),
(371, 15, 'Metallic PU - Ombre (Without Handle)', 32170.00, 1, '2026-05-30 09:58:34'),
(372, 15, 'Metallic PU - Textured (Without Handle)', 33650.00, 1, '2026-05-30 09:59:02'),
(373, 15, 'Veneer @150 per sqft Shutter with matching Edgeband', 30390.00, 1, '2026-05-30 09:59:19'),
(374, 15, 'Veneer @400 per sqft Shutter with matching Edgeband', 34860.00, 1, '2026-05-30 09:59:41'),
(375, 15, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 38590.00, 1, '2026-05-30 10:00:18'),
(376, 15, '5mm Thick Flutted Wood Shutters with matching Edgeband', 42360.00, 1, '2026-05-30 10:00:35'),
(377, 16, 'Laminate @ INR 1200 / Sheet with matching edgeband', 31170.00, 1, '2026-05-30 10:23:43'),
(378, 16, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 32210.00, 1, '2026-05-30 10:23:58'),
(379, 16, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 33510.00, 1, '2026-05-30 10:24:21'),
(380, 16, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 34830.00, 1, '2026-05-30 10:24:59'),
(381, 16, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 37430.00, 1, '2026-05-30 10:25:14'),
(382, 16, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 40030.00, 1, '2026-05-30 10:25:35'),
(383, 16, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 42640.00, 1, '2026-05-30 10:26:06'),
(384, 16, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 45250.00, 1, '2026-05-30 10:26:41'),
(385, 16, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 47860.00, 1, '2026-05-30 10:26:58'),
(386, 16, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 33880.00, 1, '2026-05-30 10:27:20'),
(387, 16, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 33980.00, 1, '2026-05-30 10:27:34'),
(388, 16, 'Glossy Acrylic Laminate with matching Edgeband - 2 MM', 40540.00, 1, '2026-05-30 10:28:06'),
(389, 16, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 41730.00, 1, '2026-05-30 10:28:20'),
(390, 16, 'Ceramic Tile Shutter with Black Profile', 45900.00, 1, '2026-05-30 10:28:36'),
(391, 16, 'Color Matt PU (Without Handle)', 36220.00, 1, '2026-05-30 10:36:02'),
(392, 16, 'Color Matt PU (Without Handle)', 38050.00, 1, '2026-05-30 10:36:24'),
(393, 16, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 39880.00, 1, '2026-05-30 10:36:40'),
(394, 16, 'Color Glossy PU (Without Handle)', 37440.00, 1, '2026-05-30 10:37:12'),
(395, 16, 'Color Glossy PU PANELLED (Without Handle)', 39880.00, 1, '2026-05-30 10:37:31'),
(396, 16, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 41120.00, 1, '2026-05-30 10:37:42'),
(397, 16, 'Metallic PU - 1 Color (Without Handle)', 44410.00, 1, '2026-05-30 10:37:56'),
(398, 16, 'Metallic PU - Ombre (Without Handle)', 48730.00, 1, '2026-05-30 10:38:25'),
(399, 16, 'Metallic PU - Textured (Without Handle)', 51820.00, 1, '2026-05-30 10:38:38'),
(400, 16, 'Veneer @150 per sqft Shutter with matching Edgeband', 45460.00, 1, '2026-05-30 10:38:51'),
(401, 16, 'Veneer @400 per sqft Shutter with matching Edgeband', 54850.00, 1, '2026-05-30 10:39:07'),
(402, 16, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 62680.00, 1, '2026-05-30 10:39:23'),
(403, 16, '5mm Thick Flutted Wood Shutters with matching Edgeband', 70610.00, 1, '2026-05-30 10:39:40'),
(404, 17, 'Laminate @ INR 1200 / Sheet with matching edgeband', 32820.00, 1, '2026-05-30 10:39:58'),
(405, 17, 'Premium Laminate @ INR 2000 / Sheet with Matching Edgeband', 33860.00, 1, '2026-05-30 10:40:09'),
(406, 17, 'Premium Laminate @ INR 3000 / Sheet with Matching Edgeband', 35160.00, 1, '2026-05-30 10:40:31'),
(407, 17, 'Premium Laminate @ INR 4000 / Sheet with Matching Edgeband', 36480.00, 1, '2026-05-30 10:40:49'),
(408, 17, 'Premium Laminate @ INR 6000 / Sheet with Matching Edgeband', 39080.00, 1, '2026-05-30 10:41:00'),
(409, 17, 'Premium Laminate @ INR 8000 / Sheet with Matching Edgeband', 41680.00, 1, '2026-05-30 10:41:12'),
(410, 17, 'Premium Laminate @ INR 10000 / Sheet with Matching Edgeband', 44290.00, 1, '2026-05-30 10:41:24'),
(411, 17, 'Premium Laminate @ INR 12000 / Sheet with Matching Edgeband', 46900.00, 1, '2026-05-30 10:41:39'),
(412, 17, 'Premium Laminate @ INR 14000 / Sheet with Matching Edgeband', 49510.00, 1, '2026-05-30 10:42:04'),
(413, 17, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 35530.00, 1, '2026-05-30 10:42:17'),
(414, 17, 'Matt Acrylic Laminate with matching Edgeband - 1.2 MM', 35630.00, 1, '2026-05-30 10:42:32'),
(415, 17, 'Glossy Acrylic Laminate with matching Edgeband - 1.2 MM', 42190.00, 1, '2026-05-30 10:42:49'),
(416, 17, 'Matt Acrylic Laminate with matching Edgeband - 3 MM', 43380.00, 1, '2026-05-30 10:43:04'),
(417, 17, 'Ceramic Tile Shutter with Black Profile', 47550.00, 1, '2026-05-30 10:43:21'),
(418, 17, 'Color Matt PU (Without Handle)', 37870.00, 1, '2026-05-30 10:43:34'),
(419, 17, 'Color Matt PU PANELLED (Without Handle)', 39700.00, 1, '2026-05-30 10:43:49'),
(420, 17, 'Color Matt PU PANELLED with MOULDINGS (Without Handle)', 41530.00, 1, '2026-05-30 10:44:03'),
(421, 17, 'Color Glossy PU (Without Handle)', 39090.00, 1, '2026-05-30 10:44:19'),
(422, 17, 'Color Glossy PU PANELLED (Without Handle)', 41530.00, 1, '2026-05-30 10:44:34'),
(423, 17, 'Color Glossy PU PANELLED with MOULDINGS (Without Handle)', 42770.00, 1, '2026-05-30 10:44:58'),
(424, 17, 'Metallic PU - 1 Color (Without Handle)', 46060.00, 1, '2026-05-30 10:45:17'),
(425, 17, 'Metallic PU - Ombre (Without Handle)', 50380.00, 1, '2026-05-30 10:45:28'),
(426, 17, 'Metallic PU - Textured (Without Handle)', 53470.00, 1, '2026-05-30 10:45:41'),
(427, 17, 'Veneer @150 per sqft Shutter with matching Edgeband', 47110.00, 1, '2026-05-30 10:46:13'),
(428, 17, 'Veneer @400 per sqft Shutter with matching Edgeband', 56500.00, 1, '2026-05-30 10:46:24'),
(429, 17, 'Flutted Veneer @1000 per sqft Shutter with matching Edgeband', 64330.00, 1, '2026-05-30 10:46:38'),
(430, 17, '5mm Thick Flutted Wood Shutters with matching Edgeband', 72260.00, 1, '2026-05-30 10:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `elevations`
--

CREATE TABLE `elevations` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `elevation_no` int(11) DEFAULT NULL,
  `ceiling_height_mm` decimal(10,2) DEFAULT NULL,
  `ceiling_height_ft` decimal(10,2) DEFAULT NULL,
  `show_note` tinyint(1) DEFAULT 0,
  `elevation_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elevations`
--

INSERT INTO `elevations` (`id`, `quotation_id`, `elevation_no`, `ceiling_height_mm`, `ceiling_height_ft`, `show_note`, `elevation_note`) VALUES
(346, 257, 1, 0.00, 0.00, 0, NULL),
(348, 248, 1, 1234.00, 4.05, 0, NULL),
(358, 249, 1, 2300.00, 7.55, 0, NULL),
(403, 258, 1, 0.00, 0.00, 0, NULL),
(404, 258, 2, 0.00, 0.00, 0, NULL),
(419, 259, 1, 2300.00, 7.55, 0, NULL),
(420, 259, 2, 2300.00, 7.55, 0, NULL),
(442, 274, 1, 0.00, 0.00, 0, ''),
(449, 276, 1, 0.00, 0.00, 0, ''),
(450, 275, 1, 0.00, 0.00, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `elevation_line_images`
--

CREATE TABLE `elevation_line_images` (
  `id` int(11) NOT NULL,
  `elevation_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elevation_line_images`
--

INSERT INTO `elevation_line_images` (`id`, `elevation_id`, `image_path`, `image_title`, `created_at`) VALUES
(47, 348, 'line_1782451107_2435.jpg', NULL, '2026-06-26 06:56:12'),
(48, 348, 'line_1782451107_4919.jpg', NULL, '2026-06-26 06:56:12'),
(53, 358, 'line_1782457714_5983.jpg', NULL, '2026-06-26 07:08:34'),
(115, 403, 'line_1782463142_4465.jpg', NULL, '2026-06-26 09:14:34'),
(116, 404, 'line_1782463143_1389.jpg', NULL, '2026-06-26 09:14:34'),
(136, 419, 'line_1782474728_1378.jpg', NULL, '2026-06-27 05:12:31'),
(137, 419, 'line_1782474728_7413.jpg', NULL, '2026-06-27 05:12:31'),
(138, 420, 'line_1782534056_1841.jpg', NULL, '2026-06-27 05:12:31');

-- --------------------------------------------------------

--
-- Table structure for table `entities`
--

CREATE TABLE `entities` (
  `id` int(11) NOT NULL,
  `entity_name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `gst_number` varchar(50) DEFAULT NULL,
  `pan_number` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entities`
--

INSERT INTO `entities` (`id`, `entity_name`, `address`, `gst_number`, `pan_number`, `email`, `phone`, `status`, `created_at`) VALUES
(1, 'F&R Kitchens And Wardrobe PVT. LTD.', 'Unit L 5 and L 6, Shree Raj Laxmi Hitech Textile Park, Kalyan Bhiwandi Junction, Kalyan, THANE \r\nPlace of Supply: MAHARASHTRA 421302 MAHARASHTRA', '27AAFCF8498K1ZT', 'AAFCF8498K', 'info@fr.com', '9999999999', 1, '2026-06-11 08:05:21'),
(2, 'craftreD Designs Pvt. Ltd ', 'L-5/L-6,Shree Raj Laxmi Hi-Tech Textile Park, Village - Sonale, Taluka- Bhiwandi, Thane - 421302', '27AADCC3846L1ZE', 'PAN456', 'shilpa@craftred.in ', '02522-280036 / 86', 1, '2026-06-11 08:05:21');

-- --------------------------------------------------------

--
-- Table structure for table `financial_reports`
--

CREATE TABLE `financial_reports` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `delivery_date` varchar(100) DEFAULT NULL,
  `fr_value` bigint(20) DEFAULT 0,
  `delivery` bigint(20) DEFAULT 0,
  `fr_installation` bigint(20) DEFAULT 0,
  `total_pre_gst` bigint(20) DEFAULT 0,
  `gst_amount` bigint(20) DEFAULT 0,
  `total_project` bigint(20) DEFAULT 0,
  `fr_payment` bigint(20) DEFAULT 0,
  `balance_payment` bigint(20) DEFAULT 0,
  `gross_margin_pre_gst` bigint(20) DEFAULT 0,
  `cr_amount` bigint(20) DEFAULT 0,
  `cr_transport` bigint(20) DEFAULT 0,
  `cr_installation` bigint(20) DEFAULT 0,
  `cr_total_pre_gst` bigint(20) DEFAULT 0,
  `cr_gst` bigint(20) DEFAULT 0,
  `cr_total_project` bigint(20) DEFAULT 0,
  `cr_payment_done` bigint(20) DEFAULT 0,
  `cr_balance` bigint(20) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `financial_reports`
--

INSERT INTO `financial_reports` (`id`, `customer_name`, `delivery_date`, `fr_value`, `delivery`, `fr_installation`, `total_pre_gst`, `gst_amount`, `total_project`, `fr_payment`, `balance_payment`, `gross_margin_pre_gst`, `cr_amount`, `cr_transport`, `cr_installation`, `cr_total_pre_gst`, `cr_gst`, `cr_total_project`, `cr_payment_done`, `cr_balance`, `created_at`) VALUES
(2, 'Gauravjit Kitchen', 'Ready for Delivery', 878500, 25000, 0, 903500, 162630, 1066130, 1036630, 29500, 50, 434985, 17500, 0, 452485, 81447, 533932, 452485, 81447, '2026-06-09 10:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(255) NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission_name`, `module`, `created_at`) VALUES
(1, 'dashboard_view', 'Dashboard', '2026-06-03 06:08:04'),
(2, 'users_view', 'Users', '2026-06-03 06:08:04'),
(3, 'users_create', 'Users', '2026-06-03 06:08:04'),
(4, 'users_edit', 'Users', '2026-06-03 06:08:04'),
(5, 'users_delete', 'Users', '2026-06-03 06:08:04'),
(6, 'roles_view', 'Roles', '2026-06-03 06:08:04'),
(7, 'roles_create', 'Roles', '2026-06-03 06:08:04'),
(8, 'roles_edit', 'Roles', '2026-06-03 06:08:04'),
(9, 'roles_delete', 'Roles', '2026-06-03 06:08:04'),
(10, 'permissions_manage', 'Permissions', '2026-06-03 06:08:04'),
(11, 'company_view', 'Company', '2026-06-03 06:08:04'),
(12, 'company_edit', 'Company', '2026-06-03 06:08:04'),
(13, 'quotation_view', 'Quotation', '2026-06-03 06:08:04'),
(14, 'quotation_create', 'Quotation', '2026-06-03 06:08:04'),
(15, 'quotation_edit', 'Quotation', '2026-06-03 06:08:04'),
(16, 'quotation_delete', 'Quotation', '2026-06-03 06:08:04'),
(17, 'quotation_print', 'Quotation', '2026-06-03 06:08:04'),
(18, 'drawers_view', 'Drawers', '2026-06-03 06:08:04'),
(19, 'drawers_create', 'Drawers', '2026-06-03 06:08:04'),
(20, 'drawers_edit', 'Drawers', '2026-06-03 06:08:04'),
(21, 'drawers_delete', 'Drawers', '2026-06-03 06:08:04'),
(22, 'shelves_view', 'Shelves', '2026-06-03 06:08:04'),
(23, 'shelves_create', 'Shelves', '2026-06-03 06:08:04'),
(24, 'shelves_edit', 'Shelves', '2026-06-03 06:08:04'),
(25, 'shelves_delete', 'Shelves', '2026-06-03 06:08:04'),
(26, 'materials_view', 'Materials', '2026-06-03 06:08:04'),
(27, 'materials_create', 'Materials', '2026-06-03 06:08:04'),
(28, 'materials_edit', 'Materials', '2026-06-03 06:08:04'),
(29, 'materials_delete', 'Materials', '2026-06-03 06:08:04'),
(30, 'reports_view', 'Reports', '2026-06-03 06:08:04'),
(31, 'reports_export', 'Reports', '2026-06-03 06:08:04'),
(32, 'settings_view', 'Settings', '2026-06-03 06:08:04'),
(33, 'settings_edit', 'Settings', '2026-06-03 06:08:04'),
(34, 'accessories_view', 'Accessories', '2026-06-04 05:01:18'),
(35, 'accessories_edit', 'Accessories', '2026-06-04 08:49:47'),
(36, 'accessories_create', 'Accessories', '2026-06-04 08:50:11'),
(37, 'frdashboard_view', 'Dashboard', '2026-06-05 06:30:50'),
(38, 'crdashboard_view', 'Dashboard', '2026-06-05 06:31:14'),
(39, 'accessories_delete', 'Accessories', '2026-06-05 08:17:08'),
(40, 'carcass_view', 'Carcass ', '2026-06-05 10:03:15'),
(41, 'carcass_edit', 'Carcass ', '2026-06-05 10:03:24'),
(42, 'carcass_delete', 'Carcass ', '2026-06-05 10:03:31'),
(43, 'carcass_create', 'Carcass ', '2026-06-05 10:03:57'),
(44, 'shutter_create', 'Shutter', '2026-06-05 10:04:15'),
(45, 'shutter_view', 'Shutter', '2026-06-05 10:04:23'),
(46, 'shutter_delete', 'Shutter', '2026-06-05 10:04:33'),
(47, 'shutter_edit', 'Shutter', '2026-06-05 10:04:44'),
(48, 'quotation_view_all', 'Quotation', '2026-06-08 10:20:23'),
(49, 'pr_view', 'Payment Reconciliation F&R - CR', '2026-06-09 10:35:47'),
(50, 'pr_create', 'Payment Reconciliation F&R - CR', '2026-06-09 10:35:53'),
(51, 'pr_edit', 'Payment Reconciliation F&R - CR', '2026-06-09 10:35:58'),
(52, 'pr_delete', 'Payment Reconciliation F&R - CR', '2026-06-09 10:36:05');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` int(11) NOT NULL,
  `project_type` varchar(255) DEFAULT NULL,
  `total_sqft` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `client_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `proforma_no` varchar(50) NOT NULL,
  `packing_charge` decimal(10,2) DEFAULT 0.00,
  `installation_charge` decimal(10,2) DEFAULT 0.00,
  `special_discount` decimal(10,2) DEFAULT 0.00,
  `final_customer_price` decimal(10,2) DEFAULT 0.00,
  `entity_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `project_type`, `total_sqft`, `grand_total`, `created_at`, `client_id`, `created_by`, `proforma_no`, `packing_charge`, `installation_charge`, `special_discount`, `final_customer_price`, `entity_id`, `updated_at`) VALUES
(248, 'Kitchen', 9.68, 356270.00, '2026-06-24 06:48:20', 179, 9, 'PI/2026-27/0032', 65000.00, 3872.00, 50.00, 178135.00, 1, NULL),
(249, 'Kitchen', 82.73, 503831.00, '2026-06-24 11:48:17', 180, 1, 'PI/2026-27/0033', 52000.00, 41924.00, 10.00, 453448.00, 1, NULL),
(257, 'Kitchen', 3.88, 60202.00, '2026-06-26 05:59:01', 188, 1, 'PI/2026-27/0035', 3000.00, 1552.00, 0.00, 60202.00, 1, NULL),
(258, 'Kitchen', 0.00, 0.00, '2026-06-26 07:33:43', 189, 1, 'PI/2026-27/0036', 0.00, 0.00, 0.00, 0.00, 0, NULL),
(259, 'Kitchen', 109.79, 1438932.00, '2026-06-26 11:52:08', 190, 1, 'PI/2026-27/0037', 65000.00, 43916.00, 7.00, 1338207.00, 1, NULL),
(274, 'Other', 0.00, 12225.00, '2026-06-30 04:58:34', 205, 1, 'PI/2026-27/0052', 0.00, 0.00, 0.00, 12225.00, 1, NULL),
(275, 'Kitchen', 0.00, 51256.02, '2026-06-30 08:50:42', 206, 1, 'PI/2026-27/0053', 4000.00, 0.00, 0.00, 51256.00, 0, '2026-06-30 09:57:51'),
(276, 'Kitchen', 0.00, 1111.00, '2026-06-30 09:43:04', 207, 1, 'PI/2026-27/0054', 0.00, 0.00, 0.00, 1111.00, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quotation_accessories`
--

CREATE TABLE `quotation_accessories` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `other_material` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT 1,
  `price` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotation_accessories`
--

INSERT INTO `quotation_accessories` (`id`, `quotation_id`, `accessory_id`, `category_id`, `other_material`, `qty`, `price`, `total`, `created_at`) VALUES
(51, 155, 18, NULL, NULL, 1, 123391.00, 123391.00, '2026-06-15 10:04:13'),
(52, 155, 6, NULL, NULL, 4, 16275.00, 65100.00, '2026-06-15 10:04:13'),
(53, 155, 24, NULL, NULL, 1, 71114.00, 71114.00, '2026-06-15 10:04:13'),
(54, 155, 19, NULL, NULL, 1, 122515.00, 122515.00, '2026-06-15 10:04:13'),
(55, 155, 18, NULL, NULL, 1, 123391.00, 123391.00, '2026-06-15 10:04:13'),
(56, 155, 6, NULL, NULL, 4, 16275.00, 65100.00, '2026-06-15 10:04:13'),
(57, 169, 8, NULL, NULL, 1, 19425.00, 19425.00, '2026-06-15 11:11:51'),
(58, 179, 7, NULL, NULL, 2, 11025.00, 22050.00, '2026-06-15 11:52:40'),
(59, 180, 7, NULL, NULL, 2, 11025.00, 22050.00, '2026-06-15 11:52:41'),
(60, 181, 7, NULL, NULL, 2, 11025.00, 22050.00, '2026-06-15 11:52:58'),
(61, 182, 7, NULL, NULL, 2, 11025.00, 22050.00, '2026-06-15 11:54:24'),
(62, 183, 7, NULL, NULL, 2, 11025.00, 22050.00, '2026-06-15 11:54:25'),
(63, 194, 7, NULL, NULL, 2, 11025.00, 22050.00, '2026-06-16 04:30:28'),
(64, 194, 24, NULL, NULL, 3, 71114.00, 213342.00, '2026-06-16 04:30:28'),
(65, 194, 29, NULL, NULL, 3, 105552.00, 316656.00, '2026-06-16 04:30:28'),
(66, 195, 7, NULL, NULL, 2, 11025.00, 22050.00, '2026-06-16 04:30:31'),
(67, 195, 24, NULL, NULL, 3, 71114.00, 213342.00, '2026-06-16 04:30:31'),
(68, 195, 29, NULL, NULL, 3, 105552.00, 316656.00, '2026-06-16 04:30:31'),
(69, 196, 7, NULL, NULL, 2, 11025.00, 22050.00, '2026-06-16 04:30:31'),
(70, 196, 24, NULL, NULL, 3, 71114.00, 213342.00, '2026-06-16 04:30:31'),
(71, 196, 29, NULL, NULL, 3, 105552.00, 316656.00, '2026-06-16 04:30:31'),
(182, 248, 7, NULL, NULL, 1, 11025.00, 11025.00, '2026-06-26 06:56:12'),
(183, 248, 8, NULL, NULL, 1, 19425.00, 19425.00, '2026-06-26 06:56:12'),
(246, 259, 24, NULL, NULL, 1, 71114.00, 71114.00, '2026-06-27 05:12:31'),
(247, 259, 19, NULL, NULL, 1, 122515.00, 122515.00, '2026-06-27 05:12:31'),
(248, 259, 18, NULL, NULL, 3, 123391.00, 370173.00, '2026-06-27 05:12:31'),
(251, 274, 7, NULL, NULL, 1, 11025.00, 11025.00, '2026-06-30 08:26:37'),
(252, 274, 0, NULL, NULL, 1, 1200.00, 1200.00, '2026-06-30 08:26:37'),
(253, 276, 0, 0, '', 1, 0.00, 0.00, '2026-06-30 09:43:04'),
(254, 276, 0, 0, 'AAA', 1, 1111.00, 1111.00, '2026-06-30 09:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_panels`
--

CREATE TABLE `quotation_panels` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `width_mm` decimal(10,2) DEFAULT NULL,
  `height_mm` decimal(10,2) DEFAULT NULL,
  `sqft` decimal(10,2) DEFAULT NULL,
  `shutter_category_id` int(11) DEFAULT NULL,
  `shutter_material_id` int(11) DEFAULT NULL,
  `panel_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotation_panels`
--

INSERT INTO `quotation_panels` (`id`, `quotation_id`, `width_mm`, `height_mm`, `sqft`, `shutter_category_id`, `shutter_material_id`, `panel_price`, `created_at`) VALUES
(4, 275, 222.00, 2222.00, 5.31, 0, 15, 23628.01, '2026-06-30 09:57:51'),
(5, 275, 222.00, 2222.00, 5.31, 0, 15, 23628.01, '2026-06-30 09:57:51');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_sequences`
--

CREATE TABLE `quotation_sequences` (
  `id` int(11) NOT NULL,
  `financial_year` varchar(20) DEFAULT NULL,
  `last_number` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotation_sequences`
--

INSERT INTO `quotation_sequences` (`id`, `financial_year`, `last_number`) VALUES
(1, '2026-27', 55);

-- --------------------------------------------------------

--
-- Table structure for table `quotation_standard_accessories`
--

CREATE TABLE `quotation_standard_accessories` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `standard_accessory_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`) VALUES
(1, 'Super Admin', '2026-05-29 08:11:25'),
(2, 'Admin', '2026-05-29 08:11:25'),
(3, 'Sales Executive', '2026-05-29 08:11:25'),
(4, 'Production Manager', '2026-05-29 08:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`) VALUES
(64, 4, 1, '2026-06-03 06:24:53'),
(274, 3, 13, '2026-06-08 04:45:47'),
(275, 3, 14, '2026-06-08 04:45:47'),
(276, 3, 15, '2026-06-08 04:45:47'),
(277, 3, 16, '2026-06-08 04:45:47'),
(278, 3, 17, '2026-06-08 04:45:47'),
(375, 1, 34, '2026-06-09 10:36:21'),
(376, 1, 35, '2026-06-09 10:36:21'),
(377, 1, 36, '2026-06-09 10:36:21'),
(378, 1, 39, '2026-06-09 10:36:21'),
(379, 1, 40, '2026-06-09 10:36:21'),
(380, 1, 41, '2026-06-09 10:36:21'),
(381, 1, 42, '2026-06-09 10:36:21'),
(382, 1, 43, '2026-06-09 10:36:21'),
(383, 1, 11, '2026-06-09 10:36:21'),
(384, 1, 12, '2026-06-09 10:36:21'),
(385, 1, 1, '2026-06-09 10:36:21'),
(386, 1, 37, '2026-06-09 10:36:21'),
(387, 1, 38, '2026-06-09 10:36:21'),
(388, 1, 18, '2026-06-09 10:36:21'),
(389, 1, 19, '2026-06-09 10:36:21'),
(390, 1, 20, '2026-06-09 10:36:21'),
(391, 1, 21, '2026-06-09 10:36:21'),
(392, 1, 26, '2026-06-09 10:36:21'),
(393, 1, 27, '2026-06-09 10:36:21'),
(394, 1, 28, '2026-06-09 10:36:21'),
(395, 1, 29, '2026-06-09 10:36:21'),
(396, 1, 49, '2026-06-09 10:36:21'),
(397, 1, 50, '2026-06-09 10:36:21'),
(398, 1, 51, '2026-06-09 10:36:21'),
(399, 1, 52, '2026-06-09 10:36:21'),
(400, 1, 10, '2026-06-09 10:36:21'),
(401, 1, 13, '2026-06-09 10:36:21'),
(402, 1, 14, '2026-06-09 10:36:21'),
(403, 1, 15, '2026-06-09 10:36:21'),
(404, 1, 16, '2026-06-09 10:36:21'),
(405, 1, 17, '2026-06-09 10:36:21'),
(406, 1, 48, '2026-06-09 10:36:21'),
(407, 1, 30, '2026-06-09 10:36:21'),
(408, 1, 31, '2026-06-09 10:36:21'),
(409, 1, 6, '2026-06-09 10:36:21'),
(410, 1, 7, '2026-06-09 10:36:21'),
(411, 1, 8, '2026-06-09 10:36:21'),
(412, 1, 9, '2026-06-09 10:36:21'),
(413, 1, 32, '2026-06-09 10:36:21'),
(414, 1, 33, '2026-06-09 10:36:21'),
(415, 1, 22, '2026-06-09 10:36:21'),
(416, 1, 23, '2026-06-09 10:36:21'),
(417, 1, 24, '2026-06-09 10:36:21'),
(418, 1, 25, '2026-06-09 10:36:21'),
(419, 1, 44, '2026-06-09 10:36:21'),
(420, 1, 45, '2026-06-09 10:36:21'),
(421, 1, 46, '2026-06-09 10:36:21'),
(422, 1, 47, '2026-06-09 10:36:21'),
(423, 1, 2, '2026-06-09 10:36:21'),
(424, 1, 3, '2026-06-09 10:36:21'),
(425, 1, 4, '2026-06-09 10:36:21'),
(426, 1, 5, '2026-06-09 10:36:21');

-- --------------------------------------------------------

--
-- Table structure for table `shelf_categories`
--

CREATE TABLE `shelf_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shelf_categories`
--

INSERT INTO `shelf_categories` (`id`, `category_name`, `status`, `created_at`) VALUES
(1, 'Base Unit 600mm Wide', 1, '2026-06-01 04:45:41'),
(2, 'Base Unit 750mm Wide', 1, '2026-06-01 04:46:06'),
(3, 'Base Unit 900mm Wide', 1, '2026-06-01 04:46:21'),
(4, 'Base Unit 1200mm Wide', 1, '2026-06-01 04:46:33'),
(5, 'Tall Unit 600mm Wide', 1, '2026-06-01 04:46:54'),
(6, 'Tall Unit 750mm Wide', 1, '2026-06-01 04:47:15'),
(7, 'Tall Unit 900mm Wide', 1, '2026-06-01 04:47:26'),
(8, 'Tall Unit 1200mm Wide', 1, '2026-06-01 04:47:42'),
(9, 'Wall Unit 600mm Wide', 1, '2026-06-01 04:48:23'),
(10, 'Wall Unit 750mm Wide', 1, '2026-06-01 04:48:38'),
(11, 'Wall Unit 900mm Wide', 1, '2026-06-01 04:48:55'),
(12, 'Wall Unit 1200mm Wide', 1, '2026-06-01 04:49:06');

-- --------------------------------------------------------

--
-- Table structure for table `shelf_materials`
--

CREATE TABLE `shelf_materials` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `material_name` varchar(255) DEFAULT NULL,
  `price_per_sqft` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shelf_materials`
--

INSERT INTO `shelf_materials` (`id`, `category_id`, `material_name`, `price_per_sqft`, `status`, `created_at`) VALUES
(1, 1, 'Full White SUD Laminate', 3640.00, 1, '2026-06-01 04:49:59'),
(2, 1, 'Non-Textured Fabric Finish Laminate', 3750.00, 1, '2026-06-01 04:50:16'),
(3, 1, 'Premium SUD Laminate', 4200.00, 1, '2026-06-01 04:50:33'),
(4, 2, 'Full White SUD Laminate', 4500.00, 1, '2026-06-01 04:50:48'),
(5, 2, 'Non-Textured Fabric Finish Laminate', 4610.00, 1, '2026-06-01 04:50:59'),
(6, 2, 'Premium SUD Laminate', 5200.00, 1, '2026-06-01 04:51:41'),
(7, 3, 'Full White SUD Laminate', 5360.00, 1, '2026-06-01 04:51:58'),
(8, 3, 'Non-Textured Fabric Finish Laminate', 5470.00, 1, '2026-06-01 04:52:11'),
(9, 3, 'Premuim SUD Laminate', 6200.00, 1, '2026-06-01 04:52:33'),
(10, 4, 'Full White SUD Laminate', 7080.00, 1, '2026-06-01 04:52:49'),
(11, 4, 'Non-Textured Fabric Finish Laminate', 7190.00, 1, '2026-06-01 04:53:01'),
(12, 4, 'Premium SUD Laminate', 8200.00, 1, '2026-06-01 04:53:30'),
(13, 5, 'Full White SUD Laminate', 3640.00, 1, '2026-06-01 04:54:13'),
(14, 5, 'Non-Textured Fabric Finish Laminate', 3750.00, 1, '2026-06-01 04:54:25'),
(15, 5, 'Premium SUD Laminate', 4200.00, 1, '2026-06-01 04:54:39'),
(16, 6, 'Full White SUD Laminate', 4500.00, 1, '2026-06-01 04:54:55'),
(17, 6, 'Non-Textured Fabric Finish Laminate', 4610.00, 1, '2026-06-01 04:55:07'),
(18, 6, 'Premium SUD Laminate', 5200.00, 1, '2026-06-01 04:55:23'),
(19, 7, 'Full White SUD Laminate', 5360.00, 1, '2026-06-01 04:55:45'),
(20, 7, 'Non-Textured Fabric Finish Laminate', 5470.00, 1, '2026-06-01 04:56:00'),
(21, 7, 'Premium SUD Laminate', 6200.00, 1, '2026-06-01 04:56:15'),
(22, 8, 'Full White SUD Laminate', 7080.00, 1, '2026-06-01 04:56:29'),
(23, 8, 'Non-Textured Fabric Finish Laminate', 7190.00, 1, '2026-06-01 04:56:42'),
(24, 8, 'Premium SUD Laminate', 8200.00, 1, '2026-06-01 04:57:00'),
(25, 9, 'Full White SUD Laminate', 2200.00, 1, '2026-06-01 04:57:27'),
(26, 9, 'Non-Textured Fabric Finish Laminate', 2310.00, 1, '2026-06-01 04:57:43'),
(27, 9, 'Premium SUD Laminate', 2760.00, 1, '2026-06-01 04:57:56'),
(28, 9, '10mm Glass', 3520.00, 1, '2026-06-01 04:58:09'),
(29, 10, 'Full White SUD Laminate', 2720.00, 1, '2026-06-01 04:58:23'),
(30, 10, 'Non-Textured Fabric Finish Laminate', 2830.00, 1, '2026-06-01 04:58:36'),
(31, 10, 'Premium SUD Laminate', 3360.00, 1, '2026-06-01 04:58:50'),
(32, 10, '10mm Glass', 4380.00, 1, '2026-06-01 04:59:01'),
(33, 11, 'Full White SUD Laminate', 3240.00, 1, '2026-06-01 04:59:10'),
(34, 11, 'Non-Textured Fabric Finish Laminate', 3350.00, 1, '2026-06-01 04:59:23'),
(35, 11, 'Premium SUD Laminate', 3960.00, 1, '2026-06-01 04:59:39'),
(36, 11, '10mm Glass', 5240.00, 1, '2026-06-01 04:59:55'),
(37, 12, 'Full White SUD Laminate', 4280.00, 1, '2026-06-01 05:00:15'),
(38, 12, 'Non-Textured Fabric Finish Laminate', 4390.00, 1, '2026-06-01 05:00:27'),
(39, 12, 'Premium SUD Laminate', 5160.00, 1, '2026-06-01 05:00:42'),
(40, 12, '10mm Glass', 6960.00, 1, '2026-06-01 05:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `shelves_data`
--

CREATE TABLE `shelves_data` (
  `id` int(11) NOT NULL,
  `assigned_unit_id` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `shelf_categories_id` int(11) DEFAULT NULL,
  `shelf_materials_id` int(11) DEFAULT NULL,
  `width_mm` decimal(10,2) DEFAULT NULL,
  `width_ft` decimal(10,2) DEFAULT NULL,
  `height_mm` decimal(10,2) DEFAULT NULL,
  `height_ft` decimal(10,2) DEFAULT NULL,
  `sqft` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shelves_data`
--

INSERT INTO `shelves_data` (`id`, `assigned_unit_id`, `quantity`, `shelf_categories_id`, `shelf_materials_id`, `width_mm`, `width_ft`, `height_mm`, `height_ft`, `sqft`, `price`, `total`, `quotation_id`) VALUES
(62, 'Tall_1', 1, 2, 5, 600.00, 1.97, 600.00, 1.97, 3.88, 2305.00, 8943.40, 193),
(63, 'Upper_1', 1, 1, 2, 600.00, 1.97, 350.00, 1.15, 2.26, 3750.00, 8475.00, 194),
(64, 'Upper_1', 1, 1, 2, 600.00, 1.97, 350.00, 1.15, 2.26, 3750.00, 8475.00, 195),
(65, 'Upper_1', 1, 1, 2, 600.00, 1.97, 350.00, 1.15, 2.26, 3750.00, 8475.00, 196),
(264, 'E1_Tall_1', 2, 2, 5, 600.00, 1.97, 600.00, 1.97, NULL, 4610.00, 9220.00, 257),
(266, 'E1_Tall_2', 2, 1, 1, 600.00, 1.97, 600.00, 1.97, NULL, 3640.00, 7280.00, 248),
(403, 'E1_Tall_2', 1, 5, 13, 600.00, 1.97, 600.00, 1.97, NULL, 3640.00, 3640.00, 259),
(404, 'E1_Tall_3', 1, 5, 13, 600.00, 1.97, 600.00, 1.97, NULL, 3640.00, 3640.00, 259),
(405, 'E1_Upper_1', 6, 9, 25, 600.00, 1.97, 350.00, 1.15, NULL, 2200.00, 13200.00, 259),
(406, 'E1_Upper_3', 6, 9, 25, 600.00, 1.97, 350.00, 1.15, NULL, 2200.00, 13200.00, 259),
(407, 'E1_Bottom_1', 2, 1, 2, 600.00, 1.97, 600.00, 1.97, NULL, 3750.00, 7500.00, 259);

-- --------------------------------------------------------

--
-- Table structure for table `shutter_categories`
--

CREATE TABLE `shutter_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shutter_categories`
--

INSERT INTO `shutter_categories` (`id`, `category_name`, `status`, `created_at`) VALUES
(2, 'Laminates', 1, '2026-05-28 06:23:10'),
(3, 'Acrylic', 1, '2026-05-28 06:23:20'),
(4, 'Ceramic', 1, '2026-05-28 06:23:28'),
(5, 'Matt PU', 1, '2026-05-28 06:23:35'),
(6, 'Glossy PU', 1, '2026-05-28 06:23:44'),
(7, 'Veneer', 1, '2026-05-28 06:23:59'),
(8, 'Metallic PU ', 1, '2026-05-28 06:24:06'),
(9, 'Glass', 1, '2026-05-28 06:24:17');

-- --------------------------------------------------------

--
-- Table structure for table `shutter_materials`
--

CREATE TABLE `shutter_materials` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `material_type` varchar(255) NOT NULL,
  `price_per_sqft` decimal(10,2) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shutter_materials`
--

INSERT INTO `shutter_materials` (`id`, `category_id`, `material_type`, `price_per_sqft`, `status`, `created_at`) VALUES
(2, 2, 'FR1200', 1800.00, 1, '2026-05-28 06:26:24'),
(3, 2, 'FR2000', 2000.00, 1, '2026-05-28 06:26:39'),
(4, 2, 'FR3000', 2240.00, 1, '2026-05-28 06:26:56'),
(5, 2, 'FR4000', 2480.00, 1, '2026-05-28 06:27:11'),
(6, 2, 'FR6000', 2960.00, 1, '2026-05-28 06:27:34'),
(7, 2, 'FR8000', 3440.00, 1, '2026-05-28 06:27:46'),
(8, 2, 'FR10000', 3920.00, 1, '2026-05-28 06:27:58'),
(9, 2, 'FR12000', 4400.00, 1, '2026-05-28 06:28:11'),
(10, 3, 'Glossy Acrylic 1.2 mm', 2500.00, 1, '2026-05-28 06:28:24'),
(11, 3, 'Matt Acrylic 1.2mm', 2600.00, 1, '2026-05-28 06:28:42'),
(12, 3, 'Glossy Acrylic 2mm', 3600.00, 1, '2026-05-28 06:28:53'),
(13, 3, 'Matt Acrylic 3mm', 3800.00, 1, '2026-05-28 06:29:05'),
(14, 4, 'Ceramic 3.5mm with Profile', 4450.00, 1, '2026-05-28 06:29:15'),
(15, 4, 'Ceramic 5mm with Profile', 4450.00, 1, '2026-05-28 06:29:26'),
(16, 5, 'Color Matt PU ', 3060.00, 1, '2026-05-28 06:29:37'),
(17, 5, 'Color Matt PU Panelled', 3260.00, 1, '2026-05-28 06:29:48'),
(18, 5, 'Color Matt PU with MOULDINGS', 3560.00, 1, '2026-05-28 06:30:08'),
(19, 5, 'Color Matt PU with Clear Glass', 3100.00, 1, '2026-05-28 06:30:21'),
(20, 5, 'Color Matt PU with Fluted Clear Glass', 3250.00, 1, '2026-05-28 06:30:33'),
(21, 5, 'Color Matt PU with Extra Clear Glass', 3450.00, 1, '2026-05-28 06:30:48'),
(22, 6, 'Color Glossy PU ', 3300.00, 1, '2026-05-28 06:31:12'),
(23, 6, 'Color Glossy PU  Panelled', 3500.00, 1, '2026-05-28 06:31:24'),
(24, 6, 'Color Glossy PU with MOULDINGS', 3800.00, 1, '2026-05-28 06:31:41'),
(25, 6, 'Color Glossy PU with Clear Glass', 3250.00, 1, '2026-05-28 06:31:53'),
(26, 6, 'Color Glossy PU with Fluted Clear Glass', 3400.00, 1, '2026-05-28 06:32:04'),
(27, 6, 'Color Glossy PU with Extra Clear Glass', 3600.00, 1, '2026-05-28 06:32:14'),
(28, 7, 'Veneer Shutter with Finger Groove ', 4600.00, 1, '2026-05-28 06:32:30'),
(29, 7, 'Dyed Veneer Shutter with Finger Groove ', 6300.00, 1, '2026-05-28 06:32:51'),
(30, 7, 'Fluted Veneer Shutter with Finger Groove / Profile ', 7700.00, 1, '2026-05-28 06:33:14'),
(31, 7, 'Thick Fluted Wood Shutters with with Finger Groove / Profile ', 9100.00, 1, '2026-05-28 06:33:26'),
(32, 8, 'Metallic PU - 1 Color', 4450.00, 1, '2026-05-28 06:33:39'),
(33, 8, 'Metallic PU - Ombre ', 5300.00, 1, '2026-05-28 06:33:58'),
(34, 8, 'Matallic PU - Textured', 5900.00, 1, '2026-05-28 06:34:08'),
(35, 9, 'Clear Glass with Profile', 3600.00, 1, '2026-05-28 06:34:21'),
(36, 9, 'Black Tinted Glass with Profile', 3900.00, 1, '2026-05-28 06:34:32'),
(37, 9, 'Brown Tinted Glass with Profile', 4000.00, 1, '2026-05-28 06:34:41'),
(38, 9, 'Clear Fluted Glass with Profile ', 4100.00, 1, '2026-05-28 06:34:52'),
(39, 9, 'Brown/Black Fluted Glass with Profile', 5100.00, 1, '2026-05-28 06:35:05'),
(40, 2, 'FR14000', 4880.00, 1, '2026-05-30 04:27:52');

-- --------------------------------------------------------

--
-- Table structure for table `standard_accessory_categories`
--

CREATE TABLE `standard_accessory_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `standard_accessory_categories`
--

INSERT INTO `standard_accessory_categories` (`id`, `category_name`, `status`, `created_at`) VALUES
(1, 'Skirting', 1, '2026-06-29 07:55:32'),
(2, 'LED', 1, '2026-06-29 07:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `standard_accessory_materials`
--

CREATE TABLE `standard_accessory_materials` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `material_name` varchar(255) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `standard_accessory_materials`
--

INSERT INTO `standard_accessory_materials` (`id`, `category_id`, `material_name`, `unit`, `price`, `status`, `created_at`) VALUES
(1, 1, 'Black', 'Nos', 1350.00, 1, '2026-06-29 08:03:56'),
(2, 2, 'Neo Flexi LED Lights, 3000K / 3500K', 'Meter', 400.00, 1, '2026-06-29 08:04:24'),
(3, 2, 'LED Driver 24 V', 'Nos', 2550.00, 1, '2026-06-29 08:06:07'),
(4, 2, 'Sensor', 'Nos', 800.00, 1, '2026-06-29 08:06:27');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `elevation_id` int(11) DEFAULT NULL,
  `unit_type` varchar(50) DEFAULT NULL,
  `unit_key` varchar(100) DEFAULT NULL,
  `width_mm` decimal(10,2) DEFAULT NULL,
  `width_ft` decimal(10,2) DEFAULT NULL,
  `height_mm` decimal(10,2) DEFAULT NULL,
  `height_ft` decimal(10,2) DEFAULT NULL,
  `depth_mm` decimal(10,2) DEFAULT NULL,
  `sqft` decimal(10,2) DEFAULT NULL,
  `carcass_categories_id` int(11) DEFAULT NULL,
  `carcass_materials_id` int(11) DEFAULT NULL,
  `shutter_categories_id` int(11) DEFAULT NULL,
  `shutter_materials_id` int(11) DEFAULT NULL,
  `unit_total` decimal(10,2) DEFAULT NULL,
  `carcass_total` decimal(10,2) DEFAULT NULL,
  `shutter_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `elevation_id`, `unit_type`, `unit_key`, `width_mm`, `width_ft`, `height_mm`, `height_ft`, `depth_mm`, `sqft`, `carcass_categories_id`, `carcass_materials_id`, `shutter_categories_id`, `shutter_materials_id`, `unit_total`, `carcass_total`, `shutter_total`) VALUES
(731, 346, 'Tall', 'E1_Tall_1', 6006.00, 0.00, 60.00, 0.00, 600.00, 3.88, 2, 22, 9, 36, 55650.00, 12998.00, 15132.00),
(734, 348, 'Tall', 'E1_Tall_1', 600.00, 0.00, 750.00, 0.00, 600.00, 4.84, 2, 21, 4, 15, 212884.00, 15246.00, 21538.00),
(735, 348, 'Tall', 'E1_Tall_2', 600.00, 0.00, 750.00, 0.00, 600.00, 4.84, 2, 21, 4, 15, 44064.00, 15246.00, 21538.00),
(805, 358, 'Tall', 'E1_Tall_1', 600.00, 0.00, 2240.00, 0.00, 600.00, 14.47, 2, 21, 2, 3, 74520.50, 45580.50, 28940.00),
(806, 358, 'Tall', 'E1_Tall_2', 600.00, 0.00, 2240.00, 0.00, 600.00, 14.47, 2, 21, 2, 3, 74520.50, 45580.50, 28940.00),
(807, 358, 'Tall', 'E1_Tall_3', 600.00, 0.00, 2240.00, 0.00, 600.00, 14.47, 2, 21, 2, 3, 74520.50, 45580.50, 28940.00),
(808, 358, 'Tall', 'E1_Tall_4', 600.00, 0.00, 2240.00, 0.00, 600.00, 14.47, 2, 21, 2, 3, 74520.50, 45580.50, 28940.00),
(809, 358, 'Upper', 'E1_Upper_1', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 3, 24353.00, 14413.00, 9940.00),
(810, 358, 'Upper', 'E1_Upper_2', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 3, 24353.00, 14413.00, 9940.00),
(811, 358, 'Upper', 'E1_Upper_3', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 3, 24353.00, 14413.00, 9940.00),
(812, 358, 'Upper', 'E1_Upper_4', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 3, 24353.00, 14413.00, 9940.00),
(813, 358, 'Upper', 'E1_Upper_5', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 0, 14413.00, 14413.00, 0.00),
(1046, 419, 'Tall', 'E1_Tall_1', 600.00, 0.00, 2200.00, 0.00, 600.00, 14.21, 2, 21, 2, 3, 124421.50, 44761.50, 28420.00),
(1047, 419, 'Tall', 'E1_Tall_2', 600.00, 0.00, 2200.00, 0.00, 600.00, 14.21, 2, 21, 2, 3, 76821.50, 44761.50, 28420.00),
(1048, 419, 'Tall', 'E1_Tall_3', 600.00, 0.00, 2200.00, 0.00, 600.00, 14.21, 2, 21, 2, 3, 150261.50, 44761.50, 28420.00),
(1049, 419, 'Tall', 'E1_Tall_4', 600.00, 0.00, 2200.00, 0.00, 600.00, 14.21, 2, 21, 2, 3, 73181.50, 44761.50, 28420.00),
(1050, 419, 'Upper', 'E1_Upper_1', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 3, 37553.00, 14413.00, 9940.00),
(1051, 419, 'Upper', 'E1_Upper_2', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 3, 24353.00, 14413.00, 9940.00),
(1052, 419, 'Upper', 'E1_Upper_3', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 3, 37553.00, 14413.00, 9940.00),
(1053, 419, 'Upper', 'E1_Upper_4', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 3, 24353.00, 14413.00, 9940.00),
(1054, 419, 'Upper', 'E1_Upper_5', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 3, 24353.00, 14413.00, 9940.00),
(1055, 419, 'Upper', 'E1_Upper_6', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 3, 24353.00, 14413.00, 9940.00),
(1056, 419, 'Upper', 'E1_Upper_7', 600.00, 0.00, 770.00, 0.00, 350.00, 4.97, 3, 26, 2, 3, 24353.00, 14413.00, 9940.00),
(1057, 419, 'Bottom', 'E1_Bottom_1', 400.00, 0.00, 600.00, 0.00, 600.00, 2.58, 1, 14, 2, 3, 20787.00, 8127.00, 5160.00),
(1058, 419, 'Bottom', 'E1_Bottom_2', 400.00, 0.00, 600.00, 0.00, 600.00, 2.58, 1, 14, 0, 0, 46527.00, 8127.00, 0.00),
(1059, 419, 'Bottom', 'E1_Bottom_3', 400.00, 0.00, 600.00, 0.00, 600.00, 2.58, 1, 14, 2, 3, 13287.00, 8127.00, 5160.00),
(1060, 419, 'Loft', 'E1_Loft_1', 450.00, 0.00, 450.00, 0.00, 350.00, 2.18, 3, 26, 2, 3, 10682.00, 6322.00, 4360.00),
(1061, 419, 'Loft', 'E1_Loft_2', 450.00, 0.00, 450.00, 0.00, 350.00, 2.18, 3, 26, 2, 3, 81522.00, 6322.00, 4360.00),
(1062, 419, 'Loft', 'E1_Loft_3', 450.00, 0.00, 450.00, 0.00, 350.00, 2.18, 3, 26, 2, 3, 10682.00, 6322.00, 4360.00),
(1063, 420, 'Tall', 'E2_Tall_1', 600.00, 0.00, 600.00, 0.00, 600.00, 3.88, 2, 21, 9, 39, 32010.00, 12222.00, 19788.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `entity_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `status`, `created_at`, `entity_id`) VALUES
(1, 'Phantom', 'admin@qg.com', '$2y$10$e.WwBBIkpuPwiA1ONCvHbOdM3JoDqOrY0JAWnGyn4RwI/WkRVVAoS', 1, 'Active', '2026-05-29 08:14:37', NULL),
(6, 'Rishi', 'aa@gmail.com', '$2y$10$6WSFNysPUi.w2npWr7DT6exaKbt81TPRoFJ06ObpOa7zfuaWWiQnu', 2, 'Active', '2026-05-29 08:56:18', NULL),
(7, 'Rishi', 'abc@gmail.com', '$2y$10$d2mQQF40WlsinMlkCmcfCeV1mGViBpy1H8IMsXHWF8UznM7qiOJ..', 4, 'Active', '2026-05-29 08:56:57', 2),
(8, 'Rishikumar Yadav', 'xyz@gmail.com', '$2y$10$lAQ1Ow5w3p16YTYXTBP/MeHiYququj1ES7zYAMCiUl7ImsNWWJpby', 3, 'Active', '2026-05-29 08:57:41', 2),
(9, 'Chirag Purohit', 'operations@frindia.com', '$2y$10$ViRm9MJpVNwh1VzYBry1wuUtPH3qsCxOrUYKkLkQ.G3tWn5/btQ.K', 3, 'Active', '2026-06-08 05:40:36', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accessory_categories`
--
ALTER TABLE `accessory_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carcass_categories`
--
ALTER TABLE `carcass_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carcass_materials`
--
ALTER TABLE `carcass_materials`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `carcass_materials` ADD FULLTEXT KEY `material_name` (`material_name`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drawers_data`
--
ALTER TABLE `drawers_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drawer_categories`
--
ALTER TABLE `drawer_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drawer_materials`
--
ALTER TABLE `drawer_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elevations`
--
ALTER TABLE `elevations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_id` (`quotation_id`),
  ADD KEY `idx_quotation_id` (`quotation_id`);

--
-- Indexes for table `elevation_line_images`
--
ALTER TABLE `elevation_line_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_elevation_line_image` (`elevation_id`);

--
-- Indexes for table `entities`
--
ALTER TABLE `entities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_reports`
--
ALTER TABLE `financial_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `proforma_no` (`proforma_no`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_created_by` (`created_by`),
  ADD KEY `idx_proforma_no` (`proforma_no`),
  ADD KEY `idx_client_id` (`client_id`);

--
-- Indexes for table `quotation_accessories`
--
ALTER TABLE `quotation_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_id` (`quotation_id`);

--
-- Indexes for table `quotation_panels`
--
ALTER TABLE `quotation_panels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation_sequences`
--
ALTER TABLE `quotation_sequences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `financial_year` (`financial_year`);

--
-- Indexes for table `quotation_standard_accessories`
--
ALTER TABLE `quotation_standard_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_id` (`quotation_id`),
  ADD KEY `standard_accessory_id` (`standard_accessory_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `shelf_categories`
--
ALTER TABLE `shelf_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shelf_materials`
--
ALTER TABLE `shelf_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shelves_data`
--
ALTER TABLE `shelves_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shutter_categories`
--
ALTER TABLE `shutter_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `shutter_materials`
--
ALTER TABLE `shutter_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `standard_accessory_categories`
--
ALTER TABLE `standard_accessory_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `standard_accessory_materials`
--
ALTER TABLE `standard_accessory_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `elevation_id` (`elevation_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `accessory_categories`
--
ALTER TABLE `accessory_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `carcass_categories`
--
ALTER TABLE `carcass_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carcass_materials`
--
ALTER TABLE `carcass_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drawers_data`
--
ALTER TABLE `drawers_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=434;

--
-- AUTO_INCREMENT for table `drawer_categories`
--
ALTER TABLE `drawer_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `drawer_materials`
--
ALTER TABLE `drawer_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=431;

--
-- AUTO_INCREMENT for table `elevations`
--
ALTER TABLE `elevations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=453;

--
-- AUTO_INCREMENT for table `elevation_line_images`
--
ALTER TABLE `elevation_line_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `entities`
--
ALTER TABLE `entities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `financial_reports`
--
ALTER TABLE `financial_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;

--
-- AUTO_INCREMENT for table `quotation_accessories`
--
ALTER TABLE `quotation_accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `quotation_panels`
--
ALTER TABLE `quotation_panels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quotation_sequences`
--
ALTER TABLE `quotation_sequences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT for table `quotation_standard_accessories`
--
ALTER TABLE `quotation_standard_accessories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=427;

--
-- AUTO_INCREMENT for table `shelf_categories`
--
ALTER TABLE `shelf_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `shelf_materials`
--
ALTER TABLE `shelf_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `shelves_data`
--
ALTER TABLE `shelves_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=408;

--
-- AUTO_INCREMENT for table `shutter_categories`
--
ALTER TABLE `shutter_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `shutter_materials`
--
ALTER TABLE `shutter_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `standard_accessory_categories`
--
ALTER TABLE `standard_accessory_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `standard_accessory_materials`
--
ALTER TABLE `standard_accessory_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1064;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `elevation_line_images`
--
ALTER TABLE `elevation_line_images`
  ADD CONSTRAINT `fk_elevation_line_image` FOREIGN KEY (`elevation_id`) REFERENCES `elevations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotation_standard_accessories`
--
ALTER TABLE `quotation_standard_accessories`
  ADD CONSTRAINT `quotation_standard_accessories_ibfk_1` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotation_standard_accessories_ibfk_2` FOREIGN KEY (`standard_accessory_id`) REFERENCES `standard_accessory_materials` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

--
-- Constraints for table `shutter_materials`
--
ALTER TABLE `shutter_materials`
  ADD CONSTRAINT `shutter_materials_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `shutter_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `standard_accessory_materials`
--
ALTER TABLE `standard_accessory_materials`
  ADD CONSTRAINT `standard_accessory_materials_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `standard_accessory_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
