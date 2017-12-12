-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2017 at 01:28 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lccdo_tracer`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`username`, `password`) VALUES
('tracer_admin2017', '5a2fc784bfd18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courses`
--

CREATE TABLE `tbl_courses` (
  `course_code` varchar(50) NOT NULL,
  `course_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_courses`
--

INSERT INTO `tbl_courses` (`course_code`, `course_description`) VALUES
('BSA', 'Bachelor of Science in Accountancy'),
('BSIT', 'Bachelor of Science in Information Technology');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_graduates`
--

CREATE TABLE `tbl_graduates` (
  `graduate_id` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `age` int(1) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `year_graduated` varchar(9) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `img` varchar(255) DEFAULT 'avatar.png',
  `status` int(1) NOT NULL,
  `date_registered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_graduates`
--

INSERT INTO `tbl_graduates` (`graduate_id`, `lastname`, `firstname`, `gender`, `age`, `course_code`, `year_graduated`, `username`, `password`, `phone`, `img`, `status`, `date_registered`) VALUES
('5a2e8403301ba', 'Erezo', 'Jan', 'male', 21, 'BSIT', '2016-2017', 'silentroom', '$2y$12$eKl62MG3tHRfr9WEjrxUbe6Qz1amPPg.LEhUHfztxK69wuMrt/ulS', '09265566146', '17861633_1677892825561910_6182402807250128639_n.jpg', 1, '2017-12-11 14:11:31'),
('5a2fcb1d89c84', 'test', 'test', 'male', 21, 'BSA', '2015-2016', 'janwick1', '$2y$12$T3GW/vnQ4eVe4PFkYXJHie8kqlDB2mV9lE/vwbUr9qHAghlucbEt.', '09057789770', 'avatar.png', 0, '2017-12-12 13:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_history`
--

CREATE TABLE `tbl_job_history` (
  `job_id` int(11) NOT NULL,
  `graduate_id` varchar(255) NOT NULL,
  `date_hired` date NOT NULL,
  `company` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `remarks` int(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_job_history`
--

INSERT INTO `tbl_job_history` (`job_id`, `graduate_id`, `date_hired`, `company`, `position`, `remarks`, `date_added`) VALUES
(2, '5a2e8403301ba', '2017-12-15', 'Syntactics', 'Front-end developer', 2, '2017-12-11 16:11:42'),
(3, '5a2e8403301ba', '2017-12-30', 'Innovuze', 'Junior Programmer', 1, '2017-12-12 10:14:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `tbl_graduates`
--
ALTER TABLE `tbl_graduates`
  ADD PRIMARY KEY (`graduate_id`);

--
-- Indexes for table `tbl_job_history`
--
ALTER TABLE `tbl_job_history`
  ADD PRIMARY KEY (`job_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_job_history`
--
ALTER TABLE `tbl_job_history`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
