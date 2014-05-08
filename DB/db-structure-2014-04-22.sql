-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 22, 2014 at 07:27 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `foodrescue`
--
CREATE DATABASE IF NOT EXISTS `foodrescue` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `foodrescue`;

-- --------------------------------------------------------

--
-- Table structure for table `my_products`
--

CREATE TABLE IF NOT EXISTS `my_products` (
  `users_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(45,0) NOT NULL,
  `end_date` int(11) NOT NULL,
  PRIMARY KEY (`users_id`,`products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `my_products_trashed`
--

CREATE TABLE IF NOT EXISTS `my_products_trashed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `my_products_id` int(11) NOT NULL,
  `quantity` decimal(45,0) NOT NULL,
  PRIMARY KEY (`id`,`my_products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(9,0) NOT NULL,
  `quantity` decimal(45,0) NOT NULL,
  `unit` varchar(45) NOT NULL,
  `end_days` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12028 ;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE IF NOT EXISTS `recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `describtion` text NOT NULL,
  `image_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1785 ;

-- --------------------------------------------------------

--
-- Table structure for table `recipes_products`
--

CREATE TABLE IF NOT EXISTS `recipes_products` (
  `recipes_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` decimal(9,2) NOT NULL,
  `unit` varchar(255) NOT NULL,
  PRIMARY KEY (`recipes_id`,`products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `reminder` int(11) NOT NULL,
  `recipe_sort` int(11) NOT NULL,
  `saved_money` decimal(9,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_recipes`
--

CREATE TABLE IF NOT EXISTS `users_recipes` (
  `users_id` int(11) NOT NULL,
  `recipes_id` int(11) NOT NULL,
  `cooked` int(11) NOT NULL,
  `liked` int(11) NOT NULL,
  PRIMARY KEY (`users_id`,`recipes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
