-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `projet_din_mai_2020`
--

-- --------------------------------------------------------

--
-- Structure de la table `Contacts`
--

CREATE TABLE `Contacts` (
  `pseudo_` varchar(15) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `contactStatus` enum('know','unknow','blocked') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Discussions`
--

CREATE TABLE `Discussions` (
  `discuID` varchar(25) NOT NULL,
  `discuName` varchar(15) DEFAULT NULL,
  `discuSetDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Messages`
--

CREATE TABLE `Messages` (
  `msgID` varchar(25) NOT NULL,
  `discuId` varchar(25) NOT NULL,
  `from_pseudo` varchar(15) NOT NULL,
  `msgPublicK` varchar(512) NOT NULL,
  `msgType` enum('text','image') NOT NULL,
  `msg` text NOT NULL,
  `msgSetDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Participants`
--

CREATE TABLE `Participants` (
  `discuId` varchar(25) NOT NULL,
  `pseudo_` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Professions`
--

CREATE TABLE `Professions` (
  `profession` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE `Users` (
  `pseudo` varchar(15) NOT NULL,
  `password` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `picture` varchar(25) NOT NULL,
  `status` varchar(250) NOT NULL,
  `permission` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Users_Professions`
--

CREATE TABLE `Users_Professions` (
  `pseudo_` varchar(15) NOT NULL,
  `profession_` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Contacts`
--
ALTER TABLE `Contacts`
  ADD PRIMARY KEY (`pseudo_`,`contact`),
  ADD KEY `FK-Contacts.contact-FROM-Users` (`contact`);

--
-- Index pour la table `Discussions`
--
ALTER TABLE `Discussions`
  ADD PRIMARY KEY (`discuID`);

--
-- Index pour la table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`msgID`,`discuId`) USING BTREE,
  ADD KEY `FK-Messages.discuId-FROM-Discussions` (`discuId`),
  ADD KEY `FK-Messages.from_pseudo-FROM-Users` (`from_pseudo`);

--
-- Index pour la table `Participants`
--
ALTER TABLE `Participants`
  ADD PRIMARY KEY (`discuId`,`pseudo_`),
  ADD KEY `FK-Participants.pseudo_-FROM-Discussions` (`pseudo_`);

--
-- Index pour la table `Professions`
--
ALTER TABLE `Professions`
  ADD PRIMARY KEY (`profession`);

--
-- Index pour la table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`pseudo`);

--
-- Index pour la table `Users_Professions`
--
ALTER TABLE `Users_Professions`
  ADD PRIMARY KEY (`pseudo_`,`profession_`),
  ADD KEY `FK-Users_Professions.profession_-FROM-Professions` (`profession_`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Contacts`
--
ALTER TABLE `Contacts`
  ADD CONSTRAINT `FK-Contacts.contact-FROM-Users` FOREIGN KEY (`contact`) REFERENCES `Users` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK-Contacts.pseudo_-FROM-Users` FOREIGN KEY (`pseudo_`) REFERENCES `Users` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `FK-Messages.discuId-FROM-Discussions` FOREIGN KEY (`discuId`) REFERENCES `Discussions` (`discuID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK-Messages.from_pseudo-FROM-Users` FOREIGN KEY (`from_pseudo`) REFERENCES `Users` (`pseudo`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Participants`
--
ALTER TABLE `Participants`
  ADD CONSTRAINT `FK-Participants.discuId-FROM-Discussions` FOREIGN KEY (`discuId`) REFERENCES `Discussions` (`discuID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK-Participants.pseudo_-FROM-Discussions` FOREIGN KEY (`pseudo_`) REFERENCES `Users` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Users_Professions`
--
ALTER TABLE `Users_Professions`
  ADD CONSTRAINT `FK-Users_Professions.profession_-FROM-Professions` FOREIGN KEY (`profession_`) REFERENCES `Professions` (`profession`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK-Users_Professions.pseudo_-FROM-Users` FOREIGN KEY (`pseudo_`) REFERENCES `Users` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;



