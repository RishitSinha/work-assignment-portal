-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2016 at 01:25 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `task_desc` varchar(255) NOT NULL,
  `task_by` varchar(100) NOT NULL,
  `task_for` int(11) NOT NULL,
  `date_assigned` date NOT NULL,
  `date_completed` date NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `group_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `user_pass` varchar(25) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `head` tinyint(1) NOT NULL,
  `engaged` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_pass`, `full_name`, `head`, `engaged`) VALUES
(1, 'ankits', 'ankits123', 'Ankit Saini', 1, 0),
(2, 'harshb', 'harshb123', 'Harsh Bajaj', 1, 0),
(3, 'himanshud', 'himanshud123', 'Himanshu Dongre', 1, 0),
(4, 'rohitk', 'rohitk123', 'Rohit Kumar', 1, 0),
(5, 'rohitkb', 'rohitkb123', 'Rohit Kumar Boga', 1, 0),
(6, 'abhinav', 'abhinav123', 'Abhinav Saini', 0, 0),
(7, 'ashutosh', 'ashutosh123', 'Ashutosh Sameer', 0, 0),
(8, 'dipramit', 'dipramit123', 'Dipramit Pal', 0, 0),
(9, 'esha', 'esha123', 'Esha Lath', 0, 0),
(10, 'harshit', 'harshit123', 'Harshit Bansal', 0, 0),
(11, 'paras', 'paras123', 'Paras Choudhary', 0, 0),
(12, 'pradhumn', 'pradhumn123', 'Pradhumn Goyal', 0, 0),
(13, 'rishit', 'rishit123', 'Rishit Sinha', 0, 0),
(14, 'sagar', 'sagar123', 'Sagar Panchal', 0, 0),
(15, 'sahil', 'sahil123', 'Sahil Raj', 0, 0),
(16, 'shivanshu', 'shivanshu123', 'Shivanshu Pandey', 0, 0),
(17, 'shubham', 'shubham123', 'Shubham Kumar', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
