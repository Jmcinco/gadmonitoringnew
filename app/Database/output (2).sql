-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2025 at 09:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
-- Table structure for table `output`
--

CREATE TABLE `output` (
  `accomplishment` varchar(255) DEFAULT NULL,
  `accepted_by` int(11) DEFAULT NULL,
  `date_accomplished` date DEFAULT NULL,
  `file` text DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `output_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `output`
--

INSERT INTO `output` (`accomplishment`, `accepted_by`, `date_accomplished`, `file`, `plan_id`, `remarks`, `status`, `timestamp`, `output_id`) VALUES
('Sample Actual Accomplishment', NULL, '2025-08-14', '1755234530_73353fc22c17aa3bc920.pdf', 43, 'dsadasdasdas', 'completed', '2025-08-15 05:08:50', 1),
('dsadasdasdsa', NULL, '2025-08-14', '1755234674_a0b513b539ddf3baa0e4.pdf', 43, 'dasdasdsada', 'completed', '2025-08-15 05:11:14', 2),
('dsadasdsad', NULL, '2025-08-14', '1755237373_a09f73b433fd8ea8a338.pdf', 43, 'sdsadasdasd', 'pending', '2025-08-15 05:56:13', 3),
('Sample Actual Accomplishment', NULL, '2025-08-13', '1755237885_136e63312bc3fb0469c8.pdf', 44, 'dasdasdas', 'completed', '2025-08-15 06:04:45', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `output`
--
ALTER TABLE `output`
  ADD PRIMARY KEY (`output_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `output`
--
ALTER TABLE `output`
  MODIFY `output_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `output`
--
ALTER TABLE `output`
  ADD CONSTRAINT `output_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
