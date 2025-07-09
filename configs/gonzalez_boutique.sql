-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 09 juil. 2025 à 15:20
-- Version du serveur : 8.3.0
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gonzalez_boutique`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `_GetAllClients`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `_GetAllClients` ()   BEGIN
    SELECT * FROM client;
END$$

DROP PROCEDURE IF EXISTS `_GetAllProduits`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `_GetAllProduits` ()   BEGIN
    SELECT * FROM produit;
END$$

--
-- Fonctions
--
DROP FUNCTION IF EXISTS `_GetTotalProduits`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `_GetTotalProduits` () RETURNS INT DETERMINISTIC BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total FROM Produit;
    RETURN total;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(500) NOT NULL,
  `mdp` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `login`, `mdp`) VALUES
(1, 'lucas', '123');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`) VALUES
(5, 'smartphone');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `rue` varchar(255) NOT NULL,
  `codePostal` int NOT NULL,
  `ville` varchar(255) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `rue`, `codePostal`, `ville`, `tel`, `email`, `mdp`) VALUES
(83, 'gonzalez', 'lucas', '2 chemin du rec destric', 11200, 'nevian', '0623596045', 'lucas.gonz2702@gmail.com', 'lucas27022005');

--
-- Déclencheurs `client`
--
DROP TRIGGER IF EXISTS `before_client_insert`;
DELIMITER $$
CREATE TRIGGER `before_client_insert` BEFORE INSERT ON `client` FOR EACH ROW BEGIN
    IF EXISTS (SELECT 1 FROM client WHERE email = NEW.email) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Un client avec cette adresse e-mail existe déjà.';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_client_update`;
DELIMITER $$
CREATE TRIGGER `before_client_update` BEFORE UPDATE ON `client` FOR EACH ROW BEGIN
    IF EXISTS (
        SELECT 1 
        FROM client 
        WHERE email = NEW.email AND id != OLD.id
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Un client avec cette adresse e-mail existe déjà.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` varchar(50) DEFAULT NULL,
  `idClient` int DEFAULT NULL,
  `statut` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `moyenPaiement` varchar(20) NOT NULL,
  `total` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `idClient` (`idClient`)
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `date`, `idClient`, `statut`, `moyenPaiement`, `total`) VALUES
(161, '2025-06-04', 83, 'Payé', 'CB', 341.00),
(162, '2025-06-04', 83, 'Payé', 'CB', 332.00),
(163, '2025-06-04', 83, 'En attente', 'CB', 998.00),
(164, '2025-06-04', 83, 'En attente', 'CB', 150.00);

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `rue` varchar(255) NOT NULL,
  `codePostal` int NOT NULL,
  `ville` varchar(255) NOT NULL,
  `tel` int NOT NULL,
  `email` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id`, `nom`, `rue`, `codePostal`, `ville`, `tel`, `email`) VALUES
