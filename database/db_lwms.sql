-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 01:33 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lwms`
--
CREATE DATABASE IF NOT EXISTS `db_lwms` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_lwms`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(55) NOT NULL,
  `name` varchar(30) NOT NULL,
  `background` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `phone_no` varchar(55) NOT NULL,
  `gender_id` char(11) NOT NULL,
  `photo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `background`, `email`, `phone_no`, `gender_id`, `photo`) VALUES
('admin', 'Zahri Abdullah', 'Information Technology', 'captainalgo@gmail.com', '0173452172', 'M', '67274d55b9190_Shahrukh-2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `coordinator`
--

CREATE TABLE `coordinator` (
  `coordinator_id` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `name` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `phone_no` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `gender_id` char(11) CHARACTER SET utf8mb4 NOT NULL,
  `photo` mediumtext CHARACTER SET utf8mb4 NOT NULL,
  `program_code` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coordinator`
--

INSERT INTO `coordinator` (`coordinator_id`, `name`, `email`, `phone_no`, `gender_id`, `photo`, `program_code`) VALUES
('C28704', 'Siti Nurhaliza', 'siti@gmail.com', '0155055505', 'F', '6735ec7ea1acf-photo_672c2f0534428.jpg', 'BK101'),
('C44245', 'ASLIMARIAH AHMAD', 'aslimariah@uptm.edu.my', '0392069700', 'F', '6735e10ab1152_18.png', 'CC101'),
('C58483', 'Sufian Suhaimi', 'sufian@gmail.com', '0133033303', 'M', '6735ec86cc2c2-photo_672c2f15544e5.png', 'AA103');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_code` char(11) NOT NULL,
  `course` varchar(55) NOT NULL,
  `credit_hour` int(11) NOT NULL,
  `contact_hour` int(11) NOT NULL,
  `prerequisite` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_code`, `course`, `credit_hour`, `contact_hour`, `prerequisite`) VALUES
('ARC1033', 'Computer Organization and Architecture', 3, 3, NULL),
('ARC1043', 'Operating Systems (L)', 3, 3, NULL),
('code101', 'sample course', 3, 3, NULL),
('EGN2103', 'General English Proficiency', 3, 3, NULL),
('ITC2143', 'Database Concepts (L)', 3, 3, NULL),
('ITC2173', 'Enterprise Information Systems', 3, 3, NULL),
('MAT1063', 'Computing Mathematics', 3, 3, NULL),
('SWC1323', 'Fundamental of Programming (L)', 3, 3, NULL),
('testcode', 'Sample Course Account', 3, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deputy_dean`
--

CREATE TABLE `deputy_dean` (
  `deputy_dean_id` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `name` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `phone_no` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `gender_id` char(11) CHARACTER SET utf8mb4 NOT NULL,
  `photo` mediumtext CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deputy_dean`
--

INSERT INTO `deputy_dean` (`deputy_dean_id`, `name`, `email`, `phone_no`, `gender_id`, `photo`) VALUES
('DD68785', 'DR. Mariani Binti Mohd Dahlan', 'mariani@uptm.edu.my', '0392069700', 'F', '6735cb0edeba3_2.png');

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `gender_id` char(11) NOT NULL,
  `gender` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`gender_id`, `gender`) VALUES
('F', 'Female'),
('M', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `lecturer_id` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `name` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `phone_no` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `gender_id` char(11) CHARACTER SET utf8mb4 NOT NULL,
  `photo` mediumtext CHARACTER SET utf8mb4 NOT NULL,
  `specialization_code` char(10) CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`lecturer_id`, `name`, `email`, `phone_no`, `gender_id`, `photo`, `specialization_code`) VALUES
('L10185', 'Nurul Neelofa', 'neelofa@gmail.com', '0177077707', 'F', '673d5165696f1-6735eb60921e7-neelofa-1.png', 'AI'),
('L20507', 'my lecturer', 'test@gmail.com', '012', 'F', '673d516d644af-6735ec22ab466-ROSYAM-POSE-1.jpg', 'CC'),
('L71833', 'Akil Hayy', 'akilhayy@gmail.com', '0188088808', 'M', '6735eb6c48fff-face9.jpg', 'CS'),
('L82874', 'Afdlin Shauki', 'afdlin@gmail.com', '0199099909', 'M', 'avatar.jpg', 'DB');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `UserID` varchar(50) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `UserLvl` int(11) NOT NULL DEFAULT 2,
  `Status` varchar(55) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`UserID`, `Password`, `UserLvl`, `Status`) VALUES
