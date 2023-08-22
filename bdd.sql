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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.acteur : ~8 rows (environ)
INSERT INTO `acteur` (`id_acteur`, `id_personne`) VALUES
	(4, 4),
	(2, 6),
	(7, 7),
	(5, 8),
	(6, 9),
	(8, 11),
	(9, 12),
	(11, 24);

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

-- Listage des données de la table cinema.film : ~5 rows (environ)
INSERT INTO `film` (`id_film`, `titre`, `dateSortie`, `duree`, `synopsis`, `id_realisateur`, `noteFilm`, `afficheFilm`) VALUES
	(1, 'Oppenheimer', '2023-07-19', 181, 'Pendant la Seconde Guerre mondiale, le lieutenant-général Leslie Groves Jr. nomme le physicien J. Robert Oppenheimer pour travailler sur le projet ultra-secret Manhattan. Oppenheimer et une équipe de scientifiques passent des années à développer et à concevoir la bombe atomique.', 1, 5, 'public\\img\\oppenheimer.jpg'),
	(2, 'Barbie', '2023-07-19', 114, 'Barbie, qui vit à Barbie Land, est expulsée du pays pour être loin d\'être une poupée à l\'apparence parfaite; n\'ayant nulle part où aller, elle part pour le monde humain et cherche le vrai bonheur.', 3, 5, 'public\\img\\barbie.webp'),
	(3, 'The Dark Knight, Le Chevalier noir', '2023-08-13', 152, 'Batman est plus que jamais déterminé à éradiquer le crime organisé qui sème la terreur en ville.', 1, 5, 'public\\img\\batman.jpg'),
	(4, 'En eaux très troubles', '2023-08-02', 116, 'Cet été, préparez-vous à une décharge d’adrénaline avec EN EAUX TRÈS TROUBLES ! Film d’action survolté, ce deuxième opus plus gigantesque encore que le blockbuster de 2018 plonge le spectateur dans des eaux toujours plus profondes, où grouillent de redoutables megalodons, et bien plus…', 1, 5, 'public\\img\\troubles.jpg'),
	(5, 'Hypnotic', '2023-08-23', 94, 'Déterminé à retrouver sa fille, le détective Danny Rourke, enquête sur une série de braquages qui pourraient être liés à sa disparition', 7, 5, 'public\\img\\hypnotic.jpg');

-- Listage de la structure de table cinema. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.genre : ~10 rows (environ)
INSERT INTO `genre` (`id_genre`, `nom`) VALUES
	(1, 'Fiction historique'),
	(2, 'Comédie'),
	(3, 'Action'),
	(4, 'Science Fiction'),
	(5, 'Thriller'),
	(6, 'Drame'),
	(7, 'Fantastique'),
	(8, 'Biopic'),
	(9, 'Historique'),
	(17, '');