(3, 'Fournisseur Samsung', '6 rue Fructidor', 11475, 'Suwon', 822225501, 'samsung@fournisseur.com'),
(4, 'Fournisseur Apple', '3-5 rue Saint-Georges', 75009, 'Cupertino', 2147483647, 'apple@fournisseur.com'),
(5, 'Fournisseur Xiaomi', '3 rue des oubliers', 11300, 'Pékin', 805370916, 'service.fr@xiaomi.fr'),
(8, 'Fournisseur Huawei', '2 rue du fournisseur de tel', 11200, 'Huaway', 659846351, 'FournisseurHuawei@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `lignedecommande`
--

DROP TABLE IF EXISTS `lignedecommande`;
CREATE TABLE IF NOT EXISTS `lignedecommande` (
  `idCommande` int NOT NULL,
  `idProduit` int NOT NULL,
  `quantite` int DEFAULT NULL,
  `prixUnitaire` decimal(10,2) DEFAULT NULL,
  `sousTotal` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idCommande`,`idProduit`),
  KEY `idProduit` (`idProduit`),
  KEY `idCommande` (`idCommande`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lignedecommande`
--

INSERT INTO `lignedecommande` (`idCommande`, `idProduit`, `quantite`, `prixUnitaire`, `sousTotal`) VALUES
(161, 20, 2, 170.00, 0),
(162, 21, 1, 332.00, 0),
(163, 32, 1, 998.00, 0),
(164, 40, 1, 150.00, 0);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id`, `nom`) VALUES
(1, 'Samsung'),
(2, 'Iphone'),
(3, 'Xiaomi'),
(6, 'Honor'),
(7, 'Wiko'),
(8, 'Huawei');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `prix` decimal(6,2) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `couleur` varchar(255) DEFAULT NULL,
  `stockage` varchar(255) DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `taille` decimal(2,1) NOT NULL,
  `Prix_Achat` decimal(20,0) NOT NULL,
  `idCategorie` int DEFAULT NULL,
  `idFournisseur` int DEFAULT NULL,
  `idMarque` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idCategorie` (`idCategorie`),
  KEY `idFournisseur` (`idFournisseur`),
  KEY `produit_ibfk_3` (`idMarque`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `description`, `prix`, `image`, `couleur`, `stockage`, `stock`, `taille`, `Prix_Achat`, `idCategorie`, `idFournisseur`, `idMarque`) VALUES
(20, 'Samsung Galaxy S9', 'Samsung Galaxy S9 - RAM 4 Go / Mémoire interne 64 Go 5.8\" - Bleu corail', 170.99, 'S9BleuCorail.jpg', 'Bleu ', '64', 52, 5.8, 85, 5, 3, 1),
(21, 'Samsung Galaxy S10', 'Smartphone Samsung Galaxy S10 Double SIM 128 Go Noir Prisme', 332.99, 'S10NoirPrisme.jpg', ' Noir ', '128', 96, 6.3, 166, 5, 3, 1),
(22, 'Samsung Galaxy S10+', 'Samsung Galaxy S10+ Duos 128Go noir prisme', 589.99, 'S10+NoirPrisme.jpg', 'Noir', '128', 24, 6.4, 295, 5, 3, 1),
(23, 'Samsung Galaxy Note 10', 'Samsung Galaxy Note 10 256 Go Noir', 350.99, 'Note10Noir.jpg', 'Noir', '256', 55, 6.3, 175, 5, 3, 1),
(24, 'Samsung Galaxy S20 5G', 'Samsung Galaxy S20 5G - double SIM - RAM 12 Go / Mémoire interne 128 Go - microSD slot - écran OEL -', 320.99, 'S205GGris.jpg', 'Gris', '128', 55, 6.3, 160, 5, 3, 1),
(25, 'Samsung Galaxy S20 Ultra 5G', 'Samsung Galaxy S20 Ultra 5G - double SIM - RAM 12 Go / Mémoire interne 128 Go - microSD slot - écran', 390.99, 'S20Ultra5GNoir.jpg', 'Noir', '128', 74, 6.7, 195, 5, 3, 1),
(26, 'Samsung Galaxy S20 FE', 'Samsung Galaxy S20FE 6.5\" Double SIM 5G 128 Go Bleu', 260.99, 'S20FeBleu.jpg', 'Bleu', '128', 88, 6.5, 130, 5, 3, 1),
(27, 'Samsung S21 FE', 'Smartphone Samsung Galaxy S21 FE 6.4\" 5G Double SIM 128 Go Graphite', 345.99, 'S21FeGraphite.jpg', 'Graphite', '128', 10, 6.4, 173, 5, 3, 1),
(28, 'Samsung Galaxy S21', 'Samsung Galaxy S21 6,2\" 256 Go 5G Double SIM Gris', 367.99, 'S21Gris.jpg', 'Gris', '256', 52, 6.3, 184, 5, 3, 1),
(29, 'Samsung Galaxy S21 Ultra', 'Samsung Galaxy S21 Ultra 6,8\" 128 Go 5G Double SIM Noir', 430.99, 'S21UltraNoir.jpg', 'Noir', '128', 78, 6.8, 215, 5, 3, 1),
(30, 'Samsung Galaxy S22', 'Samsung Galaxy S22 6.1\" Double SIM 5G 8 Go RAM 128 Go Noir', 600.99, 'S22Noir.jpg', 'Noir', '128', 28, 6.3, 300, 5, 3, 1),
(31, 'Samsung Galaxy S22+', 'Samsung Galaxy S22+ 6.6\" Double SIM 5G 8 Go RAM 256 Go Noir', 503.99, 'S22+Noir.jpg', 'Noir', '256', 63, 6.6, 252, 5, 3, 1),
(32, 'Samsung S22 Ultra', 'Samsung Galaxy S22 Ultra 6.8\" Double SIM 5G 8 Go RAM 128 Go Noir', 998.99, 'S22UltraNoir.jpg', 'Noir', '128', 68, 6.8, 499, 5, 3, 1),
(33, 'Samsung Galaxy S23', 'Samsung Galaxy S23 6.1\" Nano SIM 5G 8 Go RAM 128 Go Noir', 780.99, 'S23Noir.jpg', 'Noir', '128', 78, 6.3, 390, 5, 3, 1),
(34, 'Samsung Galaxy S23 Ultra', 'Samsung Galaxy S23 Ultra 6.8\" Nano SIM 5G 8 Go RAM 256 Go Noir', 1199.00, 'S23UltraNoir.jpg', 'Noir', '128', 85, 6.8, 600, 5, 3, 1),
(35, 'Samsung Galaxy S23+', 'Samsung Galaxy S23+ 6.6\" Nano SIM 5G 8 Go RAM 256 Go Noir', 970.99, 'S23+Noir.jpg', 'Noir', '256', 58, 6.6, 485, 5, 3, 1),
(36, 'Samsung Galaxy S24', 'Samsung Galaxy S24 6,2\" 5G Nano SIM 128 Go Argent', 899.99, 'S24Argent.jpg', 'Argent', '128', 58, 6.3, 450, 5, 3, 1),
(37, 'Samsung Galaxy S24 Ultra', 'Samsung Galaxy S24 Ultra 6,8\" 5G Nano SIM 512 Go Noir', 1469.99, 'S24UltraNoir.png', 'Noir', '512', 35, 6.8, 735, 5, 3, 1),
(38, 'Samsung Galaxy S24+', 'Samsung Galaxy S24+ 6,7\" 5G Nano SIM 512 Go Noir', 1113.99, 'S24+Noir.jpg', 'Noir', '512', 23, 6.7, 557, 5, 3, 1),
(40, 'Iphone 8', 'Apple iPhone 8 64 Go 4.7\" Blanc', 150.99, 'Iphone8Blanc.png', 'Blanc', '64', 52, 4.7, 75, 5, 4, 2),
(41, 'Iphone X', 'Apple iPhone X 64 Go 5,8\" Blanc', 214.99, 'IphoneXBlanc.png', 'Blanc', '64', 45, 5.8, 107, 5, 4, 2),
(43, 'Iphone XS', 'Apple iPhone XS 64 Go 5.8 Gris sidéral', 250.99, 'IphoneXSGrissidéral.png', 'Gris', '64', 45, 5.8, 125, 5, 4, 2),
(45, 'Iphone 12', 'iPhone 12 Mini 64Go Bleu', 406.99, 'Iphone12Bleu.png', 'Bleu', '64', 85, 6.3, 203, 5, 4, 2),
(46, 'Iphone 11', 'iPhone 11 64 Go 6.1\" Noir', 290.99, 'Iphone11Noir.png', 'Noir', '64', 45, 6.3, 145, 5, 4, 2),
(47, 'Iphone 11 Pro', ' iPhone 11 Pro 64 Go 5.8\" Gris Sidéral', 336.99, 'Iphone11ProGrissidéral.png', 'Gris', '64', 100, 5.8, 168, 5, 4, 2),
(48, 'Iphone 11 Pro Max', 'iPhone 11 Pro Max 64 Go Vert de minuit', 420.99, 'Iphone11ProMaxVertdeminuit.png', 'Vert', '64', 85, 6.5, 210, 5, 4, 2),
(49, 'Iphone 13', 'iPhone 13 6,1\" 256 Go Vert', 823.99, 'Iphone13Vert.png', 'Vert', '256', 20, 6.3, 412, 5, 4, 2),
(50, 'Iphone 13 Mini', 'iPhone 13 mini 5,4\" 512 Go Bleu', 793.99, 'Iphone13MiniBleu.png', 'Bleu', '512', 12, 5.4, 397, 5, 4, 2),
(51, 'Iphone 13 Pro', 'iPhone 13 Pro 6,1\" 128 Go Bleu', 658.99, 'Iphone13ProBleu.png', 'Bleu', '128', 65, 6.3, 329, 5, 4, 2),
(53, 'Iphone 14', 'iPhone 14 6.1\" 128 Go Noir minuit', 869.99, 'Iphone14Noirminuit.png', 'Noir ', '128', 96, 6.3, 435, 5, 4, 2),
(54, 'Iphone 14 Plus', 'iPhone 14 Plus 6.7\" 128 Go Noir minuit', 969.99, 'Iphone14PlusNoirminuit.png', 'Noir', '128', 58, 6.7, 485, 5, 4, 2),
(55, 'Iphone 14 Pro', 'iPhone 14 Pro 6,1\" 1To Or', 1320.99, 'Iphone14ProOr.png', 'Or', '1000', 78, 6.3, 660, 5, 4, 2),
(56, 'Iphone 14 Pro Max', 'iPhone 14 Pro Max 6,7\" 128 Go Or', 1248.99, 'Iphone14ProMaxOr.png', 'Or', '128', 53, 6.7, 624, 5, 4, 2),
(57, 'Xiaomi Redmi Note 12', 'Redmi Note 12 6,67\" 128 Go Bleu', 190.99, 'XiaomiRedmiNote12Bleu.jpg', 'Bleu', '128', 12, 6.6, 95, 5, 5, 3),
(58, 'Xiaomi Redmi 13C', 'Redmi 13C 6,74\" Bleu marine 128 Go', 159.90, 'Redmi13CBleumarine.jpg', 'Bleu ', '128', 41, 6.7, 80, 5, 5, 3),
(59, 'Xiaomi Redmi 12', 'Redmi 12 6,79\" Polar Silver 128 Go', 200.99, 'Redmi12Polarsilver.jpg', 'Polar ', '128', 85, 6.7, 100, 5, 5, 3),
(60, 'Xiaomi Redmi A2', 'Redmi A2 6,52\" Noir 32 Go', 129.90, 'RedmiA2Noir.jpg', 'Noir', '32', 58, 6.5, 65, 5, 5, 3),
(61, 'Xiaomi Redmi 12C', 'Redmi 12C 6,71\" Gris Graphite 64 Go', 120.99, 'Redmi12CGrisgraphite.jpg', 'Graphite', '64', 56, 6.7, 60, 5, 5, 3),
(62, 'Xiaomi Redmi 10A', 'Redmi 10A 6,53\" Argent chromé 32 Go', 99.90, 'Redmi10AArgentchromé.jpg', 'Argent', '32', 23, 6.5, 50, 5, 5, 3),
(63, 'Xiaomi Redmi Note 11S', 'Redmi Note 11S 6,43\" Gris Graphite 128 Go', 179.90, 'Redmi11SGrisgraphite.jpg', 'Graphite', '128', 10, 6.4, 90, 5, 5, 3),
(64, 'Xiaomi Redmi 10', 'Redmi 10 6,5\" Bleu Glacier 64 Go', 119.90, 'Redmi10Bleuglacier.jpg', 'Bleu ', '64', 52, 6.5, 60, 5, 5, 3),
(65, 'Xiaomi Redmi 10C', 'Redmi 10C 6,71\" Bleu Océan 64 Go', 99.90, 'Redmi10CBleuocéan.jpg', 'Bleu ', '64', 89, 6.7, 50, 5, 5, 3),
(66, 'Xiaomi 13T Pro', 'Xiaomi 13T Pro 6,67\" Vert 1 To', 849.90, 'Xiaomi13TProVert.jpg', 'Vert', '1000', 50, 6.6, 425, 5, 5, 3),
(67, 'Xiaomi 13T', 'Xiaomi 13T 6,67\" Vert 256 Go', 649.90, 'Xiaomi13TVert.jpg', 'Vert', '256 ', 96, 6.6, 325, 5, 5, 3),
(68, 'Xiaomi 13 Ultra', 'Xiaomi 13 Ultra 6,73\" Vert 512 Go', 1499.90, 'Xiaomi13UltraVert.jpg', 'Vert', '512 ', 40, 6.7, 750, 5, 5, 3),
(69, 'Xiaomi 13', 'Xiaomi 13 6,36\" Vert 256 Go', 999.90, 'Xiaomi13Vert.jpg', 'Vert', '256 ', 80, 6.3, 500, 5, 5, 3),
(70, 'Xiaomi 12 Lite', 'Xiaomi 12 Lite 6,55\" Rose 128 Go', 449.90, 'Xiaomi13LiteRose.jpg', 'Rose', '128 ', 50, 6.5, 225, 5, 5, 3),
(71, 'Xiaomi 12T', 'Xiaomi 12T 6,67\" Bleu 8 GO + 256 Go', 399.00, 'Xiaomi12TBleu.jpg', 'Bleu', '128', 60, 6.6, 200, 5, 5, 3),
(72, 'Xiaomi 12T Pro', 'Xiaomi 12T Pro 6,67\" Argent 256 Go', 799.90, 'Xiaomi12TProArgent.jpg', 'Argent', '256 ', 40, 6.6, 400, 5, 5, 3),
(73, 'Xiaomi 12X', 'Xiaomi 12X Violet 128 6,28\" Go', 769.90, 'Xiaomi12XViolet.jpg', 'Violet', '128 ', 40, 6.2, 385, 5, 5, 3),
(74, 'Xiaomi 12 Pro', 'Xiaomi 12 Pro 6,73\" Violet 256 Go', 1099.90, 'Xiaomi12ProViolet.jpg', 'Violet', '256 ', 50, 6.7, 550, 5, 5, 3),
(91, 'Iphone 15 pro', 'Iphone 15 pro 128Go 6.1\" Noir', 1250.00, 'Iphone15ProNoir.png', 'Noir', '128', 52, 6.3, 625, 5, 4, 2),
(92, 'Huawei P30', 'Smartphone Huawei P30 Double SIM 128 Go bleu 6.7', 135.00, 'HuaweiP30Bleu.jpg', 'Bleu', '128', 6, 6.7, 68, 5, 8, 8);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `lignedecommande`
--
ALTER TABLE `lignedecommande`
  ADD CONSTRAINT `lignedecommande_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `commande` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lignedecommande_ibfk_2` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `produit_ibfk_2` FOREIGN KEY (`idFournisseur`) REFERENCES `fournisseur` (`id`),
  ADD CONSTRAINT `produit_ibfk_3` FOREIGN KEY (`idMarque`) REFERENCES `marque` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
