-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour sfformations-ugo
CREATE DATABASE IF NOT EXISTS `sfformations-ugo` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sfformations-ugo`;

-- Listage de la structure de la table sfformations-ugo. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfformations-ugo.categorie : ~2 rows (environ)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`id`, `nom_categorie`) VALUES
	(1, 'Front-end');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Listage de la structure de la table sfformations-ugo. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table sfformations-ugo.doctrine_migration_versions : ~2 rows (environ)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20221202101418', '2022-12-02 10:14:39', 596),
	('DoctrineMigrations\\Version20221202123147', '2022-12-02 12:31:51', 208);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Listage de la structure de la table sfformations-ugo. formateur
CREATE TABLE IF NOT EXISTS `formateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfformations-ugo.formateur : ~2 rows (environ)
/*!40000 ALTER TABLE `formateur` DISABLE KEYS */;
INSERT INTO `formateur` (`id`, `prenom`, `nom`, `email`, `phone`) VALUES
	(1, 'Mickael', 'MUHRMANN', 'micka@gmail.com', '06 06 06 06 06'),
	(2, 'Stephane', 'SMAIL', 'stephaneS@yahoo.fr', '06 05 05 05 05'),
	(3, 'Quentin', 'MATHIEU', 'quentik@gmail.com', '07 00 00 00 01');
/*!40000 ALTER TABLE `formateur` ENABLE KEYS */;

-- Listage de la structure de la table sfformations-ugo. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfformations-ugo.messenger_messages : ~0 rows (environ)
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;

-- Listage de la structure de la table sfformations-ugo. module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) NOT NULL,
  `nom_module` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C242628BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_C242628BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfformations-ugo.module : ~3 rows (environ)
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` (`id`, `categorie_id`, `nom_module`) VALUES
	(1, 1, 'HTML5'),
	(2, 1, 'CSS3'),
	(3, 1, 'JS');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;

-- Listage de la structure de la table sfformations-ugo. programmer
CREATE TABLE IF NOT EXISTS `programmer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `duree` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4136CCA9613FECDF` (`session_id`),
  KEY `IDX_4136CCA9AFC2B591` (`module_id`),
  CONSTRAINT `FK_4136CCA9613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session_formation` (`id`),
  CONSTRAINT `FK_4136CCA9AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfformations-ugo.programmer : ~3 rows (environ)
/*!40000 ALTER TABLE `programmer` DISABLE KEYS */;
INSERT INTO `programmer` (`id`, `session_id`, `module_id`, `duree`) VALUES
	(1, 1, 1, 12),
	(2, 1, 2, 5),
	(3, 1, 3, 10);
/*!40000 ALTER TABLE `programmer` ENABLE KEYS */;

-- Listage de la structure de la table sfformations-ugo. session_formation
CREATE TABLE IF NOT EXISTS `session_formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formateur_id` int(11) NOT NULL,
  `intitule` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `place_total` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3A264B5155D8F51` (`formateur_id`),
  CONSTRAINT `FK_3A264B5155D8F51` FOREIGN KEY (`formateur_id`) REFERENCES `formateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfformations-ugo.session_formation : ~2 rows (environ)
/*!40000 ALTER TABLE `session_formation` DISABLE KEYS */;
INSERT INTO `session_formation` (`id`, `formateur_id`, `intitule`, `date_debut`, `date_fin`, `place_total`) VALUES
	(1, 2, 'Developpeur Web', '2022-03-15', '2022-10-13', 4),
	(3, 3, 'Remise a niveau', '2023-01-12', '2023-06-14', 12);
/*!40000 ALTER TABLE `session_formation` ENABLE KEYS */;

-- Listage de la structure de la table sfformations-ugo. stagiaire
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfformations-ugo.stagiaire : ~5 rows (environ)
/*!40000 ALTER TABLE `stagiaire` DISABLE KEYS */;
INSERT INTO `stagiaire` (`id`, `prenom`, `nom`, `email`, `phone`, `city`, `cp`, `adresse`) VALUES
	(1, 'Ugo', 'DA SILVA', 'ugodasilva67@gmail.com', '06 44 72 26 72', 'Strasbourg', '67100', '33A route du polygone'),
	(2, 'Selcuk', 'YALCIN', 'selcuk@mail', '07 06 06 06 07', 'Molsheim', '67120', 'rue du local'),
	(3, 'Antonin', 'PARIS', 'anton@yahoo.fr', '06 00 01 01 02', 'Nancy', '54000', '5 rue de la paix'),
	(4, 'Pauline', 'ROSER FERNBACH', 'pauline.fernbach6@yahoo.fr', '07 00 00 07 70', 'Strasbourg', '67100', '33A route du polygone'),
	(5, 'Amelia', 'KRIEGER', 'amelie@gmail.com', '07 10 02 40 15', 'Gambsheim', '67760', 'impasse du Coq');
/*!40000 ALTER TABLE `stagiaire` ENABLE KEYS */;

-- Listage de la structure de la table sfformations-ugo. stagiaire_session_formation
CREATE TABLE IF NOT EXISTS `stagiaire_session_formation` (
  `stagiaire_id` int(11) NOT NULL,
  `session_formation_id` int(11) NOT NULL,
  PRIMARY KEY (`stagiaire_id`,`session_formation_id`),
  KEY `IDX_8D88E948BBA93DD6` (`stagiaire_id`),
  KEY `IDX_8D88E9489C9D95AF` (`session_formation_id`),
  CONSTRAINT `FK_8D88E9489C9D95AF` FOREIGN KEY (`session_formation_id`) REFERENCES `session_formation` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_8D88E948BBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfformations-ugo.stagiaire_session_formation : ~4 rows (environ)
/*!40000 ALTER TABLE `stagiaire_session_formation` DISABLE KEYS */;
INSERT INTO `stagiaire_session_formation` (`stagiaire_id`, `session_formation_id`) VALUES
	(1, 1),
	(3, 1),
	(4, 1),
	(5, 1);
/*!40000 ALTER TABLE `stagiaire_session_formation` ENABLE KEYS */;

-- Listage de la structure de la table sfformations-ugo. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfformations-ugo.user : ~0 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
