-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 08 jan. 2023 à 12:55
-- Version du serveur : 5.7.33
-- Version de PHP : 8.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dp_gest_immo`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE `abonnement` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `formule_id` int(11) NOT NULL,
  `etat_abonnement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `frais` double NOT NULL,
  `etat_frais` tinyint(1) NOT NULL,
  `nbr_niveau` int(11) NOT NULL,
  `nbr_camera` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `abonnement`
--

INSERT INTO `abonnement` (`id`, `user_id`, `formule_id`, `etat_abonnement`, `prix`, `frais`, `etat_frais`, `nbr_niveau`, `nbr_camera`, `slug`) VALUES
(1, 11, 1, 'ATTENTE DE PAYEMENT', 5000, 200, 1, 2, 4, 'abnm-63907729abf0d'),
(2, 11, 1, 'ATTENTE DE VALIDATION', 12, 3500, 1, 2, 6, 'abnmnt-63b6429bc32b9'),
(3, 7, 1, 'ATTENTE DE PAYEMENT', 20000, 5000, 0, 4, 8, 'abnmnt-63b74817eab59');

-- --------------------------------------------------------

--
-- Structure de la table `abonnement_inscription`
--

CREATE TABLE `abonnement_inscription` (
  `id` int(11) NOT NULL,
  `inscription_id` int(11) DEFAULT NULL,
  `formule_id` int(11) DEFAULT NULL,
  `prix` double NOT NULL,
  `frais` double NOT NULL,
  `nbr_niveau` int(11) NOT NULL,
  `nbr_camera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `abonnement_inscription`
--

INSERT INTO `abonnement_inscription` (`id`, `inscription_id`, `formule_id`, `prix`, `frais`, `nbr_niveau`, `nbr_camera`) VALUES
(1, 3, 1, 5000, 200, 2, 4),
(2, NULL, 1, 12000, 2500, 2, 4),
(3, NULL, 1, 120002, 2500, 2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `abonnement_package`
--

CREATE TABLE `abonnement_package` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `etat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `abonnement_package`
--

INSERT INTO `abonnement_package` (`id`, `package_id`, `entreprise_id`, `etat`) VALUES
(1, 1, 1, 'DEMANDE');

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `camera`
--

CREATE TABLE `camera` (
  `id` int(11) NOT NULL,
  `niveau_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `referent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `referent_id`) VALUES
(5, NULL),
(8, NULL),
(10, NULL),
(11, NULL),
(4, 7),
(9, 7);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221121122633', '2022-11-21 12:26:55', 14255);

-- --------------------------------------------------------

--
-- Structure de la table `enregistrement`
--

CREATE TABLE `enregistrement` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rccm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ninea` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`id`, `libelle`, `rccm`, `ninea`, `slug`, `referent_id`) VALUES
(1, 'entreprise de fanta', 'rccm.pdf', 'ninea.pdf', 'etreprise-637cd5703b5e0', 7);

-- --------------------------------------------------------

--
-- Structure de la table `formule`
--

CREATE TABLE `formule` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix1` double NOT NULL,
  `prix2` double NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formule`
--

INSERT INTO `formule` (`id`, `libelle`, `prix1`, `prix2`, `details`, `etat`) VALUES
(1, 'Formule 1', 1000, 2000, 'Details formule 1 updated ', 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int(11) NOT NULL,
  `etat_inscription` tinyint(1) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` longtext COLLATE utf8mb4_unicode_ci,
  `entreprise_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `etat_inscription`, `nom`, `prenom`, `mail`, `login`, `password`, `telephone`, `region`, `pays`, `adresse`, `entreprise_id`) VALUES
(1, 1, 'rema', 'jordan', 'winigajordan@gmail.com', 'jordan', '1234', '772570206', 'Dakar', 'Sénégal', 'Fass', 1),
(2, 1, 'rema 2', 'jordan 2', 'winigajordan2@gmail.com', 'jordan 2', '1234', '7725570206', 'Dakar 2', 'Sénégall', 'Fassss', 1),
(3, 0, 'rema', 'jordan', 'jord@mail.com', 'jord', '1234', '772570206', 'dakar', 'seneal', 'aaaaaaaa', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

CREATE TABLE `niveau` (
  `id` int(11) NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `niveau`
--

INSERT INTO `niveau` (`id`, `site_id`, `libelle`, `slug`) VALUES
(5, 2, 'Niveau R+0', 'niveau-63b74afbcb610'),
(6, 2, 'Niveau R+1', 'niveau-63b74afbcb635'),
(7, 2, 'Niveau R+2', 'niveau-63b74afbcb64e'),
(8, 2, 'Niveau R+3', 'niveau-63b74afbcb667');

-- --------------------------------------------------------

--
-- Structure de la table `package`
--

CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `etat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `package`
--

INSERT INTO `package` (`id`, `libelle`, `details`, `prix`, `etat`) VALUES
(1, 'Package 1', 'details package 1', 50000, 1),
(2, 'Package 2', 'details package 2', 12500, 1);

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `referent`
--

CREATE TABLE `referent` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `referent`
--

INSERT INTO `referent` (`id`) VALUES
(6),
(7);

-- --------------------------------------------------------

--
-- Structure de la table `reglement_abonnement`
--

CREATE TABLE `reglement_abonnement` (
  `id` int(11) NOT NULL,
  `abonnement_id` int(11) NOT NULL,
  `start_at` date NOT NULL,
  `end_at` date NOT NULL,
  `paid_at` datetime NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_valide` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reglement_abonnement`
--

INSERT INTO `reglement_abonnement` (`id`, `abonnement_id`, `start_at`, `end_at`, `paid_at`, `type`, `is_valide`) VALUES
(1, 1, '2023-01-05', '2023-02-05', '2023-01-05 12:57:18', 'ONLINE', 1),
(2, 1, '2023-01-05', '2023-02-05', '2023-01-05 12:58:48', 'ONLINE', 1),
(3, 2, '2023-01-05', '2023-02-05', '2023-01-05 13:31:46', 'PHYSIQUE', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reglement_package`
--

CREATE TABLE `reglement_package` (
  `id` int(11) NOT NULL,
  `paid_at` date NOT NULL,
  `start_at` date NOT NULL,
  `end_at` date NOT NULL,
  `abonnement_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reglement_package`
--

INSERT INTO `reglement_package` (`id`, `paid_at`, `start_at`, `end_at`, `abonnement_id`) VALUES
(1, '2023-01-05', '2022-12-12', '2023-01-12', 1);

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

CREATE TABLE `site` (
  `id` int(11) NOT NULL,
  `abonnement_id` int(11) NOT NULL,
  `localisation` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `site`
--

INSERT INTO `site` (`id`, `abonnement_id`, `localisation`, `libelle`, `slug`) VALUES
(2, 3, ' ', 'Site de Fall 2', 'site-63b74afbcb58e');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` longtext COLLATE utf8mb4_unicode_ci,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dtype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `mail`, `login`, `password`, `telephone`, `region`, `pays`, `adresse`, `role`, `dtype`) VALUES
(4, 'Fall', 'Fanta', 'fanta@fall.com', 'fantafall', '1234', '123456789', 'Dakar', 'Senegal', 'hellooooo', 'PARTICULIER', 'client'),
(5, 'Fall', 'Fanta', 'fanta@fall.com', 'fantafall', '1234', '123456789', 'Dakar', 'Senegal', NULL, 'PARTICULIER', 'client'),
(6, 'Fall', 'Fanta', 'fanta@fall.com', 'fantafall', '1234', '123456789', 'Dakar', 'Senegal', ' ', 'REFERENT', 'referent'),
(7, 'Fall 2', 'Fanta', 'fanta@fall.com', 'fantafall', '1234', '123456789', 'Dakar', 'Senegal', ' ', 'REFERENT', 'referent'),
(8, 'rema', 'jordan', 'jord@mail.com', 'jord', '1234', '772570206', 'dakar', 'seneal', NULL, 'PARTICULIER', 'client'),
(9, 'rema', 'jordan', 'jord@mail.com', 'jord', '1234', '772570206', 'dakar', 'seneal', NULL, 'PARTICULIER', 'client'),
(10, 'rema', 'jordan', 'jord@mail.com', 'jord', '1234', '772570206', 'dakar', 'seneal', 'aaaaaaaa', 'PARTICULIER', 'client'),
(11, 'rema', 'jordan', 'jord@mail.com', 'jord', '12345', '772570206', 'dakar', 'seneal', 'aaaaaaaa', 'PARTICULIER', 'client');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_351268BBA76ED395` (`user_id`),
  ADD KEY `IDX_351268BB2A68F4D1` (`formule_id`);

--
-- Index pour la table `abonnement_inscription`
--
ALTER TABLE `abonnement_inscription`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_A8BB1AF75DAC5993` (`inscription_id`),
  ADD KEY `IDX_A8BB1AF72A68F4D1` (`formule_id`);

--
-- Index pour la table `abonnement_package`
--
ALTER TABLE `abonnement_package`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BE3ADAFDF44CABFF` (`package_id`),
  ADD KEY `IDX_BE3ADAFDA4AEAFEA` (`entreprise_id`);

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_23A0E66E6ADA943` (`cat_id`);

--
-- Index pour la table `camera`
--
ALTER TABLE `camera`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3B1CEE05B3E9C81` (`niveau_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C744045535E47E35` (`referent_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `enregistrement`
--
ALTER TABLE `enregistrement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D19FA6035E47E35` (`referent_id`);

--
-- Index pour la table `formule`
--
ALTER TABLE `formule`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5E90F6D6A4AEAFEA` (`entreprise_id`);

--
-- Index pour la table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4BDFF36BF6BD1646` (`site_id`);

--
-- Index pour la table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `referent`
--
ALTER TABLE `referent`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reglement_abonnement`
--
ALTER TABLE `reglement_abonnement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A4169FA4F1D74413` (`abonnement_id`);

--
-- Index pour la table `reglement_package`
--
ALTER TABLE `reglement_package`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6CA96A2FF1D74413` (`abonnement_id`);

--
-- Index pour la table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_694309E4F1D74413` (`abonnement_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `abonnement_inscription`
--
ALTER TABLE `abonnement_inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `abonnement_package`
--
ALTER TABLE `abonnement_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `camera`
--
ALTER TABLE `camera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `enregistrement`
--
ALTER TABLE `enregistrement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `formule`
--
ALTER TABLE `formule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `niveau`
--
ALTER TABLE `niveau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reglement_abonnement`
--
ALTER TABLE `reglement_abonnement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reglement_package`
--
ALTER TABLE `reglement_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `site`
--
ALTER TABLE `site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD CONSTRAINT `FK_351268BB2A68F4D1` FOREIGN KEY (`formule_id`) REFERENCES `formule` (`id`),
  ADD CONSTRAINT `FK_351268BBA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `abonnement_inscription`
--
ALTER TABLE `abonnement_inscription`
  ADD CONSTRAINT `FK_A8BB1AF72A68F4D1` FOREIGN KEY (`formule_id`) REFERENCES `formule` (`id`),
  ADD CONSTRAINT `FK_A8BB1AF75DAC5993` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`);

--
-- Contraintes pour la table `abonnement_package`
--
ALTER TABLE `abonnement_package`
  ADD CONSTRAINT `FK_BE3ADAFDA4AEAFEA` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprise` (`id`),
  ADD CONSTRAINT `FK_BE3ADAFDF44CABFF` FOREIGN KEY (`package_id`) REFERENCES `package` (`id`);

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `FK_880E0D76BF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66E6ADA943` FOREIGN KEY (`cat_id`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `camera`
--
ALTER TABLE `camera`
  ADD CONSTRAINT `FK_3B1CEE05B3E9C81` FOREIGN KEY (`niveau_id`) REFERENCES `niveau` (`id`);

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_C744045535E47E35` FOREIGN KEY (`referent_id`) REFERENCES `referent` (`id`),
  ADD CONSTRAINT `FK_C7440455BF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD CONSTRAINT `FK_D19FA6035E47E35` FOREIGN KEY (`referent_id`) REFERENCES `referent` (`id`);

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `FK_5E90F6D6A4AEAFEA` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprise` (`id`);

--
-- Contraintes pour la table `niveau`
--
ALTER TABLE `niveau`
  ADD CONSTRAINT `FK_4BDFF36BF6BD1646` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);

--
-- Contraintes pour la table `referent`
--
ALTER TABLE `referent`
  ADD CONSTRAINT `FK_FE9AAC6CBF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reglement_abonnement`
--
ALTER TABLE `reglement_abonnement`
  ADD CONSTRAINT `FK_A4169FA4F1D74413` FOREIGN KEY (`abonnement_id`) REFERENCES `abonnement` (`id`);

--
-- Contraintes pour la table `reglement_package`
--
ALTER TABLE `reglement_package`
  ADD CONSTRAINT `FK_6CA96A2FF1D74413` FOREIGN KEY (`abonnement_id`) REFERENCES `abonnement_package` (`id`);

--
-- Contraintes pour la table `site`
--
ALTER TABLE `site`
  ADD CONSTRAINT `FK_694309E4F1D74413` FOREIGN KEY (`abonnement_id`) REFERENCES `abonnement` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
