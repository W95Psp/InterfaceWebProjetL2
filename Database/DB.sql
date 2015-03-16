-- phpMyAdmin SQL Dump
-- version 3.4.3.1
-- http://www.phpmyadmin.net
--
-- Client: pdb9.awardspace.net
-- Généré le : Lun 16 Mars 2015 à 07:10
-- Version du serveur: 5.5.38
-- Version de PHP: 5.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `1058348_projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `Candidature`
--

CREATE TABLE IF NOT EXISTS `Candidature` (
  `idC` int(11) NOT NULL AUTO_INCREMENT,
  `dateC` date DEFAULT NULL,
  `idProj_C` int(11) DEFAULT NULL,
  `idGr_C` int(11) DEFAULT NULL,
  `valide` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idC`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=655 ;

--
-- Contenu de la table `Candidature`
--

INSERT INTO `Candidature` (`idC`, `dateC`, `idProj_C`, `idGr_C`, `valide`) VALUES
(123, '2015-02-09', 2, 2, 0),
(127, '2015-02-17', 2, 2, 0),
(129, '2015-02-21', 2, 2, 0),
(650, '2015-02-19', 1, 1, 0),
(651, '2015-02-11', 1, 1, 0),
(654, '2015-02-04', 1, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Candidature_valide`
--

CREATE TABLE IF NOT EXISTS `Candidature_valide` (
  `idCV` int(11) NOT NULL AUTO_INCREMENT,
  `idC_CV` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCV`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Critére`
--

CREATE TABLE IF NOT EXISTS `Critére` (
  `idCr` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idCr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `Critére`
--

INSERT INTO `Critére` (`idCr`, `description`) VALUES
(1, 'Contenu'),
(2, 'Maitrise'),
(4, 'Autonomie'),
(7, 'Contenu'),
(9, 'rapport');

-- --------------------------------------------------------

--
-- Structure de la table `Enseignent`
--

CREATE TABLE IF NOT EXISTS `Enseignent` (
  `idEns` int(11) NOT NULL AUTO_INCREMENT,
  `nomEns` varchar(45) DEFAULT NULL,
  `prenomEns` varchar(45) DEFAULT NULL,
  `emailEns` varchar(45) DEFAULT NULL,
  `telEns` varchar(12) DEFAULT NULL,
  `webEns` varchar(400) DEFAULT NULL,
  `mdpEns` varchar(8) DEFAULT NULL,
  `droitEns` varchar(20) DEFAULT 'ens',
  `idJ_E` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEns`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1016 ;

--
-- Contenu de la table `Enseignent`
--

INSERT INTO `Enseignent` (`idEns`, `nomEns`, `prenomEns`, `emailEns`, `telEns`, `webEns`, `mdpEns`, `droitEns`, `idJ_E`) VALUES
(1001, 'Herve', 'Dicky', 'herve.dicky@lirmm.fr', '6605684213', 'www.lirmm.fr/~Dicky', 'passens1', 'ens', 1),
(1002, 'Mickael', 'Montassier', 'mickael.montassier@lirmm.fr', '6605684213', 'www.lirmm.fr/~Mickael', 'passens1', 'ens', 1),
(1003, 'Michel', 'Leclere', 'michel.leclere@lirmm.fr', '6605684213', 'www.lirmm.fr/~Leclere', 'passens1', 'ens', 1),
(1004, 'Stephane', 'Bessy', 'stephane.bessy@lirmm.fr', '6605684213', 'www.lirmm.fr/~Bessy', 'passens1', 'ens', 0),
(1005, 'Nicolas', 'Briot', 'briot@lirmm.fr', '6605684213', 'www.lirmm.fr/~Briot', 'passens1', 'ens', 2),
(1006, 'Isabelle', 'Mougenot', 'Isabelle.Mougenot@lirmm.fr', '6605684213', 'www.lirmm.fr/~Mougenot', 'passens1', 'ens', 2),
(1007, 'Vincent', 'Boudet', 'boudet@lirmm.fr', '6605684213', 'www.lirmm.fr/~Boudet', 'passens1', 'ens', 0),
(1008, 'Lionel', 'Ramadier', 'Lionel.Ramadier@lirmm.fr', '6605684213', 'www.lirmm.fr/~ramadier', 'passens1', 'ens', 1),
(1009, 'Philippe', 'Janssen', 'Philippe.Janssen@lirmm.fr', '6605684213', 'www.lirmm.fr/~pja', 'passens1', 'ens', 1),
(1010, 'Abdelhak-Djamel', 'Seriai', 'seriai@lirmm.fr', '6605684213', 'http://www2.lirmm.fr/~seriai/', 'passens1', 'ens', 0),
(1011, 'Pierre', 'Pompidor', 'pompidor@lirmm.fr', '6605684213', 'http://www.lirmm.fr/~pompidor/', 'passens1', 'ens', 0),
(1012, 'Christian', 'Retore', 'Christian.Retore@lirmm.fr', '6605684213', 'http://www.lirmm.fr/~retore/index.html', 'passens1', 'ens', 0),
(1013, 'Federico', 'Ulliana', 'federico.ulliana@univ-montp2.fr', '6605684213', 'http://www.lirmm.fr/~ulliana/', 'passens1', 'ens', 0),
(1014, 'Eric', 'Bourreau', 'Eric.Bourreau@lirmm.fr', '6605684213', 'http://www.lirmm.fr/~bourreau/', 'passens1', 'ens', 0),
(1015, 'Mathieu', 'Lafourcade', 'lafourcade@lirmm.fr', '6605684213', 'http://www.lirmm.fr/~Lafourcade', 'passens1', 'ens', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Etudiant`
--

CREATE TABLE IF NOT EXISTS `Etudiant` (
  `idEtu` int(11) NOT NULL AUTO_INCREMENT,
  `nomEtu` varchar(45) DEFAULT NULL,
  `prenomEtu` varchar(45) DEFAULT NULL,
  `emailEtu` varchar(80) DEFAULT NULL,
  `telEtu` varchar(12) DEFAULT NULL,
  `mdpEtu` varchar(18) DEFAULT NULL,
  `droitEtu` varchar(20) DEFAULT 'etudiant',
  `idG_E` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEtu`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2090 ;

--
-- Contenu de la table `Etudiant`
--

INSERT INTO `Etudiant` (`idEtu`, `nomEtu`, `prenomEtu`, `emailEtu`, `telEtu`, `mdpEtu`, `droitEtu`, `idG_E`) VALUES
(2000, 'Iaroslav', 'AMPLEEV', 'Iaroslav.AMPLEEV@etud.univ-montp2.fr', '20145684213', 'passetud1', 'etudiant', 1),
(2001, 'Antoine', 'LAURENT', 'Antoine.LAURENT@etud.univ-montp2.fr', '20135684213', 'passetud1', 'etudiant', 1),
(2002, 'Nicolas', 'POMPIDOR', 'Nicolas.POMPIDOR@etud.univ-montp2.fr', '20125684213', 'passetud1', 'etudiant', 1),
(2003, 'Sacha', 'WEILL', 'Sacha.WEILL@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 1),
(2004, 'Amadou-Bailo', 'BARRY', 'ABailo.BARRY@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 2),
(2005, 'Jeremy', 'BRESSAND', 'Jeremy.BRESSAND@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 2),
(2006, 'Marin', 'JULIEN', 'Marin.JULIEN@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 2),
(2007, 'Mathieu', 'MASSAVIO', 'Mathieu.MASSAVIO@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 2),
(2008, 'Florian', 'VUILLEMOT', 'Florian.VUILLEMOT@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 3),
(2009, 'Anthony', 'BRUNEL', 'Anthony.BRUNEL@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 4),
(2010, 'Morgan', 'FOUQUE', 'Morgan.FOUQUE@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 4),
(2011, 'Manon', 'GUILLOT', 'Manon.GUILLOT@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 4),
(2012, 'Colin', 'SENEQUE', 'Colin.SENEQUE@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 4),
(2013, 'Jules', 'COULON', 'Jules.COULON@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 5),
(2014, 'Matthieu', 'KOWALCZYK', 'Matthieu.KOWALCZYK@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 5),
(2015, 'Elodie', 'SAVAJOLS', 'Elodie.SAVAJOLS@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 5),
(2016, 'Dorine', 'TABARY', 'Dorine.TABARY@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 5),
(2017, 'Tristan', 'COSSIN', 'Tristan.COSSIN@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 7),
(2018, 'Loïs', 'FAIDHERBE', 'Loïs.FAIDHERBE@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 7),
(2019, 'Florian', 'GAUNE', 'Florian.GAUNE@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 7),
(2020, 'Jordan', 'GUILLONEAU', 'Jordan.GUILLONEAU@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 7),
(2021, 'Edouard', 'BREUILLE', 'Edouard.BREUILLE@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 8),
(2022, 'Celia', 'ROUQUAIROL', 'Celia.ROUQUAIROL@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 8),
(2023, 'Thibaut', 'RUIZ', 'Thibaut.RUIZ@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 8),
(2024, 'Jeremy', 'ZAMIA', 'Jeremy.ZAMIA@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 8),
(2025, 'Kevin', 'BOUZAN', 'Kevin.BOUZAN@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 9),
(2026, 'Christopher', 'DEBOISVILLIERS', 'Christopher.DEBOISVILLIERS@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 9),
(2027, 'Alban', 'SALINAS', 'Alban.SALINAS@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 9),
(2028, 'Martin', 'ABADIE', 'Martin.ABADIE@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 10),
(2029, 'Yasmine', 'BENMOUFFOK', 'Yasmine.BENMOUFFOK@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 10),
(2030, 'Paul', 'HEIDMANN', 'Paul.HEIDMANN@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 10),
(2031, 'Sylvain', 'UTZEL', 'Sylvain.UTZEL@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 10),
(2032, 'Anastasia', 'PRYSIAZHNIUK', 'Anastasia.PRYSIAZHNIUK@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 11),
(2033, 'Charles', 'BENAIS-HUGO', 'Charles.BENAIS-HUGO@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 11),
(2034, 'Victor', 'CONNES', 'Victor.CONNES@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 11),
(2035, 'Cecilie', 'RIVIERE', 'Cecilie.RIVIERE@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 11),
(2036, 'Nicolas', 'HLAD', 'Nicolas.HLAD@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 12),
(2037, 'Guilhem', 'MARION', 'Guilhem.MARION@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 12),
(2038, 'Guilhem', 'TRAUCHESSEC', 'Guilhem.TRAUCHESSEC@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 12),
(2039, 'Pascal', 'ZARAGOZA', 'Pascal.ZARAGOZA@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 12),
(2040, 'Ivan', 'BRUNET-MANQUAT', 'Ivan.BRUNET-MANQUAT@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 13),
(2041, 'Matteo', 'COQUILHAT', 'Matteo.COQUILHAT@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 13),
(2042, 'Faustine', 'DURAND', 'Faustine.DURAND@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 13),
(2043, 'Mickael', 'HAMOUMA', 'Mickael.HAMOUMA@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 13),
(2044, 'Allaham', 'ABDULHADI', 'Allaham.ABDULHADI@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 14),
(2045, 'Dhivya', 'MOORTHY', 'Dhivya.MOORTHY@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 14),
(2046, 'Gualtiero', 'LUGATO', 'Gualtiero.LUGATO@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 14),
(2047, 'Jean-Philippe', 'VERT', 'Jean-Philippe.VERT@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 14),
(2048, 'Guenael', 'ANSELME', 'Guenael.ANSELME@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 15),
(2049, 'Alain', 'ALIGNAN', 'Alain.ALIGNAN@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 15),
(2050, 'Shyaka', 'LANIESSE', 'Shyaka.LANIESSE@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 15),
(2051, 'Celeste', 'BONKEKE', 'Celeste.BONKEKE@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 16),
(2052, 'Meryll', 'ESSIG', 'Meryll.ESSIG@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 16),
(2053, 'Ludovic', 'FANUS', 'Ludovic.FANUS@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 16),
(2054, 'Tamara', 'ROCACHER', 'Tamara.ROCACHER@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 16),
(2055, 'Jordan', 'FERRAD', 'Jordan.FERRAD@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 17),
(2056, 'Fabien', 'OCCHUZI', 'Fabien.OCCHUZI@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 17),
(2057, 'Remi', 'DE BUYER', 'Remi.DEBUYER@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 17),
(2058, 'Clement', 'DAUMET', 'Clement.DAUMET@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 18),
(2059, 'Priscilla', 'KEIP', 'Priscilla.KEIP@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 18),
(2060, 'Andrea', 'VULETIC', 'Andrea.VULETIC@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 18),
(2061, 'Nicolas', 'THERON', 'Nicolas.THERON@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 18),
(2062, 'Cvete', 'MACESKI', 'Cvete.MACESKI@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 19),
(2063, 'Achraf', 'TAJANI', 'Achraf.TAJAN@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 19),
(2064, 'Fabien', 'ZAPLANA', 'Fabien.ZAPLANA@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 19),
(2065, 'Lucas', 'FRANCESCHINO', 'Lucas.FRANCESCHINO@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 20),
(2066, 'Aurelien', 'GAUTHIER', 'Aurelien.GAUTHIER@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 20),
(2067, 'Marie', 'PALMIER', 'Marie.PALMIER@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 20),
(2068, 'Guillaume', 'SERAGLINI', 'Guillaume.SERAGLINI@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 20),
(2069, 'Julien', 'BURTE', 'Julien.BURTE@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 21),
(2070, 'Olivier', 'MONTES', 'Olivier.MONTES@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 21),
(2071, 'Theo', 'ROGLIANO', 'Theo.ROGLIANO@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 21),
(2088, 'Florian', 'PORTIER', 'Florian.PORTIER@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 7),
(2089, 'Mohamed', 'BARECHE', 'Mohamed.BARECHE@etud.univ-montp2.fr', '20115684213', 'passetud1', 'etudiant', 19);

-- --------------------------------------------------------

--
-- Structure de la table `Groupe`
--

CREATE TABLE IF NOT EXISTS `Groupe` (
  `idG` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idG`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `Groupe`
--

INSERT INTO `Groupe` (`idG`, `alias`) VALUES
(1, 'GR1'),
(2, 'GR2'),
(3, 'GR3'),
(4, 'GR4'),
(5, 'GR5'),
(6, 'GR6'),
(7, 'GR7'),
(8, 'GR8'),
(9, 'GR9'),
(10, 'GR10'),
(11, 'GR11'),
(12, 'GR12'),
(13, 'GR13'),
(14, 'GR14'),
(15, 'GR15'),
(16, 'GR16'),
(17, 'GR17'),
(18, 'GR18'),
(19, 'GR19'),
(20, 'GR20'),
(21, 'GR21');

-- --------------------------------------------------------

--
-- Structure de la table `Jury`
--

CREATE TABLE IF NOT EXISTS `Jury` (
  `id_j` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(44) DEFAULT NULL,
  PRIMARY KEY (`id_j`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `Jury`
--

INSERT INTO `Jury` (`id_j`, `type`) VALUES
(1, 'Jury'),
(2, 'Relecteur');

-- --------------------------------------------------------

--
-- Structure de la table `Note`
--

CREATE TABLE IF NOT EXISTS `Note` (
  `idn` int(11) NOT NULL AUTO_INCREMENT,
  `idEtud_N` int(11) DEFAULT NULL,
  `idE_N` int(11) DEFAULT NULL,
  `idC_N` int(11) DEFAULT NULL,
  `note` float DEFAULT NULL,
  PRIMARY KEY (`idn`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Contenu de la table `Note`
--

INSERT INTO `Note` (`idn`, `idEtud_N`, `idE_N`, `idC_N`, `note`) VALUES
(1, 1000, 2000, 1, 12.4),
(2, 1000, 2000, 2, 11.4),
(4, 1000, 2000, 4, 17.4),
(8, 1000, 2000, 7, 10.4),
(9, 1000, 2000, 9, 12.4),
(22, 1000, 3000, 2, 13.4),
(44, 1000, 3000, 4, 15.4),
(88, 1000, 3000, 7, 9);

-- --------------------------------------------------------

--
-- Structure de la table `Projet`
--

CREATE TABLE IF NOT EXISTS `Projet` (
  `idProj` int(11) NOT NULL AUTO_INCREMENT,
  `nomProj` varchar(450) DEFAULT NULL,
  `descProj` varchar(450) DEFAULT NULL,
  `preProj` varchar(450) DEFAULT NULL,
  `lien` varchar(450) DEFAULT NULL,
  `nbMini` int(11) DEFAULT NULL,
  `nbMax` int(11) DEFAULT NULL,
  `nbInscri` int(11) DEFAULT NULL,
  PRIMARY KEY (`idProj`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `Projet`
--

INSERT INTO `Projet` (`idProj`, `nomProj`, `descProj`, `preProj`, `lien`, `nbMini`, `nbMax`, `nbInscri`) VALUES
(1, 'Le carre empoisonne de la tablette de chocolat', 'Cest un jeu dans une forme d une tablette de chocolat predecoupe en carre et dont un carre situe dans un coin est empoisonne', 'pre1', 'http://www.lirmm.fr/~retore/projetsL2/TabletteChocolat.pdf', 2, 4, 0),
(2, 'Retrogaming: Arkanoid', 'Un jeu de type ball breaker a l image du celebre Arkanoid', 'pre2', 'http://www.lirmm.fr/~retore/projetsL2/MickaelMontassier-Arkanoid.pdf', 2, 4, 0),
(3, 'Implementation et evaluation d’un prouveur pour la logique des propositions', 'L’objectif de ce TER est de mettre en œuvre et d’optimiser l’algorithme de Davis-Putnam qui permet de resoudre ce probleme de satisfiabilite pour des propositions sous forme conjonctive', 'pre3', 'http://www.lirmm.fr/~retore/projetsL2/propositions.pdf', 2, 4, 0),
(4, 'Bubble Shooter', 'Implementation un jeu de Bubble shooter (possiblement en C++) a l aide d une bibliotheque graphique typiquement SDL', 'pre4', 'http://www.lirmm.fr/~retore/projetsL2/BubbleShooter.pdf', 2, 4, 0),
(5, 'Le Takuzu', 'Le takuzu est un jeu de reflexion inspire du sudoku où un grille partiellement remplie de 0 et de 1', 'pre5', 'http://www.lirmm.fr/~retore/projetsL2/projetTakuzu.pdf', 2, 4, 0),
(6, 'Editeur SKOS et application aux paysages urbains', 'Le projet s’inscrit dans la mouvance actuelle de developpements applicatifs autour du web de donnees', 'pre6', 'http://www.lirmm.fr/~retore/projetsL2/skos.pdf', 2, 4, 0),
(7, 'Representation d’un labyrinthe', 'Le but du projet est de repr´esenter une vue subjective des couloirs composants un labyrinthe', 'pre7', 'http://www.lirmm.fr/~retore/projetsL2/labyrinthe.pdf', 2, 4, 0),
(8, 'Le jeu Isola', 'Description du jeu dans le lien', 'pre8', 'http://www.lirmm.fr/~retore/projetsL2/isola.pdf', 2, 4, 0),
(9, 'Programmation de jeux 2D : un morpion en SDL', 'Le morpion est un jeu de reflexion se pratiquant a deux joueurs au tour par tour et dont le but est de creer le premier un alignement sur une grille. ', 'pre9', 'http://www.lirmm.fr/~retore/projetsL2/morpion.pdf', 2, 4, 0),
(10, 'Resolution d’un casse-tete Slither Link', 'Ce casse-tete consiste a trouver un chemin dans une grille', 'pre10', 'http://www.lirmm.fr/~retore/projetsL2/slitherLink.pdf', 2, 4, 0),
(11, 'Resolution de Picross', 'Le Picross ou Hanjie est un casse-tete qui consiste a retrouver une figure a partir d’indices', 'pre11', 'http://www.lirmm.fr/~retore/projetsL2/projetPicross.pdf', 2, 4, 0),
(12, 'Resolution de Puzzle-Image Link-a-Pix', 'Il s’agit de reconstruire une image (grille dont les cases sont noires ou blanches) a partir d’indices.', 'pre12', 'http://www.lirmm.fr/~retore/projetsL2/projetLinPix.pdf', 2, 4, 0),
(13, 'Jeu de dames en Java', 'L’objectif de ce projet est de developper une application Java de jeu de dames.', 'pre13', 'http://www.lirmm.fr/~retore/projetsL2/TER1_JeuDames.pdf', 2, 4, 0),
(14, 'Application en java pour la prise de notes', 'L’objectif de ce projet est de developper une application en java pour la prise de notes. ', 'pre14', 'http://www.lirmm.fr/~retore/projetsL2/TER2_PriseNotes.pdf', 2, 4, 0),
(15, 'Application en java pour l’organisation/gestion en local des connaissances liees a un sujet (banque de connaissances).', 'L’objectif de ce projet est le developpement d’une application en java pour la gestion des connaissances liees a un sujet (banque de connaissances).', 'pre15', 'http://www.lirmm.fr/~retore/projetsL2/TER3_Connaissances.pdf', 2, 4, 0),
(16, 'Developpement d’une application en C++ pour l’aide a l’organisation de taches', 'L’objectif de ce projet est de developper une application permettant a un utilisateur de gerer ses taches', 'pre16', 'http://www.lirmm.fr/~retore/projetsL2/TER4_OrgTacheCplusPlus.pdf', 2, 4, 0),
(17, 'Assistant de memorisation d’ouvertures au jeu de Go', 'Le jeu de Go est le seul jeu (classique) a information complete où les meilleurs joueurs battent les ordinateurs (meme les tres tres gros). ', 'pre17', 'http://www.lirmm.fr/~retore/projetsL2/memoGo.pdf', 2, 4, 0),
(18, 'Assistant de resolution de problèmes de vie et de mort au jeu de Go', 'Le jeu de Go est le seul jeu (classique) a information complete ou les meilleurs joueurs battent les ordinateurs (meme les tres gros ).', 'pre18', 'http://www.lirmm.fr/~retore/projetsL2/resoluGo.pdf', 2, 4, 0),
(19, 'Conception    de    la    base de    donnees    des    projets    de    licence    deuxieme annee', 'L’objectif    de    ce    stage  est de concevoir    une    base de    donnees    Oracle    pour les projets de    L2.', 'pre19', 'http://www.lirmm.fr/~retore/projetsL2/BDprojetsL2.pdf', 2, 4, 0),
(20, 'Interface Internet pour la    base de    donnees    des    projets    de licence deuxieme    annee', 'L’objectif de ce stage est de realiser    une    interface Web pour gerer la    base de    donnees des    projets    de L2.', 'pre20', 'http://www.lirmm.fr/~retore/projetsL2/WEBprojetsL2.pdf', 2, 4, 0),
(21, 'Ouvertures    et    Finales    d’Eternity II', 'Eternity 2    est    un    jeu    combinatoire, equivalent a un puzzle 2D    où    il    faut assembler un ensemble de pièces afin de construire     un     carre    complet de    16x16.', 'pre20', 'http://www.lirmm.fr/~retore/projetsL2/eternity.pdf', 2, 4, 0),
(22, 'Extraction    de    relations en art culinaire', 'Un    reseau lexical est    une    collection    de termes relies entre    eux    par    des    arc    orientees,    typees    (et    eventuellement    ponderees).', 'pre20', 'http://www.lirmm.fr/~retore/projetsL2/culinaire.pdf', 2, 4, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
