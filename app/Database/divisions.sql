-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 07:16 AM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`div_id`),
  ADD UNIQUE KEY `division` (`division`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `div_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
