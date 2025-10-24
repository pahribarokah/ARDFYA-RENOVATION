-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2025 at 02:46 PM
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
-- Database: `ardfya_db`
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
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `is_from_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `customer_id`, `admin_id`, `message`, `is_from_admin`, `is_read`, `created_at`, `updated_at`, `deleted_at`, `file_url`, `file_name`, `file_type`, `file_size`) VALUES
(1, 6, NULL, 'd', 0, 0, '2025-06-02 12:06:30', '2025-06-02 12:06:30', NULL, NULL, NULL, NULL, NULL),
(2, 6, 1, 'a', 1, 1, '2025-06-02 13:18:25', '2025-06-02 13:18:30', NULL, NULL, NULL, NULL, NULL),
(3, 6, 1, 'a', 1, 1, '2025-06-02 13:18:29', '2025-06-02 13:18:30', NULL, NULL, NULL, NULL, NULL),
(4, 6, 1, 'ayam', 1, 1, '2025-06-02 13:18:51', '2025-06-02 13:18:54', NULL, NULL, NULL, NULL, NULL),
(5, 6, 1, 'test\n[file:chat-files/v1xAuvyRRkPPjdQXHPIutUwlDHswImiwOXU5g8Y4.png]', 1, 0, '2025-06-12 00:39:41', '2025-06-12 00:39:41', NULL, NULL, NULL, NULL, NULL),
(6, 6, 1, 'test\n[file:chat-files/VdnHfGoIAW2EANeVj1awMlrSNlTvdM6O58jm5EWT.png]', 1, 0, '2025-06-12 00:39:43', '2025-06-12 00:39:43', NULL, NULL, NULL, NULL, NULL),
(7, 7, NULL, 'test one', 0, 0, '2025-06-12 00:40:48', '2025-06-12 00:40:48', NULL, NULL, NULL, NULL, NULL),
(8, 7, 1, 'test\n[file:chat-files/DUANT9eeo29ftSGTFu96N3qU7OnLKOEPfmPufNMW.png]', 1, 1, '2025-06-12 00:41:31', '2025-06-12 00:41:48', NULL, NULL, NULL, NULL, NULL),
(9, 7, 1, 'test', 1, 1, '2025-06-12 01:36:38', '2025-06-12 01:43:37', NULL, NULL, NULL, NULL, NULL),
(10, 7, 1, 'test\n[file:chat-files/SXpAifSoLVMKh9guIdYKX9fhMSrcK9rDRinqCoRi.png]', 1, 1, '2025-06-12 01:51:15', '2025-06-12 02:38:17', NULL, NULL, NULL, NULL, NULL),
(11, 7, 1, 'trs', 1, 1, '2025-06-12 02:27:58', '2025-06-12 02:38:17', NULL, NULL, NULL, NULL, NULL),
(12, 7, 1, 'trs', 1, 1, '2025-06-12 02:28:14', '2025-06-12 02:38:17', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749720494_Screenshot 2025-06-09 210016.png', 'Screenshot 2025-06-09 210016.png', 'image/png', 166520),
(13, 7, 1, 'test', 1, 1, '2025-06-12 02:30:03', '2025-06-12 02:38:17', NULL, NULL, NULL, NULL, NULL),
(14, 7, 1, 's', 1, 1, '2025-06-12 02:30:35', '2025-06-12 02:38:17', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749720635_Screenshot 2025-06-09 212519.png', 'Screenshot 2025-06-09 212519.png', 'image/png', 34012),
(15, 7, 1, 'ss', 1, 1, '2025-06-12 02:30:55', '2025-06-12 02:38:17', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749720655_FahriYusuf_TA_proposal.docx', 'FahriYusuf_TA_proposal.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 217409),
(16, 7, 1, 's', 1, 1, '2025-06-12 02:33:24', '2025-06-12 02:38:17', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749720804_FahriYusuf_TA_proposal.docx', 'FahriYusuf_TA_proposal.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 217409),
(17, 7, 1, 's', 1, 1, '2025-06-12 02:33:35', '2025-06-12 02:38:17', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749720815_Screenshot 2025-06-09 220133.png', 'Screenshot 2025-06-09 220133.png', 'image/png', 35495),
(18, 6, 1, 'trs', 1, 0, '2025-06-12 02:36:36', '2025-06-12 02:36:36', NULL, NULL, NULL, NULL, NULL),
(19, 7, 1, 'ss', 1, 1, '2025-06-12 02:37:52', '2025-06-12 02:38:17', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749721072_Screenshot 2025-06-09 220419.png', 'Screenshot 2025-06-09 220419.png', 'image/png', 17025),
(20, 5, 1, 'tester', 1, 0, '2025-06-12 02:53:46', '2025-06-12 02:53:46', NULL, NULL, NULL, NULL, NULL),
(21, 7, 1, 's', 1, 1, '2025-06-12 02:53:51', '2025-06-12 03:01:11', NULL, NULL, NULL, NULL, NULL),
(22, 7, 1, 'ss', 1, 1, '2025-06-12 02:56:45', '2025-06-12 03:01:11', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749722205_FahriYusuf_TA_proposal 2 (1).docx', 'FahriYusuf_TA_proposal 2 (1).docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 173389),
(23, 7, 1, 'ss', 1, 1, '2025-06-12 02:57:01', '2025-06-12 03:01:11', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749722221_Screenshot 2025-06-09 225408.png', 'Screenshot 2025-06-09 225408.png', 'image/png', 41078),
(24, 7, 1, 'trs', 1, 1, '2025-06-12 03:00:08', '2025-06-12 03:01:11', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749722408_Screenshot 2025-06-10 000923.png', 'Screenshot 2025-06-10 000923.png', 'image/png', 291557),
(25, 7, NULL, 'tester', 0, 0, '2025-06-12 03:25:44', '2025-06-12 03:25:44', NULL, NULL, NULL, NULL, NULL),
(26, 7, NULL, 'fsfdgdh', 0, 0, '2025-06-12 03:25:58', '2025-06-12 03:25:58', NULL, NULL, NULL, NULL, NULL),
(27, 7, NULL, 'sadsada', 0, 0, '2025-06-12 03:27:39', '2025-06-12 03:27:39', NULL, NULL, NULL, NULL, NULL),
(28, 7, NULL, 'ssadas', 0, 0, '2025-06-12 03:34:23', '2025-06-12 03:34:23', NULL, 'http://127.0.0.1:8000/storage/chat-files/application/1749724463_FahriYusuf_TA_proposal 2 (1).docx', 'FahriYusuf_TA_proposal 2 (1).docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 173389),
(29, 7, NULL, 'afasfasfa', 0, 0, '2025-06-12 03:34:36', '2025-06-12 03:34:36', NULL, 'http://127.0.0.1:8000/storage/chat-files/image/1749724476_Screenshot 2025-06-10 020826.png', 'Screenshot 2025-06-10 020826.png', 'image/png', 61891),
(30, 7, 1, 'arfaefaf', 1, 0, '2025-06-12 03:35:29', '2025-06-12 03:35:29', NULL, NULL, NULL, NULL, NULL),
(31, 7, 1, 'sadsa', 1, 0, '2025-06-12 03:36:57', '2025-06-12 03:36:57', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749724617_Screenshot 2025-06-09 223402.png', 'Screenshot 2025-06-09 223402.png', 'image/png', 33726),
(32, 7, 1, '', 1, 0, '2025-06-12 03:37:59', '2025-06-12 03:37:59', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749724679_Screenshot 2025-06-10 023332.png', 'Screenshot 2025-06-10 023332.png', 'image/png', 29598),
(33, 7, 1, 'ssfsa', 1, 0, '2025-06-12 03:38:03', '2025-06-12 03:38:03', NULL, NULL, NULL, NULL, NULL),
(34, 7, 1, 'saasfa', 1, 0, '2025-06-12 03:38:09', '2025-06-12 03:38:09', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749724689_Screenshot 2025-06-09 220419.png', 'Screenshot 2025-06-09 220419.png', 'image/png', 17025),
(35, 7, 1, 'asdasa', 1, 0, '2025-06-12 03:47:59', '2025-06-12 03:47:59', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749725279_Screenshot 2025-06-09 220419.png', 'Screenshot 2025-06-09 220419.png', 'image/png', 17025),
(36, 7, 1, 'ssaa', 1, 0, '2025-06-12 03:48:17', '2025-06-12 03:48:17', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749725297_Screenshot 2025-06-09 220006.png', 'Screenshot 2025-06-09 220006.png', 'image/png', 20398),
(37, 7, 1, 'sss', 1, 0, '2025-06-12 03:48:38', '2025-06-12 03:48:38', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749725318_Screenshot 2025-06-10 023553.png', 'Screenshot 2025-06-10 023553.png', 'image/png', 175303),
(38, 7, 1, '', 1, 0, '2025-06-12 04:09:40', '2025-06-12 04:09:40', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749726580_Screenshot 2025-06-09 222301.png', 'Screenshot 2025-06-09 222301.png', 'image/png', 27621),
(39, 7, 1, '', 1, 0, '2025-06-12 04:13:28', '2025-06-12 04:13:28', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749726808_Screenshot 2025-06-10 125740.png', 'Screenshot 2025-06-10 125740.png', 'image/png', 1788274),
(40, 7, NULL, 'halo', 0, 0, '2025-06-12 05:48:08', '2025-06-12 05:48:08', NULL, NULL, NULL, NULL, NULL),
(41, 7, NULL, '', 0, 0, '2025-06-12 05:48:21', '2025-06-12 05:48:21', NULL, 'http://127.0.0.1:8000/storage/chat-files/application/1749732501_FahriYusuf_TA_proposal 2.docx', 'FahriYusuf_TA_proposal 2.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 172217),
(42, 7, NULL, 'trsa', 0, 0, '2025-06-12 05:55:44', '2025-06-12 05:55:44', NULL, NULL, NULL, NULL, NULL),
(43, 7, NULL, '', 0, 0, '2025-06-12 05:55:50', '2025-06-12 05:55:50', NULL, 'http://127.0.0.1:8000/storage/chat-files/image/1749732950_Screenshot 2025-06-09 210740.png', 'Screenshot 2025-06-09 210740.png', 'image/png', 166394),
(44, 7, NULL, 'sasafsafsa', 0, 0, '2025-06-12 05:56:00', '2025-06-12 05:56:00', NULL, 'http://127.0.0.1:8000/storage/chat-files/image/1749732960_Screenshot 2025-06-09 212519.png', 'Screenshot 2025-06-09 212519.png', 'image/png', 34012),
(45, 7, NULL, '', 0, 0, '2025-06-12 05:56:10', '2025-06-12 05:56:10', NULL, 'http://127.0.0.1:8000/storage/chat-files/application/1749732970_FahriYusuf_TA_proposal 2 (1).docx', 'FahriYusuf_TA_proposal 2 (1).docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 173389),
(46, 7, 1, 'kontrak', 1, 0, '2025-06-12 09:30:53', '2025-06-12 09:30:53', NULL, 'http://127.0.0.1:8000/storage/chat-files/1749745853_Kontrak_CTR-202506-0001 (3).pdf', 'Kontrak_CTR-202506-0001 (3).pdf', 'application/pdf', 2841),
(47, 7, 1, 'sss', 1, 0, '2025-06-12 09:37:52', '2025-06-12 09:37:52', NULL, NULL, NULL, NULL, NULL),
(48, 14, NULL, 'TOLONG', 0, 0, '2025-06-13 02:45:07', '2025-06-13 02:45:07', NULL, NULL, NULL, NULL, NULL),
(49, 14, 1, 'ADA APA', 1, 0, '2025-06-13 02:46:21', '2025-06-13 02:46:21', NULL, NULL, NULL, NULL, NULL),
(50, 16, NULL, 'tolong', 0, 0, '2025-06-20 00:09:44', '2025-06-20 00:09:44', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_number` varchar(255) DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `contract_status` enum('draft','active','completed','terminated') NOT NULL DEFAULT 'active',
  `installments` int(11) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `contract_number`, `project_id`, `user_id`, `start_date`, `end_date`, `amount`, `contract_status`, `installments`, `notes`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 3, '2025-04-28', NULL, 81400000.00, 'active', 1, 'Kontrak untuk proyek Proyek Desain Interior - Customer 1', '2025-06-02 12:04:31', '2025-06-02 12:04:31'),
