-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 19 mai 2026 à 06:54
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `g_stock`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prenom`, `adresse`, `email`, `telephone`) VALUES
(1, 'aaaa', 'aaa', '', 'cyriasc@gmail.com', '673683509'),
(2, 'xczx', 'xzczxc', 'sdasd', 'zxcz@gmail.com', '655656558');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `FK_commande_id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_user`, `date`, `total`, `statut`) VALUES
(1, 1, '2026-05-17', 5000.00, 'Terminée'),
(2, 1, '2026-05-17', 7500.00, 'Terminée');

-- --------------------------------------------------------

--
-- Structure de la table `detail_commande`
--

DROP TABLE IF EXISTS `detail_commande`;
CREATE TABLE IF NOT EXISTS `detail_commande` (
  `id_detail_commande` int NOT NULL AUTO_INCREMENT,
  `id_commande` int DEFAULT NULL,
  `id_produit` int DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_detail_commande`),
  KEY `FK_detail_commande_id_commande` (`id_commande`),
  KEY `FK_detail_commande_id_produit` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `detail_commande`
--

INSERT INTO `detail_commande` (`id_detail_commande`, `id_commande`, `id_produit`, `quantite`, `prix_unitaire`) VALUES
(1, 1, 3, 10, 500.00),
(2, 2, 3, 15, 500.00);

-- --------------------------------------------------------

--
-- Structure de la table `detail_vente`
--

DROP TABLE IF EXISTS `detail_vente`;
CREATE TABLE IF NOT EXISTS `detail_vente` (
  `id_detail_vente` int NOT NULL AUTO_INCREMENT,
  `id_vente` int DEFAULT NULL,
  `id_produit` int DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_detail_vente`),
  KEY `FK_detail_vente_id_vente` (`id_vente`),
  KEY `FK_detail_vente_id_produit` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `detail_vente`
--

INSERT INTO `detail_vente` (`id_detail_vente`, `id_vente`, `id_produit`, `quantite`, `prix`) VALUES
(1, 1, 3, 1, 550.00),
(2, 2, 3, 6, 550.00);

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id_fournisseur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_fournisseur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id_fournisseur`, `nom`, `prenom`, `email`, `adresse`) VALUES
(1, 'zxczx', 'xzczxf', 'zxc@gmail.com', 'fdsd'),
(2, 'cyc', 'cyc', 'cyc@gmail.com', 'dsdf');

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id_paiement` int NOT NULL AUTO_INCREMENT,
  `id_vente` int DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `mode` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_paiement`),
  KEY `FK_paiement_id_vente` (`id_vente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id_permission` int NOT NULL AUTO_INCREMENT,
  `designation` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_permission`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`id_permission`, `designation`) VALUES
(1, 'AJOUTER_CLIENT'),
(2, 'MODIFIER_CLIENT'),
(3, 'SUPPRIMER_CLIENT'),
(4, 'VOIR_CLIENT'),
(5, 'AJOUTER_FOURNISSEUR'),
(6, 'MODIFIER_FOURNISSEUR'),
(7, 'SUPPRIMER_FOURNISSEUR'),
(8, 'VOIR_FOURNISSEUR'),
(9, 'AJOUTER_PRODUIT'),
(10, 'MODIFIER_PRODUIT'),
(11, 'SUPPRIMER_PRODUIT'),
(12, 'VOIR_PRODUIT'),
(13, 'AJOUTER_COMMANDE'),
(14, 'MODIFIER_COMMANDE'),
(15, 'SUPPRIMER_COMMANDE'),
(16, 'VOIR_COMMANDE'),
(17, 'AJOUTER_VENTE'),
(18, 'MODIFIER_VENTE'),
(19, 'SUPPRIMER_VENTE'),
(20, 'VOIR_VENTE'),
(21, 'AJOUTER_UTILISATEUR'),
(22, 'MODIFIER_UTILISATEUR'),
(23, 'SUPPRIMER_UTILISATEUR'),
(24, 'VOIR_UTILISATEUR'),
(25, 'AJOUTER_ROLE'),
(26, 'MODIFIER_ROLE'),
(27, 'SUPPRIMER_ROLE'),
(28, 'VOIR_ROLE'),
(29, 'AJOUTER_STOCK'),
(30, 'MODIFIER_STOCK'),
(31, 'SUPPRIMER_STOCK'),
(32, 'VOIR_STOCK');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prix_achat` decimal(10,2) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `nom`, `prix_achat`, `prix_vente`, `photo`) VALUES
(1, 'sasa', 500.00, 600.00, NULL),
(2, 'ssd', 600.00, 500.00, '1779024054_6a09c0b62738c.png'),
(3, 'xcz', 500.00, 550.00, '1779024494_6a09c26e4dcef.png');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `designation` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `designation`) VALUES
(1, 'CLIENTS'),
(2, 'ADMINISTRATEUR');

