-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2024 at 03:45 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survey_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`questions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `title`, `description`, `questions`) VALUES
(1, 'SP', 'SP WEB', '[{\"question\":\"apakah kamu senang?\",\"type\":\"multiple-choice\",\"options\":[\"Ya\",\"Tidak\"]},{\"question\":\"Penyebab ngylang\",\"type\":\"text\",\"options\":[]}]'),
(2, 'BASIS DATA', 'SP BASIS DATA', '[{\"question\":\"APAKAH KAMU BAHAGIA?\",\"type\":\"multiple-choice\",\"options\":[\"YA\",\"TIDAK\"]},{\"question\":\"APAKAH KAMU TERTEKAN?\",\"type\":\"text\",\"options\":[]}]'),
(3, 'Penilaian Rekan kerja', 'PT ABCD', '[{\"question\":\"Berapa lama kamu bekerja?\",\"type\":\"multiple-choice\",\"options\":[\"5 Tahun\",\"2 Tahun\",\"1 Tahun\"]},{\"question\":\"Gajih \",\"type\":\"text\",\"options\":[]}]');

-- --------------------------------------------------------

--
-- Table structure for table `survey_responses`
--

CREATE TABLE `survey_responses` (
  `id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `survey_responses`
--

INSERT INTO `survey_responses` (`id`, `survey_id`, `question_id`, `answer`, `submitted_at`) VALUES
(1, 0, 0, 'Tidak', '2024-08-18 06:30:16'),
(2, 0, 1, 'Kelompok pada ga ngerjain', '2024-08-18 06:30:16'),
(3, 1, 1, 'Ya', '2024-08-18 06:33:15'),
(4, 1, 2, 'ga tau', '2024-08-18 06:33:15'),
(5, 1, 1, 'Ya', '2024-08-18 06:35:57'),
(6, 1, 2, 'menghilang', '2024-08-18 06:35:57'),
(7, 1, 1, 'Tidak', '2024-08-18 06:38:01'),
(8, 1, 2, 'pusing', '2024-08-18 06:38:01'),
(9, 1, 1, 'Tidak', '2024-08-18 06:39:37'),
(10, 1, 2, 'pusing', '2024-08-18 06:39:37'),
(11, 1, 1, 'Ya', '2024-08-18 06:51:42'),
(12, 1, 2, 'ga tau', '2024-08-18 06:51:42'),
(13, 1, 1, '', '2024-08-18 07:03:44'),
(14, 1, 1, '', '2024-08-18 07:05:19'),
(15, 1, 1, '', '2024-08-18 07:06:20'),
(16, 1, 0, 'Ya', '2024-08-18 07:09:50'),
(17, 1, 1, 'y', '2024-08-18 07:09:50'),
(18, 1, 0, 'Ya', '2024-08-18 07:15:44'),
(19, 1, 1, 'nn', '2024-08-18 07:15:44'),
(20, 1, 0, 'Ya', '2024-08-18 07:27:21'),
(21, 1, 1, 'Kelompok pada ga ngerjain', '2024-08-18 07:27:21'),
(22, 2, 0, 'TIDAK', '2024-08-18 07:42:37'),
(23, 2, 1, 'SANGAT TERTEKAN', '2024-08-18 07:42:37'),
(24, 3, 0, '5 Tahun', '2024-08-18 14:32:44'),
(25, 3, 1, 'Rp.5.00000', '2024-08-18 14:32:44'),
(26, 3, 0, '2 Tahun', '2024-08-18 14:44:22'),
(27, 3, 1, 'Rp.5.00000', '2024-08-18 14:44:22'),
(28, 1, 0, 'Ya', '2024-08-19 13:37:34'),
(29, 1, 1, 'SANGAT TERTEKAN', '2024-08-19 13:37:34'),
(30, 1, 0, 'Ya', '2024-08-19 13:39:51'),
(31, 1, 1, 'Kelompok pada ga ngerjain', '2024-08-19 13:39:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_responses`
--
ALTER TABLE `survey_responses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `survey_responses`
--
ALTER TABLE `survey_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
