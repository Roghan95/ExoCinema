-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour cinema
CREATE DATABASE IF NOT EXISTS `cinema` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinema`;

-- Listage de la structure de table cinema. acteur
CREATE TABLE IF NOT EXISTS `acteur` (
  `id_acteur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_acteur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `acteur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.acteur : ~5 rows (environ)
INSERT INTO `acteur` (`id_acteur`, `id_personne`) VALUES
	(13, 14),
	(11, 15),
	(12, 16),
	(14, 19),
	(15, 30);

-- Listage de la structure de table cinema. film
CREATE TABLE IF NOT EXISTS `film` (
  `id_film` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `dateSortie` date NOT NULL,
  `duree` int NOT NULL,
  `synopsis` text NOT NULL,
  `id_realisateur` int NOT NULL,
  `noteFilm` int DEFAULT NULL,
  `afficheFilm` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id_film`),
  KEY `id_realisateur` (`id_realisateur`),
  CONSTRAINT `film_ibfk_1` FOREIGN KEY (`id_realisateur`) REFERENCES `realisateur` (`id_realisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.film : ~2 rows (environ)
INSERT INTO `film` (`id_film`, `titre`, `dateSortie`, `duree`, `synopsis`, `id_realisateur`, `noteFilm`, `afficheFilm`) VALUES
	(6, 'En eaux très troubles', '2023-08-02', 116, 'Cet été, préparez-vous à une décharge d’adrénaline avec EN EAUX TRÈS TROUBLES ! Film d’action survolté, ce deuxième opus plus gigantesque encore que le blockbuster de 2018 plonge le spectateur dans des eaux toujours plus profondes, où grouillent de redoutables megalodons, et bien plus…', 9, 5, 'public\\img\\troubles.jpg'),
	(7, 'Oppenheimer', '2023-07-19', 181, 'En 1942, convaincus que l’Allemagne nazie est en train de développer une arme nucléaire, les États-Unis initient, dans le plus grand secret, le "Projet Manhattan" destiné à mettre au point la première bombe atomique de l’histoire. Pour piloter ce dispositif, le gouvernement engage J. Robert Oppenheimer, brillant physicien, qui sera bientôt surnommé "le père de la bombe atomique". C’est dans le laboratoire ultra-secret de Los Alamos, au cœur du désert du Nouveau-Mexique, que le scientifique et son équipe mettent au point une arme révolutionnaire dont les conséquences, vertigineuses, continuent de peser sur le monde actuel… ', 8, 5, 'public\\img\\oppenheimer.jpg');

-- Listage de la structure de table cinema. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.genre : ~6 rows (environ)
INSERT INTO `genre` (`id_genre`, `nom`) VALUES
	(11, 'Biopic'),
	(12, 'Historique'),
	(13, 'Thriller'),
	(14, 'Action'),
	(15, 'Aventure'),
	(16, 'Sci-Fi');

-- Listage de la structure de table cinema. genrer
CREATE TABLE IF NOT EXISTS `genrer` (
  `id_film` int NOT NULL,
  `id_genre` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_genre`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `genrer_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `genrer_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.genrer : ~5 rows (environ)
INSERT INTO `genrer` (`id_film`, `id_genre`) VALUES
	(7, 11),
	(7, 12),
	(6, 13),
	(7, 13),
	(6, 14);

-- Listage de la structure de table cinema. jouer
CREATE TABLE IF NOT EXISTS `jouer` (
  `id_acteur` int NOT NULL,
  `id_film` int NOT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`id_acteur`,`id_film`,`id_role`),
  KEY `id_film` (`id_film`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `jouer_ibfk_1` FOREIGN KEY (`id_acteur`) REFERENCES `acteur` (`id_acteur`),
  CONSTRAINT `jouer_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `jouer_ibfk_3` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.jouer : ~4 rows (environ)
INSERT INTO `jouer` (`id_acteur`, `id_film`, `id_role`) VALUES
	(12, 6, 7),
	(14, 6, 8),
	(11, 7, 10),
	(13, 7, 9);

-- Listage de la structure de table cinema. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `sexe` varchar(50) NOT NULL,
  `dateNaissance` date NOT NULL,
  `photoAR` varchar(255) DEFAULT NULL,
  `biographie` text,
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.personne : ~17 rows (environ)
INSERT INTO `personne` (`id_personne`, `nom`, `prenom`, `sexe`, `dateNaissance`, `photoAR`, `biographie`) VALUES
	(14, 'Murphy', 'Cillian', 'H', '1976-05-25', 'public\\img\\CillianMurphy.jpg', 'Cillian Murphy est né d\'une mère professeur de français et d\'un père travaillant pour le ministère irlandais de l\'Éducation. C\'est au théâtre qu\'il se fait d\'abord connaître, notamment avec une prestation dans la pièce Disco Pigs, mais également dans Beaucoup de bruit pour rien et The Shape of things, mise en scène par Neil LaBute.'),
	(15, 'Florence', 'Pugh', 'F', '2023-08-21', 'public\\img\\FlorencePugh.jpg', 'Née en Angleterre, c\'est pourtant en Andalousie que grandit Florence Pugh. De retour avec sa famille à Oxford lorsqu\'elle avait 11 ans, elle commence la comédie dans les pièces de théâtre de son école. Elle fait ses débuts en 2014 aux côtés de Maisie Williams dans le drame The Falling. Son talent lui permet d\'être vite repérée : trois ans plus tard, elle tient le premier rôle de The Young Lady.'),
	(16, 'Jason', 'Statham', 'H', '1967-07-26', 'public\\img\\JasonStatham.jpg', 'Tour à tour plongeur olympique, mannequin et vendeur de bijoux au noir, Jason Statham est repéré, au détour d\'une promenade à Londres, par le réalisateur Guy Ritchie qui l\'engage pour son premier film, Arnaques, crimes et botanique, en 1998.'),
	(17, 'Wheatley', 'Ben', 'H', '1972-05-01', 'public\\img\\BenWheatley.jpg', 'Après avoir réalisé de nombreuses publicités et vidéos virales, Ben Wheatley signe la comédie Down Terrace. Il gagne en notoriété en 2012 lorsque sort son second long, Kill List. Il s\'agit d\'un thriller horrifique noir et hypnotique dans lequel deux anciens soldats devenus tueurs à gages se lancent dans un périple meurtrier les conduisant vers un final des plus terrifiants.'),
	(18, 'Nolan', 'Christopher', 'H', '1970-07-30', 'public\\img\\ChristopherNolan.webp', 'Né d\'un père anglais et d\'une mère américaine, Christopher Nolan a commencé dès son plus jeune âge à réaliser des films avec la caméra 8mm de son père, et ce malgré son daltonisme. Son court métrage en 8mm, Tarantella, est diffusé aux États-Unis sur la chaîne PBS alors qu\'il est encore étudiant en lettres à l\'Université de Londres.'),
	(19, 'Wu', 'Jing', 'H', '1974-04-03', 'public\\img\\JingWu.jpg', 'Tour à tour plongeur olympique, mannequin et vendeur de bijoux au noir, Jason Statham est repéré, au détour d\'une promenade à Londres, par le réalisateur Guy Ritchie qui l\'engage pour son premier film, Arnaques, crimes et botanique, en 1998.'),
	(20, 'test', 'test', 'h', '2023-08-23', 'public\\img\\JingWu.jpg', 'test'),
	(21, 'test', 'test', 'h', '2023-08-23', 'public\\img\\JingWu.jpg', 'test'),
	(22, 'test', 'test', 'h', '2023-08-23', 'public\\img\\JingWu.jpg', 'test'),
	(23, 'test', 'test', 'h', '2023-08-23', 'public\\img\\JingWu.jpg', 'test'),
	(24, 'test', 'test', 'h', '2023-08-23', 'public\\img\\JingWu.jpg', 'test'),
	(25, 'test', 'test', 'h', '2023-08-23', 'public\\img\\JingWu.jpg', 'test'),
	(26, 'test', 'test', 'h', '2023-08-24', 'public\\img\\JingWu.jpg', 'test'),
	(27, 'test', 'test', 'h', '2023-08-24', 'public\\img\\JingWu.jpg', 'test'),
	(28, 'test', 'test', 'h', '2023-08-24', 'public\\img\\JingWu.jpg', 'test'),
	(29, 'test', 'test', 'h', '2023-08-24', 'https://i.mydramalist.com/Y3KWPc.jpg', 'test'),
	(30, 'test', 'test', 'f', '2023-08-18', 'https://imgsrc.cineserie.com/2023/06/461469.jpg?ver=1', 'test');

-- Listage de la structure de table cinema. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_realisateur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `realisateur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.realisateur : ~7 rows (environ)
INSERT INTO `realisateur` (`id_realisateur`, `id_personne`) VALUES
	(9, 17),
	(8, 18),
	(10, 25),
	(11, 26),
	(12, 27),
	(13, 28),
	(14, 29);

-- Listage de la structure de table cinema. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `personnage` varchar(255) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.role : ~7 rows (environ)
INSERT INTO `role` (`id_role`, `personnage`) VALUES
	(7, 'Jonas Taylor'),
	(8, 'Jiuming Zhang'),
	(9, 'J.Robert Oppenheimer'),
	(10, 'Jean Tatlock'),
	(11, 'Danny Rourke'),
	(12, 'Emily Blunt'),
	(13, 'Emily Blunt');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
