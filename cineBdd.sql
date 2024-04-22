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


-- Listage de la structure de la base pour cinebdd
CREATE DATABASE IF NOT EXISTS `cinebdd` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinebdd`;

-- Listage de la structure de table cinebdd. actor
CREATE TABLE IF NOT EXISTS `actor` (
  `id_actor` int NOT NULL AUTO_INCREMENT,
  `id_person` int NOT NULL,
  PRIMARY KEY (`id_actor`),
  UNIQUE KEY `id_person` (`id_person`),
  CONSTRAINT `actor_ibfk_1` FOREIGN KEY (`id_person`) REFERENCES `person` (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table cinebdd.actor : ~37 rows (environ)
INSERT INTO `actor` (`id_actor`, `id_person`) VALUES
	(1, 2),
	(2, 3),
	(3, 4),
	(6, 5),
	(4, 6),
	(5, 7),
	(11, 8),
	(12, 10),
	(13, 11),
	(14, 12),
	(15, 13),
	(16, 15),
	(17, 16),
	(18, 17),
	(19, 18),
	(20, 20),
	(21, 21),
	(22, 22),
	(23, 23),
	(24, 25),
	(25, 26),
	(26, 27),
	(27, 28),
	(28, 30),
	(29, 31),
	(30, 32),
	(31, 33),
	(32, 35),
	(33, 36),
	(34, 37),
	(35, 38),
	(36, 39),
	(37, 40),
	(38, 41),
	(39, 43),
	(40, 44),
	(41, 45);

-- Listage de la structure de table cinebdd. casting
CREATE TABLE IF NOT EXISTS `casting` (
  `id_movie` int NOT NULL,
  `id_actor` int NOT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`id_movie`,`id_actor`,`id_role`),
  KEY `id_actor` (`id_actor`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `casting_ibfk_1` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id_movie`),
  CONSTRAINT `casting_ibfk_2` FOREIGN KEY (`id_actor`) REFERENCES `actor` (`id_actor`),
  CONSTRAINT `casting_ibfk_3` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table cinebdd.casting : ~35 rows (environ)
INSERT INTO `casting` (`id_movie`, `id_actor`, `id_role`) VALUES
	(1, 1, 3),
	(2, 4, 5),
	(2, 5, 6),
	(2, 6, 4),
	(2, 11, 9),
	(3, 12, 10),
	(3, 13, 11),
	(3, 14, 12),
	(3, 15, 13),
	(4, 16, 14),
	(4, 17, 15),
	(4, 18, 16),
	(4, 19, 17),
	(5, 20, 21),
	(5, 21, 18),
	(5, 22, 19),
	(5, 23, 20),
	(6, 24, 22),
	(6, 25, 23),
	(6, 26, 24),
	(6, 27, 25),
	(7, 28, 26),
	(7, 29, 27),
	(7, 30, 28),
	(7, 31, 29),
	(8, 31, 30),
	(8, 32, 31),
	(8, 33, 32),
	(8, 34, 33),
	(9, 35, 34),
	(9, 36, 35),
	(9, 37, 36),
	(9, 38, 37),
	(10, 39, 41),
	(10, 40, 39),
	(10, 41, 40);

