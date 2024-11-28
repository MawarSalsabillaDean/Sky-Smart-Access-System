-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2024 at 03:54 PM
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
-- Database: `ssas`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenity_usage`
--

CREATE TABLE `amenity_usage` (
  `usage_id` int(11) NOT NULL,
  `resident_id` int(11) DEFAULT NULL,
  `amenity_name` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amenity_usage`
--

INSERT INTO `amenity_usage` (`usage_id`, `resident_id`, `amenity_name`, `start_time`, `end_time`, `duration`) VALUES
(1, 30, 'Gym', '2024-11-07 05:30:57', '2024-11-07 05:31:15', NULL),
(2, 30, 'Gym', '2024-11-07 05:36:12', NULL, NULL),
(3, 30, 'Gym', '2024-11-07 05:46:49', '2024-11-07 05:55:55', 546),
(4, 30, 'Gym', '2024-11-07 05:56:16', '2024-11-07 05:56:27', 11),
(5, 30, 'Gym', '2024-11-07 05:56:55', '2024-11-07 05:57:29', 34),
(6, 30, 'Gym', '2024-11-07 05:57:54', '2024-11-07 05:58:05', 11),
(7, 30, 'Gym', '2024-11-07 06:00:19', '2024-11-07 06:00:29', 10),
(8, 30, 'Gym', '2024-11-07 06:03:07', '2024-11-07 06:03:35', 28),
(9, 30, 'Gym', '2024-11-07 06:08:10', '2024-11-07 06:35:46', 0),
(10, 30, 'Gym', '2024-11-07 06:36:25', '2024-11-07 06:36:30', 5),
(11, 36, 'Swimming Pool', '2024-11-07 16:27:58', '2024-11-07 16:28:10', 12),
(12, 37, 'Swimming Pool', '2024-11-07 16:36:18', '2024-11-07 16:38:05', 107),
(13, 37, 'Swimming Pool', '2024-11-07 16:38:43', '2024-11-07 16:38:50', 7),
(14, 37, 'Swimming Pool', '2024-11-07 17:18:35', '2024-11-07 17:18:40', 5),
(15, 37, 'Wading Pool', '2024-11-07 17:21:49', '2024-11-07 17:21:57', 8),
(16, 37, 'Wading Pool', '2024-11-07 17:22:33', '2024-11-07 17:22:40', 7),
(17, 37, 'Wading Pool', '2024-11-07 17:23:49', '2024-11-07 17:23:55', 6),
(18, 37, 'Wading Pool', '2024-11-07 17:24:13', '2024-11-07 17:24:22', 9),
(19, 37, 'Landscaped Garden', '2024-11-07 17:29:54', '2024-11-07 17:30:00', 6),
(20, 36, 'Gymnasium', '2024-11-07 23:50:56', '2024-11-07 23:50:59', 3),
(21, 30, 'Gymnasium', '2024-11-08 01:03:03', '2024-11-08 01:03:08', 5),
(22, 30, 'Landscaped Garden', '2024-11-08 01:06:07', '2024-11-08 01:06:13', 6),
(23, 30, 'Landscaped Garden', '2024-11-08 01:06:28', '2024-11-08 01:06:33', 5),
(24, 30, 'Landscaped Garden', '2024-11-08 01:06:38', '2024-11-08 01:06:47', 9),
(25, 30, 'Landscaped Garden', '2024-11-08 01:07:03', '2024-11-08 01:07:11', 8),
(26, 30, 'Landscaped Garden', '2024-11-08 01:07:56', '2024-11-08 01:07:59', 3),
(27, 30, 'Landscaped Garden', '2024-11-08 01:08:07', '2024-11-08 01:08:11', 4),
(28, 30, 'Landscaped Garden', '2024-11-08 01:08:20', '2024-11-08 01:08:24', 4),
(29, 30, 'Landscaped Garden', '2024-11-08 01:08:31', '2024-11-08 01:08:42', 11),
(30, 30, 'Landscaped Garden', '2024-11-08 01:08:54', '2024-11-08 01:09:04', 10),
(31, 38, 'Wading Pool', '2024-11-08 02:38:26', '2024-11-08 02:38:37', 11),
(32, 38, 'Wading Pool', '2024-11-08 02:38:49', '2024-11-08 02:39:00', 11),
(33, 38, 'Wading Pool', '2024-11-08 02:39:18', '2024-11-08 02:39:27', 9),
(34, 38, 'Wading Pool', '2024-11-08 02:39:55', '2024-11-08 02:40:04', 9),
(35, 38, 'Wading Pool', '2024-11-08 02:40:17', '2024-11-08 02:40:30', 13),
(36, 38, 'Wading Pool', '2024-11-08 02:43:48', '2024-11-08 02:43:54', 6),
(37, 38, 'Wading Pool', '2024-11-08 02:44:03', '2024-11-08 02:44:07', 4),
(38, 39, 'Gymnasium', '2024-11-08 11:33:09', '2024-11-08 11:33:17', 8),
(39, 39, 'Gymnasium', '2024-11-08 11:33:51', NULL, NULL),
(40, 39, 'Gymnasium', '2024-11-08 11:34:52', '2024-11-08 11:34:58', 6),
(41, 40, 'Landscaped Garden', '2024-11-19 01:22:20', '2024-11-19 01:23:21', 61),
(42, 40, 'Landscaped Garden', '2024-11-19 01:23:41', NULL, NULL),
(43, 40, 'Landscaped Garden', '2024-11-19 01:27:04', '2024-11-19 01:27:08', 4),
(44, 40, 'Landscaped Garden', '2024-11-19 01:30:19', '2024-11-19 01:30:21', 2),
(45, 40, 'Landscaped Garden', '2024-11-19 01:50:47', NULL, NULL),
(46, 40, 'Landscaped Garden', '2024-11-19 02:04:35', NULL, NULL),
(47, 40, 'Landscaped Garden', '2024-11-19 02:08:20', NULL, NULL),
(48, 40, 'Landscaped Garden', '2024-11-19 02:09:48', '2024-11-19 02:10:05', 17),
(49, 42, 'Gymnasium', '2024-11-19 14:42:21', '2024-11-19 14:42:25', 4),
(50, 42, 'Gymnasium', '2024-11-19 14:43:00', '2024-11-19 14:43:07', 7),
(51, 42, 'Gymnasium', '2024-11-19 14:43:33', NULL, NULL),
(52, 42, 'Gymnasium', '2024-11-19 14:43:40', '2024-11-19 14:43:44', 4),
(53, 42, 'Gymnasium', '2024-11-19 14:43:58', '2024-11-19 14:44:08', 10),
(54, 25, 'Landscaped Garden', '2024-11-19 15:38:52', '2024-11-19 15:38:56', 4),
(55, 44, 'Landscaped Garden', '2024-11-19 16:04:37', '2024-11-19 16:04:57', 20),
(56, 45, 'Landscaped Garden', '2024-11-19 16:18:03', '2024-11-19 16:18:15', 12),
(57, 25, 'Landscaped Garden', '2024-11-19 23:46:10', '2024-11-19 23:47:24', 74),
(58, 25, 'Landscaped Garden', '2024-11-19 23:48:31', '2024-11-19 23:49:41', 70),
(60, 38, 'Gymnasium', '2024-11-26 01:27:23', '2024-11-26 01:27:30', 7),
(61, 38, 'Gymnasium', '2024-11-26 01:27:44', '2024-11-26 01:27:48', 4),
(62, 38, 'Gymnasium', '2024-11-26 01:27:56', '2024-11-26 01:28:03', 7),
(63, 38, 'Gymnasium', '2024-11-26 01:28:54', '2024-11-26 01:29:04', 10),
(64, 38, 'Swimming Pool', '2024-11-26 20:08:46', '2024-11-26 20:09:55', 69),
(65, 38, 'Landscaped Garden', '2024-11-27 07:15:58', '2024-11-27 07:16:01', 3),
(66, 38, 'Landscaped Garden', '2024-11-27 07:16:13', '2024-11-27 07:16:16', 3),
(67, 38, 'Landscaped Garden', '2024-11-27 07:22:14', '2024-11-27 07:22:27', 13),
(68, 47, 'Gymnasium', '2024-11-28 14:34:56', '2024-11-28 14:35:02', 6),
(69, 47, 'Landscaped Garden', '2024-11-28 14:35:08', '2024-11-28 14:35:15', 7),
(70, 47, 'Wading Pool', '2024-11-28 14:35:18', '2024-11-28 14:35:25', 7),
(71, 47, 'Swimming Pool', '2024-11-28 14:35:29', '2024-11-28 14:35:37', 8),
(72, 47, 'Gymnasium', '2024-11-28 16:17:32', '2024-11-28 16:18:02', 30),
(73, 48, 'Gym', '2024-11-28 19:59:07', '2024-11-28 19:59:21', 14);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `send_to_all` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `title`, `file_name`, `send_to_all`, `created_at`) VALUES
(24, 'First Lift Under Maintenance for A Week', 'LIFT UNDER MAINTENANCE.pdf', 1, '2024-11-19 16:09:52'),
(27, 'LIft Maintenance', 'LIFT UNDER MAINTENANCE THIRD.pdf', 1, '2024-11-28 07:57:51'),
(28, 'access card', 'bmw e90 wqq 6239.jpg', 0, '2024-11-28 08:00:49');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_units`
--

CREATE TABLE `announcement_units` (
  `announcement_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_units`
--

INSERT INTO `announcement_units` (`announcement_id`, `resident_id`) VALUES
(28, 47);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaint_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `problem_title` varchar(255) NOT NULL,
  `date_occurrence` date NOT NULL,
  `time_occurrence` time NOT NULL,
  `problem_desc` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaint_id`, `resident_id`, `problem_title`, `date_occurrence`, `time_occurrence`, `problem_desc`, `image_path`, `submitted_at`, `status`, `comment`) VALUES
