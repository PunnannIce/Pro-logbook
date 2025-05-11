-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2025 at 01:08 PM
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
-- Database: `pro_logbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `confirms`
--

CREATE TABLE `confirms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` tinyint(4) DEFAULT NULL,
  `location_id` tinyint(4) DEFAULT NULL,
  `req` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `confirms`
--

INSERT INTO `confirms` (`id`, `user_id`, `location_id`, `req`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 0, '2025-05-08 04:13:29', '2025-05-08 04:33:37');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `term_year` varchar(6) DEFAULT NULL,
  `student_id1` varchar(10) DEFAULT NULL,
  `student_id2` varchar(10) DEFAULT NULL,
  `student_id3` varchar(10) DEFAULT NULL,
  `student_id4` varchar(10) DEFAULT NULL,
  `mentor_id1` varchar(10) DEFAULT NULL,
  `mentor_id2` varchar(10) DEFAULT NULL,
  `mentor_id3` varchar(10) DEFAULT NULL,
  `teacher_id` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `term_year`, `student_id1`, `student_id2`, `student_id3`, `student_id4`, `mentor_id1`, `mentor_id2`, `mentor_id3`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, 'Lotus', '1/2569', '6000000001', NULL, NULL, NULL, '3', '', '', '2', NULL, '2025-05-10 07:49:55');

-- --------------------------------------------------------

--
-- Table structure for table `location_infos`
--

CREATE TABLE `location_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loc_detail` text DEFAULT NULL,
  `loc_house_no` varchar(255) DEFAULT NULL,
  `loc_moo` varchar(255) DEFAULT NULL,
  `loc_soi` varchar(255) DEFAULT NULL,
  `loc_road` varchar(255) DEFAULT NULL,
  `loc_subdistrict` varchar(255) DEFAULT NULL,
  `loc_district` varchar(255) DEFAULT NULL,
  `loc_province` varchar(255) DEFAULT NULL,
  `loc_zip_code` varchar(255) DEFAULT NULL,
  `loc_phone_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location_infos`
--

INSERT INTO `location_infos` (`id`, `loc_detail`, `loc_house_no`, `loc_moo`, `loc_soi`, `loc_road`, `loc_subdistrict`, `loc_district`, `loc_province`, `loc_zip_code`, `loc_phone_number`, `created_at`, `updated_at`) VALUES
(1, 'ศูนย์การค้าและห้างสรรพสินค้าประเภทไฮเปอร์มาร์เก็ต, ซูเปอร์มาร์เก็ต, ร้านค้าปลีกขนาดใหญ่ และร้านสะดวกซื้อสัญชาติไทย ดำเนินกิจการค้าปลีกสินค้าอุปโภคบริโภคในประเทศไทย', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '22000', '0112223333', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2025_04_02_201919_create_locations_table', 1),
(7, '2025_04_03_210633_create_confirms_table', 1),
(8, '2025_04_23_161601_create_student_infos_table', 1),
(9, '2025_04_23_171155_create_student_loc_infos_table', 1),
(10, '2025_04_23_173202_create_location_infos_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_infos`
--

