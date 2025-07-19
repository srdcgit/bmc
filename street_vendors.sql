-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 07:15 AM
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
-- Database: `bmcn`
--

-- --------------------------------------------------------

--
-- Table structure for table `street_vendors`
--

CREATE TABLE `street_vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uu_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `mobilenumber` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `street_vendors`
--

INSERT INTO `street_vendors` (`id`, `uu_id`, `name`, `photo`, `address`, `area`, `mobilenumber`, `created_at`, `updated_at`) VALUES
(1, 'SV-765885', 'Nilanchal Patra', 'photos/1749639058_images (9).jpg', 'S/o- Purusottam Patra, Plot-No - 1512/1477,Khandagiri Bari, Bhubaneswar, 751030', NULL, '7325918880', '2025-06-11 04:17:59', '2025-06-11 05:20:58'),
(2, 'SV-818340', 'Jyotiranjan Mohanty', 'photos/1749639243_download (8).jpg', 'S/o- Kanduri Ch.Mohanty, At-Mohanty Sahi, Ghatikia, ps- khandagiri, Bhubaneswar-751003', NULL, '7978839568', '2025-06-11 04:36:16', '2025-06-11 05:24:03'),
(4, 'SV-418029', 'Nimansha Rout', NULL, 'S/o - Pramod Rout , Barakandha , Chedakari,Kendrapada-754224', NULL, '8249334358', '2025-06-11 05:29:54', '2025-06-11 05:29:54'),
(5, 'SV-773402', 'Bharat ch Barik(PH)', NULL, 'S/o- Umesh Barik , At- Salapada ,Jajpur - 754082', NULL, '6372188909', '2025-06-11 05:31:50', '2025-06-11 05:31:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `street_vendors`
--
ALTER TABLE `street_vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `street_vendors_uu_id_unique` (`uu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `street_vendors`
--
ALTER TABLE `street_vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
