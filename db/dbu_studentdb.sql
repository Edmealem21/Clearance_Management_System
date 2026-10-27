-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2022 at 02:34 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `designation` varchar(25) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `status` varchar(10) NOT NULL,
  `photo` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `username`, `password`, `designation`, `fullname`, `email`, `status`, `photo`) VALUES
(4, 'edmealem', 'edmu1234', 'Admin', 'edmu, edmealem getnet', 'eva_2012@gmail.com', 'Active', 'uploads/default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `clearance_requests`
--

CREATE TABLE clearance_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reason VARCHAR(255) NOT NULL,
    school_year VARCHAR(255) NOT NULL,
    matric_no varchar(15) NOT NULL,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dumping data for table `clearance_requests`
INSERT INTO clearance_requests ( reason, school_year, date)
VALUES ( 'Health problem',  'II', '2024-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `fee`
--

CREATE TABLE `fee` (
  `ID` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `session` varchar(9) NOT NULL,
  `job_position` varchar(40) NOT NULL,
  `matric_no` varchar(15) NOT NULL,
  `faculty` varchar(40) NOT NULL,
  `dept` varchar(40) NOT NULL,
  `amount` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `fee`
INSERT INTO `fee` (`ID`, `session`, `job_position`, `matric_no`, `faculty`, `dept`, `amount`) VALUES
(14, '2020/2021', 'library', '4567', 'Computing', 'Computer Science', '100000');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `ID` int(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `feeID` varchar(25) NOT NULL,
  `studentID` varchar(25) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `datepaid` datetime NOT NULL,
  `matric_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `payment` (`ID`, `feeID`, `studentID`, `amount`, `datepaid`, `matric_no`) VALUES
(24, '8FAC46R2579D', '8', '20000', '2022-08-17 13:24:57', '0237');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `ID` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `fullname` varchar(50) NOT NULL,
  `sex` ENUM('male', 'female') NOT NULL,
  `matric_no` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `session` varchar(10) NOT NULL,
  `faculty` varchar(30) NOT NULL,
  `dept` varchar(44) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `photo` varchar(400) NOT NULL,
  `is_course_cordinator_approved` int(3) NOT NULL,
  `is_library_approved` int(3) NOT NULL,
  `is_cafeteria_approved` int(3) NOT NULL,
  `is_dormitory_approved` int(3) NOT NULL,
  `is_bookstore_approved` int(3) NOT NULL,
  `is_sport_approved` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `fullname`, `sex`, `matric_no`, `password`, `session`, `faculty`, `dept`, `phone`, `photo`, `is_course_cordinator_approved`, `is_library_approved`, `is_cafeteria_approved`, `is_dormitory_approved`, `is_bookstore_approved`, `is_sport_approved`) VALUES
(8, 'sew', 'male', '18/132010', '11111111', '2021/2022', 'Computing', 'Computer Science', '0906736102', 'uploads/eva.jpeg', 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblsession`
--

CREATE TABLE `tblsession` (
  `ID` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `session` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblsession`
--

INSERT INTO `tblsession` (`ID`, `session`) VALUES
(1, '2023/2024'),
(2, '2024/2025'),
(3, '2025/2026');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `designation` varchar(25) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `status` varchar(10) NOT NULL,
  `photo` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `username`, `password`, `designation`, `fullname`, `email`, `status`, `photo`) VALUES
(2, 'bewket', 'beya1234', 'dormitory', 'BEYA, BEWKET YESERAH', 'eva_2012@gmail.com', 'Active', 'uploads/11.png');



-- Create the table register material
CREATE TABLE recorded_issue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    matric_no VARCHAR(11) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
   any_record VARCHAR(255) NOT NULL
);

-- Insert data into the table
INSERT INTO  recorded_issue  (fullname, matric_no, amount, any_record)
VALUES ('John Doe', '6789', 100.00, 'Textbook 1');

COMMIT;


