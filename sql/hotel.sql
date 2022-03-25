-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 25, 2022 at 10:37 AM
-- Server version: 8.0.28
-- PHP Version: 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `booking_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_detail_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `room_id` int NOT NULL,
  `payment_id` int DEFAULT NULL,
  `status` enum('RESERVED','CHECK_IN','CHECK_OUT','CANCEL','WAIT_PAY') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `created_user_id` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` int NOT NULL,
  `date_in` date NOT NULL,
  `date_out` date NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_user_id` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `deposit` decimal(8,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_user_id` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int NOT NULL,
  `room_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_price` decimal(10,2) NOT NULL,
  `room_type` enum('STANDARD','SUPEIROR','DELUXE','SUITE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bed_type` enum('SINGLE_BEDDED','TWIN_BEDDED','DOUBLE_BEDDED','TRIPLE_BEDDED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_user_id` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_price`, `room_type`, `bed_type`, `created_at`, `created_user_id`, `updated_at`, `updated_user_id`) VALUES
(1, 'A1', '950.00', 'STANDARD', 'SINGLE_BEDDED', '2022-02-22 16:22:59', 1, '2022-02-22 16:22:59', 1),
(2, 'A2', '970.00', 'STANDARD', 'TWIN_BEDDED', '2022-02-22 16:22:59', 1, '2022-02-22 16:22:59', 1),
(3, 'A3', '1100.00', 'SUPEIROR', 'TWIN_BEDDED', '2022-02-22 16:44:19', 1, '2022-02-22 16:44:19', 1),
(4, 'A4', '1100.00', 'SUPEIROR', 'DOUBLE_BEDDED', '2022-02-22 16:44:19', 1, '2022-02-22 16:44:19', 1),
(5, 'A5', '1390.00', 'DELUXE', 'DOUBLE_BEDDED', '2022-02-22 16:45:13', 1, '2022-02-22 16:45:13', 1),
(6, 'A6', '1390.00', 'DELUXE', 'TWIN_BEDDED', '2022-02-22 16:45:13', 1, '2022-02-22 16:45:13', 1),
(7, 'A7', '1690.00', 'SUITE', 'TRIPLE_BEDDED', '2022-02-22 16:46:15', 1, '2022-02-22 16:46:15', 1),
(8, 'A8', '1500.00', 'SUITE', 'TWIN_BEDDED', '2022-02-22 16:46:15', 1, '2022-02-22 16:46:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role_id` int NOT NULL,
  `locale` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint NOT NULL,
  `created_at` datetime NOT NULL,
  `created_user_id` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `address`, `email`, `user_role_id`, `locale`, `enabled`, `created_at`, `created_user_id`, `updated_at`, `updated_user_id`) VALUES
(1, 'admin', '$2y$10$AG.ltxsSn6jfR1wveS7jreu9eWIz.qou9sBjA3OLa3FWUnKKg/5Ta', 'admin', 'admin', '', '', 1, 'admin', 0, '2022-02-22 13:19:53', 1, '2022-02-22 13:19:53', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
