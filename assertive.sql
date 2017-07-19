-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2017 at 04:45 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assertive`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE `apps` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `directory` varchar(50) NOT NULL,
  `cookie` varchar(10) NOT NULL,
  `image` varchar(32) NOT NULL,
  `dps` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apps`
--

INSERT INTO `apps` (`id`, `title`, `description`, `directory`, `cookie`, `image`, `dps`) VALUES
(1, 'School Management System', 'This is an application for school and student management system..', 'sms', 'scms', '', '{\n"permission": true,\n"param1": false,\n"param2": false,\n"param3": false,\n"param4": true,\n"param5": true,\n"param6": true\n}'),
(2, 'Simplework', 'sdfsfsdf', 'simplework', 'sw', '', '{\r\n"permission": false,\r\n"param": false\r\n}'),
(3, 'Center Apps', 'Simple login system', 'center', 'cntr', '', '{\r\n"permission": true,\r\n"param1": true\r\n}');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `userid` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cell` varchar(20) NOT NULL,
  `covert` varchar(32) NOT NULL,
  `tokens` varchar(200) NOT NULL,
  `consents` text NOT NULL,
  `credentials` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `dob`, `userid`, `email`, `cell`, `covert`, `tokens`, `consents`, `credentials`) VALUES
(1, 'Aman Ullah', '25-10-1992', 'amanullah.en', 'amanullah.en@gmail.com', '01823022586', '1212', '{"STK":"jcbs2s5kk8nf3mltv2q488shl2","ASID":"ByCookie"}', '{"scms":{"param2":true}}', '{"e6ov7ifbfm1045u6pdjen0b7d7":{"time":1500995132,"duration":604800,"hs_token":"0gUKQrjMy-FPzyNA89eQtyakEyhwkLBYSPueo7XJYJ4,","di":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36"},"bovs9cv3b04d6o2rkuo6qjupe3":{"time":1501001047,"duration":604800,"hs_token":"5frpybImifXbr-15XitGeaUulxRqghJKNnIbRtZmDlg,","di":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36"},"t1v6sjoekh3bl55rm7tlcj2is5":{"time":1501002418,"duration":604800,"hs_token":"eQ4uUkQP9OXLMEcoZN107fRJx7GDBxcmpvitQ7dpKFU,","di":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36"}}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
