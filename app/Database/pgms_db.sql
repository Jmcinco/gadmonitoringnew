-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2025 at 02:30 AM
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
-- Database: `pgms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--
CREATE DATABASE IF NOT EXISTS pgms_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE pgms_db;

CREATE TABLE `audit_trail` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` enum('CREATE','UPDATE','DELETE','LOGIN','LOGOUT','REVIEW','APPROVE','REJECT','FINALIZE','ARCHIVE') NOT NULL,
  `table_name` varchar(100) NOT NULL DEFAULT 'employees',
  `record_id` int(11) UNSIGNED DEFAULT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_email` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `old_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_data`)),
  `new_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_data`)),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`id`, `user_id`, `action`, `table_name`, `record_id`, `employee_name`, `employee_email`, `details`, `ip_address`, `user_agent`, `old_data`, `new_data`, `created_at`, `updated_at`, `timestamp`) VALUES
(2, 1235, 'LOGIN', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 07:46:23', '2025-08-12 07:46:23', '2025-08-12 07:46:23'),
(3, 1235, 'LOGIN', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 07:47:04', '2025-08-12 07:47:04', '2025-08-12 07:47:04'),
(4, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 07:53:25', '2025-08-12 07:53:25', '2025-08-12 07:53:25'),
(5, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 07:54:18', '2025-08-12 07:54:18', '2025-08-12 07:54:18'),
(6, 1235, 'LOGIN', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 07:54:23', '2025-08-12 07:54:23', '2025-08-12 07:54:23'),
(12, 1235, 'LOGOUT', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 08:03:38', '2025-08-12 08:03:38', '2025-08-12 08:03:38'),
(13, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 08:03:52', '2025-08-12 08:03:52', '2025-08-12 08:03:52'),
(14, 13, 'CREATE', 'plan', 41, 'dasdsadsadsaadasd', 'john.doe@gmail.com', 'GAD Plan created: dasdsadsadsaadasd', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, '{\"plan_id\":\"\",\"issue_mandate\":\"Under the Magna Carta of Women (MCW) Chapter IV Sec 16. Nondiscriminatory and Nonderogatory Portrayal of Women in Media and Film and under the Gender Equality, and Women Empowerment (GEWE) Plan Strategic Goals Area 7 Chapter 15: Transforming Gender Norms and Culture.\",\"cause\":\"dsadadadadasdasdad\",\"gad_objective\":\"[\\\"asdasdasdasdasdadada\\\"]\",\"activity\":\"dasdsadsadsaadasd\",\"indicator_text\":\"[\\\"asdasdasdasdsadadadsa\\\"]\",\"target_text\":\"[\\\"sadasdsadadadasdasdasasdsas\\\"]\",\"startDate\":\"2025-08-12\",\"endDate\":\"2025-08-16\",\"responsible_units\":\"[\\\"Region IX\\\",\\\"Region IX\\\"]\",\"authors_division\":\"1\",\"status\":\"Pending\",\"budget\":\"232323232\",\"hgdg_score\":\"23\",\"file_attachments\":\"[\\\"Uploads\\\\\\/1754985869_47b4656f60eb043f8a64.pdf\\\"]\",\"is_draft\":0,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFA\\\",\\\"statement\\\":\\\"dasdasdasdadadadsadasdas\\\"}]\"}', '2025-08-12 08:04:29', '2025-08-12 08:04:29', '2025-08-12 08:04:29'),
(15, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 08:04:41', '2025-08-12 08:04:41', '2025-08-12 08:04:41'),
(16, 1235, 'LOGIN', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 08:04:47', '2025-08-12 08:04:47', '2025-08-12 08:04:47'),
(17, 1235, 'LOGIN', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 08:57:39', '2025-08-12 08:57:39', '2025-08-12 08:57:39'),
(18, 1235, 'LOGOUT', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 08:58:01', '2025-08-12 08:58:01', '2025-08-12 08:58:01'),
(19, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 08:58:05', '2025-08-12 08:58:05', '2025-08-12 08:58:05'),
(20, 13, 'DELETE', 'plan', 40, 'asdadasdassdasdsasdsdasdasd', 'john.doe@gmail.com', 'GAD Plan deleted: asdadasdassdasdsasdsdasdasd', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '{\"plan_id\":\"40\",\"approved_by\":null,\"authors_division\":\"1\",\"budget\":\"0.00\",\"cause\":\"Sample Cause of Gender Issue\",\"indicator_text\":\"[\\\"assdadadasd\\\"]\",\"target_text\":\"[\\\"asdasdasdasdasd\\\"]\",\"issue_mandate\":\"Under the Magna Carta of Women (MCW) Chapter IV Sec 16. Nondiscriminatory and Nonderogatory Portrayal of Women in Media and Film and under the Gender Equality, and Women Empowerment (GEWE) Plan Strategic Goals Area 7 Chapter 15: Transforming Gender Norms and Culture.\",\"mfo_id\":null,\"pap_id\":null,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFO\\\",\\\"statement\\\":\\\"dasdasdasda\\\"},{\\\"type\\\":\\\"MFO\\\",\\\"statement\\\":\\\"dsadaasdasdsad\\\"}]\",\"endDate\":\"2025-08-16\",\"gad_objective\":\"[\\\"Sample GAD objectives\\\"]\",\"activity\":\"asdadasdassdasdsasdsdasdasd\",\"startDate\":\"2025-08-11\",\"created_at\":\"2025-08-12 07:54:13\",\"updated_at\":\"2025-08-12 07:54:13\",\"status\":\"Draft\",\"hgdg_score\":\"23.00\",\"file_attachments\":\"[\\\"Uploads\\\\\\/1754985253_297d42ac428889bec6ca.pdf\\\"]\",\"responsible_units\":\"[\\\"Region VI\\\",\\\"Region II\\\",\\\"Region III\\\"]\"}', NULL, '2025-08-12 08:58:12', '2025-08-12 08:58:12', '2025-08-12 08:58:12'),
(21, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 08:58:13', '2025-08-12 08:58:13', '2025-08-12 08:58:13'),
(22, 1235, 'LOGIN', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 08:58:18', '2025-08-12 08:58:18', '2025-08-12 08:58:18'),
(23, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-12 23:43:58', '2025-08-12 23:43:58', '2025-08-12 23:43:58'),
(24, 13, 'DELETE', 'plan', 41, 'dasdsadsadsaadasd', 'john.doe@gmail.com', 'GAD Plan deleted: dasdsadsadsaadasd', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '{\"plan_id\":\"41\",\"approved_by\":null,\"authors_division\":\"1\",\"budget\":\"232323232.00\",\"cause\":\"dsadadadadasdasdad\",\"indicator_text\":\"[\\\"asdasdasdasdsadadadsa\\\"]\",\"target_text\":\"[\\\"sadasdsadadadasdasdasasdsas\\\"]\",\"issue_mandate\":\"Under the Magna Carta of Women (MCW) Chapter IV Sec 16. Nondiscriminatory and Nonderogatory Portrayal of Women in Media and Film and under the Gender Equality, and Women Empowerment (GEWE) Plan Strategic Goals Area 7 Chapter 15: Transforming Gender Norms and Culture.\",\"mfo_id\":null,\"pap_id\":null,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFA\\\",\\\"statement\\\":\\\"dasdasdasdadadadsadasdas\\\"}]\",\"endDate\":\"2025-08-16\",\"gad_objective\":\"[\\\"asdasdasdasdasdadada\\\"]\",\"activity\":\"dasdsadsadsaadasd\",\"startDate\":\"2025-08-12\",\"created_at\":\"2025-08-12 08:04:29\",\"updated_at\":\"2025-08-12 08:04:29\",\"status\":\"Pending\",\"hgdg_score\":\"23.00\",\"file_attachments\":\"[\\\"Uploads\\\\\\/1754985869_47b4656f60eb043f8a64.pdf\\\"]\",\"responsible_units\":\"[\\\"Region IX\\\",\\\"Region IX\\\"]\"}', NULL, '2025-08-13 00:21:19', '2025-08-13 00:21:19', '2025-08-13 00:21:19'),
(25, 13, 'CREATE', 'plan', 42, 'To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', 'john.doe@gmail.com', 'GAD Plan saved as draft: To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, '{\"plan_id\":\"\",\"issue_mandate\":\"Under the Magna Carta of Women(MCW) Chapter IV Sec.36. Gender Mainstreaming as a strategy for implementing the MCW\",\"cause\":\"Limited award or recognition given to women in the Cagayan Valley durinf Women\'s Month\",\"gad_objective\":\"[\\\"To boost morale of women-awardees from different sectors in the society\\\"]\",\"activity\":\"To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector\",\"indicator_text\":\"[\\\"No. of Women awardees\\\",\\\"No.of produced GAD-related feature stories\\\",\\\"No. of produced  GAD-related videos\\\",\\\"No. of produced GAD-related news stories\\\"]\",\"target_text\":\"[\\\"\\\",\\\"\\\",\\\"\\\",\\\"\\\"]\",\"startDate\":\"2025-08-10\",\"endDate\":\"2025-09-06\",\"responsible_units\":\"[\\\"Region IX\\\",\\\"Region VII\\\"]\",\"authors_division\":\"1\",\"status\":\"Draft\",\"budget\":\"\",\"hgdg_score\":\"20\",\"file_attachments\":\"[\\\"Uploads\\\\\\/1755044594_c68789b75abf4ad04a63.pdf\\\"]\",\"is_draft\":1,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFO\\\",\\\"statement\\\":\\\"Development Communication Services\\\"}]\"}', '2025-08-13 00:23:14', '2025-08-13 00:23:14', '2025-08-13 00:23:14'),
(26, 13, 'UPDATE', 'plan', 42, 'To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', 'john.doe@gmail.com', 'GAD Plan updated: To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '{\"plan_id\":\"42\",\"approved_by\":null,\"authors_division\":\"1\",\"budget\":\"250000.00\",\"cause\":\"Limited award or recognition given to women in the Cagayan Valley durinf Women\'s Month\",\"indicator_text\":\"[\\\"No. of Women awardees\\\",\\\"No.of produced GAD-related feature stories\\\",\\\"No. of produced  GAD-related videos\\\",\\\"No. of produced GAD-related news stories\\\"]\",\"target_text\":\"[\\\"\\\",\\\"\\\",\\\"\\\",\\\"\\\"]\",\"issue_mandate\":\"Under the Magna Carta of Women(MCW) Chapter IV Sec.36. Gender Mainstreaming as a strategy for implementing the MCW\",\"mfo_id\":null,\"pap_id\":null,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFO\\\",\\\"statement\\\":\\\"Development Communication Services\\\"}]\",\"endDate\":\"2025-09-06\",\"gad_objective\":\"[\\\"To boost morale of women-awardees from different sectors in the society\\\"]\",\"activity\":\"To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector\",\"startDate\":\"2025-08-10\",\"created_at\":\"2025-08-13 00:23:14\",\"updated_at\":\"2025-08-13 00:23:59\",\"status\":\"Pending\",\"hgdg_score\":\"20.00\",\"file_attachments\":\"[\\\"Uploads\\\\\\/1755044639_7556af73dfe242a6c413.pdf\\\"]\",\"responsible_units\":\"[\\\"Region IX\\\",\\\"Region VII\\\"]\"}', '{\"plan_id\":\"42\",\"issue_mandate\":\"Under the Magna Carta of Women(MCW) Chapter IV Sec.36. Gender Mainstreaming as a strategy for implementing the MCW\",\"cause\":\"Limited award or recognition given to women in the Cagayan Valley durinf Women\'s Month\",\"gad_objective\":\"[\\\"To boost morale of women-awardees from different sectors in the society\\\"]\",\"activity\":\"To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector\",\"indicator_text\":\"[\\\"No. of Women awardees\\\",\\\"No.of produced GAD-related feature stories\\\",\\\"No. of produced  GAD-related videos\\\",\\\"No. of produced GAD-related news stories\\\"]\",\"target_text\":\"[\\\"\\\",\\\"\\\",\\\"\\\",\\\"\\\"]\",\"startDate\":\"2025-08-10\",\"endDate\":\"2025-09-06\",\"responsible_units\":\"[\\\"Region IX\\\",\\\"Region VII\\\"]\",\"authors_division\":\"1\",\"status\":\"Pending\",\"budget\":\"250000.00\",\"hgdg_score\":\"20.00\",\"file_attachments\":\"[\\\"Uploads\\\\\\/1755044639_7556af73dfe242a6c413.pdf\\\"]\",\"is_draft\":0,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFO\\\",\\\"statement\\\":\\\"Development Communication Services\\\"}]\"}', '2025-08-13 00:23:59', '2025-08-13 00:23:59', '2025-08-13 00:23:59'),
(27, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 00:50:05', '2025-08-13 00:50:05', '2025-08-13 00:50:05'),
(28, 1235, 'LOGIN', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 00:50:12', '2025-08-13 00:50:12', '2025-08-13 00:50:12'),
(29, 1235, 'DELETE', 'employees', 1259, 'John Doe', 'sampledata2@gmail.com', 'Employee deleted: John Doe', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '{\"emp_id\":\"1259\",\"first_name\":\"John\",\"last_name\":\"Doe\",\"div_id\":\"15\",\"pos_id\":\"10\",\"role_id\":\"1\",\"gender\":\"Male\",\"email\":\"sampledata2@gmail.com\",\"password\":\"$2y$10$KU9f1\\/uRVmHsgy3p29svgOsEp3NklPPEibcCFZXNZUjCj\\/po07WrS\",\"created_at\":\"2025-08-09 11:31:29\",\"updated_at\":null}', NULL, '2025-08-13 00:50:37', '2025-08-13 00:50:37', '2025-08-13 00:50:37'),
(30, 1235, 'LOGIN', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 00:54:11', '2025-08-13 00:54:11', '2025-08-13 00:54:11'),
(31, 1235, 'DELETE', 'employees', 1260, 'John Cinco23', 'sampledata3@gmail.com', 'Employee deleted: John Cinco23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '{\"emp_id\":\"1260\",\"first_name\":\"John\",\"last_name\":\"Cinco23\",\"div_id\":\"1\",\"pos_id\":\"1\",\"role_id\":\"4\",\"gender\":\"Male\",\"email\":\"sampledata3@gmail.com\",\"password\":\"$2y$10$CN\\/mcHkclb\\/D\\/MSwgmzKC.iLxTSAX1H6BQBERbN6uvGy33VtmjKHu\",\"created_at\":\"2025-08-11 01:05:45\",\"updated_at\":null}', NULL, '2025-08-13 00:54:19', '2025-08-13 00:54:19', '2025-08-13 00:54:19'),
(32, 1235, 'DELETE', 'employees', 1261, 'Test Database', 'johndoe23@gmail.com', 'Employee deleted: Test Database', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '{\"emp_id\":\"1261\",\"first_name\":\"Test\",\"last_name\":\"Database\",\"div_id\":\"2\",\"pos_id\":\"2\",\"role_id\":\"2\",\"gender\":\"Male\",\"email\":\"johndoe23@gmail.com\",\"password\":\"$2y$10$V4OmYZtL\\/J0zC0NipjOJrOETSyjutEWuXf7jG\\/Xp98NIR6L.p60vC\",\"created_at\":\"2025-08-12 07:18:33\",\"updated_at\":\"2025-08-12 07:18:33\"}', NULL, '2025-08-13 00:54:27', '2025-08-13 00:54:27', '2025-08-13 00:54:27'),
(33, 1235, 'LOGOUT', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 00:55:13', '2025-08-13 00:55:13', '2025-08-13 00:55:13'),
(34, 1235, 'LOGIN', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 00:55:38', '2025-08-13 00:55:38', '2025-08-13 00:55:38'),
(35, 1235, 'LOGOUT', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 00:56:18', '2025-08-13 00:56:18', '2025-08-13 00:56:19'),
(36, 1255, 'LOGIN', 'employees', 1255, 'Secretariat Account', 'pdgem029@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 00:56:22', '2025-08-13 00:56:22', '2025-08-13 00:56:22'),
(37, 1255, 'LOGOUT', 'employees', 1255, 'Secretariat Account', 'pdgem029@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 00:59:58', '2025-08-13 00:59:58', '2025-08-13 00:59:58'),
(38, 1235, 'LOGIN', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:00:26', '2025-08-13 01:00:26', '2025-08-13 01:00:26'),
(39, 1235, 'UPDATE', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'Employee updated: John Doe', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '{\"emp_id\":\"1262\",\"first_name\":\"John\",\"last_name\":\"Doe\",\"div_id\":\"7\",\"pos_id\":\"2\",\"role_id\":\"2\",\"gender\":\"Female\",\"email\":\"johnmichael.cinco.piagov2@gmail.com\",\"password\":\"$2y$10$JCPtZFyytImzmHsnuzEARef8wv22fivH9DZX2IRQRr\\/CYwXOSsqSa\",\"created_at\":\"2025-08-12 07:40:06\",\"updated_at\":\"2025-08-12 07:40:06\"}', '{\"first_name\":\"John\",\"last_name\":\"Doe\",\"div_id\":\"7\",\"pos_id\":\"2\",\"role_id\":\"2\",\"gender\":\"female\",\"email\":\"johnmichael.cinco.piagov2@gmail.com\",\"updated_at\":\"2025-08-13 01:00:59\",\"password\":\"$2y$10$LNEP\\/75ms8M.tERk47y9reSaj3mbGt0MCeWqxZuavFHGLnf1iPx2e\"}', '2025-08-13 01:00:59', '2025-08-13 01:00:59', '2025-08-13 01:00:59'),
(40, 1235, 'LOGOUT', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:01:05', '2025-08-13 01:01:05', '2025-08-13 01:01:05'),
(41, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:01:09', '2025-08-13 01:01:09', '2025-08-13 01:01:09'),
(42, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:23:04', '2025-08-13 01:23:04', '2025-08-13 01:23:04'),
(43, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:50:50', '2025-08-13 01:50:50', '2025-08-13 01:50:50'),
(44, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:50:53', '2025-08-13 01:50:53', '2025-08-13 01:50:53'),
(45, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:51:29', '2025-08-13 01:51:29', '2025-08-13 01:51:29'),
(46, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:51:39', '2025-08-13 01:51:39', '2025-08-13 01:51:39'),
(47, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:51:59', '2025-08-13 01:51:59', '2025-08-13 01:51:59'),
(48, 1235, 'LOGIN', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:52:03', '2025-08-13 01:52:03', '2025-08-13 01:52:03'),
(49, 1235, 'UPDATE', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'Employee updated: John Doe', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '{\"emp_id\":\"13\",\"first_name\":\"John\",\"last_name\":\"Doe\",\"div_id\":\"1\",\"pos_id\":\"1\",\"role_id\":\"1\",\"gender\":\"Male\",\"email\":\"john.doe@gmail.com\",\"password\":\"$2y$10$v33gy\\/CLkNRX37CQ5enXhu\\/MIj\\/AyrVTaOndF7lx4vxJOc\\/KxZBVG\",\"created_at\":null,\"updated_at\":\"2025-08-12 07:22:17\"}', '{\"first_name\":\"John\",\"last_name\":\"Doe\",\"div_id\":\"1\",\"pos_id\":\"1\",\"role_id\":\"1\",\"gender\":\"male\",\"email\":\"john.doe@gmail.com\",\"updated_at\":\"2025-08-13 01:52:17\",\"password\":\"$2y$10$yebdxpWQ9wCoQ254T\\/6a3eIWMcFozQwkssouaiHVZ6nHN9EJjGCHS\"}', '2025-08-13 01:52:17', '2025-08-13 01:52:17', '2025-08-13 01:52:17'),
(50, 1235, 'LOGOUT', 'employees', 1235, 'Sample Name Database', 'sampledata@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:52:20', '2025-08-13 01:52:20', '2025-08-13 01:52:20'),
(51, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:52:23', '2025-08-13 01:52:23', '2025-08-13 01:52:23'),
(52, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:55:10', '2025-08-13 01:55:10', '2025-08-13 01:55:10'),
(53, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:59:44', '2025-08-13 01:59:44', '2025-08-13 01:59:44'),
(54, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:59:50', '2025-08-13 01:59:50', '2025-08-13 01:59:50'),
(55, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:59:54', '2025-08-13 01:59:54', '2025-08-13 01:59:54'),
(56, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 01:59:58', '2025-08-13 01:59:58', '2025-08-13 01:59:58'),
(57, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:14:49', '2025-08-13 02:14:49', '2025-08-13 02:14:49'),
(58, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:14:57', '2025-08-13 02:14:57', '2025-08-13 02:14:57'),
(59, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:15:00', '2025-08-13 02:15:00', '2025-08-13 02:15:00'),
(60, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:15:06', '2025-08-13 02:15:06', '2025-08-13 02:15:06'),
(61, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:17:57', '2025-08-13 02:17:57', '2025-08-13 02:17:57'),
(62, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:17:59', '2025-08-13 02:17:59', '2025-08-13 02:17:59'),
(63, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:18:03', '2025-08-13 02:18:03', '2025-08-13 02:18:03'),
(64, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:18:06', '2025-08-13 02:18:06', '2025-08-13 02:18:06'),
(65, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:21:53', '2025-08-13 02:21:53', '2025-08-13 02:21:53'),
(66, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:21:59', '2025-08-13 02:21:59', '2025-08-13 02:21:59'),
(67, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:22:03', '2025-08-13 02:22:03', '2025-08-13 02:22:03'),
(68, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:22:07', '2025-08-13 02:22:07', '2025-08-13 02:22:07'),
(69, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:31:05', '2025-08-13 02:31:05', '2025-08-13 02:31:05'),
(70, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:39:48', '2025-08-13 02:39:48', '2025-08-13 02:39:48'),
(71, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:39:50', '2025-08-13 02:39:50', '2025-08-13 02:39:50'),
(72, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:39:52', '2025-08-13 02:39:52', '2025-08-13 02:39:52'),
(73, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:39:55', '2025-08-13 02:39:55', '2025-08-13 02:39:55'),
(74, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:43:14', '2025-08-13 02:43:14', '2025-08-13 02:43:14'),
(75, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:49:53', '2025-08-13 02:49:53', '2025-08-13 02:49:53'),
(76, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:49:56', '2025-08-13 02:49:56', '2025-08-13 02:49:56'),
(77, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 02:49:59', '2025-08-13 02:49:59', '2025-08-13 02:49:59'),
(78, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 03:39:41', '2025-08-13 03:39:41', '2025-08-13 03:39:41'),
(79, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 03:40:06', '2025-08-13 03:40:06', '2025-08-13 03:40:06'),
(80, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 03:40:09', '2025-08-13 03:40:09', '2025-08-13 03:40:09'),
(81, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 03:40:11', '2025-08-13 03:40:11', '2025-08-13 03:40:11'),
(82, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 03:42:19', '2025-08-13 03:42:19', '2025-08-13 03:42:19'),
(83, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 03:42:21', '2025-08-13 03:42:21', '2025-08-13 03:42:21'),
(84, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 03:42:24', '2025-08-13 03:42:24', '2025-08-13 03:42:24'),
(85, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 03:57:49', '2025-08-13 03:57:49', '2025-08-13 03:57:49'),
(86, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 03:57:52', '2025-08-13 03:57:52', '2025-08-13 03:57:52'),
(87, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:12:29', '2025-08-13 04:12:29', '2025-08-13 04:12:29'),
(88, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:12:33', '2025-08-13 04:12:33', '2025-08-13 04:12:33'),
(89, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:12:37', '2025-08-13 04:12:37', '2025-08-13 04:12:37'),
(90, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:12:55', '2025-08-13 04:12:55', '2025-08-13 04:12:55'),
(91, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:15:03', '2025-08-13 04:15:03', '2025-08-13 04:15:03'),
(92, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:15:08', '2025-08-13 04:15:08', '2025-08-13 04:15:08'),
(93, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:17:23', '2025-08-13 04:17:23', '2025-08-13 04:17:23'),
(94, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:17:27', '2025-08-13 04:17:27', '2025-08-13 04:17:27'),
(95, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:17:29', '2025-08-13 04:17:29', '2025-08-13 04:17:29'),
(96, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:17:32', '2025-08-13 04:17:32', '2025-08-13 04:17:32'),
(97, 1262, 'UPDATE', 'plan', 42, '', '', 'Plan status updated to: approved by Member', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, '{\"status\":\"approved\",\"remarks\":\"Plan approved for implementation by John Doe (Member)\",\"approved_by\":\"1262\",\"approved_at\":\"2025-08-13 04:27:15\"}', '2025-08-13 04:27:15', '2025-08-13 04:27:15', '2025-08-13 04:27:15'),
(98, 1262, 'UPDATE', 'plan', 42, '', '', 'Plan status updated to: pending by Member', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, '{\"status\":\"pending\",\"remarks\":\"Plan reopened for review by John Doe (Member)\",\"reviewed_by\":\"1262\",\"reviewed_at\":\"2025-08-13 04:27:22\"}', '2025-08-13 04:27:22', '2025-08-13 04:27:22', '2025-08-13 04:27:22'),
(99, 1262, 'UPDATE', 'plan', 42, '', '', 'Plan status updated to: returned by Member', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, '{\"status\":\"returned\",\"remarks\":\"Please Revise Anything\",\"returned_by\":\"1262\",\"returned_at\":\"2025-08-13 04:27:39\"}', '2025-08-13 04:27:39', '2025-08-13 04:27:39', '2025-08-13 04:27:39'),
(100, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:27:43', '2025-08-13 04:27:43', '2025-08-13 04:27:43'),
(101, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:27:47', '2025-08-13 04:27:47', '2025-08-13 04:27:47'),
(102, 13, 'UPDATE', 'plan', 42, 'To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', 'john.doe@gmail.com', 'GAD Plan saved as draft: To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '{\"plan_id\":\"42\",\"approved_by\":\"1262\",\"authors_division\":\"1\",\"budget\":\"250000.00\",\"cause\":\"Limited award or recognition given to women in the Cagayan Valley durinf Women\'s Month\",\"indicator_text\":\"[\\\"No. of Women awardees\\\",\\\"No.of produced GAD-related feature stories\\\",\\\"No. of produced  GAD-related videos\\\",\\\"No. of produced GAD-related news stories\\\"]\",\"target_text\":\"[\\\"\\\",\\\"\\\",\\\"\\\",\\\"\\\"]\",\"issue_mandate\":\"Under the Magna Carta of Women(MCW) Chapter IV Sec.36. Gender Mainstreaming as a strategy for implementing the MCW\",\"mfo_id\":null,\"pap_id\":null,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFO\\\",\\\"statement\\\":\\\"Development Communication Services\\\"}]\",\"endDate\":\"2025-09-06\",\"gad_objective\":\"[\\\"To boost morale of women-awardees from different sectors in the society\\\"]\",\"activity\":\"To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector\",\"startDate\":\"2025-08-10\",\"created_at\":\"2025-08-13 00:23:14\",\"updated_at\":\"2025-08-13 04:37:52\",\"status\":\"Draft\",\"hgdg_score\":\"20.00\",\"file_attachments\":\"[]\",\"responsible_units\":\"[\\\"Region IX\\\",\\\"Region VII\\\"]\",\"reviewed_by\":\"1262\",\"reviewed_at\":\"2025-08-13 04:27:22\",\"returned_by\":\"1262\",\"returned_at\":\"2025-08-13 04:27:39\",\"approved_at\":\"2025-08-13 04:27:15\",\"remarks\":\"Please Revise Anything\",\"indicators\":null}', '{\"plan_id\":\"42\",\"issue_mandate\":\"Under the Magna Carta of Women(MCW) Chapter IV Sec.36. Gender Mainstreaming as a strategy for implementing the MCW\",\"cause\":\"Limited award or recognition given to women in the Cagayan Valley durinf Women\'s Month\",\"gad_objective\":\"[\\\"To boost morale of women-awardees from different sectors in the society\\\"]\",\"activity\":\"To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector\",\"indicator_text\":\"[\\\"No. of Women awardees\\\",\\\"No.of produced GAD-related feature stories\\\",\\\"No. of produced  GAD-related videos\\\",\\\"No. of produced GAD-related news stories\\\"]\",\"target_text\":\"[\\\"\\\",\\\"\\\",\\\"\\\",\\\"\\\"]\",\"startDate\":\"2025-08-10\",\"endDate\":\"2025-09-06\",\"responsible_units\":\"[\\\"Region IX\\\",\\\"Region VII\\\"]\",\"authors_division\":\"1\",\"status\":\"Draft\",\"budget\":\"250000.00\",\"hgdg_score\":\"20.00\",\"file_attachments\":\"[]\",\"is_draft\":1,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFO\\\",\\\"statement\\\":\\\"Development Communication Services\\\"}]\"}', '2025-08-13 04:37:52', '2025-08-13 04:37:52', '2025-08-13 04:37:52'),
(103, 13, 'DELETE', 'plan', 42, 'To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', 'john.doe@gmail.com', 'GAD Plan deleted: To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '{\"plan_id\":\"42\",\"approved_by\":\"1262\",\"authors_division\":\"1\",\"budget\":\"250000.00\",\"cause\":\"Limited award or recognition given to women in the Cagayan Valley durinf Women\'s Month\",\"indicator_text\":\"[\\\"No. of Women awardees\\\",\\\"No.of produced GAD-related feature stories\\\",\\\"No. of produced  GAD-related videos\\\",\\\"No. of produced GAD-related news stories\\\"]\",\"target_text\":\"[\\\"\\\",\\\"\\\",\\\"\\\",\\\"\\\"]\",\"issue_mandate\":\"Under the Magna Carta of Women(MCW) Chapter IV Sec.36. Gender Mainstreaming as a strategy for implementing the MCW\",\"mfo_id\":null,\"pap_id\":null,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFO\\\",\\\"statement\\\":\\\"Development Communication Services\\\"}]\",\"endDate\":\"2025-09-06\",\"gad_objective\":\"[\\\"To boost morale of women-awardees from different sectors in the society\\\"]\",\"activity\":\"To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector\",\"startDate\":\"2025-08-10\",\"created_at\":\"2025-08-13 00:23:14\",\"updated_at\":\"2025-08-13 04:37:52\",\"status\":\"Draft\",\"hgdg_score\":\"20.00\",\"file_attachments\":\"[]\",\"responsible_units\":\"[\\\"Region IX\\\",\\\"Region VII\\\"]\",\"reviewed_by\":\"1262\",\"reviewed_at\":\"2025-08-13 04:27:22\",\"returned_by\":\"1262\",\"returned_at\":\"2025-08-13 04:27:39\",\"approved_at\":\"2025-08-13 04:27:15\",\"remarks\":\"Please Revise Anything\",\"indicators\":null}', NULL, '2025-08-13 04:37:59', '2025-08-13 04:37:59', '2025-08-13 04:37:59'),
(104, 13, 'CREATE', 'plan', 43, 'To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', 'john.doe@gmail.com', 'GAD Plan saved as draft: To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, '{\"plan_id\":\"\",\"issue_mandate\":\"Under the Magna Carta of Women(MCW) Chapter IV Sec.36. Gender Mainstreaming as a strategy for implementing the MCW\",\"cause\":\"Limited award or recognition given to women in the Cagayan Valley durinf Women\'s Month\",\"gad_objective\":\"[\\\"To boost morale of women-awardees from different sectors in the society\\\"]\",\"activity\":\"To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector\",\"indicator_text\":\"[\\\"No.of produced GAD-related feature stories\\\",\\\"No. of produced  GAD-related videos\\\",\\\"No. of produced GAD-related social media cards\\\"]\",\"target_text\":\"[\\\"\\\",\\\"\\\",\\\"\\\"]\",\"startDate\":\"2025-08-12\",\"endDate\":\"2025-08-16\",\"responsible_units\":\"[\\\"Region IX\\\",\\\"Region VI\\\"]\",\"authors_division\":\"1\",\"status\":\"Draft\",\"budget\":\"\",\"hgdg_score\":\"24\",\"file_attachments\":\"[\\\"Uploads\\\\\\/1755059972_c99bfdcc1c81c5334604.pdf\\\"]\",\"is_draft\":1,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFO\\\",\\\"statement\\\":\\\"Development Communication Services\\\"}]\"}', '2025-08-13 04:39:32', '2025-08-13 04:39:32', '2025-08-13 04:39:32');
INSERT INTO `audit_trail` (`id`, `user_id`, `action`, `table_name`, `record_id`, `employee_name`, `employee_email`, `details`, `ip_address`, `user_agent`, `old_data`, `new_data`, `created_at`, `updated_at`, `timestamp`) VALUES
(105, 13, 'UPDATE', 'plan', 43, 'To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', 'john.doe@gmail.com', 'GAD Plan updated: To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '{\"plan_id\":\"43\",\"approved_by\":null,\"authors_division\":\"1\",\"budget\":\"120000.00\",\"cause\":\"Limited award or recognition given to women in the Cagayan Valley durinf Women\'s Month\",\"indicator_text\":\"[\\\"No.of produced GAD-related feature stories\\\",\\\"No. of produced  GAD-related videos\\\",\\\"No. of produced GAD-related social media cards\\\"]\",\"target_text\":\"[\\\"\\\",\\\"\\\",\\\"\\\"]\",\"issue_mandate\":\"Under the Magna Carta of Women(MCW) Chapter IV Sec.36. Gender Mainstreaming as a strategy for implementing the MCW\",\"mfo_id\":null,\"pap_id\":null,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFO\\\",\\\"statement\\\":\\\"Development Communication Services\\\"}]\",\"endDate\":\"2025-08-16\",\"gad_objective\":\"[\\\"To boost morale of women-awardees from different sectors in the society\\\"]\",\"activity\":\"To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector\",\"startDate\":\"2025-08-12\",\"created_at\":\"2025-08-13 04:39:32\",\"updated_at\":\"2025-08-13 04:40:34\",\"status\":\"Pending\",\"hgdg_score\":\"24.00\",\"file_attachments\":\"[\\\"Uploads\\\\\\/1755060034_ffb8101bc72d534215f1.pdf\\\"]\",\"responsible_units\":\"[\\\"Region IX\\\",\\\"Region VI\\\"]\",\"reviewed_by\":null,\"reviewed_at\":null,\"returned_by\":null,\"returned_at\":null,\"approved_at\":null,\"remarks\":null,\"indicators\":null}', '{\"plan_id\":\"43\",\"issue_mandate\":\"Under the Magna Carta of Women(MCW) Chapter IV Sec.36. Gender Mainstreaming as a strategy for implementing the MCW\",\"cause\":\"Limited award or recognition given to women in the Cagayan Valley durinf Women\'s Month\",\"gad_objective\":\"[\\\"To boost morale of women-awardees from different sectors in the society\\\"]\",\"activity\":\"To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector\",\"indicator_text\":\"[\\\"No.of produced GAD-related feature stories\\\",\\\"No. of produced  GAD-related videos\\\",\\\"No. of produced GAD-related social media cards\\\"]\",\"target_text\":\"[\\\"\\\",\\\"\\\",\\\"\\\"]\",\"startDate\":\"2025-08-12\",\"endDate\":\"2025-08-16\",\"responsible_units\":\"[\\\"Region IX\\\",\\\"Region VI\\\"]\",\"authors_division\":\"1\",\"status\":\"Pending\",\"budget\":\"120000.00\",\"hgdg_score\":\"24.00\",\"file_attachments\":\"[\\\"Uploads\\\\\\/1755060034_ffb8101bc72d534215f1.pdf\\\"]\",\"is_draft\":0,\"mfoPapData\":\"[{\\\"type\\\":\\\"MFO\\\",\\\"statement\\\":\\\"Development Communication Services\\\"}]\"}', '2025-08-13 04:40:34', '2025-08-13 04:40:34', '2025-08-13 04:40:34'),
(106, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:40:49', '2025-08-13 04:40:49', '2025-08-13 04:40:49'),
(107, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:40:52', '2025-08-13 04:40:52', '2025-08-13 04:40:52'),
(108, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:40:54', '2025-08-13 04:40:54', '2025-08-13 04:40:54'),
(109, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:40:57', '2025-08-13 04:40:57', '2025-08-13 04:40:57'),
(110, 1262, 'UPDATE', 'plan', 43, '', '', 'Plan returned to Focal for revision (marked as Draft)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, '{\"status\":\"Draft\",\"remarks\":\"Please Revise Anything\",\"returned_by\":\"1262\",\"returned_at\":\"2025-08-13 04:41:31\"}', '2025-08-13 04:41:31', '2025-08-13 04:41:31', '2025-08-13 04:41:31'),
(111, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:41:35', '2025-08-13 04:41:35', '2025-08-13 04:41:35'),
(112, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:41:40', '2025-08-13 04:41:40', '2025-08-13 04:41:40'),
(113, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:42:17', '2025-08-13 04:42:17', '2025-08-13 04:42:17'),
(114, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:42:21', '2025-08-13 04:42:21', '2025-08-13 04:42:21'),
(115, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:42:34', '2025-08-13 04:42:34', '2025-08-13 04:42:34'),
(116, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:42:43', '2025-08-13 04:42:43', '2025-08-13 04:42:43'),
(117, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:42:45', '2025-08-13 04:42:45', '2025-08-13 04:42:45'),
(118, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:42:48', '2025-08-13 04:42:48', '2025-08-13 04:42:48'),
(119, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:42:58', '2025-08-13 04:42:58', '2025-08-13 04:42:58'),
(120, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:50:56', '2025-08-13 04:50:56', '2025-08-13 04:50:56'),
(121, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:51:00', '2025-08-13 04:51:00', '2025-08-13 04:51:00'),
(122, 1262, 'UPDATE', 'plan', 43, '', '', 'Plan approved by Member', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, '{\"status\":\"approved\",\"remarks\":\"Approved\",\"approved_by\":\"1262\",\"approved_at\":\"2025-08-13 04:53:51\"}', '2025-08-13 04:53:51', '2025-08-13 04:53:51', '2025-08-13 04:53:51'),
(123, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:54:41', '2025-08-13 04:54:41', '2025-08-13 04:54:41'),
(124, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 04:54:44', '2025-08-13 04:54:44', '2025-08-13 04:54:44'),
(125, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 12:06:54', '2025-08-13 12:06:54', '2025-08-13 12:06:54'),
(126, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 12:10:42', '2025-08-13 12:10:42', '2025-08-13 12:10:42'),
(127, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 12:10:50', '2025-08-13 12:10:50', '2025-08-13 12:10:50'),
(128, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 12:10:53', '2025-08-13 12:10:53', '2025-08-13 12:10:53'),
(129, 13, 'LOGOUT', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 12:12:32', '2025-08-13 12:12:32', '2025-08-13 12:12:32'),
(130, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 12:12:37', '2025-08-13 12:12:37', '2025-08-13 12:12:37'),
(131, 1262, 'LOGOUT', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 12:12:46', '2025-08-13 12:12:46', '2025-08-13 12:12:46'),
(132, 1262, 'LOGIN', 'employees', 1262, 'John Doe', 'johnmichael.cinco.piagov2@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 12:12:52', '2025-08-13 12:12:52', '2025-08-13 12:12:52'),
(133, 13, 'LOGIN', 'employees', 13, 'John Doe', 'john.doe@gmail.com', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', NULL, NULL, '2025-08-13 12:13:00', '2025-08-13 12:13:00', '2025-08-13 12:13:00');

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `act_id` int(11) NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `obj_id` int(11) DEFAULT NULL,
  `src_id` int(11) DEFAULT NULL,
  `particulars` text DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `type_of_expense` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`act_id`, `plan_id`, `obj_id`, `src_id`, `particulars`, `amount`, `type_of_expense`) VALUES
(9, 43, 14, 1, 'Representation', 25000.00, 'Direct Expense'),
(10, 43, 9, 1, 'Supplies', 95000.00, 'Direct Expense');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `div_id` int(11) NOT NULL,
  `div_code` varchar(50) NOT NULL,
  `division` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`div_id`, `div_code`, `division`) VALUES
(1, 'ODG', 'Office of the Director-General'),
(2, 'ODDG-FLASC', 'Office of the Deputy Director-General for Finance, Legal Administration, and Special Concern'),
(3, 'ADMIN', 'Administrative Division'),
(4, 'CPSD', 'Creative and Production Services Division'),
(5, 'FMD', 'Finance and Management Division'),
(6, 'HRDD', 'Human Resource Development Division'),
(7, 'MISD', 'Management Information Systems Division'),
(8, 'PCRD', 'Planning and Communication Research Division'),
(9, 'PMD', 'Program Management Division'),
(10, 'ROD', 'Regional Operations Division'),
(11, 'RO1', 'Region I'),
(12, 'RO2', 'Region II'),
(13, 'RO3', 'Region III'),
(14, 'RO4A', 'Region IV-A'),
(15, 'MIMAROPA', 'MIMAROPA'),
(16, 'RO5', 'Region V'),
(17, 'RO6', 'Region VI'),
(18, 'RO7', 'Region VII'),
(19, 'RO8', 'Region VIII'),
(20, 'RO9', 'Region IX'),
(21, 'RO10', 'Region X'),
(22, 'RO11', 'Region XI'),
(23, 'RO12', 'Region XII'),
(24, 'RO13', 'Region XIII'),
(25, 'CAR', 'Cordillera Administrative Region'),
(26, 'NCR', 'National Capital Region');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `div_id` int(11) NOT NULL,
  `pos_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `first_name`, `last_name`, `div_id`, `pos_id`, `role_id`, `gender`, `email`, `password`, `created_at`, `updated_at`) VALUES