-- --------------------------------------------------------

--
-- Structure de la table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE IF NOT EXISTS `role_permission` (
  `id_role` int NOT NULL,
  `id_permission` int NOT NULL,
  PRIMARY KEY (`id_role`,`id_permission`),
  KEY `FK_role_permission_id_permission` (`id_permission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `role_permission`
--

INSERT INTO `role_permission` (`id_role`, `id_permission`) VALUES
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32);

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id_stock` int NOT NULL AUTO_INCREMENT,
  `id_produit` int DEFAULT NULL,
  `id_fournisseur` int DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `date_peremption` date DEFAULT NULL,
  PRIMARY KEY (`id_stock`),
  KEY `FK_stock_id_produit` (`id_produit`),
  KEY `FK_stock_id_fournisseur` (`id_fournisseur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id_stock`, `id_produit`, `id_fournisseur`, `quantite`, `date_peremption`) VALUES
(1, 3, 1, 3, '2026-06-07'),
(2, 3, 2, 15, '2026-10-04');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `id_client` int DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_users_id_client` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `id_client`, `nom`, `prenom`, `contact`, `email`, `password`) VALUES
(1, NULL, 'choffo', 'cyrias', '655659053', 'ccyrias@gmail.com', '$2y$10$uyqtjlKmZOVZVKSUzR0pw.iXLLYqtSBmntM6BKKO.5f4SOarnzMRW'),
(2, 1, 'aaaa', 'aaa', '673683509', 'cyriasc@gmail.com', '$2y$10$NLfZSLEDHu6y8f.d/XNyku4Ad8Pypx5Jd8by2LsApzL2hv8SsByS.'),
(3, 2, 'xczx', 'xzczxc', '655656558', 'zxcz@gmail.com', '$2y$10$8TwtZGkBvyVHHcF./cqpduux0fT.05jnMEc1rLVyZzAzfjTmDtlwa'),
(4, NULL, 'dd', 'ddd', '650556598', 'sdasd@dfdsf.cm', '$2y$10$9Hc7ervzSHCzSO5eyu1FqeNghpHy5kQv1ztO6dAII7.E.LZsYLaUe'),
(11, NULL, 'vvv', 'vvv', '655986321', 'vvv@gmail.com', '$2y$10$CbPVdkv20quD5ej2jBXHTOAN1PqEogilm/uehxYpkwpic910DW5C2');

-- --------------------------------------------------------

--
-- Structure de la table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id_user` int NOT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`id_user`,`id_role`),
  KEY `FK_user_role_id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user_role`
--

INSERT INTO `user_role` (`id_user`, `id_role`) VALUES
(2, 1),
(3, 1),
(4, 2),
(11, 2);

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

DROP TABLE IF EXISTS `vente`;
CREATE TABLE IF NOT EXISTS `vente` (
  `id_vente` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `id_client` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_vente`),
  KEY `FK_vente_id_user` (`id_user`),
  KEY `FK_vente_id_client` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `vente`
--

INSERT INTO `vente` (`id_vente`, `id_user`, `id_client`, `date`, `total`, `statut`) VALUES
(1, 1, 2, '2026-05-17', 550.00, 'Livré'),
(2, 1, 1, '2026-05-19', 3300.00, 'Livré');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_commande_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `detail_commande`
--
ALTER TABLE `detail_commande`
  ADD CONSTRAINT `FK_detail_commande_id_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_detail_commande_id_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);

--
-- Contraintes pour la table `detail_vente`
--
ALTER TABLE `detail_vente`
  ADD CONSTRAINT `FK_detail_vente_id_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`),
  ADD CONSTRAINT `FK_detail_vente_id_vente` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id_vente`) ON DELETE CASCADE;

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `FK_paiement_id_vente` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id_vente`);

--
-- Contraintes pour la table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `FK_role_permission_id_permission` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id_permission`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_role_permission_id_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE;

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `FK_stock_id_fournisseur` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseur` (`id_fournisseur`),
  ADD CONSTRAINT `FK_stock_id_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_id_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `FK_user_role_id_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_user_role_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `vente`
--
ALTER TABLE `vente`
  ADD CONSTRAINT `FK_vente_id_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `FK_vente_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
