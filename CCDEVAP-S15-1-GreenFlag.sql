-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 14, 2026 at 01:42 PM
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
-- Database: `greenflag`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `created_at`) VALUES
(1, 2, 'Registered a new Green Flag account.', NULL, NULL, '2026-07-14 06:50:04'),
(2, 3, 'Registered a new Green Flag account.', NULL, NULL, '2026-07-14 06:50:04'),
(3, 4, 'Registered a new Green Flag account.', NULL, NULL, '2026-07-14 06:50:04'),
(4, 1, 'Verified the account of Juan Dela Cruz.', NULL, NULL, '2026-07-14 06:50:04'),
(5, 1, 'Verified the account of Maria Santos.', NULL, NULL, '2026-07-14 06:50:04'),
(6, 2, 'Logged into the application.', NULL, NULL, '2026-07-14 06:50:04'),
(7, 3, 'Logged into the application.', NULL, NULL, '2026-07-14 06:50:04'),
(8, 2, 'Submitted a review for Cafe Mesa.', NULL, NULL, '2026-07-14 06:50:04'),
(9, 3, 'Submitted a review for Santos Garden.', NULL, NULL, '2026-07-14 06:50:04'),
(10, 1, 'Approved a review submitted by Juan Dela Cruz.', NULL, NULL, '2026-07-14 06:50:04'),
(11, 1, 'Approved a review submitted by Maria Santos.', NULL, NULL, '2026-07-14 06:50:04'),
(12, 2, 'Added Coffee Bean & Tea Leaf to Favorites.', NULL, NULL, '2026-07-14 06:50:04'),
(13, 2, 'Added Cafe Mesa to Favorites.', NULL, NULL, '2026-07-14 06:50:04'),
(14, 3, 'Added Santos Garden to Favorites.', NULL, NULL, '2026-07-14 06:50:04'),
(15, 3, 'Added Death to Aladeen to Favorites.', NULL, NULL, '2026-07-14 06:50:04'),
(16, 1, 'Published the announcement \"Welcome to Green Flag!\".', NULL, NULL, '2026-07-14 06:50:04'),
(17, 1, 'Published the announcement \"Platform Maintenance\".', NULL, NULL, '2026-07-14 06:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `target_role` enum('all','student','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `admin_id`, `title`, `message`, `target_role`, `created_at`, `expires_at`) VALUES
(1, 1, 'Welcome to Green Flag!', 'Welcome to Green Flag! Explore the best study spots, cafés, restaurants, and hangout locations around DLSU. Start discovering your next favorite place today!', 'all', '2026-07-14 06:48:59', NULL),
(2, 1, 'New Spot Added', 'Coffee Bean & Tea Leaf (Henry Sy Sr. Hall) has been added to the platform. Check it out and let the community know what you think!', 'all', '2026-07-14 06:48:59', NULL),
(3, 1, 'Community Guidelines Reminder', 'Please keep reviews respectful and honest. Reviews containing offensive language, spam, or misleading information may be removed by the administrators.', 'all', '2026-07-14 06:48:59', NULL),
(4, 1, 'Platform Maintenance', 'Green Flag will undergo scheduled maintenance this Sunday from 12:00 AM to 2:00 AM. Some features may be temporarily unavailable during this period.', 'all', '2026-07-14 06:48:59', NULL),
(5, 1, 'Feature Update', 'The Favorites system is now available! Save your favorite study spots and restaurants for quick access anytime.', 'all', '2026-07-14 06:48:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int(11) NOT NULL,
  `spot_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`user_id`, `spot_id`, `created_at`) VALUES
(2, 2, '2026-07-14 05:10:38'),
(2, 6, '2026-07-14 05:10:38'),
(3, 3, '2026-07-14 05:10:38'),
(3, 5, '2026-07-14 05:10:38'),
(3, 6, '2026-07-14 05:10:38'),
(4, 1, '2026-07-14 05:10:38'),
(4, 4, '2026-07-14 05:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `spot_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `review` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `spot_id`, `rating`, `review`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 4, 'Great place to study after classes. The photobooth was a nice bonus!', 'approved', '2026-07-14 02:41:55', '2026-07-14 02:41:55'),
(2, 3, 1, 5, 'Very peaceful during weekdays. Definitely coming back.', 'approved', '2026-07-14 02:41:55', '2026-07-14 02:41:55'),
(3, 2, 2, 5, 'Excellent coffee and plenty of charging outlets. Perfect during finals week.', 'approved', '2026-07-14 02:41:55', '2026-07-14 02:41:55'),
(4, 3, 2, 4, 'Food was good but it gets crowded around lunchtime.', 'approved', '2026-07-14 02:41:55', '2026-07-14 02:41:55'),
(5, 3, 3, 5, 'Probably my favorite place to unwind after a long day of classes.', 'approved', '2026-07-14 02:41:55', '2026-07-14 02:41:55'),
(6, 4, 3, 5, 'Beautiful scenery and surprisingly quiet. Great for dates.', 'pending', '2026-07-14 02:41:55', '2026-07-14 02:41:55'),
(7, 2, 4, 4, 'Nice place to hang out with friends between classes.', 'approved', '2026-07-14 02:41:55', '2026-07-14 02:41:55'),
(8, 3, 5, 5, 'The food was amazing and the atmosphere was unique.', 'approved', '2026-07-14 02:41:55', '2026-07-14 02:41:55'),
(9, 4, 5, 3, 'Pretty good overall, although service was a little slow.', 'pending', '2026-07-14 02:41:55', '2026-07-14 02:41:55'),
(10, 2, 6, 5, 'One of the best study spots on campus. Fast Wi-Fi and great coffee.', 'approved', '2026-07-14 02:41:55', '2026-07-14 02:41:55'),
(11, 3, 6, 5, 'Quiet environment with lots of seating. Highly recommended.', 'approved', '2026-07-14 02:41:55', '2026-07-14 02:41:55');

