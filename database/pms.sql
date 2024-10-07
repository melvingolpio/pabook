-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2024 at 11:33 PM
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
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `plate_number` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `slot_number` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `plate_number`, `user_id`, `date`, `time_in`, `time_out`, `status`, `slot_number`, `slot_id`) VALUES
(74, '87AIW', 0, '2024-08-20', '07:39:30', '07:49:00', 'out', NULL, 27),
(76, '87AIW', 54, '2024-08-20', '08:00:37', '08:00:59', 'out', NULL, 26),
(79, '87AIW', 54, '2024-08-20', '08:09:10', '08:10:35', 'out', NULL, 37),
(91, '64JNW', 54, '2024-08-20', '19:49:27', '19:59:51', 'out', NULL, 39),
(93, '64JNW', 54, '2024-08-20', '20:17:18', '20:17:29', 'out', NULL, 39),
(94, '64JNW', 54, '2024-08-20', '20:17:57', '20:18:15', 'out', NULL, 43),
(95, '64JNW', 54, '2024-08-20', '20:18:38', '20:18:52', 'out', NULL, 49),
(96, '5W80', 54, '2024-08-20', '20:19:21', '20:27:38', 'out', NULL, 4),
(97, '5W80', 54, '2024-08-20', '20:37:26', '20:54:26', 'out', NULL, 6),
(100, 'WI014A', 55, '2024-08-21', '04:57:28', '04:58:13', 'out', NULL, 1),
(101, 'WI014A', 55, '2024-08-21', '05:33:09', '05:34:48', 'out', NULL, 1),
(103, '35WWQ', 54, '2024-08-23', '19:36:29', '19:42:53', 'out', NULL, 3),
(105, 'sample3', 56, '2024-08-23', '21:19:05', '21:19:40', 'out', NULL, 30),
(106, 'president', 58, '2024-08-25', '02:28:35', '02:29:14', 'out', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` int(11) NOT NULL,
  `plate_number` varchar(255) NOT NULL,
  `receipt_token` varchar(255) NOT NULL,
  `expiration_date` timestamp NULL DEFAULT NULL,
  `qr_code` blob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`id`, `plate_number`, `receipt_token`, `expiration_date`, `qr_code`, `created_at`, `user_id`) VALUES
(81, 'W45WIW', '349bb162db9b9a201b6f013a2cc4443c', '2026-08-25 11:48:09', 0x7172636f646573322f5734355749575f7172636f64652e706e67, '2024-08-25 11:48:09', 54),
(82, 'RED', '457932a3a9ee466c8167e3f7b6bc6c2b', '2025-08-25 11:50:48', 0x7172636f646573322f5245445f7172636f64652e706e67, '2024-08-25 11:50:48', 54),
(83, 'president', 'a186b8e96c451182e22506539e8fdc0f', '2025-08-25 12:04:35', 0x7172636f646573322f707265736964656e745f7172636f64652e706e67, '2024-08-25 12:04:35', 58),
(84, 'EGM43A', '61de7149e42e72b0e42424b3812f216a', '2025-08-27 13:13:44', 0x7172636f646573322f45474d3433415f7172636f64652e706e67, '2024-08-27 13:13:44', 54),
(85, 'waoj', '273df840f8eac7fe1146cf89d3c13ec0', '2025-08-27 13:13:52', 0x7172636f646573322f77616f6a5f7172636f64652e706e67, '2024-08-27 13:13:52', 54),
(86, '3KIVFW2', '999c97aba0e52e9877a1c0bbbeff0f25', '2025-08-27 13:14:20', 0x7172636f646573322f334b49564657325f7172636f64652e706e67, '2024-08-27 13:14:20', 56),
(87, 'KEJ3351', '16718e73c753353ce37cc89bbc3980ef', '2025-08-27 13:14:27', 0x7172636f646573322f4b454a333335315f7172636f64652e706e67, '2024-08-27 13:14:27', 54),
(88, '00000000000', 'b23a6e1dde0131bc63f23d5dfaed4186', '2025-09-03 05:18:31', 0x7172636f646573322f30303030303030303030305f7172636f64652e706e67, '2024-09-03 05:18:31', 55),
(89, '1111111111111111111', '7855e26420597bdd202a5b23e6800d7e', '2025-09-03 06:20:58', 0x7172636f646573322f313131313131313131313131313131313131315f7172636f64652e706e67, '2024-09-03 06:20:58', 59);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `plate_number` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `slot_number` int(11) DEFAULT NULL,
  `reservation_date` datetime DEFAULT current_timestamp(),
  `status` enum('reserved','available','occupied','expired') DEFAULT 'available',
  `expiry_time` time DEFAULT NULL,
  `slot_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `plate_number`, `vehicle_type`, `slot_number`, `reservation_date`, `status`, `expiry_time`, `slot_id`, `user_id`) VALUES
