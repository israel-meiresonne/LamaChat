-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  ven. 21 août 2020 à 08:05
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `projet_din_mai_2020`
--
CREATE DATABASE IF NOT EXISTS `projet_din_mai_2020` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `projet_din_mai_2020`;

-- --------------------------------------------------------

--
-- Structure de la table `Contacts`
--

CREATE TABLE `Contacts` (
  `pseudo_` varchar(15) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `contactStatus` enum('know','blocked') NOT NULL DEFAULT 'know'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Contacts`
--

INSERT INTO `Contacts` (`pseudo_`, `contact`, `contactStatus`) VALUES
('pseudo2', 'terminator', 'blocked'),
('pseudo3', 'pseudo2', 'know'),
('terminator', 'pseudo2', 'know'),
('terminator', 'pseudo3', 'know'),
('terminator', 'pseudo4', 'know'),
('terminator', 'pseudo5', 'know'),
('terminator', 'skryska', 'know');

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
-- Structure de la table `Informations`
--

CREATE TABLE `Informations` (
  `information` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Informations`
--

INSERT INTO `Informations` (`information`) VALUES
('hobbit'),
('métier'),
('nationalité');

-- --------------------------------------------------------

--
-- Structure de la table `Messages`
--

CREATE TABLE `Messages` (
  `msgID` varchar(25) NOT NULL,
  `discuId` varchar(25) NOT NULL,
  `from_pseudo` varchar(15) NOT NULL,
  `msgPrivateK` varchar(4000) NOT NULL,
  `msgType` enum('text','file') NOT NULL,
  `msg` blob NOT NULL,
  `msgStatus` enum('read','sent') NOT NULL,
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
-- Structure de la table `Users`
--

CREATE TABLE `Users` (
  `pseudo` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `picture` varchar(50) DEFAULT 'default-user-picture.png',
  `status` varchar(250) DEFAULT 'hello world',
  `permission` enum('admin','user','banished','deleted') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Users`
--

INSERT INTO `Users` (`pseudo`, `password`, `firstname`, `lastname`, `birthdate`, `picture`, `status`, `permission`) VALUES
('mytest', '$2y$10$t80pozczfIIrM7ulnVQE5OQAtZD765D6PKvs2STwb9uZ7VVd7HjjK', 'prénomtest', 'nomtest', NULL, 'default-user-picture.png', 'hello world', 'user'),
('pseudo2', '$2y$10$t80pozczfIIrM7ulnVQE5OQAtZD765D6PKvs2STwb9uZ7VVd7HjjK', 'my-firstname', 'my-lastaname', '1997-04-01', 'user-test2.png', 'hello world2', 'user'),
('pseudo3', '$2y$10$t80pozczfIIrM7ulnVQE5OQAtZD765D6PKvs2STwb9uZ7VVd7HjjK', 'my-firstname', 'my-lastaname', '1997-04-01', 'user-test3.png', 'hello world', 'user'),
('pseudo4', '$2y$10$t80pozczfIIrM7ulnVQE5OQAtZD765D6PKvs2STwb9uZ7VVd7HjjK', 'my-firstname', 'my-lastaname', '1997-04-01', 'user-test4.png', 'hello world', 'user'),
('pseudo5', '$2y$10$t80pozczfIIrM7ulnVQE5OQAtZD765D6PKvs2STwb9uZ7VVd7HjjK', 'my-firstname', 'my-lastaname', '1997-04-01', '30aw08002570160o7j25.jpeg', 'hello world', 'user'),
('skryska', '$2y$10$t80pozczfIIrM7ulnVQE5OQAtZD765D6PKvs2STwb9uZ7VVd7HjjK', 'lola', 'lalo', NULL, '00729011022pc96d72aj.jpg', 'Born to die', 'user'),
('terminator', '$2y$10$t80pozczfIIrM7ulnVQE5OQAtZD765D6PKvs2STwb9uZ7VVd7HjjK', 'spiderman', 'larrraigné', NULL, 'ml1wv80ox00252020350.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `UsersKeys`
--

CREATE TABLE `UsersKeys` (
  `pseudo_` varchar(15) NOT NULL,
  `keySetDate` datetime NOT NULL,
  `privateK` varchar(4000) NOT NULL,
  `publicK` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Users_ Informations`
--

CREATE TABLE `Users_ Informations` (
  `pseudo_` varchar(15) NOT NULL,
  `information_` varchar(25) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Users_ Informations`
--

INSERT INTO `Users_ Informations` (`pseudo_`, `information_`, `value`) VALUES
('pseudo2', 'hobbit', 'pompe'),
('skryska', 'hobbit', 'kill hollows'),
('skryska', 'métier', 'living my hobbit'),
('skryska', 'nationalité', 'peculliar'),
('terminator', 'hobbit', 'escalade'),
('terminator', 'métier', 'streaper'),
('terminator', 'nationalité', 'espagnol');

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
-- Index pour la table `Informations`
--
ALTER TABLE `Informations`
  ADD PRIMARY KEY (`information`);

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
-- Index pour la table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`pseudo`);

--
-- Index pour la table `UsersKeys`
--
ALTER TABLE `UsersKeys`
  ADD PRIMARY KEY (`pseudo_`,`keySetDate`);

--
-- Index pour la table `Users_ Informations`
--
ALTER TABLE `Users_ Informations`
  ADD PRIMARY KEY (`pseudo_`,`information_`),
  ADD KEY `FK-Users_Professions.profession_-FROM-Professions` (`information_`);

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
-- Contraintes pour la table `UsersKeys`
--
ALTER TABLE `UsersKeys`
  ADD CONSTRAINT `FK-UsersKeys.pseudo-FROM-Users` FOREIGN KEY (`pseudo_`) REFERENCES `Users` (`pseudo`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Users_ Informations`
--
ALTER TABLE `Users_ Informations`
  ADD CONSTRAINT `FK-Users_Professions.profession_-FROM-Professions` FOREIGN KEY (`information_`) REFERENCES `Informations` (`information`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK-Users_Professions.pseudo_-FROM-Users` FOREIGN KEY (`pseudo_`) REFERENCES `Users` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;
