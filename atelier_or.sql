-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 05 juil. 2025 à 18:58
-- Version du serveur : 9.1.0
-- Version de PHP : 8.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `atelier_or`
--

-- --------------------------------------------------------

--
-- Structure de la table `approvisionnement`
--

DROP TABLE IF EXISTS `approvisionnement`;
CREATE TABLE IF NOT EXISTS `approvisionnement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_appro` date NOT NULL,
  `quantite` int NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `montant` decimal(12,2) NOT NULL,
  `observation` text,
  `article_confection_id` int NOT NULL,
  `fournisseur_id` int NOT NULL,
  `responsable_stock_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_confection_id` (`article_confection_id`),
  KEY `fournisseur_id` (`fournisseur_id`),
  KEY `responsable_stock_id` (`responsable_stock_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `approvisionnement`
--

INSERT INTO `approvisionnement` (`id`, `date_appro`, `quantite`, `prix`, `montant`, `observation`, `article_confection_id`, `fournisseur_id`, `responsable_stock_id`) VALUES
(1, '2025-06-20', 5, 2000.00, 10000.00, '_', 4, 7, 1),
(3, '2025-06-20', 2, 7000.00, 14000.00, '_', 3, 10, 1),
(4, '2025-06-20', 2, 500.00, 1000.00, '_', 9, 7, 1),
(5, '2025-06-20', 2, 75000.00, 150000.00, '_', 7, 10, 2),
(6, '2025-06-20', 10, 2500.00, 25000.00, '_', 11, 10, 2),
(7, '2025-06-26', 20, 50.00, 1000.00, '_', 18, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `article_confection`
--

DROP TABLE IF EXISTS `article_confection`;
CREATE TABLE IF NOT EXISTS `article_confection` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `categorie` enum('confection') DEFAULT 'confection',
  `prix_achat` decimal(10,2) NOT NULL,
  `quantite_achat` int NOT NULL,
  `quantite_stock` int NOT NULL,
  `montant_stock` decimal(12,2) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `etat` enum('actif','archive') DEFAULT 'actif',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article_confection`
--

INSERT INTO `article_confection` (`id`, `libelle`, `categorie`, `prix_achat`, `quantite_achat`, `quantite_stock`, `montant_stock`, `photo`, `etat`) VALUES
(7, 'Machine à coudre', 'confection', 75000.00, 2, 10, 750000.00, 'articles_conf/article_685472ccbb0235.62690850.jpeg', 'actif'),
(3, 'Tissu en coton', 'confection', 5000.00, 50, 25, 125000.00, 'articles_conf/article_6857410e7af162.87335827.jpeg', 'actif'),
(4, 'Bobine de fils', 'confection', 2000.00, 10, 15, 30000.00, 'articles_conf/article_685464076aac33.58724578.jpeg', 'actif'),
(9, 'Mètres ruban', 'confection', 500.00, 20, 12, 6000.00, 'articles_conf/article_685474127190c5.52374551.jpeg', 'actif'),
(11, 'Ciseaux pour tissu', 'confection', 2500.00, 10, 15, 37500.00, 'articles_conf/article_6856b3d91b0f21.32754931.jpeg', 'actif'),
(12, 'Tissu wax', 'confection', 2000.00, 20, 10, 20000.00, 'articles_conf/article_685741d7e04184.15393177.jpeg', 'actif'),
(13, 'Tissu wax', 'confection', 2000.00, 20, 10, 20000.00, 'articles_conf/article_6857424ee70848.54789047.jpeg', 'actif'),
(14, 'Dentelle', 'confection', 1500.00, 15, 10, 15000.00, 'articles_conf/article_6857435a790135.06175559.jpeg', 'actif'),
(15, 'Dentelle ', 'confection', 1500.00, 15, 10, 15000.00, 'articles_conf/article_685743860467c5.25042286.jpeg', 'actif'),
(16, 'Tissu en lin', 'confection', 3000.00, 5, 5, 15000.00, 'articles_conf/article_68576dc9077997.83832198.jpeg', 'actif'),
(17, 'Agnellat Tissu', 'confection', 5000.00, 10, 5, 25000.00, 'articles_conf/article_68576eeeea05b4.32861890.jpeg', 'actif'),
(18, 'Aiguille', 'confection', 50.00, 20, 30, 1500.00, 'articles_conf/article_685dcfb9654ac3.19655730.jpeg', 'actif');

-- --------------------------------------------------------

--
-- Structure de la table `article_vente`
--

DROP TABLE IF EXISTS `article_vente`;
CREATE TABLE IF NOT EXISTS `article_vente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `categorie` enum('vente') DEFAULT 'vente',
  `prix_vente` decimal(10,2) NOT NULL,
  `quantite_stock` int NOT NULL,
  `montant_vente` decimal(12,2) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `etat` enum('actif','archive') DEFAULT 'actif',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article_vente`
--

INSERT INTO `article_vente` (`id`, `libelle`, `categorie`, `prix_vente`, `quantite_stock`, `montant_vente`, `photo`, `etat`) VALUES
(5, 'Costume Noir', 'vente', 20000.00, 3, 60000.00, 'articles_vente/vente_68576236452728.56077526.jpeg', 'actif'),
(4, 'Robe de soirée', 'vente', 15000.00, 18, 270000.00, 'articles_vente/vente_685761f7dfec29.43690014.jpeg', 'actif'),
(3, 'Pantalon large', 'vente', 4000.00, 3, 12000.00, 'articles_vente/vente_685763078bfcf8.04485124.jpeg', 'archive'),
(6, 'Costume Vert', 'vente', 15000.00, 15, 225000.00, 'articles_vente/vente_6857629ae698c1.49226684.jpeg', 'actif'),
(7, 'Jupe en Tuile', 'vente', 5000.00, 29, 145000.00, 'articles_vente/vente_685760e65b5ab5.55006163.jpeg', 'actif'),
(8, 'Veste rose', 'vente', 5000.00, 18, 90000.00, 'articles_vente/vente_685dd064e4cbc7.17629024.jpeg', 'actif');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone_portable` varchar(20) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `observation` text,
  `photo` varchar(255) DEFAULT NULL,
  `etat` enum('actif','archive') DEFAULT 'actif',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `telephone_portable`, `adresse`, `observation`, `photo`, `etat`) VALUES
(3, 'Bâ', 'Sékou', '778945869', 'Liberté 2', '', '', 'actif'),
(2, 'Waméogo', 'Loic', '789541262', 'Liberté 6', '', '', 'actif'),
(4, 'Kaboré', 'Judith', '859784631', 'Sacré-Coeur', '', '', 'actif'),
(5, 'Assimi', 'Koita', '852013647', 'Sally', '', '', 'actif');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone_portable` varchar(20) NOT NULL,
  `telephone_fixe` varchar(20) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `etat` enum('actif','archive') DEFAULT 'actif',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id`, `nom`, `prenom`, `telephone_portable`, `telephone_fixe`, `adresse`, `photo`, `etat`) VALUES
(5, 'Four', 'Nisseur', '778452137', '789664310', 'Mermoz', 'fournisseurs/fournisseur_6857504582a774.03021347.jpeg', 'archive'),
(4, 'Diakhaté', 'Babo', '769524828', '789654310', 'Sicap Karaq', 'fournisseurs/fournisseur_685812fc5b8811.89709350.jpg', 'actif'),
(7, 'Cissé', 'Binga', '459876321', '984102675', 'Thiaroye', 'fournisseurs/fournisseur_68574f70aba2a5.23243742.jpeg', 'actif'),
(10, 'Sawadogo', 'Eric', '785412305', '895476321', 'Parcelle', 'fournisseurs/fournisseur_68574fcf40b423.20842268.jpeg', 'actif'),
(11, 'Moussa', 'Boubakar', '01234568', '78451203', 'Cap Sud', 'fournisseurs/fournisseur_685dcf2e3c9046.26063140.png', 'actif');

-- --------------------------------------------------------

--
-- Structure de la table `production`
--

DROP TABLE IF EXISTS `production`;
CREATE TABLE IF NOT EXISTS `production` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_production` date NOT NULL,
  `quantite` int NOT NULL,
  `observation` text,
  `article_vente_id` int NOT NULL,
  `responsable_production_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_vente_id` (`article_vente_id`),
  KEY `responsable_production_id` (`responsable_production_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `production`
--

INSERT INTO `production` (`id`, `date_production`, `quantite`, `observation`, `article_vente_id`, `responsable_production_id`) VALUES
(1, '2025-06-20', 12, '_', 4, 1),
(2, '2025-06-20', 5, '_', 5, 1),
(3, '2025-06-20', 10, '_', 6, 1),
(4, '2025-06-21', 20, '_', 7, 1),
(5, '2025-06-26', 10, '_', 8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone_portable` varchar(20) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `salaire` decimal(10,2) DEFAULT '0.00',
  `login` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('gestionnaire','responsable_stock','responsable_production','vendeur') NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `etat` enum('actif','archive') DEFAULT 'actif',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `telephone_portable`, `adresse`, `salaire`, `login`, `mot_de_passe`, `role`, `photo`, `etat`) VALUES
(1, 'Ouédraogo', 'Rita', '778744975', 'Dakar', 3500000.00, 'rita', 'pass123', 'gestionnaire', '/aiguille-or/assets/photos_users/photo_6857193b6b0689.96968581.jpeg', 'actif'),
(2, 'Diatta', 'Alioune', '771234567', 'Dakar', 750000.00, 'alioune', 'ali123', 'responsable_stock', '/aiguille-or/assets/photos_users/photo_68571a25ca0711.24182745.jpeg', 'actif'),
(3, 'Ky', 'Marc', '748596134', 'Ouest-Foire', 500000.00, 'marc', 'marc123', 'responsable_production', '/aiguille-or/assets/photos_users/photo_68571a888801c3.25474585.jpeg', 'actif'),
(7, 'Mame', 'Jeska', '412586962', 'Ouest', 100000.00, 'duc', 'duc123', 'vendeur', '/aiguille-or/assets/photos_users/photo_685719b6493976.71206877.jpeg', 'actif'),
(8, 'Akossé', 'Eddy', '458796534', 'Sicap-Foire', 70000.00, 'eddy', 'eddy123', 'vendeur', '/aiguille-or/assets/photos_users/photo_68571f16db03d6.52835617.jpeg', 'actif'),
(9, 'Joly', 'Merveille', '123654789', 'Fass', 300000.00, 'mer', 'mer123', 'responsable_stock', '/aiguille-or/assets/photos_users/photo_68571f95177b14.44395545.jpeg', 'actif'),
(10, 'Mel', 'Belle', '789654128', 'Baobab', 500000.00, 'belle', 'belle123', 'responsable_production', '/aiguille-or/assets/photos_users/photo_68572032f3a9d5.62539562.jpeg', 'actif'),
(11, 'Bayala', 'Ruben', '857429612', 'Colobane', 1000000.00, 'ruben', 'ruben123', 'gestionnaire', '/aiguille-or/assets/photos_users/photo_685720bf5a4148.00677407.jpeg', 'actif'),
(12, 'Teuks', 'Papou', '159247568', 'Extention', 50000.00, 'pap', 'pap123', 'vendeur', '/aiguille-or/assets/photos_users/photo_68572157553ff7.91310362.jpeg', 'actif'),
(13, 'Lankouandé', 'Malika', '321654987', 'Dial Diop', 60000.00, 'mali', 'mali123', 'vendeur', '/aiguille-or/assets/photos_users/photo_685722224488f5.42287371.jpeg', 'actif');

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

DROP TABLE IF EXISTS `vente`;
CREATE TABLE IF NOT EXISTS `vente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_vente` date NOT NULL,
  `quantite` int NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `montant` decimal(12,2) NOT NULL,
  `observation` text,
  `article_vente_id` int NOT NULL,
  `client_id` int NOT NULL,
  `vendeur_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_vente_id` (`article_vente_id`),
  KEY `client_id` (`client_id`),
  KEY `vendeur_id` (`vendeur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `vente`
--

INSERT INTO `vente` (`id`, `date_vente`, `quantite`, `prix`, `montant`, `observation`, `article_vente_id`, `client_id`, `vendeur_id`) VALUES
(1, '2025-06-21', 2, 20000.00, 40000.00, '_', 5, 2, 1),
(2, '2025-06-21', 2, 20000.00, 40000.00, '_', 5, 3, 1),
(3, '2025-06-22', 2, 15000.00, 30000.00, '_', 4, 2, 1),
(4, '2025-06-21', 1, 5000.00, 5000.00, '_', 7, 4, 1),
(5, '2025-06-22', 2, 4000.00, 8000.00, '_', 3, 4, 1),
(6, '2025-06-26', 2, 5000.00, 10000.00, '_', 8, 4, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
