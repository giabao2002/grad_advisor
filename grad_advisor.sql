-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 07:55 AM
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
  `accumulation` enum('Tích lũy','Không tích lũy') DEFAULT 'Tích lũy',
  `pre_course` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `credits`, `optional`, `accumulation`, `pre_course`) VALUES
(135, 'CT2101', 'Triết học Mác-Lênin', 3, 'Bắt buộc', '', NULL),
(136, 'CT2102', 'Kinh tế chính trị Mác-Lênin', 2, 'Bắt buộc', '', NULL),
(137, 'CT2103', 'Chủ nghĩa xã hội khoa học', 2, 'Bắt buộc', '', NULL),
(138, 'CT2104', 'Lịch sử Đảng Cộng sản Việt Nam', 2, 'Bắt buộc', '', NULL),
(139, 'CT1102', 'Tư tưởng Hồ Chí Minh', 2, 'Bắt buộc', '', NULL),
(140, 'UL1104', 'Pháp luật đại cương', 2, 'Bắt buộc', '', NULL),
(141, 'EC1600', 'Khởi nghiệp', 1, 'Bắt buộc', '', NULL),
(142, 'EC1217', 'Nguyên lý kế toán', 2, 'Tự chọn', '', NULL),
(143, 'UL1106', 'Quản lý hành chính nhà nước và quản lý ngành giáo dục –', 2, 'Tự chọn', '', NULL),
(144, 'CB1106', 'Toán cao cấp A1', 3, 'Bắt buộc', '', NULL),
(145, 'CB1107', 'Toán cao cấp A2', 3, 'Bắt buộc', '', NULL),
(146, 'CB1111', 'Vật lý đại cương A1', 3, 'Tự chọn', '', NULL),
(147, 'CB1109', 'Xác suất thống kê', 3, 'Tự chọn', '', NULL),
(148, 'TH1114', 'Tin học', 3, 'Bắt buộc', '', NULL),
(149, 'NN1101', 'Anh văn 1', 3, 'Bắt buộc', '', NULL),
(150, 'NN1102', 'Anh văn 2', 3, 'Bắt buộc', '', NULL),
(151, 'NN1103', 'Anh văn 3', 4, 'Bắt buộc', '', NULL),
(152, 'TC1101', 'Giáo dục thể chất 1', 1, 'Bắt buộc', '', NULL),
(153, 'TC1102', 'Giáo dục thể chất 2', 1, 'Bắt buộc', '', NULL),
(154, 'TC1103', 'Giáo dục thể chất 3', 1, 'Bắt buộc', '', NULL),
(155, 'QP2101', 'Đường lối quốc phòng và an ninh của ĐCSVN', 3, 'Bắt buộc', '', NULL),
(156, 'QP2102', 'Công tác quốc phòng – An ninh', 2, 'Bắt buộc', '', NULL),
(157, 'QP2103', 'Quân sự chung', 1, 'Bắt buộc', '', NULL),
(158, 'QP2104', 'Kỹ thuật chiến đấu bộ binh và chiến thuật', 2, 'Bắt buộc', '', NULL),
(159, 'TH1201', 'Tin học cơ sở', 2, 'Bắt buộc', '', NULL),
(160, 'TH1203', 'Toán rời rạc', 2, 'Bắt buộc', '', NULL),
(161, 'TH1219', 'Lập trình căn bản', 4, 'Bắt buộc', '', 'TH1201'),
(162, 'TH1205', 'Cấu trúc máy tính', 3, 'Bắt buộc', '', 'TH1201'),
(163, 'TH1206', 'Cấu trúc dữ liệu và giải thuật', 3, 'Bắt buộc', '', 'TH1219'),
(164, 'TH1207', 'Cơ sở dữ liệu', 3, 'Bắt buộc', '', 'TH1203'),
(165, 'TH1208', 'Hệ điều hành', 3, 'Bắt buộc', '', 'TH1205'),
(166, 'TH1209', 'Lập trình hướng đối tượng', 3, 'Bắt buộc', '', 'TH1219'),
(167, 'TH1227', 'Biên tập và soạn thảo văn bản', 2, 'Bắt buộc', '', NULL),
(168, 'DT1283', 'Kỹ thuật số-CNTT', 2, 'Bắt buộc', '', NULL),
(169, 'TH1216', 'Phần mềm mã nguồn mở', 2, 'Bắt buộc', '', 'TH1208'),
(170, 'TH1214', 'Mạng máy tính', 3, 'Bắt buộc', '', 'TH1208'),
(171, 'TH1217', 'An toàn và vệ sinh lao động trong lĩnh vực CNTT', 1, 'Bắt buộc', '', NULL),
(172, 'TH1507', 'Đồ án CNTT 1', 1, 'Bắt buộc', '', NULL),
(173, 'TH1521', 'Lắp ráp và cài đặt máy tính', 2, 'Tự chọn', '', NULL),
(174, 'TH1522', 'Tin học ứng dụng', 2, 'Tự chọn', 'Tích lũy', NULL),
(175, 'TH1354', 'Anh văn chuyên ngành', 2, 'Bắt buộc', '', NULL),
(176, 'TH1359', 'Internet vạn vật', 3, 'Bắt buộc', '', 'TH1216'),
(177, 'TH1335', 'Xử lý ảnh', 3, 'Bắt buộc', '', NULL),
(178, 'TH1305', 'Phân tích thiết kế hệ thống thông tin', 3, 'Bắt buộc', '', 'TH1207'),
(179, 'TH1324', 'Phân tích thiết kế hướng đối tượng', 3, 'Bắt buộc', '', 'TH1209'),
(180, 'TH1336', 'Lập trình Web', 4, 'Bắt buộc', '', 'TH1209'),
(181, 'TH1309', 'Lập trình Java', 3, 'Bắt buộc', '', NULL),
(182, 'TH1337', 'Lập trình dotNET', 4, 'Bắt buộc', '', 'TH1209'),
(183, 'TH1338', 'Lập trình ứng dụng cho thiết bị di động', 4, 'Bắt buộc', '', NULL),
(184, 'TH1376', 'Sensor và ứng dụng', 3, 'Bắt buộc', '', NULL),
(185, 'TH1369', 'Phát triển ứng dụng IoT', 3, 'Bắt buộc', '', 'TH1336'),
(186, 'TH1512', 'Đồ án CNTT 2', 2, 'Bắt buộc', '', NULL),
(187, 'TH1358', 'Bảo mật ứng dụng Web', 3, 'Tự chọn', '', NULL),
(188, 'TH1307', 'Hệ quản trị cơ sở dữ liệu', 3, 'Tự chọn', '', NULL),
(189, 'TH1339', 'Quản trị mạng máy tính', 3, 'Bắt buộc', '', NULL),
(190, 'TH1341', 'An toàn và an ninh thông tin', 3, 'Bắt buộc', '', NULL),
(191, 'TH1314', 'Lập trình mạng', 3, 'Bắt buộc', '', NULL),
(192, 'TH1342', 'Công nghệ mạng không dây', 2, 'Bắt buộc', '', NULL),
(193, 'TH1316', 'Thiết kế mạng máy tính', 3, 'Bắt buộc', '', NULL),
(194, 'TH1370', 'Triển khai hệ thống mạng văn phòng', 3, 'Bắt buộc', '', NULL),
(195, 'TH1526', 'Hệ thống thông tin quang', 2, 'Bắt buộc', '', NULL),
(196, 'TH1355', 'Hệ thống nhúng', 3, 'Bắt buộc', '', NULL),
(197, 'TH1356', 'Mạng trong IoT', 3, 'Bắt buộc', '', NULL),
(198, 'TH1357', 'Phát triển ứng dụng IoT nâng cao', 3, 'Bắt buộc', '', NULL),
(199, 'TH1377', 'Bảo mật trong IoT', 3, 'Bắt buộc', '', NULL),
(200, 'TH1360', 'Phân tích dữ liệu lớn trong IoT', 3, 'Bắt buộc', '', NULL),
(201, 'TH1361', 'Ứng dụng máy học trong IoT', 2, 'Bắt buộc', '', NULL),
(202, 'TH1362', 'Ứng dụng điện toán đám mây trong IoT', 2, 'Bắt buộc', '', NULL),
(203, 'TH1353', 'Điện toán đám mây', 2, 'Bắt buộc', '', NULL),
(204, 'TH1363', 'An toàn cơ sở dữ liệu', 3, 'Bắt buộc', '', NULL),
(205, 'TH1364', 'An toàn mạng máy tính', 3, 'Bắt buộc', '', NULL),
(206, 'TH1365', 'Tấn công mạng', 3, 'Bắt buộc', '', NULL),
(207, 'TH1366', 'Kỹ thuật phân tích mã độc', 3, 'Bắt buộc', '', NULL),
(208, 'TH1367', 'Quản lý rủi ro và an toàn thông tin trong doanh nghiệp ', 2, 'Bắt buộc', '', NULL),
(209, 'TH1368', 'An toàn điện toán đám mây', 3, 'Bắt buộc', '', NULL),
(210, 'TH1340', 'Hệ thống phân tán', 3, 'Bắt buộc', '', NULL),
(211, 'TH1387', 'Hệ điều hành nguồn mở', 2, 'Bắt buộc', '', NULL),
(212, 'TH1379', 'Công nghệ ảo hóa', 3, 'Bắt buộc', '', NULL),
(213, 'TH1378', 'Phát triển ứng dụng điện toán đám mây', 4, 'Bắt buộc', '', NULL),
(214, 'TH1601', 'Thực tập tốt nghiệp', 2, 'Bắt buộc', '', NULL),
(215, 'TH1602', 'Khóa luận tốt nghiệp', 10, 'Bắt buộc', '', NULL),
(216, 'TH1606', 'Thương mại điện tử', 3, 'Bắt buộc', '', NULL),
(217, 'TH1607', 'Cơ sở dữ liệu phân tán', 3, 'Bắt buộc', '', NULL),
(218, 'TH1608', 'Chuyên đề về công nghệ thông tin', 4, 'Bắt buộc', '', NULL);

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
  `practising` enum('Đạt','Chưa đạt') DEFAULT 'Chưa đạt',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_code`, `grade`, `language`, `infomatic`, `military`, `practising`, `created_at`) VALUES
(59, '22004151', '{\"CT2101\":\"8\"}', 'Chưa đạt', 'Chưa đạt', 'Chưa đạt', 'Chưa đạt', '2024-11-19 13:54:35');

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
  `email` varchar(255) DEFAULT NULL,
  `status` enum('Đang học','Tạm dừng học','Đã tốt nghiệp','Nghỉ học','Buộc thôi học') DEFAULT 'Đang học',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_code`, `full_name`, `identity`, `dob`, `gender`, `address`, `email`, `status`, `created_at`) VALUES