CREATE TABLE `student_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` varchar(10) DEFAULT NULL,
  `image_student` varchar(255) DEFAULT NULL,
  `name_eng` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `degree_level` enum('ปริญญาตรี','ปริญญาโท') DEFAULT NULL,
  `sector` enum('ปกติ','พิเศษ') DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `term_year` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `father_career` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_career` varchar(255) DEFAULT NULL,
  `old_house_no` varchar(255) DEFAULT NULL,
  `old_moo` varchar(255) DEFAULT NULL,
  `old_soi` varchar(255) DEFAULT NULL,
  `old_road` varchar(255) DEFAULT NULL,
  `old_subdistrict` varchar(255) DEFAULT NULL,
  `old_district` varchar(255) DEFAULT NULL,
  `old_province` varchar(255) DEFAULT NULL,
  `old_zip_code` varchar(255) DEFAULT NULL,
  `old_phone_number` varchar(255) DEFAULT NULL,
  `now_house_no` varchar(255) DEFAULT NULL,
  `now_moo` varchar(255) DEFAULT NULL,
  `now_soi` varchar(255) DEFAULT NULL,
  `now_road` varchar(255) DEFAULT NULL,
  `now_subdistrict` varchar(255) DEFAULT NULL,
  `now_district` varchar(255) DEFAULT NULL,
  `now_province` varchar(255) DEFAULT NULL,
  `now_zip_code` varchar(255) DEFAULT NULL,
  `now_phone_number` varchar(255) DEFAULT NULL,
  `work_experience` varchar(255) DEFAULT NULL,
  `talent` varchar(255) DEFAULT NULL,
  `special_interests` varchar(255) DEFAULT NULL,
  `marital_status` enum('โสด','แต่งงาน','หย่าร้าง') DEFAULT NULL,
  `spouse_name` varchar(255) DEFAULT NULL,
  `spouse_job` varchar(255) DEFAULT NULL,
  `children_count` varchar(255) DEFAULT NULL,
  `emg_name` varchar(255) DEFAULT NULL,
  `emg_address` varchar(255) DEFAULT NULL,
  `emg_phone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_infos`
--

INSERT INTO `student_infos` (`id`, `student_id`, `image_student`, `name_eng`, `birthday`, `age`, `religion`, `degree_level`, `sector`, `group`, `term_year`, `year`, `father_name`, `father_career`, `mother_name`, `mother_career`, `old_house_no`, `old_moo`, `old_soi`, `old_road`, `old_subdistrict`, `old_district`, `old_province`, `old_zip_code`, `old_phone_number`, `now_house_no`, `now_moo`, `now_soi`, `now_road`, `now_subdistrict`, `now_district`, `now_province`, `now_zip_code`, `now_phone_number`, `work_experience`, `talent`, `special_interests`, `marital_status`, `spouse_name`, `spouse_job`, `children_count`, `emg_name`, `emg_address`, `emg_phone`, `created_at`, `updated_at`) VALUES
(1, '6000000001', NULL, 'Tanrak Phrana', '2005-10-01', '20', 'พุทธ', 'ปริญญาตรี', 'ปกติ', '1', '1', '2569', 'นายบิดา ประนา', 'ธุรกิจส่วนตัว', 'นางมารดา ประนา', 'ธุรกิจส่วนตัว', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '22000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '22000', NULL, 'ไม่มีประสบการณ์การทำงาน', 'สามารถพูดได้ 2 ภาษาได้แก่ อังกฤษ และ จีน', 'มีความสนใจในการเขียนโปรแกรมอย่างมาก', 'โสด', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_loc_infos`
--

