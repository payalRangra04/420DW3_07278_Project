-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2024 at 11:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erpdatabase`
--
CREATE DATABASE IF NOT EXISTS `erpdatabase` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `erpdatabase`;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `groupId` int(11) NOT NULL AUTO_INCREMENT,
  `groupName` varchar(256) NOT NULL,
  `groupDescription` varchar(256) DEFAULT NULL,
  `creationDate` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `modificationDate` datetime(6) DEFAULT NULL ON UPDATE current_timestamp(6),
  PRIMARY KEY (`groupId`),
  UNIQUE KEY `groupName` (`groupName`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`groupId`, `groupName`, `groupDescription`, `creationDate`, `modificationDate`) VALUES
(1, 'Admins', 'Administrative users with full access to manage the system', '2024-05-05 23:04:17.213853', NULL),
(2, 'Support', 'Users providing technical support', '2024-05-05 23:04:17.213853', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `permissionId` int(11) NOT NULL AUTO_INCREMENT,
  `permissionKey` varchar(256) NOT NULL,
  `permissionName` varchar(256) NOT NULL,
  `permissionDescription` varchar(256) DEFAULT NULL,
  `creationDate` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `modificationDate` datetime(6) DEFAULT NULL ON UPDATE current_timestamp(6),
  PRIMARY KEY (`permissionId`),
  UNIQUE KEY `permissionKey` (`permissionKey`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permissionId`, `permissionKey`, `permissionName`, `permissionDescription`, `creationDate`, `modificationDate`) VALUES
(1, 'add_record', 'Add Record', 'Allow user to add new records', '2024-05-05 23:05:53.127665', NULL),
(2, 'update_record', 'Update Record', 'Allow user to update existing records', '2024-05-05 23:05:53.127665', NULL),
(3, 'delete_record', 'Delete Record', 'Allow user to delete existing records', '2024-05-05 23:05:53.127665', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usergrouppermissionstable`
--

DROP TABLE IF EXISTS `usergrouppermissionstable`;
CREATE TABLE IF NOT EXISTS `usergrouppermissionstable` (
  `groupId` int(11) NOT NULL,
  `permissionId` int(11) NOT NULL,
  PRIMARY KEY (`groupId`,`permissionId`) USING BTREE,
  KEY `permissionId` (`permissionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userpermissionstable`
--

DROP TABLE IF EXISTS `userpermissionstable`;
CREATE TABLE IF NOT EXISTS `userpermissionstable` (
  `userId` int(11) NOT NULL,
  `permissionId` int(11) NOT NULL,
  PRIMARY KEY (`userId`,`permissionId`),
  KEY `userpermissionstable_ibfk_2` (`permissionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `creationDate` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `modificationDate` datetime(6) DEFAULT NULL ON UPDATE current_timestamp(6),
  PRIMARY KEY (`userId`),
  UNIQUE KEY `nameUq` (`userName`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `password`, `email`, `creationDate`, `modificationDate`) VALUES
(1, 'rahul_sharma', 'rahul@123', 'rahul.sharma@example.com', '2024-05-05 23:01:28.615165', NULL),
(2, 'priya_patel', 'priya456', 'priya.patel@example.com', '2024-05-05 23:01:28.615165', NULL),
(3, 'neha_gupta', 'neha789', 'neha.gupta@example.com', '2024-05-05 23:01:28.615165', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `usergrouppermissionstable`
--
ALTER TABLE `usergrouppermissionstable`
  ADD CONSTRAINT `FK_usergrouptable_permissions` FOREIGN KEY (`permissionId`) REFERENCES `permissions` (`permissionId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `usergrouppermissionstable_ibfk_2` FOREIGN KEY (`groupId`) REFERENCES `groups` (`groupId`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `userpermissionstable`
--
ALTER TABLE `userpermissionstable`
  ADD CONSTRAINT `userpermissionstable_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `userpermissionstable_ibfk_2` FOREIGN KEY (`permissionId`) REFERENCES `permissions` (`permissionId`) ON DELETE CASCADE ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
