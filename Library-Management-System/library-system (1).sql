-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2025 at 04:20 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `year` year(4) DEFAULT NULL,
  `status` enum('avaliable','borrowed') DEFAULT 'avaliable',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `book` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `year`, `status`, `created_at`, `book`) VALUES
(1, 'cpp', 'c++', 2025, 'avaliable', '2025-09-01 15:58:14', '1756742294_Grokking_Algorithms20191211-5332-1c8w1se.pdf'),
(2, 'javascript', 'js', 2025, 'avaliable', '2025-09-01 15:58:44', '1756742324_javascriptBook.pdf'),
(3, 'js', 'js', 2025, 'avaliable', '2025-09-01 15:59:03', '1756742343_Eloquent_JavaScript_small.pdf'),
(4, 'DSA', 'DSA', 2025, 'avaliable', '2025-09-01 16:00:37', '1756742437_DataStructures.pdf'),
(5, 'c++Book', 'c++', 2025, 'avaliable', '2025-09-01 16:01:45', '1756742505_الكتاب الثانيC++  _programing_from_problem_analysis.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'mohamed tamer', 'mohmedtamer9887@gmail.com', '$2y$10$j07YQcdwXQAZXCbSFDy9J.GdnqjW5M/5ZailIhsj7TGkxyOn2aSe2', 'admin', '2025-09-02 10:42:53'),
(2, 'adminpanle', 'Admin@gmail.com', '$2y$10$reQEAr8D5zkchfX9X7nIn.sBbg3p7p3eOC5kJ2bh1TkiYlsVWfX7C', 'admin', '2025-09-02 10:43:30'),
(3, 'WARDA', 'Warda@gmail.com', '$2y$10$/jzPfS1jAAFvFb70/yvPP.W5y6y5Tk5NY2b1f8h5XXfmQF3P42Mn6', 'user', '2025-09-02 10:50:07'),
(21, 'atwaa', 'atwaa@gmail.com', '$2y$10$41j1cv5bjd6rix02wOeTO.1zdcdHAniMx9VeP/RTI/Z7psxdZgVxS', 'admin', '2025-09-02 10:38:40'),
(25, 'mahamed', 'pop1@gmail.com', '$2y$10$7iRxLtDBBLxFIrCCtxKFQuphqCmj3tDj7luhwJjvHalrrgVUjetmq', 'admin', '2025-09-02 10:44:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
