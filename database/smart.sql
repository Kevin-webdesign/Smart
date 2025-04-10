-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 08:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminprofile`
--

CREATE TABLE `adminprofile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_head_of_faculty` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminprofile`
--

INSERT INTO `adminprofile` (`id`, `user_id`, `is_head_of_faculty`) VALUES
(3, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course` varchar(250) NOT NULL,
  `lecture` varchar(255) NOT NULL,
  `entry_time` datetime DEFAULT current_timestamp(),
  `exit_time` datetime DEFAULT NULL,
  `entry_exit_fingerprint_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `had_extended_absence` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `baseuser`
--

CREATE TABLE `baseuser` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `second_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_staff` tinyint(1) DEFAULT 0,
  `user_type` enum('Admin','Student','Lecture') NOT NULL,
  `profile_pic` varchar(255) DEFAULT 'default-profile.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `baseuser`
--

INSERT INTO `baseuser` (`id`, `first_name`, `second_name`, `email`, `telephone`, `password`, `is_active`, `is_staff`, `user_type`, `profile_pic`, `created_at`, `updated_at`) VALUES
(3, 'edt', 'eddy', 'b1@gmail.com', '078928298293', '$2y$10$AASHOrav7u8HzHouABIo0uvHiH.cXFpi.ReFQaLFH7jeUt86n25e.', 1, 0, 'Lecture', 'default-profile.png', '2025-03-24 10:34:09', '2025-03-25 07:19:17'),
(5, 'paccy', 'gisa', 'paccy@gmail.com', '08692387', '$2y$10$noJHl/1AbRMvSMj32trhSOhlSFWUsXp/qh0m0j8HsM5XuUwCfjMPq', 1, 0, 'Lecture', 'default-profile.png', '2025-03-23 12:07:16', '2025-03-24 15:18:40'),
(16, 'UZAMURERA', 'Kevin', 'kevinuzamurera@gmail.com', '0791888898', '$2y$10$nZSiT4itztuafazjcCPZI.nTzWSqdXrKHHk2xU.WskMUMa6x3oQ6e', 1, 0, 'Admin', 'default-profile.png', '2025-03-20 20:31:35', '2025-03-24 14:46:33'),
(20, 'placide', 'Kevin', 'placide@gmail.com', '0791888888', '$2y$10$AsVQdmYOPFxqMIDa18c8duPULX3.iReZW.I.MCRuY.1YXMVywwyE.', 1, 0, 'Lecture', 'default-profile.png', '2025-03-23 11:11:32', '2025-03-23 11:11:32'),
(36, 'Mr', 'kelia', 'student@gmail.com', '0791813622', '$2y$10$eAXQ3HKlxUZxTAb1hsiPmeFlUAOrs6PXTpcecCpFTxCo.Aig8AWL6', 1, 0, 'Student', 'default-profile.png', '2025-03-26 17:55:49', '2025-03-26 17:55:49'),
(37, 'Gihozo', 'kelia', 'kelia@gmail.com', '0791813622', '$2y$10$BO5mnnwEUL0Ybsg98nOqOuBw6l55E8Fnqs3U9pE6dik72DQDWwxhS', 1, 0, 'Student', 'default-profile.png', '2025-03-26 18:03:25', '2025-03-26 18:03:25'),
(38, 'NTAKI', 'Bonny', 'bonny@gmail.com', '08692387', '$2y$10$L/7v8aefgWju01Nn3GYQge2ydesCMJci2RfdVUZQPqo665ZTKCarC', 1, 0, 'Student', 'default-profile.png', '2025-03-27 15:01:15', '2025-03-27 15:01:15'),
(39, 'Best', 'Friend', 'friend@gmail.com', '0791888898', '$2y$10$uJIRhHzh14fy6uMY7hx7duFtese33QJABh/2I5dmsZQJF03H6pHAm', 1, 0, 'Lecture', 'default-profile.png', '2025-03-28 00:18:15', '2025-03-28 00:18:15'),
(48, 'uwamahirwe', 'gihozo', 'uwamahirwe@gmail.com', '0791888888', '$2y$10$KWJBqf4kCi3AtTBjCfSBDuDt0h5T4.2.0n3YeKvNo4rP6Bi7SRJX.', 1, 0, 'Student', NULL, '2025-03-28 01:27:16', '2025-03-28 01:27:16'),
(49, 'Best', 'kevin', 'best@gmail.com', '1234', '$2y$10$fjumqcLxVeSPr1Jb0J34XOQWNP2LiJ7D9H51HnO9FfaL5EEr4wJz6', 1, 0, 'Student', NULL, '2025-03-28 01:29:54', '2025-03-28 01:29:54');

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `building` varchar(100) NOT NULL,
  `floor` varchar(10) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `capacity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`id`, `name`, `building`, `floor`, `room_number`, `capacity`) VALUES
(1, 'Kivu', 'block 1', '3', '20', 40),
(2, 'Bisoke', 'block 1', '3', '212', 20),
(3, 'Lab 1', 'south build', '2', '45', 67);

-- --------------------------------------------------------

--
-- Table structure for table `classsession`
--

CREATE TABLE `classsession` (
  `id` int(11) NOT NULL,
  `course` varchar(200) NOT NULL,
  `classroom` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `session_type` enum('DAY','EVENING','WEEKEND') DEFAULT 'DAY'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classsession`
--

INSERT INTO `classsession` (`id`, `course`, `classroom`, `date`, `start_time`, `end_time`, `session_type`) VALUES
(2, ' Calculas', ' Kivu', '2025-03-07', '08:30:00', '11:00:00', 'EVENING');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `sessions_offered` varchar(100) DEFAULT NULL,
  `lecturer` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `code`, `description`, `sessions_offered`, `lecturer`) VALUES