-- --------------------------------------------------------

--
-- Table structure for table `spots`
--

CREATE TABLE `spots` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `hours` varchar(100) NOT NULL,
  `noise` enum('Low','Medium','High') NOT NULL,
  `privacy` enum('Low','Medium','High') NOT NULL,
  `price` enum('Free','Low','Medium','High') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spots`
--

INSERT INTO `spots` (`id`, `name`, `location`, `description`, `image`, `hours`, `noise`, `privacy`, `price`, `created_at`) VALUES
(1, 'Archer\'s Place', 'Taft Avenue', 'One Archers Place is a 31-storey condominium located along Taft Avenue near several universities. It offers 665 residential units along with amenities.', 'photos/thumbnails/archers-place.png', 'Open • 9:00 AM - 10:00 PM', 'Low', 'Medium', 'High', '2026-07-14 02:30:43'),
(2, 'Cafe Mesa', 'Taft Avenue', 'A cozy café perfect for locking in during finals week. Popular for students looking for a peaceful workspace with good coffee.', 'photos/thumbnails/cafe-mesa.png', 'Open • 9:00 AM - 10:00 PM', 'Low', 'Medium', 'High', '2026-07-14 02:30:43'),
(3, 'Santos Garden', 'Ayala Center, Makati', 'Relaxing view perfect place to chill and enjoy your snack. There are various cafes and restaurants around the park. There are also cats, koi fish, and ducks.', 'photos/thumbnails/santos-garden.png', 'Open • 9:00 AM - 10:00 PM', 'High', 'Low', 'Free', '2026-07-14 02:30:43'),
(4, 'Amphitheater', 'DLSU, Taft Avenue', 'Relaxing view perfect place to chill, enjoy your snack, and hang out with your date or friends!', 'photos/thumbnails/amphitheater.png', 'Open • 6:00 AM - 5:00 PM', 'High', 'Medium', 'Free', '2026-07-14 02:30:43'),
(5, 'Death to Aladeen', 'Taft Avenue', 'Serving homestyle classics since 1982, where every meal feels like Sunday dinner.', 'photos/thumbnails/death-to-aladeen.png', 'Open • 6:00 AM - 5:00 PM', 'High', 'Medium', 'Medium', '2026-07-14 02:30:43'),
(6, 'Coffee Bean & Tea Leaf', 'Henry Sy Sr. Hall, DLSU', 'Make your everyday coffee and tea moments even more rewarding! From our viral Dry Americano to your favorite Ice Blended® beverages, every sip gets you closer to exclusive merchandise and seasonal favorites.', 'photos/thumbnails/coffee-bean.png', 'Open • 8:00 AM - 7:00 PM', 'Medium', 'Medium', 'High', '2026-07-14 02:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `spot_tags`
--

CREATE TABLE `spot_tags` (
  `spot_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spot_tags`
--

INSERT INTO `spot_tags` (`spot_id`, `tag_id`) VALUES
(1, 2),
(1, 3),
(1, 9),
(2, 1),
(2, 2),
(2, 7),
(3, 4),
(3, 5),
(3, 6),
(4, 7),
(5, 6),
(5, 8),
(6, 1),
(6, 2),
(6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `tag_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag_name`) VALUES
(6, 'Ambience'),
(1, 'Cafe'),
(7, 'Chill'),
(9, 'Condo'),
(5, 'Couple Photos'),
(3, 'Photobooth'),
(8, 'Restaurant'),
(4, 'Romantic'),
(2, 'Workspace');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') NOT NULL,
  `status` enum('pending','verified','suspended','banned') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Green Flag Admin', 'admin@dlsu.edu.ph', 'admin123', 'admin', 'verified', '2026-07-14 02:17:50'),
(2, 'Juan Dela Cruz', 'juan.delacruz@dlsu.edu.ph', 'password123', 'student', 'verified', '2026-07-14 02:17:50'),
(3, 'Maria Santos', 'maria.santos@dlsu.edu.ph', 'password123', 'student', 'verified', '2026-07-14 02:17:50'),
(4, 'Miguel Reyes', 'miguel.reyes@dlsu.edu.ph', 'password123', 'student', 'pending', '2026-07-14 02:17:50'),
(5, 'Test Student', 'test.student@dlsu.edu.ph', '$2y$10$8krKcrADPjNwkFxK3LqideVCSgKMnUQmLzd1jsupx8imn2W/xmrY2', 'student', 'verified', '2026-07-14 11:24:22'),
(6, 'Test StudentTwo', 'test.student2@dlsu.edu.ph', '$2y$10$34.zv2.I9oINRm9Dp1G2VOHXJd6RhzAv81DsptW5xrZIgGbWcx2sW', 'student', 'verified', '2026-07-14 11:33:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`spot_id`),
  ADD KEY `spot_id` (`spot_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `spot_id` (`spot_id`);

--
-- Indexes for table `spots`
--
ALTER TABLE `spots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spot_tags`
--
ALTER TABLE `spot_tags`
  ADD PRIMARY KEY (`spot_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `spots`
--
ALTER TABLE `spots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`spot_id`) REFERENCES `spots` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`spot_id`) REFERENCES `spots` (`id`);

--
-- Constraints for table `spot_tags`
--
ALTER TABLE `spot_tags`
  ADD CONSTRAINT `spot_tags_ibfk_1` FOREIGN KEY (`spot_id`) REFERENCES `spots` (`id`),
  ADD CONSTRAINT `spot_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