(7, 29, 'Testing', '2024-11-04', '02:15:00', 'Test test', 'uploads/lift rosak.jpg', '2024-11-03 18:15:16', 'Resolved', ''),
(9, 37, 'Elevator Breaking Down', '2024-11-07', '10:00:00', 'Im stuck in the lift, the third elevator suddenly stop working and shut down! ', 'uploads/lift rosak.jpg', '2024-11-07 09:15:40', 'pending', ''),
(10, 36, 'Elevator Breakdown', '2024-11-06', '00:00:00', 'Im in the lift suddenly the elevator not functioning.', 'uploads/lift rosak.jpg', '2024-11-07 15:55:35', 'pending', ''),
(11, 40, 'Neighbourhood Too Load', '2024-11-18', '03:00:00', 'The neighborhood is too noisy and it disturbs my sleep.', 'uploads/House the sky residensi.jpg', '2024-11-18 15:57:23', 'Resolved', ''),
(12, 42, 'First elevator not function.', '2024-11-19', '14:38:00', 'First elevator not functioning. Only second and third lifts function well. ', 'uploads/lift rosak.jpg', '2024-11-19 06:39:26', 'In Progress', 'already send to contractor for the repairing work'),
(15, 44, 'Elevator Breakdown', '2024-11-19', '16:02:00', 'First elevator not function.', 'uploads/lift rosak.jpg', '2024-11-19 08:03:01', 'Rejected', ''),
(18, 47, 'Broken Gym Equipment', '2024-11-28', '13:20:00', 'Some gym machines are broken and unusable.', 'uploads/broken equipment.jpg', '2024-11-28 05:19:20', 'Resolved', 'already send to contractor for the repairing work'),
(19, 48, 'Elevator Breakdown', '2024-11-28', '20:27:00', 'Second evaluator cannot be used.', 'uploads/WhatsApppppppp Image 2024-11-28 at 8.00.24 PM.jpeg', '2024-11-28 12:27:36', 'pending', ''),
(20, 48, 'Elevator Breakdown', '2024-11-28', '20:28:00', 'Second evaluator cannot be used.', 'uploads/WhatsApppppppp Image 2024-11-28 at 8.00.24 PM.jpeg', '2024-11-28 12:28:07', 'In Progress', ''),
(21, 48, 'Elevator Breakdown', '2024-11-28', '20:29:00', 'Second evaluator cannot be used.', 'uploads/WhatsApppppppp Image 2024-11-28 at 8.00.24 PM.jpeg', '2024-11-28 12:28:32', 'Resolved', ''),
(22, 48, 'Elevator Breakdown', '2024-11-28', '20:29:00', 'Second evaluator cannot be used.', 'uploads/WhatsApppppppp Image 2024-11-28 at 8.00.24 PM.jpeg', '2024-11-28 12:28:47', 'Rejected', 'The elevator already can be use.');

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `login_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `login_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`login_id`, `resident_id`, `login_time`) VALUES
(1, 30, '2024-11-08 01:05:52'),
(2, 30, '2024-11-08 01:07:48'),
(3, 29, '2024-11-08 01:11:17'),
(4, 29, '2024-11-08 01:13:16'),
(5, 29, '2024-11-08 02:06:08'),
(6, 38, '2024-11-08 02:30:09'),
(7, 38, '2024-11-08 02:37:45'),
(8, 38, '2024-11-08 02:39:43'),
(9, 39, '2024-11-08 11:32:00'),
(10, 39, '2024-11-08 11:32:24'),
(11, 39, '2024-11-08 11:39:13'),
(12, 39, '2024-11-08 11:40:37'),
(13, 40, '2024-11-18 23:32:56'),
(14, 40, '2024-11-19 01:22:04'),
(15, 38, '2024-11-19 01:37:28'),
(16, 40, '2024-11-19 01:42:22'),
(17, 25, '2024-11-19 13:57:14'),
(18, 25, '2024-11-19 13:57:47'),
(19, 25, '2024-11-19 14:01:59'),
(20, 25, '2024-11-19 14:10:03'),
(21, 25, '2024-11-19 14:11:44'),
(22, 25, '2024-11-19 14:12:46'),
(23, 42, '2024-11-19 14:25:50'),
(24, 42, '2024-11-19 14:41:25'),
(25, 38, '2024-11-19 14:47:37'),
(26, 38, '2024-11-19 14:54:34'),
(27, 25, '2024-11-19 15:36:33'),
(28, 25, '2024-11-19 15:38:25'),
(29, 43, '2024-11-19 15:52:16'),
(30, 44, '2024-11-19 15:56:35'),
(31, 45, '2024-11-19 16:10:47'),
(32, 25, '2024-11-19 23:36:31'),
(33, 25, '2024-11-21 08:16:29'),
(34, 25, '2024-11-21 11:06:17'),
(37, 38, '2024-11-26 00:43:02'),
(38, 38, '2024-11-26 19:11:39'),
(39, 38, '2024-11-26 23:42:23'),
(40, 38, '2024-11-27 01:13:26'),
(41, 38, '2024-11-27 07:11:48'),
(42, 38, '2024-11-27 07:15:09'),
(43, 38, '2024-11-27 07:20:51'),
(44, 38, '2024-11-27 08:05:49'),
(45, 38, '2024-11-28 10:19:54'),
(46, 47, '2024-11-28 13:06:55'),
(47, 47, '2024-11-28 14:13:44'),
(48, 38, '2024-11-28 15:29:27'),
(49, 47, '2024-11-28 16:01:07'),
(50, 38, '2024-11-28 16:01:38'),
(51, 47, '2024-11-28 16:16:40'),
(52, 47, '2024-11-28 19:19:22'),
(53, 48, '2024-11-28 19:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `resident_account`
--

CREATE TABLE `resident_account` (
  `resident_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `unit_number` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resident_account`
--

INSERT INTO `resident_account` (`resident_id`, `full_name`, `phone_number`, `unit_number`, `email`, `password`, `created_at`, `last_login`) VALUES
(1, 'Adleena Binti Maihazam', '011-1111 111', '09-01', 'adleena@gmail.com', '$2y$10$EkR8A6Do.1loUgud/uaXf.vPbACemWEhrJWFQiUMveIMKxKSSawMO', '2024-10-25 02:23:57', '0000-00-00 00:00:00'),
(8, 'Nurish Qalisya binti Syed Muhmin', '018-2395 817', '09-05', 'qalisya@gmail.com', '$2y$10$0RTuLxmKvU5G.xtUX5A7K.7oeDLoUipEefljExo7/NszpJk0YAQ0u', '2024-10-29 23:15:06', '2024-10-29 23:29:47'),
(11, 'Aiman Bin Zaki', '011-1111 115', '09-02', 'aiman@gmail.com', '$2y$10$trVcwM3nBX0RQUl8mugcheuOkpwlfaOrWStX9ItzIxJKDUXN3tm4e', '2024-10-30 00:41:50', '2024-10-30 01:34:02'),
(17, 'Rahim bin Arfan', '011-1111 119', '09-02', 'rahim@gmail.com', '$2y$10$U5Dbiryh6KoiThpyQ7SEj.a.knWARfh7qUZ6FyM5gjYB6yU4acn6.', '2024-10-30 01:35:37', '2024-10-30 02:06:29'),
(19, 'Anggun binti Abdullah', '011-1111 120', '09-06', 'anggun@gmail.com', '$2y$10$CVNpPnH9B7pCATFEtJKi2.VpbFrR60DNXJv4ZkwUkRaV82z6LdYwm', '2024-10-30 17:39:40', '2024-10-30 17:40:14'),
(21, 'Melur binti Faris', '011-1111 117', '09-06', 'melur@gmail.com', '$2y$10$sZXJt3hCU/ToBHIAQhFSP.Vw/Ji1G6KyaB8gzDZhZ181QXVrFcbE2', '2024-10-30 17:50:44', '2024-10-30 17:53:59'),
(22, 'Adam bin Yusuf', '011-1111 123', '09-06', 'adam@gmail.com', '$2y$10$Zbj6rnLQfgyZ6ebMIRSEj.jZJ66NOLd4qyE7pU.V1cb3DTqNzgr1i', '2024-10-31 01:45:15', '2024-10-31 01:46:17'),
(23, 'Zhang Wei', '012-3456 123', '09-10', 'zhangwei@gmail.com', '$2y$10$LD8GKBx2ZIT1iKtM4qp7HeYWVPMfbmsBrVOGDBX44ecvsjfotpAXm', '2024-10-31 17:14:41', '0000-00-00 00:00:00'),
(24, 'Abinesh Srie', '011-3498 938', '09-01', 'abinesh@gmail.com', '$2y$10$HFCMMsGBVVqB0DHPfKktIe2JWe1hNtAhBo/fU60mazg5lnLP6O2ri', '2024-11-01 15:18:55', '2024-11-01 15:33:05'),
(25, 'Priyanka A/L Avinesh', '013-3283 892', '10-01', 'priyanka@gmail.com', '$2y$10$qSpj4ZCT5Bv3WzOESvaBdeAZAE3GwEhOZXgPqkkQdRKQsPSQsfsZO', '2024-11-01 15:35:25', '2024-11-21 11:06:17'),
(26, 'Mawar Binti Kardin', '018-2373 283', '10-02', 'mawar@gmail.com', '$2y$10$KIpYVxqhvmLYQCGcPJiyCOOc9/AALjHC.b4AB1OZOfJGOKJs7DVxS', '2024-11-01 17:20:35', '2024-11-01 19:33:07'),
(28, 'Aiman bin Zaki', '011-1111 5150', '10-07', 'aimanzaki@gmail.com', '$2y$10$HURX5hCf7GmuuQFVfLYR9OqW2swof9RQ8mW7eOqTVEWeul/tIMcI.', '2024-11-02 13:54:55', '2024-11-05 17:30:58'),
(29, 'Qaireena Binti Rayyan', '014-2398 298', '10-09', 'qaireena@gmail.com', '$2y$10$aJvEEmGSqNDTmG0WLGmT..rE0atmpesAw4s1rhuYlBXIkaGnFoZYG', '2024-11-04 02:14:26', '2024-11-08 02:06:08'),
(30, 'Intan bin Tahir', '011-2892 489', '10-10', 'intan@gmail.com', '$2y$10$TJi1HIqhOaYD.jcZO0ct5.Hsui9Owy.0ASEnf.U.tfZM9p55lA.1C', '2024-11-05 03:50:03', '2024-11-08 01:07:48'),
(31, 'Testing', '011-1111 5150', '10-11', 'cuba@gmail.com', '$2y$10$9SIkcTRnlkns/NP.jNey0.kZGqU1kxhQPfKxP4HoEmgkfida.272u', '2024-11-05 03:54:47', '2024-11-05 03:55:01'),
(32, 'Jia Li', '018-4877 233', '10-03', 'jiali@gmail.com', '$2y$10$rtSznVGeGsjvJR/k.dsam.uzRACrPSeajTkd6uNfzCFdVRAuH947u', '2024-11-05 15:33:41', '2024-11-05 16:59:54'),
(33, 'Trisha Lopez', '011-4389 203', '10-04', 'trisha@gmail.com', '$2y$10$RBvhCuBkcAAmzRRS./pVaOHEWz2R1xx.eOvxjspSyw0nSDCOw4pvy', '2024-11-05 17:10:40', '2024-11-05 17:11:08'),
(34, 'Saarvin Nair', '012-2309 230', '10-08', 'saarvin@gmail.com', '$2y$10$20T0/kJfnSFBwxzg2ebx5.vewm8ywEvBNG.pwqE0mBBXzsZPs2H4q', '2024-11-05 17:13:17', '2024-11-07 03:11:53'),
(35, 'Sofia binti Abdul', '018-4877 098', '10-12', 'sofia@gmail.com', '$2y$10$o0Voo90k8cfDwpvQ32SqaOIBGuZiKoGCaJb2YBvzvIUJr.726S5gS', '2024-11-06 12:07:34', '2024-11-06 12:07:46'),
(36, 'Tengku Fasya binti Tengku Zack', '012-9327 349', '10-12', 'tengkufasya@gmail.com', '$2y$10$Od6h1v8a5Ev6MrKwoW/w6.OrpJGh8zc9x5PaRu/MdCyFPJ5X5VR7a', '2024-11-07 16:00:56', '2024-11-08 00:25:28'),
(37, 'Raja Auni Binti Raja Samsul', '018-3930 309', '10-12', 'rajaauni@gmail.com', '$2y$10$83F2yZi09zn9TjDygRSTtO5ouuV2BcSka.Bcj3XHq4iDHC6oRMbaa', '2024-11-07 16:35:53', '2024-11-07 17:20:47'),
(38, 'Tengku Yusreena binti Tengku Hassan', '012-2399 238', '11-01', 'tengkuyusreena@gmail.com', '$2y$10$Bt8RISHBsHYn/ybvPc/t1erB4D.iuL6a2x4QxJYk7bghnI0B1IMTy', '2024-11-08 02:30:06', '2024-11-28 16:01:38'),
(39, 'Hakim bin Abdul', '012-8765 268', '11-02', 'hakim@gmail.com', '$2y$10$8MpWlRsvwNjqI3n7G9Lrwe95GIoqi3yPFy6eqfjc3WcW0nVKTgGvW', '2024-11-08 11:31:54', '2024-11-08 11:40:37'),
(40, 'Priyanka A/P Rahul', '012-7832 982', '11-03', 'priyanka03@gmail.com', '$2y$10$xWEC8EkvZwKZfFz8sUcgcesM38p.LMI6QVDX25bFTgHFhTILRbX4e', '2024-11-18 23:32:42', '2024-11-19 01:42:22'),
(42, 'Nur Aisyah Binti Rahman', '011-1111 1111', '11-05', 'aisyah00@gmail.com', '$2y$10$LNfCwH4//6I2MzpvGww7WOUkZcXVnll/IDe0/8byO/qtacjkYdtZ6', '2024-11-19 14:25:34', '2024-11-19 14:41:25'),
(43, 'Syahirah Binti Syaf', '012-2389 283', '11-06', 'syahirah@gmail.com', '$2y$10$214iEtQJg1jrSSWO8Pl.EOSeNYRJB6tiuwNF/2t83KzdEUC4Sngpy', '2024-11-19 15:52:01', '2024-11-19 15:52:16'),
(44, 'Aireen binti Rosli', '012-2383 238', '11-05', 'aireen@gmail.com', '$2y$10$2uAV7ITFJ/A/aRq7vz2K4.ia3C1uQHc8p6Kq8lB12xSbNt6uGLQBC', '2024-11-19 15:56:23', '2024-11-19 15:56:35'),
(45, 'Fasya binti Ahmad', '011-2028 927', '11-06', 'fasyasya@gmail.com', '$2y$10$aKw/jkBFFvzR76XpU/4ZFu4DrCspMfFcva5LABmVMe8LDSaywvaNa', '2024-11-19 16:10:37', '2024-11-19 16:10:47'),
(47, 'Hakim bin Mohd Zaki', '014-2349 238', '11-08', 'hakimzaki@gmail.com', '$2y$10$qxAOyUkLJMmAkT1FjW6E3uq2aymuJNdZ5GpXSUF71ETbUddTbNvv.', '2024-11-28 13:06:38', '2024-11-28 19:19:22'),
(48, 'Zafera Binti Ali', '011-2839 298', '11-09', 'zafera@gmail.com', '$2y$10$bgeRnlmIGT51u9HPSkWfjuNgyoUo.g4VuJJvlWEi4ut15u48o8HUW', '2024-11-28 19:20:50', '2024-11-28 19:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `resident_profile`
--

CREATE TABLE `resident_profile` (
  `resident_id` int(11) NOT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `ic_number` varchar(20) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `race` varchar(50) DEFAULT NULL,
  `number_of_occupants` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resident_profile`
--

INSERT INTO `resident_profile` (`resident_id`, `nick_name`, `ic_number`, `age`, `gender`, `race`, `number_of_occupants`) VALUES
(1, NULL, '020222-03-1992', 22, 'Female', 'Malay', 2),
(8, NULL, '020201-06-0260', 22, 'Female', 'Malay', 6),
(11, 'Aiman Baik', '111111-11-1117', 23, 'Male', 'Malay', 2),
(17, 'Rahim', '111111-11-1111', 12, 'Male', 'Malay', 3),
(19, NULL, '921030-10-2382', 32, 'Female', 'Malay', 5),
(21, 'Melur Cantik', '111111-11-1112', 23, 'Female', 'Malay', 3),
(22, 'Adam', '111111-11-0123', 34, 'Male', 'Malay', 3),
(24, 'Abinesh Good', '010101-10-1111', 24, 'Female', 'Indian', 4),
(25, 'Priyanka Hensem', '020109-10-8435', 22, 'Male', 'Indian', 5),
(26, '', '', 0, '', '', 0),
(28, 'Aiman Hensem', '020122-03-2389', 22, 'Male', 'Malay', 7),
(29, '', '', 0, '', '', 0),
(30, '', '', 0, '', '', 0),
(31, '', '', 0, '', '', 0),
(32, '', '', 0, '', '', 0),
(33, '', '', 0, '', '', 0),
(34, 'Saarvin Baik', '040101-10-1111', 22, 'Male', 'Indian', 7),
(35, '', '', 0, '', '', 0),
(36, 'ChaCha', '000101-10-4533', 24, 'Female', 'Malay', 4),
(38, 'Yusreena', '000101-10-2340', 24, 'Female', 'Malay', 4),
(39, '', '', 0, '', '', 0),
(40, '', '010101-10-2983', 23, 'Female', 'Indian', 4),
(42, 'Aisyah Cantik', '050409-10-3233', 19, 'Female', 'Malay', 6),
(43, '', '020222-03-1992', 22, 'Female', 'Malay', 4),
(44, 'Reen', '030101-10-2183', 21, 'Female', 'Malay', 5),
(45, 'Fasyasya', '000202-10-2378', 24, 'Female', 'Malay', 6),
(47, '', '123456', 20, 'Male', 'Malay', 3),
(48, 'Era', '001130-10-2983', 24, 'Female', 'Malay', 6);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `car_color` varchar(50) NOT NULL,
  `vehicle_registration_number` varchar(50) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `parking_spot` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `registration_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `comments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `resident_id`, `brand`, `model`, `car_color`, `vehicle_registration_number`, `vehicle_type`, `parking_spot`, `image_path`, `registration_timestamp`, `status`, `comments`) VALUES
(13, 28, 'Proton Saga', 'S70', 'Blue', 'SSD 9273', 'Car', 'L2-09', 'uploads/S70.jpg', '2024-11-03 14:39:34', 'pending', NULL),
(18, 36, 'Honda', 'Civic RS', 'Grey', 'WHS 0128', 'Car', 'L2-27', 'uploads/S70.jpg', '2024-11-07 16:22:27', 'pending', NULL),
(20, 40, 'Honda', 'City Hatchback', 'Gray', 'WWC 4053', 'Car', 'L3-09', 'uploads/HONDA CITY HATCHBACK.jpeg', '2024-11-18 15:49:47', 'Approved', ''),
(21, 42, 'Honda', 'CR-V', 'Dark blue metallic', 'WSP 2038', 'Car', 'L2-07', 'uploads/WhatsApp Image 2024-11-19 at 2.22.59 PM.jpeg', '2024-11-19 06:33:29', 'Rejected', 'Parking lot already taken. Please choose a different parking lot.'),
(23, 45, 'Honda', 'CR-V', 'Dark blue metallic', 'JSO 2903', 'Car', 'L5-34', 'uploads/WhatsApp Image 2024-11-19 at 2.22.59 PM.jpeg', '2024-11-19 08:15:04', 'Rejected', 'Parking lot already taken. Please choose a different parking lot.'),
(26, 47, 'Toyota', 'Alphard', 'Black', 'MA 1380', 'Car', 'L3A-09', 'uploads/Screenshot 2024-11-28 131358.png', '2024-11-28 05:14:09', 'Approved', ''),
(27, 48, 'Honda', 'Civic RS', 'Grey', 'GSD 5675', 'Car', 'L2-56', 'uploads/Honda-Civic-RS-Prototype-unveiled-Tokyo-Auto-Salon-2024.jpg', '2024-11-28 11:44:46', 'pending', NULL),
(28, 48, 'Honda', 'Civic RS', 'Black', 'SFG 5645', 'Car', 'L2-34', 'uploads/Honda-Civic-RS-Prototype-unveiled-Tokyo-Auto-Salon-2024.jpg', '2024-11-28 11:45:39', 'Approved', ''),
(29, 48, 'Honda', 'Civic RS', 'Red', 'VHG 8032', 'Car', 'L2-32', 'uploads/2022-Honda-Civic-RS-Penang-1.jpg', '2024-11-28 11:46:37', 'Rejected', 'Parking lot already taken. Please choose a different parking lot.');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `visitor_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `visitor_name` varchar(255) NOT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `nric` varchar(50) DEFAULT NULL,
  `vehicle_registration_number` varchar(50) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `number_of_visitors` int(11) DEFAULT NULL,
  `purpose_of_visit` varchar(255) DEFAULT NULL,
  `date_of_visit` date DEFAULT NULL,
  `time_of_visit` time DEFAULT NULL,
  `registration_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'pending',
  `comments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`visitor_id`, `resident_id`, `visitor_name`, `phone_number`, `nric`, `vehicle_registration_number`, `company_name`, `number_of_visitors`, `purpose_of_visit`, `date_of_visit`, `time_of_visit`, `registration_timestamp`, `status`, `comments`) VALUES
(19, 25, 'Tahir bin Rafizi', '011-8423 933', '950103-11-4938', 'WTC 2344', 'Unifi', 2, 'Wi-Fi Installation', '2024-11-11', '10:00:00', '2024-11-01 15:45:39', 'Rejected', 'FULL'),
(20, 25, 'Raju', '018-0128 912', '920131-03-8179', 'PDP 2383', 'Unifi', 2, 'Wi-Fi Installation', '2024-11-12', '11:40:00', '2024-11-01 15:51:34', 'pending', ''),
(21, 25, 'Raju', '018-0128 912', '920131-03-8179', 'WTC 2344', 'Unifi', 2, 'Wi-Fi Installation', '2024-11-02', '02:05:00', '2024-11-01 18:05:43', 'Approved', ''),
(22, 28, 'Li Wei', '018-2579 298', '950103-11-7234', 'PPF 2349', 'Unifi', 1, 'Wi-Fi Installation', '2024-11-12', '10:20:00', '2024-11-02 11:20:46', 'Under Review', 'The date and time already full, please choose other time. Please submit new form!'),
(23, 28, 'Raju', '018-0128 912', '920131-03-8179', 'JSH 8921', 'Unifi', 1, 'Wi-Fi Installation', '2024-11-20', '12:00:00', '2024-11-02 15:00:36', 'Rejected', 'FULL'),
(24, 28, 'Tahir bin Rafizi', '011-8423 933', '950103-11-4938', 'WTC 2344', 'Unifi', 2, 'Wi-Fi Installation', '2024-11-22', '12:20:00', '2024-11-02 15:02:04', 'Approved', ''),
(25, 29, 'Abu bin Ali ', '013-9876 543', '991231-12-3456', 'ABC 1234', 'Tech Solutions', 1, 'Maintenance Check', '2024-11-12', '15:00:00', '2024-11-04 09:04:19', 'Approved', ''),
(27, 35, 'Raju', '018-0128 912', '920131-03-8179', 'KLC 3948', 'Unifi', 1, 'Wi-Fi Installation', '2024-11-06', '14:10:00', '2024-11-06 04:09:13', 'Rejected', 'full booked'),
(28, 36, 'Abu bin Ali ', '013-9876 543', '920323-10-2332', 'WHS 0128', 'Tech Solutions', 1, 'Maintenance Check', '2024-11-22', '12:00:00', '2024-11-07 15:45:35', 'pending', NULL),
(29, 36, 'Azlan Shah Bin Abdul Rahman', '011-2339 839', '891130-03-2308', 'PYH 0349', 'Tech Solutions', 1, 'Maintenance Check', '2024-11-12', '12:20:00', '2024-11-07 16:21:38', 'Rejected', ''),
(30, 40, 'Rahim bin Abu Bakar', '011-9282 827', '920329-03-1111', 'FPP 3937', 'Coway', 2, 'Service Coway', '2024-11-22', '10:00:00', '2024-11-18 15:41:42', 'Rejected', 'Full booked. Please choose another date. '),
(31, 42, 'Muqriz bin Ahmad', '011-9374 937', '950129-03-0282', 'JJP 3947', 'Unifi', 1, 'Wi-Fi Installation', '2024-11-22', '10:30:00', '2024-11-19 06:29:31', 'Rejected', 'Full booked. Please choose other date and time. '),
(32, 44, 'Shahrul bin Abu', '011-2378 892', '890327-10-3282', 'WSP 4930', 'Coway', 1, 'Service Coway', '2024-11-22', '10:00:00', '2024-11-19 07:59:05', 'Rejected', 'Full booked. Please choose other date and time. '),
(36, 47, 'Syafiq bin Syukur', '011-3498 348', '880927-10-2348', 'SJD 3984', 'Time', 1, 'Wi-Fi Installation', '2024-12-02', '10:00:00', '2024-11-28 05:08:56', 'Rejected', 'Full booked. Please choose other date and time. '),
(37, 48, 'Shahmim Bin Azad', '011-2380 298', '920525-04-9210', 'POQ 2109', 'Time', 1, 'Wi-Fi Installation', '2024-12-03', '09:40:00', '2024-11-28 11:38:32', 'pending', NULL),
(38, 48, 'Abu bin Ahmad', '011-2309 092', '900525-04-5757', 'SDI 2309', 'Coway', 2, 'Coway Service', '2024-12-06', '22:40:00', '2024-11-28 11:39:57', 'Approved', ''),
(39, 48, 'Azad bin Ali', '012-2383 295', '890525-10-4566', 'GSD 4654', 'Time', 1, 'Wi-Fi Installation', '2024-12-03', '12:00:00', '2024-11-28 11:41:16', 'Rejected', 'Full booked. Please choose other date and time. ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenity_usage`
--
ALTER TABLE `amenity_usage`
  ADD PRIMARY KEY (`usage_id`),
  ADD KEY `amenity_usage_ibfk_1` (`resident_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `announcement_units`
--
ALTER TABLE `announcement_units`
  ADD PRIMARY KEY (`announcement_id`,`resident_id`),
  ADD KEY `announcement_units_ibfk_2` (`resident_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaint_id`),
  ADD KEY `complaints_ibfk_1` (`resident_id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `login_history_ibfk_1` (`resident_id`);

--
-- Indexes for table `resident_account`
--
ALTER TABLE `resident_account`
  ADD PRIMARY KEY (`resident_id`),
  ADD UNIQUE KEY `idx_email` (`email`);

--
-- Indexes for table `resident_profile`
--
ALTER TABLE `resident_profile`
  ADD PRIMARY KEY (`resident_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD KEY `vehicles_ibfk_1` (`resident_id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`visitor_id`),
  ADD KEY `visitors_ibfk_1` (`resident_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenity_usage`
--
ALTER TABLE `amenity_usage`
  MODIFY `usage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `resident_account`
--
ALTER TABLE `resident_account`
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `visitor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amenity_usage`
--
ALTER TABLE `amenity_usage`
  ADD CONSTRAINT `amenity_usage_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident_account` (`resident_id`) ON DELETE CASCADE;

--
-- Constraints for table `announcement_units`
--
ALTER TABLE `announcement_units`
  ADD CONSTRAINT `announcement_units_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`announcement_id`),
  ADD CONSTRAINT `announcement_units_ibfk_2` FOREIGN KEY (`resident_id`) REFERENCES `resident_account` (`resident_id`) ON DELETE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident_account` (`resident_id`) ON DELETE CASCADE;

--
-- Constraints for table `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `login_history_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident_account` (`resident_id`) ON DELETE CASCADE;

--
-- Constraints for table `resident_profile`
--
ALTER TABLE `resident_profile`
  ADD CONSTRAINT `resident_profile_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident_account` (`resident_id`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident_account` (`resident_id`) ON DELETE CASCADE;

--
-- Constraints for table `visitors`
--
ALTER TABLE `visitors`
  ADD CONSTRAINT `visitors_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident_account` (`resident_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