(2, NULL, 3, 5, '2025-06-05', NULL, 64900000.00, 'active', 1, 'Kontrak untuk proyek Proyek Desain Interior - Customer 3', '2025-06-02 12:04:31', '2025-06-02 12:04:31'),
(3, 'CTR-202506-0001', 4, 7, '2025-06-19', '2025-06-19', 124345353.00, 'active', 1, 'testetrffhgh', '2025-06-12 08:59:02', '2025-06-12 09:27:14'),
(4, 'CTR-202506-0002', 5, 14, '2025-06-15', '2025-06-20', 10.00, 'active', 1, NULL, '2025-06-13 02:48:59', '2025-06-13 02:48:59'),
(5, 'CTR-202506-0003', 6, 14, '2025-06-23', '2025-06-27', 10000000.00, 'active', 1, NULL, '2025-06-19 21:04:21', '2025-06-19 21:04:21'),
(6, 'CTR-202506-0004', 9, 15, '2025-06-23', '2025-06-25', 12000000.00, 'active', 1, NULL, '2025-06-19 21:46:55', '2025-06-19 21:46:55'),
(7, 'CTR-202506-0005', 10, 16, '2025-06-23', '2025-06-27', 10000000.00, 'active', 1, NULL, '2025-06-20 00:12:25', '2025-06-20 00:12:25');

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
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `address` text NOT NULL,
  `property_type` varchar(255) DEFAULT NULL,
  `area_size` int(11) DEFAULT NULL,
  `current_condition` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `budget` decimal(12,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `schedule_flexibility` varchar(255) DEFAULT NULL,
  `status` enum('new','contacted','in_progress','completed','cancelled') NOT NULL DEFAULT 'new',
  `admin_notes` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `name`, `email`, `phone`, `service_id`, `address`, `property_type`, `area_size`, `current_condition`, `description`, `budget`, `start_date`, `schedule_flexibility`, `status`, `admin_notes`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Customer 1', 'customer1@example.com', '087064778818', 3, 'Jl. Customer No. 1, Jakarta', 'rumah', 306, 'Kondisi rumah saat ini memerlukan perbaikan.', 'Permintaan renovasi untuk rumah saya. Butuh bantuan profesional.', 74000000.00, '2025-07-01', 'flexible', 'in_progress', 'Telah dihubungi pada 31/05/2025', 3, '2025-04-21 12:04:31', '2025-05-04 12:04:31'),
(2, 'Customer 1', 'customer1@example.com', '087064778818', 1, 'Jl. Customer No. 1, Jakarta', 'rumah', 267, 'Kondisi rumah saat ini memerlukan perbaikan.', 'Permintaan renovasi untuk rumah saya. Butuh bantuan profesional.', 61000000.00, '2025-06-19', 'flexible', 'contacted', 'Telah dihubungi pada 31/05/2025', 3, '2025-05-12 12:04:31', '2025-05-21 12:04:31'),
(3, 'Customer 2', 'customer2@example.com', '084298409715', 1, 'Jl. Customer No. 2, Jakarta', 'lainnya', 384, 'Kondisi lainnya saat ini memerlukan perbaikan.', 'Permintaan renovasi untuk lainnya saya. Butuh bantuan profesional.', 91000000.00, '2025-06-30', 'flexible', 'cancelled', NULL, 4, '2025-04-17 12:04:31', '2025-05-30 12:04:31'),
(4, 'Customer 2', 'customer2@example.com', '084298409715', 2, 'Jl. Customer No. 2, Jakarta', 'lainnya', 490, 'Kondisi lainnya saat ini memerlukan perbaikan.', 'Permintaan renovasi untuk lainnya saya. Butuh bantuan profesional.', 36000000.00, '2025-06-28', 'moderate', 'in_progress', 'Telah dihubungi pada 29/05/2025', 4, '2025-04-13 12:04:31', '2025-06-02 12:04:31'),
(5, 'Customer 3', 'customer3@example.com', '083226756040', 3, 'Jl. Customer No. 3, Jakarta', 'lainnya', 145, 'Kondisi lainnya saat ini memerlukan perbaikan.', 'Permintaan renovasi untuk lainnya saya. Butuh bantuan profesional.', 59000000.00, '2025-06-27', 'strict', 'in_progress', 'Telah dihubungi pada 27/05/2025', 5, '2025-05-29 12:04:31', '2025-05-20 12:04:31'),
(6, 'Customer 3', 'customer3@example.com', '083226756040', 1, 'Jl. Customer No. 3, Jakarta', 'ruko', 106, 'Kondisi ruko saat ini memerlukan perbaikan.', 'Permintaan renovasi untuk ruko saya. Butuh bantuan profesional.', 73000000.00, '2025-06-10', 'strict', 'contacted', 'Telah dihubungi pada 29/05/2025', 5, '2025-05-19 12:04:31', '2025-05-21 12:04:31'),
(7, 'fahri', 'fahri@gmail.com', '08979788887879', 1, 'djakarta', 'kantor', 1221, 'ambruk', 'fafefef', 124345353.00, '2025-06-19', 'hari kamis', 'in_progress', NULL, 7, '2025-06-12 08:10:25', '2025-06-12 08:38:52'),
(22, 'arshaka', 'yoel@gmail.com', '082134567891', 2, 'BASECAMP BABEH', 'rumah', 60, 'genteng abruk', 'AMBRUK', 10000000.00, '2025-06-23', 'dihari sabtu dan minggu', 'in_progress', NULL, 14, '2025-06-13 02:44:31', '2025-06-18 05:03:27'),
(23, 'ff', 'yoel@gmail.com', '085211224332', 2, 'jl.kebon jeruk', 'rumah', 1215, 'rusak kramik', 'minta ganti kramik', 10000000.00, '2025-06-23', 'dihari sabtu dan minggu', 'in_progress', NULL, 14, '2025-06-19 06:08:40', '2025-06-19 06:11:36'),
(24, 'baim', 'baim@gmail.com', '08979788887879', 2, 'jl.h.bolot', 'kantor', 150, 'laporan ada bocoran di pilar pengubung', 'bocor di lantai dua dari pilar', 12.00, '2025-06-20', 'sore hari ini', 'in_progress', NULL, 15, '2025-06-19 21:27:26', '2025-06-19 21:35:12'),
(25, 'danda', 'danda@gmail.com', '08979788887879', 2, 'kebon jeruk', 'Rumah', 157, NULL, 'plafon ambruk', 10000000.00, NULL, NULL, 'in_progress', NULL, 16, '2025-06-20 00:08:47', '2025-06-20 00:11:20');

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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"55dd1007-9422-47d6-b346-5d40282d1bff\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1748891190,\"delay\":null}', 0, NULL, 1748891190, 1748891190),
(2, 'default', '{\"uuid\":\"6028ea01-2221-475c-85dd-dfc0c5a01e70\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1748895507,\"delay\":null}', 0, NULL, 1748895507, 1748895507),
(3, 'default', '{\"uuid\":\"f1e7940f-8d5e-4616-89fd-367631b070ba\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1748895509,\"delay\":null}', 0, NULL, 1748895509, 1748895509),
(4, 'default', '{\"uuid\":\"fa84b332-9b03-4479-be2f-52ad5ead5c1a\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1748895531,\"delay\":null}', 0, NULL, 1748895531, 1748895531),
(5, 'default', '{\"uuid\":\"2d11e911-e3eb-42b9-a350-cfa56d06266e\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749713983,\"delay\":null}', 0, NULL, 1749713983, 1749713983),
(6, 'default', '{\"uuid\":\"2fbbfc33-0ba9-4957-bf6c-5c7b57e3a947\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749713983,\"delay\":null}', 0, NULL, 1749713983, 1749713983),
(7, 'default', '{\"uuid\":\"b50a1d4f-182c-4381-9e9c-d17bef8286fe\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749714048,\"delay\":null}', 0, NULL, 1749714048, 1749714048),
(8, 'default', '{\"uuid\":\"3624d5f0-7fa3-4252-b376-5e8152170557\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749714091,\"delay\":null}', 0, NULL, 1749714091, 1749714091),
(9, 'default', '{\"uuid\":\"7e6a4063-dbeb-4e4d-bce8-89c1b17521d8\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749717398,\"delay\":null}', 0, NULL, 1749717398, 1749717398),
(10, 'default', '{\"uuid\":\"c1f97659-a77f-43e7-b51c-0f5cec317659\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749718275,\"delay\":null}', 0, NULL, 1749718275, 1749718275),
(11, 'default', '{\"uuid\":\"28f1f42f-f6d3-43c7-9ace-9bc609e89f8d\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749720478,\"delay\":null}', 0, NULL, 1749720478, 1749720478),
(12, 'default', '{\"uuid\":\"cd99d2ec-4191-499f-a509-2f42caeb181f\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:12;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749720495,\"delay\":null}', 0, NULL, 1749720495, 1749720495),
(13, 'default', '{\"uuid\":\"3f2d2949-0f7c-4a3d-8e7c-81fafbf2e908\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:13;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749720603,\"delay\":null}', 0, NULL, 1749720603, 1749720603),
(14, 'default', '{\"uuid\":\"f40612ff-ea16-4522-9dc2-fcaf239b3609\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749720635,\"delay\":null}', 0, NULL, 1749720635, 1749720635),
(15, 'default', '{\"uuid\":\"f63246f5-4180-40bf-96ad-d81bf085e507\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:15;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749720655,\"delay\":null}', 0, NULL, 1749720655, 1749720655),
(16, 'default', '{\"uuid\":\"3c2e9365-bb25-4dfa-bd76-cc8ebe666883\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749720804,\"delay\":null}', 0, NULL, 1749720804, 1749720804),
(17, 'default', '{\"uuid\":\"d07949d7-24c1-4429-93df-63134d77aad9\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:17;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749720816,\"delay\":null}', 0, NULL, 1749720816, 1749720816),
(18, 'default', '{\"uuid\":\"5aa18f5d-198e-44e7-8db7-2ac74c237073\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749720996,\"delay\":null}', 0, NULL, 1749720996, 1749720996),
(19, 'default', '{\"uuid\":\"3bec5228-20d2-49f8-a2fb-615e0c04b5bf\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:19;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749721072,\"delay\":null}', 0, NULL, 1749721072, 1749721072),
(20, 'default', '{\"uuid\":\"b36c4b6d-f82e-4204-b6b1-6204d10606db\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:20;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749722026,\"delay\":null}', 0, NULL, 1749722026, 1749722026),
(21, 'default', '{\"uuid\":\"c89b753f-fcab-42ea-bb8f-96f90f807600\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749722031,\"delay\":null}', 0, NULL, 1749722031, 1749722031),
(22, 'default', '{\"uuid\":\"ad93cf29-d544-4b7f-837b-85007ce0384d\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749722205,\"delay\":null}', 0, NULL, 1749722205, 1749722205),
(23, 'default', '{\"uuid\":\"b235d983-d09e-4b34-80f8-fc2ad1d5e8bb\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749722221,\"delay\":null}', 0, NULL, 1749722221, 1749722221),
(24, 'default', '{\"uuid\":\"1aa300bf-50c7-40b2-9c3f-6be25ecc0746\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:24;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749722408,\"delay\":null}', 0, NULL, 1749722408, 1749722408),
(25, 'default', '{\"uuid\":\"278fef7c-a7f9-4b5d-bec2-4fb53d823b80\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:25;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749723944,\"delay\":null}', 0, NULL, 1749723944, 1749723944),
(26, 'default', '{\"uuid\":\"71c20ff3-c84b-4645-aca6-862bcfb98bed\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:26;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749723958,\"delay\":null}', 0, NULL, 1749723958, 1749723958),
(27, 'default', '{\"uuid\":\"8024e063-80b2-4c75-9e68-f3faa980c445\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749724059,\"delay\":null}', 0, NULL, 1749724059, 1749724059),
(28, 'default', '{\"uuid\":\"85d23bd0-5c5b-4c01-bb0b-111e850aed3f\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:28;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749724463,\"delay\":null}', 0, NULL, 1749724463, 1749724463),
(29, 'default', '{\"uuid\":\"19b4230c-128b-4868-b12a-7510036bc6df\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749724476,\"delay\":null}', 0, NULL, 1749724476, 1749724476),
(30, 'default', '{\"uuid\":\"08634650-511e-4f86-b6de-9aa0b4db2c65\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749724529,\"delay\":null}', 0, NULL, 1749724529, 1749724529),
(31, 'default', '{\"uuid\":\"27fc868f-8029-4655-89c6-4d6b3cd16a80\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749724617,\"delay\":null}', 0, NULL, 1749724617, 1749724617),
(32, 'default', '{\"uuid\":\"3fa288c6-0f0d-4538-8afc-ff9fff87d2ac\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749724679,\"delay\":null}', 0, NULL, 1749724679, 1749724679),
(33, 'default', '{\"uuid\":\"56f91c49-2f79-4559-be11-beed3a5742f8\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:33;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749724683,\"delay\":null}', 0, NULL, 1749724683, 1749724683),
(34, 'default', '{\"uuid\":\"4da7288b-f110-4487-aab9-56eeaf48afe9\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:34;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749724690,\"delay\":null}', 0, NULL, 1749724690, 1749724690),
(35, 'default', '{\"uuid\":\"c649d6aa-b2a7-4eb6-b507-813bf5b3c6e6\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:35;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749725279,\"delay\":null}', 0, NULL, 1749725279, 1749725279),
(36, 'default', '{\"uuid\":\"bf67bea0-6bd4-42c1-887b-ee9e5e11772f\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:36;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749725297,\"delay\":null}', 0, NULL, 1749725297, 1749725297),
(37, 'default', '{\"uuid\":\"de81aca5-7196-4c11-8659-cad1fc198c76\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:37;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749725318,\"delay\":null}', 0, NULL, 1749725318, 1749725318),
(38, 'default', '{\"uuid\":\"0e0e91ef-ab85-4388-9002-acdf7e3272da\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:38;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749726580,\"delay\":null}', 0, NULL, 1749726580, 1749726580),
(39, 'default', '{\"uuid\":\"f58e4916-ac65-432e-bedd-dbf0f61c6ef6\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:39;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749726808,\"delay\":null}', 0, NULL, 1749726808, 1749726808),
(40, 'default', '{\"uuid\":\"11b83e0a-1127-4d05-bd1b-4f04825c0f2f\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:40;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749732489,\"delay\":null}', 0, NULL, 1749732489, 1749732489);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(41, 'default', '{\"uuid\":\"43b31d79-5da4-465a-b31a-6d3b07f3f8c4\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749732501,\"delay\":null}', 0, NULL, 1749732501, 1749732501),
(42, 'default', '{\"uuid\":\"70057323-ba48-43ab-8f48-6d82fc83207a\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:42;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749732944,\"delay\":null}', 0, NULL, 1749732944, 1749732944),
(43, 'default', '{\"uuid\":\"e7945151-2087-41ed-9e10-a002d5f3f97e\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:43;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749732951,\"delay\":null}', 0, NULL, 1749732951, 1749732951),
(44, 'default', '{\"uuid\":\"d10482ef-e88e-4e75-b341-97e98357d5dc\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:44;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749732960,\"delay\":null}', 0, NULL, 1749732960, 1749732960),
(45, 'default', '{\"uuid\":\"be7a6a71-8531-4c62-b53d-2d1825c451d8\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:45;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749732970,\"delay\":null}', 0, NULL, 1749732970, 1749732970),
(46, 'default', '{\"uuid\":\"cf2ff09e-0bd2-4108-af64-3ada9e88e35f\",\"displayName\":\"App\\\\Notifications\\\\NewMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:40:\\\"App\\\\Notifications\\\\NewMessageNotification\\\":4:{s:10:\\\"\\u0000*\\u0000message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Message\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:11:\\\"\\u0000*\\u0000chatType\\\";s:7:\\\"inquiry\\\";s:12:\\\"\\u0000*\\u0000chatTitle\\\";s:14:\\\"Renovasi Rumah\\\";s:2:\\\"id\\\";s:36:\\\"984a8289-c3dd-486f-b7e8-d38e7e4f0e0e\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1749741588,\"delay\":null}', 0, NULL, 1749741588, 1749741588),
(47, 'default', '{\"uuid\":\"c654d9f9-1d07-4cb0-8cd2-1c97cce2561f\",\"displayName\":\"App\\\\Notifications\\\\NewMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:40:\\\"App\\\\Notifications\\\\NewMessageNotification\\\":4:{s:10:\\\"\\u0000*\\u0000message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Message\\\";s:2:\\\"id\\\";i:12;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:11:\\\"\\u0000*\\u0000chatType\\\";s:7:\\\"inquiry\\\";s:12:\\\"\\u0000*\\u0000chatTitle\\\";s:14:\\\"Renovasi Rumah\\\";s:2:\\\"id\\\";s:36:\\\"ff8c2aa2-ada5-45f5-bf4d-910787f14d37\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1749741631,\"delay\":null}', 0, NULL, 1749741631, 1749741631),
(48, 'default', '{\"uuid\":\"e20c7083-fa01-415f-a28d-a53d9d988713\",\"displayName\":\"App\\\\Notifications\\\\NewMessageNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:40:\\\"App\\\\Notifications\\\\NewMessageNotification\\\":4:{s:10:\\\"\\u0000*\\u0000message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Message\\\";s:2:\\\"id\\\";i:13;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:11:\\\"\\u0000*\\u0000chatType\\\";s:7:\\\"inquiry\\\";s:12:\\\"\\u0000*\\u0000chatTitle\\\";s:14:\\\"Renovasi Rumah\\\";s:2:\\\"id\\\";s:36:\\\"33331b29-182b-43d3-a416-da6648d9f23d\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1749741638,\"delay\":null}', 0, NULL, 1749741638, 1749741638),
(49, 'default', '{\"uuid\":\"3ea24718-7657-4486-afb9-a33e81e87b2c\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:46;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749745853,\"delay\":null}', 0, NULL, 1749745853, 1749745853),
(50, 'default', '{\"uuid\":\"a0f179ef-496e-473c-802d-0440fd395682\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:47;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749746272,\"delay\":null}', 0, NULL, 1749746272, 1749746272),
(51, 'default', '{\"uuid\":\"e3c258e1-d613-4b80-a28a-0636107c8d14\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:48;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749807909,\"delay\":null}', 0, NULL, 1749807909, 1749807909),
(52, 'default', '{\"uuid\":\"a3194bbd-34e1-477d-aa8c-f3756abc6897\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:49;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:5:\\\"admin\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1749807981,\"delay\":null}', 0, NULL, 1749807981, 1749807981),
(53, 'default', '{\"uuid\":\"444776b4-af18-47e9-afe4-0f406b967e0c\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\Chat\\\";s:2:\\\"id\\\";i:50;s:9:\\\"relations\\\";a:1:{i:0;s:8:\\\"customer\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1750403386,\"delay\":null}', 0, NULL, 1750403386, 1750403386);

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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `inquiry_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `is_from_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `project_id`, `inquiry_id`, `message`, `is_from_admin`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, 'Terima kasih atas permintaan Anda. Kami akan meninjau dan menghubungi Anda segera.', 1, 1, '2025-04-22 12:04:31', '2025-06-02 12:04:31'),
(2, 3, NULL, 1, 'Terima kasih. Saya menunggu kabar selanjutnya.', 0, 1, '2025-04-23 12:04:31', '2025-06-02 12:04:31'),
(3, 1, NULL, 2, 'Terima kasih atas permintaan Anda. Kami akan meninjau dan menghubungi Anda segera.', 1, 1, '2025-05-13 12:04:31', '2025-06-02 12:04:31'),
(4, 3, NULL, 2, 'Terima kasih. Saya menunggu kabar selanjutnya.', 0, 0, '2025-05-14 12:04:31', '2025-06-02 12:04:31'),
(5, 1, NULL, 4, 'Terima kasih atas permintaan Anda. Kami akan meninjau dan menghubungi Anda segera.', 1, 1, '2025-04-14 12:04:31', '2025-06-02 12:04:31'),
(6, 4, NULL, 4, 'Terima kasih. Saya menunggu kabar selanjutnya.', 0, 1, '2025-04-15 12:04:31', '2025-06-02 12:04:31'),
(7, 1, NULL, 5, 'Terima kasih atas permintaan Anda. Kami akan meninjau dan menghubungi Anda segera.', 1, 1, '2025-05-30 12:04:31', '2025-06-02 12:04:31'),
(8, 5, NULL, 5, 'Terima kasih. Saya menunggu kabar selanjutnya.', 0, 1, '2025-05-31 12:04:31', '2025-06-02 12:04:31'),
(9, 1, NULL, 6, 'Terima kasih atas permintaan Anda. Kami akan meninjau dan menghubungi Anda segera.', 1, 1, '2025-05-20 12:04:31', '2025-06-02 12:04:31'),
(10, 5, NULL, 6, 'Terima kasih. Saya menunggu kabar selanjutnya.', 0, 0, '2025-05-21 12:04:31', '2025-06-02 12:04:31'),
(11, 1, NULL, 7, 'sasfsafasf', 1, 0, '2025-06-12 08:19:48', '2025-06-12 08:19:48'),
(12, 1, NULL, 7, 'bjjhjhj', 1, 0, '2025-06-12 08:20:31', '2025-06-12 08:20:31'),
(13, 1, NULL, 7, 'bjjhjhj', 1, 0, '2025-06-12 08:20:38', '2025-06-12 08:20:38');

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
(4, '0001_01_01_000003_create_admins_table', 1),
(5, '2025_05_15_182611_create_services_table', 1),
(6, '2025_05_15_182650_create_inquiries_table', 1),
(7, '2025_05_15_182700_create_projects_table', 1),
(8, '2025_05_15_182714_create_messages_table', 1),
(9, '2025_05_15_182736_create_contracts_table', 1),
(10, '2025_05_16_082451_add_is_featured_column_to_projects_table', 1),
(11, '2025_05_16_082624_add_additional_columns_to_services_table', 1),
(12, '2025_05_16_084022_create_project_images_table', 1),
(13, '2025_05_26_102345_add_notification_settings_to_users', 1),
(14, '2025_05_26_102857_create_notifications_table', 1),
(15, '2025_06_03_100000_create_chats_table', 1),
(16, '2025_06_12_create_admin_notes_column', 1),
(17, '2025_06_13_create_missing_project_fields', 1),
(18, '2025_06_13_fix_project_budget', 1),
(19, '2025_06_14_create_contract_payments_table', 1),
(20, '2025_06_14_enhance_contracts_table', 1),
(21, '2025_06_12_090859_create_chats_table', 2),
(22, '2025_06_03_100001_add_file_columns_to_chats_table', 3),
(23, '2025_06_19_085736_create_portfolios_table', 4),
(24, '2025_06_19_105746_remove_payment_fields_from_contracts_table', 5),
(25, '2025_06_19_110352_enhance_projects_table_for_management', 6),
(26, '2025_06_20_044430_drop_contract_file_from_contracts_table', 7);

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
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `project_value` decimal(15,2) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`id`, `title`, `description`, `category`, `image_path`, `client_name`, `location`, `completion_date`, `project_value`, `is_featured`, `is_active`, `ordering`, `created_at`, `updated_at`) VALUES
(5, 'Landscape Taman Rumah', 'Desain dan pembuatan taman rumah dengan konsep natural yang menyegarkan. Menggunakan tanaman lokal dan sistem irigasi yang efisien.', 'landscape', NULL, 'Ibu Maya Sari', 'Depok', '2024-01-25', 50000000.00, 0, 1, 5, '2025-06-19 02:08:14', '2025-06-19 02:08:14'),
(6, 'a', 'ddddddd', 'renovasi', 'portfolios/1750326104_7S0mHo66Te.jpg', 's', NULL, '2025-06-26', 99999999999.00, 0, 1, 2, '2025-06-19 02:41:44', '2025-06-19 02:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `inquiry_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `expected_end_date` date DEFAULT NULL,
  `actual_end_date` date DEFAULT NULL,
  `status` enum('planning','in_progress','on_hold','completed','cancelled') NOT NULL DEFAULT 'planning',
  `address` text DEFAULT NULL,
  `total_cost` decimal(12,2) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `budget` decimal(12,2) NOT NULL DEFAULT 0.00,
  `budget_used` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `timeline_details` text DEFAULT NULL,
  `team_assigned` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`team_assigned`)),
  `project_photos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`project_photos`)),
  `progress_percentage` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_last_viewed` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `user_id`, `service_id`, `inquiry_id`, `description`, `start_date`, `end_date`, `expected_end_date`, `actual_end_date`, `status`, `address`, `total_cost`, `category`, `is_featured`, `budget`, `budget_used`, `notes`, `timeline_details`, `team_assigned`, `project_photos`, `progress_percentage`, `created_at`, `updated_at`, `customer_last_viewed`) VALUES
