-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 07:17 AM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`pos_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
