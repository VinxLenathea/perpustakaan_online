-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Des 2025 pada 07.02
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Karya Tulis Ilmiah', '2025-10-01 19:36:16', '2025-10-01 19:36:16'),
(2, 'Poster', '2025-10-01 19:36:16', '2025-10-01 19:36:16'),
(3, 'Penelitian Eksternal', '2025-10-01 19:36:16', '2025-10-01 19:36:16'),
(4, 'Penelitian Internal', '2025-10-01 19:36:16', '2025-10-01 19:36:16'),
(5, 'E Book', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `clients`
--

INSERT INTO `clients` (`id`, `name`, `created_at`, `updated_at`, `api_token`) VALUES
(1, 'siakad', NULL, NULL, '240452607');

-- --------------------------------------------------------

--
-- Struktur dari tabel `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_published` year(4) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `abstract` text COLLATE utf8mb4_unicode_ci,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kampus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prodi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `documents`
--

INSERT INTO `documents` (`id`, `title`, `author`, `year_published`, `category_id`, `abstract`, `cover_image`, `file_url`, `views`, `client_id`, `status`, `created_at`, `updated_at`, `kampus`, `prodi`) VALUES
(1, 'Ayo Hidup Sehat', 'alvin dwi', 2023, 1, 'Penelitian ini membahasan bagaimana cara mejaga hidup agar tetap sehat', 'covers/Vm0ozlTX9mwf58tYlM2VRZ4RbejT2mZQWVFTuMGz.jpg', 'documents/Rkzb0LEUWoM0fC3RpKLKfsEuCEccrJ3tIYGzb48g.png', 0, NULL, 'pending', '2025-09-01 23:19:31', '2025-10-01 23:34:05', NULL, NULL),
(2, 'Waspada Anemia', 'cinta', 2025, 3, 'penelitian membahas kewaspadaan terhadap anemia yang kian marak di masyarakat karena di akibatkan kekurangan sel darah merah', 'covers/krsU9fVx30wTO3EOupIvQymFdHKGwVvPyKHF1ViB.jpg', 'documents/NYUk4RNKf4d5IZfKSK4pcMa0bTmDq61kftL3L9w7.png', 0, NULL, 'pending', '2025-10-01 23:36:18', '2025-10-01 23:36:18', NULL, NULL),
(4, 'karya 1', 'cinta', 2024, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec purus magna. Fusce fermentum nunc diam, eget porttitor nulla ullamcorper vel. Nullam iaculis risus ac sem tincidunt auctor. Ut lobortis justo at semper luctus. Vivamus fringilla vehicula dui nec posuere. Fusce ligula odio, interdum at scelerisque placerat, pulvinar sit amet justo. Etiam dictum massa nec est dictum, sed pharetra neque sagittis.', 'covers/29eWzx5vEtQt3hsWQqoCOJF2D8GGpjbpCp7NWMmE.jpg', 'documents/2TKnH0mN7TSFhj7EoIFoQBwjqOTjiqzF1fVQ1zzF.pdf', 0, NULL, 'pending', '2025-10-06 19:36:46', '2025-10-06 19:36:46', NULL, NULL),
(5, 'karya 2', 'cinta', 2024, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec purus magna. Fusce fermentum nunc diam, eget porttitor nulla ullamcorper vel. Nullam iaculis risus ac sem tincidunt auctor. Ut lobortis justo at semper luctus. Vivamus fringilla vehicula dui nec posuere. Fusce ligula odio, interdum at scelerisque placerat, pulvinar sit amet justo. Etiam dictum massa nec est dictum, sed pharetra neque sagittis.', 'covers/vRqhywTRJBm8eIcBVLh6LeA3CDti94gUGYZigJdx.jpg', 'documents/0ej8ZtbK2DTSYXj4BANEidUmHncDshfKxIMD2ScJ.pdf', 1, NULL, 'pending', '2025-10-06 19:37:15', '2025-10-12 19:45:19', NULL, NULL),
(6, 'Poster 1', 'Alvin Dwi Jayadi', 2018, 2, NULL, NULL, 'documents/EM09soyoioCYgi1zPi11f0saWUp3Ve5JsAXSfukX.png', 4, NULL, 'pending', '2025-10-12 20:03:41', '2025-12-14 21:49:18', NULL, NULL),
(7, 'test post file', 'Sahroni', 2025, 3, 'ini adalah abstrak dari tes post file', 'covers/XPvIgRAzxJCjphUk4CoEN6q0fiTzYRgFsMYycVS0.jpg', 'documents/Ea3iawwrhn13bYV6aV5OQiUgnVXejvBTmWL20Axh.pdf', 8, NULL, 'pending', '2025-10-12 20:26:56', '2025-12-14 21:50:06', 'Politeknik Negeri Malang', 'Manajemen Informatika'),
(8, 'nyoba log', 'Alvin Dwi Jayadi', 2018, 1, 'ini abstrak untuk upload log', 'covers/NhGYuB5xvbzd4fQzov7KWwWv4F0ixtweHSi7Z7sG.jpg', 'documents/LI8dQo1ncQZG9EhGxd8sXSgUVA9W5UoKdCk6BTCl.pdf', 1, NULL, 'pending', '2025-10-16 22:37:34', '2025-10-21 19:22:27', NULL, NULL),
(9, 'mooooo', 'mkdir', 2023, 2, NULL, NULL, 'documents/WynX3hqvMQ0KAgvfsSzhO88LPxeKoGwYZgNKmI30.png', 0, NULL, 'pending', '2025-10-16 22:47:51', '2025-10-16 22:47:51', NULL, NULL),
(10, 'test upload log', 'Sahroni', 2019, 2, NULL, NULL, 'documents/J5RKyj8nTbMndz1PKvvWYG9OjEDbz2JLFWaZ6Df1.jpg', 0, NULL, 'pending', '2025-10-19 19:11:18', '2025-10-19 19:11:18', NULL, NULL),
(12, 'test upload log', 'Sahroni', 2025, 2, NULL, NULL, 'documents/IGrSuSg3kbClbpD0MBqoltkyrTNBigEinkQMRdZI.jpg', 0, NULL, 'pending', '2025-10-19 19:13:30', '2025-10-19 19:13:30', NULL, NULL),
(13, 'tes', 'Alvin Dwi Jayadi JR', 2024, 2, NULL, NULL, 'documents/lsFP4Fkoet97YH3imabz5sB06cwpB90W1HCu1r1x.jpg', 0, NULL, 'pending', '2025-10-19 19:23:39', '2025-10-19 19:23:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
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
(27, '2025_10_22_024329_make_document_id_nullable_in_upload_logs_table', 9),
(28, '2025_12_11_033107_make_user_id_nullable_in_upload_logs_table', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('SdRFXf7rB85jyesj0rQnt1fc1BNk7QyWUVolGBDY', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT0ZyVFVHYXZCUFVhcFlHeGJMMVRIMEtCdEdSb0lTVndtNDhsS1VNUCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbGlicmFyeSI7czo1OiJyb3V0ZSI7czo3OiJsaWJyYXJ5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Nzt9', 1765778511);

-- --------------------------------------------------------

--
-- Struktur dari tabel `upload_logs`
--

CREATE TABLE `upload_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upload',
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `upload_logs`
--

INSERT INTO `upload_logs` (`id`, `document_id`, `user_id`, `client_id`, `action`, `status`, `created_at`, `updated_at`) VALUES
(1, 15, 7, NULL, 'upload', 'approved', '2025-10-19 19:31:30', '2025-10-19 19:31:30'),
(2, 15, 7, NULL, 'update', 'approved', '2025-10-19 19:34:05', '2025-10-19 19:34:05'),
(3, NULL, 7, NULL, 'delete', 'approved', '2025-10-21 19:47:21', '2025-10-21 19:47:21'),
(4, 16, NULL, 1, 'upload', 'approved', '2025-12-13 22:29:00', '2025-12-13 22:29:20'),
(5, 17, NULL, 1, 'upload', 'approved', '2025-12-13 23:10:46', '2025-12-13 23:34:40'),
(6, 18, NULL, 1, 'upload', 'approved', '2025-12-13 23:35:56', '2025-12-13 23:36:38'),
(7, 19, NULL, 1, 'upload', 'rejected', '2025-12-14 00:43:20', '2025-12-14 00:44:25'),
(8, 20, NULL, 1, 'upload', 'rejected', '2025-12-14 00:43:57', '2025-12-14 00:59:18'),
(9, 21, NULL, 1, 'upload', 'rejected', '2025-12-14 00:53:32', '2025-12-14 00:59:15'),
(10, 22, NULL, 1, 'upload', 'rejected', '2025-12-14 00:56:14', '2025-12-14 00:59:11'),
(11, 23, NULL, 1, 'upload', 'rejected', '2025-12-14 00:57:47', '2025-12-14 00:59:08'),
(12, 24, NULL, 1, 'upload', 'rejected', '2025-12-14 00:58:54', '2025-12-14 00:59:04'),
(13, 25, NULL, 1, 'upload', 'rejected', '2025-12-14 20:39:13', '2025-12-14 22:16:52'),
(14, 26, NULL, 1, 'upload', 'approved', '2025-12-14 20:51:24', '2025-12-14 20:53:56'),
(15, 27, NULL, 1, 'upload', 'rejected', '2025-12-14 21:53:22', '2025-12-14 22:16:56'),
(16, 28, NULL, 1, 'upload', 'rejected', '2025-12-14 21:56:31', '2025-12-14 22:17:01'),
(17, 29, NULL, 1, 'upload', 'rejected', '2025-12-14 21:59:45', '2025-12-14 22:17:11'),
(18, 30, NULL, 1, 'upload', 'rejected', '2025-12-14 22:15:47', '2025-12-14 22:17:19'),
(19, 29, 7, NULL, 'delete', 'approved', '2025-12-14 22:56:30', '2025-12-14 22:56:30'),
(20, 28, 7, NULL, 'delete', 'approved', '2025-12-14 22:56:35', '2025-12-14 22:56:35'),
(21, 30, 7, NULL, 'delete', 'approved', '2025-12-14 22:56:40', '2025-12-14 22:56:40'),
(22, 27, 7, NULL, 'delete', 'approved', '2025-12-14 22:56:46', '2025-12-14 22:56:46'),
(23, 26, 7, NULL, 'delete', 'approved', '2025-12-14 22:56:50', '2025-12-14 22:56:50'),
(24, 25, 7, NULL, 'delete', 'approved', '2025-12-14 22:56:55', '2025-12-14 22:56:55'),
(25, 24, 7, NULL, 'delete', 'approved', '2025-12-14 22:57:01', '2025-12-14 22:57:01'),
(26, 23, 7, NULL, 'delete', 'approved', '2025-12-14 22:57:06', '2025-12-14 22:57:06'),
(27, 22, 7, NULL, 'delete', 'approved', '2025-12-14 22:57:11', '2025-12-14 22:57:11'),
(28, 21, 7, NULL, 'delete', 'approved', '2025-12-14 22:57:16', '2025-12-14 22:57:16'),
(29, 20, 7, NULL, 'delete', 'approved', '2025-12-14 22:57:27', '2025-12-14 22:57:27'),
(30, 19, 7, NULL, 'delete', 'approved', '2025-12-14 22:57:32', '2025-12-14 22:57:32'),
(31, 18, 7, NULL, 'delete', 'approved', '2025-12-14 22:57:38', '2025-12-14 22:57:38'),
(32, 17, 7, NULL, 'delete', 'approved', '2025-12-14 22:57:44', '2025-12-14 22:57:44'),
(33, 16, 7, NULL, 'delete', 'approved', '2025-12-14 22:57:51', '2025-12-14 22:57:51'),
(34, 31, 7, NULL, 'upload', 'approved', '2025-12-14 23:00:56', '2025-12-14 23:00:56'),
(35, 32, 7, NULL, 'upload', 'approved', '2025-12-14 23:01:21', '2025-12-14 23:01:21'),
(36, 32, 7, NULL, 'delete', 'approved', '2025-12-14 23:01:27', '2025-12-14 23:01:27'),
(37, 31, 7, NULL, 'delete', 'approved', '2025-12-14 23:01:32', '2025-12-14 23:01:32'),
(38, 11, 7, NULL, 'delete', 'approved', '2025-12-14 23:01:38', '2025-12-14 23:01:38'),
(39, 15, 7, NULL, 'delete', 'approved', '2025-12-14 23:01:47', '2025-12-14 23:01:47'),
(40, 14, 7, NULL, 'delete', 'approved', '2025-12-14 23:01:51', '2025-12-14 23:01:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(7, 'Test User', 'test@example.com', NULL, '$2y$12$asBnd2iFg/2FDMWv1TjzS.t8V2Ix9I3c5uHQUAmoRuphkOX74A2i2', NULL, '2025-10-12 19:55:37', '2025-10-12 19:55:37');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_api_token_unique` (`api_token`);

--
-- Indeks untuk tabel `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `documents_client_id_foreign` (`client_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`(191));

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `upload_logs`
--
ALTER TABLE `upload_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `upload_logs_user_id_foreign` (`user_id`),
  ADD KEY `upload_logs_client_id_foreign` (`client_id`),
  ADD KEY `upload_logs_document_id_foreign` (`document_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `upload_logs`
--
ALTER TABLE `upload_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `documents_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