(37, '22004151', 'Võ Lê Minh Khang', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004151@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(38, '22004152', 'Hồng Phạm Gia Thiên', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004152@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(39, '22004153', 'Nguyễn Kim Hân', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004153@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(40, '22004154', 'Nguyễn Duy Quân', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004154@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(41, '22004155', 'Nguyễn Tuấn Đạt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004155@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(42, '22004156', 'Trần Phát Tài', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004156@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(43, '22004157', 'Nguyễn Tấn Lộc', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004157@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(44, '22004158', 'Nguyễn Tiểu Mẫn', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004158@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(45, '22004159', 'Nguyễn Thị Thảo Nhi', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004159@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(46, '22004160', 'Lê Gia Anh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004160@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(47, '22004161', 'Phan Vân Sơn', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004161@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(48, '22004162', 'Dương Võ Thành Luân', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004162@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(49, '22004163', 'Nguyễn Thành Đạt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004163@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(50, '22004164', 'Lê Quang Vinh Hiển', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004164@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(51, '22004165', 'Lê Phúc Duy', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004165@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(52, '22004166', 'Lê Thị Thúy Vy', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004166@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(53, '22004167', 'Lê Tiến Trung', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004167@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(54, '22004168', 'Võ Trọng Văn', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004168@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(55, '22004169', 'Nguyễn Vỹ Khang', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004169@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(56, '22004170', 'Hồ Thanh Trọng', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004170@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(57, '22004171', 'Nguyễn Định Tường', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004171@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(58, '22004172', 'Võ Hoàng Văn', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004172@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(59, '22004173', 'Trần Tuấn Kiệt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004173@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(60, '22004174', 'Phạm Tấn Dũng', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004174@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(61, '22004175', 'Bành Thế Nam', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004175@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(62, '22004176', 'Nguyễn Tuấn Kiệt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004176@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(63, '22004177', 'Phan Thị Tuyết Mai', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004177@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(64, '22004178', 'Nguyễn Văn Khỏe', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004178@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(65, '22004179', 'Đoàn Phước Phi', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004179@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(66, '22004180', 'Nguyễn Minh Quân', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004180@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(67, '22004181', 'Nguyễn Trường Giang', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004181@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(68, '22004182', 'Thạch Đa Ra', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004182@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(69, '22004183', 'Lê Triều Qui', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004183@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(70, '22004184', 'Nguyễn Thế Hiển', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004184@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(71, '22004185', 'Trần Lê Trọng Phúc', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004185@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(72, '22004186', 'Nguyễn Hoàng Khải', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004186@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(73, '22004187', 'Lê Thanh Lợi', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004187@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(74, '22004188', 'Nguyễn Thị Ngọc Huyền', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004188@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(75, '22004189', 'Nguyễn Thành Đạt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004189@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(76, '22004190', 'Nguyễn Gia Bảo', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004190@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(77, '22004191', 'Nguyễn Thị Tâm Đoan', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004191@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(78, '22004192', 'Trần Thanh Tuấn', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004192@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(79, '22004193', 'Phạm Hồng Cẩm', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004193@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(80, '22004194', 'Trần Minh Khang', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004194@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(81, '22004195', 'Phạm Huỳnh Khánh Nguyên', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004195@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(82, '22004196', 'Võ Thị Thãng', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004196@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(83, '22004197', 'Phan Thị Thùy Trang', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004197@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(84, '22004198', 'Nguyễn Thị Như Ý', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004198@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(85, '22004199', 'Nguyễn Trương Khánh Tường', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004199@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(86, '22004200', 'Lê Minh Nhựt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004200@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(87, '22004201', 'Trần Nguyễn Duy Đạt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004201@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(88, '22004202', 'Trần Huỳnh Ngọc Hương', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004202@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(89, '22004203', 'Nguyễn Hoàng Phúc', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004203@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(90, '22004204', 'Hồ Ngọc Gấm', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004204@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(91, '22004205', 'Nguyễn Quang Trung', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004205@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(92, '22004206', 'Trần Cao Trí', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004206@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(93, '22004207', 'Nguyễn Thanh Nam', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004207@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(94, '22004208', 'Nguyễn Thanh Hoài', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004208@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(95, '22004209', 'Lê Nguyễn Minh Châu', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004209@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(96, '22004210', 'Mai Minh Khôi', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004210@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(97, '22004211', 'Hồ Duy Khang', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004211@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(98, '22004212', 'Nguyễn Hoài Phong', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004212@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(99, '22004213', 'Nguyễn Thanh Phong', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004213@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(100, '22004214', 'Đặng Thị Thúy Ngân', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004214@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(101, '22004215', 'Nguyễn Nhựt Hào', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004215@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(102, '22004216', 'Mai Gia Hân', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004216@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(103, '22004217', 'Nguyễn Gia Thịnh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004217@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(104, '22004218', 'Nguyễn Hữu Vinh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004218@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(105, '22004219', 'Võ Việt Tiến', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004219@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(106, '22004220', 'Phạm Minh Gia Nghiêm', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004220@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(107, '22004221', 'Nguyễn Vũ Khánh Duy', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004221@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(108, '22004222', 'Nguyễn Văn Phước Thảo', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004222@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(109, '22004223', 'Nguyễn Diệp Thiên Quân', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004223@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(110, '22004224', 'Đặng Nhật Đan', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004224@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(111, '22004225', 'Mai Thị Ngọc Trâm', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004225@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(112, '22004226', 'Trần Thanh Duy', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004226@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(113, '22004227', 'Dương Trần Phi Yến', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004227@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(114, '22004228', 'Nguyễn Phạm Minh Kha', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004228@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(115, '22004229', 'Nguyễn Tấn Lộc', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004229@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(116, '22004230', 'Phan Nguyễn Ngọc Chi', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004230@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(117, '22004231', 'Nguyễn Trần Cẩm Nhung', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004231@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(118, '22004232', 'Võ Tiến Đạt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004232@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(119, '22004233', 'Lê Chí Khanh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004233@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(120, '22004234', 'Đặng Khánh Vy', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004234@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(121, '22004235', 'Trần Ngọc Hân', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004235@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(122, '22004236', 'Huỳnh Tiền Em', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004236@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(123, '22004237', 'Huỳnh Phúc An', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004237@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(124, '22004238', 'Lê Văn Khanh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004238@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(125, '22004239', 'Nguyễn Công Danh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004239@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(126, '22004240', 'Trịnh Phước Nhựt Hoàng', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004240@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(127, '22004241', 'Nguyễn Trường Huy', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004241@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(128, '22004242', 'Đặng Thị Thùy Linh', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004242@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(129, '22004243', 'Bùi Nhật Vinh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004243@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(130, '22004244', 'Lê Thanh Phong', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004244@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(131, '22004245', 'Trần Hoàng Khang', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004245@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(132, '22004246', 'Lưu Tuấn Thành', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004246@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(133, '22004247', 'Cao Hồng Phi', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004247@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(134, '22004248', 'Biện Minh Hiếu', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004248@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(135, '22004249', 'Nguyễn Quốc Tuấn', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004249@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(136, '22004250', 'Nguyễn Dương Khang', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004250@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(137, '22004251', 'Nguyễn Khoa Đăng', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004251@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(138, '22004252', 'Dương Hoàng Quốc Thái', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004252@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(139, '22004253', 'Lưu Ngọc Thiên', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004253@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(140, '22004254', 'Trần Vĩnh Phúc', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004254@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(141, '22004255', 'Nguyễn Nhựt Hào', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004255@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(142, '22004256', 'Nguyễn Hiếu Đạt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004256@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(143, '22004257', 'Lê Duy Phú', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004257@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(144, '22004258', 'Trần Duy Khánh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004258@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(145, '22004259', 'Trương Hoàng Anh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004259@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(146, '22004260', 'Nguyễn Minh Hiển', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004260@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(147, '22004261', 'Phan Thị Mỹ Tiên', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004261@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(148, '22004262', 'Nguyễn Phúc Hạnh Nguyên', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004262@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(149, '22004263', 'Trần Ngọc Mỹ Duyên', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004263@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(150, '22004264', 'Nguyễn Thành Thơ', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004264@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(151, '22004265', 'Lê Phúc Khang', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004265@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(152, '22004266', 'Thạch Chí Hiếu', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004266@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(153, '22004267', 'Huỳnh Trường Giang', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004267@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(154, '22004268', 'Nguyễn Hữu Phúc', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004268@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(155, '22004269', 'Phan Khánh Duy', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004269@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(156, '22004270', 'Nguyễn Hải Đăng', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004270@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(157, '22004271', 'Nguyễn Thanh Sơn', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004271@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(158, '22004272', 'Đinh Hoàng Minh Khoa', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004272@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(159, '22004273', 'Nguyễn Huỳnh Anh Kiệt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004273@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(160, '22004274', 'Phạm Lê Phát Huy', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004274@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(161, '22004275', 'Đặng Thị Thúy Vy', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004275@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(162, '22004276', 'Nguyễn Hoài Nam', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004276@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(163, '22004277', 'Hồ Thị Thùy Dương', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004277@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(164, '22004278', 'Đặng Tuấn Kiệt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004278@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(165, '22004279', 'Trần Minh Quý', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004279@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(166, '22004280', 'Nguyễn Hoài Nam', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004280@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(167, '22004281', 'Nguyễn Lê Duy', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004281@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(168, '22004282', 'Lê Huy Cường', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004282@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(169, '22004283', 'Vương Hữu Thịnh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004283@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(170, '22004284', 'Nguyễn Cao Khén', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004284@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(171, '22004285', 'Võ Đinh Hoàng Mỹ', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004285@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(172, '22004286', 'Lâm Lê Gia Kim', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004286@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(173, '22004287', 'Võ Thị Ngọc Hân', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004287@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(174, '22004288', 'Nguyễn Thị Phương Trầm', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004288@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(175, '22004289', 'Ngô Minh Khánh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004289@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(176, '22004290', 'Võ Hoàng Tấn Phát', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004290@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(177, '22004291', 'Nguyễn Đức Phúc An', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004291@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(178, '22004292', 'Nguyễn Thị Thuý An', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004292@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(179, '22004293', 'Nguyễn Bảo Lộc', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004293@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(180, '22004294', 'Trịnh Khắc Nhựt', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004294@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(181, '22004295', 'Huỳnh Thúy Quyên', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004295@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(182, '22004296', 'Trần Huỳnh Viễn Hưng', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004296@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(183, '22004297', 'Trương Minh Thư', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004297@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(184, '22004298', 'Nguyễn Ngọc Cẩm Tú', '86123456789', '2004-01-01', 'Nữ', 'Vĩnh Long', '22004298@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(185, '22004299', 'Ngô Duy Khánh', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004299@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17'),
(186, '22004300', 'Trương Anh Tú', '86123456789', '2004-01-01', 'Nam', 'Vĩnh Long', '22004300@st.vlute.edu.vn', 'Đang học', '2024-11-18 16:02:17');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

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
  ADD CONSTRAINT `course_prefk` FOREIGN KEY (`pre_course`) REFERENCES `courses` (`course_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `fk_students` FOREIGN KEY (`student_code`) REFERENCES `students` (`student_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
