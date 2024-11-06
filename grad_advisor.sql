-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 03:35 AM
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
(7, 'CT2102', 'Kinh tế chính trị Mác-Lênin', 2, 'Bắt buộc', NULL),
(13, 'CT2101', 'Triết học Mác-Lênin', 3, 'Bắt buộc', NULL),
(14, 'CT2103', 'Chủ nghĩa xã hội khoa học', 2, 'Bắt buộc', NULL),
(15, 'CT2104', 'Lịch sử Đảng Cộng sản Việt Nam', 2, 'Bắt buộc', NULL),
(16, 'CT1102', 'Tư tưởng Hồ Chí Minh', 2, 'Bắt buộc', NULL),
(17, 'UL1104', 'Pháp luật đại cương', 2, 'Bắt buộc', NULL),
(18, 'EC1600', 'Khởi nghiệp', 1, 'Bắt buộc', NULL),
(20, 'UL1106', 'Quản lý hành chính nhà nước và quản lý ngành giáo dục –  đào tạo', 2, 'Bắt buộc', NULL),
(21, 'CB1106', 'Toán cao cấp A1', 3, 'Bắt buộc', NULL),
(22, 'CB1107', 'Toán cao cấp A2', 3, 'Bắt buộc', NULL),
(23, 'CB1111', 'Vật lý đại cương A1', 3, 'Bắt buộc', NULL),
(24, 'TC1102', 'Giáo dục thể chất 2', 1, 'Bắt buộc', NULL),
(25, 'TC1101', 'Giáo dục thể chất 1', 1, 'Bắt buộc', NULL),
(26, 'TC1103', 'Giáo dục thể chất 3', 1, 'Bắt buộc', NULL),
(27, 'QP2101', 'Đường lối quốc phòng và an ninh của ĐCSVN', 3, 'Bắt buộc', NULL),
(28, 'QP2102', 'Công tác quốc phòng – An ninh', 2, 'Bắt buộc', NULL),
(29, 'QP2103', 'Quân sự chung', 1, 'Bắt buộc', NULL),
(30, 'QP2104', 'Kỹ thuật chiến đấu bộ binh và chiến thuật', 2, 'Bắt buộc', NULL),
(31, 'TH1201', 'Tin học cơ sở', 2, 'Bắt buộc', 32),
(32, 'TH1203', 'Toán rời rạc', 2, 'Bắt buộc', 31),
(33, 'TH1219', 'Lập trình căn bản', 4, 'Bắt buộc', 34),
(34, 'TH1205', 'Cấu trúc máy tính', 3, 'Bắt buộc', 33),
(35, 'TH1207', 'Cơ sở dữ liệu', 3, 'Bắt buộc', 34);

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
(14, '22004153', '{\"CT2102\": \"6\", \"CT2101\": \"8\", \"CT2103\": \"9\", \"CT2104\": \"4\", \"CT1102\": \"5\"}', 'Chưa đạt', 'Chưa đạt', 'Chưa đạt', '2024-11-05 18:32:55'),
(15, '22004157', '{\"CT2102\":\"6\"}', 'Chưa đạt', 'Chưa đạt', 'Chưa đạt', '2024-11-05 18:33:38'),
(16, '22004154', '{\"EC1600\":\"2\"}', 'Chưa đạt', 'Chưa đạt', 'Chưa đạt', '2024-11-05 18:34:37'),
(17, '22004156', '{\"EC1600\":\"5\"}', 'Chưa đạt', 'Chưa đạt', 'Chưa đạt', '2024-11-05 18:34:48'),
(18, '22004151', '{\"CT2102\": \"5\", \"CT2101\": \"3\", \"CT2103\": \"7\"}', 'Chưa đạt', 'Chưa đạt', 'Chưa đạt', '2024-11-06 06:24:36');

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
(18, '22004152', 'Hồng Phạm Gia Thiên', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công nghệ thông tin', '22004152@st.vlute.edu.vn', 'Đang học', '2024-10-22 14:11:47'),
(19, '22004153', 'Nguyễn Kim Hân', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004153@st.vlute.edu.vn', 'Đang học', '2024-11-05 17:43:15'),
(20, '22004154', 'Nguyễn Duy Quân', '86123456789', '2024-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004154@st.vlute.edu.vn', 'Đang học', '2024-11-05 17:43:49'),
(21, '22004155', 'Nguyễn Tuấn Đạt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004155@st.vlute.edu.vn', 'Đang học', '2024-11-05 17:44:22'),
(22, '22004156', 'Trần Phát	Tài', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004156@st.vlute.edu.vn', 'Đang học', '2024-11-05 17:45:02'),
(23, '22004157', 'Nguyễn Tấn Lộc', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004157@st.vlute.edu.vn', 'Đang học', '2024-11-05 17:53:42'),
(24, '22004158', 'Nguyễn Tiểu Mẫn', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004158@st.vlute.edu.vn', 'Đang học', '2024-11-05 17:58:56'),
(25, '22004159', 'Nguyễn Thị Thảo Nhi', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004159@st.vlute.edu.vn', 'Đang học', '2024-11-05 17:59:29'),
(26, '22004160', 'Lê Gia Anh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004160@st.vlute.edu.vn', 'Đang học', '2024-11-05 18:00:04'),
(27, '22004161', 'Phan Vân	Sơn', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004161@st.vlute.edu.vn', 'Đang học', '2024-11-05 18:00:34'),
(28, '22004162', 'Dương Võ Thành Luân', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004162@st.vlute.edu.vn', 'Đang học', '2024-11-05 18:01:02'),
(29, '22004163', 'Nguyễn Thành Đạt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004163@st.vlute.edu.vn', 'Đang học', '2024-11-05 18:01:29'),
(30, '22004164', 'Lê Quang Vinh Hiển', '86123456789', '2004-01-12', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004164@st.vlute.edu.vn', 'Đang học', '2024-11-05 18:02:13'),
(31, '22004165', 'Lê Phúc Duy', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004165@st.vlute.edu.vn', 'Đang học', '2024-11-05 18:03:33'),
(32, '22004166', 'Lê Thị Thúy Vy', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004166@st.vlute.edu.vn', 'Đang học', '2024-11-05 18:04:04'),
(33, '22004167', 'Lê Tiến Trung', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004167@st.vlute.edu.vn', 'Đang học', '2024-11-05 18:04:34'),
(34, '22004168', 'Võ Trọng	Văn', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004168@st.vlute.edu.vn', 'Đang học', '2024-11-05 18:05:29'),
(35, '22004169', 'Nguyễn Vỹ Khang', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004169@st.vlute.edu.vn', 'Đang học', '2024-11-05 18:06:21'),
(36, '22004170', 'Hồ Thanh Trọng', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', 'Công Nghệ Thông Tin', '22004170@st.vlute.edu.vn', 'Đang học', '2024-11-05 18:07:27');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