(13, 'John', 'Doe', 1, 1, 1, 'Male', 'john.doe@gmail.com', '$2y$10$yebdxpWQ9wCoQ254T/6a3eIWMcFozQwkssouaiHVZ6nHN9EJjGCHS', NULL, '2025-08-13 01:52:17'),
(1235, 'Sample Name', 'Database', 1, 4, 4, 'Male', 'sampledata@gmail.com', '$2y$10$8mKG6AMl0bX69w1cNatv7eqeccyYCvPvBgT7kc7mIfErBLh95rqHa', NULL, NULL),
(1255, 'Secretariat', 'Account', 7, 11, 3, 'Male', 'pdgem029@gmail.com', '$2y$10$dCmeg3cspwW4dq9hyvktgephH5vqbGnUB6gUqDZgx.A4m6xyVK1x.', '2025-08-06 07:07:52', '2025-08-09 11:32:57'),
(1262, 'John', 'Doe', 7, 2, 2, 'Female', 'johnmichael.cinco.piagov2@gmail.com', '$2y$10$LNEP/75ms8M.tERk47y9reSaj3mbGt0MCeWqxZuavFHGLnf1iPx2e', '2025-08-12 07:40:06', '2025-08-13 01:00:59');

-- --------------------------------------------------------

--
-- Table structure for table `gad_mandate`
--