CREATE TABLE `student_loc_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` varchar(10) DEFAULT NULL,
  `duty1` varchar(255) DEFAULT NULL,
  `duty2` varchar(255) DEFAULT NULL,
  `duty3` varchar(255) DEFAULT NULL,
  `duty4` varchar(255) DEFAULT NULL,
  `duty5` varchar(255) DEFAULT NULL,
  `work_issue` text DEFAULT NULL,
  `work_solution` text DEFAULT NULL,
  `subject_name_1` varchar(255) DEFAULT NULL,
  `subject_usage_1` text DEFAULT NULL,
  `subject_name_2` varchar(255) DEFAULT NULL,
  `subject_usage_2` text DEFAULT NULL,
  `subject_name_3` varchar(255) DEFAULT NULL,
  `subject_usage_3` text DEFAULT NULL,
  `subject_name_4` varchar(255) DEFAULT NULL,
  `subject_usage_4` text DEFAULT NULL,
  `subject_name_5` varchar(255) DEFAULT NULL,
  `subject_usage_5` text DEFAULT NULL,
  `training_hours` int(11) DEFAULT NULL,
  `training_task_1` text DEFAULT NULL,
  `training_result_1` text DEFAULT NULL,
  `training_task_2` text DEFAULT NULL,
  `training_result_2` text DEFAULT NULL,
  `training_task_3` text DEFAULT NULL,
  `training_result_3` text DEFAULT NULL,
  `training_task_4` text DEFAULT NULL,
  `training_result_4` text DEFAULT NULL,
  `training_task_5` text DEFAULT NULL,
  `training_result_5` text DEFAULT NULL,
  `training_obstacle_1` text DEFAULT NULL,
  `suggestion_1` text DEFAULT NULL,
  `training_obstacle_2` text DEFAULT NULL,
  `suggestion_2` text DEFAULT NULL,
  `training_obstacle_3` text DEFAULT NULL,
  `suggestion_3` text DEFAULT NULL,
  `training_obstacle_4` text DEFAULT NULL,
  `suggestion_4` text DEFAULT NULL,
  `training_obstacle_5` text DEFAULT NULL,
  `suggestion_5` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_loc_infos`
--

INSERT INTO `student_loc_infos` (`id`, `student_id`, `duty1`, `duty2`, `duty3`, `duty4`, `duty5`, `work_issue`, `work_solution`, `subject_name_1`, `subject_usage_1`, `subject_name_2`, `subject_usage_2`, `subject_name_3`, `subject_usage_3`, `subject_name_4`, `subject_usage_4`, `subject_name_5`, `subject_usage_5`, `training_hours`, `training_task_1`, `training_result_1`, `training_task_2`, `training_result_2`, `training_task_3`, `training_result_3`, `training_task_4`, `training_result_4`, `training_task_5`, `training_result_5`, `training_obstacle_1`, `suggestion_1`, `training_obstacle_2`, `suggestion_2`, `training_obstacle_3`, `suggestion_3`, `training_obstacle_4`, `suggestion_4`, `training_obstacle_5`, `suggestion_5`, `created_at`, `updated_at`) VALUES
(1, '6000000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_log`
--

