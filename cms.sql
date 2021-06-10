-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 03, 2021 at 03:25 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `aname` varchar(100) NOT NULL,
  `addedBy` varchar(100) NOT NULL,
  `aheadline` varchar(20) DEFAULT NULL,
  `abio` text DEFAULT NULL,
  `aimage` varchar(60) NOT NULL DEFAULT 'default-user-image.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `datetime`, `username`, `password`, `aname`, `addedBy`, `aheadline`, `abio`, `aimage`) VALUES
(1, 'June-01-2021 12:28:03', 'sleepturtle', '1234', 'admin', 'sayantan ', '', '', ''),
(2, 'June-01-2021 12:29:07', 'new', '123', 'sayantan ', 'Jazeb', 'head poet', 'sdfsfd', 'phone.png'),
(4, 'June-03-2021 17:10:57', 'huko_mukho', '1234', 'new', 'hangla', NULL, NULL, 'default-user-image.png');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `author` varchar(100) NOT NULL,
  `datetime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `author`, `datetime`) VALUES
(1, 'course', 'admin', 'May-31-2021 09:12:07'),
(2, 'testing ', 'admin', 'May-31-2021 09:12:42'),
(3, 'sports', 'admin', 'June-01-2021 23:14:28'),
(4, 'new new cat', 'admin', 'June-01-2021 23:18:22'),
(10, 'happy dogs', 'new', 'June-02-2021 19:16:37');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `approvedBy` varchar(100) NOT NULL,
  `status` varchar(3) NOT NULL,
  `post_id` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `datetime`, `name`, `email`, `comment`, `approvedBy`, `status`, `post_id`) VALUES
(9, 'May-31-2021 21:56:23', 'asd', 'asd@sdf.sd', 'comment 2', 'admin', 'ON', 2),
(11, 'May-31-2021 21:57:17', 'bad_name', 'bad_name@gmail.com', 'test comment ', 'admin', 'ON', 3),
(12, 'May-31-2021 21:57:46', 'black_sabbath', 'black_sabbth@mail.com', 'black army ', 'admin', 'OFF', 4),
(13, 'June-02-2021 20:44:35', 'mgmt', 'mgmt@popband.com', 'unapproved comment ', 'Pending', 'OFF', 3);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(50) NOT NULL,
  `datetime` varchar(100) NOT NULL,
  `title` varchar(300) NOT NULL,
  `category` varchar(200) NOT NULL,
  `author` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'no-image.jpg',
  `post` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `datetime`, `title`, `category`, `author`, `image`, `post`) VALUES
(2, 'May-31-2021 21:55:10', 'first post ', 'course', 'admin', 'black-sabbath-wallpaper.jpg', 'testing '),
(3, 'May-31-2021 21:55:29', 'second post ', 'course', 'admin', '1495959.jpg', 'still testing '),
(4, 'May-31-2021 21:55:48', 'third post ', 'testing', 'admin', '0932v38.png', 'doing it for the lulz\r\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
