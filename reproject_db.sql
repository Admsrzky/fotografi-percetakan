-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for reproject_db
CREATE DATABASE IF NOT EXISTS `reproject_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `reproject_db`;

-- Dumping structure for table reproject_db.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.cache: ~4 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('566f6eee35c4a211966f8f415bba2a0b', 'i:1;', 1754921771),
	('566f6eee35c4a211966f8f415bba2a0b:timer', 'i:1754921771;', 1754921771),
	('livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1753647123),
	('livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1753647123;', 1753647123);

-- Dumping structure for table reproject_db.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.cache_locks: ~0 rows (approximately)

-- Dumping structure for table reproject_db.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table reproject_db.jadwal
CREATE TABLE IF NOT EXISTS `jadwal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jasa_id` bigint unsigned DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `alasan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_jasa_id_foreign` (`jasa_id`),
  CONSTRAINT `jadwal_jasa_id_foreign` FOREIGN KEY (`jasa_id`) REFERENCES `jasa` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.jadwal: ~0 rows (approximately)

-- Dumping structure for table reproject_db.jasa
CREATE TABLE IF NOT EXISTS `jasa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_jasa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_jasa` text COLLATE utf8mb4_unicode_ci,
  `tipe_jasa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fotografi',
  `gambar_jasa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jasa_nama_jasa_unique` (`nama_jasa`),
  UNIQUE KEY `jasa_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.jasa: ~2 rows (approximately)
INSERT INTO `jasa` (`id`, `nama_jasa`, `slug`, `deskripsi_jasa`, `tipe_jasa`, `gambar_jasa`, `aktif`, `created_at`, `updated_at`) VALUES
	(1, 'Fotografi', 'fotografi', 'Fotografi adalah seni dan praktik menciptakan gambar dengan merekam cahaya, baik melalui sensor digital maupun film fotografi. Ini adalah cara yang ampuh untuk menangkap momen, menyampaikan cerita, dan mengekspresikan kreativitas.', 'fotografi', 'jasa/01K0F6CN7ED8M9RDHA86VJ4MMM.jpg', 1, '2025-07-18 09:37:59', '2025-07-18 09:37:59'),
	(2, 'Percetakan', 'percetakan', 'Percetakan adalah sebuah proses industri untuk memproduksi secara massal tulisan, gambar, atau desain dengan menggunakan tinta di atas berbagai media, paling umum adalah kertas, menggunakan sebuah mesin cetak. Ini adalah bagian krusial dalam penerbitan, periklanan, dan berbagai aspek kehidupan modern lainnya.', 'percetakan', 'jasa/01K0F6Q28BJAX6JPRE18VAB3V7.png', 1, '2025-07-18 09:43:40', '2025-07-18 09:43:40');

-- Dumping structure for table reproject_db.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.jobs: ~0 rows (approximately)

-- Dumping structure for table reproject_db.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.job_batches: ~0 rows (approximately)

-- Dumping structure for table reproject_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.migrations: ~15 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_07_16_170515_add_two_factor_columns_to_users_table', 1),
	(5, '2025_07_16_170539_create_personal_access_tokens_table', 1),
	(6, '2025_07_16_172204_create_jasa_table', 1),
	(7, '2025_07_16_172223_create_paket_table', 1),
	(8, '2025_07_16_172319_create_portofolio_table', 1),
	(9, '2025_07_16_172350_create_jadwal_table', 1),
	(10, '2025_07_16_172404_create_pemesanan_table', 1),
	(11, '2025_07_16_172500_create_rekening_banks_table', 1),
	(12, '2025_07_16_172517_create_pengaturan_situses_table', 1),
	(13, '2025_07_17_195619_add_bukti_pembayaran_to_pemesanan_table', 1),
	(14, '2025_07_21_214435_add_all_payment_columns_to_pemesanan_table', 2),
	(15, '2025_07_21_220656_update_decimal_columns_in_pemesanan_table', 3),
	(16, '2025_07_21_223008_update_decimal_columns_in_pemesanan_table', 4),
	(17, '2025_07_21_233553_add_bukti_pelunasan_to_pemesanans_table', 5);

-- Dumping structure for table reproject_db.paket
CREATE TABLE IF NOT EXISTS `paket` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jasa_id` bigint unsigned NOT NULL,
  `nama_paket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_paket` text COLLATE utf8mb4_unicode_ci,
  `harga_paket` bigint unsigned NOT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_durasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_output` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan_tampil` int NOT NULL DEFAULT '0',
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `paket_jasa_id_foreign` (`jasa_id`),
  CONSTRAINT `paket_jasa_id_foreign` FOREIGN KEY (`jasa_id`) REFERENCES `jasa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.paket: ~3 rows (approximately)
INSERT INTO `paket` (`id`, `jasa_id`, `nama_paket`, `deskripsi_paket`, `harga_paket`, `kategori`, `info_durasi`, `info_output`, `urutan_tampil`, `aktif`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Harmoni', 'Abadikan momen sakral dan indah di hari pernikahan Anda.', 800000, 'wedding', '<p>Fullday</p>', '<p>1 Fotografer</p><p>1 Lightning</p>', 1, 1, '2025-07-18 10:54:41', '2025-07-22 14:45:23'),
	(2, 1, 'Ultimate', 'Ciptakan Moment Prewedding Anda dengan Tangkapan yang estetik ', 1000000, 'prewedding', '<p>Durasi 3 - 4 Jam</p>', '<p>Test</p>', 1, 1, '2025-07-18 11:15:29', '2025-07-18 11:15:29'),
	(3, 1, 'Standard', 'test', 200000, 'photosekolah', '<p>test</p>', '<p>test</p>', 1, 1, '2025-07-18 12:57:04', '2025-07-18 12:57:04'),
	(4, 2, 'ID CARD STANDARD', 'Paket ini menawarkan solusi ekonomis untuk kebutuhan identitas dasar.', 10000, 'cetakidcard', '<p>Desain Template&nbsp; dasar (pilih dari beberapa opsi standar)</p><p>Bahan PVC standar</p><p>Proses produksi cepat (1-2 hari kerja)</p>', '<p>Cetak satu sisi</p>', 1, 1, '2025-07-18 12:58:17', '2025-07-22 14:53:08'),
	(5, 1, 'Ultimate', 'Paket dengan Kualitas Terjamin', 1500000, 'wedding', '<p>Full Day</p>', '<p>Camera Canon terbaru</p><p>2 Fotografer</p><p>2 Lightning</p><p>Flashdisk (backup file)</p>', 2, 1, '2025-07-22 14:44:46', '2025-07-22 14:46:03');

-- Dumping structure for table reproject_db.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table reproject_db.pemesanan
CREATE TABLE IF NOT EXISTS `pemesanan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pengguna_id` bigint unsigned DEFAULT NULL,
  `jasa_id` bigint unsigned NOT NULL,
  `paket_id` bigint unsigned DEFAULT NULL,
  `kategori_paket` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `subtotal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_harga` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dp_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `remaining_payment` decimal(15,2) NOT NULL DEFAULT '0.00',
  `bukti_pelunasan_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_pelunasan_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `tanggal_pelunasan` timestamp NULL DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pelanggan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_pelanggan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon_pelanggan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_acara` date DEFAULT NULL,
  `lokasi_acara` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_tambahan` text COLLATE utf8mb4_unicode_ci,
  `status_pemesanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pemesanan_pengguna_id_foreign` (`pengguna_id`),
  KEY `pemesanan_jasa_id_foreign` (`jasa_id`),
  KEY `pemesanan_paket_id_foreign` (`paket_id`),
  CONSTRAINT `pemesanan_jasa_id_foreign` FOREIGN KEY (`jasa_id`) REFERENCES `jasa` (`id`),
  CONSTRAINT `pemesanan_paket_id_foreign` FOREIGN KEY (`paket_id`) REFERENCES `paket` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pemesanan_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.pemesanan: ~4 rows (approximately)