(2, 'Calculas', 'MAT101', 'Mathematics', 'EVENING', 'eddy'),
(3, 'English', 'Eng 010', 'general english', 'EVENING', 'eddy'),
(4, 'Entreprenuership', 'Bus02', 'business', 'DAY', 'eddy'),
(5, 'C programming', 'csc011', 'computer programming', 'DAY', 'edt eddy');

-- --------------------------------------------------------

--
-- Table structure for table `lecturerprofile`
--

CREATE TABLE `lecturerprofile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturerprofile`
--

INSERT INTO `lecturerprofile` (`id`, `user_id`, `department`) VALUES
(6, 20, 'IT'),
(7, 21, 'Business'),
(8, 27, 'Science'),
(9, 39, 'IT');

-- --------------------------------------------------------

--
-- Table structure for table `moduleregistration`
--

CREATE TABLE `moduleregistration` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `code` varchar(11) NOT NULL,
  `description` varchar(30) NOT NULL,
  `sessions_offered` varchar(250) NOT NULL,
  `Lecturer` varchar(250) NOT NULL,
  `user_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `moduleregistration`
--

INSERT INTO `moduleregistration` (`id`, `name`, `code`, `description`, `sessions_offered`, `Lecturer`, `user_id`) VALUES
(4, 'English', 'Eng 010', 'general english', 'EVENING', 'paccy gisa', ''),
(14, 'Entreprenuership', 'Bus02', 'business', 'DAY', 'eddy', '22'),
(15, 'English', 'Eng 010', 'general english', 'EVENING', 'eddy', '22'),
(16, 'Calculas', 'MAT101', 'Mathematics', 'EVENING', 'eddy', '36'),
(17, 'Entreprenuership', 'Bus02', 'business', 'DAY', 'eddy', '36'),
(18, 'English', 'Eng 010', 'general english', 'EVENING', 'eddy', '37'),
(19, 'English', 'Eng 010', 'general english', 'EVENING', 'eddy', '20'),
(20, 'Entreprenuership', 'Bus02', 'business', 'DAY', 'eddy', '16'),
(21, 'English', 'Eng 010', 'general english', 'EVENING', 'eddy', '36'),
(22, 'C programming', 'csc011', 'computer programming', 'DAY', 'edt eddy', '36');

-- --------------------------------------------------------

--
-- Table structure for table `seatactivity`
--

CREATE TABLE `seatactivity` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_session_id` int(11) NOT NULL,
  `left_seat_time` datetime NOT NULL,
  `returned_seat_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_finger`
--

CREATE TABLE `status_finger` (
  `id` int(11) NOT NULL,
  `f_number` int(11) NOT NULL,
  `f_status` int(11) NOT NULL,
  `f_mode` int(11) NOT NULL,
  `attended` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_finger`
--

INSERT INTO `status_finger` (`id`, `f_number`, `f_status`, `f_mode`, `attended`, `time`) VALUES
(1, 0, 0, 3, '4', '2025-03-26 08:32:21');

-- --------------------------------------------------------

--
-- Table structure for table `studentprofile`
--

CREATE TABLE `studentprofile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session` enum('DAY','EVENING','WEEKEND') DEFAULT 'DAY',
  `student_id` varchar(15) NOT NULL,
  `fingerprint` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentprofile`
--

INSERT INTO `studentprofile` (`id`, `user_id`, `session`, `student_id`, `fingerprint`) VALUES
(18, 36, 'EVENING', '1', ''),
(19, 37, 'WEEKEND', '2', ''),
(20, 38, 'DAY', '3', ''),
(21, 47, 'EVENING', '4', ''),
(22, 48, 'WEEKEND', '5', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminprofile`
--
ALTER TABLE `adminprofile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `baseuser`
--
ALTER TABLE `baseuser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classsession`
--
ALTER TABLE `classsession`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `lecturerprofile`
--
ALTER TABLE `lecturerprofile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `moduleregistration`
--
ALTER TABLE `moduleregistration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seatactivity`
--
ALTER TABLE `seatactivity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_finger`
--
ALTER TABLE `status_finger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentprofile`
--
ALTER TABLE `studentprofile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminprofile`
--
ALTER TABLE `adminprofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `baseuser`
--
ALTER TABLE `baseuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `classroom`
--
ALTER TABLE `classroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `classsession`
--
ALTER TABLE `classsession`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lecturerprofile`
--
ALTER TABLE `lecturerprofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `moduleregistration`
--
ALTER TABLE `moduleregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `seatactivity`
--
ALTER TABLE `seatactivity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_finger`
--
ALTER TABLE `status_finger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `studentprofile`
--
ALTER TABLE `studentprofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
