-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 09, 2009 at 08:54 AM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET FOREIGN_KEY_CHECKS=0;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test2`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--
-- Creation: Aug 08, 2009 at 11:33 PM
-- Last update: Aug 08, 2009 at 11:34 PM
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin5 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`) VALUES
(1, 'alicia Chaffin'),
(2, 'norman Whitten'),
(3, 'howard Cottrell'),
(4, 'natalie Mccollum'),
(5, 'jesse Polanco'),
(6, 'carl Santiago'),
(7, 'craig Chapman'),
(8, 'helen Raab'),
(9, 'carl Lavin'),
(10, 'vanessa Rankins'),
(11, 'douglas Pedigo'),
(12, 'steve Hartfield'),
(13, 'Wegner Pedigo'),
(14, 'christy Sinclair'),
(15, 'jack Kovacs'),
(16, 'bonnie Ivory'),
(17, 'william Allen'),
(18, 'juan Pino'),
(19, 'megan Godin'),
(20, 'bernice Mackie'),
(21, 'douglas Watters'),
(22, 'genevieve Slater'),
(23, 'ralph Aucoin'),
(24, 'virginia Kwon'),
(25, 'Godoy Larson'),
(26, 'frank Villatoro'),
(27, 'anthony Hintz'),
(28, 'johnny Manzo'),
(29, 'joe Dix'),
(30, 'michael Litchfield'),
(31, 'priscilla Weimer'),
(32, 'charles Godwin'),
(33, 'victoria Doney'),
(34, 'irene Petry'),
(35, 'william Byler'),
(36, 'ronald Auger'),
(37, 'steve Tedder'),
(38, 'theresa Goodale'),
(39, 'adam Verdugo'),
(40, 'glenn Simard'),
(41, 'louis Woodring'),
(42, 'phyllis Arbogast'),
(43, 'janice Ripley'),
(44, 'amy Mcginnis'),
(45, 'phillip Wiser'),
(46, 'patrick Perrotta'),
(47, 'crystal Ridenhour'),
(48, 'nathan Ober'),
(49, 'molly Pitzer'),
(50, 'jonathan Tubbs'),
(51, 'Leary Levin'),
(52, 'cathy Pierre'),
(53, 'victoria Searle'),
(54, 'adam Gaskin'),
(55, 'debra Centeno'),
(56, 'kristi Hassan'),
(57, 'marsha Schaffer'),
(58, 'gerald Wrenn'),
(59, 'howard Levin'),
(60, 'ana Larson');

SET FOREIGN_KEY_CHECKS=1;
