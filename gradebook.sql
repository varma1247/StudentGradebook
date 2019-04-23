-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 23, 2019 at 12:40 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gradebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `password`) VALUES
('saivarma@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseid` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `year` varchar(50) NOT NULL,
  `professorid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseid`, `name`, `semester`, `year`, `professorid`) VALUES
('CSE5301', 'Artificial Intelligence', 'Spring', '2019', '1234567899');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `studentid` varchar(50) NOT NULL,
  `courseid` varchar(50) NOT NULL,
  `year` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `professorid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`studentid`, `courseid`, `year`, `semester`, `grade`, `professorid`) VALUES
('1001669341', 'CSE5301', '2019', 'Spring', 'E', '1234567899');

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `email` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id` varchar(50) NOT NULL,
  `approved` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`email`, `firstname`, `lastname`, `password`, `id`, `approved`) VALUES
('s11@gmail.com', 'gdfd', 'fsdsd', 'a283d5b8093e301cdc47fc10debf014b', '1234567899', '1');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `email` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id` varchar(50) NOT NULL,
  `approved` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`email`, `firstname`, `lastname`, `password`, `id`, `approved`) VALUES
('ahvhgsav@ggf.sj', 'gcgcgcgc', 'gcgcgg', 'a283d5b8093e301cdc47fc10debf014b', '1001788878', 0),
('jghhhvh@vv.ocm', 'hjhj17816', 'jgjbsjhbhj', 'a283d5b8093e301cdc47fc10debf014b', '1001669811', 0),
('jughg@yfgf.dxjb', 'gfgtdfgd', 'fgdgfd', 'edb79d45e6a839b6c8b7fbf0ae94b903', '1001778187', 0),
('saiva10@gmail.com', 'Satfgg', 'gcgcg', 'a283d5b8093e301cdc47fc10debf014b', '1001777654', 0),
('saivarma10@gmail.com', 'saivarma', 'raghavaraju', 'a283d5b8093e301cdc47fc10debf014b', '1001669341', 1),
('saivarma11@gmail.com', 'GDFGDggDGDG', 'gdggdg', 'a283d5b8093e301cdc47fc10debf014b', '1001998272', 0),
('sasaff@ffc.xn', 'hvhvh', 'hvvhvh', 'a283d5b8093e301cdc47fc10debf014b', '1001777611', 0),
('wdhdvsgh@gmail.com', 'gvgfg', 'fgcfgc', 'e10adc3949ba59abbe56e057f20f883e', '1989189191', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseid`,`professorid`),
  ADD KEY `professorid` (`professorid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`studentid`,`courseid`,`professorid`),
  ADD KEY `courseid` (`courseid`),
  ADD KEY `professorid` (`professorid`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`email`,`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`professorid`) REFERENCES `professor` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`courseid`) REFERENCES `course` (`courseid`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`professorid`) REFERENCES `course` (`professorid`),
  ADD CONSTRAINT `grades_ibfk_3` FOREIGN KEY (`studentid`) REFERENCES `enrolledstudents` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
