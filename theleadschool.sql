-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2026 at 11:58 AM
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
-- Database: `theleadschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

CREATE TABLE `active_users` (
  `id` int(11) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `visitor_ip` varchar(45) NOT NULL,
  `current_page` varchar(255) DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `active_users`
--

INSERT INTO `active_users` (`id`, `session_id`, `visitor_ip`, `current_page`, `last_activity`) VALUES
(143, '03nbnf85sis9vmescqqmr6cum4', '::1', '/AimsGroupOfColleges/index.php', '2026-08-24 09:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('super_admin','admin','moderator') DEFAULT 'admin',
  `status` enum('active','inactive') DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `full_name`, `email`, `role`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(2, 'admin', '$2y$10$/o35JgU6QYIwUx/LbF06YevNTQlJtIJ5PhtjZMPK82BP7FuL6xX9u', 'Administrator', 'sphs.pk.148@gmail.com', 'admin', 'active', '2026-08-20 16:30:32', '2025-12-26 07:04:40', '2026-08-20 11:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `cnic_bform` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `course_id` varchar(100) NOT NULL,
  `medium` varchar(10) NOT NULL DEFAULT 'English',
  `previous_education` varchar(255) DEFAULT NULL,
  `documents` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`id`, `student_name`, `father_name`, `cnic_bform`, `phone`, `email`, `address`, `course_id`, `medium`, `previous_education`, `documents`, `message`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(2, 'Umar Ali', 'Arshad Ali', '45234523452452', '03159060190', '', 'adfasdfadfadsf', '8', 'English', '65%', '', '', 'pending', NULL, '2026-03-31 06:54:23', '2026-03-31 06:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `current_job` varchar(150) DEFAULT NULL,
  `job_department` varchar(150) DEFAULT NULL,
  `job_city` varchar(100) DEFAULT NULL,
  `course` varchar(100) NOT NULL,
  `passing_year` int(4) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `whatsapp_number` varchar(20) DEFAULT NULL,
  `review` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_reviews`
--

CREATE TABLE `alumni_reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `passing_year` int(4) DEFAULT NULL,
  `review` text NOT NULL,
  `rating` int(1) DEFAULT 5,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `board_results`
--

CREATE TABLE `board_results` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `board_type` enum('Matric','Intermediate') NOT NULL,
  `year` int(4) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campuses`
--

CREATE TABLE `campuses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `area` varchar(150) NOT NULL COMMENT 'e.g. Green Town, Gujranwala',
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `students` varchar(20) DEFAULT NULL COMMENT 'e.g. 800+',
  `programs` varchar(10) DEFAULT NULL COMMENT 'e.g. 12',
  `since_year` varchar(10) DEFAULT NULL COMMENT 'e.g. 2009',
  `icon` varchar(50) DEFAULT 'fa-building-columns' COMMENT 'Font Awesome class',
  `badge` varchar(50) DEFAULT NULL COMMENT 'e.g. Headquarters, Boys Campus',
  `badge_color` varchar(20) DEFAULT '#0B7275',
  `color_from` varchar(20) DEFAULT '#052E30' COMMENT 'Gradient start hex',
  `color_to` varchar(20) DEFAULT '#0B7275' COMMENT 'Gradient end hex',
  `map_query` varchar(200) DEFAULT NULL COMMENT 'Google Maps query, e.g. Green+Town+Gujranwala+Pakistan',
  `facilities` varchar(500) DEFAULT NULL COMMENT 'Comma separated list',
  `is_main` tinyint(1) DEFAULT 0 COMMENT 'Featured in the Location/Map section',
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campuses`
--