INSERT INTO `pemesanan` (`id`, `pengguna_id`, `jasa_id`, `paket_id`, `kategori_paket`, `quantity`, `subtotal`, `total_harga`, `dp_amount`, `remaining_payment`, `bukti_pelunasan_path`, `is_pelunasan_confirmed`, `tanggal_pelunasan`, `payment_type`, `nama_pelanggan`, `email_pelanggan`, `telepon_pelanggan`, `tanggal_acara`, `lokasi_acara`, `catatan_tambahan`, `status_pemesanan`, `bukti_pembayaran`, `catatan_admin`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, 1, 'wedding', 1, 800000.00, 800000.00, 800000.00, 0.00, NULL, 0, NULL, 'full_payment', 'Reza Adya Pratama', 'rezaadya@gmail.com', '087887967328', '2025-07-22', 'Gedung Pernikahan Harmoni Jasa', 'bbb', 'selesai', 'bukti_pembayaran/nByRLz5iQqkvhEJvMOyiGUGqzCA5CLiLB7MkOaWE.jpg', NULL, '2025-07-21 17:01:10', '2025-07-22 10:24:13'),
	(3, 2, 1, 1, NULL, 1, 800000.00, 800000.00, 0.00, 800000.00, NULL, 1, '2025-07-27 12:26:39', 'dp', 'Reza Adya Pratama', 'rezaadya@gmail.com', '0896', '2025-07-25', 'Sebarguna', 'oke', 'selesai', 'bukti_pembayaran/AbQzYMt5yNpXvKzZy0CqDR7YrAKVaxvWWGyRf1Xz.jpg', NULL, '2025-07-22 23:04:29', '2025-07-27 12:34:27'),
	(4, 2, 2, 4, NULL, 1, 10000.00, 10000.00, 350.00, 9650.00, NULL, 1, '2025-07-27 13:15:22', 'dp', 'Reza Adya Pratama', 'rezaadya@gmail.com', '098776', '2025-07-31', 'ghjjjjkk', 'id card 2 sisi', 'menunggu', 'bukti_pembayaran/6Us79UgZfDA7AgHYV87QAnz6Z1C5wCmCzeczmxoQ.jpg', NULL, '2025-07-22 23:33:02', '2025-07-27 13:15:22'),
	(5, 2, 2, 4, NULL, 1, 10000.00, 10000.00, 5000.00, 5000.00, NULL, 0, NULL, 'dp', 'Reza Adya Pratama', 'rezaadya@gmail.com', '08877666', '2025-07-24', 'hjahjahajaalll', 'id card 1 sisi', 'menunggu', 'bukti_pembayaran/20IOUgnFrTKuDvcp9GuAMUg1fWLC7g9cXhpj3wUl.jpg', NULL, '2025-07-22 23:38:18', '2025-07-22 23:38:18');

