-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 02, 2011 at 11:55 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mydatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `CustomerID` varchar(4) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `CountryCode` varchar(2) NOT NULL,
  `Budget` double NOT NULL,
  `Used` double NOT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `Name`, `Email`, `CountryCode`, `Budget`, `Used`) VALUES
('C001', 'Ma. Junallie Fuentebella', 'allie@yahoo.com', 'PH', 14000, 150000),
('C002', 'Peter North', 'pete@gmail.com', 'CN', 65000, 75000),
('C004', 'Kobe Bryant', 'kobe@adidas.com', 'US', 45000, 24000),
('C005', 'Jake Pomperada', 'jakerpomperada@yahoo.com', 'US', 50000, 30000),
('C006', 'Ricky Arro', 'ricky@hotmail.com', 'PH', 3000, 1000),
('C007', 'Wayne Custer Alegata', 'waynes_world@gmail.com', 'PH', 12000, 8500),
('C010', 'Albert Pepito', 'albert@gmail.com', 'PH', 18000, 15000),
('C011', 'James Smith', 'smith@nasa.com', 'US', 34000, 23000),
('C012', 'Vincent Qui', 'vincent@yahoomail.com', 'PH', 52000, 35000);