-- Listage de la structure de table cinema. genrer
CREATE TABLE IF NOT EXISTS `genrer` (
  `id_film` int NOT NULL,
  `id_genre` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_genre`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `genrer_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `genrer_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.genrer : ~10 rows (environ)
INSERT INTO `genrer` (`id_film`, `id_genre`) VALUES
	(1, 1),
	(2, 2),
	(3, 3),
	(4, 3),
	(5, 3),
	(6, 3),
	(7, 3),
	(1, 5),
	(3, 5),
	(4, 5);

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

-- Listage des données de la table cinema.jouer : ~6 rows (environ)
INSERT INTO `jouer` (`id_acteur`, `id_film`, `id_role`) VALUES
	(2, 1, 3),
	(7, 1, 4),
	(4, 2, 2),
	(6, 3, 1),
	(8, 4, 6),
	(9, 5, 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.personne : ~10 rows (environ)
INSERT INTO `personne` (`id_personne`, `nom`, `prenom`, `sexe`, `dateNaissance`, `photoAR`, `biographie`) VALUES
	(4, 'Robbie', 'Margot', 'F', '1990-07-02', 'public\\img\\MargotRobbie.webp', 'Surnommée la « nouvelle reine d\'Hollywood »2 et sex-symbol de la Génération Z, elle se fait d’abord connaître en Australie en 2008 en décrochant un rôle régulier dans le soap opera à succès Les Voisins, rôle qu\'elle tiendra quatre ans et qui lui permettra de décrocher deux nominations aux Logie Awards. Elle s\'exporte ensuite à Hollywood, où elle devient l\'un des personnages centraux de la mini-série historique Pan Am. '),
	(5, 'Christopher', 'Nolan', 'M', '1970-07-30', 'public\\img\\ChristopherNolan.webp', 'Ses films ont rapporté plus de 5 milliards de dollars dans le monde et ont obtenu onze Oscars sur trente-six nominations. Lauréat de nombreux prix et distinctions, il a été nommé pour cinq Oscars, cinq British Academy Film Awards et six Golden Globes. En 2015, Time le désigne comme l\'une des cent personnes les plus influentes dans le monde, tandis qu\'en 2019, il est nommé à l\'ordre de l\'Empire britannique par la reine Élisabeth II pour services rendus aux arts cinématographiques. '),
	(6, 'Murphy', 'Cillian', 'M', '1976-05-25', 'public\\img\\CillianMurphy.jpg', 'Il a commencé sa carrière en tant que musicien de rock. Il a ensuite joué d\'abord au théâtre puis dans des courts métrages et des films indépendants à la fin des années 1990. Il se fait connaître dans plusieurs films tels que 28 Jours plus tard (2002), Retour à Cold Mountain (2003), Intermission (2003), Red Eye : Sous haute pression (2005) et Breakfast on Pluto (2005), pour lesquels il est nommé pour un Golden Globes du meilleur acteur dans une comédie musicale ou une comédie en 2006.'),
	(7, 'Florence', 'Pugh', 'F', '1996-01-03', 'public\\img\\FlorencePugh.jpg', 'Après avoir fait ses débuts dans le drame The Falling, Florence Pugh se fait connaître en 2016 grâce à son rôle principal dans The Young Lady, qui lui permet de remporter le prix de la meilleure actrice aux British Independent Film Awards. En 2018, elle est à l\'affiche de la mini-série télévisée The Little Drummer Girl. '),
	(8, 'Gerwig', 'Greta', 'F', '1983-08-04', 'public\\img\\GretaGerwig.webp', 'Principalement connue pour sa participation dans le mouvement cinématographique mumblecore, elle est révélée en 2010 avec le rôle de Florence Marr dans le long-métrage indépendant Greenberg, réalisé par Noah Baumbach. Elle fait ses débuts dans le cinéma grand public avec Sex Friends et Arthur, un amour de milliardaire, l\'année suivante, avant de tourner sous la direction de Woody Allen dans To Rome with Love. En 2013, elle tient le rôle-titre dans la comédie dramatique Frances Ha, dont elle a écrit le scénario avec le réalisateur, qui rencontre un large accueil favorable auprès de la critique, ce qui lui permet d\'être nommée au Golden Globe de la meilleure actrice dans un film musical ou une comédie en 2014. '),
	(9, 'Bale', 'Christian', 'M', '1974-01-30', 'public\\img\\ChristianBale.webp', 'Il attire l\'attention du public dès l\'âge de 13 ans, lorsqu\'il obtient le rôle principal du film Empire du soleil (1987) de Steven Spielberg, tiré du roman du même nom de J. G. Ballard. Il y joue un jeune garçon anglais, séparé de ses parents pendant la Seconde Guerre mondiale et qui découvre la vie dans un camp d\'internement japonais. En 2000, il reçoit des critiques élogieuses pour son interprétation du tueur en série Patrick Bateman dans American Psycho. Adepte de la « Méthode », il perd 28 kilos en 2003 pour tenir le rôle de Trevor Reznik dans The Machinist, avant de reprendre 45 kilos six mois plus tard afin de tenir le rôle titre dans Batman Begins. Sa capacité à assurer de telles transformations physiques lui vaut d\'être l\'un des acteurs les plus demandés de sa génération. '),
	(10, 'Wheatley', 'Ben', 'M', '1972-05-01', 'public\\img\\BenWheatley.jpg', 'Avant de commencer sa carrière au cinéma avec Down Terrace et surtout Kill List qui l\'a révélé, Wheatley a réalisé une centaine de publicités et de vidéos virales. Il collabore régulièrement avec sa femme Amy Jump pour l\'écriture des scénarios2. '),
	(11, 'Statham', 'Jason', 'M', '1967-07-26', 'public\\img\\JasonStatham.jpg', 'Il est surtout renommé pour son rôle de Frank Martin dans les trois premiers films de la saga d\'action Le Transporteur, mais également pour ses collaborations avec Guy Ritchie (Snatch) ou Sylvester Stallone (dans la série de films Expendables), ainsi que pour plusieurs films de la série Fast and Furious. '),
	(12, 'Affleck', 'Ben', 'M', '1972-08-15', 'public\\img\\BenAffleck.webp', 'Il est révélé en 1997 par Will Hunting, un succès critique et commercial réalisé par Gus Van Sant, et qu\'il a coécrit avec son ami Matt Damon, et où ils remportent l\'Oscar du meilleur scénario original. Il s\'impose parallèlement comme un acteur fétiche du réalisateur indépendant Kevin Smith : Les Glandeurs (1995), Méprise multiple (1997), Dogma (1999), Jay et Bob contre-attaquent (2001), Clerks 2 (2006), Jay and Silent Bob Reboot (2019) et Clerks 3 (2022).'),
	(13, 'Rodriguez', 'Robert', 'M', '1968-06-20', 'public\\img\\RobertRodriguez.webp', 'Diplômé de l\'université du Texas à Austin, il est connu pour tourner des films à petit budget qui rencontrent souvent un grand succès public et dans lesquels il occupe de nombreux « postes ». Son premier long métrage El Mariachi est ainsi produit pour seulement 7 000 dollars et est présenté dans divers festivals (Toronto, Sundance ou encore la Berlinale 1993). Les critiques sont assez bonnes et le film est remarqué par les grands studios hollywoodiens3. Ce film connaîtra deux suites. Robert Rodriguez développe ensuite des films d\'aventures avec la franchise familiale Spy Kids (2001-2011). ');

-- Listage de la structure de table cinema. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_realisateur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `realisateur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.realisateur : ~7 rows (environ)
INSERT INTO `realisateur` (`id_realisateur`, `id_personne`) VALUES
	(1, 5),
	(3, 8),
	(6, 10),
	(7, 13),
	(8, 21),
	(9, 22),
	(10, 23);

-- Listage de la structure de table cinema. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `personnage` varchar(255) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.role : ~6 rows (environ)
INSERT INTO `role` (`id_role`, `personnage`) VALUES
	(1, 'Batman'),
	(2, 'Barbie'),
	(3, 'J. Robert Oppenheimer'),
	(4, 'Jean Tatlock'),
	(5, 'Danny Rourke'),
	(6, 'Jason Statham');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;