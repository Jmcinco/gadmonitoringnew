-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2025 at 03:42 AM
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
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `act_id` int(11) NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `obj_id` int(11) DEFAULT NULL,
  `src_id` int(11) DEFAULT NULL,
  `particulars` text DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `first_name`, `last_name`, `div_id`, `pos_id`, `role_id`, `gender`, `email`, `password`) VALUES
(5, 'Jane', 'Doe', 1, 1, 4, 'Female', 'jane.doe@example.com', '$2y$10$Qe8m5n7pL2k9jB3vX4cD7u8Y9z1xW5v6K7m8n9pL2k9jB3vX4cD7u8'),
(13, 'John Michael', 'Cinco', 1, 1, 1, 'Male', 'johnmichael.cinco.piagov@gmail.com', '$2y$10$OBS3Vp/xGL7Az01AJFGcTOzSfnTh3Sa/dNDQuqoVFPaY.QRJgfZNK'),
(1234, 'John Michael', 'Cinco', 2, 1, 4, 'Male', 'sampledata@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `gad_mandate`
--

CREATE TABLE `gad_mandate` (
  `id` int(11) NOT NULL,
  `year` varchar(4) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `mfo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `object` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pap`
--

CREATE TABLE `pap` (
  `pap_id` int(11) NOT NULL,
  `pap` text DEFAULT NULL,
  `mfo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `plan_id` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `authors_division` varchar(100) DEFAULT NULL,
  `budget` decimal(12,2) DEFAULT NULL,
  `cause` text DEFAULT NULL,
  `indicators` text DEFAULT NULL,
  `issue_mandate` text DEFAULT NULL,
  `mfo_id` int(11) DEFAULT NULL,
  `pap_id` int(11) DEFAULT NULL,
  `mfoPapData` text DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `gad_objective` text DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `pos_id` int(11) NOT NULL,
  `position` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `source` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

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
  ADD UNIQUE KEY `email` (`email`);

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
-- Indexes for table `pap`
--
ALTER TABLE `pap`
  ADD PRIMARY KEY (`pap_id`),
  ADD KEY `mfo_id` (`mfo_id`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `mfo_id` (`mfo_id`),
  ADD KEY `pap_id` (`pap_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`pos_id`);

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
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `act_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `div_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1235;

--
-- AUTO_INCREMENT for table `gad_mandate`
--
ALTER TABLE `gad_mandate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gad_plans`
--
ALTER TABLE `gad_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mfo`
--
ALTER TABLE `mfo`
  MODIFY `mfo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `object_of_expense`
--
ALTER TABLE `object_of_expense`
  MODIFY `obj_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pap`
--
ALTER TABLE `pap`
  MODIFY `pap_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `source_of_fund`
--
ALTER TABLE `source_of_fund`
  MODIFY `src_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget`
--
ALTER TABLE `budget`
  ADD CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`),
  ADD CONSTRAINT `budget_ibfk_2` FOREIGN KEY (`obj_id`) REFERENCES `object_of_expense` (`obj_id`),
  ADD CONSTRAINT `budget_ibfk_3` FOREIGN KEY (`src_id`) REFERENCES `source_of_fund` (`src_id`);

--
-- Constraints for table `pap`
--
ALTER TABLE `pap`
  ADD CONSTRAINT `pap_ibfk_1` FOREIGN KEY (`mfo_id`) REFERENCES `mfo` (`mfo_id`);

--
-- Constraints for table `plan`
--
ALTER TABLE `plan`
  ADD CONSTRAINT `plan_ibfk_1` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`emp_id`),
  ADD CONSTRAINT `plan_ibfk_2` FOREIGN KEY (`mfo_id`) REFERENCES `mfo` (`mfo_id`),
  ADD CONSTRAINT `plan_ibfk_3` FOREIGN KEY (`pap_id`) REFERENCES `pap` (`pap_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
