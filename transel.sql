-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 03:30 PM
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
-- Database: `transel`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `amount`, `type`, `timestamp`) VALUES
(1, 1, 50000.00, 'deposit', '2024-05-27 12:46:22'),
(2, 1, 30000.00, 'withdrawal', '2024-05-27 19:46:40'),
(3, 2, 10000.00, 'deposit', '2024-05-27 12:53:33'),
(4, 1, 50000.00, 'deposit', '2024-05-27 12:57:59'),
(5, 1, 10000.00, 'deposit', '2024-05-27 13:10:15'),
(6, 1, 10000.00, 'deposit', '2024-05-27 13:17:08'),
(7, 1, 2000.00, 'deposit', '2024-05-27 13:17:27'),
(8, 1, 20000.00, 'deposit', '2024-05-27 13:18:36'),
(9, 1, 20000.00, 'deposit', '2024-05-27 13:20:45'),
(10, 1, 0.00, 'withdrawal', '2024-05-27 20:21:41'),
(11, 1, 20000.00, 'deposit', '2024-05-27 13:23:10'),
(12, 1, 10000.00, 'withdrawal', '2024-05-27 20:36:56'),
(13, 1, 10000.00, 'withdrawal', '2024-05-27 20:42:03'),
(14, 2, 5000.00, 'withdrawal', '2024-05-27 20:46:34'),
(15, 1, 50000.00, 'deposit', '2024-05-27 17:59:02'),
(16, 1, 5000.00, 'deposit', '2024-05-28 01:03:03'),
(17, 1, 2000.00, 'deposit', '2024-05-28 01:03:12'),
(18, 1, 100000.00, 'withdrawal', '2024-05-28 02:32:17'),
(19, 1, 50000.00, 'deposit', '2024-05-27 19:34:08'),
(20, 1, 50000.00, 'deposit', '2024-05-27 19:35:16'),
(21, 1, 100000.00, 'withdrawal', '2024-05-28 02:35:54'),
(22, 1, 10000.00, 'withdrawal', '2024-05-29 13:29:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `balance`) VALUES
(1, 'faishal', '$2y$10$qHWx3ZLjpBHsi4PWZpMWuOxUJYG77IOCxf9fYy/hjNBSqvhoYF7XS', 'Faishal', 79000.00),
(2, 'alif', '$2y$10$fu9OIB3qK4yCjQ0ai26XB.DISrWFQ1vXXL6HRTYg/BGyAPe2Xi7pi', 'Alif', 5000.00),
(3, 'dicky', '$2y$10$Mzot0KnNW.xRRLFZo8zPuefPO3D.SrgmzTqZ/pjsTn8cqQYw.7AGu', 'Dicky', 0.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