-- Dumping structure for table reproject_db.pengaturan_situs
CREATE TABLE IF NOT EXISTS `pengaturan_situs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kunci` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` text COLLATE utf8mb4_unicode_ci,
  `tipe_data` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'teks',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengaturan_situs_kunci_unique` (`kunci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.pengaturan_situs: ~0 rows (approximately)

-- Dumping structure for table reproject_db.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table reproject_db.portofolio
CREATE TABLE IF NOT EXISTS `portofolio` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jasa_id` bigint unsigned DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar_utama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_galeri` json DEFAULT NULL,
  `tahun` int DEFAULT NULL,
  `unggulan` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `portofolio_jasa_id_foreign` (`jasa_id`),
  CONSTRAINT `portofolio_jasa_id_foreign` FOREIGN KEY (`jasa_id`) REFERENCES `jasa` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.portofolio: ~2 rows (approximately)
INSERT INTO `portofolio` (`id`, `jasa_id`, `judul`, `deskripsi`, `kategori`, `gambar_utama`, `gambar_galeri`, `tahun`, `unggulan`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Prewedding Anna & Haris', 'Prewedding Annaaaaaaaaa', 'fotografi', 'portofolio/utama/01K0F7QQWGEA1FS2P947D685E4.jpeg', '["portofolio/galeri/01K0F7QQWK6Z9SDPEW3DF9ETCH.jpg", "portofolio/galeri/01K0F7QQWNV9PQASP7PJ1Y2NPK.jpeg"]', 2022, 1, '2025-07-18 10:01:31', '2025-07-18 10:01:31'),
	(2, 2, 'ID Card SMP YPWKS', 'Tstssssss', 'percetakan', 'portofolio/utama/01K0F7V95QWS16PPM1AQ313RR1.jpg', '["portofolio/galeri/01K0F7V95TYXPQ11Z3RGY02H8R.jpg", "portofolio/galeri/01K0F7V95WJASYYR0FKDK7ATPF.jpg"]', 2025, 1, '2025-07-18 10:03:27', '2025-07-18 10:03:27');

-- Dumping structure for table reproject_db.rekening_bank
CREATE TABLE IF NOT EXISTS `rekening_bank` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_rekening` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atas_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_bank_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.rekening_bank: ~0 rows (approximately)

-- Dumping structure for table reproject_db.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('814WQvP68owEXRhM8dMoYkbUyWmYEujheReYNs8E', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZGpFaDQ0SGx5VGJ4MDR0Mkxob2xGd0NIQnQxQWdESFo0QThjRGc3VyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3BlbGFuZ2dhbnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJE45VXlKVVhKODFXcVEwb0JhU1E1VS43bFpRbkNlcTN2VzROWi5nbzl3T2NMTUpzMkxvQnVxIjt9', 1754920977),
	('t6r2RxlJJpNJST7dgxF3aEScOSV1RzOpFaxm687I', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSk1xbmFBbGdraE1JZEtPOW5nNzFQZlRFbUNmN2JnZlFueGpLN3gxeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW1lc2FuYW4iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEyJE45VXlKVVhKODFXcVEwb0JhU1E1VS43bFpRbkNlcTN2VzROWi5nbzl3T2NMTUpzMkxvQnVxIjt9', 1754921748);

-- Dumping structure for table reproject_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table reproject_db.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
	(1, 'Re Project', 'admin@gmail.com', 'admin', NULL, '$2y$12$tu9U1Yg6Z4rrAH5ZJYuyJeh8rATvyj/D/JOVdJsl3n3TWEf8KbnbG', NULL, NULL, NULL, NULL, NULL, 'profile/01K0SBHWF1R3SGT3S278W7W5AM.jpg', '2025-07-18 09:23:05', '2025-07-22 08:20:38'),
	(2, 'Reza Adya Pratama', 'rezaadya@gmail.com', 'user', NULL, '$2y$12$N9UyJUXJ81WqQ0oBaSQ5U.7lZQnCeq3vW4NZ.go9wOcLMJs2LoBuq', NULL, NULL, NULL, '9SaiPrsiRZ9B67mVUzYJeD8gFdkfVKi9PmN3ofpTBSzQ3GYSnjJuIG5BCEzc', NULL, 'profile/01K0SBNSP7SBR41Q7ZMY79Q1S9.jpg', '2025-07-21 08:14:35', '2025-07-22 13:49:10');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