-- Listage de la structure de table cinebdd. director
CREATE TABLE IF NOT EXISTS `director` (
  `id_director` int NOT NULL AUTO_INCREMENT,
  `id_person` int NOT NULL,
  PRIMARY KEY (`id_director`) USING BTREE,
  UNIQUE KEY `id_person` (`id_person`),
  CONSTRAINT `director_ibfk_1` FOREIGN KEY (`id_person`) REFERENCES `person` (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table cinebdd.director : ~9 rows (environ)
INSERT INTO `director` (`id_director`, `id_person`) VALUES
	(2, 1),
	(3, 5),
	(4, 9),
	(5, 14),
	(6, 19),
	(7, 24),
	(8, 29),
	(9, 34),
	(10, 42);

-- Listage de la structure de table cinebdd. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `nameGenre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table cinebdd.genre : ~8 rows (environ)
INSERT INTO `genre` (`id_genre`, `nameGenre`) VALUES
	(1, 'Action'),
	(2, 'Fantastique'),
	(3, 'Science Fiction'),
	(4, 'Comédie'),
	(5, 'Drame'),
	(6, 'Thriller'),
	(7, 'Aventure'),
	(8, 'Romance'),
	(9, 'Epouvante-horreur'),
	(10, 'Science Fiction');

-- Listage de la structure de table cinebdd. genre_movie
CREATE TABLE IF NOT EXISTS `genre_movie` (
  `id_movie` int NOT NULL,
  `id_genre` int NOT NULL,
  PRIMARY KEY (`id_movie`,`id_genre`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `genre_movie_ibfk_1` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id_movie`),
  CONSTRAINT `genre_movie_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table cinebdd.genre_movie : ~21 rows (environ)
INSERT INTO `genre_movie` (`id_movie`, `id_genre`) VALUES
	(1, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(8, 1),
	(1, 2),
	(4, 2),
	(5, 2),
	(6, 2),
	(1, 3),
	(3, 3),
	(4, 3),
	(7, 3),
	(1, 4),
	(2, 4),
	(1, 5),
	(3, 5),
	(9, 5),
	(1, 6),
	(5, 6),
	(9, 6),
	(1, 7),
	(7, 7),
	(1, 8),
	(8, 8),
	(1, 9),
	(9, 9),
	(1, 10);

-- Listage de la structure de table cinebdd. movie
CREATE TABLE IF NOT EXISTS `movie` (
  `id_movie` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `releaseDate` datetime NOT NULL,
  `timeMovie` int DEFAULT NULL,
  `synopsis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `id_director` int NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_movie`),
  KEY `id_realisator` (`id_director`) USING BTREE,
  CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`id_director`) REFERENCES `director` (`id_director`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table cinebdd.movie : ~10 rows (environ)
INSERT INTO `movie` (`id_movie`, `title`, `releaseDate`, `timeMovie`, `synopsis`, `id_director`, `image_url`) VALUES
	(1, 'Godzilla x Kong : Le Nouvel Empire', '2024-04-03 00:00:00', 60, 'Le tout-puissant Kong et le redoutable Godzilla unissent leurs forces contre une terrible menace encore secrète qui risque de les anéantir et qui met en danger la survie même de l’espèce humaine. GODZILLA X KONG : LE NOUVEL EMPIRE remonte à l’origine des deux titans et aux mystères de Skull Island, tout en révélant le combat mythique qui a contribué à façonner ces deux créatures hors du commun et lié leur sort à celui de l’homme pour toujours…', 2, './public/img/films/godzillaxkong/godzilla_x_kong.jpg'),
	(2, 'Ducobu passe au vert', '2024-04-03 18:07:20', 80, 'Nouvelle rentrée à Saint-Potache. Cette année Ducobu a une idée de génie : prendre une année sabbatique pour sauver la planète mais surtout pour sécher l’école ! Mais Latouche ne compte pas le laisser faire si facilement… Tricheur et écolo, c’est pas du gâteau !', 3, './public/img/films/ducobu/ducobu.webp'),
	(3, 'Dune : Deuxième Partie', '2024-02-28 19:29:52', 166, 'Dans DUNE : DEUXIÈME PARTIE, Paul Atreides s’unit à Chani et aux Fremen pour mener la révolte contre ceux qui ont anéanti sa famille. Hanté par de sombres prémonitions, il se trouve confronté au plus grand des dilemmes : choisir entre l’amour de sa vie et le destin de l’univers.', 4, './public/img/films/dune2/dune2.webp'),
	(4, 'Captain Marvel', '2019-03-06 19:41:23', 124, 'Captain Marvel raconte l’histoire de Carol Danvers qui va devenir l’une des super-héroïnes les plus puissantes de l’univers lorsque la Terre se révèle l’enjeu d’une guerre galactique entre deux races extraterrestres.', 5, './public/img/films/captain/captain.jpg'),
	(5, 'Batman Forever', '1995-07-19 19:53:09', 122, 'Nul ne sait que Bruce Wayne, le patron d\'un vaste et puissant consortium, l\'homme le plus riche des Etats-Unis, revêt chaque nuit la combinaison et le masque de cuir de Batman pour voler au secours de ses concitoyens injustement opprimés. Personne, hormis son fidèle maître d\'hôtel Alfred et son vieil ami, le commissaire Gordon.', 6, './public/img/films/batmanforever/batman.jpg'),
	(6, 'Spider-Man 3', '2007-05-01 08:50:22', 139, 'Peter Parker a enfin réussi à concilier son amour pour Mary-Jane et ses devoirs de super-héros. Mais l\'horizon s\'obscurcit. La brutale mutation de son costume, qui devient noir, décuple ses pouvoirs et transforme également sa personnalité pour laisser ressortir l\'aspect sombre et vengeur que Peter s\'efforce de contrôler.', 7, './public/img/films/spiderman3/spiderman3.jpg'),
	(7, 'X-Men: Dark Phoenix', '2019-06-05 09:45:58', 114, 'Dans cet ultime volet, les X-MEN affrontent leur ennemi le plus puissant, Jean Grey, l’une des leurs.', 8, './public/img/films/darkphoenix/darkphoenix.jpg'),
	(8, 'Passengers', '2016-12-28 09:57:05', 117, 'Alors que 5000 passagers endormis pour longtemps voyagent dans l’espace vers une nouvelle planète, deux d’entre eux sont accidentellement tirés de leur sommeil artificiel 90 ans trop tôt. Jim et Aurora doivent désormais accepter l’idée de passer le reste de leur existence à bord du vaisseau spatial. Alors qu’ils éprouvent peu à peu une indéniable attirance, ils découvrent que le vaisseau court un grave danger. La vie des milliers de passagers endormis est entre leurs mains…', 9, './public/img/films/passengers/passengers.webp'),
	(9, 'A Horrible Way to Die', '2011-04-25 10:13:39', 85, 'Son ex était un meurtrier. Difficile de s’en remettre et d’aimer à nouveau, mais cette fois elle rencontre un type qui a l’air sympa…', 2, './public/img/films/horriblewaytodie/horrible_way_to_die.jpg'),
	(10, 'Le Challenge', '2023-06-21 10:35:13', 103, 'Maddie est sur le point de perdre sa maison d’enfance et elle pense avoir trouvé la solution à ses problèmes financiers lorsqu’elle tombe sur une offre d’emploi intrigante : parents fortunés cherchent quelqu’un pour emmener Percy, leur fils introverti de 19 ans, dans une série de « dates » afin de le décoincer avant qu’il ne parte pour l’université. A la grande surprise de Maddie, Percy rend ce challenge plus compliqué que prévu et le temps est compté. Elle a un été pour relever ce challenge ou se retrouver sans toit.', 10, './public/img/films/lechallenge/le_challenge.webp');

-- Listage de la structure de table cinebdd. person
CREATE TABLE IF NOT EXISTS `person` (
  `id_person` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birthday` datetime NOT NULL,
  `sex` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table cinebdd.person : ~45 rows (environ)
INSERT INTO `person` (`id_person`, `firstName`, `lastName`, `birthday`, `sex`, `image_url`) VALUES
	(1, 'Adam', 'Wingard', '1982-12-03 00:00:00', 'M', '010'),
	(2, 'Rebecca', 'Hall', '1982-05-03 17:34:51', 'F', './public/img/persons/RebeccaHall.webp'),
	(3, 'Brian', 'Tyree Henry', '1982-03-31 17:35:39', 'M', './public/img/persons/BrianTyreeHenry.jpg'),
	(4, 'Dan', 'Stevens', '1982-10-10 17:39:19', 'M', './public/img/persons/DanStevens.webp'),
	(5, 'Elie', 'Semoun', '1963-10-16 18:02:23', 'M', './public/img/persons/ElieSemoun.webp'),
	(6, 'Émilie', 'Caen', '1970-01-01 18:03:09', 'F', './public/img/persons/EmilieCaen.webp'),
	(7, 'Frédérique', 'Bel', '1975-03-24 18:05:37', 'F', './public/img/persons/FrederiqueBel.webp'),
	(8, 'Loïc', 'Legendre', '1978-03-01 19:18:09', 'M', './public/img/persons/LoicLegendre.webp'),
	(9, 'Denis', 'Villeneuve', '1967-10-03 19:23:53', 'M', './public/img/persons/DenisVilleneuve.webp'),
	(10, 'Timothée', 'Chalamet', '1995-12-27 19:24:44', 'M', './public/img/persons/ThimotheeChalamet.webp'),
	(11, 'Zendaya', 'Coleman', '1996-09-01 19:25:29', 'F', './public/img/persons/ZendayaColeman.webp'),
	(12, 'Rebecca ', 'Ferguson', '1983-10-19 19:26:14', 'F', './public/img/persons/RebeccaFerguson.webp'),
	(13, 'Josh', 'Brolin', '1968-02-12 19:26:47', 'M', './public/img/persons/JoshBrolin.webp'),
	(14, 'Anna', 'Boden', '1976-09-20 19:34:56', 'F', './public/img/persons/AnnaBoden.jpg'),
	(15, 'Brie', 'Larson', '1989-10-01 19:36:12', 'F', './public/img/persons/BrieLarson.webp'),
	(16, 'Samuel', 'L. Jackson', '1948-12-21 19:36:54', 'M', './public/img/persons/SamuelLJackson.webp'),
	(17, 'Jude', 'Law', '1972-12-29 19:37:32', 'M', './public/img/persons/JudeLaw.webp'),
	(18, 'Clark', 'Gregg', '1962-04-02 19:38:24', 'M', './public/img/persons/ClarkGregg.webp'),
	(19, 'Joel', 'Schumacher', '1939-08-29 19:46:39', 'M', './public/img/persons/JoelSchumacher.webp'),
	(20, 'Val ', 'Kilmer', '1959-12-31 19:47:55', 'M', './public/img/persons/ValKilmer.webp'),
	(21, 'Tommy', 'Lee Jones', '1946-09-15 19:48:50', 'M', './public/img/persons/tommyLeeJones.webp'),
	(22, 'Jim', 'Carrey', '1962-01-17 19:49:32', 'M', './public/img/persons/JimCarrey.webp'),
	(23, 'Nicole', 'Kidman', '1967-06-20 19:50:04', 'M', './public/img/persons/NicoleKidman.jpg'),
	(24, 'Sam', 'Raimi', '1959-10-23 08:43:14', 'M', './public/img/persons/SamRaimi.webp'),
	(25, 'Tobey', 'Maguire', '1975-06-27 08:44:17', 'M', './public/img/persons/TobeyMaguire.webp'),
	(26, 'Kirsten', 'Dunst', '1982-04-30 08:44:57', 'F', './public/img/persons/KirstenDunst.webp'),
	(27, 'James', 'Franco', '1978-04-19 08:45:46', 'M', './public/img/persons/JamesFranco.webp'),
	(28, 'Thomas', 'Haden Church', '1960-06-17 08:46:31', 'M', './public/img/persons/ThomasHadenChurch.webp'),
	(29, 'Simon', 'Kinberg', '1973-08-02 09:38:55', 'M', './public/img/persons/SimonKinberg.webp'),
	(30, 'Sophie', 'Turner', '1996-02-21 09:39:37', 'F', './public/img/persons/SophieTurner.jpg'),
	(31, 'James', 'McAvoy', '1979-04-21 09:40:35', 'M', './public/img/persons/JamesMcAvoy.webp'),
	(32, 'Michael ', 'Fassbender', '1977-04-02 09:41:11', 'M', './public/img/persons/MichaelFassbender.webp'),
	(33, 'Jennifer', 'Lawrence', '1990-08-15 09:41:39', 'F', './public/img/persons/JenniferLawrence.webp'),
	(34, 'Morten', 'Tyldum', '1967-05-19 09:51:09', 'M', './public/img/persons/MortenTyldum.webp'),
	(35, 'Chris', 'Pratt', '1979-06-21 09:52:01', 'M', './public/img/persons/ChrisPratt.webp'),
	(36, 'Michael', 'Sheen', '1969-02-05 09:53:02', 'M', './public/img/persons/MichaelSheen.webp'),
	(37, 'Laurence', 'Fishburne', '1961-07-30 09:53:49', 'M', './public/img/persons/LaurenceFishburne.webp'),
	(38, 'AJ', 'Bowen', '1977-12-21 10:05:01', 'M', './public/img/persons/AjBowen.jpg'),
	(39, 'Amy', 'Seimetz', '1981-11-25 10:05:43', 'F', './public/img/persons/AmySeimetz.webp'),
	(40, 'Joe', 'Swanberg', '1981-08-31 10:06:11', 'M', './public/img/persons/JoeSwanberg.webp'),
	(41, 'Lane', 'Hughes', '2024-04-09 10:06:41', 'M', './public/img/persons/LaneHughes.jpg'),
	(42, 'Gene', 'Stupnitsky', '1977-08-26 10:29:14', 'M', './public/img/persons/GeneStupnitsky.webp'),
	(43, 'Andrew', 'Barth Feldman', '2002-05-07 10:29:55', 'M', './public/img/persons/AndrewBarthFeldman.webp'),
	(44, 'Laura', 'Benanti', '1979-07-15 10:30:34', 'F', './public/img/persons/LauraBenandi.webp'),
	(45, 'Natalie', 'Morales', '1985-02-15 10:31:08', 'F', './public/img/persons/NatalieMorales.jpg');

-- Listage de la structure de table cinebdd. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `nameRole` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table cinebdd.role : ~39 rows (environ)
INSERT INTO `role` (`id_role`, `nameRole`) VALUES
	(1, 'Trapper'),
	(2, 'Bernies Hayes'),
	(3, 'Dr. Ilene Andrews'),
	(4, 'Gustave Latouche'),
	(5, 'Mademoiselle Rateau'),
	(6, 'Adeline Gratin'),
	(9, 'Hervé Ducobu'),
	(10, 'Paul Atreides'),
	(11, 'Chani'),
	(12, 'Lady Jessica Atreides'),
	(13, 'Gurney Halleck'),
	(14, 'Captain Marvel'),
	(15, 'Nick Fury'),
	(16, 'Yon-Rogg'),
	(17, 'Phil Coulson'),
	(18, 'Bruce Wayne Batman'),
	(19, 'Harvey Dent Double Face'),
	(20, 'Edward Nygma Homme Mystère'),
	(21, 'Docteur Chase Meridian'),
	(22, 'Peter Parker Spider-Man'),
	(23, 'Mary Jane Watson'),
	(24, 'Harry Osborn le nouveau Bouffon'),
	(25, 'Flint Marko l\'Homme Sable'),
	(26, 'Jean Grey Phoenix'),
	(27, 'Professeur Charles Xavier'),
	(28, 'Erik Lehnsherr Magneto'),
	(29, 'Raven Mystique'),
	(30, 'Aurora Lane'),
	(31, 'Jim Preston'),
	(32, 'Arthur le robot'),
	(33, 'Gus Mancuso'),
	(34, 'Garrick Turell'),
	(35, 'Sarah'),
	(36, 'Kevin'),
	(37, 'Reed'),
	(38, 'Maddie'),
	(39, 'Allison la mère de Percy'),
	(40, 'Sara'),
	(41, 'Percy');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
