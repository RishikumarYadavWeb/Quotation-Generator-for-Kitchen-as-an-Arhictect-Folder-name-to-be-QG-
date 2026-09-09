-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
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
-- Table structure for table `accessory_categories`
--

CREATE TABLE `accessory_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `quotation_sequences`
--

CREATE TABLE `quotation_sequences` (
  `id` int(11) NOT NULL,
  `financial_year` varchar(20) DEFAULT NULL,
  `last_number` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