(522, 'president', '4_wheel', 1, '2024-08-25 05:38:31', 'reserved', '23:59:59', 1, 58),
(523, 'RED', '4_wheel', NULL, '2024-08-25 05:43:34', 'expired', '00:00:00', 3, 54),
(525, 'EGM43A', '2_wheel', NULL, '2024-08-27 06:17:46', 'expired', '00:00:00', 42, 54),
(527, 'KEJ3351', '3_wheel', NULL, '2024-08-27 06:24:08', 'expired', '00:00:00', 30, 54),
(528, 'KEJ3351', '3_wheel', NULL, '2024-08-27 06:29:21', 'expired', '00:00:00', 29, 54),
(529, 'RED', '4_wheel', NULL, '2024-08-27 06:32:24', 'expired', '00:00:00', 3, 54);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `type` enum('Admin','User') NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `account_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `penalty` decimal(10,2) DEFAULT 0.00,
  `restricted` tinyint(1) DEFAULT 0,
  `disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `birth_date`, `gender`, `contact_number`, `type`, `role`, `username`, `password`, `email`, `image`, `account_created_at`, `penalty`, `restricted`, `disabled`) VALUES
(5, 'Pabook', 'ka?', '1935-12-25', 'Male', '099999', 'Admin', NULL, 'Melucky', '$2y$10$MODpXAJ/A4UGLD6BzPClr.utMGN/smjQMHZO0wARDDxLv4nFe8xIm', 'Melucky@gmail.com', 'working.png', '2024-09-04 18:52:18', NULL, 0, 0),
(54, 'Yong', 'Flores', '2024-10-03', 'Male', '99564575', 'User', 'security', 'jaspherflores', '$2y$10$nJ1YkIrQhzuH7DMAxFda0uvoYlzBLlNzsgaFmWr4wf23y4V6/Zb1.', 'jaspherflores@gmail.com', 'cancer.jpg', '2024-09-04 18:52:18', 75.00, 1, 0),
(55, 'sample', 'sample', '0000-00-00', 'Male', '9999', 'User', 'president', 'sample', '$2y$10$i.oeV4xiMh1SLy8gUWJ7Be//AW2nJtpxppms.BCt81maO/OwnT.n.', 'sample.@gmail.com', 'users.jpg', '2024-09-04 18:52:18', 0.00, 0, 0),
(56, 'sample2', 'sample2', '0000-00-00', 'Male', '099999', 'User', 'staff', 'sample2', '$2y$10$6WH6xLcvP6oCSMFW0TKhFuz7OT5yPASKTTu/RVHoiYDVGY.FbVHfK', 'sample2@gmail.com', 'users.jpg', '2024-09-04 18:52:18', 0.00, 0, 1),
(57, 'sample0', 'sample0', '0000-00-00', 'Male', '0999999', 'User', 'vice_president', 'sample0', '$2y$10$1iBpIhZnhVUmtoS/7hDo6OTyBEN/xIRtIbCTXLn5yhwGWvPucATNm', 'sample0Q@gmail.com', 'users.jpg', '2024-09-04 18:52:18', 0.00, 0, 0),
(58, 'president', 'president', '0000-00-00', 'Female', '0999999', 'User', 'president', 'president', '$2y$10$KYrB6fJaR3fDhdFEuOKWK.f7WFp5YhHfwGOpSpes2gm3DIRjgiOAK', 'president@gmail.com', 'users.jpg', '2024-09-04 18:52:18', 0.00, 0, 0),
(59, 'user', 'user', '0000-00-00', 'Male', '099999', 'User', 'faculty', 'user', '$2y$10$D6yoeCzhywBe1GaSn898xuvmeZLEDzMOK5jleCXXC8B/07yzzbeZS', 'user@gmail.com', 'users.jpg', '2024-09-04 18:52:18', 0.00, 0, 0),
(60, 'vicepresident', 'vicepresident', '0000-00-00', 'Male', '9999999', 'User', 'vice_president', 'vicepresident', '$2y$10$jUySJbO1vxKBKTNBC5RoWOA.jhzP5FjioFAHqRLlQPg9fGHBo/tke', 'vicepresident@gmail.com', 'users.jpg', '2024-09-04 18:52:18', 0.00, 0, 0),
(61, 'samplelang', 'samplelang', '0000-00-00', 'Male', '099999', 'User', 'faculty', 'samplelang', '$2y$10$OGVESwcZruxAF/RneuOucu7s5P3LJz0JtZYWnsHjFWk.BQ4kxndzW', 'samplelang@gmail.com', 'users.jpg', '2024-09-04 18:52:18', 0.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `plate_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vehicle_brand` varchar(255) NOT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `color` varchar(50) NOT NULL,
  `lto_registration` blob DEFAULT NULL,
  `vehicle_picture` blob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `paid` varchar(255) DEFAULT NULL,
  `amount` int(255) DEFAULT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`plate_number`, `user_id`, `vehicle_brand`, `vehicle_type`, `color`, `lto_registration`, `vehicle_picture`, `created_at`, `paid`, `amount`, `paid_at`) VALUES
