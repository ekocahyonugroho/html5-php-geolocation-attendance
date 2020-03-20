-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 20, 2020 at 12:17 PM
-- Server version: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mydatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances_gps`
--

CREATE TABLE IF NOT EXISTS `attendances_gps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `long` varchar(100) NOT NULL,
  `lat` varchar(100) NOT NULL,
  `accuracy` float NOT NULL,
  `type` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `attendances_gps`
--

INSERT INTO `attendances_gps` (`id`, `user_name`, `datetime`, `long`, `lat`, `accuracy`, `type`) VALUES
(2, 'Eko Cahyo Nugroho', '2020-03-19 10:09:43', '106.8529248', '-6.4211233', 10, 'Home'),
(3, 'Helmi filani', '2020-03-19 10:12:31', '106.8698213', '-6.375165', 52, 'Home'),
(4, 'Eko Cahyo Nugroho', '2020-03-20 09:26:41', '106.8550254', '-6.4231603', 20, 'Home'),
(5, 'Eko Cahyo Nugroho', '2020-03-20 10:14:28', '106.8526165', '-6.4203823', 8.133, 'Home');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
