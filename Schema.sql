
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opisto`
--
CREATE DATABASE IF NOT EXISTS `opisto` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `opisto`;

-- --------------------------------------------------------

--
-- Rakenne taululle `avoinkurssi`
--

CREATE TABLE IF NOT EXISTS `avoinkurssi` (
  `atunnus` varchar(100) NOT NULL,
  `animi` varchar(100) NOT NULL,
  `aopintopisteet` int(20) NOT NULL,
  `asuoritusaika` varchar(100) NOT NULL,
  `hinta` int(100) NOT NULL,
  PRIMARY KEY (`atunnus`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELAATIOT TAULULLE `avoinkurssi`:
--

--
-- Vedos taulusta `avoinkurssi`
--

INSERT INTO `avoinkurssi` (`atunnus`, `animi`, `aopintopisteet`, `asuoritusaika`, `hinta`) VALUES
('AC246782', 'Koirankoulutusta', 4, '30.7-6.8', 40),
('ACT01922', 'Kissanrapsutusta', 3, '20.6-1.7', 30),
('AK112222', 'Historia 1', 2, '10.6-1.9', 20),
('APK93871', 'Matikka 0202', 5, '6.6-6.8', 50);

-- --------------------------------------------------------

--
-- Rakenne taululle `ilmottautuminen`
--

CREATE TABLE IF NOT EXISTS `ilmottautuminen` (
  `itunnus` int(250) NOT NULL AUTO_INCREMENT,
  `ktunnus` varchar(255) NOT NULL,
  `opiskelijanumero` int(255) NOT NULL,
  `status` int(3) NOT NULL,
  `pvm` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`itunnus`),
  KEY `ktunnus` (`ktunnus`),
  KEY `opiskelijanumero` (`opiskelijanumero`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- RELAATIOT TAULULLE `ilmottautuminen`:
--   `opiskelijanumero`
--       `opiskelija` -> `opiskelijanumero`
--

--
-- Vedos taulusta `ilmottautuminen`
--

INSERT INTO `ilmottautuminen` (`itunnus`, `ktunnus`, `opiskelijanumero`, `status`, `pvm`) VALUES
(1, 'CT60A4002', 45, 2, '2017-05-17 20:00:14.207691'),
(2, 'CT10A0006', 45, 2, '2017-05-17 20:00:27.816085'),
(3, 'CT60A2411', 45, 2, '2017-05-17 21:21:08.291305'),
(4, 'CT10A0300', 45, 1, '2017-05-17 21:22:08.132537'),
(7, 'CT60A0220', 45, 1, '2017-05-17 21:24:30.926264'),
(17, 'ACT01922', 45, 1, '2017-05-17 21:48:24.664429'),
(18, 'CT10A0102', 48, 1, '2017-05-17 22:24:58.726280'),
(19, 'CT60A2411', 48, 1, '2017-05-17 22:25:03.715496'),
(20, 'AK112222', 48, 1, '2017-05-17 22:25:08.330496'),
(21, 'AK112222', 45, 1, '2017-05-18 17:13:15.868052'),
(22, 'CT60A4302', 45, 1, '2017-05-18 17:19:01.643709'),
(23, 'CT60A5150', 45, 1, '2017-05-18 17:19:06.459526'),
(24, 'CT10A0015', 45, 1, '2017-05-18 17:25:01.636354'),
(25, 'AC246782', 45, 1, '2017-05-19 00:56:08.471133'),
(26, 'CT60A2411', 50, 2, '2017-05-19 00:58:57.173477'),
(27, 'AC246782', 50, 1, '2017-05-19 00:59:05.772156'),
(28, 'CT60A5150', 50, 1, '2017-05-19 00:59:07.493500'),
(29, 'CT60A2411', 51, 2, '2017-05-19 18:33:42.236814'),
(30, 'CT10A0300', 51, 1, '2017-05-19 18:33:44.265267'),
(31, 'CT10A0015', 51, 1, '2017-05-19 18:33:46.063687'),
(32, 'CT60A7600', 51, 1, '2017-05-19 18:33:48.576882'),
(33, 'AC246782', 51, 1, '2017-05-19 18:33:51.046802'),
(34, 'CT60A2411', 52, 1, '2017-05-19 18:44:02.591239'),
(35, 'CT60A4002', 52, 2, '2017-05-19 18:44:04.587632'),
(36, 'CT60A4302', 52, 1, '2017-05-19 18:44:06.394707'),
(37, 'ACT01922', 52, 1, '2017-05-19 18:44:09.553330'),
(38, 'CT10A0015', 53, 1, '2017-05-19 19:01:09.064422'),
(39, 'CT10A0300', 53, 1, '2017-05-19 19:01:10.941482'),
(40, 'CT10A0102', 53, 1, '2017-05-19 19:01:12.468976'),
(41, 'CT60A0220', 53, 1, '2017-05-19 19:01:14.139867'),
(42, 'CT60A2411', 53, 2, '2017-05-19 19:01:15.819209');

-- --------------------------------------------------------

--
-- Rakenne taululle `kurssi`
--

CREATE TABLE IF NOT EXISTS `kurssi` (
  `ktunnus` varchar(20) NOT NULL,
  `knimi` varchar(200) NOT NULL,
  `kopintopisteet` int(20) NOT NULL,
  `ksuoritusaika` varchar(100) NOT NULL,
  PRIMARY KEY (`ktunnus`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELAATIOT TAULULLE `kurssi`:
--

--
-- Vedos taulusta `kurssi`
--

INSERT INTO `kurssi` (`ktunnus`, `knimi`, `kopintopisteet`, `ksuoritusaika`) VALUES
('CT10A0006', 'Valittujen Code Camp', 2, '21.4-3.5'),
('CT10A0011', 'Laboratory Work Course in Computer Science', 5, '20.2-1.2'),
('CT10A0015', 'Introduction to M.Sc. Studies in Computer Science', 3, '10.2-10.6'),
('CT10A0102', 'Johdatus tietotekniikan opiskeluun', 5, '5.1-9.3'),
('CT60A0220', 'C-ohjelmoinnin ja testauksen periaatteet', 4, '7.7-16.8'),
('CT60A2411', 'Olio-ohjelmointi', 6, '4.7-8.8'),
('CT60A4002', 'Ohjelmistotuotanto', 1, '11.7-8.10'),
('CT60A4302', 'Tietokannat', 5, '22.7-18.10'),
('CT60A5150', 'Tietojohtamisen teknologiat', 10, '6.6-10.11'),
('CT60A7600', 'Distributed Database Systems', 2, '1.9-8.9');

-- --------------------------------------------------------

--
-- Rakenne taululle `kurssikirja`
--

CREATE TABLE IF NOT EXISTS `kurssikirja` (
  `isbn` varchar(100) NOT NULL,
  `kirjannimi` varchar(200) NOT NULL,
  `ktunnus` varchar(255) DEFAULT NULL,
  `atunnus` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`isbn`),
  KEY `ktunnnus` (`ktunnus`),
  KEY `atunnus` (`atunnus`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELAATIOT TAULULLE `kurssikirja`:
--

--
-- Vedos taulusta `kurssikirja`
--

INSERT INTO `kurssikirja` (`isbn`, `kirjannimi`, `ktunnus`, `atunnus`) VALUES
('111-222-333-566', 'Ohjelmointia', 'CT60A2411', NULL),
('121-242-113-456', 'TietokannatOpus', 'CT60A4302', NULL),
('235-312-123-556', 'Historia 1', NULL, 'AK112222');

-- --------------------------------------------------------

--
-- Rakenne taululle `kurssivastaava`
--

CREATE TABLE IF NOT EXISTS `kurssivastaava` (
  `vastuuid` int(11) NOT NULL AUTO_INCREMENT,
  `ktunnus` varchar(255) NOT NULL,
  `opettajaid` int(255) NOT NULL,
  PRIMARY KEY (`vastuuid`),
  KEY `ktunnus` (`ktunnus`),
  KEY `opettajaid` (`opettajaid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- RELAATIOT TAULULLE `kurssivastaava`:
