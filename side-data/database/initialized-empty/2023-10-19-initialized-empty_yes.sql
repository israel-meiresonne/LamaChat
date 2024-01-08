-- Adminer 4.8.1 MySQL 8.0.34 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `lamachat.dev` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `lamachat.dev`;

CREATE TABLE `Contacts` (
  `pseudo_` varchar(15) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `contactStatus` enum('know','blocked') NOT NULL DEFAULT 'know',
  PRIMARY KEY (`pseudo_`,`contact`),
  KEY `FK-Contacts.contact-FROM-Users` (`contact`),
  CONSTRAINT `FK-Contacts.contact-FROM-Users` FOREIGN KEY (`contact`) REFERENCES `Users` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK-Contacts.pseudo_-FROM-Users` FOREIGN KEY (`pseudo_`) REFERENCES `Users` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


CREATE TABLE `Discussions` (
  `discuID` varchar(25) NOT NULL,
  `discuName` varchar(15) DEFAULT NULL,
  `discuSetDate` datetime NOT NULL,
  PRIMARY KEY (`discuID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


CREATE TABLE `Informations` (
  `information` varchar(25) NOT NULL,
  PRIMARY KEY (`information`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `Informations` (`information`) VALUES
('hobbit'),
('métier'),
('nationalité');

CREATE TABLE `Messages` (
  `msgID` varchar(25) NOT NULL,
  `discuId` varchar(25) NOT NULL,
  `from_pseudo` varchar(15) NOT NULL,
  `msgPrivateK` varchar(4000) NOT NULL,
  `msgType` enum('text','file') NOT NULL,
  `msg` blob NOT NULL,
  `msgStatus` enum('read','sent') NOT NULL,
  `msgSetDate` datetime NOT NULL,
  PRIMARY KEY (`msgID`,`discuId`) USING BTREE,
  KEY `FK-Messages.discuId-FROM-Discussions` (`discuId`),
  KEY `FK-Messages.from_pseudo-FROM-Users` (`from_pseudo`),
  CONSTRAINT `FK-Messages.discuId-FROM-Discussions` FOREIGN KEY (`discuId`) REFERENCES `Discussions` (`discuID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK-Messages.from_pseudo-FROM-Users` FOREIGN KEY (`from_pseudo`) REFERENCES `Users` (`pseudo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


CREATE TABLE `Participants` (
  `discuId` varchar(25) NOT NULL,
  `pseudo_` varchar(15) NOT NULL,
  PRIMARY KEY (`discuId`,`pseudo_`),
  KEY `FK-Participants.pseudo_-FROM-Discussions` (`pseudo_`),
  CONSTRAINT `FK-Participants.discuId-FROM-Discussions` FOREIGN KEY (`discuId`) REFERENCES `Discussions` (`discuID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK-Participants.pseudo_-FROM-Discussions` FOREIGN KEY (`pseudo_`) REFERENCES `Users` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


CREATE TABLE `Users` (
  `pseudo` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `picture` varchar(50) DEFAULT 'default-user-picture.png',
  `status` varchar(250) DEFAULT 'hello world',
  `permission` enum('admin','user','banished','deleted') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


CREATE TABLE `Users_ Informations` (
  `pseudo_` varchar(15) NOT NULL,
  `information_` varchar(25) NOT NULL,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY (`pseudo_`,`information_`),
  KEY `FK-Users_Professions.profession_-FROM-Professions` (`information_`),
  CONSTRAINT `FK-Users_Professions.profession_-FROM-Professions` FOREIGN KEY (`information_`) REFERENCES `Informations` (`information`) ON UPDATE CASCADE,
  CONSTRAINT `FK-Users_Professions.pseudo_-FROM-Users` FOREIGN KEY (`pseudo_`) REFERENCES `Users` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


CREATE TABLE `UsersKeys` (
  `pseudo_` varchar(15) NOT NULL,
  `keySetDate` datetime NOT NULL,
  `privateK` varchar(4000) NOT NULL,
  `publicK` varchar(1000) NOT NULL,
  PRIMARY KEY (`pseudo_`,`keySetDate`),
  CONSTRAINT `FK-UsersKeys.pseudo-FROM-Users` FOREIGN KEY (`pseudo_`) REFERENCES `Users` (`pseudo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- 2023-10-19 07:12:14
