-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 03:19 AM
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
  `optional` enum('Bắt buộc','Tự chọn') DEFAULT 'Bắt buộc',
  `pre_course` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `credits`, `optional`, `pre_course`) VALUES
(6, 'CS1452', 'Toán rời rạc', 2, 'Bắt buộc', 7),
(7, 'CS1235', 'Đại số tuyến tính', 3, 'Bắt buộc', NULL),
(10, 'CS1346', 'Xác suất thống kê', 3, 'Bắt buộc', 7),
(11, 'CS1652', 'Kinh tế học', 2, 'Tự chọn', 10),
(12, 'CS1563', 'Nhập môn dữ liệu', 2, 'Bắt buộc', NULL),
(13, 'CT2101', 'Triết học Mác-Lênin', 3, 'Bắt buộc', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_code` varchar(50) NOT NULL,
  `grade` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `language` enum('Đạt','Chưa đạt') DEFAULT 'Chưa đạt',
  `infomatic` enum('Đạt','Chưa đạt') DEFAULT 'Chưa đạt',
  `military` enum('Đạt','Chưa đạt') DEFAULT 'Chưa đạt',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_code`, `grade`, `language`, `infomatic`, `military`, `created_at`) VALUES
(10, '22004151', '{\"CS1235\": \"5\", \"CS1346\": \"6\", \"CS1652\": \"7\", \"CS1563\": \"8\", \"CS1452\": \"8\"}', 'Chưa đạt', 'Chưa đạt', 'Chưa đạt', '2024-10-26 22:13:33'),
(11, '22004152', '{\"CS1346\": \"9\", \"CS1652\": \"8\", \"CS1563\": \"9\", \"CS1452\": \"9\", \"CS1235\": \"10\"}', 'Chưa đạt', 'Chưa đạt', 'Chưa đạt', '2024-10-28 09:49:44');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_code` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Nam','Nữ','Khác') NOT NULL DEFAULT 'Nam',
  `address` varchar(255) NOT NULL,
  `major` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` enum('Đang học','Thôi học','Đã tốt nghiệp','') DEFAULT 'Đang học',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_code`, `full_name`, `identity`, `dob`, `gender`, `address`, `major`, `email`, `status`, `created_at`) VALUES
(17, '22004151', 'Võ Lê Minh Khang', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công nghệ thông tin', '22004151@st.vlute.edu.vn', 'Đang học', '2024-10-22 10:40:59'),
(18, '22004152', 'Hồng Phạm Gia Thiên', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công nghệ thông tin', '22004152@st.vlute.edu.vn', 'Đang học', '2024-10-22 14:11:47');

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
(1, 'Nguyễn Văn Minh', '123123', 'GV', 'nva@gmail.com', '2024-10-01 14:14:01'),
(2, 'Vũ Thu Trà', '123123', 'CVHT', 'thutra@gmail.com', '2024-10-16 09:38:21');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