(1, 'Proyek Desain Interior - Customer 1', 3, 3, 1, 'Proyek Desain Interior untuk rumah milik Customer 1', '2025-04-28', NULL, NULL, NULL, 'in_progress', 'Jl. Customer No. 1, Jakarta', 81400000.00, 'rumah', 0, 0.00, 0.00, NULL, NULL, NULL, NULL, 27, '2025-06-02 12:04:31', '2025-06-02 12:04:31', NULL),
(2, 'Proyek Perbaikan Rumah - Customer 2', 4, 2, 4, 'Proyek Perbaikan Rumah untuk lainnya milik Customer 2', '2025-04-20', NULL, NULL, NULL, 'in_progress', 'Jl. Customer No. 2, Jakarta', 39600000.00, 'lainnya', 0, 0.00, 0.00, NULL, NULL, NULL, NULL, 27, '2025-06-02 12:04:31', '2025-06-02 12:04:31', NULL),
(3, 'Proyek Desain Interior - Customer 3', 5, 3, 5, 'Proyek Desain Interior untuk lainnya milik Customer 3', '2025-06-05', NULL, NULL, NULL, 'in_progress', 'Jl. Customer No. 3, Jakarta', 64900000.00, 'lainnya', 0, 0.00, 0.00, NULL, NULL, NULL, NULL, 95, '2025-06-02 12:04:31', '2025-06-12 06:57:46', NULL),
(4, 'fahri', 7, 1, 7, 'aaa', '2025-06-19', NULL, '2025-06-19', '2025-06-19', 'in_progress', NULL, NULL, NULL, 0, 124345353.00, 0.00, NULL, NULL, NULL, NULL, 30, '2025-06-12 08:47:11', '2025-06-12 08:48:56', NULL),
(5, 'el', 14, 2, 22, 'pekerjaan untuk plafon ambruk, dimulai pekerjaan dengan tanggal mulai di 15/06/25.\r\nborongan (jasa dan matrial)', '2025-06-15', NULL, '2025-06-20', '2025-06-21', 'planning', NULL, NULL, NULL, 0, 10.00, 0.00, NULL, NULL, NULL, NULL, 0, '2025-06-13 02:47:49', '2025-06-18 05:02:50', NULL),
(6, 'ff', 14, 2, 23, 'ganti proyek', '2025-06-23', NULL, '2025-06-27', NULL, 'planning', NULL, NULL, NULL, 0, 10000000.00, 0.00, NULL, NULL, NULL, NULL, 5, '2025-06-19 06:11:36', '2025-06-19 06:11:53', NULL),
(7, 'ff', 14, 1, 23, 'perbaikan keramik', '2025-06-23', NULL, '2025-06-27', NULL, 'planning', NULL, NULL, NULL, 0, 10000000.00, 0.00, NULL, NULL, NULL, NULL, 0, '2025-06-19 10:03:41', '2025-06-19 10:03:41', NULL),
(8, 'el', 14, 1, 23, 'perbaikan kramik pecah akan diganti baru', '2025-06-23', NULL, '2025-06-27', NULL, 'planning', NULL, NULL, NULL, 0, 10000000.00, 0.00, NULL, NULL, NULL, NULL, 0, '2025-06-19 20:47:13', '2025-06-19 20:47:13', NULL),
(9, 'baim', 15, 2, 24, 'setelah team survei. terdapat pilar penyambung pipa mengalami boco (pecah)', '2025-06-23', NULL, '2025-06-25', NULL, 'planning', NULL, NULL, NULL, 0, 12000000.00, 0.00, NULL, NULL, NULL, NULL, 0, '2025-06-19 21:35:12', '2025-06-19 21:35:12', NULL),
(10, 'rumah danda jl kk', 16, 2, 25, 'minta di ganti', '2025-06-23', NULL, '2025-06-27', NULL, 'planning', NULL, NULL, NULL, 0, 10000000.00, 0.00, NULL, NULL, NULL, NULL, 5, '2025-06-20 00:11:20', '2025-06-20 00:11:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Renovasi Rumah', 'Layanan renovasi rumah yang mencakup perubahan struktur, desain, dan perbaikan pada bangunan rumah Anda. Kami menawarkan solusi renovasi yang komprehensif untuk meningkatkan nilai dan fungsi rumah Anda.', 'fas fa-home', 1, '2025-06-02 12:04:30', '2025-06-02 12:04:30'),
(2, 'Perbaikan Rumah', 'Layanan perbaikan untuk masalah di rumah Anda seperti kebocoran, kerusakan dinding, lantai, plafon, atau instalasi listrik dan air. Teknisi berpengalaman kami siap menyelesaikan masalah rumah Anda dengan cepat dan profesional.', 'fas fa-tools', 1, '2025-06-02 12:04:30', '2025-06-02 12:04:30'),
(3, 'Desain Interior', 'Layanan desain interior untuk menciptakan ruangan yang indah, fungsional dan sesuai dengan gaya hidup Anda. Tim desainer kami akan membantu mewujudkan ruangan impian Anda dengan desain yang estetis dan praktis.', 'fas fa-drafting-compass', 1, '2025-06-02 12:04:30', '2025-06-02 12:04:30');

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
('8OakBzS4ISrBu1ioagzwvbKHrGtAOoP32d8zbANH', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibG44WVU1R1pHUVZ1eXdsNVFJMTZBcG5hekJLaDJXbTkzMjNsNXJBVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jdXN0b21lci9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1MDUwMTYzODt9fQ==', 1750501645);

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
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `notification_settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`notification_settings`)),
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `notification_settings`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@ardfya.com', NULL, '$2y$12$7iEJE4VViwEpSmzhiVtM4uCARWu4jei5eNB/xq7x3SH4OGU4NYPGO', '08123456789', 'Jl. Admin No. 1', 'admin', NULL, NULL, '2025-06-02 12:04:29', '2025-06-02 12:04:29'),
(2, 'User', 'user@example.com', NULL, '$2y$12$ewo7qgPnVVaiiWaNDrZGLeCKjbzme.a9/3FOrtEMq6BKPZPlZWMPq', '08987654321', 'Jl. User No. 1', 'customer', NULL, NULL, '2025-06-02 12:04:30', '2025-06-02 12:04:30'),
(3, 'Customer 1', 'customer1@example.com', NULL, '$2y$12$i2dAf9uWMmJRUdrz/45ETuCHsPg6sYmVX1fu05Uot4ev9K//dMLDO', '087064778818', 'Jl. Customer No. 1, Jakarta', 'customer', NULL, NULL, '2025-06-02 12:04:30', '2025-06-02 12:04:30'),
(4, 'Customer 2', 'customer2@example.com', NULL, '$2y$12$bVvCU47Og72chy3UQGjQiuGuuBur6MYhVOJ6QZBzVQFyjRq01ObDi', '084298409715', 'Jl. Customer No. 2, Jakarta', 'customer', NULL, NULL, '2025-06-02 12:04:31', '2025-06-02 12:04:31'),
(5, 'Customer 3', 'customer3@example.com', NULL, '$2y$12$EXdqcOl8lgSxz6faMmT5..PvKFcWox7.bt8Has6U2p91zPhd.X/Y.', '083226756040', 'Jl. Customer No. 3, Jakarta', 'customer', NULL, NULL, '2025-06-02 12:04:31', '2025-06-02 12:04:31'),
(6, 'ucu', 'ucup@email.com', NULL, '$2y$12$GWkDtaZVLapS5DhVKn78A.hWa.PuwquJcz7qjzZsA.H2cPZIu5Hgm', NULL, NULL, 'customer', NULL, NULL, '2025-06-02 12:05:25', '2025-06-02 12:05:25'),
(7, 'fahri', 'fahri@gmail.com', NULL, '$2y$12$YyuKquJdDxVLd8OxjE25muKdjVUcpc7iPlto6ImyI.D9uinVPrXNm', NULL, NULL, 'customer', NULL, NULL, '2025-06-12 00:40:33', '2025-06-12 00:40:33'),
(10, 'test', 'testi@gmail.com', NULL, '$2y$12$x6ecUFUq5INzkm.A0jme.OSI03x8vxHk0FR6ABj0Liir8bD2Di/J2', '241241', NULL, 'customer', NULL, NULL, '2025-06-12 09:50:59', '2025-06-12 09:50:59'),
(11, 'sfsd', 'sdfs@gmail.com', NULL, '$2y$12$fDSmDXpPlZL/3ITzcZo6i.5/vBMNIi6AKS0cAmYNZhdWu7e5a9MEu', '2353253252', NULL, 'customer', NULL, NULL, '2025-06-12 09:52:22', '2025-06-12 09:52:22'),
(12, 'fds', 'asa@gmail.com', NULL, '$2y$12$PLF48klhpwcUmkVcVDrB4.kuaVab/bGb.ZwPSHLSWgXXH/yq7DdWW', '08979788887879', NULL, 'customer', NULL, NULL, '2025-06-12 09:55:27', '2025-06-12 09:55:27'),
(13, 'fds', 'ffs@gmail.com', NULL, '$2y$12$AP5kr9KBghy2eWJf1/JuyesjRFux9xgB.Ruo/v96ga.zHF8vHwXz6', '14141241', NULL, 'customer', NULL, NULL, '2025-06-12 09:59:46', '2025-06-12 09:59:46'),
(14, 'el', 'yoel@gmail.com', NULL, '$2y$12$ORJRyqdWPjJfwrjjspzgle4SUZbXMp3b7U65wWLIDLIvm6WzoayMy', NULL, NULL, 'customer', NULL, NULL, '2025-06-13 02:42:46', '2025-06-13 02:42:46'),
(15, 'baim', 'baim@gmail.com', NULL, '$2y$12$O5hIanHqqvz/cWc1a42WFet5THpks.LxGLO1u1f861nuiWJodV74m', NULL, NULL, 'customer', NULL, NULL, '2025-06-19 21:22:01', '2025-06-19 21:22:01'),
(16, 'danda', 'danda@gmail.com', NULL, '$2y$12$E0NN0wgDPcNDzf9FHPRkPOLWsahgRfA.U60EwArO9bUCi.Ab8ImTu', NULL, NULL, 'customer', NULL, NULL, '2025-06-20 00:06:59', '2025-06-20 00:06:59');

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
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_customer_id_foreign` (`customer_id`),
  ADD KEY `chats_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contracts_project_id_foreign` (`project_id`),
  ADD KEY `contracts_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inquiries_service_id_foreign` (`service_id`),
  ADD KEY `inquiries_user_id_foreign` (`user_id`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_user_id_foreign` (`user_id`),
  ADD KEY `messages_project_id_foreign` (`project_id`),
  ADD KEY `messages_inquiry_id_foreign` (`inquiry_id`);

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
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolios_is_active_is_featured_index` (`is_active`,`is_featured`),
  ADD KEY `portfolios_category_is_active_index` (`category`,`is_active`),
  ADD KEY `portfolios_ordering_index` (`ordering`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_user_id_foreign` (`user_id`),
  ADD KEY `projects_service_id_foreign` (`service_id`),
  ADD KEY `projects_inquiry_id_foreign` (`inquiry_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `chats_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contracts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `inquiries_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inquiries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_inquiry_id_foreign` FOREIGN KEY (`inquiry_id`) REFERENCES `inquiries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_inquiry_id_foreign` FOREIGN KEY (`inquiry_id`) REFERENCES `inquiries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `projects_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
