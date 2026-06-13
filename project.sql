-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2026 at 07:59 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `user_id`, `category_id`, `title`, `slug`, `thumbnail`, `description`, `status`, `created_at`) VALUES
(25, 10, 9, 'Exploring PHP Basics', 'exploring-php-basics', 'image/1781160378.png', 'A beginner-friendly guide to PHP syntax, variables, and loops. Perfect for those starting backend development.', 'approved', '2026-06-11 06:46:18'),
(26, 10, 10, 'Healthy Cooking Tips', 'healthy-cooking-tips', 'image/1781160425.png', 'Learn how to prepare quick, nutritious meals with simple ingredients. Includes recipes and cooking hacks.', 'approved', '2026-06-11 06:47:05'),
(27, 10, 11, 'Travel to Ireland', 'travel-to-ireland', 'image/1781160459.png', 'Discover the beauty of Downpatrick Head and other scenic spots in Ireland. A complete travel diary.', 'approved', '2026-06-11 06:47:39'),
(28, 11, 13, 'Morning Fitness Routine', 'morning-fitness-routine', 'image/1781160746.png', 'A 20-minute workout plan to boost energy and stay fit every morning.', 'pending', '2026-06-11 06:52:26'),
(29, 11, 11, 'Exploring Goa Beaches', 'exploring-goa-beaches', 'image/1781162172.png', 'A travel guide to the best beaches, cafes, and sunset spots in Goa.', 'pending', '2026-06-11 07:16:12'),
(30, 11, 10, 'Quick Lunch Ideas', 'quick-lunch-ideas', 'image/1781162296.png', 'Delicious and healthy lunch recipes ready in under 20 minutes.', 'approved', '2026-06-11 07:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `slug`, `created_at`) VALUES
(9, 'Programming', 'programming', '2026-06-11 06:43:24'),
(10, 'Food', 'food', '2026-06-11 06:43:40'),
(11, 'Travel', 'travel', '2026-06-11 06:43:57'),
(12, 'Technology', 'technology', '2026-06-11 06:44:07'),
(13, 'Health', 'health', '2026-06-11 06:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(5, 'amit', 'amitchaulya553@gmail.com', '$2y$10$BvxWuMITEE.jJUtqzNQBU.KbzlKDsBHXKqA3Yupl1gtZG3VOhFpaS', 'admin', '2026-06-08 17:09:07'),
(10, 'akash', 'akash@gmail.com', '$2y$10$F93MCVbEjYDQO98VCUZNlextQwifD6jIJX8NhVWc7g32sipHwy.L2', 'user', '2026-06-11 06:14:17'),
(11, 'bikash', 'bikash@gmail.com', '$2y$10$E9jcN3c6qO7tkXO5xJUFweuoufAfSOStHQ7nIwJ.edygpOdCBlM8K', 'user', '2026-06-11 06:48:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `blogs_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
