-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2025 at 05:24 PM
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
  `class_session_id` int(11) NOT NULL,
  `entry_time` datetime DEFAULT NULL,
  `entry_fingerprint_verified` tinyint(1) DEFAULT 0,
  `exit_time` datetime DEFAULT NULL,
  `exit_fingerprint_verified` tinyint(1) DEFAULT 0,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `baseuser`
--

INSERT INTO `baseuser` (`id`, `first_name`, `second_name`, `email`, `telephone`, `password`, `is_active`, `is_staff`, `user_type`, `created_at`, `updated_at`) VALUES
(13, 'UZAMURERA', 'Kevin', 'kevinuzamurera@gmail.com', '0791888898', '$2y$10$nZSiT4itztuafazjcCPZI.nTzWSqdXrKHHk2xU.WskMUMa6x3oQ6e', 1, 0, 'Admin', '2025-03-20 20:31:35', '2025-03-20 20:31:35'),
(18, 'Blessing', 'eddy', 'edz@gmail.com', '07883743848', '$2y$10$mpSKnHumRbWt8Fl0R8mjPeQDYbGp/mjvifQHiGRPmcPKHEimbvnau', 1, 0, 'Student', '2025-03-21 12:32:39', '2025-03-21 12:32:39'),
(19, 'Alexie', 'eddy', 'chuck@gmail.com', '0783939', '$2y$10$fzpsl9SiqxpNQSb9QIl.yeK4hsgxUYI4/D43I9XtX8ev88gSuZwZS', 1, 0, 'Student', '2025-03-21 15:19:43', '2025-03-21 15:19:43'),
(20, 'placide', 'Kevin', 'placide@gmail.com', '0791888888', '$2y$10$AsVQdmYOPFxqMIDa18c8duPULX3.iReZW.I.MCRuY.1YXMVywwyE.', 1, 0, 'Lecture', '2025-03-23 11:11:32', '2025-03-23 11:11:32'),
(21, 'paccy', 'gisa', 'paccy@gmail.com', '08692387', '$2y$10$noJHl/1AbRMvSMj32trhSOhlSFWUsXp/qh0m0j8HsM5XuUwCfjMPq', 1, 0, 'Lecture', '2025-03-23 12:07:16', '2025-03-23 12:07:16'),
(22, 'gisa', 'student', 'student@gmail.com', '08692387', '$2y$10$Yyd.xBotf/A3xjaScOFFIO4RKUkOW/fQlSuCE2XDl6e7QI5NTqBH.', 1, 0, 'Student', '2025-03-23 13:30:45', '2025-03-23 13:30:45'),
(23, 'stu', 'student2', 'student2@gmail.com', '0791813688', '$2y$10$H0ZYYvXJK2JFjWNcYhSUIuQaXuODiIvGAeMRa5C9cdTfBoXvv2u3.', 1, 0, 'Student', '2025-03-23 15:37:47', '2025-03-23 15:37:47'),
(26, 'stu', 'student2', 'kstudent@gmail.com', '0791813688', '$2y$10$QCC/ibj1A2mB/7m6onPAfONae/F9Yv0a1cQabrF843c3j7H9gRJ62', 1, 0, 'Student', '2025-03-23 15:38:24', '2025-03-23 15:38:24');

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
(2, 'Bisoke', 'block 1', '3', '212', 20);

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
(2, 'Calculas', 'MAT101', 'Mathematics', 'EVENING', 'paccy gisa'),
(3, 'English', 'Eng 010', 'general english', 'EVENING', 'paccy gisa'),
(4, 'Entreprenuership', 'Bus02', 'business', 'DAY', 'paccy gisa');

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
(7, 21, 'Business');

-- --------------------------------------------------------

--
-- Table structure for table `moduleregistration`
--

CREATE TABLE `moduleregistration` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `code` varchar(11) NOT NULL,
  `description` varchar(30) NOT NULL,
  `Sessions Offered` varchar(250) NOT NULL,
  `Lecturer` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `moduleregistration`
--

INSERT INTO `moduleregistration` (`id`, `name`, `code`, `description`, `Sessions Offered`, `Lecturer`) VALUES
(4, 'English', 'Eng 010', 'general english', 'EVENING', 'paccy gisa'),
(8, 'Entreprenuership', 'Bus02', 'business', 'DAY', 'paccy gisa');

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
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_finger`
--

INSERT INTO `status_finger` (`id`, `f_number`, `f_status`, `f_mode`, `time`) VALUES
(1, 0, 0, 1, '2025-03-21 15:19:43');

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
(4, 14, 'EVENING', '2', '1'),
(6, 18, 'EVENING', '3', '2'),
(7, 19, 'EVENING', '5', '3'),
(8, 22, 'DAY', '4', ''),
(10, 26, 'DAY', '', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `baseuser`
--
ALTER TABLE `baseuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `classroom`
--
ALTER TABLE `classroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `classsession`
--
ALTER TABLE `classsession`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lecturerprofile`
--
ALTER TABLE `lecturerprofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `moduleregistration`
--
ALTER TABLE `moduleregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
