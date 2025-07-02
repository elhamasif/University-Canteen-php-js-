-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 02, 2025 at 07:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university_canteen`
--

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `canteen` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('snacks','heavy-meal','appetizer','drinks') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `canteen`, `name`, `type`, `price`, `description`, `image`, `status`) VALUES
(9, 'south-campus', 'pasta', 'heavy-meal', 300.00, 'Oven Backed Chicken Pasta', 'uploads/678b6c946c995_pasta.webp', 1),
(10, 'central', 'Dosa', 'snacks', 50.00, 'delicious', 'uploads/67a9aa3915596_images (3).jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `items` text NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `final_total` decimal(10,2) NOT NULL,
  `timestamp` datetime NOT NULL,
  `room_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `username`, `order_number`, `items`, `subtotal`, `discount`, `final_total`, `timestamp`, `room_number`) VALUES
(1, '', 'ORD-678b8220d7410', '{\"6\":{\"name\":\"Pizza\",\"price\":\"330.00\",\"image\":\"uploads\\/678b567eedc5e_pizza.jpg\",\"quantity\":1},\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":2},\"9\":{\"name\":\"pasta\",\"price\":\"300.00\",\"image\":\"uploads\\/678b6c946c995_pasta.webp\",\"quantity\":1}}', 1070.00, 321.00, 749.00, '2025-01-18 16:27:44', NULL),
(2, 'sad', 'ORD-678b8628512e5', '{\"6\":{\"name\":\"Pizza\",\"price\":\"330.00\",\"image\":\"uploads\\/678b567eedc5e_pizza.jpg\",\"quantity\":1},\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":1}}', 550.00, 165.00, 385.00, '2025-01-18 16:44:56', NULL),
(3, 'sad', 'ORD-678b86a88dd62', '{\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":\"3\"}}', 660.00, 264.00, 396.00, '2025-01-18 16:47:04', NULL),
(4, 'sad', 'ORD-678b904d59273', '{\"6\":{\"name\":\"Pizza\",\"price\":\"330.00\",\"image\":\"uploads\\/678b567eedc5e_pizza.jpg\",\"quantity\":1}}', 330.00, 99.00, 231.00, '2025-01-18 17:28:13', NULL),
(5, 'sad', 'ORD-678b933b0bfe0', '{\"6\":{\"name\":\"Pizza\",\"price\":\"330.00\",\"image\":\"uploads\\/678b567eedc5e_pizza.jpg\",\"quantity\":1}}', 330.00, 99.00, 231.00, '2025-01-18 17:40:43', NULL),
(6, 'sad', 'ORD-678ba0064be52', '{\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":1}}', 220.00, 0.00, 220.00, '2025-01-18 18:35:18', NULL),
(7, 'rad', 'ORD-678ba8fd6b435', '{\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":\"1\"},\"9\":{\"name\":\"pasta\",\"price\":\"300.00\",\"image\":\"uploads\\/678b6c946c995_pasta.webp\",\"quantity\":2},\"6\":{\"name\":\"Pizza\",\"price\":\"330.00\",\"image\":\"uploads\\/678b567eedc5e_pizza.jpg\",\"quantity\":1}}', 1150.00, 0.00, 1150.00, '2025-01-18 19:13:33', NULL),
(8, 'rad', 'ORD-678baa6308575', '{\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":1}}', 220.00, 0.00, 220.00, '2025-01-18 19:19:31', NULL),
(9, 'rad', 'ORD-678bafac65dc3', '{\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":1}}', 220.00, 0.00, 220.00, '2025-01-18 19:42:04', '100'),
(10, 'rad', 'ORD-678bb245f0d54', '{\"6\":{\"name\":\"Pizza\",\"price\":\"330.00\",\"image\":\"uploads\\/678b567eedc5e_pizza.jpg\",\"quantity\":\"3\"}}', 990.00, 297.00, 693.00, '2025-01-18 19:53:09', 'd211'),
(11, 'rad', 'ORD-678bb297aacc8', '{\"6\":{\"name\":\"Pizza\",\"price\":\"330.00\",\"image\":\"uploads\\/678b567eedc5e_pizza.jpg\",\"quantity\":1}}', 330.00, 0.00, 330.00, '2025-01-18 19:54:31', 'd211'),
(12, 'rad', 'ORD-678bb4bd9aad5', '{\"9\":{\"name\":\"pasta\",\"price\":\"300.00\",\"image\":\"uploads\\/678b6c946c995_pasta.webp\",\"quantity\":1}}', 300.00, 0.00, 300.00, '2025-01-18 20:03:41', NULL),
(13, 'itsme', 'ORD-678bd1c88e5c9', '{\"6\":{\"name\":\"Pizza\",\"price\":\"330.00\",\"image\":\"uploads\\/678b567eedc5e_pizza.jpg\",\"quantity\":1},\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":1}}', 550.00, 165.00, 385.00, '2025-01-18 22:07:36', NULL),
(14, 'sad', 'ORD-678bf36fd5f97', '{\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":\"2\"}}', 440.00, 0.00, 440.00, '2025-01-19 00:31:11', NULL),
(15, 'sad', 'ORD-678bf4600af7b', '{\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":\"2\"}}', 440.00, 0.00, 440.00, '2025-01-19 00:35:12', NULL),
(16, 'Md. Deniad Alam', 'ORD-678ce44acf6ad', '{\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":1}}', 220.00, 132.00, 88.00, '2025-01-19 17:38:50', NULL),
(17, 'rad', 'ORD-678ce56618bb4', '{\"9\":{\"name\":\"pasta\",\"price\":\"300.00\",\"image\":\"uploads\\/678b6c946c995_pasta.webp\",\"quantity\":1}}', 300.00, 120.00, 180.00, '2025-01-19 17:43:34', NULL),
(18, 'rad', 'ORD-678ce5ac3e6a7', '{\"6\":{\"name\":\"Pizza\",\"price\":\"330.00\",\"image\":\"uploads\\/678b567eedc5e_pizza.jpg\",\"quantity\":1},\"9\":{\"name\":\"pasta\",\"price\":\"300.00\",\"image\":\"uploads\\/678b6c946c995_pasta.webp\",\"quantity\":1}}', 630.00, 252.00, 378.00, '2025-01-19 17:44:44', NULL),
(19, 'rad', 'ORD-678cea14e1736', '{\"6\":{\"name\":\"Pizza\",\"price\":\"330.00\",\"image\":\"uploads\\/678b567eedc5e_pizza.jpg\",\"quantity\":1}}', 330.00, 0.00, 330.00, '2025-01-19 18:03:32', NULL),
(20, 'rad', 'ORD-678cf1afd5262', '{\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":1}}', 220.00, 0.00, 220.00, '2025-01-19 18:35:59', NULL),
(21, 'rad', 'ORD-678cf2eb77855', '{\"8\":{\"name\":\"burger\",\"price\":\"220.00\",\"image\":\"uploads\\/678b6bc8d5967_burger.webp\",\"quantity\":1}}', 220.00, 0.00, 220.00, '2025-01-19 18:41:15', 'csdc'),
(22, 'sad', 'ORD-67a9b6e741e3c', '{\"9\":{\"name\":\"pasta\",\"price\":\"300.00\",\"image\":\"uploads\\/678b6c946c995_pasta.webp\",\"quantity\":1}}', 300.00, 0.00, 300.00, '2025-02-10 14:20:55', ''),
(23, 'abc', 'ORD-682587ba472fd', '{\"9\":{\"name\":\"pasta\",\"price\":\"300.00\",\"image\":\"uploads\\/678b6c946c995_pasta.webp\",\"quantity\":\"1\"}}', 300.00, 0.00, 300.00, '2025-05-15 12:20:42', '');