CREATE TABLE `gad_mandate` (
  `id` int(11) NOT NULL,
  `year` varchar(4) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gad_mandate`
--

INSERT INTO `gad_mandate` (`id`, `year`, `description`, `created_at`, `updated_at`) VALUES
(2, '2025', 'Under the Magna Carta of Women (MCW) Chapter IV Sec 16. Nondiscriminatory and Nonderogatory Portrayal of Women in Media and Film and under the Gender Equality, and Women Empowerment (GEWE) Plan Strategic Goals Area 7 Chapter 15: Transforming Gender Norms and Culture.', '2025-08-05 05:36:45', '2025-08-11 05:17:23'),
(3, '2025', 'Under the Magna Carta of Women Sec. 26. Right to information. Limited access to information regarding policies on women, including programs, projects, and funding outlays that affect them, shall be ensured', '2025-08-05 05:36:57', '2025-08-11 07:48:45'),
(8, '2025', 'Under the Magna Carta of Women(MCW) Chapter IV Sec. 36. Gender Mainstreaming as a strategy for implementing the MCW', '2025-08-11 08:33:19', '2025-08-11 08:33:19'),
(9, '2025', 'Under the Magna Carta of Women(MCW) Chapter IV Sec.36. Gender Mainstreaming as a strategy for implementing the MCW', '2025-08-11 08:39:33', '2025-08-11 08:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `gad_plans`
--

CREATE TABLE `gad_plans` (
  `id` int(11) NOT NULL,
  `genderIssue` text NOT NULL,
  `causeOfIssue` text NOT NULL,
  `gadObjective` text NOT NULL,
  `gadActivity` text NOT NULL,
  `performanceTargets` text NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `responsibleUnit` varchar(255) NOT NULL,
  `budgetAmount` decimal(15,2) NOT NULL,
  `mfoPapData` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mfo`
--

CREATE TABLE `mfo` (
  `mfo_id` int(11) NOT NULL,
  `mfo_code` varchar(100) DEFAULT NULL,
  `mfo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mfo`
--

INSERT INTO `mfo` (`mfo_id`, `mfo_code`, `mfo`) VALUES
(5, '1a', 'General Management and Supervision');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `object_of_expense`
--

CREATE TABLE `object_of_expense` (
  `obj_id` int(11) NOT NULL,
  `object_name` varchar(255) NOT NULL,
  `uacs_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `object_of_expense`
--

INSERT INTO `object_of_expense` (`obj_id`, `object_name`, `uacs_code`) VALUES
(1, 'Salaries and Wages', '50101010 00'),
(2, 'Traveling Expenses-Local', '50201010 00'),
(3, 'Traveling Expenses-Foreign', '50201020 00'),
(4, 'Training Expenses', '50202010 00'),
(5, 'Scholarship Grants Expenses', '50202020 00'),
(6, 'ICT Office Supplies', '50203010 01'),
(7, 'Office Supplies Expenses', '50203010 02'),
(8, 'Fuel, Oil, and Lubricants Exp.', '50203090 00'),
(9, 'Semi-expendable -Office Equip\'t', '50203210 02'),
(10, 'Semi-expendable -ICT Equip\'t', '50203210 03'),
(11, 'Semi-expendable -Communication Equip\'t', '50203210 07'),
(12, 'Semi-expendable -Other Machinery & Equipment', '50203210 99'),
(13, 'Semi-expendable - Furniture & Fixtures', '50203220 01'),
(14, 'Other Supplies & Materials exp.', '50203990 00'),
(15, 'Water Expenses', '50204010 00'),
(16, 'Electricity Expenses', '50204020 00'),
(17, 'Postage & Courier Services', '50205010 00'),
(18, 'Mobile', '50205020 01'),
(19, 'Landline', '50205020 02'),
(20, 'Internet Subscription Expenses', '50205030 00'),
(21, 'Cable, Satellite, Telegraph, & Radio Exp.', '50205040 00'),
(22, 'Extraordinary & Misc. Exp.', '50210030 01'),
(23, 'Legal Services', '50211010 00'),
(24, 'Auditing Services', '50211020 00'),
(25, 'Consultancy Services', '50211030 00'),
(26, 'Other Professional Services', '50211990 00'),
(27, 'Janitorial Services', '50212020 00'),
(28, 'Security Services', '50212030 00'),
(29, 'Other General Services', '50212990 00'),
(30, 'Repair and Maintenance-Buildings', '50213040 01'),
(31, 'Repair and Maintenance-Other Structures', '50213040 99'),
(32, 'Repair and Maintenance-Machinery', '50213050 01'),
(33, 'Repair and Maintenance-Office Equipment', '50213050 02'),
(34, 'Repair and Maintenance- ICT Equipment', '50213050 03'),
(35, 'Repair and Maintenance-Communication Equipment', '50213050 07'),
(36, 'Repair and Maintenance-Printing Equipment', '50213050 12'),
(37, 'Repair and Maintenance-Other Machinery', '50213050 99'),
(38, 'Repair and Maintenance- Motor Vehicles', '50213060 01'),
(39, 'Repair and Maintenance-Furniture and Fixture', '50213070 00'),
(40, 'Leased Assets-Building and Other Structures', '50213080 01'),
(41, 'Taxes, Duties, and Licenses', '50215010 01'),
(42, 'Fidelity Bond Premiums', '50215020 00'),
(43, 'Insurance Expenses', '50215030 00'),
(44, 'Advertising Expenses', '50299010 00'),
(45, 'Printing and Publication Exp.', '50299020 00'),
(46, 'Representation Expenses', '50299030 00'),
(47, 'Transportation & Delivery Exp.', '50299040 00'),
(48, 'Rent-Building', '50299050 01'),
(49, 'Rent-Motor Vehicles', '50299050 03'),
(50, 'Rent-Equipment', '50299050 04'),
(51, 'Membership Dues & Cont.', '50299060 00'),
(52, 'ICT Software Subscription', '50299070 01'),
(53, 'Other Subscription Expenses', '50299070 99'),
(54, 'Other MOOE', '50299990 99'),
(55, 'Accountable Forms', '50203020 00');

-- --------------------------------------------------------

--
-- Table structure for table `output`
--

CREATE TABLE `output` (
  `output_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `output_date` datetime DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pap`
--

CREATE TABLE `pap` (
  `mfo_id` int(11) DEFAULT NULL,
  `pap` text DEFAULT NULL,
  `pap_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pap`
--

INSERT INTO `pap` (`mfo_id`, `pap`, `pap_id`) VALUES
(5, 'I. GENERAL ADMINISTRATION AND SUPPORT SERVICES', 13);

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `plan_id` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `authors_division` int(11) DEFAULT NULL,
  `budget` decimal(12,2) DEFAULT NULL,
  `cause` text DEFAULT NULL,
  `indicator_text` text DEFAULT NULL,
  `target_text` text DEFAULT NULL,
  `issue_mandate` text DEFAULT NULL,
  `mfo_id` int(11) DEFAULT NULL,
  `pap_id` int(11) DEFAULT NULL,
  `mfoPapData` text DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `gad_objective` text DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending',
  `hgdg_score` decimal(5,2) DEFAULT NULL COMMENT 'HGDG Score (0.00 to 100.00)',
  `file_attachments` text DEFAULT NULL COMMENT 'Stores file paths or references as JSON array',
  `responsible_units` text DEFAULT NULL COMMENT 'Stores multiple responsible units as JSON array',
  `reviewed_by` int(11) DEFAULT NULL COMMENT 'User ID who reviewed the plan',
  `reviewed_at` datetime DEFAULT NULL COMMENT 'When the plan was reviewed',
  `returned_by` int(11) DEFAULT NULL COMMENT 'User ID who returned the plan',
  `returned_at` datetime DEFAULT NULL COMMENT 'When the plan was returned',
  `approved_at` datetime DEFAULT NULL COMMENT 'When the plan was approved',
  `remarks` text DEFAULT NULL COMMENT 'Review remarks and comments',
  `indicators` text DEFAULT NULL COMMENT 'Plan indicators'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`plan_id`, `approved_by`, `authors_division`, `budget`, `cause`, `indicator_text`, `target_text`, `issue_mandate`, `mfo_id`, `pap_id`, `mfoPapData`, `endDate`, `gad_objective`, `activity`, `startDate`, `created_at`, `updated_at`, `status`, `hgdg_score`, `file_attachments`, `responsible_units`, `reviewed_by`, `reviewed_at`, `returned_by`, `returned_at`, `approved_at`, `remarks`, `indicators`) VALUES
(43, 1262, 1, 120000.00, 'Limited award or recognition given to women in the Cagayan Valley durinf Women\'s Month', '[\"No.of produced GAD-related feature stories\",\"No. of produced  GAD-related videos\",\"No. of produced GAD-related social media cards\"]', '[\"\",\"\",\"\"]', 'Under the Magna Carta of Women(MCW) Chapter IV Sec.36. Gender Mainstreaming as a strategy for implementing the MCW', NULL, NULL, '[{\"type\":\"MFO\",\"statement\":\"Development Communication Services\"}]', '2025-08-16', '[\"To boost morale of women-awardees from different sectors in the society\"]', 'To conduct IDDU, an annual recognition institutionalized by PIA Region 2 which aims to recognize woman-honorees whose exemplary performances and outstanding achievements continue to serve as inspiration and model to the rest of the women sector', '2025-08-12', '2025-08-13 04:39:32', '2025-08-13 12:53:51', 'approved', 24.00, '[\"Uploads\\/1755060034_ffb8101bc72d534215f1.pdf\"]', '[\"Region IX\",\"Region VI\"]', NULL, NULL, 1262, '2025-08-13 04:41:31', '2025-08-13 04:53:51', 'Approved', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `pos_id` int(11) NOT NULL,
  `position` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`pos_id`, `position`, `code`) VALUES
(1, 'Chief Administrative Officer', 'CADOF'),
(2, 'Supervising Administrative Officer', 'SADOF'),
(3, 'Information Officer V', 'INFO5'),
(4, 'Information Officer IV', 'INFO4'),
(5, 'Information Officer III', 'INFO3'),
(6, 'Information Officer II', 'INFO2'),
(7, 'Information Officer I', 'INFO1'),
(8, 'Information Technology Officer I', 'ITO1'),
(9, 'Information Systems Analyst II', 'ISA2'),
(10, 'Computer Programmer III', 'CP3'),
(11, 'Computer Programmer II', 'CP2'),
(12, 'Administrative Officer V', 'ADOF5'),
(13, 'Administrative Officer IV', 'ADOF4'),
(14, 'Administrative Officer II', 'ADOF2'),
(15, 'Administrative Assistant VI', 'ADAS6'),
(16, 'Administrative Assistant V', 'ADAS5'),
(17, 'Administrative Assistant IV', 'ADAS4'),
(18, 'Administrative Assistant III', 'ADAS3'),
(19, 'Administrative Assistant II', 'ADAS2');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role`) VALUES
(1, 'Focal'),
(2, 'Member'),
(3, 'Secretariat'),
(4, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `source_of_fund`
--

CREATE TABLE `source_of_fund` (
  `src_id` int(11) NOT NULL,
  `source_name` varchar(255) NOT NULL,
  `fund_cluster` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `source_of_fund`
--

INSERT INTO `source_of_fund` (`src_id`, `source_name`, `fund_cluster`) VALUES
(1, 'Primary Source', 'General Fund'),
(2, 'Other Sources', 'Others');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_table_name` (`table_name`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`act_id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `obj_id` (`obj_id`),
  ADD KEY `src_id` (`src_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`div_id`),
  ADD UNIQUE KEY `division` (`division`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_role_id` (`role_id`),
  ADD KEY `fk_div_id` (`div_id`),
  ADD KEY `fk_pos_id` (`pos_id`);

--
-- Indexes for table `gad_mandate`
--
ALTER TABLE `gad_mandate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gad_plans`
--
ALTER TABLE `gad_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mfo`
--
ALTER TABLE `mfo`
  ADD PRIMARY KEY (`mfo_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `object_of_expense`
--
ALTER TABLE `object_of_expense`
  ADD PRIMARY KEY (`obj_id`);

--
-- Indexes for table `output`
--
ALTER TABLE `output`
  ADD PRIMARY KEY (`output_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `pap`
--
ALTER TABLE `pap`
  ADD PRIMARY KEY (`pap_id`),
  ADD KEY `fk_pap_mfo` (`mfo_id`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `mfo_id` (`mfo_id`),
  ADD KEY `pap_id` (`pap_id`),
  ADD KEY `idx_plan_reviewed_by` (`reviewed_by`),
  ADD KEY `idx_plan_returned_by` (`returned_by`),
  ADD KEY `idx_plan_approved_by` (`approved_by`),
  ADD KEY `idx_plan_reviewed_at` (`reviewed_at`),
  ADD KEY `idx_plan_returned_at` (`returned_at`),
  ADD KEY `idx_plan_approved_at` (`approved_at`),
  ADD KEY `fk_plan_authors_division` (`authors_division`),
  ADD KEY `idx_plan_status` (`status`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`pos_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `source_of_fund`
--
ALTER TABLE `source_of_fund`
  ADD PRIMARY KEY (`src_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `act_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `div_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1263;

--
-- AUTO_INCREMENT for table `gad_mandate`
--
ALTER TABLE `gad_mandate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `gad_plans`
--
ALTER TABLE `gad_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mfo`
--
ALTER TABLE `mfo`
  MODIFY `mfo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `object_of_expense`
--
ALTER TABLE `object_of_expense`
  MODIFY `obj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `output`
--
ALTER TABLE `output`
  MODIFY `output_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pap`
--
ALTER TABLE `pap`
  MODIFY `pap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `source_of_fund`
--
ALTER TABLE `source_of_fund`
  MODIFY `src_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `employees` (`emp_id`);

--
-- Constraints for table `budget`
--
ALTER TABLE `budget`
  ADD CONSTRAINT `budget_ibfk_2` FOREIGN KEY (`obj_id`) REFERENCES `object_of_expense` (`obj_id`),
  ADD CONSTRAINT `budget_ibfk_3` FOREIGN KEY (`src_id`) REFERENCES `source_of_fund` (`src_id`),
  ADD CONSTRAINT `fk_budget_plan` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_div_id` FOREIGN KEY (`div_id`) REFERENCES `divisions` (`div_id`),
  ADD CONSTRAINT `fk_pos_id` FOREIGN KEY (`pos_id`) REFERENCES `positions` (`pos_id`),
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `output`
--
ALTER TABLE `output`
  ADD CONSTRAINT `output_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`) ON DELETE CASCADE;

--
-- Constraints for table `pap`
--
ALTER TABLE `pap`
  ADD CONSTRAINT `fk_pap_mfo` FOREIGN KEY (`mfo_id`) REFERENCES `mfo` (`mfo_id`) ON DELETE SET NULL;

--
-- Constraints for table `plan`
--
ALTER TABLE `plan`
  ADD CONSTRAINT `fk_plan_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`emp_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_plan_authors_division` FOREIGN KEY (`authors_division`) REFERENCES `divisions` (`div_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_plan_returned_by` FOREIGN KEY (`returned_by`) REFERENCES `employees` (`emp_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_plan_reviewed_by` FOREIGN KEY (`reviewed_by`) REFERENCES `employees` (`emp_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `plan_ibfk_1` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`emp_id`),
  ADD CONSTRAINT `plan_ibfk_2` FOREIGN KEY (`mfo_id`) REFERENCES `mfo` (`mfo_id`),
  ADD CONSTRAINT `plan_ibfk_3` FOREIGN KEY (`pap_id`) REFERENCES `pap` (`pap_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