CREATE TABLE `student_log` (
  `id` bigint(20) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `log_date` date NOT NULL,
  `log_header` text NOT NULL,
  `log_detail` longtext NOT NULL,
  `t_comment` mediumtext DEFAULT NULL,
  `m_comment` mediumtext DEFAULT NULL,
  `signature` tinyint(1) NOT NULL DEFAULT 0,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `updated_date` date NOT NULL DEFAULT current_timestamp(),
  `log` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_log`
--

INSERT INTO `student_log` (`id`, `student_id`, `log_date`, `log_header`, `log_detail`, `t_comment`, `m_comment`, `signature`, `created_date`, `updated_date`, `log`) VALUES
(1, '6000000001', '2025-05-05', '0', '0', '0', '0', 0, '2025-05-05', '2025-05-05', '[{\"log_date\":\"2025-05-05\",\"log_header\":\"1\",\"log_detail\":\"2345\",\"created_date\":\"2025-05-05 11:56:29\",\"t_comments\":[\"6\"],\"m_comments\":[\"8\"],\"signature\":\"no\"},{\"log_date\":\"2025-05-06\",\"log_header\":\"fix computer\",\"log_detail\":\"fix computer startup error due to 1 memory slot is full of dust\",\"created_date\":\"2025-05-05 11:57:19\",\"t_comments\":[\"good\"],\"m_comments\":[\"well done\"],\"signature\":\"no\"},{\"log_date\":\"2025-05-07\",\"log_header\":\"\\u0e40\\u0e1b\\u0e47\\u0e19\\u0e27\\u0e31\\u0e19\\u0e17\\u0e35\\u0e48\\u0e2a\\u0e07\\u0e1a\",\"log_detail\":\"\\u0e17\\u0e33\\u0e07\\u0e32\\u0e19\\u0e40\\u0e2d\\u0e01\\u0e2a\\u0e32\\u0e23\\u0e19\\u0e34\\u0e14\\u0e2b\\u0e19\\u0e48\\u0e2d\\u0e22\\u0e41\\u0e25\\u0e30\\u0e0a\\u0e48\\u0e27\\u0e22\\u0e1e\\u0e35\\u0e48\\u0e46\\u0e02\\u0e19\\u0e04\\u0e2d\\u0e21\\u0e1e\\u0e34\\u0e27\\u0e40\\u0e15\\u0e2d\\u0e23\\u0e4c\\u0e40\\u0e01\\u0e48\\u0e32\\u0e44\\u0e1b\\u0e40\\u0e01\\u0e47\\u0e1a\\u0e43\\u0e19\\u0e2b\\u0e49\\u0e2d\\u0e07\\u0e40\\u0e01\\u0e47\\u0e1a\\u0e02\\u0e2d\\u0e07\",\"created_date\":\"2025-05-05 11:58:02\",\"m_comments\":[\"\\u0e17\\u0e33\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e17\\u0e35\\u0e48\\u0e44\\u0e14\\u0e49\\u0e2d\\u0e22\\u0e48\\u0e32\\u0e07\\u0e22\\u0e2d\\u0e14\\u0e40\\u0e22\\u0e35\\u0e48\\u0e22\\u0e21\\u0e21\\u0e32\\u0e01\"],\"signature\":\"yes\"},{\"log_date\":\"2025-05-08\",\"log_header\":\"\\u0e17\\u0e14\\u0e2a\\u0e2d\\u0e1a\\u0e2a\\u0e21\\u0e1a\\u0e39\\u0e23\\u0e13\\u0e4c\",\"log_detail\":\"\\u0e44\\u0e21\\u0e48\\u0e21\\u0e35\\u0e2d\\u0e30\\u0e44\\u0e23\\u0e40\\u0e1b\\u0e47\\u0e19\\u0e1e\\u0e34\\u0e40\\u0e28\\u0e29 \\u0e41\\u0e01\\u0e49\\u0e44\\u0e02\\u0e2a\\u0e33\\u0e40\\u0e23\\u0e47\\u0e08\",\"created_date\":\"2025-05-08 11:08:31\",\"t_comments\":[\"\\u0e44\\u0e21\\u0e48\\u0e21\\u0e35\\u0e2d\\u0e30\\u0e44\\u0e23\\u0e1c\\u0e34\\u0e14\\u0e1b\\u0e01\\u0e15\\u0e34 \\u0e41\\u0e01\\u0e49\\u0e44\\u0e02\\u0e40\\u0e23\\u0e35\\u0e22\\u0e1a\\u0e23\\u0e49\\u0e2d\\u0e22\"],\"m_comments\":[\"\\u0e41\\u0e01\\u0e49\\u0e44\\u0e02\\u0e40\\u0e23\\u0e35\\u0e22\\u0e1a\\u0e23\\u0e49\\u0e2d\\u0e22\"],\"signature\":\"yes\"},{\"log_date\":\"2025-05-09\",\"log_header\":\"test\",\"log_detail\":\"123455\",\"created_date\":\"2025-05-08 14:17:36\",\"t_comments\":[\"test1234\"],\"m_comments\":[\"12345\"],\"signature\":\"no\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_notes`
--

CREATE TABLE `teacher_notes` (
  `id` bigint(20) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `supervision_type` enum('','ออนไลน์','ออนไซต์') DEFAULT NULL,
  `note_detail` longtext DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_notes`
--

INSERT INTO `teacher_notes` (`id`, `student_id`, `supervision_type`, `note_detail`, `created_at`, `updated_at`) VALUES
(1, '6000000001', 'ออนไซต์', 'นักศึกษาปฏิบัติได้ดีเยี่ยม แก้ไขแล้ว', '2025-05-11', '2025-05-11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `student_id` varchar(10) DEFAULT NULL,
  `branch` enum('วิทยาการคอมพิวเตอร์','เทคโนโลยีสารสนเทศ','เทคโนโลยีเครือข่าย','ภูมิสารสนเทศ') DEFAULT NULL,
  `year` enum('1','2','3','4','5') DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Administrator','Teacher','Student','Mentor') NOT NULL DEFAULT 'Student',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `student_id`, `branch`, `year`, `phone_number`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', NULL, NULL, NULL, 'admin@gmail.com', '2025-05-05 02:40:25', '$2y$10$tQZ04xByjNLglhUs.nGY7.vGxv92q3E1We/6P4Ukr5q2IVUqEDBb2', 'Administrator', NULL, '2025-05-05 02:40:25', '2025-05-05 02:40:25'),
(2, 'อาจารย์สุวาณี คำศรี', '1000000001', NULL, NULL, NULL, 'teacher@gmail.com', '2025-05-05 02:40:25', '$2y$10$Xh9WEl2BpswyRl/4l4rES.ZZVzhbwjcZBRHtCc0t2teYCzNMjpgou', 'Teacher', NULL, '2025-05-05 02:40:25', '2025-05-06 01:48:08'),
(3, 'นายซีเมเจอร์ บลูโซล', '0000000001', NULL, NULL, NULL, 'mentor1@gmail.com', '2025-05-05 02:40:25', '$2y$10$OhmIEg2NN23ROtZtmdpGZeeRgjY7bsjQTyuxOX0.R0T9m9QCti/oC', 'Mentor', NULL, '2025-05-05 02:40:25', '2025-05-06 01:48:17'),
(4, 'นายผ้าพันคอ ดวงดาว', NULL, NULL, NULL, NULL, 'mentor2@gmail.com', '2025-05-05 02:40:25', '$2y$10$zUyR0Yc8LR3//G3GuCodieOzUc19rIzUb97CLR/6weIBBaT6SFtr.', 'Student', NULL, '2025-05-05 02:40:25', '2025-05-05 02:40:25'),
(5, 'นางสาวแทนรัก ประนา', '6000000001', 'วิทยาการคอมพิวเตอร์', '1', '0123456789', 'student@gmail.com', '2025-05-05 02:40:25', '$2y$10$yB3J8dem7jOIiIpi0J6oxumej0/5I30J3B2IYdCH.9LMOxuAtth9S', 'Student', NULL, '2025-05-05 02:40:25', '2025-05-05 02:40:25'),
(6, 'นายดวงดาว สว่างจ้า', '6000000002', 'วิทยาการคอมพิวเตอร์', '1', '0212223333', 'student2@gmail.com', '2025-05-06 01:44:48', '$2y$10$Tz5E6LX5ZuM2rVo7hH3itu.TUb1RoJk9uPJBxPCIe19Tnu0fgC2TW', 'Student', '', '2025-05-06 01:44:48', '2025-05-06 01:44:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `confirms`
--
ALTER TABLE `confirms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_teacher_id_unique` (`teacher_id`),
  ADD UNIQUE KEY `locations_student_id1_unique` (`student_id1`),
  ADD UNIQUE KEY `locations_student_id2_unique` (`student_id2`),
  ADD UNIQUE KEY `locations_student_id3_unique` (`student_id3`),
  ADD UNIQUE KEY `locations_student_id4_unique` (`student_id4`),
  ADD UNIQUE KEY `locations_mentor_id_unique` (`mentor_id1`,`mentor_id2`,`mentor_id3`);

--
-- Indexes for table `location_infos`
--
ALTER TABLE `location_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `student_infos`
--
ALTER TABLE `student_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_infos_student_id_unique` (`student_id`);

--
-- Indexes for table `student_loc_infos`
--
ALTER TABLE `student_loc_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_loc_infos_student_id_unique` (`student_id`);

--
-- Indexes for table `student_log`
--
ALTER TABLE `student_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `log_student_id_unique` (`student_id`);

--
-- Indexes for table `teacher_notes`
--
ALTER TABLE `teacher_notes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_notes_student_id_unique` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_student_id_unique` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `confirms`
--
ALTER TABLE `confirms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `location_infos`
--
ALTER TABLE `location_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_infos`
--
ALTER TABLE `student_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_loc_infos`
--
ALTER TABLE `student_loc_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_log`
--
ALTER TABLE `student_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teacher_notes`
--
ALTER TABLE `teacher_notes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