-- --------------------------------------------------------

--
-- Table structure for table `special_items`
--

CREATE TABLE `special_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `special_items`
--

INSERT INTO `special_items` (`id`, `name`, `price`, `description`, `image`) VALUES
(7, 'Pizza', 330.00, '12\" chicken pizza', 'uploads/678b567eedc5e_pizza.jpg'),
(9, 'burger', 220.00, 'good and delicious chicken burger', 'uploads/678b6bc8d5967_burger.webp'),
(10, 'pasta', 300.00, 'Oven Backed Chicken Pasta', 'uploads/678b6c946c995_pasta.webp');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('student','faculty','staff') NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `profile_picture`, `created_at`) VALUES
(1, 'asif', '22-46638-1@student.aiub.edu', '$2y$10$uRKHQ6irjdT/5u1L0HPDw.h.cRyIWtV6ibBJwrFDoxebI8sj31Tt.', 'student', 'userimages/6789351341236_Jungle Book.jpg', '2025-01-16 16:34:27'),
(6, 'a', 'sadikelham69@gmail.com', '$2y$10$N2ROfY7h3LMGuOZ.pV7p2uaduZpKNkOgCudQCmuDMrAbZXZUDX8/u', 'staff', 'userimages/678937af2e6fb_Jungle Book.jpg', '2025-01-16 16:45:35'),
(17, 'asifhugibknl', '22-46688-1@student.aiub.edu', '$2y$10$pkay0NugfQWFO0/SbupvBOTmSVaqwEeaOq6VLFuNFa6GGcf11R0Zq', 'faculty', 'userimages/6789399777bfe_Jungle Book.jpg', '2025-01-16 16:53:43'),
(18, 'asifaa', '22-47688-1@student.aiub.edu', '$2y$10$iaEvPaDM5AbMcCx6Tq4tE.eIq820/aXy7NU0hbpUgXM4kJR9wM3bS', 'faculty', 'userimages/67893aec6d888_Information Technology.jpeg', '2025-01-16 16:59:24'),
(19, 'sadik', 's@gmail.com', '$2y$10$FcjUodoIbOzIDe7Egk8MwuS0L1NIKi/N/lFOGiHuJmEIG8dk.O3pu', 'staff', 'userimages/67893b2da6a65_the-nature-of-technology.jpg', '2025-01-16 17:00:29'),
(20, 'asifsadik', '22-46648-1@student.aiub.edu', '$2y$10$sE3.Nmz7SOOJLppHV9HMie0QUan2EHPFKg4UGecmmLlEQSQgYatL6', 'staff', 'userimages/678a8e28edec1_indian-food.jpg', '2025-01-17 17:06:48'),
(21, 'shafin', 'sa@gmail.com', '$2y$10$L3OgXw0E95lMITDBWYOq0u6VUdJPC.nN/xYXrmzIC92nW6VbxNTnq', 'staff', 'userimages/678a8e8f3b7b1_history.jpg', '2025-01-17 17:08:31'),
(22, 'd', 'd@gmail.com', '$2y$10$RGktfQcLvrpjD0AIxIldE.57TXXOD1dSyzs.KTtX5r2CA5kpkYv.2', 'student', 'userimages/678a8f25c322c_Image1_-Puran-Poli-1024x538.jpg', '2025-01-17 17:11:01'),
(23, 'sad', 'sad@gmail.com', '$2y$10$4M/Bjfk8f/h3eO7qbCN5nOopLWrwYgN96uIMu4.U8ASSD5zvSvkqa', 'student', 'userimages/678a9d615ef91_images (3).jpeg', '2025-01-17 18:11:45'),
(24, 'rad', 'r@gmail.com', '$2y$10$scPCFBuaxw3uyuJMPcN6zOER2fvpjzvIM7EZuF.ceowhsKeqQBmmi', 'faculty', 'userimages/678b9c6618a78_pasta.webp', '2025-01-18 12:19:20'),
(25, 'itsme', 'itsme@gmail.com', '$2y$10$KVIsI5t334FIsX5x1m7lHOifIvVF0tlT87F5GJCEUeOnrrrZL7cr.', 'student', 'userimages/678bd05d6d9e9_pizza.jpg', '2025-01-18 16:01:33'),
(26, 'bad', 'bad@gmail.com', '$2y$10$efYMgTblsJTxyry/B99lleMhsqnMJODmM2JypyV2vINc3bU3H1wmi', 'student', NULL, '2025-01-18 19:28:25'),
(27, 'cat', 'cat@gmail.com', '$2y$10$tmd7F.YOJYR.5QiLq3sTteGlO1Xttn2WjCfNlFxO5D/BHpH3jz3f6', 'student', 'userimages/678c022dde75b_cover2.jpg', '2025-01-18 19:32:59'),
(28, 'Md. Deniad Alam', 'deniadalam87@gmail.com', '$2y$10$PFAWEqsA98LOWUan7OANLu3HZWk.B76.om.8JhkieY252OoErSlJ2', 'student', NULL, '2025-01-19 11:35:17'),
(29, 'sadmad', 'sadmad@gmail.com', '$2y$10$/aTD3WJKLWOk1IlEY708qeNkyI059yQnoFT9sGHGvxodHjIio/jiu', 'student', 'userimages/67a8449d71024_Book_That_Change_History.jpg', '2025-02-09 06:01:01'),
(30, 'araf', 'araf@gmail.com', '$2y$10$lafQ15ESpN60qq9rRIJ5eeguc1IalS75GoUHcKin6sVnVoMFdH7fi', 'staff', 'userimages/67a8494f4f257_burger.webp', '2025-02-09 06:21:03'),
(31, 'abc', 'abc@gmail.com', '$2y$10$CLXRxwIJM9uBJmliz/Dwne5vPh1h6H0mCRi/9pEovlrZ8MFbAHZwK', 'student', 'userimages/6825877a7da15_IMG_3559.HEIC', '2025-05-15 06:19:38');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_percentage` int(11) NOT NULL CHECK (`discount_percentage` between 1 and 100),
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `discount_percentage`, `image`, `created_at`) VALUES
(19, 'code40', 40, 'uploads/vouchers/Image1_-Puran-Poli-1024x538.jpg', '2025-02-09 06:25:36'),
(20, 'co0de30', 30, 'uploads/vouchers/burger.webp', '2025-02-09 07:07:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`);

--
-- Indexes for table `special_items`
--
ALTER TABLE `special_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `special_items`
--
ALTER TABLE `special_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
