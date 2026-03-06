-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2026 at 12:29 AM
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
-- Database: `straivefl`
--

-- --------------------------------------------------------

--
-- Table structure for table `production_mapping`
--

CREATE TABLE `production_mapping` (
  `id` int(11) NOT NULL,
  `number_seat` varchar(50) NOT NULL,
  `host_name` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `production_mapping`
--

INSERT INTO `production_mapping` (`id`, `number_seat`, `host_name`, `department`, `updated_at`) VALUES
(1, 'ATL00001', 'SOPLAW60024010', 'DPD', '2026-03-06 16:00:57');

-- --------------------------------------------------------

--
-- Table structure for table `prod_mapping`
--

CREATE TABLE `prod_mapping` (
  `id` int(11) NOT NULL,
  `cubicle_number` varchar(20) NOT NULL,
  `hostname` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prod_mapping`
--

INSERT INTO `prod_mapping` (`id`, `cubicle_number`, `hostname`, `department`) VALUES
(1, 'ATL0001', 'SOPLAGW60024014', 'DPD'),
(3, 'ATL0002', 'SOPLAGW60024015', 'DPD');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'test@straive.com', '$2y$10$8W9f.tW.8f.tW.8f.tW.8f.tW.8f.tW.8f.tW.8f.tW.8f.tW.8f.', '2026-03-06 11:55:36'),
(2, 'jerico.amata09@gmail.com', 'Jerico@123', '2026-03-06 11:57:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `production_mapping`
--
ALTER TABLE `production_mapping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prod_mapping`
--
ALTER TABLE `prod_mapping`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cubicle_number` (`cubicle_number`);

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
-- AUTO_INCREMENT for table `production_mapping`
--
ALTER TABLE `production_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prod_mapping`
--
ALTER TABLE `prod_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
