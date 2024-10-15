-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 08:48 AM
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
-- Database: `grad_advisor`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `credits` int(11) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `pre_course` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `credits`, `semester`, `year`, `pre_course`) VALUES
(6, 'CS1452', 'Toán rời rạc', 2, 1, 2023, 7),
(7, 'CS1235', 'Đại số tuyến tính', 3, 2, 2022, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_code` varchar(50) NOT NULL,
  `grade` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` enum('Đạt','Thi lại','Rớt') DEFAULT 'Đạt',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_code`, `grade`, `status`, `created_at`) VALUES
(6, 'KB156506', '{\"CS1452\": \"9\"}', 'Đạt', '2024-10-15 13:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_code` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `major` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_code`, `full_name`, `dob`, `major`, `email`, `created_at`) VALUES
(1, 'KB156506', 'Nguyễn Minh Phương', '2024-10-03', 'Y dược', 'minhphuong@gmail.com', '2024-10-02 13:10:28'),
(5, 'KB138921', 'Đỗ Phương Nam', '2024-10-04', 'Y Dược', 'phuongnam@gmail.com', '2024-10-02 13:26:30'),
(6, 'KB155676', 'Nguyễn Đức Hải', '2024-10-10', 'Y Dược', 'hai@gmail.com', '2024-10-02 14:02:08'),
(7, 'KB133554', 'Hà Như Yên', '2024-10-12', 'Y Dược', 'nhuyen@gmail.com', '2024-10-02 14:03:06'),
(8, 'KB156435', 'Mai Đức Trung', '2024-10-11', 'Y Dược', 'trung@gmail.com', '2024-10-02 14:04:00'),
(9, 'KB151532', 'Hoàng Hải Yến', '2024-10-04', 'Y Dược', 'haiyen@gmail.com', '2024-10-02 14:06:07'),
(10, 'KB157622', 'Hoàng Như Quỳnh', '2024-10-01', 'Y Dược', 'hoangquynh@gmail.com', '2024-10-02 14:07:12'),
(11, 'KB151324', 'Đỗ Mạnh Cường', '2024-10-09', 'Y Dược', 'cuongca@gmail.com', '2024-10-02 14:07:54'),
(12, 'KB151623', 'Vũ Đức Minh', '2024-10-26', 'Y Dược', 'minhduc@gmail.com', '2024-10-02 14:08:37'),
(13, 'KB162876', 'Vũ Minh Tuấn', '2024-10-09', 'Y Dược', 'tuan.minhtuan@gmail.com', '2024-10-02 14:12:26'),
(14, 'KB159923', 'Mai Quỳnh Hương', '2024-10-12', 'Y Dược', 'huongne@gmail.com', '2024-10-02 14:13:10'),
(15, 'KB135554', 'Đỗ Duy Phương', '2024-10-11', 'Y Dược', 'duyphuong@gmail.com', '2024-10-04 14:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('GV','CVHT') NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `created_at`) VALUES
(1, 'Nguyễn Văn Minh', '123123', 'GV', 'nva@gmail.com', '2024-10-01 14:14:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`course_code`),
  ADD KEY `pre_requisite_course_id` (`pre_course`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_students` (`student_code`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_code` (`student_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`pre_course`) REFERENCES `courses` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `fk_students` FOREIGN KEY (`student_code`) REFERENCES `students` (`student_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
