-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2025 at 08:43 AM
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
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Karya Tulis Ilmiah', '2025-10-01 19:36:16', '2025-10-01 19:36:16'),
(2, 'Poster', '2025-10-01 19:36:16', '2025-10-01 19:36:16'),
(3, 'Penelitian Eksternal', '2025-10-01 19:36:16', '2025-10-01 19:36:16'),
(4, 'Penelitian Internal', '2025-10-01 19:36:16', '2025-10-01 19:36:16'),
(5, 'E Book', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_token` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `year_published` year(4) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `abstract` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) NOT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kampus` varchar(255) DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `title`, `author`, `year_published`, `category_id`, `abstract`, `cover_image`, `file_url`, `views`, `client_id`, `status`, `created_at`, `updated_at`, `kampus`, `prodi`) VALUES
(1, 'Ayo Hidup Sehat', 'alvin dwi', '2023', 1, 'Penelitian ini membahasan bagaimana cara mejaga hidup agar tetap sehat', 'covers/Vm0ozlTX9mwf58tYlM2VRZ4RbejT2mZQWVFTuMGz.jpg', 'documents/Rkzb0LEUWoM0fC3RpKLKfsEuCEccrJ3tIYGzb48g.png', 0, NULL, 'pending', '2025-09-01 23:19:31', '2025-10-01 23:34:05', NULL, NULL),
(2, 'Waspada Anemia', 'cinta', '2025', 3, 'penelitian membahas kewaspadaan terhadap anemia yang kian marak di masyarakat karena di akibatkan kekurangan sel darah merah', 'covers/krsU9fVx30wTO3EOupIvQymFdHKGwVvPyKHF1ViB.jpg', 'documents/NYUk4RNKf4d5IZfKSK4pcMa0bTmDq61kftL3L9w7.png', 0, NULL, 'pending', '2025-10-01 23:36:18', '2025-10-01 23:36:18', NULL, NULL),
(4, 'karya 1', 'cinta', '2024', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec purus magna. Fusce fermentum nunc diam, eget porttitor nulla ullamcorper vel. Nullam iaculis risus ac sem tincidunt auctor. Ut lobortis justo at semper luctus. Vivamus fringilla vehicula dui nec posuere. Fusce ligula odio, interdum at scelerisque placerat, pulvinar sit amet justo. Etiam dictum massa nec est dictum, sed pharetra neque sagittis.', 'covers/29eWzx5vEtQt3hsWQqoCOJF2D8GGpjbpCp7NWMmE.jpg', 'documents/2TKnH0mN7TSFhj7EoIFoQBwjqOTjiqzF1fVQ1zzF.pdf', 0, NULL, 'pending', '2025-10-06 19:36:46', '2025-10-06 19:36:46', NULL, NULL),
(5, 'karya 2', 'cinta', '2024', 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec purus magna. Fusce fermentum nunc diam, eget porttitor nulla ullamcorper vel. Nullam iaculis risus ac sem tincidunt auctor. Ut lobortis justo at semper luctus. Vivamus fringilla vehicula dui nec posuere. Fusce ligula odio, interdum at scelerisque placerat, pulvinar sit amet justo. Etiam dictum massa nec est dictum, sed pharetra neque sagittis.', 'covers/vRqhywTRJBm8eIcBVLh6LeA3CDti94gUGYZigJdx.jpg', 'documents/0ej8ZtbK2DTSYXj4BANEidUmHncDshfKxIMD2ScJ.pdf', 1, NULL, 'pending', '2025-10-06 19:37:15', '2025-10-12 19:45:19', NULL, NULL),
(6, 'Poster 1', 'Alvin Dwi Jayadi', '2018', 2, NULL, NULL, 'documents/EM09soyoioCYgi1zPi11f0saWUp3Ve5JsAXSfukX.png', 3, NULL, 'pending', '2025-10-12 20:03:41', '2025-10-14 19:48:44', NULL, NULL),
(7, 'test post file', 'Sahroni', '2025', 3, 'ini adalah abstrak dari tes post file', 'covers/XPvIgRAzxJCjphUk4CoEN6q0fiTzYRgFsMYycVS0.jpg', 'documents/Ea3iawwrhn13bYV6aV5OQiUgnVXejvBTmWL20Axh.pdf', 6, NULL, 'pending', '2025-10-12 20:26:56', '2025-10-21 19:22:04', 'Politeknik Negeri Malang', 'Manajemen Informatika'),
(8, 'nyoba log', 'Alvin Dwi Jayadi', '2018', 1, 'ini abstrak untuk upload log', 'covers/NhGYuB5xvbzd4fQzov7KWwWv4F0ixtweHSi7Z7sG.jpg', 'documents/LI8dQo1ncQZG9EhGxd8sXSgUVA9W5UoKdCk6BTCl.pdf', 1, NULL, 'pending', '2025-10-16 22:37:34', '2025-10-21 19:22:27', NULL, NULL),
(9, 'mooooo', 'mkdir', '2023', 2, NULL, NULL, 'documents/WynX3hqvMQ0KAgvfsSzhO88LPxeKoGwYZgNKmI30.png', 0, NULL, 'pending', '2025-10-16 22:47:51', '2025-10-16 22:47:51', NULL, NULL),
(10, 'test upload log', 'Sahroni', '2019', 2, NULL, NULL, 'documents/J5RKyj8nTbMndz1PKvvWYG9OjEDbz2JLFWaZ6Df1.jpg', 0, NULL, 'pending', '2025-10-19 19:11:18', '2025-10-19 19:11:18', NULL, NULL),
(11, 'test upload log', 'Sahroni', '2019', 2, NULL, NULL, 'documents/DEpOnwFFdUN1m9tEOcXQeYpFGjN81Dgs9VUpyMlT.jpg', 0, NULL, 'pending', '2025-10-19 19:12:04', '2025-10-19 19:12:04', NULL, NULL),
(12, 'test upload log', 'Sahroni', '2025', 2, NULL, NULL, 'documents/IGrSuSg3kbClbpD0MBqoltkyrTNBigEinkQMRdZI.jpg', 0, NULL, 'pending', '2025-10-19 19:13:30', '2025-10-19 19:13:30', NULL, NULL),
(13, 'tes', 'Alvin Dwi Jayadi JR', '2024', 2, NULL, NULL, 'documents/lsFP4Fkoet97YH3imabz5sB06cwpB90W1HCu1r1x.jpg', 0, NULL, 'pending', '2025-10-19 19:23:39', '2025-10-19 19:23:39', NULL, NULL),
(14, 'tes lagi', 'Alvin Dwi Jayadi JR', '2024', 2, NULL, NULL, 'documents/RD2hjlRLknZ1wFO92zHJ7wvyvoFVr5JIHdaYXMO4.jpg', 0, NULL, 'pending', '2025-10-19 19:26:00', '2025-10-19 19:26:00', NULL, NULL),
(15, 'tes lagi 3', 'Alvin Dwi Jayadi JR', '2024', 2, NULL, NULL, 'documents/ZXxGUrEGZOGWhuZT4fEO9ic9dhJIi7Ywvbgc3CFA.jpg', 0, NULL, 'pending', '2025-10-19 19:31:30', '2025-10-19 19:34:05', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_15_033231_create_categories_table', 1),
(5, '2025_09_29_054314_create_documents_table', 1),
(6, '2025_10_08_021550_add_views_to_documents_table', 2),
(7, '2025_10_09_061551_add_kampus_prodi_to_documents_table', 3),
(12, '2025_10_17_011718_create_clients_table', 4),
(21, '2025_10_17_011844_add_client_id_status_to_documents_table', 5),
(22, '2025_10_17_030317_create_upload_logs_table', 6),
(23, '2025_10_17_051000_add_api_token_to_clients_table', 7),
(24, '2025_10_20_022848_make_client_id_nullable_in_upload_logs_table', 8),
(25, '2025_10_16_022116_add_cover_image_to_documents_table', 9),
(26, '2025_10_21_010817_make_cover_image_nullable_in_documents_table', 9),
(27, '2025_10_22_024329_make_document_id_nullable_in_upload_logs_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('meLYhjTh3UrUMEtUAbTUzIbmTcH60gmg4yx3sWF0', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoia05TeTNtQndZUHhiVm8yY1lEVEF0UGJjMGJwYzZTaGJZS3h2Zk95NyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbGlicmFyeT9zb3J0X2J5PWp1ZHVsX2FzYyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1761115395);

-- --------------------------------------------------------

--
-- Table structure for table `upload_logs`
--

CREATE TABLE `upload_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL DEFAULT 'upload',
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `upload_logs`
--

INSERT INTO `upload_logs` (`id`, `document_id`, `user_id`, `client_id`, `action`, `status`, `created_at`, `updated_at`) VALUES
(1, 15, 7, NULL, 'upload', 'approved', '2025-10-19 19:31:30', '2025-10-19 19:31:30'),
(2, 15, 7, NULL, 'update', 'approved', '2025-10-19 19:34:05', '2025-10-19 19:34:05'),
(3, NULL, 7, NULL, 'delete', 'approved', '2025-10-21 19:47:21', '2025-10-21 19:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(7, 'Test User', 'test@example.com', NULL, '$2y$12$asBnd2iFg/2FDMWv1TjzS.t8V2Ix9I3c5uHQUAmoRuphkOX74A2i2', NULL, '2025-10-12 19:55:37', '2025-10-12 19:55:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_api_token_unique` (`api_token`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `documents_client_id_foreign` (`client_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `upload_logs`
--
ALTER TABLE `upload_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `upload_logs_user_id_foreign` (`user_id`),
  ADD KEY `upload_logs_client_id_foreign` (`client_id`),
  ADD KEY `upload_logs_document_id_foreign` (`document_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `upload_logs`
--
ALTER TABLE `upload_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `documents_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `upload_logs`
--
ALTER TABLE `upload_logs`
  ADD CONSTRAINT `upload_logs_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `upload_logs_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `upload_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
