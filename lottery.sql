-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 11, 2018 at 04:03 PM
-- Server version: 5.6.38
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plugine_lotterydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `title`, `created_time`) VALUES
(2, 'پانصد هزار تومان', '2018-07-04 10:25:50'),
(6, 'قرعه کشی پژو 206', '2018-07-04 10:25:38'),
(9, 'قرعه کشی خودرو bmw', '2018-07-04 10:25:56'),
(10, 'یک میلیون تومان', '2018-07-08 19:53:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_game`
--

CREATE TABLE `tbl_game` (
  `id` int(10) UNSIGNED NOT NULL,
  `team1` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `team2` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `team1_goal` tinyint(4) NOT NULL DEFAULT '-1',
  `team2_goal` tinyint(4) NOT NULL DEFAULT '-1',
  `active` enum('yes','no') COLLATE utf8_persian_ci NOT NULL DEFAULT 'no',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tbl_game`
--

INSERT INTO `tbl_game` (`id`, `team1`, `team2`, `team1_goal`, `team2_goal`, `active`, `created_time`) VALUES
(7, 'فرانسه', 'ایتالیا', 1, 0, 'yes', '2018-07-04 16:41:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_register`
--

CREATE TABLE `tbl_register` (
  `id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `tel` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  `team1_goal` tinyint(4) NOT NULL,
  `team2_goal` tinyint(4) NOT NULL,
  `win` enum('yes','no') COLLATE utf8_persian_ci NOT NULL DEFAULT 'no',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tbl_register`
--

INSERT INTO `tbl_register` (`id`, `game_id`, `tel`, `team1_goal`, `team2_goal`, `win`, `created_time`) VALUES
(8, 7, '9158930106', 2, 0, 'no', '2018-07-11 13:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_winner`
--

CREATE TABLE `tbl_winner` (
  `id` int(11) NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `tel` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sms_verify` enum('yes','no') COLLATE utf8_persian_ci NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tbl_winner`
--

INSERT INTO `tbl_winner` (`id`, `game_id`, `tel`, `category_id`, `created_time`, `sms_verify`) VALUES
(2, 7, '09158930106', 6, '2018-07-04 21:00:39', 'yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `tbl_game`
--
ALTER TABLE `tbl_game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_register`
--
ALTER TABLE `tbl_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_winner`
--
ALTER TABLE `tbl_winner`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_game`
--
ALTER TABLE `tbl_game`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_register`
--
ALTER TABLE `tbl_register`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_winner`
--
ALTER TABLE `tbl_winner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