INSERT INTO `campuses` (`id`, `name`, `area`, `phone`, `email`, `students`, `programs`, `since_year`, `icon`, `badge`, `badge_color`, `color_from`, `color_to`, `map_query`, `facilities`, `is_main`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Main Campus', 'Green Town, Gujranwala', '0300 0642851', 'main@aimsgroupofcolleges.com', '800+', '12', '2009', 'fa-building-columns', 'Headquarters', '#0B7275', '#052E30', '#0B7275', 'Green+Town+Gujranwala+Pakistan', 'Computer Lab,Science Labs,Library,Cafeteria,Sports Ground,Prayer Area', 1, 1, 'active', '2026-08-18 10:20:33', '2026-08-18 10:20:33'),
(2, 'North Campus', 'Satellite Town, Gujranwala', '0346 4890875', 'north@aimsgroupofcolleges.com', '500+', '8', '2014', 'fa-school', 'Boys Campus', '#7C3AED', '#3B1F6B', '#7C3AED', 'Satellite+Town+Gujranwala+Pakistan', 'Computer Lab,Science Labs,Library,Sports Facility,Prayer Area,Canteen', 0, 2, 'active', '2026-08-18 10:20:33', '2026-08-18 10:20:33'),
(3, 'Girls Campus', 'Civil Lines, Gujranwala', '0300 1234567', 'girls@aimsgroupofcolleges.com', '600+', '10', '2016', 'fa-graduation-cap', 'Girls Campus', '#D91E8C', '#7A0A4E', '#D91E8C', 'Civil+Lines+Gujranwala+Pakistan', 'Computer Lab,Science Labs,Library,Prayer Area,Cafeteria,Recreation Room', 0, 3, 'active', '2026-08-18 10:20:33', '2026-08-18 10:20:33'),
(4, 'Lahore Campus', 'Model Town, Lahore', '0321 9876543', 'lahore@aimsgroupofcolleges.com', '400+', '7', '2020', 'fa-city', 'New Campus', '#F0A500', '#7A5200', '#F0A500', 'Model+Town+Lahore+Pakistan', 'Computer Lab,Science Labs,Library,Sports Area,Cafeteria,Smart Classrooms', 0, 4, 'active', '2026-08-18 10:20:33', '2026-08-18 10:20:33');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','replied') DEFAULT 'unread',
  `admin_reply` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_faqs`
--

CREATE TABLE `contact_faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_faqs`
--

INSERT INTO `contact_faqs` (`id`, `question`, `answer`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'What are the admission requirements?', 'Requirements vary by program. Generally needed: previous educational certificates, CNIC/B-Form, passport photos, and admission fee. Visit our Admission page for full details.', 1, 'active', '2026-08-18 10:43:52', '2026-08-18 10:43:52'),
(2, 'How can I apply for admission?', 'Apply online through our Admission page, or visit our campus in person. Fill the form, submit documents, and pay the admission fee.', 2, 'active', '2026-08-18 10:43:52', '2026-08-18 10:43:52'),
(3, 'What is the fee structure?', 'Fees range from Rs. 3,000/month (short courses) to Rs. 8,000/month (entry test prep). Matric: Rs. 5,000/mo. Intermediate: Rs. 6,000/mo. One-time admission fee: Rs. 2,000.', 3, 'active', '2026-08-18 10:43:52', '2026-08-18 10:43:52'),
(4, 'Do you offer scholarships?', 'Yes! We offer merit-based and need-based scholarships. Sibling discounts and installment plans are also available. Contact our admission office for details.', 4, 'active', '2026-08-18 10:43:52', '2026-08-18 10:43:52'),
(5, 'How can I contact a specific teacher?', 'Visit our campus during office hours or call us. We will connect you with the right faculty member or department directly.', 5, 'active', '2026-08-18 10:43:52', '2026-08-18 10:43:52');

-- --------------------------------------------------------

--
-- Table structure for table `core_values`
--

CREATE TABLE `core_values` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(50) DEFAULT 'fas fa-star' COMMENT 'Font Awesome class, e.g. fas fa-star',
  `color` varchar(20) DEFAULT '#0B7275' COMMENT 'Hex color for icon and accent',
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `core_values`
--

INSERT INTO `core_values` (`id`, `title`, `description`, `icon`, `color`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Excellence', 'We strive for the highest standards in teaching, learning, and all our educational programs.', 'fas fa-star', '#0B7275', 1, 'active', '2026-07-27 09:28:39', '2026-07-27 09:28:39'),
(2, 'Integrity', 'We uphold honesty, transparency, and ethical conduct in all our interactions.', 'fas fa-handshake', '#2e7d32', 2, 'active', '2026-07-27 09:28:39', '2026-07-27 09:28:39'),
(3, 'Innovation', 'We embrace new ideas, modern teaching methods, and continuous improvement.', 'fas fa-lightbulb', '#F0A500', 3, 'active', '2026-07-27 09:28:39', '2026-07-27 09:28:39'),
(4, 'Respect', 'We value diversity, dignity, and mutual respect among all members.', 'fas fa-heart', '#e53935', 4, 'active', '2026-07-27 09:28:39', '2026-07-27 09:28:39'),
(5, 'Community', 'We foster a supportive learning environment and positive relationships.', 'fas fa-users', '#7b1fa2', 5, 'active', '2026-07-27 09:28:39', '2026-07-27 09:28:39'),
(6, 'Social Responsibility', 'We prepare students to be responsible citizens who contribute positively.', 'fas fa-globe', '#00695c', 6, 'active', '2026-07-27 09:28:39', '2026-07-27 09:28:39');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `category` varchar(20) DEFAULT 'regular' COMMENT 'regular, test, or short',
  `icon` varchar(50) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `duration`, `fee`, `category`, `icon`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(4, 'O Level – Part 1', 'The O Level – Part 1 program at Sir Syed Degree College Chowki AJK provides students with a strong academic foundation in core subjects and essential learning skills. This stage focuses on developing critical thinking, analytical abilities, and a deep understanding of fundamental concepts.\r\n\r\nStudents are guided by experienced teachers who help them build confidence in their studies while encouraging curiosity and independent learning. The curriculum is designed to prepare students for the advanced level of O Level studies and future academic challenges.', '1 year', 70000.00, 'regular', NULL, 0, 'active', '2026-03-16 03:09:25', '2026-03-16 03:09:25'),
(5, 'O Level – Part 2', 'The O Level – Part 2 program is the continuation of the O Level journey where students strengthen their subject knowledge and prepare for their final examinations. At this stage, greater emphasis is placed on problem-solving, practical learning, and exam preparation.\r\n\r\nThrough modern teaching methods and continuous assessment, students are supported in achieving academic excellence and developing the skills required for higher education and professional success.', '1 year', 70000.00, 'regular', NULL, 0, 'active', '2026-03-16 03:10:04', '2026-03-16 03:10:04'),
(6, 'A Level – Part 1', 'The A Level – Part 1 program focuses on advanced learning and subject specialization. Students are encouraged to explore their academic interests while developing strong analytical and research skills.\r\n\r\nAt Sir Syed Degree College Chowki AJK, our faculty provides personalized guidance to help students understand complex concepts and build a solid foundation for the final stage of A Level studies.', '1 year', 80000.00, 'regular', NULL, 0, 'active', '2026-03-16 03:10:40', '2026-03-16 03:10:40'),
(7, 'A Level – Part 2', 'The A Level – Part 2 program represents the final stage of advanced secondary education. Students refine their knowledge, improve their academic performance, and prepare for higher education opportunities.\r\n\r\nThis stage emphasizes independent thinking, problem-solving abilities, and academic excellence. Our goal is to equip students with the knowledge, confidence, and skills needed to succeed in universities and future careers.', '1 year', 80000.00, 'regular', NULL, 0, 'active', '2026-03-16 03:11:14', '2026-03-16 03:11:14'),
(8, 'ECAT Preparation', 'Intensive preparation course for Engineering College Admission Test. Covers all test patterns, practice questions, and proven strategies for success.', '6 Months', 40000.00, 'regular', NULL, 0, 'active', '2026-03-16 03:12:11', '2026-03-16 03:12:11'),
(9, 'MDCAT Preparation', 'Comprehensive Medical and Dental College Admission Test preparation. Expert faculty, extensive practice tests, and personalized guidance.', '6 Months', 50000.00, 'regular', NULL, 0, 'active', '2026-03-16 03:12:48', '2026-03-16 03:12:48');

-- --------------------------------------------------------

--
-- Table structure for table `datesheet_details`
--

CREATE TABLE `datesheet_details` (
  `id` int(11) NOT NULL,
  `datesheet_id` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `day_name` varchar(20) NOT NULL,
  `class` varchar(20) NOT NULL,
  `subject` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dms_features`
--

CREATE TABLE `dms_features` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(50) DEFAULT 'fas fa-star' COMMENT 'Font Awesome class, e.g. fas fa-star',
  `color` varchar(20) DEFAULT '#0B7275' COMMENT 'Hex color for icon and accent',
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dms_features`
--

INSERT INTO `dms_features` (`id`, `title`, `description`, `icon`, `color`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Online Exam Results', 'Instant results & detailed analysis', 'fas fa-chart-line', '#0BBFC6', 1, 'active', '2026-08-18 09:27:10', '2026-08-18 09:27:10'),
(2, 'Digital Attendance', 'Real-time tracking & reports', 'fas fa-user-check', '#4CAF50', 2, 'active', '2026-08-18 09:27:10', '2026-08-18 09:27:10'),
(3, 'WhatsApp & SMS', 'Automated alerts to parents', 'fab fa-whatsapp', '#25D366', 3, 'active', '2026-08-18 09:27:10', '2026-08-18 09:27:10'),
(4, 'Parent Complaints', 'Quick resolution system', 'fas fa-comments', '#FF7043', 4, 'active', '2026-08-18 09:27:10', '2026-08-18 09:27:10'),
(5, 'Fee Management', 'Online fee history & tracking', 'fas fa-wallet', '#CE93D8', 5, 'active', '2026-08-18 09:27:10', '2026-08-18 09:27:10'),
(6, 'Digital Diaries', 'Homework & assignments online', 'fas fa-book-open', '#EF5350', 6, 'active', '2026-08-18 09:27:10', '2026-08-18 09:27:10'),
(7, 'Smart Timetable', 'Dynamic class schedules', 'fas fa-calendar-alt', '#26C6DA', 7, 'active', '2026-08-18 09:27:10', '2026-08-18 09:27:10'),
(8, 'PTM Notes', 'Parent-teacher meeting records', 'fas fa-clipboard-list', '#FFA726', 8, 'active', '2026-08-18 09:27:10', '2026-08-18 09:27:10');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date NOT NULL,
  `time` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `exam_title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `exam_title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Annual Examination 2025 9th-B', 'dummy data', 'active', '2026-01-27 09:19:54', '2026-01-27 09:54:14'),
(3, 'Mid Term Exam 2025 9th-B', '', 'active', '2026-01-27 10:39:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_datesheets`
--

CREATE TABLE `exam_datesheets` (
  `id` int(11) NOT NULL,
  `exam_name` varchar(150) NOT NULL,
  `exam_year` int(4) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `subjects` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `icon` varchar(50) DEFAULT 'fa-chalkboard-teacher' COMMENT 'Font Awesome class fallback avatar icon',
  `bio` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_structure`
--

CREATE TABLE `fee_structure` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(150) DEFAULT NULL,
  `price` varchar(50) NOT NULL COMMENT 'e.g. 5,000 or 7,000-8,000',
  `price_period` varchar(50) DEFAULT 'per month',
  `icon` varchar(50) DEFAULT 'fas fa-tag' COMMENT 'Font Awesome class',
  `color` varchar(20) DEFAULT '#0B7275' COMMENT 'Hex color for card gradient',
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_structure`
--

INSERT INTO `fee_structure` (`id`, `title`, `subtitle`, `price`, `price_period`, `icon`, `color`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Matric Programs', '9th & 10th Grade', '5,000', 'per month', 'fas fa-graduation-cap', '#0B7275', 1, 'active', '2026-08-18 10:11:49', '2026-08-18 10:11:49'),
(2, 'Intermediate', 'FSc / ICS Programs', '6,000', 'per month', 'fas fa-university', '#1565c0', 2, 'active', '2026-08-18 10:11:49', '2026-08-18 10:11:49'),
(3, 'Entry Test Prep', 'ECAT / MDCAT / IELTS', '7,000-8,000', 'per month', 'fas fa-pencil-alt', '#e65100', 3, 'active', '2026-08-18 10:11:49', '2026-08-18 10:11:49'),
(4, 'Short Courses', 'IT / Languages / Math', '3,000-5,000', 'per month', 'fas fa-clock', '#7b1fa2', 4, 'active', '2026-08-18 10:11:49', '2026-08-18 10:11:49'),
(5, 'Admission Fee', 'One-time registration', '2,000', 'one time', 'fas fa-star', '#c62828', 5, 'active', '2026-08-18 10:11:49', '2026-08-18 10:11:49');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` enum('events','classes','activities','achievements') DEFAULT 'events',
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hero_carousel`
--

CREATE TABLE `hero_carousel` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `text_color` varchar(20) DEFAULT '#ffffff',
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_carousel`
--

INSERT INTO `hero_carousel` (`id`, `image_path`, `title`, `subtitle`, `text_color`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'images/hero/slide_1779181802_8456.jpg', 'Aims Group Of Colleges', 'Empowering students with quality education', '#ffffff', 1, 'active', '2025-12-26 10:06:59', '2026-05-19 09:10:02'),
(2, 'images/hero/slide_1773486400_4238.png', 'Excellence in Education', 'Building tomorrow\'s leaders today', '#ffffff', 2, 'active', '2025-12-26 10:06:59', '2026-03-14 11:06:40');

-- --------------------------------------------------------

--
-- Table structure for table `leadership`
--

CREATE TABLE `leadership` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `role_title` varchar(100) DEFAULT NULL COMMENT 'e.g., Founder Message, Director Message',
  `photo` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leadership`
--

INSERT INTO `leadership` (`id`, `name`, `designation`, `role_title`, `photo`, `signature`, `message`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ABC', 'Principal', 'Principal', 'images/leadership/leader_1773568775_7696.jpg', '', 'At AIMS Group of Colleges, we believe that education is the key to a successful and purposeful life. Our mission is not only to provide high-quality academic education but also to nurture confidence, discipline, creativity, and leadership qualities in our students. We are dedicated to creating a positive and inspiring learning environment where every student is encouraged to discover their talents and reach their highest potential.\r\n\r\nOur experienced and committed faculty members work passionately to guide, support, and mentor students in their academic and personal growth. We strive to develop individuals who are intellectually strong, morally responsible, and socially aware, preparing them to meet the challenges of the modern world with confidence and determination.\r\n\r\nAt AIMS Group of Colleges, we are committed to maintaining the values of excellence, integrity, and respect while shaping the future leaders of tomorrow. We warmly welcome students and parents to join us on this journey of knowledge, achievement, and a brighter future.\r\n', 1, 'active', '2025-12-26 07:56:01', '2026-05-19 10:38:10'),
(2, 'XYZ', 'Vice Principal', 'Vice Principal', 'images/leadership/leader_1773568876_7312.jpg', '', 'It is my pleasure to welcome you to AIMS Group of Colleges.\r\n\r\nOur institution is dedicated to providing a supportive, modern, and inspiring learning environment where students can achieve academic excellence while developing strong moral and ethical values. We believe that education is not only about acquiring knowledge but also about building character, discipline, confidence, and leadership skills.\r\n\r\nAt AIMS Group of Colleges, we encourage our students to think creatively, work with dedication, and strive for continuous growth and improvement. Our highly qualified teachers and committed staff work together to guide and mentor students toward success, helping them become responsible, confident, and productive members of society.\r\n\r\nWe take pride in the achievements of our students and remain committed to nurturing their talents, broadening their vision, and preparing them for the opportunities and challenges of the modern world. We warmly welcome students and parents to become part of our journey toward excellence, success, and a brighter future.\r\n', 2, 'active', '2025-12-26 07:56:01', '2026-05-19 10:38:46');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` varchar(50) DEFAULT 'text',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `created_at`, `updated_at`) VALUES
(25, 'site_name', 'AIMS Group of Colleges', 'text', '2025-12-26 07:28:46', '2026-05-19 09:22:08'),
(26, 'site_email', 'info@aimsgroupofcolleges.com', 'text', '2025-12-26 07:28:46', '2026-05-19 09:22:08'),
(27, 'site_phone', '0346-4890875', 'text', '2025-12-26 07:28:46', '2026-03-14 10:50:18'),
(28, 'site_address', 'Chowki, Bhimber, Pakistan, 10080', 'text', '2025-12-26 07:28:46', '2026-03-14 10:50:18'),
(29, 'hero_image', 'images/hero/hero_1766742714.jpeg', 'text', '2025-12-26 07:51:44', '2025-12-26 09:51:54'),
(30, 'office_hours', 'Mon - Sat: 8:00 AM - 5:00 PM', 'text', '2025-12-27 07:13:03', '2025-12-27 07:13:03'),
(31, 'facebook_url', 'https://www.facebook.com/AimsGroup.Pakistan/', 'text', '2025-12-27 07:13:03', '2026-05-19 11:06:42'),
(32, 'instagram_url', '', 'text', '2025-12-27 07:13:03', '2025-12-27 07:13:03'),
(33, 'youtube_url', '', 'text', '2025-12-27 07:13:03', '2025-12-27 07:13:03'),
(34, 'twitter_url', '', 'text', '2025-12-27 07:13:03', '2025-12-27 07:13:03'),
(35, 'hero_title', 'Lighting the Candle of Knowledge', 'text', '2025-12-27 07:13:03', '2026-08-18 09:37:37'),
(36, 'hero_description', 'Empowering students with quality education and nurturing their potential to become future leaders.', 'text', '2025-12-27 07:13:03', '2026-08-18 09:37:37'),
(37, 'hero_button_text', 'Apply Now', 'text', '2025-12-27 07:13:03', '2026-08-18 09:37:37'),
(38, 'hero_button_link', 'admission.php', 'text', '2025-12-27 07:13:03', '2025-12-27 07:13:03'),
(39, 'stats_students', '500', 'text', '2025-12-27 07:13:03', '2026-08-18 09:37:37'),
(40, 'stats_teachers', '50', 'text', '2025-12-27 07:13:03', '2026-08-18 09:37:37'),
(41, 'stats_courses', '15', 'text', '2025-12-27 07:13:03', '2026-08-18 09:37:37'),
(42, 'stats_years', '10', 'text', '2025-12-27 07:13:03', '2026-08-18 09:37:37'),
(43, 'about_description', 'AIMS Group of Colleges is a leading educational institution committed to excellence in education...', 'text', '2025-12-27 07:13:03', '2026-08-18 09:52:31'),
(44, 'mission_statement', 'The mission of AIMS Group of Colleges is to provide high-quality education in a supportive and disciplined environment that encourages academic excellence, critical thinking, and personal growth. We aim to equip our students with knowledge, skills, and strong moral values so they can contribute positively to society and become responsible citizens.\r\n\r\nOur goal is to inspire students to achieve their full potential through dedicated teaching, modern learning methods, and a commitment to lifelong learning. We strive to develop confident, capable, and ethical individuals who are prepared to face the challenges of the future and play a meaningful role in the development of their community and nation.', 'text', '2025-12-27 07:13:03', '2026-05-19 10:36:43'),
(45, 'vision_statement', 'The vision of AIMS Group of Colleges is to become a leading educational institution recognized for academic excellence, character building, and innovation in learning. We aspire to create an environment where students are inspired to achieve their highest potential and develop into knowledgeable, confident, and responsible individuals.', 'text', '2025-12-27 07:13:03', '2026-05-19 10:36:43'),
(46, 'footer_about_text', 'AIMS Group of Colleges is dedicated to providing quality education focused on academic excellence, discipline, and ethical values. We strive to nurture confident, responsible, and well-rounded students in a supportive and inspiring learning environment.', 'text', '2025-12-27 07:13:03', '2026-05-19 10:36:43'),
(47, 'copyright_text', 'AIMS Group of Colleges. All rights reserved.', 'text', '2025-12-27 07:13:03', '2026-05-19 10:36:43'),
(48, 'google_maps_embed', '', 'text', '2025-12-27 07:13:03', '2025-12-27 07:13:03'),
(49, 'whatsapp_number', '', 'text', '2025-12-27 07:13:03', '2025-12-27 07:13:03'),
(50, 'about_stat1_number', '98%', 'text', '2026-08-18 09:52:30', '2026-08-18 09:52:30'),
(51, 'about_stat1_label', 'Board Pass Rate', 'text', '2026-08-18 09:52:30', '2026-08-18 09:52:30'),
(52, 'about_stat2_number', '500+', 'text', '2026-08-18 09:52:30', '2026-08-18 09:52:30'),
(53, 'about_stat2_label', 'Students Enrolled', 'text', '2026-08-18 09:52:30', '2026-08-18 09:52:30'),
(54, 'about_stat3_number', '40+', 'text', '2026-08-18 09:52:30', '2026-08-18 09:52:30'),
(55, 'about_stat3_label', 'Expert Faculty', 'text', '2026-08-18 09:52:31', '2026-08-18 09:52:31'),
(56, 'about_stat4_number', '15+', 'text', '2026-08-18 09:52:31', '2026-08-18 09:52:31'),
(57, 'about_stat4_label', 'Years of Excellence', 'text', '2026-08-18 09:52:31', '2026-08-18 09:52:31'),
(58, 'contact_hours_weekday', '8:00 AM - 5:00 PM', 'text', '2026-08-18 10:51:15', '2026-08-18 10:51:15'),
(59, 'contact_hours_saturday', '9:00 AM - 3:00 PM', 'text', '2026-08-18 10:51:15', '2026-08-18 10:51:15'),
(60, 'contact_hours_sunday', 'Closed', 'text', '2026-08-18 10:51:15', '2026-08-18 10:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `student_exams`
--

CREATE TABLE `student_exams` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `total_marks` decimal(10,2) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `registration_no` varchar(100) NOT NULL,
  `obtain_marks` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_exams`
--

INSERT INTO `student_exams` (`id`, `exam_id`, `total_marks`, `student_name`, `father_name`, `registration_no`, `obtain_marks`, `created_at`, `updated_at`) VALUES
(1, 2, 75.00, 'Zaid', 'Ali', '258', 65.00, '2026-01-27 09:45:40', NULL),
(2, 2, 75.00, 'Subhan', 'Mukhtar', '260', 72.00, '2026-01-27 09:45:40', NULL),
(3, 2, 75.00, 'Hameed', 'Ahmad', '245', 55.00, '2026-01-27 09:45:40', NULL),
(4, 2, 75.00, 'Asghar', 'Ali', '261', 75.00, '2026-01-27 09:45:40', NULL),
(5, 2, 75.00, 'Aqib', 'Majeed', '290', 49.00, '2026-01-27 09:45:40', '2026-01-27 09:55:20'),
(6, 2, 75.00, 'Hamza', 'Babar', '300', 21.00, '2026-01-27 09:45:40', NULL),
(7, 3, 50.00, 'Zaid', NULL, '258', 11.00, '2026-01-27 10:45:58', NULL),
(8, 3, 100.00, 'Ali Ahmed', 'Hasan Ahmed', '2024-001', 85.00, '2026-03-02 08:07:22', NULL),
(9, 3, 100.00, 'Sara Khan', 'Imran Khan', '2024-002', 92.00, '2026-03-02 08:07:22', NULL),
(10, 3, 100.00, 'Zain Malik', 'Usman Malik', '2024-003', 78.00, '2026-03-02 08:07:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `theme_name` varchar(100) NOT NULL,
  `primary_color` varchar(7) NOT NULL DEFAULT '#0B4DA2',
  `secondary_color` varchar(7) NOT NULL DEFAULT '#FFFFFF',
  `accent_color` varchar(7) NOT NULL DEFAULT '#F9C900',
  `logo_path` varchar(255) DEFAULT 'images/logo.png',
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `theme_name`, `primary_color`, `secondary_color`, `accent_color`, `logo_path`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Default - Blue & Yellow', '#0B4DA2', '#FFFFFF', '#F9C900', 'images/logos/logo_1768371326.jpeg', 0, '2025-12-26 06:58:34', '2026-01-14 07:00:26'),
(2, 'Green Theme', '#1B5E20', '#FFFFFF', '#FDD835', 'images/logo.png', 0, '2025-12-26 06:58:34', '2026-01-14 06:59:57'),
(3, 'Purple Theme', '#4A148C', '#FFFFFF', '#FFD740', 'images/logo.png', 0, '2025-12-26 06:58:34', '2025-12-26 06:58:34'),
(4, 'Red Theme', '#B71C1C', '#FFFFFF', '#FFD700', 'images/logos/logo_1766733969.png', 0, '2025-12-26 06:58:34', '2025-12-26 09:38:48'),
(5, 'Teal Theme', '#00695C', '#FFFFFF', '#FFB300', 'images/logos/logo_1768385142.png', 0, '2025-12-26 06:58:34', '2026-03-14 11:08:46'),
(6, 'AIMS Teal Theme', '#0B7275', '#FFFFFF', '#F0A500', 'images/logos/logo_1780899737.png', 1, '2025-12-26 06:58:34', '2026-06-08 06:22:17');

-- --------------------------------------------------------

--
-- Table structure for table `unique_visitors`
--

CREATE TABLE `unique_visitors` (
  `id` int(11) NOT NULL,
  `visitor_ip` varchar(45) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `first_visit` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_visit` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_visits` int(11) DEFAULT 1,
  `user_agent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unique_visitors`
--

INSERT INTO `unique_visitors` (`id`, `visitor_ip`, `session_id`, `first_visit`, `last_visit`, `total_visits`, `user_agent`) VALUES
(1, '127.0.0.1', 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27 09:51:30', '2025-12-27 10:43:42', 29, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0'),
(2, '::1', 'kkbk6ki04deocaqg1c56a1h1hs', '2026-01-05 07:54:49', '2026-01-05 09:10:20', 4, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36'),
(3, '127.0.0.1', '1tkhaulgu9mobi38vhu99gj6cd', '2026-01-13 09:31:44', '2026-01-13 09:59:52', 8, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0'),
(4, '::1', 'h8unkai0empu9dca4f89dpnetj', '2026-01-14 05:39:31', '2026-01-14 07:20:50', 31, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36'),
(5, '127.0.0.1', '05gcre9067e2v7pejjete1vgda', '2026-01-14 10:04:17', '2026-01-14 10:05:48', 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0'),
(6, '::1', 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27 08:52:04', '2026-01-27 10:47:01', 26, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36'),
(7, '127.0.0.1', 'ga6dduep8slm4crmf4a8hloi57', '2026-01-28 11:25:00', '2026-01-28 11:25:00', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0'),
(8, '127.0.0.1', 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29 09:03:24', '2026-01-29 09:21:26', 11, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0'),
(9, '127.0.0.1', 'r5aqkek0qd8mhki1ldm93p08pr', '2026-03-02 07:17:22', '2026-03-02 07:18:46', 4, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0'),
(10, '::1', 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14 10:42:10', '2026-03-14 16:02:01', 29, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36'),
(23, '::1', 'idkf1resvep611610l7u01tl9v', '2026-03-31 06:38:37', '2026-03-31 06:54:25', 5, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36'),
(24, '127.0.0.1', 's4tf866c02r0tk62rsku2898v6', '2026-04-06 03:29:42', '2026-04-06 03:36:33', 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0'),
(25, '::1', 'gndbq25omqgt8alesip48sibpi', '2026-05-19 07:16:19', '2026-05-19 11:07:06', 67, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36'),
(26, '127.0.0.1', '69sc1n07dkbeanuknm10htke8n', '2026-05-20 03:13:19', '2026-05-20 06:35:36', 27, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0'),
(27, '::1', 'l105dtlmdm1avt98avorhahnqb', '2026-05-20 04:45:01', '2026-05-20 04:45:01', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36'),
(28, '::1', 'fsv002e0esc0pcp14407g6mgs0', '2026-05-21 07:20:25', '2026-05-21 07:20:25', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36'),
(29, '127.0.0.1', '0qgocbogaeqlkah9gsj1sun0tp', '2026-06-08 05:19:57', '2026-06-08 05:19:57', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36'),
(34, '::1', 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08 06:10:12', '2026-06-08 06:22:31', 13, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36'),
(35, '::1', 'df3j0s14o91vci4sai9gld39s5', '2026-07-25 07:05:52', '2026-07-27 08:18:06', 6, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36'),
(37, '::1', 'hksg0k581jpm4hmg04mingfpgl', '2026-07-27 07:56:13', '2026-07-27 08:07:20', 33, 'curl/8.15.0'),
(38, '::1', 'hci3thoo938surrdal8b9o7f6g', '2026-07-27 08:17:16', '2026-07-27 08:17:16', 1, 'curl/8.15.0'),
(39, '::1', 'f9psieimke0bbohad8n2nt03bh', '2026-07-27 08:17:16', '2026-07-27 08:17:16', 1, 'curl/8.15.0'),
(40, '::1', 'd25jbpgk2njcu54tun0dhjq2q3', '2026-07-27 08:17:16', '2026-07-27 08:17:16', 1, 'curl/8.15.0'),
(41, '::1', 'ic3kh7p6vogp3nont9ibmvird1', '2026-07-27 08:17:16', '2026-07-27 08:17:16', 1, 'curl/8.15.0'),
(42, '::1', '6fpj1h7vko50atnqfvt372cuh7', '2026-07-27 08:17:16', '2026-07-27 08:17:16', 1, 'curl/8.15.0'),
(43, '::1', 'v3cit74gk23prsul4hvqu43jtk', '2026-07-27 08:17:17', '2026-07-27 08:17:17', 1, 'curl/8.15.0'),
(44, '::1', 'th2unoldhq41nf2b1h2m032mle', '2026-07-27 08:17:30', '2026-07-27 08:17:30', 1, 'curl/8.15.0'),
(45, '::1', 'rc63j3i25qc2rsm9nbr2olpa1a', '2026-07-27 08:17:30', '2026-07-27 08:17:30', 1, 'curl/8.15.0'),
(46, '::1', '7tineb0li7hpndpdifr8goac61', '2026-07-27 08:17:30', '2026-07-27 08:17:30', 1, 'curl/8.15.0'),
(47, '::1', 'ul9mv2gs2ao34ski7vfjc691ol', '2026-07-27 08:17:30', '2026-07-27 08:17:30', 1, 'curl/8.15.0'),
(48, '::1', 'vuha86i043ae26uet2govnnjis', '2026-07-27 08:17:30', '2026-07-27 08:17:30', 1, 'curl/8.15.0'),
(49, '::1', 'aci3df48lgpf40bdgm0c40ml4h', '2026-07-27 08:17:30', '2026-07-27 08:17:30', 1, 'curl/8.15.0'),
(50, '::1', 'ftknb15vuu8o2f7do2fun5c3sn', '2026-07-27 08:17:30', '2026-07-27 08:17:30', 1, 'curl/8.15.0'),
(51, '::1', 'phurh31dch51gfj5ihmf35dfu3', '2026-07-27 08:17:30', '2026-07-27 08:17:30', 1, 'curl/8.15.0'),
(52, '::1', 'gftaspkett7p4974dgngf5e5si', '2026-07-27 08:17:30', '2026-07-27 08:17:30', 1, 'curl/8.15.0'),
(53, '::1', '0nptaqqcvhdqsi69i9aofgaird', '2026-07-27 08:17:31', '2026-07-27 08:17:31', 1, 'curl/8.15.0'),
(54, '::1', 'ne9l9lt3miuej43is3mnc20mcp', '2026-07-27 08:17:31', '2026-07-27 08:17:31', 1, 'curl/8.15.0'),
(55, '::1', '50o40j47s2o9808mtfbiuo5l7i', '2026-07-27 08:17:31', '2026-07-27 08:17:31', 1, 'curl/8.15.0'),
(56, '::1', 'alf055cj1hv0i414g9cfvm4t4c', '2026-07-27 08:17:31', '2026-07-27 08:17:31', 1, 'curl/8.15.0'),
(57, '::1', 'rmkeb3kn3q5topm8e5f2gaut5v', '2026-07-27 08:17:31', '2026-07-27 08:17:31', 1, 'curl/8.15.0'),
(58, '::1', '9aek9s0e237hv06uah89nhbkl1', '2026-07-27 08:17:31', '2026-07-27 08:17:31', 1, 'curl/8.15.0'),
(59, '::1', 'gfjcpovmbvp5fqlv2rbmc3rqqh', '2026-07-27 08:17:31', '2026-07-27 08:17:31', 1, 'curl/8.15.0'),
(60, '::1', 'edmesdq9arcqii272qm55ddb9k', '2026-07-27 08:17:31', '2026-07-27 08:17:31', 1, 'curl/8.15.0'),
(63, '::1', '01slk03unf5k03krgfe0d2b01h', '2026-07-27 09:35:22', '2026-07-27 09:35:22', 1, 'curl/8.15.0'),
(64, '::1', '4s1oc4uhl3d92mc328n6sqeu93', '2026-07-27 09:35:23', '2026-07-27 09:35:23', 1, 'curl/8.15.0'),
(65, '::1', 'qd2bovg547fl4mapj32vaq47up', '2026-07-27 09:35:47', '2026-07-27 09:35:47', 1, 'curl/8.15.0'),
(66, '::1', 'dud8ivihnefdh56jollj4ol4m8', '2026-07-27 09:35:47', '2026-07-27 09:35:47', 1, 'curl/8.15.0'),
(67, '::1', 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18 09:12:11', '2026-08-18 10:42:26', 33, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0'),
(70, '::1', 'vs0td2jc8ekikj334jlmjdfh4s', '2026-08-18 09:29:42', '2026-08-18 09:29:42', 1, 'curl/8.15.0'),
(71, '::1', 'gvb4iqi86moaod09gjevpmmbnr', '2026-08-18 09:45:42', '2026-08-18 09:45:42', 1, 'curl/8.15.0'),
(76, '::1', '8pf0d813s9qu7cgfl6kraliq6o', '2026-08-18 09:52:03', '2026-08-18 09:52:03', 1, 'curl/8.15.0'),
(77, '::1', 'coeb9gqql4rt4muj9u8elehe3d', '2026-08-18 09:52:04', '2026-08-18 09:52:04', 1, 'curl/8.15.0'),
(78, '::1', '7rlds96bkv8qclo2vq25h6onq7', '2026-08-18 09:52:04', '2026-08-18 09:52:04', 1, 'curl/8.15.0'),
(79, '::1', 'qme6fu4pqi087v0466hg29b30h', '2026-08-18 09:52:04', '2026-08-18 09:52:04', 1, 'curl/8.15.0'),
(80, '::1', 'a34qvbpoq4nkkqiup51n8mkbo8', '2026-08-18 09:52:31', '2026-08-18 09:52:31', 1, 'curl/8.15.0'),
(86, '::1', 'ecc3c7fdcs0k8o97ve3v81bm9s', '2026-08-18 10:07:26', '2026-08-18 10:07:26', 1, 'curl/8.15.0'),
(87, '::1', '3eabfgansasfmscroe8r09svev', '2026-08-18 10:07:27', '2026-08-18 10:07:27', 1, 'curl/8.15.0'),
(88, '::1', 'sjhmuslralfpc77vfi82l1dtvk', '2026-08-18 10:07:27', '2026-08-18 10:07:27', 1, 'curl/8.15.0'),
(89, '::1', 'h79nnso9ku5akfug1simmm75c5', '2026-08-18 10:07:39', '2026-08-18 10:07:39', 1, 'curl/8.15.0'),
(90, '::1', '0ip4no1mhhjada1rnrtfbh437h', '2026-08-18 10:08:04', '2026-08-18 10:08:04', 1, 'curl/8.15.0'),
(97, '::1', 'm1o7bdcl11an619fh771487j82', '2026-08-18 10:17:34', '2026-08-18 10:17:34', 1, 'curl/8.15.0'),
(98, '::1', '372g97vspajmjjmtp2l868rj6g', '2026-08-18 10:17:34', '2026-08-18 10:17:34', 1, 'curl/8.15.0'),
(99, '::1', '28icri8ipidc5h9lr2p1qdrtko', '2026-08-18 10:17:34', '2026-08-18 10:17:34', 1, 'curl/8.15.0'),
(100, '::1', 'fbina1ednhd1vth0os9jurm894', '2026-08-18 10:17:52', '2026-08-18 10:17:52', 1, 'curl/8.15.0'),
(102, '::1', 'lpqqjota1si4mhvsm9pogvo0n4', '2026-08-18 10:24:26', '2026-08-18 10:24:26', 1, 'curl/8.15.0'),
(103, '::1', 'ngpvilu3en35fn6pcoie876r13', '2026-08-18 10:26:25', '2026-08-18 10:26:25', 1, 'curl/8.15.0'),
(107, '::1', 'guh1gfn70ehkvqoo163hf0c979', '2026-08-18 10:34:01', '2026-08-18 10:34:01', 1, 'curl/8.15.0'),
(108, '::1', 'sua54pkhpjubhsnk089g4utml7', '2026-08-18 10:34:01', '2026-08-18 10:34:01', 1, 'curl/8.15.0'),
(109, '::1', 'nqq7d3412a14ld7jt2n5i91dsg', '2026-08-18 10:34:01', '2026-08-18 10:34:01', 1, 'curl/8.15.0'),
(110, '::1', 'u14a51i44ncomk9uraeupqqpll', '2026-08-18 10:34:12', '2026-08-18 10:34:12', 1, 'curl/8.15.0'),
(120, '::1', 'psi3rvplrtu3dhl6dom80nrtk0', '2026-08-18 10:41:12', '2026-08-18 10:41:12', 1, 'curl/8.15.0'),
(121, '::1', 'ov64j6pk1o2u8akrsnu36gm5n9', '2026-08-18 10:41:12', '2026-08-18 10:41:12', 1, 'curl/8.15.0'),
(124, '::1', 'hdb0psteuukq8458d3pun2abvh', '2026-08-18 10:50:28', '2026-08-18 10:50:28', 1, 'curl/8.15.0'),
(125, '::1', '3bfd1upjsj5b0oi1ghl3337qa9', '2026-08-18 10:50:28', '2026-08-18 10:50:28', 1, 'curl/8.15.0'),
(126, '::1', 'tcatjrkoi3lvojmaiuuc2sd986', '2026-08-18 10:51:02', '2026-08-18 10:51:02', 1, 'curl/8.15.0'),
(127, '::1', 'c0ju1nfrasghvqp2v0qg0grqag', '2026-08-18 10:51:15', '2026-08-18 10:51:15', 1, 'curl/8.15.0'),
(128, '::1', 'rnttge7rlsg1gijce2ne831ivm', '2026-08-20 11:28:53', '2026-08-20 11:28:59', 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36'),
(130, '::1', 'rfsakn7efgvo9sftq9r2nbo1sn', '2026-08-20 11:44:20', '2026-08-20 11:44:20', 1, 'curl/8.15.0'),
(131, '::1', 'rkrfbpmnedvv3idfhjj8kff1mg', '2026-08-20 11:44:29', '2026-08-20 11:44:29', 1, 'curl/8.15.0'),
(132, '::1', 'v53iav7ot5g8li8j762404ejlq', '2026-08-20 11:44:42', '2026-08-20 11:44:42', 1, 'curl/8.15.0'),
(133, '::1', 'cijdrpnv2lg615mrp3fp7qola9', '2026-08-20 11:45:25', '2026-08-20 11:45:25', 1, 'curl/8.15.0'),
(134, '::1', 'l2h7k22gs2m1mmdamdf5me05ku', '2026-08-20 11:45:31', '2026-08-20 11:45:31', 1, 'curl/8.15.0'),
(135, '::1', 'aa3bpdinsgv6dqu05p317fhl0a', '2026-08-21 10:24:34', '2026-08-21 10:27:33', 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36'),
(137, '::1', 'us39m15vnt1mde3j3d3p51st2f', '2026-08-21 10:45:27', '2026-08-21 10:45:27', 1, 'curl/8.15.0'),
(138, '::1', 'dp9jktkksoj6cc9cinkeaer8ss', '2026-08-21 10:45:40', '2026-08-21 10:45:40', 1, 'curl/8.15.0'),
(139, '::1', 'l70jrro8h2hk71t4u3i74d4gao', '2026-08-21 10:45:40', '2026-08-21 10:45:40', 1, 'curl/8.15.0'),
(140, '::1', 'tfoftnjhq6l1ud1nhjka0lqdb4', '2026-08-21 11:11:10', '2026-08-21 11:11:10', 1, 'curl/8.15.0'),
(141, '::1', 'fccuc519ne7gm7t7cq09ebt2tc', '2026-08-21 11:11:17', '2026-08-21 11:11:17', 1, 'curl/8.15.0'),
(142, '::1', '8bot9pka0222tnj881405b52is', '2026-08-21 11:11:17', '2026-08-21 11:11:17', 1, 'curl/8.15.0'),
(143, '::1', '3k70vfs8p986j02n2sdfrep39p', '2026-08-21 11:24:20', '2026-08-21 11:24:20', 1, 'curl/8.15.0'),
(144, '::1', 'kccvevm92ldri54nkp92t8bnep', '2026-08-21 11:24:20', '2026-08-21 11:24:20', 1, 'curl/8.15.0'),
(145, '::1', '2jptcl78edjdtcm1u5hqou2erm', '2026-08-21 11:24:21', '2026-08-21 11:24:21', 1, 'curl/8.15.0'),
(146, '::1', 'q9ijae71on09irm183oelm5qt5', '2026-08-21 11:29:26', '2026-08-21 11:29:26', 1, 'curl/8.15.0'),
(147, '::1', 'qsjt0tr3g4vrapl8muh1bb4rje', '2026-08-21 11:29:26', '2026-08-21 11:29:26', 1, 'curl/8.15.0'),
(148, '::1', '0vsj4ht8ciru14jadk71hs0le1', '2026-08-21 11:29:27', '2026-08-21 11:29:27', 1, 'curl/8.15.0'),
(149, '::1', 'gu2tabnecjg2ksqo37evrhbi35', '2026-08-21 11:29:38', '2026-08-21 11:29:38', 1, 'curl/8.15.0'),
(150, '::1', 'bn8vsf27o48i19eb1vmufd20vc', '2026-08-21 11:29:38', '2026-08-21 11:29:38', 1, 'curl/8.15.0'),
(151, '::1', 'mjb5q61kjuhlsuqufle94ncp5h', '2026-08-21 11:29:39', '2026-08-21 11:29:39', 1, 'curl/8.15.0'),
(152, '::1', 'a1fdteb3aru95843gra0hg118u', '2026-08-21 11:29:45', '2026-08-21 11:29:45', 1, 'curl/8.15.0'),
(153, '::1', 'bgb39n3nviqk4m0ga0c5egpjl6', '2026-08-21 11:29:46', '2026-08-21 11:29:46', 1, 'curl/8.15.0'),
(154, '::1', 'a84dd3nhf1g6ikjt8dbju8gm58', '2026-08-21 11:29:48', '2026-08-21 11:29:48', 1, 'curl/8.15.0'),
(155, '::1', '03nbnf85sis9vmescqqmr6cum4', '2026-08-24 09:19:00', '2026-08-24 09:19:00', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36');

-- --------------------------------------------------------

--
-- Table structure for table `website_analytics`
--

CREATE TABLE `website_analytics` (
  `id` int(11) NOT NULL,
  `visitor_ip` varchar(45) NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `device_type` enum('Mobile','Tablet','Desktop','Unknown') DEFAULT 'Unknown',
  `browser` varchar(100) DEFAULT NULL,
  `operating_system` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `session_id` varchar(100) NOT NULL,
  `visit_date` date NOT NULL,
  `visit_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_analytics`
--

INSERT INTO `website_analytics` (`id`, `visitor_ip`, `page_url`, `page_title`, `referrer`, `user_agent`, `device_type`, `browser`, `operating_system`, `country`, `city`, `session_id`, `visit_date`, `visit_time`, `created_at`) VALUES
(1, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '10:51:30', '2025-12-27 09:51:30'),
(2, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '10:53:16', '2025-12-27 09:53:16'),
(3, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '10:57:59', '2025-12-27 09:57:59'),
(4, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '10:59:52', '2025-12-27 09:59:52'),
(5, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:04:42', '2025-12-27 10:04:42'),
(6, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:04:56', '2025-12-27 10:04:56'),
(7, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:05:52', '2025-12-27 10:05:52'),
(8, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:06:28', '2025-12-27 10:06:28'),
(9, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:10:04', '2025-12-27 10:10:04'),
(10, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:11:02', '2025-12-27 10:11:02'),
(11, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:16:21', '2025-12-27 10:16:21'),
(12, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:19:18', '2025-12-27 10:19:18'),
(13, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:19:37', '2025-12-27 10:19:37'),
(14, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:27:11', '2025-12-27 10:27:11'),
(15, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:27:13', '2025-12-27 10:27:13'),
(16, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/courses.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:27:35', '2025-12-27 10:27:35'),
(17, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/admission.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:27:49', '2025-12-27 10:27:49'),
(18, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/faculty.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:28:07', '2025-12-27 10:28:07'),
(19, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:28:16', '2025-12-27 10:28:16'),
(20, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:30:24', '2025-12-27 10:30:24'),
(21, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:31:46', '2025-12-27 10:31:46'),
(22, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:32:38', '2025-12-27 10:32:38'),
(23, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:34:08', '2025-12-27 10:34:08'),
(24, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:35:42', '2025-12-27 10:35:42'),
(25, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:41:15', '2025-12-27 10:41:15'),
(26, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:43:35', '2025-12-27 10:43:35'),
(27, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:43:37', '2025-12-27 10:43:37'),
(28, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:43:39', '2025-12-27 10:43:39'),
(29, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'd5jspmud1b47s4ncofloekjgpr', '2025-12-27', '11:43:42', '2025-12-27 10:43:42'),
(30, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'kkbk6ki04deocaqg1c56a1h1hs', '2026-01-05', '08:54:44', '2026-01-05 07:54:44'),
(31, '::1', '/shaheen/shaheen/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'kkbk6ki04deocaqg1c56a1h1hs', '2026-01-05', '09:51:55', '2026-01-05 08:51:55'),
(32, '::1', '/shaheen/shaheen/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'kkbk6ki04deocaqg1c56a1h1hs', '2026-01-05', '10:09:43', '2026-01-05 09:09:43'),
(33, '::1', '/shaheen/shaheen/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'kkbk6ki04deocaqg1c56a1h1hs', '2026-01-05', '10:10:20', '2026-01-05 09:10:20'),
(34, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '1tkhaulgu9mobi38vhu99gj6cd', '2026-01-13', '10:31:44', '2026-01-13 09:31:44'),
(35, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '1tkhaulgu9mobi38vhu99gj6cd', '2026-01-13', '10:45:27', '2026-01-13 09:45:27'),
(36, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '1tkhaulgu9mobi38vhu99gj6cd', '2026-01-13', '10:45:34', '2026-01-13 09:45:34'),
(37, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '1tkhaulgu9mobi38vhu99gj6cd', '2026-01-13', '10:53:27', '2026-01-13 09:53:27'),
(38, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '1tkhaulgu9mobi38vhu99gj6cd', '2026-01-13', '10:57:01', '2026-01-13 09:57:01'),
(39, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '1tkhaulgu9mobi38vhu99gj6cd', '2026-01-13', '10:58:41', '2026-01-13 09:58:41'),
(40, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '1tkhaulgu9mobi38vhu99gj6cd', '2026-01-13', '10:59:19', '2026-01-13 09:59:19'),
(41, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '1tkhaulgu9mobi38vhu99gj6cd', '2026-01-13', '10:59:52', '2026-01-13 09:59:52'),
(42, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '06:39:31', '2026-01-14 05:39:31'),
(43, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '06:39:41', '2026-01-14 05:39:41'),
(44, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '06:43:21', '2026-01-14 05:43:21'),
(45, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '06:55:39', '2026-01-14 05:55:39'),
(46, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:15:29', '2026-01-14 06:15:29'),
(47, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:20:02', '2026-01-14 06:20:02'),
(48, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:28:51', '2026-01-14 06:28:51'),
(49, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:30:09', '2026-01-14 06:30:09'),
(50, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:33:00', '2026-01-14 06:33:00'),
(51, '::1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:33:58', '2026-01-14 06:33:58'),
(52, '::1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:36:06', '2026-01-14 06:36:06'),
(53, '::1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:38:34', '2026-01-14 06:38:34'),
(54, '::1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:38:37', '2026-01-14 06:38:37'),
(55, '::1', '/SHAHEENPUBLICHIGHSCHOOL/courses.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:39:20', '2026-01-14 06:39:20'),
(56, '::1', '/SHAHEENPUBLICHIGHSCHOOL/courses.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:39:35', '2026-01-14 06:39:35'),
(57, '::1', '/SHAHEENPUBLICHIGHSCHOOL/admission.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:39:39', '2026-01-14 06:39:39'),
(58, '::1', '/SHAHEENPUBLICHIGHSCHOOL/faculty.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:39:58', '2026-01-14 06:39:58'),
(59, '::1', '/SHAHEENPUBLICHIGHSCHOOL/gallery.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:40:08', '2026-01-14 06:40:08'),
(60, '::1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/gallery.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:40:12', '2026-01-14 06:40:12'),
(61, '::1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/gallery.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:56:53', '2026-01-14 06:56:53'),
(62, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:57:12', '2026-01-14 06:57:12'),
(63, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/AdminCP/dashboard.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:57:46', '2026-01-14 06:57:46'),
(64, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:58:23', '2026-01-14 06:58:23'),
(65, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:58:54', '2026-01-14 06:58:54'),
(66, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:59:46', '2026-01-14 06:59:46'),
(67, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '07:59:59', '2026-01-14 06:59:59'),
(68, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '08:00:29', '2026-01-14 07:00:29'),
(69, '::1', '/SHAHEENPUBLICHIGHSCHOOL/admission.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '08:01:47', '2026-01-14 07:01:47'),
(70, '::1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '08:02:24', '2026-01-14 07:02:24'),
(71, '::1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '08:20:42', '2026-01-14 07:20:42'),
(72, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'h8unkai0empu9dca4f89dpnetj', '2026-01-14', '08:20:50', '2026-01-14 07:20:50'),
(73, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '05gcre9067e2v7pejjete1vgda', '2026-01-14', '11:04:17', '2026-01-14 10:04:17'),
(74, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '05gcre9067e2v7pejjete1vgda', '2026-01-14', '11:04:22', '2026-01-14 10:04:22'),
(75, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '05gcre9067e2v7pejjete1vgda', '2026-01-14', '11:05:47', '2026-01-14 10:05:47'),
(76, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '09:52:04', '2026-01-27 08:52:04'),
(77, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '10:00:23', '2026-01-27 09:00:23'),
(78, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '10:04:38', '2026-01-27 09:04:38'),
(79, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '10:04:40', '2026-01-27 09:04:40'),
(80, '::1', '/ghzaliSwari/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '10:07:15', '2026-01-27 09:07:15'),
(81, '::1', '/ghzaliSwari/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '10:07:30', '2026-01-27 09:07:30'),
(82, '::1', '/ghzaliSwari/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '10:07:37', '2026-01-27 09:07:37'),
(83, '::1', '/ghzaliSwari/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:29:13', '2026-01-27 10:29:13'),
(84, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:29:18', '2026-01-27 10:29:18'),
(85, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:29:32', '2026-01-27 10:29:32'),
(86, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=2&registration_no=258', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:29:51', '2026-01-27 10:29:51'),
(87, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=&registration_no=258', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:30:07', '2026-01-27 10:30:07'),
(88, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=&registration_no=258', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:33:24', '2026-01-27 10:33:24'),
(89, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=&registration_no=258', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:35:47', '2026-01-27 10:35:47'),
(90, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=&registration_no=258', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:37:18', '2026-01-27 10:37:18'),
(91, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=&registration_no=258', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:37:28', '2026-01-27 10:37:28'),
(92, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=&registration_no=259', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:38:11', '2026-01-27 10:38:11'),
(93, '::1', '/ghzaliSwari/index.php', '', 'http://localhost/ghzaliSwari/result.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:38:29', '2026-01-27 10:38:29'),
(94, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:38:50', '2026-01-27 10:38:50'),
(95, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:43:53', '2026-01-27 10:43:53'),
(96, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=&registration_no=258', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:44:03', '2026-01-27 10:44:03'),
(97, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=3&registration_no=258', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:45:38', '2026-01-27 10:45:38'),
(98, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=2&registration_no=258', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:46:04', '2026-01-27 10:46:04'),
(99, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=&registration_no=258', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:46:14', '2026-01-27 10:46:14'),
(100, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:46:41', '2026-01-27 10:46:41'),
(101, '::1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php?exam_id=2&registration_no=258', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'ffppbhsphl6k15okg0hvl2dsft', '2026-01-27', '11:47:01', '2026-01-27 10:47:01'),
(102, '127.0.0.1', '/ghzaliSwari/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'ga6dduep8slm4crmf4a8hloi57', '2026-01-28', '12:25:00', '2026-01-28 11:25:00'),
(103, '127.0.0.1', '/ghzaliSwari/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29', '10:03:24', '2026-01-29 09:03:24'),
(104, '127.0.0.1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29', '10:03:28', '2026-01-29 09:03:28'),
(105, '127.0.0.1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29', '10:10:36', '2026-01-29 09:10:36'),
(106, '127.0.0.1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29', '10:13:39', '2026-01-29 09:13:39'),
(107, '127.0.0.1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29', '10:15:00', '2026-01-29 09:15:00'),
(108, '127.0.0.1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29', '10:16:39', '2026-01-29 09:16:39'),
(109, '127.0.0.1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29', '10:20:44', '2026-01-29 09:20:44'),
(110, '127.0.0.1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29', '10:20:52', '2026-01-29 09:20:52'),
(111, '127.0.0.1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29', '10:21:07', '2026-01-29 09:21:07'),
(112, '127.0.0.1', '/ghzaliSwari/result.php', '', 'http://localhost/ghzaliSwari/result.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29', '10:21:18', '2026-01-29 09:21:18'),
(113, '127.0.0.1', '/ghzaliSwari/result.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'n1b8e0mqhvi4muf7p90v7920vq', '2026-01-29', '10:21:26', '2026-01-29 09:21:26'),
(114, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'r5aqkek0qd8mhki1ldm93p08pr', '2026-03-02', '08:17:22', '2026-03-02 07:17:22'),
(115, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/examination.php', '', 'https://localhost/SHAHEENPUBLICHIGHSCHOOL/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'r5aqkek0qd8mhki1ldm93p08pr', '2026-03-02', '08:17:33', '2026-03-02 07:17:33'),
(116, '127.0.0.1', '/ghzaliSwari/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'r5aqkek0qd8mhki1ldm93p08pr', '2026-03-02', '08:18:41', '2026-03-02 07:18:41'),
(117, '127.0.0.1', '/ghzaliSwari/result.php', '', 'https://localhost/ghzaliSwari/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'r5aqkek0qd8mhki1ldm93p08pr', '2026-03-02', '08:18:46', '2026-03-02 07:18:46'),
(118, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '11:42:10', '2026-03-14 10:42:10'),
(119, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '11:42:31', '2026-03-14 10:42:31'),
(120, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '11:50:25', '2026-03-14 10:50:25'),
(121, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '11:50:50', '2026-03-14 10:50:50'),
(122, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '12:07:09', '2026-03-14 11:07:09'),
(123, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '12:08:50', '2026-03-14 11:08:50'),
(124, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '12:17:16', '2026-03-14 11:17:16'),
(125, '::1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '12:17:22', '2026-03-14 11:17:22'),
(126, '::1', '/SHAHEENPUBLICHIGHSCHOOL/admission.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '12:17:58', '2026-03-14 11:17:58'),
(127, '::1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '12:18:42', '2026-03-14 11:18:42'),
(128, '::1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '12:23:17', '2026-03-14 11:23:17'),
(129, '::1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '12:25:22', '2026-03-14 11:25:22'),
(130, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '12:25:41', '2026-03-14 11:25:41'),
(131, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '16:53:46', '2026-03-14 15:53:46'),
(132, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '16:57:09', '2026-03-14 15:57:09'),
(133, '::1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '16:58:29', '2026-03-14 15:58:29'),
(134, '::1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:00:44', '2026-03-14 16:00:45'),
(135, '::1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:00:47', '2026-03-14 16:00:47'),
(136, '::1', '/SHAHEENPUBLICHIGHSCHOOL/about.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:00:49', '2026-03-14 16:00:49'),
(137, '::1', '/SHAHEENPUBLICHIGHSCHOOL/courses.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:00:58', '2026-03-14 16:00:58'),
(138, '::1', '/SHAHEENPUBLICHIGHSCHOOL/admission.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:01:10', '2026-03-14 16:01:10'),
(139, '::1', '/SHAHEENPUBLICHIGHSCHOOL/faculty.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:01:19', '2026-03-14 16:01:19'),
(140, '::1', '/SHAHEENPUBLICHIGHSCHOOL/downloads.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:01:30', '2026-03-14 16:01:30'),
(141, '::1', '/SHAHEENPUBLICHIGHSCHOOL/alumni.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/downloads.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:01:36', '2026-03-14 16:01:36'),
(142, '::1', '/SHAHEENPUBLICHIGHSCHOOL/examination.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/alumni.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:01:43', '2026-03-14 16:01:43'),
(143, '::1', '/SHAHEENPUBLICHIGHSCHOOL/events.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/examination.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:01:49', '2026-03-14 16:01:49'),
(144, '::1', '/SHAHEENPUBLICHIGHSCHOOL/gallery.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/events.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:01:54', '2026-03-14 16:01:54'),
(145, '::1', '/SHAHEENPUBLICHIGHSCHOOL/contact.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/gallery.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:01:58', '2026-03-14 16:01:58'),
(146, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-14', '17:02:01', '2026-03-14 16:02:01'),
(147, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-15', '11:01:22', '2026-03-15 10:01:22'),
(148, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-15', '11:01:45', '2026-03-15 10:01:45'),
(149, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-15', '11:03:05', '2026-03-15 10:03:05'),
(150, '::1', '/SHAHEENPUBLICHIGHSCHOOL/courses.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-16', '04:06:23', '2026-03-16 03:06:23'),
(151, '::1', '/SHAHEENPUBLICHIGHSCHOOL/courses.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-16', '04:12:53', '2026-03-16 03:12:53'),
(152, '::1', '/SHAHEENPUBLICHIGHSCHOOL/gallery.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-16', '04:13:34', '2026-03-16 03:13:34');
INSERT INTO `website_analytics` (`id`, `visitor_ip`, `page_url`, `page_title`, `referrer`, `user_agent`, `device_type`, `browser`, `operating_system`, `country`, `city`, `session_id`, `visit_date`, `visit_time`, `created_at`) VALUES
(153, '::1', '/SHAHEENPUBLICHIGHSCHOOL/gallery.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-16', '04:20:28', '2026-03-16 03:20:28'),
(154, '::1', '/SHAHEENPUBLICHIGHSCHOOL/gallery.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-16', '04:21:14', '2026-03-16 03:21:14'),
(155, '::1', '/SHAHEENPUBLICHIGHSCHOOL/gallery.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-16', '04:23:42', '2026-03-16 03:23:42'),
(156, '::1', '/SHAHEENPUBLICHIGHSCHOOL/courses.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/gallery.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-16', '04:24:14', '2026-03-16 03:24:14'),
(157, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-16', '04:24:22', '2026-03-16 03:24:22'),
(158, '::1', '/SHAHEENPUBLICHIGHSCHOOL/courses.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'bqm074mnfg4qtcfor8sshokrl4', '2026-03-16', '04:25:26', '2026-03-16 03:25:26'),
(159, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'idkf1resvep611610l7u01tl9v', '2026-03-31', '08:38:37', '2026-03-31 06:38:37'),
(160, '::1', '/SHAHEENPUBLICHIGHSCHOOL/downloads.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'idkf1resvep611610l7u01tl9v', '2026-03-31', '08:38:41', '2026-03-31 06:38:41'),
(161, '::1', '/SHAHEENPUBLICHIGHSCHOOL/downloads.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'idkf1resvep611610l7u01tl9v', '2026-03-31', '08:51:49', '2026-03-31 06:51:49'),
(162, '::1', '/SHAHEENPUBLICHIGHSCHOOL/admission.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/downloads.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'idkf1resvep611610l7u01tl9v', '2026-03-31', '08:53:30', '2026-03-31 06:53:30'),
(163, '::1', '/SHAHEENPUBLICHIGHSCHOOL/admission.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'idkf1resvep611610l7u01tl9v', '2026-03-31', '08:54:25', '2026-03-31 06:54:25'),
(164, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 's4tf866c02r0tk62rsku2898v6', '2026-04-06', '05:29:39', '2026-04-06 03:29:39'),
(165, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/admission.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 's4tf866c02r0tk62rsku2898v6', '2026-04-06', '05:29:46', '2026-04-06 03:29:46'),
(166, '127.0.0.1', '/SHAHEENPUBLICHIGHSCHOOL/admission.php', '', 'http://localhost/SHAHEENPUBLICHIGHSCHOOL/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 's4tf866c02r0tk62rsku2898v6', '2026-04-06', '05:36:33', '2026-04-06 03:36:33'),
(167, '::1', '/ghzaliSwari/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '09:16:19', '2026-05-19 07:16:19'),
(168, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '09:16:44', '2026-05-19 07:16:44'),
(169, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '09:18:34', '2026-05-19 07:18:34'),
(170, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:01:48', '2026-05-19 09:01:48'),
(171, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:08:16', '2026-05-19 09:08:16'),
(172, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:10:07', '2026-05-19 09:10:07'),
(173, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:17:33', '2026-05-19 09:17:33'),
(174, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:22:25', '2026-05-19 09:22:25'),
(175, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:25:37', '2026-05-19 09:25:37'),
(176, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:25:48', '2026-05-19 09:25:48'),
(177, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:26:06', '2026-05-19 09:26:06'),
(178, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:26:30', '2026-05-19 09:26:30'),
(179, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:30:17', '2026-05-19 09:30:17'),
(180, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:35:45', '2026-05-19 09:35:45'),
(181, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:40:31', '2026-05-19 09:40:31'),
(182, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:47:02', '2026-05-19 09:47:02'),
(183, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '11:52:43', '2026-05-19 09:52:43'),
(184, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:01:02', '2026-05-19 10:01:02'),
(185, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:01:13', '2026-05-19 10:01:13'),
(186, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:09:09', '2026-05-19 10:09:09'),
(187, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:09:16', '2026-05-19 10:09:16'),
(188, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:19:26', '2026-05-19 10:19:26'),
(189, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:22:39', '2026-05-19 10:22:39'),
(190, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:25:58', '2026-05-19 10:25:58'),
(191, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:28:31', '2026-05-19 10:28:31'),
(192, '::1', '/AimsGroupOfColleges/about.php', '', 'http://localhost/AimsGroupOfColleges/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:28:56', '2026-05-19 10:28:56'),
(193, '::1', '/AimsGroupOfColleges/courses.php', '', 'http://localhost/AimsGroupOfColleges/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:31:27', '2026-05-19 10:31:27'),
(194, '::1', '/AimsGroupOfColleges/admission.php', '', 'http://localhost/AimsGroupOfColleges/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:31:42', '2026-05-19 10:31:42'),
(195, '::1', '/AimsGroupOfColleges/faculty.php', '', 'http://localhost/AimsGroupOfColleges/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:31:52', '2026-05-19 10:31:52'),
(196, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:32:01', '2026-05-19 10:32:01'),
(197, '::1', '/AimsGroupOfColleges/contact.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:32:19', '2026-05-19 10:32:19'),
(198, '::1', '/AimsGroupOfColleges/about.php', '', 'http://localhost/AimsGroupOfColleges/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:32:56', '2026-05-19 10:32:56'),
(199, '::1', '/AimsGroupOfColleges/courses.php', '', 'http://localhost/AimsGroupOfColleges/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:33:13', '2026-05-19 10:33:13'),
(200, '::1', '/AimsGroupOfColleges/admission.php', '', 'http://localhost/AimsGroupOfColleges/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:34:02', '2026-05-19 10:34:02'),
(201, '::1', '/AimsGroupOfColleges/faculty.php', '', 'http://localhost/AimsGroupOfColleges/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:34:17', '2026-05-19 10:34:17'),
(202, '::1', '/AimsGroupOfColleges/courses.php', '', 'http://localhost/AimsGroupOfColleges/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:34:27', '2026-05-19 10:34:27'),
(203, '::1', '/AimsGroupOfColleges/about.php', '', 'http://localhost/AimsGroupOfColleges/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:38:50', '2026-05-19 10:38:50'),
(204, '::1', '/AimsGroupOfColleges/courses.php', '', 'http://localhost/AimsGroupOfColleges/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:38:58', '2026-05-19 10:38:58'),
(205, '::1', '/AimsGroupOfColleges/admission.php', '', 'http://localhost/AimsGroupOfColleges/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:39:12', '2026-05-19 10:39:12'),
(206, '::1', '/AimsGroupOfColleges/faculty.php', '', 'http://localhost/AimsGroupOfColleges/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:40:00', '2026-05-19 10:40:00'),
(207, '::1', '/AimsGroupOfColleges/admission.php', '', 'http://localhost/AimsGroupOfColleges/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:40:20', '2026-05-19 10:40:20'),
(208, '::1', '/AimsGroupOfColleges/admission.php', '', 'http://localhost/AimsGroupOfColleges/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:42:53', '2026-05-19 10:42:53'),
(209, '::1', '/AimsGroupOfColleges/faculty.php', '', 'http://localhost/AimsGroupOfColleges/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:43:24', '2026-05-19 10:43:24'),
(210, '::1', '/AimsGroupOfColleges/admission.php', '', 'http://localhost/AimsGroupOfColleges/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:46:29', '2026-05-19 10:46:29'),
(211, '::1', '/AimsGroupOfColleges/faculty.php', '', 'http://localhost/AimsGroupOfColleges/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:46:34', '2026-05-19 10:46:34'),
(212, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:46:56', '2026-05-19 10:46:56'),
(213, '::1', '/AimsGroupOfColleges/contact.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:47:02', '2026-05-19 10:47:02'),
(214, '::1', '/AimsGroupOfColleges/faculty.php', '', 'http://localhost/AimsGroupOfColleges/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:49:22', '2026-05-19 10:49:22'),
(215, '::1', '/AimsGroupOfColleges/downloads.php', '', 'http://localhost/AimsGroupOfColleges/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:49:26', '2026-05-19 10:49:26'),
(216, '::1', '/AimsGroupOfColleges/alumni.php', '', 'http://localhost/AimsGroupOfColleges/downloads.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:49:30', '2026-05-19 10:49:30'),
(217, '::1', '/AimsGroupOfColleges/examination.php', '', 'http://localhost/AimsGroupOfColleges/alumni.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:49:39', '2026-05-19 10:49:39'),
(218, '::1', '/AimsGroupOfColleges/events.php', '', 'http://localhost/AimsGroupOfColleges/examination.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:49:43', '2026-05-19 10:49:43'),
(219, '::1', '/AimsGroupOfColleges/about.php', '', 'http://localhost/AimsGroupOfColleges/events.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:49:48', '2026-05-19 10:49:48'),
(220, '::1', '/AimsGroupOfColleges/contact.php', '', 'http://localhost/AimsGroupOfColleges/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:54:35', '2026-05-19 10:54:35'),
(221, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:54:54', '2026-05-19 10:54:54'),
(222, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:56:58', '2026-05-19 10:56:58'),
(223, '::1', '/AimsGroupOfColleges/about.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:57:32', '2026-05-19 10:57:32'),
(224, '::1', '/AimsGroupOfColleges/courses.php', '', 'http://localhost/AimsGroupOfColleges/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:57:54', '2026-05-19 10:57:54'),
(225, '::1', '/AimsGroupOfColleges/admission.php', '', 'http://localhost/AimsGroupOfColleges/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:58:01', '2026-05-19 10:58:01'),
(226, '::1', '/AimsGroupOfColleges/faculty.php', '', 'http://localhost/AimsGroupOfColleges/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:58:08', '2026-05-19 10:58:08'),
(227, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:58:17', '2026-05-19 10:58:17'),
(228, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '12:58:54', '2026-05-19 10:58:54'),
(229, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '13:05:36', '2026-05-19 11:05:36'),
(230, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '13:06:54', '2026-05-19 11:06:54'),
(231, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '13:07:01', '2026-05-19 11:07:01'),
(232, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '13:07:02', '2026-05-19 11:07:02'),
(233, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'gndbq25omqgt8alesip48sibpi', '2026-05-19', '13:07:04', '2026-05-19 11:07:04'),
(234, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '05:13:19', '2026-05-20 03:13:19'),
(235, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '06:35:16', '2026-05-20 04:35:16'),
(236, '127.0.0.1', '/AimsGroupOfColleges/campuses.php', '', 'http://localhost/AimsGroupOfColleges/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '06:35:41', '2026-05-20 04:35:41'),
(237, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campuses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '06:35:48', '2026-05-20 04:35:48'),
(238, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campuses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '06:41:33', '2026-05-20 04:41:33'),
(239, '127.0.0.1', '/AimsGroupOfColleges/campuses.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '06:41:39', '2026-05-20 04:41:39'),
(240, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campuses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '06:41:44', '2026-05-20 04:41:44'),
(241, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'l105dtlmdm1avt98avorhahnqb', '2026-05-20', '06:45:01', '2026-05-20 04:45:01'),
(242, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campuses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:22:32', '2026-05-20 05:22:32'),
(243, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campuses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:32:24', '2026-05-20 05:32:24'),
(244, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, 'k4ot68ir5rsd10kqb02k6jmvbb', '2026-05-20', '07:39:12', '2026-05-20 05:39:12'),
(245, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campuses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:39:25', '2026-05-20 05:39:25'),
(246, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campuses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:41:02', '2026-05-20 05:41:02'),
(247, '127.0.0.1', '/AimsGroupOfColleges/campus-portal.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:41:21', '2026-05-20 05:41:21'),
(248, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:44:48', '2026-05-20 05:44:48'),
(249, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:49:53', '2026-05-20 05:49:53'),
(250, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:52:06', '2026-05-20 05:52:06'),
(251, '127.0.0.1', '/AimsGroupOfColleges/campuses.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:54:43', '2026-05-20 05:54:43'),
(252, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campuses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:54:49', '2026-05-20 05:54:49'),
(253, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campuses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:54:59', '2026-05-20 05:54:59'),
(254, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campuses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:56:36', '2026-05-20 05:56:36'),
(255, '127.0.0.1', '/AimsGroupOfColleges/campus-portal.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:57:21', '2026-05-20 05:57:21'),
(256, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:58:55', '2026-05-20 05:58:55'),
(257, '127.0.0.1', '/AimsGroupOfColleges/campus-portal.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '9ojthgg0mevrc3p7ceu7n6eopu', '2026-05-20', '07:59:06', '2026-05-20 05:59:06'),
(258, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '69sc1n07dkbeanuknm10htke8n', '2026-05-20', '08:25:42', '2026-05-20 06:25:42'),
(259, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '69sc1n07dkbeanuknm10htke8n', '2026-05-20', '08:35:09', '2026-05-20 06:35:09'),
(260, '127.0.0.1', '/AimsGroupOfColleges/campus-portal.php', '', 'http://localhost/AimsGroupOfColleges/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '69sc1n07dkbeanuknm10htke8n', '2026-05-20', '08:35:16', '2026-05-20 06:35:16'),
(261, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'Desktop', 'Firefox', 'Windows 10', NULL, NULL, '69sc1n07dkbeanuknm10htke8n', '2026-05-20', '08:35:35', '2026-05-20 06:35:35'),
(262, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'fsv002e0esc0pcp14407g6mgs0', '2026-05-21', '09:20:25', '2026-05-21 07:20:25'),
(263, '127.0.0.1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, '0qgocbogaeqlkah9gsj1sun0tp', '2026-06-08', '07:19:57', '2026-06-08 05:19:57'),
(264, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, '0qgocbogaeqlkah9gsj1sun0tp', '2026-06-08', '07:21:28', '2026-06-08 05:21:28'),
(265, '::1', '/AimsGroupOfColleges/campus-portal.php', '', 'http://localhost/AimsGroupOfColleges/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, '0qgocbogaeqlkah9gsj1sun0tp', '2026-06-08', '07:23:20', '2026-06-08 05:23:20'),
(266, '::1', '/AimsGroupOfColleges/campus-portal.php', '', 'http://localhost/AimsGroupOfColleges/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, '0qgocbogaeqlkah9gsj1sun0tp', '2026-06-08', '07:34:36', '2026-06-08 05:34:36'),
(267, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, '0qgocbogaeqlkah9gsj1sun0tp', '2026-06-08', '07:35:45', '2026-06-08 05:35:45'),
(268, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:10:12', '2026-06-08 06:10:12'),
(269, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:10:26', '2026-06-08 06:10:26'),
(270, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:11:29', '2026-06-08 06:11:29'),
(271, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:11:31', '2026-06-08 06:11:31'),
(272, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:12:01', '2026-06-08 06:12:01'),
(273, '::1', '/AimsGroupOfColleges/campus-portal.php', '', 'http://localhost/AimsGroupOfColleges/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:12:10', '2026-06-08 06:12:10'),
(274, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:12:12', '2026-06-08 06:12:12'),
(275, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:20:19', '2026-06-08 06:20:19'),
(276, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:20:24', '2026-06-08 06:20:24'),
(277, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:20:35', '2026-06-08 06:20:35'),
(278, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:20:38', '2026-06-08 06:20:38'),
(279, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:22:19', '2026-06-08 06:22:19'),
(280, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'mb3ua4k1aiblfh1hf090ephqp5', '2026-06-08', '08:22:30', '2026-06-08 06:22:30'),
(281, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-25', '09:05:52', '2026-07-25 07:05:52'),
(282, '::1', '/ghzaliSwari/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-25', '09:06:34', '2026-07-25 07:06:34'),
(283, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-25', '09:06:56', '2026-07-25 07:06:56'),
(284, '::1', '/SHAHEENPUBLICHIGHSCHOOL/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-25', '09:07:00', '2026-07-25 07:07:00'),
(285, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '07:30:13', '2026-07-27 05:30:13'),
(286, '::1', '/AimsGroupOfColleges/about.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'rk47o3t9hjauf3qc63ufd4950n', '2026-07-27', '09:56:11', '2026-07-27 07:56:11'),
(287, '::1', '/AimsGroupOfColleges/mission-vision.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'prc446hn4vgjra4o2nbcgvtvml', '2026-07-27', '09:57:58', '2026-07-27 07:57:58'),
(288, '::1', '/AimsGroupOfColleges/core-values.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'fh6fbe16i3bpi5mi4kcf9tfblj', '2026-07-27', '09:59:11', '2026-07-27 07:59:11'),
(289, '::1', '/AimsGroupOfColleges/leadership.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '8o31gbe9o8de36hglj2vt98kgg', '2026-07-27', '09:59:11', '2026-07-27 07:59:11'),
(290, '::1', '/AimsGroupOfColleges/leadership.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '36gti1jgnlvtpdgq9b7l2vk79v', '2026-07-27', '09:59:21', '2026-07-27 07:59:21'),
(291, '::1', '/AimsGroupOfColleges/leadership.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'pnll83hb9loph8pp91addmjt1l', '2026-07-27', '09:59:21', '2026-07-27 07:59:21'),
(292, '::1', '/AimsGroupOfColleges/news.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'm6fq3sbcq7vskmltbui57209el', '2026-07-27', '10:00:07', '2026-07-27 08:00:07'),
(293, '::1', '/AimsGroupOfColleges/notifications.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'jl38pb4kh4j4dl850601or2o2o', '2026-07-27', '10:00:41', '2026-07-27 08:00:41'),
(294, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'hmia6j81rp5u7nc0en9e8eg21u', '2026-07-27', '10:05:20', '2026-07-27 08:05:20'),
(295, '::1', '/AimsGroupOfColleges/about.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '2bflcihj6bnrm3sommuntkuo85', '2026-07-27', '10:05:20', '2026-07-27 08:05:20'),
(296, '::1', '/AimsGroupOfColleges/mission-vision.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '64167go5n4ok8pp6pfjagkqcgd', '2026-07-27', '10:05:20', '2026-07-27 08:05:20'),
(297, '::1', '/AimsGroupOfColleges/core-values.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'hjedb5h22p2ebcbqrtc8gkkols', '2026-07-27', '10:05:20', '2026-07-27 08:05:20'),
(298, '::1', '/AimsGroupOfColleges/leadership.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'pbcf725a1t2h28vgp5a14s65qv', '2026-07-27', '10:05:21', '2026-07-27 08:05:21'),
(299, '::1', '/AimsGroupOfColleges/courses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'ig25097rnmq06eo48302pgue4b', '2026-07-27', '10:05:21', '2026-07-27 08:05:21'),
(300, '::1', '/AimsGroupOfColleges/faculty.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'ftusouedofjsg12vult2ii6c2c', '2026-07-27', '10:05:21', '2026-07-27 08:05:21'),
(301, '::1', '/AimsGroupOfColleges/examination.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'hekqcuhtubkbt1r59kjfkevvfq', '2026-07-27', '10:05:21', '2026-07-27 08:05:21'),
(302, '::1', '/AimsGroupOfColleges/admission.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '7chjfcukis4j2p4k59fkkfv5fe', '2026-07-27', '10:05:21', '2026-07-27 08:05:21'),
(303, '::1', '/AimsGroupOfColleges/downloads.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'f71dpadiouom3d22li8ibqrufb', '2026-07-27', '10:05:21', '2026-07-27 08:05:21'),
(304, '::1', '/AimsGroupOfColleges/notifications.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'impci5lfabrdjuhds9j31e1hjj', '2026-07-27', '10:05:22', '2026-07-27 08:05:22'),
(305, '::1', '/AimsGroupOfColleges/campuses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'shil3d8jvs5lj591tks58t5cvb', '2026-07-27', '10:05:22', '2026-07-27 08:05:22'),
(306, '::1', '/AimsGroupOfColleges/campus-portal.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'ic9utsgjl4ri3s969dvq34ou82', '2026-07-27', '10:05:22', '2026-07-27 08:05:22'),
(307, '::1', '/AimsGroupOfColleges/events.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'vo6o0ecdood3sjse1s0a3610c3', '2026-07-27', '10:05:22', '2026-07-27 08:05:22'),
(308, '::1', '/AimsGroupOfColleges/news.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '7ld4scmcilev1nnp7besrjk0ef', '2026-07-27', '10:05:22', '2026-07-27 08:05:22'),
(309, '::1', '/AimsGroupOfColleges/alumni.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'fdqp42fn73crjftuk5c2to8vnc', '2026-07-27', '10:05:22', '2026-07-27 08:05:22'),
(310, '::1', '/AimsGroupOfColleges/gallery.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'j11rm7ev9vjlrh0u5p6buegjbl', '2026-07-27', '10:05:22', '2026-07-27 08:05:22'),
(311, '::1', '/AimsGroupOfColleges/contact.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '6pm2urkb6hha21q2binglstlpg', '2026-07-27', '10:05:23', '2026-07-27 08:05:23'),
(312, '::1', '/AimsGroupOfColleges/gallery.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '84ci3dk2gq24vl1125fnid63ut', '2026-07-27', '10:06:14', '2026-07-27 08:06:14'),
(313, '::1', '/AimsGroupOfColleges/gallery.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '8e1hmip16bvq8vf026gu0b565v', '2026-07-27', '10:07:19', '2026-07-27 08:07:19'),
(314, '::1', '/AimsGroupOfColleges/gallery.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '05eklvds5ptd1g2s9g83vecnpl', '2026-07-27', '10:07:19', '2026-07-27 08:07:19'),
(315, '::1', '/AimsGroupOfColleges/gallery.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'oujdrlhmd95ip6ngr52tksp1sp', '2026-07-27', '10:07:19', '2026-07-27 08:07:19'),
(316, '::1', '/AimsGroupOfColleges/gallery.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'gqkqd9tsfahc60r7lam2euf4tg', '2026-07-27', '10:07:20', '2026-07-27 08:07:20');
INSERT INTO `website_analytics` (`id`, `visitor_ip`, `page_url`, `page_title`, `referrer`, `user_agent`, `device_type`, `browser`, `operating_system`, `country`, `city`, `session_id`, `visit_date`, `visit_time`, `created_at`) VALUES
(317, '::1', '/AimsGroupOfColleges/mission-vision.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'hhrt2flsnvcdoifk6sbb3v4b4k', '2026-07-27', '10:07:20', '2026-07-27 08:07:20'),
(318, '::1', '/AimsGroupOfColleges/notifications.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'hksg0k581jpm4hmg04mingfpgl', '2026-07-27', '10:07:20', '2026-07-27 08:07:20'),
(319, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:11:11', '2026-07-27 08:11:11'),
(320, '::1', '/AimsGroupOfColleges/about.php', '', 'http://localhost/AimsGroupOfColleges/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:11:22', '2026-07-27 08:11:22'),
(321, '::1', '/AimsGroupOfColleges/mission-vision.php', '', 'http://localhost/AimsGroupOfColleges/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:11:25', '2026-07-27 08:11:25'),
(322, '::1', '/AimsGroupOfColleges/core-values.php', '', 'http://localhost/AimsGroupOfColleges/mission-vision.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:11:29', '2026-07-27 08:11:29'),
(323, '::1', '/AimsGroupOfColleges/leadership.php', '', 'http://localhost/AimsGroupOfColleges/core-values.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:11:34', '2026-07-27 08:11:34'),
(324, '::1', '/AimsGroupOfColleges/courses.php', '', 'http://localhost/AimsGroupOfColleges/leadership.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:11:41', '2026-07-27 08:11:41'),
(325, '::1', '/AimsGroupOfColleges/faculty.php', '', 'http://localhost/AimsGroupOfColleges/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:11:44', '2026-07-27 08:11:44'),
(326, '::1', '/AimsGroupOfColleges/examination.php', '', 'http://localhost/AimsGroupOfColleges/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:11:49', '2026-07-27 08:11:49'),
(327, '::1', '/AimsGroupOfColleges/admission.php', '', 'http://localhost/AimsGroupOfColleges/examination.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:11:53', '2026-07-27 08:11:53'),
(328, '::1', '/AimsGroupOfColleges/admission.php', '', 'http://localhost/AimsGroupOfColleges/examination.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:14:03', '2026-07-27 08:14:03'),
(329, '::1', '/AimsGroupOfColleges/admission.php', '', 'http://localhost/AimsGroupOfColleges/examination.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:14:07', '2026-07-27 08:14:07'),
(330, '::1', '/AimsGroupOfColleges/downloads.php', '', 'http://localhost/AimsGroupOfColleges/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:14:15', '2026-07-27 08:14:15'),
(331, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/downloads.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:14:19', '2026-07-27 08:14:19'),
(332, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'hci3thoo938surrdal8b9o7f6g', '2026-07-27', '10:17:16', '2026-07-27 08:17:16'),
(333, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'f9psieimke0bbohad8n2nt03bh', '2026-07-27', '10:17:16', '2026-07-27 08:17:16'),
(334, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'd25jbpgk2njcu54tun0dhjq2q3', '2026-07-27', '10:17:16', '2026-07-27 08:17:16'),
(335, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'ic3kh7p6vogp3nont9ibmvird1', '2026-07-27', '10:17:16', '2026-07-27 08:17:16'),
(336, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '6fpj1h7vko50atnqfvt372cuh7', '2026-07-27', '10:17:16', '2026-07-27 08:17:16'),
(337, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'v3cit74gk23prsul4hvqu43jtk', '2026-07-27', '10:17:17', '2026-07-27 08:17:17'),
(338, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'th2unoldhq41nf2b1h2m032mle', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(339, '::1', '/AimsGroupOfColleges/about.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'rc63j3i25qc2rsm9nbr2olpa1a', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(340, '::1', '/AimsGroupOfColleges/core-values.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '7tineb0li7hpndpdifr8goac61', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(341, '::1', '/AimsGroupOfColleges/mission-vision.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'ul9mv2gs2ao34ski7vfjc691ol', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(342, '::1', '/AimsGroupOfColleges/leadership.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'aci3df48lgpf40bdgm0c40ml4h', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(343, '::1', '/AimsGroupOfColleges/courses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'vuha86i043ae26uet2govnnjis', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(344, '::1', '/AimsGroupOfColleges/admission.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'ftknb15vuu8o2f7do2fun5c3sn', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(345, '::1', '/AimsGroupOfColleges/examination.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'gftaspkett7p4974dgngf5e5si', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(346, '::1', '/AimsGroupOfColleges/faculty.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'phurh31dch51gfj5ihmf35dfu3', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(347, '::1', '/AimsGroupOfColleges/downloads.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '0nptaqqcvhdqsi69i9aofgaird', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(348, '::1', '/AimsGroupOfColleges/campuses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'alf055cj1hv0i414g9cfvm4t4c', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(349, '::1', '/AimsGroupOfColleges/contact.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '9aek9s0e237hv06uah89nhbkl1', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(350, '::1', '/AimsGroupOfColleges/gallery.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'gfjcpovmbvp5fqlv2rbmc3rqqh', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(351, '::1', '/AimsGroupOfColleges/news.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'edmesdq9arcqii272qm55ddb9k', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(352, '::1', '/AimsGroupOfColleges/notifications.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '50o40j47s2o9808mtfbiuo5l7i', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(353, '::1', '/AimsGroupOfColleges/alumni.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'ne9l9lt3miuej43is3mnc20mcp', '2026-07-27', '10:17:30', '2026-07-27 08:17:30'),
(354, '::1', '/AimsGroupOfColleges/events.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'rmkeb3kn3q5topm8e5f2gaut5v', '2026-07-27', '10:17:31', '2026-07-27 08:17:31'),
(355, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/downloads.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:17:58', '2026-07-27 08:17:58'),
(356, '::1', '/AimsGroupOfColleges/campuses.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'df3j0s14o91vci4sai9gld39s5', '2026-07-27', '10:18:04', '2026-07-27 08:18:04'),
(357, '::1', '/AimsGroupOfColleges/core-values.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '01slk03unf5k03krgfe0d2b01h', '2026-07-27', '11:35:22', '2026-07-27 09:35:22'),
(358, '::1', '/AimsGroupOfColleges/core-values.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '4s1oc4uhl3d92mc328n6sqeu93', '2026-07-27', '11:35:23', '2026-07-27 09:35:23'),
(359, '::1', '/AimsGroupOfColleges/core-values.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'qd2bovg547fl4mapj32vaq47up', '2026-07-27', '11:35:47', '2026-07-27 09:35:47'),
(360, '::1', '/AimsGroupOfColleges/core-values.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'dud8ivihnefdh56jollj4ol4m8', '2026-07-27', '11:35:47', '2026-07-27 09:35:47'),
(361, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:12:11', '2026-08-18 09:12:11'),
(362, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/AdminCP/dashboard.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:20:23', '2026-08-18 09:20:23'),
(363, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:26:50', '2026-08-18 09:26:50'),
(364, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'vs0td2jc8ekikj334jlmjdfh4s', '2026-08-18', '11:29:42', '2026-08-18 09:29:42'),
(365, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'gvb4iqi86moaod09gjevpmmbnr', '2026-08-18', '11:45:42', '2026-08-18 09:45:42'),
(366, '::1', '/AimsGroupOfColleges/about.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:47:12', '2026-08-18 09:47:12'),
(367, '::1', '/AimsGroupOfColleges/mission-vision.php', '', 'http://localhost/AimsGroupOfColleges/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:47:28', '2026-08-18 09:47:28'),
(368, '::1', '/AimsGroupOfColleges/core-values.php', '', 'http://localhost/AimsGroupOfColleges/mission-vision.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:47:41', '2026-08-18 09:47:41'),
(369, '::1', '/AimsGroupOfColleges/leadership.php', '', 'http://localhost/AimsGroupOfColleges/core-values.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:47:55', '2026-08-18 09:47:55'),
(370, '::1', '/AimsGroupOfColleges/about.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '8pf0d813s9qu7cgfl6kraliq6o', '2026-08-18', '11:52:03', '2026-08-18 09:52:03'),
(371, '::1', '/AimsGroupOfColleges/mission-vision.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'coeb9gqql4rt4muj9u8elehe3d', '2026-08-18', '11:52:04', '2026-08-18 09:52:04'),
(372, '::1', '/AimsGroupOfColleges/core-values.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '7rlds96bkv8qclo2vq25h6onq7', '2026-08-18', '11:52:04', '2026-08-18 09:52:04'),
(373, '::1', '/AimsGroupOfColleges/leadership.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'qme6fu4pqi087v0466hg29b30h', '2026-08-18', '11:52:04', '2026-08-18 09:52:04'),
(374, '::1', '/AimsGroupOfColleges/about.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'a34qvbpoq4nkkqiup51n8mkbo8', '2026-08-18', '11:52:31', '2026-08-18 09:52:31'),
(375, '::1', '/AimsGroupOfColleges/mission-vision.php', '', 'http://localhost/AimsGroupOfColleges/leadership.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:54:26', '2026-08-18 09:54:26'),
(376, '::1', '/AimsGroupOfColleges/about.php', '', 'http://localhost/AimsGroupOfColleges/mission-vision.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:54:31', '2026-08-18 09:54:31'),
(377, '::1', '/AimsGroupOfColleges/courses.php', '', 'http://localhost/AimsGroupOfColleges/about.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:55:03', '2026-08-18 09:55:03'),
(378, '::1', '/AimsGroupOfColleges/faculty.php', '', 'http://localhost/AimsGroupOfColleges/courses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:55:14', '2026-08-18 09:55:14'),
(379, '::1', '/AimsGroupOfColleges/examination.php', '', 'http://localhost/AimsGroupOfColleges/faculty.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '11:55:25', '2026-08-18 09:55:25'),
(380, '::1', '/AimsGroupOfColleges/courses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'ecc3c7fdcs0k8o97ve3v81bm9s', '2026-08-18', '12:07:26', '2026-08-18 10:07:26'),
(381, '::1', '/AimsGroupOfColleges/faculty.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '3eabfgansasfmscroe8r09svev', '2026-08-18', '12:07:27', '2026-08-18 10:07:27'),
(382, '::1', '/AimsGroupOfColleges/examination.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'sjhmuslralfpc77vfi82l1dtvk', '2026-08-18', '12:07:27', '2026-08-18 10:07:27'),
(383, '::1', '/AimsGroupOfColleges/courses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'h79nnso9ku5akfug1simmm75c5', '2026-08-18', '12:07:39', '2026-08-18 10:07:39'),
(384, '::1', '/AimsGroupOfColleges/examination.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '0ip4no1mhhjada1rnrtfbh437h', '2026-08-18', '12:08:03', '2026-08-18 10:08:03'),
(385, '::1', '/AimsGroupOfColleges/admission.php', '', 'http://localhost/AimsGroupOfColleges/examination.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:10:07', '2026-08-18 10:10:07'),
(386, '::1', '/AimsGroupOfColleges/downloads.php', '', 'http://localhost/AimsGroupOfColleges/admission.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:10:23', '2026-08-18 10:10:23'),
(387, '::1', '/AimsGroupOfColleges/notifications.php', '', 'http://localhost/AimsGroupOfColleges/downloads.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:10:32', '2026-08-18 10:10:32'),
(388, '::1', '/AimsGroupOfColleges/campus-portal.php', '', 'http://localhost/AimsGroupOfColleges/notifications.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:16:18', '2026-08-18 10:16:18'),
(389, '::1', '/AimsGroupOfColleges/index.php', '', 'http://localhost/AimsGroupOfColleges/campus-portal.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:16:27', '2026-08-18 10:16:27'),
(390, '::1', '/AimsGroupOfColleges/campuses.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:16:31', '2026-08-18 10:16:31'),
(391, '::1', '/AimsGroupOfColleges/admission.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'm1o7bdcl11an619fh771487j82', '2026-08-18', '12:17:34', '2026-08-18 10:17:34'),
(392, '::1', '/AimsGroupOfColleges/downloads.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '372g97vspajmjjmtp2l868rj6g', '2026-08-18', '12:17:34', '2026-08-18 10:17:34'),
(393, '::1', '/AimsGroupOfColleges/notifications.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '28icri8ipidc5h9lr2p1qdrtko', '2026-08-18', '12:17:34', '2026-08-18 10:17:34'),
(394, '::1', '/AimsGroupOfColleges/admission.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'fbina1ednhd1vth0os9jurm894', '2026-08-18', '12:17:52', '2026-08-18 10:17:52'),
(395, '::1', '/AimsGroupOfColleges/campuses.php', '', 'http://localhost/AimsGroupOfColleges/index.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:19:05', '2026-08-18 10:19:05'),
(396, '::1', '/AimsGroupOfColleges/campuses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'lpqqjota1si4mhvsm9pogvo0n4', '2026-08-18', '12:24:26', '2026-08-18 10:24:26'),
(397, '::1', '/AimsGroupOfColleges/campuses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'ngpvilu3en35fn6pcoie876r13', '2026-08-18', '12:26:25', '2026-08-18 10:26:25'),
(398, '::1', '/AimsGroupOfColleges/events.php', '', 'http://localhost/AimsGroupOfColleges/campuses.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:29:38', '2026-08-18 10:29:38'),
(399, '::1', '/AimsGroupOfColleges/news.php', '', 'http://localhost/AimsGroupOfColleges/events.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:29:58', '2026-08-18 10:29:58'),
(400, '::1', '/AimsGroupOfColleges/alumni.php', '', 'http://localhost/AimsGroupOfColleges/news.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:30:11', '2026-08-18 10:30:11'),
(401, '::1', '/AimsGroupOfColleges/events.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'guh1gfn70ehkvqoo163hf0c979', '2026-08-18', '12:34:01', '2026-08-18 10:34:01'),
(402, '::1', '/AimsGroupOfColleges/news.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'sua54pkhpjubhsnk089g4utml7', '2026-08-18', '12:34:01', '2026-08-18 10:34:01'),
(403, '::1', '/AimsGroupOfColleges/alumni.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'nqq7d3412a14ld7jt2n5i91dsg', '2026-08-18', '12:34:01', '2026-08-18 10:34:01'),
(404, '::1', '/AimsGroupOfColleges/news.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'u14a51i44ncomk9uraeupqqpll', '2026-08-18', '12:34:12', '2026-08-18 10:34:12'),
(405, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/alumni.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:38:23', '2026-08-18 10:38:23'),
(406, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:38:37', '2026-08-18 10:38:37'),
(407, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php?category=events', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:39:02', '2026-08-18 10:39:02'),
(408, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php?category=classes', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:39:09', '2026-08-18 10:39:09'),
(409, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php?category=activities', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:39:12', '2026-08-18 10:39:12'),
(410, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:39:14', '2026-08-18 10:39:14'),
(411, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php?category=events', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:39:34', '2026-08-18 10:39:34'),
(412, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php?category=classes', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:39:46', '2026-08-18 10:39:46'),
(413, '::1', '/AimsGroupOfColleges/gallery.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php?category=activities', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:39:57', '2026-08-18 10:39:57'),
(414, '::1', '/AimsGroupOfColleges/gallery.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'psi3rvplrtu3dhl6dom80nrtk0', '2026-08-18', '12:41:12', '2026-08-18 10:41:12'),
(415, '::1', '/AimsGroupOfColleges/gallery.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'ov64j6pk1o2u8akrsnu36gm5n9', '2026-08-18', '12:41:12', '2026-08-18 10:41:12'),
(416, '::1', '/AimsGroupOfColleges/contact.php', '', 'http://localhost/AimsGroupOfColleges/gallery.php?category=achievements', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:41:45', '2026-08-18 10:41:45'),
(417, '::1', '/AimsGroupOfColleges/campuses.php', '', 'http://localhost/AimsGroupOfColleges/contact.php', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Desktop', 'Edge', 'Windows 10', NULL, NULL, 'pu3tu3me8fmcpvfp2jghdjugpt', '2026-08-18', '12:42:26', '2026-08-18 10:42:26'),
(418, '::1', '/AimsGroupOfColleges/contact.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'hdb0psteuukq8458d3pun2abvh', '2026-08-18', '12:50:28', '2026-08-18 10:50:28'),
(419, '::1', '/AimsGroupOfColleges/campuses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '3bfd1upjsj5b0oi1ghl3337qa9', '2026-08-18', '12:50:28', '2026-08-18 10:50:28'),
(420, '::1', '/AimsGroupOfColleges/contact.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'tcatjrkoi3lvojmaiuuc2sd986', '2026-08-18', '12:51:02', '2026-08-18 10:51:02'),
(421, '::1', '/AimsGroupOfColleges/contact.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'c0ju1nfrasghvqp2v0qg0grqag', '2026-08-18', '12:51:15', '2026-08-18 10:51:15'),
(422, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'rnttge7rlsg1gijce2ne831ivm', '2026-08-20', '13:28:53', '2026-08-20 11:28:53'),
(423, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'rnttge7rlsg1gijce2ne831ivm', '2026-08-20', '13:28:59', '2026-08-20 11:28:59'),
(424, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'rfsakn7efgvo9sftq9r2nbo1sn', '2026-08-20', '13:44:20', '2026-08-20 11:44:20'),
(425, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'rkrfbpmnedvv3idfhjj8kff1mg', '2026-08-20', '13:44:29', '2026-08-20 11:44:29'),
(426, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'v53iav7ot5g8li8j762404ejlq', '2026-08-20', '13:44:40', '2026-08-20 11:44:40'),
(427, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'cijdrpnv2lg615mrp3fp7qola9', '2026-08-20', '13:45:25', '2026-08-20 11:45:25'),
(428, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'l2h7k22gs2m1mmdamdf5me05ku', '2026-08-20', '13:45:31', '2026-08-20 11:45:31'),
(429, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'aa3bpdinsgv6dqu05p317fhl0a', '2026-08-21', '12:24:34', '2026-08-21 10:24:34'),
(430, '::1', '/AimsGroupOfColleges/about.php', '', 'http://localhost/AimsGroupOfColleges/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, 'aa3bpdinsgv6dqu05p317fhl0a', '2026-08-21', '12:27:33', '2026-08-21 10:27:33'),
(431, '::1', '/AimsGroupOfColleges/about.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'us39m15vnt1mde3j3d3p51st2f', '2026-08-21', '12:45:27', '2026-08-21 10:45:27'),
(432, '::1', '/AimsGroupOfColleges/about.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'dp9jktkksoj6cc9cinkeaer8ss', '2026-08-21', '12:45:40', '2026-08-21 10:45:40'),
(433, '::1', '/AimsGroupOfColleges/about.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'l70jrro8h2hk71t4u3i74d4gao', '2026-08-21', '12:45:40', '2026-08-21 10:45:40'),
(434, '::1', '/AimsGroupOfColleges/about.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'tfoftnjhq6l1ud1nhjka0lqdb4', '2026-08-21', '13:11:10', '2026-08-21 11:11:10'),
(435, '::1', '/AimsGroupOfColleges/about.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'fccuc519ne7gm7t7cq09ebt2tc', '2026-08-21', '13:11:17', '2026-08-21 11:11:17'),
(436, '::1', '/AimsGroupOfColleges/about.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '8bot9pka0222tnj881405b52is', '2026-08-21', '13:11:17', '2026-08-21 11:11:17'),
(437, '::1', '/AimsGroupOfColleges/courses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '3k70vfs8p986j02n2sdfrep39p', '2026-08-21', '13:24:20', '2026-08-21 11:24:20'),
(438, '::1', '/AimsGroupOfColleges/faculty.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'kccvevm92ldri54nkp92t8bnep', '2026-08-21', '13:24:20', '2026-08-21 11:24:20'),
(439, '::1', '/AimsGroupOfColleges/examination.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '2jptcl78edjdtcm1u5hqou2erm', '2026-08-21', '13:24:21', '2026-08-21 11:24:21'),
(440, '::1', '/AimsGroupOfColleges/courses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'q9ijae71on09irm183oelm5qt5', '2026-08-21', '13:29:26', '2026-08-21 11:29:26'),
(441, '::1', '/AimsGroupOfColleges/faculty.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'qsjt0tr3g4vrapl8muh1bb4rje', '2026-08-21', '13:29:26', '2026-08-21 11:29:26'),
(442, '::1', '/AimsGroupOfColleges/examination.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, '0vsj4ht8ciru14jadk71hs0le1', '2026-08-21', '13:29:27', '2026-08-21 11:29:27'),
(443, '::1', '/AimsGroupOfColleges/courses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'gu2tabnecjg2ksqo37evrhbi35', '2026-08-21', '13:29:37', '2026-08-21 11:29:37'),
(444, '::1', '/AimsGroupOfColleges/faculty.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'bn8vsf27o48i19eb1vmufd20vc', '2026-08-21', '13:29:38', '2026-08-21 11:29:38'),
(445, '::1', '/AimsGroupOfColleges/examination.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'mjb5q61kjuhlsuqufle94ncp5h', '2026-08-21', '13:29:39', '2026-08-21 11:29:39'),
(446, '::1', '/AimsGroupOfColleges/courses.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'a1fdteb3aru95843gra0hg118u', '2026-08-21', '13:29:40', '2026-08-21 11:29:40'),
(447, '::1', '/AimsGroupOfColleges/faculty.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'bgb39n3nviqk4m0ga0c5egpjl6', '2026-08-21', '13:29:46', '2026-08-21 11:29:46'),
(448, '::1', '/AimsGroupOfColleges/examination.php', '', 'Direct', 'curl/8.15.0', 'Desktop', 'Unknown', 'Unknown OS', NULL, NULL, 'a84dd3nhf1g6ikjt8dbju8gm58', '2026-08-21', '13:29:47', '2026-08-21 11:29:47'),
(449, '::1', '/AimsGroupOfColleges/index.php', '', 'Direct', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Desktop', 'Chrome', 'Windows 10', NULL, NULL, '03nbnf85sis9vmescqqmr6cum4', '2026-08-24', '11:18:58', '2026-08-24 09:18:58');

-- --------------------------------------------------------

--
-- Table structure for table `why_choose_us`
--

CREATE TABLE `why_choose_us` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(50) DEFAULT 'fas fa-star' COMMENT 'Font Awesome class, e.g. fas fa-star',
  `color` varchar(20) DEFAULT '#0B7275' COMMENT 'Hex color for icon and accent bar',
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `why_choose_us`
--

INSERT INTO `why_choose_us` (`id`, `title`, `description`, `icon`, `color`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Expert Faculty', 'Highly qualified teachers dedicated to your success', 'fas fa-chalkboard-teacher', '#0B7275', 1, 'active', '2026-08-18 09:27:11', '2026-08-18 09:27:11'),
(2, 'Modern Facilities', 'State-of-the-art classrooms & labs', 'fas fa-building', '#2e7d32', 2, 'active', '2026-08-18 09:27:11', '2026-08-18 09:27:11'),
(3, 'Small Classes', 'Personalized attention for every student', 'fas fa-users', '#7b1fa2', 3, 'active', '2026-08-18 09:27:11', '2026-08-18 09:27:11'),
(4, 'Quality Education', 'Board-aligned curriculum & standards', 'fas fa-certificate', '#e65100', 4, 'active', '2026-08-18 09:27:11', '2026-08-18 09:27:11'),
(5, 'Proven Results', 'Outstanding board exam track record', 'fas fa-chart-line', '#00695c', 5, 'active', '2026-08-18 09:27:11', '2026-08-18 09:27:11'),
(6, 'Affordable Fees', 'Scholarships & easy installments', 'fas fa-hand-holding-heart', '#c62828', 6, 'active', '2026-08-18 09:27:11', '2026-08-18 09:27:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_users`
--
ALTER TABLE `active_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_session` (`session_id`),
  ADD KEY `idx_last_activity` (`last_activity`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alumni_reviews`
--
ALTER TABLE `alumni_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_results`
--
ALTER TABLE `board_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campuses`
--
ALTER TABLE `campuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_faqs`
--
ALTER TABLE `contact_faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_values`
--
ALTER TABLE `core_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `datesheet_details`
--
ALTER TABLE `datesheet_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `datesheet_id` (`datesheet_id`);

--
-- Indexes for table `dms_features`
--
ALTER TABLE `dms_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_datesheets`
--
ALTER TABLE `exam_datesheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_structure`
--
ALTER TABLE `fee_structure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_carousel`
--
ALTER TABLE `hero_carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leadership`
--
ALTER TABLE `leadership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `student_exams`
--
ALTER TABLE `student_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unique_visitors`
--
ALTER TABLE `unique_visitors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_session` (`session_id`),
  ADD KEY `idx_visitor_ip` (`visitor_ip`),
  ADD KEY `idx_last_visit` (`last_visit`);

--
-- Indexes for table `website_analytics`
--
ALTER TABLE `website_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_visitor_ip` (`visitor_ip`),
  ADD KEY `idx_page_url` (`page_url`),
  ADD KEY `idx_visit_date` (`visit_date`),
  ADD KEY `idx_session_id` (`session_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `why_choose_us`
--
ALTER TABLE `why_choose_us`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_users`
--
ALTER TABLE `active_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alumni_reviews`
--
ALTER TABLE `alumni_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `board_results`
--
ALTER TABLE `board_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `campuses`
--
ALTER TABLE `campuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_faqs`
--
ALTER TABLE `contact_faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `core_values`
--
ALTER TABLE `core_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `datesheet_details`
--
ALTER TABLE `datesheet_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dms_features`
--
ALTER TABLE `dms_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exam_datesheets`
--
ALTER TABLE `exam_datesheets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_structure`
--
ALTER TABLE `fee_structure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hero_carousel`
--
ALTER TABLE `hero_carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leadership`
--
ALTER TABLE `leadership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `student_exams`
--
ALTER TABLE `student_exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `unique_visitors`
--
ALTER TABLE `unique_visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `website_analytics`
--
ALTER TABLE `website_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=450;

--
-- AUTO_INCREMENT for table `why_choose_us`
--
ALTER TABLE `why_choose_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `datesheet_details`
--
ALTER TABLE `datesheet_details`
  ADD CONSTRAINT `datesheet_details_ibfk_1` FOREIGN KEY (`datesheet_id`) REFERENCES `exam_datesheets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_exams`
--
ALTER TABLE `student_exams`
  ADD CONSTRAINT `student_exams_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