('admin', 'admin', 1, 'Active'),
('C28704', 'C28704', 3, 'Active'),
('C44245', 'C44245', 3, 'Active'),
('C58483', 'C58483', 3, 'Active'),
('DD68785', 'DD68785', 2, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `program_code` char(11) NOT NULL,
  `program` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`program_code`, `program`) VALUES
('AA103', 'Diploma of Accountancy'),
('BK101', 'Diploma in Corporate Communication'),
('CC101', 'Diploma in Computer Science');

-- --------------------------------------------------------

--
-- Table structure for table `projection`
--

CREATE TABLE `projection` (
  `projection_id` varchar(55) NOT NULL,
  `program_code` char(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `batch` varchar(55) NOT NULL,
  `course_code` char(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `sections` char(11) NOT NULL,
  `groupings` varchar(55) NOT NULL,
  `total_by_group` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `lecturer_id` varchar(55) DEFAULT NULL,
  `assigned_hours` int(11) DEFAULT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projection`
--

INSERT INTO `projection` (`projection_id`, `program_code`, `session_id`, `batch`, `course_code`, `semester_id`, `sections`, `groupings`, `total_by_group`, `total`, `lecturer_id`, `assigned_hours`, `remarks`) VALUES
('P17320895267812', 'CC101', 9, 'BATCH 0723', 'ITC2143', 1, 'SEC 03', '1.1', 1, 30, 'L10185', 3, 'okay'),
('P17320949969826', 'CC101', 9, 'BATCH 0723', 'ITC2143', 1, 'SEC 4.0', '1.1', 1, 30, 'L71833', 2, 'ok'),
('P17320963477203', 'CC101', 9, 'BATCH 0723', 'SWC1323', 1, 'SEC 5.0', '1.1', 1, 30, NULL, NULL, 'okay'),
('WL17313942538399', 'CC101', 9, 'BATCH 0723', 'ARC1033', 1, 'SEC 01', '1.1', 1, 30, 'L10185', 3, '- test remarks'),
('WL17314818678984', 'CC101', 9, 'BATCH 0723', 'ARC1033', 1, 'SEC 01', '1.2', 1, 30, 'L71833', 3, 'second group for sec 01');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `semester_id` int(11) NOT NULL,
  `semester` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`semester_id`, `semester`) VALUES
(1, 'Semester 1'),
(2, 'Semester 2'),
(3, 'Semester 3'),
(4, 'Semester 4'),
(5, 'Semester 5'),
(6, 'Semester 6'),
(7, 'Semester 7'),
(8, 'Semester 8'),
(9, 'Semester 9'),
(10, 'Semester 10');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `session_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`session_id`, `month`, `year`) VALUES
(9, 7, 2024),
(11, 7, 2023);

-- --------------------------------------------------------

--
-- Table structure for table `specialization`
--

CREATE TABLE `specialization` (
  `specialization_code` varchar(10) NOT NULL,
  `specialization` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `specialization`
--

INSERT INTO `specialization` (`specialization_code`, `specialization`) VALUES
('AC', 'Algorithms and Complexity'),
('AI', 'Artificial Intelligence (AI)'),
('CC', 'Cloud Computing'),
('CG', 'Computer Graphics and Visualization'),
('CN', 'Computer Networks'),
('CS', 'Cybersecurity'),
('DB', 'Database Systems'),
('DS', 'Data Science and Big Data'),
('DSYS', 'Distributed Systems'),
('HCI', 'Human-Computer Interaction (HCI)'),
('MC', 'Mobile Computing'),
('PLC', 'Programming Languages and Compilers'),
('SE', 'Software Engineering'),
('TCS', 'Theoretical Computer Science');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `coordinator`
--
ALTER TABLE `coordinator`
  ADD PRIMARY KEY (`coordinator_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `deputy_dean`
--
ALTER TABLE `deputy_dean`
  ADD PRIMARY KEY (`deputy_dean_id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`gender_id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`lecturer_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`program_code`);

--
-- Indexes for table `projection`
--
ALTER TABLE `projection`
  ADD PRIMARY KEY (`projection_id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `specialization`
--
ALTER TABLE `specialization`
  ADD PRIMARY KEY (`specialization_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
