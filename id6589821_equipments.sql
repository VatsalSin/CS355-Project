-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2019 at 03:44 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id6589821_equipments`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`id6589821_iitp`@`%` FUNCTION `getQty` (`qty` INT(11), `id` INT(11)) RETURNS TINYINT(1) begin
DECLARE x INT(11);
SELECT quantity - quantity_issue into x from equipments where equipments.id = id;
IF x >= qty THEN
RETURN (true);
ELSE
RETURN (false);
END IF;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `specifications` varchar(1023) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_issue` int(11) NOT NULL,
  `lab_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`id`, `name`, `specifications`, `quantity`, `quantity_issue`, `lab_code`) VALUES
(37, 'Pix Hawk', 'Drone Compatible\r\nClone\r\n', 3, 3, 'hardware lab');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `e_id` int(11) NOT NULL,
  `dop` date DEFAULT NULL,
  `dow` date DEFAULT NULL,
  `po` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`e_id`, `dop`, `dow`, `po`, `quantity`) VALUES
(37, '2019-01-01', '0000-00-00', '', 1),
(37, '2014-01-05', '2020-01-08', '1234', 2);

-- --------------------------------------------------------

--
-- Table structure for table `issue`
--

CREATE TABLE `issue` (
  `roll_no` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `e_id` int(11) NOT NULL,
  `doi` date DEFAULT current_timestamp(),
  `dor` date DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `issue`
--

INSERT INTO `issue` (`roll_no`, `e_id`, `doi`, `dor`, `qty`, `status`) VALUES
('1701CS33', 37, '2019-11-06', '2019-11-06', 2, 0),
('1701CS52', 37, '2019-11-06', '2019-01-01', 2, 1),
('1701CS33', 37, '2019-11-06', '2019-12-01', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE `labs` (
  `lab_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lab_incharge` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`lab_name`, `password`, `department`, `lab_incharge`, `email`) VALUES
('hardware lab', '608cb271bb7fb52c99a1a8e003e0f80f57fb41e1', 'CSE', 'Asim Maiti', 'asim@iitp.ac.in');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `roll_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`roll_no`, `name`, `contact`, `email`) VALUES
('1701CS33', 'Piyush Chauhan', '9999900000', 'piyush.cs17@iitp.ac.in'),
('1701CS52', 'Vatsal Singhal', '8585992062', 'vatsal.cs17@iitp.ac.in');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_code` (`lab_code`);
ALTER TABLE `equipments` ADD FULLTEXT KEY `name` (`name`,`specifications`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD KEY `e_id` (`e_id`);

--
-- Indexes for table `issue`
--
ALTER TABLE `issue`
  ADD KEY `roll_no` (`roll_no`),
  ADD KEY `e_id` (`e_id`);

--
-- Indexes for table `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`lab_name`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`roll_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipments`
--
ALTER TABLE `equipments`
  ADD CONSTRAINT `equipments_ibfk_1` FOREIGN KEY (`lab_code`) REFERENCES `labs` (`lab_name`);

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`e_id`) REFERENCES `equipments` (`id`);

--
-- Constraints for table `issue`
--
ALTER TABLE `issue`
  ADD CONSTRAINT `issue_ibfk_1` FOREIGN KEY (`roll_no`) REFERENCES `students` (`roll_no`),
  ADD CONSTRAINT `issue_ibfk_2` FOREIGN KEY (`roll_no`) REFERENCES `students` (`roll_no`),
  ADD CONSTRAINT `issue_ibfk_3` FOREIGN KEY (`e_id`) REFERENCES `equipments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
