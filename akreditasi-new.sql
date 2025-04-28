-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 23, 2025 at 02:09 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akreditasi-new`
--

-- --------------------------------------------------------

--
-- Table structure for table `beban_kinerja_dosen`
--

CREATE TABLE `beban_kinerja_dosen` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nidn` int NOT NULL,
  `pengajaran` enum('Program studi sendiri','Program studi lain','Program studi diluar PT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `penelitian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pkm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penunjang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_sks` int NOT NULL,
  `rata_rata_sks` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluasi_pelaksanaan`
--

CREATE TABLE `evaluasi_pelaksanaan` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nomor_ptk` int NOT NULL,
  `kategori_ptk` enum('Mayor','Minor','Observasi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `rencana_penyelesaian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `realisasi_perbaikan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penanggungjawab_perbaikan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_settings`
--

CREATE TABLE `form_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `form_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_settings`
--

INSERT INTO `form_settings` (`id`, `form_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'visi misi', 1, NULL, '2025-02-14 07:34:12'),
(2, 'kerjasama pendidikan', 0, NULL, '2025-02-14 08:51:58'),
(3, 'kerjasama penelitian', 1, NULL, NULL),
(4, 'kerjasama pengabdian', 1, NULL, NULL),
(5, 'Beban Kinerja Dosen', 1, NULL, NULL),
(6, 'Evaluasi Pelaksanaan', 0, NULL, NULL),
(7, 'Profil Dosen', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kerjasama_pendidikan`
--

CREATE TABLE `kerjasama_pendidikan` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `lembaga_mitra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` enum('Internasional','Nasional','Lokal','') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_kegiatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_durasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `realisasi_kerjasama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `spk` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kerjasama_pendidikan`
--

INSERT INTO `kerjasama_pendidikan` (`id`, `user_id`, `lembaga_mitra`, `tingkat`, `judul_kegiatan`, `waktu_durasi`, `realisasi_kerjasama`, `spk`, `created_at`, `updated_at`) VALUES
(1, 1, 'PT.Mencari Cinta Sejati', 'Internasional', 'Makan Bersama', '1 Bulan', 'Lorem Ipsummmmm', 1, '2025-02-09 07:02:15', '2025-02-09 07:41:07');

-- --------------------------------------------------------

--
-- Table structure for table `kerjasama_penelitian`
--

CREATE TABLE `kerjasama_penelitian` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lembaga_mitra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` enum('internasional','nasional','lokal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_kerjasama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_durasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `realisasi_kerjasama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `spk` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kerjasama_pengabdian_kepada_masyarakat`
--

CREATE TABLE `kerjasama_pengabdian_kepada_masyarakat` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lembaga_mitra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` enum('internasional','nasional','lokal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_kerjasama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_durasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `realisasi_kerjasama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `spk` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_02_09_144453_create_kerjasama_penelitian_table', 2),
(5, '2025_02_09_154449_create_kerjasama_pengabdian_kepada_masyarakat_table', 3),
(6, '2025_02_14_124843_create_settings_table', 4),
(7, '2025_02_14_135655_create_form_settings_table', 5),
(8, '2025_02_12_113007_create_profil_dosen_table', 6),
(9, '2025_02_13_112442_create_evaluasi_pelaksanaan_table', 6),
(10, '2025_02_14_121636_create_beban_kinerja_dosen_table', 6),
(11, '2025_02_14_131647_create_profil_dosen_tidak_tetap_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profil_dosen`
--

CREATE TABLE `profil_dosen` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kualifikasi_pendidikan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sertifikasi_pendidik_profesional` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bidang_keahlian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang_ilmu_prodi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profil_dosen_tidak_tetap`
--

CREATE TABLE `profil_dosen_tidak_tetap` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asal_instansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kualifikasi_pendidikan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sertifikasi_pendidik_profesional` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sertifikat_kompetensi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang_keahlian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kesesuaian_bidang_ilmu_prodi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('AT04uyKfOO0eGbzPt23vr3YCheIbqCYOMZWS9SVh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Edg/133.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0ZhcG5jTEk2dXNOaXdmcnV1b2Faczg5N0xMbjJrQWJJTVFVV1lGRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly90YS1ha3JlZGl0YXNpLnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1740229947),
('HUXpOFhjm4uSsCDUV0XpqAzRdShbarXI3Gnj8Ldv', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Edg/133.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibjFnRWVCVnFIVTdGT21wWkNPSmhISFZyck9qQk9NN2toaEdRSkNkTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly90YS1ha3JlZGl0YXNpLnRlc3QvYWRtaW4vZm9ybXMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1739551949),
('wL47vLHKTIrEsZWY21zkYQyJlavpaHJWb6y1bPnZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Edg/133.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUU1aDZqMUVWSzZmRWlvQll4OExNVDVtQnN5dEdkdzFrRldXRWF3WiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly90YS1ha3JlZGl0YXNpLnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1739622920),
('yVWEx8NDVDibVOYX77VTSLJwkr4KqLPsaAGZkKky', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Edg/133.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0liUUlHb0VmbktHNEdaU1VQSURyaHhaeEsyQVlwWm40Z0VnV3pocyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly90YS1ha3JlZGl0YXNpLnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1739688074);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `form_status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `form_status`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-02-14 13:15:53', '2025-02-14 06:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usertype` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `usertype`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Teknik Informatika', 'user@gmail.com', 'user', NULL, '$2y$12$QJVguMtopx88AUpCy.JBmugcUY0HZyT1O/VKG05.doez9Xxdd9.Hq', NULL, '2025-02-05 05:39:18', '2025-02-05 05:39:18'),
(2, 'Admin', 'admin@gmail.com', 'admin', NULL, '$2y$12$dsHHwvvQUnOSQK1ZTrvKf.mt7egBxV3mQ7KqdfnS5NZe4gG50yqdq', NULL, '2025-02-05 05:40:10', '2025-02-05 05:40:10'),
(3, 'Akuntansi', 'user1@gmail.com', 'user', NULL, '$2y$12$5IH82wvheh8Czj32zNFlnu/BO.cE41/UkcxzsjYdH1kTk0Wv/9jSG', NULL, '2025-02-08 08:39:10', '2025-02-13 09:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `visi_misi`
--

CREATE TABLE `visi_misi` (
  `id` int NOT NULL,
  `visi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `misi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visi_misi`
--

INSERT INTO `visi_misi` (`id`, `visi`, `misi`, `deskripsi`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'menjadi perguruan tinggi dengan reputasi internasional dalam ilmu pengetahuan, teknologi', 'Menyelenggarakan proses pembelajaran yang berkualitas, dan memenuhi standar nasional maupun internasional,', 'Menghasilkan lulusan yang kompeten di bidang Informatika, serta memiliki daya saing dan kemandirian untuk berkompetisi di tingkat nasional dan internasional,', 1, '2025-02-09 10:12:40', '2025-02-10 01:59:10'),
(3, 'berfokus untuk menjadi lembaga pendidikan yang unggul dan inovatif-inventif dalam informatika cerdas, mendukung transformasi digital dan berkontribusi kepada masyarakat dengan reputasi internasional.', 'Melaksanakan penelitian yang inovatif, bermutu, dan bermanfaat,', 'Menghasilkan karya penelitian yang inovatif dan bermanfaat bagi masyarakat, serta publikasi di jurnal nasional ataupun internasional bereputasi', 3, '2025-02-09 03:29:23', '2025-02-10 02:00:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beban_kinerja_dosen`
--
ALTER TABLE `beban_kinerja_dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beban_kinerja_dosen_user_id_foreign` (`user_id`);

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
-- Indexes for table `evaluasi_pelaksanaan`
--
ALTER TABLE `evaluasi_pelaksanaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluasi_pelaksanaan_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `form_settings`
--
ALTER TABLE `form_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `form_settings_form_name_unique` (`form_name`);

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
-- Indexes for table `kerjasama_pendidikan`
--
ALTER TABLE `kerjasama_pendidikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kerjasama_pendidikan_user_id` (`user_id`);

--
-- Indexes for table `kerjasama_penelitian`
--
ALTER TABLE `kerjasama_penelitian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kerjasama_penelitian_user_id_foreign` (`user_id`);

--
-- Indexes for table `kerjasama_pengabdian_kepada_masyarakat`
--
ALTER TABLE `kerjasama_pengabdian_kepada_masyarakat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kerjasama_pengabdian_kepada_masyarakat_user_id_foreign` (`user_id`);

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
-- Indexes for table `profil_dosen`
--
ALTER TABLE `profil_dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profil_dosen_user_id_foreign` (`user_id`);

--
-- Indexes for table `profil_dosen_tidak_tetap`
--
ALTER TABLE `profil_dosen_tidak_tetap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profil_dosen_tidak_tetap_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visi_misi`
--
ALTER TABLE `visi_misi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beban_kinerja_dosen`
--
ALTER TABLE `beban_kinerja_dosen`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evaluasi_pelaksanaan`
--
ALTER TABLE `evaluasi_pelaksanaan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_settings`
--
ALTER TABLE `form_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kerjasama_pendidikan`
--
ALTER TABLE `kerjasama_pendidikan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kerjasama_penelitian`
--
ALTER TABLE `kerjasama_penelitian`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kerjasama_pengabdian_kepada_masyarakat`
--
ALTER TABLE `kerjasama_pengabdian_kepada_masyarakat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `profil_dosen`
--
ALTER TABLE `profil_dosen`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profil_dosen_tidak_tetap`
--
ALTER TABLE `profil_dosen_tidak_tetap`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `visi_misi`
--
ALTER TABLE `visi_misi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beban_kinerja_dosen`
--
ALTER TABLE `beban_kinerja_dosen`
  ADD CONSTRAINT `beban_kinerja_dosen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `evaluasi_pelaksanaan`
--
ALTER TABLE `evaluasi_pelaksanaan`
  ADD CONSTRAINT `evaluasi_pelaksanaan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kerjasama_penelitian`
--
ALTER TABLE `kerjasama_penelitian`
  ADD CONSTRAINT `kerjasama_penelitian_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kerjasama_pengabdian_kepada_masyarakat`
--
ALTER TABLE `kerjasama_pengabdian_kepada_masyarakat`
  ADD CONSTRAINT `kerjasama_pengabdian_kepada_masyarakat_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profil_dosen`
--
ALTER TABLE `profil_dosen`
  ADD CONSTRAINT `profil_dosen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profil_dosen_tidak_tetap`
--
ALTER TABLE `profil_dosen_tidak_tetap`
  ADD CONSTRAINT `profil_dosen_tidak_tetap_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
