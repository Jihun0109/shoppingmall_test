-- 2018 09-04
-- --------------------------------------------------------
-- phpMyAdmin SQL Dump
-- version 4.4.6.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 05, 2018 at 12:01 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fuyuanquan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `shipping address`
--

CREATE TABLE IF NOT EXISTS `shipping address` (
  `id` int(11) NOT NULL,
  `mb_id` int(11) NOT NULL,
  `mb_receiving_address` varchar(150) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shipping address`
--
ALTER TABLE `shipping address`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shipping address`
--
ALTER TABLE `shipping address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- 2018-09-07

ALTER TABLE `shipping address` ADD `mb_ship_province` VARCHAR(150) NOT NULL AFTER `mb_id`, ADD `mb_ship_city` VARCHAR(150) NOT NULL AFTER `mb_ship_province`, ADD `mb_ship_district` VARCHAR(150) NOT NULL AFTER `mb_ship_city`;

-- 2018-09-10---
ALTER TABLE `payment_list` ADD `ship_status` TINYINT NOT NULL DEFAULT '0' AFTER `payment_types`; 




ALTER TABLE `payment_list` ADD `shipping_id` INT NOT NULL AFTER `ship_status`; 



ALTER TABLE `payment_list` ADD `mb_receiving_address` VARCHAR(250) NULL DEFAULT '0' AFTER `shipping_id`; 
