-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Agu 2025 pada 16.32
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `progresproject`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bagian_id` bigint(20) UNSIGNED NOT NULL,
  `no_wbs` varchar(50) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `aktivitas`
--

INSERT INTO `aktivitas` (`id`, `bagian_id`, `no_wbs`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '121212', 'Luhut', '2025-08-11 21:18:18', '2025-08-11 21:18:18', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bagian`
--

CREATE TABLE `bagian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bagian`
--

INSERT INTO `bagian` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'King', '2025-08-11 01:54:29', '2025-08-11 01:54:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jam_kerja`
--

CREATE TABLE `jam_kerja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_profile_id` bigint(20) UNSIGNED NOT NULL,
  `no_wbs` varchar(50) DEFAULT NULL,
  `kode_proyek` varchar(50) DEFAULT NULL,
  `proyek_id` bigint(20) UNSIGNED DEFAULT NULL,
  `Aktivitas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jumlah_jam` decimal(5,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mode_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jam_kerja`
--

INSERT INTO `jam_kerja` (`id`, `user_profile_id`, `no_wbs`, `kode_proyek`, `proyek_id`, `Aktivitas_id`, `tanggal`, `jumlah_jam`, `keterangan`, `status_id`, `mode_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, '2121313', '12564', NULL, 1, '2025-08-12', 4.60, 'Burhan tidur saat jam kerja', 1, 2, '2025-08-11 22:52:12', '2025-08-11 22:52:12', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jam_per_tanggal`
--

CREATE TABLE `jam_per_tanggal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_profile_id` bigint(20) UNSIGNED NOT NULL,
  `proyek_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jam_per_tanggal`
--

INSERT INTO `jam_per_tanggal` (`id`, `user_profile_id`, `proyek_id`, `tanggal`, `jam`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2025-08-12', 7.50, '2025-08-11 20:16:26', '2025-08-11 20:16:26', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pesan`
--

CREATE TABLE `jenis_pesan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jenis_pesan`
--

INSERT INTO `jenis_pesan` (`id`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'dari siswa', '2025-08-11 20:29:39', '2025-08-11 20:29:39', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `keterangan`
--

CREATE TABLE `keterangan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bagian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proyek_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lembur`
--

CREATE TABLE `lembur` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_profile_id` bigint(20) UNSIGNED NOT NULL,
  `proyek_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lembur`
--

INSERT INTO `lembur` (`id`, `user_profile_id`, `proyek_id`, `tanggal`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2025-08-12', '2025-08-11 19:49:34', '2025-08-11 19:49:34', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `levels`
--

INSERT INTO `levels` (`id`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super root magang', '2025-08-11 00:28:39', '2025-08-11 00:44:37', NULL),
(2, 'Super root', '2025-08-11 00:38:21', '2025-08-11 00:38:21', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, 'create_status_table', 2),
(6, 'create_level_table', 3),
(7, 'create_bagian_table', 4),
(8, '2025_08_11_090842_create_proyek_table', 5),
(9, '2025_08_12_021350_create_lembur_table', 6),
(10, '2025_08_12_013206_create_keterangan_table', 7),
(11, '2025_08_11_080552_create_user_profile_table', 8),
(12, '2025_08_12_025303_create_proyek_user_table', 9),
(13, '2025_08_12_030435_create_jam_per_tanggal_table', 10),
(14, '2025_08_12_032154_create_jenis_pesan_table', 11),
(15, '2025_08_12_033108_create_pesan_table', 12),
(16, '2025_08_12_040933_create_aktivitas_table', 13),
(17, '2025_08_12_042157_create_mode_jam_kerja_table', 14),
(18, '2025_08_12_043133_create_status_jam_kerja_table', 15),
(19, '2025_08_12_043925_create_jam_kerja_table', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mode_jam_kerja`
--

CREATE TABLE `mode_jam_kerja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mode_jam_kerja`
--

INSERT INTO `mode_jam_kerja` (`id`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'mode serius', '2025-08-11 21:30:24', '2025-08-11 21:30:24', NULL),
(3, 'mode off', '2025-08-11 21:30:41', '2025-08-11 21:30:41', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE `pesan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengirim` varchar(100) DEFAULT NULL,
  `penerima` varchar(100) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `tgl_pesan` datetime DEFAULT NULL,
  `jenis_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesan`
--

INSERT INTO `pesan` (`id`, `pengirim`, `penerima`, `isi`, `parent_id`, `tgl_pesan`, `jenis_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sugeng', 'Burhan', 'Halo pak burhan, ini mahkotamu yang ketinggalan itu', 1, '2025-08-12 10:30:00', 1, '2025-08-11 21:04:04', '2025-08-11 21:04:04', NULL),
(2, 'Sugeng', 'Burhan', 'Halo pak burhan, ini mahkotamu yang ketinggalan itu', 1, '2025-08-12 10:30:00', 1, '2025-08-11 21:04:57', '2025-08-11 21:04:57', NULL),
(3, 'Sugeng', 'Burhan', 'Halo pak burhan, ini mahkotamu yang ketinggalan itu', 1, '2025-08-12 10:30:00', 1, '2025-08-11 21:05:15', '2025-08-11 21:05:15', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `proyek`
--

CREATE TABLE `proyek` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `nama_sekolah` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `proyek`
--

INSERT INTO `proyek` (`id`, `kode`, `nama`, `tanggal`, `nama_sekolah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '123', 'Kartel', '2025-08-12', 'SMKN7 Batam', '2025-08-11 18:02:38', '2025-08-11 18:02:38', NULL),
(2, '123', 'Bandar', '2025-08-12', 'SMKN7 Batam', '2025-08-11 18:03:54', '2025-08-11 18:03:54', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `proyek_user`
--

CREATE TABLE `proyek_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proyek_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_profile_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `proyek_user`
--

INSERT INTO `proyek_user` (`id`, `proyek_id`, `user_profile_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2025-08-11 20:02:23', '2025-08-11 20:02:23', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `statuses`
--

INSERT INTO `statuses` (`id`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Selesai', '2025-08-11 00:30:28', '2025-08-11 00:30:28', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_jam_kerja`
--

CREATE TABLE `status_jam_kerja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `status_jam_kerja`
--

INSERT INTO `status_jam_kerja` (`id`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Selesai', '2025-08-11 21:38:30', '2025-08-11 21:38:30', NULL),
(2, 'Belum Selesai', '2025-08-11 21:38:37', '2025-08-11 21:38:37', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Kinga', 'asep@gmail.com', NULL, '$2y$10$oRsRyclhmFs3TUTaWF0Ooug6myod4m.0CuxBtK7Cvqyd80b1hozmG', NULL, '2025-08-11 02:00:18', '2025-08-11 02:00:18', NULL),
(2, 'Galang', 'galang88@gmail.com', NULL, '$2y$10$JGMHjoxwVFc7GXc.A5Zng.6u2dFS2OgJbRgR0wCpkU81JZJqaAFym', NULL, '2025-08-12 02:15:35', '2025-08-12 02:15:35', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_profile`
--

CREATE TABLE `user_profile` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `nrp` varchar(20) DEFAULT NULL,
  `alamat` varchar(225) DEFAULT NULL,
  `foto` varchar(250) DEFAULT NULL,
  `level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bagian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `nama_lengkap`, `nrp`, `alamat`, `foto`, `level_id`, `status_id`, `bagian_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Asep Sinaga', '12345', 'Jl. Sudirman', 'Asep.jpg', 1, 1, 1, '2025-08-11 19:47:06', '2025-08-11 19:47:06', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aktivitas_bagian_id_foreign` (`bagian_id`);

--
-- Indeks untuk tabel `bagian`
--
ALTER TABLE `bagian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jam_kerja`
--
ALTER TABLE `jam_kerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jam_kerja_user_profile_id_foreign` (`user_profile_id`),
  ADD KEY `jam_kerja_proyek_id_foreign` (`proyek_id`),
  ADD KEY `jam_kerja_aktivitas_id_foreign` (`Aktivitas_id`),
  ADD KEY `jam_kerja_status_id_foreign` (`status_id`),
  ADD KEY `jam_kerja_mode_id_foreign` (`mode_id`);

--
-- Indeks untuk tabel `jam_per_tanggal`
--
ALTER TABLE `jam_per_tanggal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jam_per_tanggal_user_profile_id_foreign` (`user_profile_id`),
  ADD KEY `jam_per_tanggal_proyek_id_foreign` (`proyek_id`);

--
-- Indeks untuk tabel `jenis_pesan`
--
ALTER TABLE `jenis_pesan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keterangan`
--
ALTER TABLE `keterangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keterangan_bagian_id_foreign` (`bagian_id`),
  ADD KEY `keterangan_proyek_id_foreign` (`proyek_id`);

--
-- Indeks untuk tabel `lembur`
--
ALTER TABLE `lembur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lembur_user_profile_id_foreign` (`user_profile_id`),
  ADD KEY `lembur_proyek_id_foreign` (`proyek_id`);

--
-- Indeks untuk tabel `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `levels_nama_unique` (`nama`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mode_jam_kerja`
--
ALTER TABLE `mode_jam_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesan_jenis_id_foreign` (`jenis_id`);

--
-- Indeks untuk tabel `proyek`
--
ALTER TABLE `proyek`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `proyek_user`
--
ALTER TABLE `proyek_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proyek_user_proyek_id_foreign` (`proyek_id`),
  ADD KEY `proyek_user_user_profile_id_foreign` (`user_profile_id`);

--
-- Indeks untuk tabel `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `statuses_nama_unique` (`nama`);

--
-- Indeks untuk tabel `status_jam_kerja`
--
ALTER TABLE `status_jam_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profile_user_id_foreign` (`user_id`),
  ADD KEY `user_profile_level_id_foreign` (`level_id`),
  ADD KEY `user_profile_status_id_foreign` (`status_id`),
  ADD KEY `user_profile_bagian_id_foreign` (`bagian_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `bagian`
--
ALTER TABLE `bagian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jam_kerja`
--
ALTER TABLE `jam_kerja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jam_per_tanggal`
--
ALTER TABLE `jam_per_tanggal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jenis_pesan`
--
ALTER TABLE `jenis_pesan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `keterangan`
--
ALTER TABLE `keterangan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lembur`
--
ALTER TABLE `lembur`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `mode_jam_kerja`
--
ALTER TABLE `mode_jam_kerja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `proyek`
--
ALTER TABLE `proyek`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `proyek_user`
--
ALTER TABLE `proyek_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `status_jam_kerja`
--
ALTER TABLE `status_jam_kerja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD CONSTRAINT `aktivitas_bagian_id_foreign` FOREIGN KEY (`bagian_id`) REFERENCES `bagian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jam_kerja`
--
ALTER TABLE `jam_kerja`
  ADD CONSTRAINT `jam_kerja_aktivitas_id_foreign` FOREIGN KEY (`Aktivitas_id`) REFERENCES `aktivitas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `jam_kerja_mode_id_foreign` FOREIGN KEY (`mode_id`) REFERENCES `mode_jam_kerja` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `jam_kerja_proyek_id_foreign` FOREIGN KEY (`proyek_id`) REFERENCES `proyek` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `jam_kerja_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `status_jam_kerja` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `jam_kerja_user_profile_id_foreign` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jam_per_tanggal`
--
ALTER TABLE `jam_per_tanggal`
  ADD CONSTRAINT `jam_per_tanggal_proyek_id_foreign` FOREIGN KEY (`proyek_id`) REFERENCES `proyek` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `jam_per_tanggal_user_profile_id_foreign` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `keterangan`
--
ALTER TABLE `keterangan`
  ADD CONSTRAINT `keterangan_bagian_id_foreign` FOREIGN KEY (`bagian_id`) REFERENCES `bagian` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `keterangan_proyek_id_foreign` FOREIGN KEY (`proyek_id`) REFERENCES `proyek` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lembur`
--
ALTER TABLE `lembur`
  ADD CONSTRAINT `lembur_proyek_id_foreign` FOREIGN KEY (`proyek_id`) REFERENCES `proyek` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `lembur_user_profile_id_foreign` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD CONSTRAINT `pesan_jenis_id_foreign` FOREIGN KEY (`jenis_id`) REFERENCES `jenis_pesan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `proyek_user`
--
ALTER TABLE `proyek_user`
  ADD CONSTRAINT `proyek_user_proyek_id_foreign` FOREIGN KEY (`proyek_id`) REFERENCES `proyek` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `proyek_user_user_profile_id_foreign` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_bagian_id_foreign` FOREIGN KEY (`bagian_id`) REFERENCES `bagian` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_profile_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_profile_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_profile_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
