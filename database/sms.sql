-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2024 at 11:14 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CID` int(11) NOT NULL,
  `CName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CID`, `CName`) VALUES
(1, 'Smartphone'),
(2, 'Television'),
(3, 'Speaker');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `PID` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `PName` varchar(300) NOT NULL,
  `quantity` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`PID`, `cid`, `PName`, `quantity`, `uid`, `date`, `price`) VALUES
(9, 1, 'Redmi Noe 12', 6, 1, '2024-03-13 14:41:13', 40000),
(18, 2, 'LG x1pro', 2, 1, '2024-03-16 03:20:00', 800000),
(19, 1, 'Tecno pov 4', 4, 1, '2024-03-14 17:27:00', 400000),
(20, 1, 'redmi note12 pro', 3, 1, '2024-03-15 03:28:00', 360000),
(21, 1, 'Redmi 9', 3, 9, '2024-03-16 04:43:00', 360000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UID` int(11) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Utype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UID`, `Email`, `Password`, `Name`, `Utype`) VALUES
(1, 'admin@gmail.com', 'admin', 'Administrator', 'admin'),
(3, 'aungmoe@gmail.com', 'Aungmoe12345@', 'aungmoe', 'supplier'),
(4, 'heinkhant@gmail.com', 'Heinkhant12345@', 'hein khant', 'supplier'),
(5, 'soewai@gmail.com', 'Soewai12345@', 'soewai', 'supplier'),
(6, 'a@gmail.com', 'a', 'a', 'supplier'),
(7, 'kaung@gmail.com', 'Kaung12345@', 'kaung', 'supplier'),
(8, 'aungpyae@gmail.com', '12345', 'aungpyae', 'supplier'),
(9, 'zarni@gmail.com', 'Zarni123@', 'zarni', 'supplier');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`PID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
