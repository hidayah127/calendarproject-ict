-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 17, 2026 at 02:09 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uptmprogramdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'super_admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'hidayah_burhannudin@uptm.edu.my', '$2y$12$w.ZYjc/3naJxTZn09eWZ.eHB.XkaleaP.uUq1LWhLfqaWAeZRwmeO', 'super_admin', '2026-04-16 06:50:31', '2026-04-16 06:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Teknologi Maklumat & Komunikasi', 'ICT', NULL, '2026-03-08 18:58:05', '2026-04-02 01:34:22'),
(2, 'Pejabat Bursar', 'Bursar', NULL, '2026-03-10 04:02:42', '2026-04-02 01:26:43'),
(7, 'Pejabat Canselori', 'Canselori', NULL, '2026-04-02 01:28:04', '2026-04-02 01:28:04'),
(8, 'Unit Jaminan dan Kualiti', 'Kualiti', NULL, '2026-04-02 01:32:59', '2026-04-02 01:32:59'),
(9, 'Unit Sekretariat & Komunikasi Korporat', 'SCC', NULL, '2026-04-02 01:33:21', '2026-04-02 01:33:21'),
(10, 'Jabatan Pemasaran & Pengambilan Pelajar', 'MaSR', NULL, '2026-04-02 01:34:38', '2026-04-02 01:34:38'),
(11, 'Pejabat Timbalan Naib Canselor Akademik & Pengantarabangsaan', 'TNCAA', NULL, '2026-04-02 01:35:12', '2026-04-02 01:35:12'),
(12, 'Fakulti Perniagaan & Perakaunan', 'FABA', NULL, '2026-04-02 01:35:25', '2026-04-02 01:35:25'),
(13, 'Fakulti Pendidikan, Sains Sosial & Kemanusiaan', 'FESSH', NULL, '2026-04-02 01:35:37', '2026-04-02 01:35:37'),
(14, 'Fakulti Pengkomputeran & Multimedia', 'FCOM', NULL, '2026-04-02 01:35:51', '2026-04-02 01:35:51'),
(15, 'Instiut Pengajian Profesional', 'IPS', NULL, '2026-04-02 01:36:01', '2026-04-02 01:36:01'),
(16, 'Institut Pengajian Siswazah', 'IGS', NULL, '2026-04-02 01:37:02', '2026-04-02 01:37:02'),
(17, 'Pusat Pengajian Islam, Umum & Bahasa', 'CIGLS', NULL, '2026-04-02 01:37:17', '2026-04-02 01:37:17'),
(18, 'Pusat Sumber Maklumat', 'IRC', NULL, '2026-04-02 01:37:29', '2026-04-02 01:37:29'),
(19, 'Kecemerlangan Akademik', 'AES', NULL, '2026-04-02 01:37:40', '2026-04-02 01:37:40'),
(20, 'Hal Ehwal Akademik', 'AAS', NULL, '2026-04-02 01:37:50', '2026-04-02 01:37:50'),
(21, 'Jaringan Industri & Pengantarabangsaan Akademik', 'ILAI', NULL, '2026-04-02 01:38:22', '2026-04-02 01:38:22'),
(22, 'Pejabat Timbalan Naib Canselor Hal Ehwal Pelajar & Alumni', 'TNCHEPA', NULL, '2026-04-02 01:38:35', '2026-04-02 01:38:35'),
(23, 'Jabatan Kaunseling, Kerjaya & Alumni', 'Kaunseling', NULL, '2026-04-02 01:38:47', '2026-04-02 01:38:47'),
(24, 'Jabatan Kemudahan & Kebajikan Pelajar', 'Kebajikan', NULL, '2026-04-02 01:39:01', '2026-04-02 01:39:01'),
(25, 'Jabatan Ko-kurikulum & Keusahawanan', 'Ko-kurikulum', NULL, '2026-04-02 01:39:21', '2026-04-02 01:39:21'),
(26, 'Pejabat Timbalan Naib Canselor Penyelidikan & Inovasi', 'TNCP', NULL, '2026-04-02 01:40:26', '2026-04-02 01:40:26'),
(27, 'Pusat Pengurusan Penyelidikan', 'RMC', NULL, '2026-04-02 01:40:43', '2026-04-02 01:40:43'),
(28, 'Jabatan Konsultasi & Penerbitan Inovasi', 'Penerbitan', NULL, '2026-04-02 01:41:31', '2026-04-02 01:41:31'),
(29, 'Institut Kajian Ekonomi Bumiputera', 'IKEB', NULL, '2026-04-02 01:41:44', '2026-04-02 01:41:44'),
(30, 'Pejabat Pendaftar', 'Pendaftar', NULL, '2026-04-02 01:42:04', '2026-04-02 01:42:04'),
(31, 'Sumber Manusia', 'HR', NULL, '2026-04-02 01:42:29', '2026-04-02 01:42:29'),
(32, 'Pentadbiran & Pengurusan Aset', 'Admin', NULL, '2026-04-02 01:42:45', '2026-04-02 01:42:45'),
(33, 'Tadbir Urus & Sekretariat Universiti', 'Sekritariat', NULL, '2026-04-02 01:43:02', '2026-04-02 01:43:02'),
(34, 'Sekretariat Senat', 'Senat', NULL, '2026-04-02 01:43:13', '2026-04-02 01:43:13'),
(35, 'Pengurusan Akaun Pelajar', 'Akaun Pelajar', NULL, '2026-04-02 01:43:33', '2026-04-02 01:43:48'),
(36, 'Penajaan', 'Penajaan', NULL, '2026-04-02 01:44:12', '2026-04-02 01:44:12'),
(37, 'Operasi Akaun Umum', 'Akaun Umum', NULL, '2026-04-02 01:44:30', '2026-04-02 01:44:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merit_claims`
--

CREATE TABLE `merit_claims` (
  `id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint UNSIGNED NOT NULL,
  `program_id` bigint UNSIGNED NOT NULL,
  `claim_type` enum('attendee','committee_member','committee_head','coordinator','secretary','treasurer','facilitator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'attendee',
  `merit_points` int NOT NULL DEFAULT '0',
  `proof_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proof_original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merit_claims`
--

INSERT INTO `merit_claims` (`id`, `staff_id`, `program_id`, `claim_type`, `merit_points`, `proof_path`, `proof_original_name`, `status`, `rejection_reason`, `reviewed_at`, `reviewed_by`, `created_at`, `updated_at`) VALUES
(1, 1, 20, 'attendee', 1, 'merit-proofs/HXr91ZVrTc7UOMj04JDZkG2lsu45UE4j2qGXWn2m.pdf', 'DFo_6_1_sg.pdf', 'approved', NULL, '2026-04-06 02:28:52', 8, '2026-03-31 08:28:13', '2026-04-06 02:28:52'),
(2, 5, 20, 'treasurer', 4, 'merit-proofs/qmQy9VFwniO2S86jdPsAvdbzD3Z56XK7bJlIN5DV.pdf', 'DFo_6_1_sg.pdf', 'approved', NULL, '2026-04-13 04:26:33', 8, '2026-04-01 01:12:24', '2026-04-13 04:26:33'),
(3, 5, 20, 'committee_member', 3, 'merit-proofs/Ns2jAi4R0CMJLPyqfcC7iOj0B8PzlC7QchbAuFIi.pdf', 'DFo_6_1_sg.pdf', 'approved', NULL, '2026-04-01 02:59:09', 8, '2026-04-01 01:52:47', '2026-04-01 02:59:09'),
(5, 1, 20, 'treasurer', 4, 'merit-proofs/4him1WBKgXRAfRi5DIeN6EXpo30XnTzpJQXGrKMZ.png', 'amazingcalendar.png', 'approved', NULL, '2026-04-06 02:28:47', 8, '2026-04-06 02:27:22', '2026-04-06 02:28:47'),
(6, 1, 21, 'attendee', 1, 'merit-proofs/vUrSqkMcTVdLTPxXKEaajE5oDfioPliUtivcgMIo.png', 'logo-sdg-baru.png', 'approved', NULL, '2026-04-13 04:26:09', 8, '2026-04-08 09:01:25', '2026-04-13 04:26:09'),
(7, 13, 21, 'attendee', 1, 'merit-proofs/YtZzxCyvTlmaCfFRMZMnrbYp6T7ryGFNkU55mWtp.png', 'ALP-LOGO-PLATINUM.png', 'approved', NULL, '2026-04-13 04:26:27', 8, '2026-04-13 03:51:46', '2026-04-13 04:26:27'),
(8, 13, 20, 'committee_member', 3, 'merit-proofs/3oGSv5I7cPTMJOgJZjeVEfAOi8lum5C8ju42t5gW.jpg', '1685610433080.jpg', 'rejected', 'Rejected in bulk review.', '2026-04-13 04:27:47', 8, '2026-04-13 04:27:09', '2026-04-13 04:27:47'),
(16, 11, 21, 'attendee', 1, 'merit-proofs/60YLBPx0HfGiskLHxjJIc08SGWhXDDItUO4nQdxA.jpg', 'IMG_3494-300x225.jpg', 'rejected', 'Approval reversed by reviewer.', '2026-04-17 01:52:07', 8, '2026-04-17 01:50:45', '2026-04-17 01:52:07');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2026_02_26_015439_create_departments_table', 1),
(5, '2026_02_26_015511_create_staffs_table', 1),
(6, '2026_02_26_015541_create_users_table', 1),
(7, '2026_02_26_015613_create_programs_table', 1),
(8, '2026_03_10_004742_update_status_enum_in_programs_table', 2),
(9, '2026_03_10_110942_create_notifications_table', 3),
(10, '2026_03_11_131303_add_reset_token_to_users_table', 4),
(11, '2026_03_17_085018_create_program_staff_table', 5),
(12, '2026_03_31_143105_create_merit_claims_table', 6),
(13, '2026_04_07_163739_update_users_role_enum', 7),
(14, '2026_04_16_144241_create_admins_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fa-bell',
  `icon_bg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#eff6ff',
  `icon_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1d4ed8',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `message`, `url`, `icon`, `icon_bg`, `icon_color`, `read_at`, `created_at`, `updated_at`) VALUES
(7, 6, 'program_created', 'New program added: \"solat sunat hajat\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', '2026-03-10 06:37:44', '2026-03-10 06:35:55', '2026-03-10 06:37:44'),
(11, 6, 'program_created', 'New program added: \"Solat Terawih\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', '2026-03-10 06:37:44', '2026-03-10 06:37:29', '2026-03-10 06:37:44'),
(15, 6, 'program_created', 'New program added: \"jtyjt\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', '2026-03-10 08:02:55', '2026-03-10 07:08:45', '2026-03-10 08:02:55'),
(19, 6, 'program_created', 'New program added: \"gwegwe\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', '2026-03-11 03:27:19', '2026-03-11 01:40:55', '2026-03-11 03:27:19'),
(23, 6, 'program_created', 'New program added: \"hbgi\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', '2026-03-11 03:27:19', '2026-03-11 01:42:47', '2026-03-11 03:27:19'),
(27, 6, 'program_completed', 'Program \"jjj\" has been completed.', 'http://localhost/vc/programs', 'fa-circle-check', '#e0e7ff', '#4338ca', '2026-03-11 03:27:19', '2026-03-11 02:20:15', '2026-03-11 03:27:19'),
(31, 6, 'program_completed', 'Program \"Solat Terawih\" has been completed.', 'http://localhost/vc/programs', 'fa-circle-check', '#e0e7ff', '#4338ca', '2026-03-11 03:27:19', '2026-03-11 02:20:15', '2026-03-11 03:27:19'),
(35, 6, 'program_completed', 'Program \"gwegwe\" has been completed.', 'http://localhost/vc/programs', 'fa-circle-check', '#e0e7ff', '#4338ca', '2026-03-11 03:27:19', '2026-03-11 02:20:15', '2026-03-11 03:27:19'),
(39, 6, 'program_rescheduled', 'Program \"fdsgerhrtj\" has been rescheduled.', 'http://127.0.0.1:8000/vc/programs', 'fa-clock-rotate-left', '#fef9c3', '#b45309', '2026-03-11 03:27:19', '2026-03-11 02:43:24', '2026-03-11 03:27:19'),
(43, 6, 'program_completed', 'Program \"hbgi\" has been completed.', 'http://localhost/vc/programs', 'fa-circle-check', '#e0e7ff', '#4338ca', '2026-03-11 03:27:19', '2026-03-11 02:50:20', '2026-03-11 03:27:19'),
(47, 6, 'program_created', 'New program added: \"guguk\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', '2026-03-11 03:27:19', '2026-03-11 03:02:37', '2026-03-11 03:27:19'),
(51, 6, 'program_rescheduled', 'Program \"solat sunat hajat\" has been rescheduled.', 'http://127.0.0.1:8000/vc/programs', 'fa-clock-rotate-left', '#fef9c3', '#b45309', '2026-03-11 03:27:19', '2026-03-11 03:03:28', '2026-03-11 03:27:19'),
(55, 6, 'program_created', 'New program added: \"testing\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', '2026-03-17 07:17:16', '2026-03-13 01:56:48', '2026-03-17 07:17:16'),
(59, 6, 'program_cancelled', 'Program \"testing\" has been cancelled.', 'http://127.0.0.1:8000/vc/programs', 'fa-ban', '#fee2e2', '#b91c1c', '2026-03-17 07:17:16', '2026-03-13 01:57:51', '2026-03-17 07:17:16'),
(63, 6, 'program_created', 'New program added: \"hari minggu\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', '2026-03-17 07:17:16', '2026-03-17 05:05:59', '2026-03-17 07:17:16'),
(67, 6, 'program_created', 'New program added: \"hari minggu 2\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', '2026-03-17 07:17:16', '2026-03-17 05:08:06', '2026-03-17 07:17:16'),
(71, 6, 'program_created', 'New program added: \"Program Testing\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', NULL, '2026-03-30 04:45:29', '2026-03-30 04:45:29'),
(72, 8, 'program_created', 'Your program \"Program Testing\" has been created successfully.', 'http://127.0.0.1:8000/head/programs', 'fa-circle-check', '#dcfce7', '#15803d', '2026-04-01 02:59:24', '2026-03-30 04:45:29', '2026-04-01 02:59:24'),
(75, 6, 'program_created', 'New program added: \"Program Hari Minggu\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', NULL, '2026-04-06 02:32:39', '2026-04-06 02:32:39'),
(76, 8, 'program_created', 'Your program \"Program Hari Minggu\" has been created successfully.', 'http://127.0.0.1:8000/head/programs', 'fa-circle-check', '#dcfce7', '#15803d', NULL, '2026-04-06 02:32:39', '2026-04-06 02:32:39'),
(77, 6, 'program_created', 'New program added: \"test\" by Program Manager.', 'http://127.0.0.1:8000/vc/programs', 'fa-calendar-plus', '#dcfce7', '#15803d', NULL, '2026-04-17 01:38:18', '2026-04-17 01:38:18'),
(78, 8, 'program_created', 'Your program \"test\" has been created successfully.', 'http://127.0.0.1:8000/head/programs', 'fa-circle-check', '#dcfce7', '#15803d', NULL, '2026-04-17 01:38:18', '2026-04-17 01:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `venue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` enum('upcoming','ongoing','completed','cancelled','rescheduled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upcoming',
  `department_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `staff_in_charge_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `title`, `description`, `venue`, `start_date`, `end_date`, `status`, `department_id`, `created_by`, `staff_in_charge_id`, `created_at`, `updated_at`) VALUES
(20, 'Program Testing', 'test', 'UPTM', '2026-03-30 12:44:00', '2026-03-30 13:44:00', 'upcoming', 1, 8, 1, '2026-03-30 04:45:29', '2026-03-30 04:45:29'),
(21, 'Program Hari Minggu', 'Program', 'UPTM', '2026-04-11 10:32:00', '2026-04-11 13:32:00', 'upcoming', 1, 8, 1, '2026-04-06 02:32:39', '2026-04-06 02:32:39'),
(22, 'test', 'testtt', 'UPTM', '2026-04-22 09:33:00', '2026-04-22 11:34:00', 'upcoming', 1, 8, 1, '2026-04-17 01:38:18', '2026-04-17 01:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `program_staff`
--

CREATE TABLE `program_staff` (
  `id` bigint UNSIGNED NOT NULL,
  `program_id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint UNSIGNED NOT NULL,
  `role` enum('committee_member','committee_head','coordinator','facilitator','secretary','treasurer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'committee_member',
  `responsibility` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_lead` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_staff`
--

INSERT INTO `program_staff` (`id`, `program_id`, `staff_id`, `role`, `responsibility`, `is_lead`, `created_at`, `updated_at`) VALUES
(7, 21, 1, 'secretary', NULL, 0, '2026-04-06 02:33:15', '2026-04-06 02:33:15'),
(8, 21, 5, 'treasurer', NULL, 0, '2026-04-06 02:33:25', '2026-04-06 02:33:25'),
(9, 21, 13, 'committee_head', 'Overall program management', 1, '2026-04-13 02:05:47', '2026-04-13 02:05:47'),
(13, 22, 13, 'coordinator', NULL, 1, '2026-04-17 01:40:37', '2026-04-17 01:40:37'),
(14, 22, 5, 'facilitator', NULL, 0, '2026-04-17 01:41:43', '2026-04-17 01:41:43');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint UNSIGNED NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_id`, `name`, `email`, `phone`, `position`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 'FP04428', 'Hidayah Binti Burhannudin (KL)', 'hidayah_burhannudin@uptm.edu.my', NULL, 'staff', 1, '2026-03-08 18:58:18', '2026-03-08 18:58:23'),
(3, 'FP00000', 'Vice Chancellor', 'vc@uptm.edu.my', NULL, 'staff', 7, '2026-03-08 20:36:13', '2026-04-17 01:30:05'),
(4, 'FP01111', 'Program Manager', 'pm@uptm.edu.my', NULL, 'hd', 1, '2026-03-08 20:37:40', '2026-03-08 20:37:40'),
(5, 'FP12345', 'Nabila Sofea', 'nabila@uptm.edu.my', NULL, 'hd', 1, '2026-03-10 03:54:58', '2026-03-10 03:57:33'),
(11, 'FP24681', 'Leader Test', 'leader@uptm.edu.my', NULL, 'ld', 1, '2026-04-07 08:04:20', '2026-04-07 08:04:20'),
(12, 'FP36912', 'Secretariat Test', 'secretariat@uptm.edu.my', NULL, 'hd', 1, '2026-04-07 08:04:58', '2026-04-07 08:04:58'),
(13, 'FP00001', 'Ali Ahmad', 'ali@uptm.edu.my', '0123456789', 'staff', 1, '2026-04-10 06:54:54', '2026-04-10 06:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','vc','hd','ld') COLLATE utf8mb4_unicode_ci DEFAULT 'hd',
  `staff_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token_expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `staff_id`, `remember_token`, `created_at`, `updated_at`, `reset_token`, `reset_token_expires_at`) VALUES
(6, 'Vice Chancellor', 'vc@uptm.edu.my', NULL, '$2y$12$C7.2kGAO6qg.E4fEfylb9uO.rFhd0QMCZpZPKMocZgPpA0Lg3ZRzq', 'vc', 3, NULL, '2026-03-08 20:36:22', '2026-03-08 20:36:22', NULL, NULL),
(8, 'Program Manager', 'pm@uptm.edu.my', NULL, '$2y$12$7dcU9oPkoM7voNPvvAeOUudzrVYcjg2FtE6.f1pOjRmloE/DNcuCu', 'hd', 4, NULL, '2026-03-08 20:37:46', '2026-03-08 20:37:46', NULL, NULL),
(9, 'Nabila Sofea', 'nabila@uptm.edu.my', NULL, '$2y$12$yYSI40SHD5An/a6U1vm00.1ikBB7MFCKoUU3KwMZRInX8B.pVwrw.', 'hd', 5, NULL, '2026-03-10 03:57:41', '2026-03-10 03:57:41', NULL, NULL),
(13, 'Leader Test', 'leader@uptm.edu.my', NULL, '$2y$12$Z6FtWb3PGOQpMXMWiU5QAOHGm55Z5.CiDI2BRpx0MIHoPs/iMhUNG', 'ld', 11, NULL, '2026-04-07 08:42:12', '2026-04-07 08:42:12', NULL, NULL),
(14, 'Secretariat Test', 'secretariat@uptm.edu.my', NULL, '$2y$12$Fc5gSWBAAs1nbaa7cltrFeovqWo6CL8y5apPD0n4GGIsQ8.iqcD7.', 'hd', 12, NULL, '2026-04-07 08:42:28', '2026-04-07 08:42:28', NULL, NULL),
(15, 'Hidayah Binti Burhannudin (KL)', 'hidayah_burhannudin@uptm.edu.my', NULL, '$2y$12$4jSJHoKlvD3YCE4J3wIYVetT3Fd9TV.TXyADoAHHeSW1Gh3ZMwE2m', 'hd', 1, NULL, '2026-04-17 00:18:47', '2026-04-17 00:18:47', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `merit_claims`
--
ALTER TABLE `merit_claims`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `merit_claims_staff_id_program_id_claim_type_unique` (`staff_id`,`program_id`,`claim_type`),
  ADD KEY `merit_claims_program_id_foreign` (`program_id`),
  ADD KEY `merit_claims_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `programs_department_id_foreign` (`department_id`),
  ADD KEY `programs_created_by_foreign` (`created_by`);

--
-- Indexes for table `program_staff`
--
ALTER TABLE `program_staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `program_staff_program_id_staff_id_unique` (`program_id`,`staff_id`),
  ADD KEY `program_staff_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_staff_id_unique` (`staff_id`),
  ADD UNIQUE KEY `staff_email_unique` (`email`),
  ADD KEY `staff_department_id_foreign` (`department_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merit_claims`
--
ALTER TABLE `merit_claims`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `program_staff`
--
ALTER TABLE `program_staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `merit_claims`
--
ALTER TABLE `merit_claims`
  ADD CONSTRAINT `merit_claims_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `merit_claims_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `merit_claims_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `programs_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `program_staff`
--
ALTER TABLE `program_staff`
  ADD CONSTRAINT `program_staff_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_staff_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