--   `ktunnus`
--       `kurssi` -> `ktunnus`
--   `opettajaid`
--       `opettaja` -> `opettajaid`
--

--
-- Vedos taulusta `kurssivastaava`
--

INSERT INTO `kurssivastaava` (`vastuuid`, `ktunnus`, `opettajaid`) VALUES
(1, 'CT60A4002', 5),
(2, 'CT10A0006', 5),
(3, 'CT60A2411', 5),
(4, 'CT60A0220', 1),
(5, 'CT60A0220', 4),
(6, 'CT60A2411', 4),
(7, 'CT60A0220', 5);

-- --------------------------------------------------------

--
-- Rakenne taululle `luentosali`
--

CREATE TABLE IF NOT EXISTS `luentosali` (
  `salinnumero` int(255) NOT NULL,
  `istumapaikat` int(255) NOT NULL,
  `ktunnus` varchar(255) DEFAULT NULL,
  `atunnus` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`salinnumero`),
  KEY `ktunnus` (`ktunnus`),
  KEY `atunnus` (`atunnus`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELAATIOT TAULULLE `luentosali`:
--   `ktunnus`
--       `kurssi` -> `ktunnus`
--   `atunnus`
--       `avoinkurssi` -> `atunnus`
--

--
-- Vedos taulusta `luentosali`
--

INSERT INTO `luentosali` (`salinnumero`, `istumapaikat`, `ktunnus`, `atunnus`) VALUES
(112, 246, 'CT10A0102', NULL),
(113, 50, 'CT10A0006', NULL),
(114, 100, NULL, 'AK112222');

-- --------------------------------------------------------

--
-- Rakenne taululle `opettaja`
--

CREATE TABLE IF NOT EXISTS `opettaja` (
  `opettajaid` int(255) NOT NULL AUTO_INCREMENT,
  `nimi` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phash` varchar(80) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `rights` int(2) NOT NULL DEFAULT '2',
  `puh` varchar(15) NOT NULL,
  PRIMARY KEY (`opettajaid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- RELAATIOT TAULULLE `opettaja`:
--

--
-- Vedos taulusta `opettaja`
--

INSERT INTO `opettaja` (`opettajaid`, `nimi`, `email`, `phash`, `salt`, `rights`, `puh`) VALUES
(1, 'Mikki Hiiri', 'mikki@koulu.com', '$2y$10$91e22993cadec45738743umPwGAkXIZW.lz8n5tkvPSa2K0ATmiSe', '8178c1de4682c3a389ce0ede1e03ea3db4b171dc', 2, '04044412567'),
(4, 'kake3', 'kakemies@koulu.com', '$2y$10$46fcc5cda465dd3ef02a0OEaKAbekQjePQ2SAk8upzF6G5bdiijIy', '46fcc5cda465dd3ef02a0bfc77a883fe03153665', 2, '04028958222'),
(5, 'jarkko kimmonen', 'jarkko@koulu.com', '$2y$10$f4a8ab71e84a6e52b6931OwdLPyqzrdFlfWQ1MydxmzZz6wYBWTuS', '00d76a2cc39fe191053ec6425b8e5a8bfd9afb98', 2, '0404912835'),
(6, 'kimmo mies', 'mies@koulu.com', '$2y$10$161821b592e115e872e40uG8zpJzFWmeWCc/ITdvuH/1hxIN13JhC', 'e383452cf713cea59283d8a3f540c13067011e1e', 2, '036756123'),
(7, 'kissa mies', 'koira@koulu.com', '$2y$10$70d38428c890a9d284d18uY53Gm7XnrMOngX5IFVPLcSOPex/9qRO', 'a691ad8d104745e453f14008ea1a084ea0df0523', 2, '02894781'),
(8, 'kissa mies', 'kitten@koulu.com', '$2y$10$70d38428c890a9d284d18uY53Gm7XnrMOngX5IFVPLcSOPex/9qRO', 'a691ad8d104745e453f14008ea1a084ea0df0523', 2, '057827272');

-- --------------------------------------------------------

--
-- Rakenne taululle `opiskelija`
--

CREATE TABLE IF NOT EXISTS `opiskelija` (
  `opiskelijanumero` int(255) NOT NULL AUTO_INCREMENT,
  `nimi` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phash` varchar(80) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `rights` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`opiskelijanumero`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- RELAATIOT TAULULLE `opiskelija`:
--

--
-- Vedos taulusta `opiskelija`
--

INSERT INTO `opiskelija` (`opiskelijanumero`, `nimi`, `email`, `phash`, `salt`, `rights`) VALUES
(44, 'mikko kimmonen', 'kimmo@gmail.com', '$2y$10$e350e7536138cb2eeeae2u6nmWfoqP3aNPWHGXkhL42OhncqkSfNq', 'e350e7536138cb2eeeae25a2bf92fdaa34638cbe', 1),
(45, 'hessu hopo', 'hessu@gmail.com', '$2y$10$91e22993cadec45738743umPwGAkXIZW.lz8n5tkvPSa2K0ATmiSe', '8178c1de4682c3a389ce0ede1e03ea3db4b171dc', 1),
(48, 'make mikkonen', 'make@luukku.com', '$2y$10$c38df0b31e66eff0aaa99uG1pmtghQz12.AnnnttQ0a9r1x.aWp.m', 'c38df0b31e66eff0aaa9977ac1206aa27d738a8a', 1),
(49, 'jarkko kimmonen', 'jarkko@cat.com', '$2y$10$00d76a2cc39fe191053ecuAb4DLOnhEy.TTaG3xf13smFmjWLxkLi', '00d76a2cc39fe191053ec6425b8e5a8bfd9afb98', 1),
(50, 'erno poika', 'erno@gmail.com', '$2y$10$5904e44d3ef4d83c909aaO6V9avckk/Jv.ip2ZROFAlB9DH/I0VZe', '5904e44d3ef4d83c909aad3bbe5b2e07864458e6', 1),
(51, 'kimmo mies', 'mies@gmail.com', '$2y$10$161821b592e115e872e40uG8zpJzFWmeWCc/ITdvuH/1hxIN13JhC', 'e383452cf713cea59283d8a3f540c13067011e1e', 1),
(52, 'kissa mies', 'kissa@koira.com', '$2y$10$70d38428c890a9d284d18uY53Gm7XnrMOngX5IFVPLcSOPex/9qRO', 'a691ad8d104745e453f14008ea1a084ea0df0523', 1),
(53, 'asta laakkonen', 'asta@gmail.com', '$2y$10$b8ea62ece39d274a9bf5cul/EPba/FFU5HktaMdBBSFcK4Kp.ZjSK', '8afe84a953956e5406694954f349b37313b9b390', 1);

-- --------------------------------------------------------

--
-- Rakenne taululle `suoritus`
--

CREATE TABLE IF NOT EXISTS `suoritus` (
  `stunnus` int(250) NOT NULL AUTO_INCREMENT,
  `ktunnus` varchar(255) NOT NULL,
  `opiskelijanumero` int(255) NOT NULL,
  `arvosana` int(2) NOT NULL,
  `pvm` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`stunnus`),
  KEY `ktunnus` (`ktunnus`),
  KEY `opiskelijanumero` (`opiskelijanumero`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- RELAATIOT TAULULLE `suoritus`:
--   `stunnus`
--       `kurssi` -> `ktunnus`
--   `ktunnus`
--       `kurssi` -> `ktunnus`
--   `opiskelijanumero`
--       `opiskelija` -> `opiskelijanumero`
--

--
-- Vedos taulusta `suoritus`
--

INSERT INTO `suoritus` (`stunnus`, `ktunnus`, `opiskelijanumero`, `arvosana`, `pvm`) VALUES
(27, 'CT60A4002', 45, 4, '2017-05-18 16:18:48.868438'),
(28, 'CT10A0006', 45, 3, '2017-05-18 16:19:44.176203'),
(30, 'CT60A2411', 45, 2, '2017-05-18 16:22:14.359645'),
(31, 'CT60A2411', 50, 5, '2017-05-19 01:00:16.254636'),
(32, 'CT60A2411', 51, 4, '2017-05-19 18:35:25.180802'),
(33, 'CT60A4002', 52, 5, '2017-05-19 18:45:57.471248'),
(34, 'CT60A2411', 53, 5, '2017-05-19 19:03:32.885965');

-- --------------------------------------------------------

--
-- Rakenne taululle `yllapito`
--

CREATE TABLE IF NOT EXISTS `yllapito` (
  `yllapitoid` int(255) NOT NULL AUTO_INCREMENT,
  `nimi` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phash` varchar(80) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `rights` int(2) NOT NULL DEFAULT '3',
  PRIMARY KEY (`yllapitoid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- RELAATIOT TAULULLE `yllapito`:
--

--
-- Vedos taulusta `yllapito`
--

INSERT INTO `yllapito` (`yllapitoid`, `nimi`, `email`, `phash`, `salt`, `rights`) VALUES
(1, 'Iines Ankka', 'iinea@admin.com', '$2y$10$e4541f750fa31814e95a5ujUwWACrq.1.LI1myiliwWMTN7Vqbx46', '8178c1de4682c3a389ce0ede1e03ea3db4b171dc', 3);

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `ilmottautuminen`
--
ALTER TABLE `ilmottautuminen`
  ADD CONSTRAINT `ilmottautuminen_ibfk_2` FOREIGN KEY (`opiskelijanumero`) REFERENCES `opiskelija` (`opiskelijanumero`);

--
-- Rajoitteet taululle `kurssivastaava`
--
ALTER TABLE `kurssivastaava`
  ADD CONSTRAINT `kurssivastaava_ibfk_1` FOREIGN KEY (`ktunnus`) REFERENCES `kurssi` (`ktunnus`),
  ADD CONSTRAINT `kurssivastaava_ibfk_2` FOREIGN KEY (`opettajaid`) REFERENCES `opettaja` (`opettajaid`);

--
-- Rajoitteet taululle `luentosali`
--
ALTER TABLE `luentosali`
  ADD CONSTRAINT `luentosali_ibfk_1` FOREIGN KEY (`ktunnus`) REFERENCES `kurssi` (`ktunnus`),
  ADD CONSTRAINT `luentosali_ibfk_2` FOREIGN KEY (`atunnus`) REFERENCES `avoinkurssi` (`atunnus`);

--
-- Rajoitteet taululle `suoritus`
--
ALTER TABLE `suoritus`
  ADD CONSTRAINT `ktunnus` FOREIGN KEY (`ktunnus`) REFERENCES `kurssi` (`ktunnus`),
  ADD CONSTRAINT `opiskelijanumero` FOREIGN KEY (`opiskelijanumero`) REFERENCES `opiskelija` (`opiskelijanumero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