('00000000000', 55, 'LAMBORGINI', '4_wheel', 'RAINBOW', '', '', '2024-09-02 20:17:57', NULL, NULL, '2024-09-04 19:24:26'),
('1111111111111111111', 59, 'MUSTANG', '4_wheel', 'RED', '', '', '2024-09-02 21:20:44', '1', 1200, '2024-09-04 19:24:26'),
('3KIVFW2', 56, 'sample2', '2_wheel', 'red', '', '', '2024-08-27 04:09:23', NULL, NULL, '2024-09-04 19:24:26'),
('EGM43A', 54, 'toyota', '2_wheel', 'red', '', '', '2024-08-27 04:12:57', '1', 600, '2024-09-04 19:24:26'),
('KEJ3351', 54, 'Mercidis', '3_wheel', 'griy', 0x2e2e2f75706c6f6164732f74756e696e672e706e67, 0x2e2e2f75706c6f6164732f74756e696e672e706e67, '2024-08-25 02:44:30', '1', 600, '2024-09-04 19:24:26'),
('president', 58, 'president', '4_wheel', 'president', '', '', '2024-08-25 03:03:44', NULL, NULL, '2024-09-04 19:24:26'),
('RED', 54, 'RED', '4_wheel', 'RED', 0x2e2e2f75706c6f6164732f74756e696e672e706e67, 0x2e2e2f75706c6f6164732f74756e696e672e706e67, '2024-08-25 02:45:02', '1', 1200, '2024-09-04 19:24:26'),
('W45WIW', 54, 'Inubishe', '4_wheel', 'rid', 0x2e2e2f75706c6f6164732f74756e696e672e706e67, 0x2e2e2f75706c6f6164732f636d752e6a7067, '2024-08-25 02:43:20', '1', 1200, '2024-09-04 19:24:26'),
('waoj', 54, 'waoj', '4_wheel', 'waoj', '', '', '2024-08-25 03:01:48', '1', 1200, '2024-09-04 19:24:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_plate_number` (`plate_number`),
  ADD UNIQUE KEY `unique_plate_token` (`plate_number`,`receipt_token`),
  ADD UNIQUE KEY `plate_number` (`plate_number`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`plate_number`,`slot_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_type` (`type`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`plate_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=530;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `receipts`
--
ALTER TABLE `receipts`
  ADD CONSTRAINT `fk_vehicle_plate` FOREIGN KEY (`plate_number`) REFERENCES `vehicle` (`plate_number`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_plate_number` FOREIGN KEY (`plate_number`) REFERENCES `vehicle` (`plate_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
