-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2022 at 10:26 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prodajavozil`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `ePosta` varchar(255) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `uporabnisko_ime` varchar(50) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `geslo` varchar(255) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `ePosta`, `uporabnisko_ime`, `geslo`, `created_at`) VALUES
(7, 'ADMIN1@gmail.com', 'ADMIN1', '$2y$10$qA4PeFL9aP8AvrQu3RDEMePXCImD8Qtb6zkTFWivf3u99oeYfxK3m', '2022-03-09 14:19:09'),
(10, 'ADMIN3@gmail.com', 'admin3', '$2y$10$idx/tqNOCiy0EEqrrc31TeMhHQcDidasBeIdtShYT4BwG6pZ3jl0W', '2022-04-08 16:51:17'),
(11, 'ADMIN4@gmail.com', 'nekaj123', '$2y$10$Jc7sRHy94WehUihMevcohus.t5N3nf7alWcYHUn2HDDZ0EY6ISUMG', '2022-04-08 17:04:03');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `komentarID` int(11) NOT NULL,
  `opis` text COLLATE utf8mb4_slovenian_ci NOT NULL,
  `uporabnikID` int(11) NOT NULL,
  `temaID` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`komentarID`, `opis`, `uporabnikID`, `temaID`, `created_at`) VALUES
(1, 'Jarooooo', 3, 5, '2022-02-01 22:43:02'),
(3, 'BMW je najači brooo.', 3, 10, '2022-02-01 23:02:18'),
(4, 'Jst, bi rajš kupu Hyundai, ker je cenejš auto.', 3, 10, '2022-02-01 23:02:35'),
(6, 'Men se zdi da najbulš izbira je VW GOLF 8.', 18, 5, '2022-02-02 12:59:16'),
(8, 'This is first comment.', 18, 5, '2022-02-06 11:20:05'),
(9, 'This is second comment.', 12, 5, '2022-02-06 11:20:05'),
(19, 'nekineki', 3, 5, '2022-02-21 15:13:47'),
(27, 'Dejstvo je, da kupovanje avtomobilov v letu 2022 se popolnoma ne splača. Sej vidte da se bencin draži. Skor bo 2 eura. Brezveze.', 20, 5, '2022-06-16 11:42:11'),
(29, 'Neki.', 20, 5, '2022-06-17 12:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `imeModela` varchar(100) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `znamka` varchar(100) COLLATE utf8mb4_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`imeModela`, `znamka`) VALUES
('159', 'Alfa Romeo'),
('giulia', 'Alfa Romeo'),
('giulietta', 'Alfa Romeo'),
('stelvio', 'Alfa Romeo'),
('A3', 'Audi'),
('A4', 'Audi'),
('A5', 'Audi'),
('M2', 'BMW'),
('M3', 'BMW'),
('serija 1', 'BMW'),
('serija 2', 'BMW'),
('serija 3', 'BMW'),
('serija 4', 'BMW'),
('serija 5', 'BMW'),
('serija 6', 'BMW'),
('serija 7', 'BMW'),
('i10', 'Hyundai'),
('i20', 'Hyundai'),
('i30', 'Hyundai'),
('ioniq 5', 'Hyundai'),
('CT', 'Lexus'),
('ES', 'Lexus'),
('GS', 'Lexus'),
('GX', 'Lexus'),
('LS', 'Lexus'),
('Celica', 'Toyota'),
('Corolla', 'Toyota'),
('RAV4', 'Toyota'),
('Supra', 'Toyota'),
('Yaris', 'Toyota'),
('Arteon', 'Volkswagen'),
('Golf', 'Volkswagen'),
('Passat', 'Volkswagen'),
('C30', 'Volvo'),
('C40', 'Volvo'),
('V60', 'Volvo'),
('V70', 'Volvo'),
('V90', 'Volvo'),
('XC40', 'Volvo'),
('XC60', 'Volvo');

-- --------------------------------------------------------

--
-- Table structure for table `odgovor`
--

CREATE TABLE `odgovor` (
  `odgovorID` int(11) NOT NULL,
  `opis` text COLLATE utf8mb4_slovenian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nested_level` tinyint(4) NOT NULL DEFAULT 1,
  `komentarID` int(11) NOT NULL,
  `uporabnikID` int(11) NOT NULL,
  `odgovorjenID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `odgovor`
--

INSERT INTO `odgovor` (`odgovorID`, `opis`, `created_at`, `nested_level`, `komentarID`, `uporabnikID`, `odgovorjenID`) VALUES
(11, 'This is first reply to first comment', '2022-02-06 11:23:01', 1, 8, 10, NULL),
(12, 'This is a second reply to first comment', '2022-02-06 11:29:44', 1, 8, 15, NULL),
(13, 'This is a third reply to first comment', '2022-02-06 11:29:44', 1, 8, 2, NULL),
(14, 'This is a first reply to first reply of a first comment', '2022-02-06 11:29:44', 2, 8, 11, 11),
(15, 'This is a second reply to first reply of a first comment', '2022-02-06 11:30:21', 2, 8, 11, 11),
(16, 'This is a first reply of a first reply of a first reply of a first comment', '2022-02-06 11:32:06', 3, 8, 15, 14),
(17, 'This is first reply to a second comment', '2022-02-06 19:10:45', 1, 9, 18, NULL),
(18, 'this is a third reply to a first reply of a first comment.', '2022-02-07 17:50:26', 2, 8, 14, 11),
(19, 'This is a second reply to a second comment', '2022-02-07 20:55:03', 1, 9, 18, NULL),
(20, 'This is a first reply to a second reply of a second comment', '2022-02-07 21:01:08', 2, 9, 17, 19),
(21, 'This is a second reply of a second reply of a second comment', '2022-02-09 21:41:39', 2, 9, 13, 19),
(22, 'This is a first reply to a third reply of a first reply of a first comment.', '2022-02-09 21:25:18', 2, 8, 14, 18),
(23, 'This is a first reply to a second reply of a  second reply of a second comment', '2022-02-09 21:43:25', 3, 9, 17, 21),
(24, 'This is a second reply to a second reply of a second reply of a second comment.', '2022-02-19 15:49:25', 3, 9, 10, 21),
(33, 'jaroo2', '2022-02-22 09:22:19', 1, 1, 3, NULL),
(34, 'Men se zdi pa Audi A3 jači.', '2022-02-22 09:32:47', 1, 6, 3, NULL),
(48, 'jarooo3', '2022-02-22 13:54:55', 2, 1, 18, 33),
(49, 'Jarooo4', '2022-02-22 13:58:45', 2, 1, 18, 33),
(50, 'Men je BMW jači.', '2022-02-22 14:02:02', 2, 6, 18, 34),
(51, 'men se zdi lexus buls.', '2022-02-22 14:02:53', 2, 6, 3, 34),
(52, 'Men se zdi da najbulš izbira je VW GOLF9', '2022-02-22 14:03:30', 1, 6, 3, NULL),
(53, 'BMW serija 5 je najača, se strinjam Blocan.', '2022-02-22 14:05:48', 3, 6, 3, 50),
(54, 'Men se zdi merčo bolš.', '2022-02-22 14:34:07', 2, 6, 3, 34),
(56, 'VW 10', '2022-02-22 14:36:52', 2, 6, 3, 52),
(57, 'CIGOOOO.', '2022-02-22 14:37:18', 3, 6, 3, 56),
(58, 'this is the fourth reply.', '2022-02-22 16:51:18', 1, 9, 3, NULL),
(59, 'jarooo3', '2022-02-22 16:53:42', 2, 1, 3, 33),
(60, 'Men je BMW SERIJA 8 najači bro.', '2022-02-22 17:57:33', 3, 6, 3, 50),
(61, 'Nah bro.', '2022-02-22 19:09:51', 1, 3, 18, NULL),
(62, 'This is a reply to Jožek božek.', '2022-02-23 11:18:03', 3, 9, 3, 20),
(63, 'To je reply.', '2022-02-25 17:58:01', 2, 6, 3, 52),
(64, 'Jst sm cigooooo.', '2022-02-27 21:26:49', 2, 8, 3, 12),
(65, 'Men je Lexus EX najbolsi.', '2022-03-06 11:25:18', 3, 6, 3, 51),
(66, 'Nah bro, pickA SI.', '2022-03-07 20:44:00', 4, 6, 18, 65),
(67, 'Men pa BMW ni jačui.', '2022-03-09 10:06:01', 3, 6, 3, 50),
(69, 'BMW SERIJA 5', '2022-03-11 09:04:36', 4, 6, 3, 53),
(70, 'jarooo4', '2022-03-11 12:07:53', 3, 1, 19, 59),
(71, 'Men se zdi ni.', '2022-03-11 12:10:59', 2, 6, 3, 34),
(72, 'Nah, to je krneki model', '2022-04-08 16:39:06', 3, 6, 3, 50),
(73, 'This is a reply of a reply Jožek Božek.', '2022-06-16 11:15:06', 4, 9, 3, 62),
(74, 'Al je brezveze no, škoda dnarja za drage aute.', '2022-06-16 11:42:53', 2, 8, 20, 13),
(75, 'Ma sezmer se splaca. Preprosto, ce zivis v kakem oddaljenem kraju kot je npr. Loska dolina, pol je avto nujno potrebno vozilo. To je dejstvo Jaka.', '2022-06-16 11:47:31', 1, 27, 3, NULL),
(76, 'Mah to je res sam jst zivim v Ljubljani, tko da se bolj splača nakup električnega skiroja.', '2022-06-16 11:48:19', 2, 27, 20, 75),
(77, 'To se pa popolnoma strinjam.', '2022-06-16 11:48:39', 3, 27, 3, 76),
(78, 'Zapomn se, tu je dejstvu.', '2022-06-16 15:01:28', 2, 27, 3, 75),
(79, 'Jaoooo.', '2022-06-16 16:25:45', 2, 27, 20, 75),
(80, 'Joj.', '2022-06-17 12:06:23', 1, 27, 20, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oglas`
--

CREATE TABLE `oglas` (
  `oglasID` int(11) NOT NULL,
  `opis` mediumtext COLLATE utf8mb4_slovenian_ci DEFAULT NULL,
  `cena` int(11) NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_slovenian_ci NOT NULL DEFAULT 'neprodano',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `voziloID` int(11) NOT NULL,
  `model` varchar(100) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `znamka` varchar(100) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `uporabnikID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `oglas`
--

INSERT INTO `oglas` (`oglasID`, `opis`, `cena`, `status`, `created_at`, `updated_at`, `voziloID`, `model`, `znamka`, `uporabnikID`) VALUES
(22, 'Dobro ohranjeno vozilo. Lp', 18000, 'prodano', '2022-01-28 21:48:35', '2022-06-16 15:24:42', 31, 'A3', 'Audi', 3),
(23, 'Slabo ohranjeno vozilo. Potrebna obnova motorja.', 7000, 'prodano', '2022-01-28 21:53:08', '2022-03-08 23:00:00', 32, 'Corolla', 'Toyota', 3),
(24, 'Majhen avtek, za malo denarja.', 3000, 'prodano', '2022-01-28 22:32:49', '2022-04-13 19:14:05', 33, 'i10', 'Hyundai', 3),
(25, 'Skratka k nov. Dobra mašinca res.', 35000, 'Neprodano', '2022-01-28 22:45:27', '2022-03-08 23:00:00', 34, 'A3', 'Audi', 3),
(26, 'Malo popraskan odzadi. Moznost dokupa dodatnih gum.', 24000, 'neprodano', '2022-03-07 20:41:55', '2022-03-08 23:00:00', 35, 'Arteon', 'Volkswagen', 3),
(27, 'Malce opraskan na zunaj. Potrebno je kemično čiščenje. Lahko tudi menjamo za novejši model. Glede cene se da še nekaj dogovoriti.', 5500, 'Neprodano', '2022-02-02 13:08:08', '2022-03-08 23:00:00', 36, 'serija 3', 'Volkswagen', 18),
(28, 'Kar vredu ohranjeno. Potrebno je zunanje čiščenje.', 35000, 'prodano', '2022-02-01 19:52:25', '2022-03-08 23:00:00', 37, 'A4', 'Audi', 3),
(30, 'Dober avto', 15000, 'neprodano', '2022-02-02 13:37:27', '2022-03-08 23:00:00', 39, 'Golf', 'Volkswagen', 18),
(34, 'Kar ok ohranjenu. Za ceno se da še dogovorit.. Drgač bom pa spustu ceno.', 23500, 'neprodano', '2022-06-16 11:13:29', '2022-03-08 23:00:00', 43, 'A4', 'Audi', 3),
(35, 'Odličen, prebarvan na rdečo.', 35000, 'neprodano', '2022-04-13 18:50:28', '2022-03-08 23:00:00', 44, 'Golf', 'Volkswagen', 3),
(36, 'Mau ga rja načenja, zamenjan motor, potrebno popravilo zavor.', 2300, 'neprodano', '2022-06-16 12:07:34', '2022-03-08 23:00:00', 45, 'serija 3', 'BMW', 3),
(37, 'Lepo ohranjen. Vožen vedno le za do cerkve ali pa do trgovine. Zadnja cena ob ogledu.', 999, 'neprodano', '2022-02-26 15:11:22', '2022-03-08 23:00:00', 46, 'C30', 'Volvo', 18),
(38, 'Praktično novo vozilo. Ene parkrat je bilo testirano.', 56000, 'prodano', '2022-02-26 15:17:00', '2022-04-13 19:09:30', 47, 'XC60', 'Volvo', 18),
(39, 'Kot nov. Vse dela brez problemov.', 39500, 'neprodano', '2022-06-17 06:25:53', '2022-03-08 23:00:00', 48, 'serija 5', 'BMW', 18),
(40, 'Neki neki', 29000, 'prodano', '2022-04-09 16:11:16', '2022-03-08 23:00:00', 49, 'A4', 'Audi', 3),
(41, 'Mah, mal je opraskan, enkrat je bil ob strani prebarvan.', 3500, 'neprodano', '2022-03-10 21:16:12', '2022-03-09 23:00:00', 50, 'C30', 'Volvo', 3),
(42, 'Malce opraskan, drugače je pa supr!', 15200, 'prodano', '2022-04-08 19:08:37', '2022-04-07 22:00:00', 51, 'Golf', 'Volkswagen', 18),
(44, 'Odlično ohrannje, kot nov. Kemično očiščen.', 32600, 'neprodano', '2022-04-11 21:04:35', '2022-04-07 22:00:00', 53, 'Arteon', 'Volkswagen', 3),
(45, 'Malce razbit, drgac pa kar vredu.', 3500, 'neprodano', '2022-04-13 19:21:24', '2022-04-13 19:21:24', 54, 'C30', 'Volvo', 18),
(47, 'Dobro ohranjeno. Bilo je tudi na kemičnem čiščenju, tako da je na noter kot nov.', 1900, 'neprodano', '2022-06-16 11:37:21', '2022-06-16 11:37:21', 56, 'Golf', 'Volkswagen', 20),
(48, 'Zadnji del otolčen. Potrebno je zamenjati gume, ker so že izrabljene.', 5240, 'neprodano', '2022-06-16 16:24:00', '2022-06-16 11:40:52', 57, '159', 'Alfa Romeo', 20),
(49, 'Novo vozilo. Le testirano', 56500, 'prodano', '2022-06-16 16:36:54', '2022-06-17 06:44:59', 58, 'A5', 'Audi', 20),
(50, 'Kot nov. Prebarvan je bil na oranžno barvo.', 7900, 'neprodano', '2022-06-17 06:31:18', '2022-06-17 06:30:10', 59, 'C30', 'Volvo', 20),
(51, 'Dober avto, vreden nakupa!', 25000, 'prodano', '2022-06-17 06:42:22', '2022-06-17 06:42:44', 60, 'ES', 'Lexus', 20),
(52, 'Sprednje zice sm pobral, ker je blu premal placa.', 700, 'neprodano', '2022-06-17 07:09:23', '2022-06-17 07:09:23', 61, 'Golf', 'Volkswagen', 21),
(53, 'Dober avto.', 20000, 'prodano', '2022-06-17 12:04:42', '2022-06-17 12:09:07', 62, 'Arteon', 'Volkswagen', 20);

-- --------------------------------------------------------

--
-- Table structure for table `oglas_karantena`
--

CREATE TABLE `oglas_karantena` (
  `karantena_oglasID` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) COLLATE utf8mb4_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profilka`
--

CREATE TABLE `profilka` (
  `profilkaID` int(11) NOT NULL,
  `uporabnikID` int(11) NOT NULL,
  `status` varchar(15) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `status_explanation` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `profilka`
--

INSERT INTO `profilka` (`profilkaID`, `uporabnikID`, `status`, `status_explanation`) VALUES
(1, 3, '0', 0),
(2, 18, '0', 0),
(3, 20, '0', 0),
(4, 21, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `slika`
--

CREATE TABLE `slika` (
  `slikaID` int(11) NOT NULL,
  `imeSlike` varchar(255) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `oglasID` int(11) NOT NULL,
  `voziloID` int(11) NOT NULL,
  `model` varchar(100) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `znamka` varchar(100) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `uporabnik_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `slika`
--

INSERT INTO `slika` (`slikaID`, `imeSlike`, `created_at`, `oglasID`, `voziloID`, `model`, `znamka`, `uporabnik_ID`) VALUES
(39, 'og22voz31up3num0.jpg', '2022-01-28 21:48:35', 22, 31, 'A3', 'Audi', 3),
(41, 'og23voz32up3num0.jpg', '2022-01-28 21:53:08', 23, 32, 'Corolla', 'Toyota', 3),
(42, 'og23voz32up3num1.jpg', '2022-01-28 21:53:08', 23, 32, 'Corolla', 'Toyota', 3),
(43, 'og23voz32up3num2.jpg', '2022-01-28 21:53:08', 23, 32, 'Corolla', 'Toyota', 3),
(44, 'og24voz33up3num0.jpg', '2022-01-28 22:32:49', 24, 33, 'i10', 'Hyundai', 3),
(45, 'og24voz33up3num1.jpg', '2022-01-28 22:32:49', 24, 33, 'i10', 'Hyundai', 3),
(46, 'og24voz33up3num2.jpg', '2022-01-28 22:32:49', 24, 33, 'i10', 'Hyundai', 3),
(47, 'og24voz33up3num3.jpg', '2022-01-28 22:32:49', 24, 33, 'i10', 'Hyundai', 3),
(48, 'og25voz34up3num0.jpg', '2022-01-28 22:45:27', 25, 34, 'A3', 'Audi', 3),
(49, 'og25voz34up3num1.jpg', '2022-01-28 22:45:27', 25, 34, 'A3', 'Audi', 3),
(50, 'og25voz34up3num2.jpg', '2022-01-28 22:45:27', 25, 34, 'A3', 'Audi', 3),
(51, 'og26voz35up3num0.jpg', '2022-01-28 22:50:26', 26, 35, 'Arteon', 'BMW', 3),
(52, 'og26voz35up3num1.jpg', '2022-01-28 22:50:26', 26, 35, 'Arteon', 'BMW', 3),
(53, 'og26voz35up3num2.jpg', '2022-01-28 22:50:26', 26, 35, 'Arteon', 'BMW', 3),
(62, 'og28voz37up3num0.jpg', '2022-01-31 22:13:46', 28, 37, 'A4', 'Audi', 3),
(63, 'og28voz37up3num1.jpg', '2022-01-31 22:13:46', 28, 37, 'A4', 'Audi', 3),
(64, 'og28voz37up3num2.jpg', '2022-01-31 22:13:46', 28, 37, 'A4', 'Audi', 3),
(65, 'og28voz37up3num3.jpg', '2022-01-31 22:13:46', 28, 37, 'A4', 'Audi', 3),
(66, 'og28voz37up3num4.jpg', '2022-01-31 22:13:46', 28, 37, 'A4', 'Audi', 3),
(73, 'og34voz43up3num0.jpg', '2022-02-26 11:18:53', 34, 43, 'A4', 'Audi', 3),
(74, 'og34voz43up3num1.jpg', '2022-02-26 11:18:53', 34, 43, 'A4', 'Audi', 3),
(75, 'og35voz44up3num0.jpg', '2022-02-26 11:39:44', 35, 44, 'Arteon', 'BMW', 3),
(76, 'og35voz44up3num1.jpg', '2022-02-26 11:39:44', 35, 44, 'Arteon', 'BMW', 3),
(77, 'og22voz31up3num1.jpg', '2022-02-26 11:54:43', 22, 31, 'A3', 'Audi', 3),
(78, 'og36voz45up3num0.jpg', '2022-02-26 12:02:01', 36, 45, 'Arteon', 'BMW', 3),
(79, 'og36voz45up3num1.jpg', '2022-02-26 12:02:01', 36, 45, 'Arteon', 'BMW', 3),
(80, 'og37voz46up18num0.jpg', '2022-02-26 15:11:22', 37, 46, 'C30', 'Volvo', 18),
(81, 'og37voz46up18num1.jpg', '2022-02-26 15:11:22', 37, 46, 'C30', 'Volvo', 18),
(82, 'og37voz46up18num2.jpg', '2022-02-26 15:11:22', 37, 46, 'C30', 'Volvo', 18),
(83, 'og38voz47up18num0.jpg', '2022-02-26 15:17:00', 38, 47, 'XC60', 'Volvo', 18),
(84, 'og38voz47up18num1.jpg', '2022-02-26 15:17:00', 38, 47, 'XC60', 'Volvo', 18),
(85, 'og39voz48up18num0.jpg', '2022-02-26 15:59:53', 39, 48, 'serija 5', 'BMW', 18),
(86, 'og39voz48up18num1.jpg', '2022-02-26 15:59:53', 39, 48, 'serija 5', 'BMW', 18),
(87, 'og40voz49up3num0.jpg', '2022-03-09 10:03:25', 40, 49, 'A4', 'Audi', 3),
(88, 'og41voz50up3num0.jpg', '2022-03-10 21:14:02', 41, 50, 'C30', 'Volvo', 3),
(89, 'og41voz50up3num1.jpg', '2022-03-10 21:14:02', 41, 50, 'C30', 'Volvo', 3),
(90, 'og42voz51up18num0.jpg', '2022-04-08 19:08:37', 42, 51, 'Arteon', 'BMW', 18),
(91, 'og44voz53up3num0.jpg', '2022-04-08 19:14:37', 44, 53, 'Arteon', 'BMW', 3),
(92, 'og44voz53up3num1.jpg', '2022-04-08 19:14:37', 44, 53, 'Arteon', 'BMW', 3),
(93, 'og45voz54up18num0.jpg', '2022-04-13 19:21:24', 45, 54, 'C30', 'Volvo', 18),
(94, 'og47voz56up20num0.jpg', '2022-06-16 11:37:21', 47, 56, 'Arteon', 'BMW', 20),
(95, 'og47voz56up20num1.jpg', '2022-06-16 11:37:21', 47, 56, 'Arteon', 'BMW', 20),
(96, 'og48voz57up20num0.jpg', '2022-06-16 11:40:52', 48, 57, '159', 'Alfa Romeo', 20),
(97, 'og48voz57up20num1.jpg', '2022-06-16 11:40:52', 48, 57, '159', 'Alfa Romeo', 20),
(98, 'og48voz57up20num2.jpg', '2022-06-16 11:40:52', 48, 57, '159', 'Alfa Romeo', 20),
(99, 'og49voz58up20num0.jpg', '2022-06-16 16:36:54', 49, 58, 'A5', 'Audi', 20),
(100, 'og49voz58up20num1.jpg', '2022-06-16 16:36:54', 49, 58, 'A5', 'Audi', 20),
(101, 'og50voz59up20num0.jpg', '2022-06-17 06:30:10', 50, 59, 'C30', 'Volvo', 20),
(102, 'og50voz59up20num1.jpg', '2022-06-17 06:30:10', 50, 59, 'C30', 'Volvo', 20),
(103, 'og50voz59up20num2.jpg', '2022-06-17 06:30:10', 50, 59, 'C30', 'Volvo', 20),
(104, 'og51voz60up20num0.jpg', '2022-06-17 06:42:22', 51, 60, 'ES', 'Lexus', 20),
(105, 'og51voz60up20num1.jpg', '2022-06-17 06:42:22', 51, 60, 'ES', 'Lexus', 20),
(106, 'og52voz61up21num0.jpg', '2022-06-17 07:09:23', 52, 61, 'Arteon', 'Volkswagen', 21),
(107, 'og52voz61up21num1.jpg', '2022-06-17 07:09:23', 52, 61, 'Arteon', 'Volkswagen', 21),
(108, 'og53voz62up20num0.jpg', '2022-06-17 12:04:05', 53, 62, 'Arteon', 'Volkswagen', 20),
(109, 'og53voz62up20num1.jpg', '2022-06-17 12:04:05', 53, 62, 'Arteon', 'Volkswagen', 20);

-- --------------------------------------------------------

--
-- Table structure for table `sporočilo`
--

CREATE TABLE `sporočilo` (
  `sporočiloID` int(11) NOT NULL,
  `opis` text COLLATE utf8mb4_slovenian_ci NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `prejemnikID` int(11) NOT NULL,
  `posiljateljID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `sporočilo`
--

INSERT INTO `sporočilo` (`sporočiloID`, `opis`, `created_at`, `prejemnikID`, `posiljateljID`) VALUES
(1, 'jaooo', '2022-02-28', 18, 3),
(2, 'Cigoo', '2022-02-28', 18, 3),
(3, 'Cigan si. Nebom kupu tvojga auta.', '2022-02-28', 18, 3),
(4, 'Nub si.', '2022-03-04', 3, 18),
(5, 'Mah dej sam ne bt pametn.', '2022-03-04', 18, 3),
(6, 'Nub', '2022-03-04', 18, 3),
(7, 'Bk se.', '2022-03-04', 3, 18),
(8, 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.', '2022-03-04', 3, 18),
(11, 'Ma uglavnm, jst mislm da bom totketa 5 pisou', '2022-03-04', 3, 18),
(12, 'Evi je retard', '2022-03-04', 3, 18),
(13, 'neki', '2022-03-04', 3, 18),
(14, 'Ne ne ti cigo.', '2022-03-04', 18, 3),
(15, 'Ne ne ti cigo.', '2022-03-04', 18, 3),
(16, 'oooo', '2022-03-04', 2, 3),
(17, 'Oj.', '2022-03-05', 12, 3),
(18, 'Dej gremo se ucit.', '2022-03-06', 18, 3),
(19, 'Nub', '2022-03-06', 14, 3),
(20, 'Jaooo', '2022-03-07', 18, 3),
(21, 'Zakaj imam sliko od blocANA', '2022-03-07', 3, 18),
(22, 'Ah kaj cm te jst pomagat, pejd pod nastavitve pa se jo spremene.', '2022-03-09', 18, 3),
(23, 'Kej se cigan', '2022-03-09', 18, 3),
(24, 'Alo nub', '2022-03-09', 10, 3),
(25, 'Jaooo bro.', '2022-03-10', 18, 3),
(26, 'jao.', '2022-03-11', 18, 3),
(27, 'Alooo.', '2022-03-11', 18, 3),
(28, 'Kejs nub.', '2022-03-11', 11, 3),
(29, 'Nub', '2022-03-11', 3, 18),
(30, 'neki neki', '2022-03-11', 1, 3),
(31, 'Evi je retard', '2022-03-11', 3, 19),
(32, 'Cigooo', '2022-03-11', 17, 3),
(33, 'jao', '2022-03-26', 18, 3),
(34, 'jao', '2022-03-26', 18, 3),
(35, 'jao', '2022-03-26', 18, 3),
(36, 'jao', '2022-03-26', 18, 3),
(37, 'jao', '2022-03-26', 18, 3),
(38, 'jao', '2022-03-26', 18, 3),
(39, 'jao', '2022-03-26', 18, 3),
(40, 'Ojj', '2022-04-09', 3, 18),
(41, 'Alooooooooooooooooooooooooooooooooooooooo!!', '2022-04-09', 3, 18),
(42, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2022-04-09', 3, 18),
(43, 'aloooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo. Neki!', '2022-04-09', 3, 18),
(44, 'aloooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo. Neki!', '2022-04-09', 3, 18),
(45, 'aloooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo. Neki!', '2022-04-09', 3, 18),
(46, 'aloooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo. Neki!', '2022-04-09', 3, 18),
(47, 'aloooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo. Neki!', '2022-04-09', 3, 18),
(48, 'aloooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo. Neki!', '2022-04-09', 3, 18),
(49, 'aloooooooooooooooooooooooaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa!', '2022-04-09', 18, 3),
(50, 'O Erik.', '2022-06-15', 18, 3),
(51, 'O erik. Zanima me nakup tvojega vozila.', '2022-06-16', 18, 20),
(52, 'Zivjo Jan, zanima me nakupa tvojega BMW-ja.', '2022-06-16', 3, 20),
(53, 'O super, me veseli. Za katerga BMW-ja pa se zanimas?', '2022-06-16', 20, 3),
(54, 'BMW serijo 3', '2022-06-16', 3, 20),
(55, 'Aha. ja to pa pod 10 jurjev ne bo slo.', '2022-06-16', 20, 3),
(56, 'Juu', '2022-06-16', 18, 3),
(57, 'Joj, jaz sem pa mislil da bi ga kupu pa za 9 jurjev.', '2022-06-16', 3, 20),
(58, 'Jah pod 9 pa pol ga ne dam. Lej dobru premisl, ker jst mislim da je zelu dober nakup. Vedno je bil redno servisiran, olje menjano na 12k kilometrov.', '2022-06-16', 20, 3),
(59, 'Hm...dobro bom premislu.', '2022-06-16', 3, 20),
(60, 'Ojjjjj.', '2022-06-16', 3, 20),
(61, 'aloooo', '2022-06-16', 3, 20),
(62, 'A boss kej odpisou', '2022-06-17', 3, 20),
(63, 'Ja zivjo, sm biu na dopustu', '2022-06-17', 20, 3),
(64, 'Kupil bom tvoj avto.', '2022-06-17', 3, 20);

-- --------------------------------------------------------

--
-- Table structure for table `tema`
--

CREATE TABLE `tema` (
  `temaID` int(11) NOT NULL,
  `naslov` varchar(255) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `razprava` text COLLATE utf8mb4_slovenian_ci NOT NULL,
  `uporabnikID` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `tema`
--

INSERT INTO `tema` (`temaID`, `naslov`, `razprava`, `uporabnikID`, `created_at`) VALUES
(5, 'Leto 2022? Mnenje o najbolšem avtu.', 'Men se to zdi odpadna pločevina. Skratka ena velka pločevina.', 3, '2022-06-16 11:14:41'),
(6, 'Kateri avto priporočate v letu 2019?', 'Nove alfice, kaj pravite fantje? Se splača.', 3, '2022-02-01 21:03:53'),
(10, 'BMW vs Hyundai? 2022? Kaj prauteeee', 'Meh, dej nvejm kaj vi Kaj praute.', 3, '2022-03-11 12:11:52'),
(16, 'Kaj dogaja? aaa?', 'Jaroooooooooooooooooooo!', 18, '2022-02-27 09:34:57');

-- --------------------------------------------------------

--
-- Table structure for table `uporabnik`
--

CREATE TABLE `uporabnik` (
  `uporabnikID` int(11) NOT NULL,
  `ime` varchar(50) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `priimek` varchar(50) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `ePosta` varchar(100) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `geslo` varchar(255) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `telefonska` varchar(12) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `opis` longtext COLLATE utf8mb4_slovenian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `uporabnik`
--

INSERT INTO `uporabnik` (`uporabnikID`, `ime`, `priimek`, `ePosta`, `geslo`, `telefonska`, `opis`, `created_at`) VALUES
(1, 'Jan', 'Sterle', 'jan.sterle123@gmail.com', '$2y$10$jDG3S95AvuArJggIM1.vxe93ntsuFTf2yGk3AeMWuj7OjxgeH.Nlm', '070766355', '', '2022-01-08 16:22:19'),
(2, 'Janez', 'Novak', 'janez.novak123@gmail.com', '$2y$10$DXjEepd3GUspHLI8BhsVxOTtTPIt0SY3B.eCBGO382kThfxjrmbri', '1386734', '', '2022-01-08 17:36:59'),
(3, 'Jan', 'Sterle', 'eva.sterle123@gmail.com', '$2y$10$3vUTNFnR90GHwnJJXYAOl.bJQbdj3oXgBB1ErdU.FZ7.xl0J0bPGq', '070766355', 'Sem najbolši prodajalec iz Lwške doline. Moje avte je blagoslovil Sv. Peter. Sem najbolši.', '2022-01-08 18:30:24'),
(10, 'Erik', 'Korenjak', 'erik.korenjak@gmail.com', '$2y$10$Ic4GwUHEN6z8b04BdEi6I.s0u7O9YaGns5CTMyu/I0qJ0jdfFxKAG', '45231512', '', '2022-01-09 10:30:09'),
(11, 'Erik', 'Korenjak', 'erik.korenjak@gmail.com', '$2y$10$ZP91FdORemxiUWukPNCc.uVk1hkLkkRaDEmd9vw/E6q0vgxTufHeK', '452315132', '', '2022-01-09 10:31:36'),
(12, 'nana', 'banana', 'nana@gmail.com', '$2y$10$xbj11Czqrnn5ck2mWNYyMu9LTUuvQ.iwN8TFRY0B.O5OF7LCgMxSi', '45231512', '', '2022-01-09 10:45:38'),
(13, 'nana', 'banana', 'nana1@gmail.com', '$2y$10$xOI.VNIDaABxBbMMMkYSGe4yZG/DNA1tVkAsFZ/t8uySVzNLpcNbC', '45231512', '', '2022-01-09 10:48:12'),
(14, 'Jan', 'Sterle', 'janinani.sterle123@gmail.com', '$2y$10$rT1CRTCopprgOLULMKM52eiF6JJv2Df//gUsU7K.7EdyWSnn0P2CC', '342667894', '', '2022-01-09 10:51:28'),
(15, 'Sandi', 'Urbiha', 'sandi.urbiha@gmail.com', '$2y$10$Qi9AXNYbfsRBmGVc4N/t1ulad.rXeN1jZo7GrXv6cIBfi5bfhlasq', '95437925', '', '2022-01-09 10:52:37'),
(17, 'jožek', 'božek', 'bozek@gmail.com', '$2y$10$BKiV9.HhN/jmDbeVOY5X.OGWaa2MUX9UlpG8cCWy6uDbY6icATNhq', '252346532', '', '2022-01-09 20:18:26'),
(18, 'Erik', 'Bloški', 'bine.cadez@gmail.com', '$2y$10$ZCABuET3FvhsVbyZmJR3ceiM4HAY1bxJcDS85jRT9V6WmGge6Fdpq', '12345678900', 'Sem Bine čadež. Rad preprodajm razne avtomobile. Lp', '2022-01-30 21:42:04'),
(19, 'Neki', 'neki2', 'neki2@gmail.com', '$2y$10$ws8mPdxoim1UZKm0qXzIR.KMIhYWJWbEqF9ifEa95xC1p0Dcehwpm', '54652467', '', '2022-03-11 12:02:27'),
(20, 'Jakec', 'Malečkar', 'jaka.maleckar@gmail.com', '$2y$10$o6R4RMKsYd//NkyOhs3KJ.HDSH9PD786SrGrsUwmkm0CAdEXdYzV2', '111023552', 'Zivim v LJ. LP', '2022-06-16 11:30:47'),
(21, 'Nejc', 'Silak', 'nejc.sila@gmail.com', '$2y$10$rLglsv6ZXCVTHVG/vRZRiuFYoDGoqHFwgK97JTlE0yXDToW7HnbZi', '076633112', 'Zivjo, sem Nejc in prihajam iz Primorske. Avte znam prodajat zlu dobru.', '2022-06-17 07:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `uporabnik_karantena`
--

CREATE TABLE `uporabnik_karantena` (
  `uporabnik_karantenaID` int(11) NOT NULL,
  `zacetek_karantene` date NOT NULL DEFAULT current_timestamp(),
  `konec_karantene` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(55) COLLATE utf8mb4_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `uporabnik_karantena`
--

INSERT INTO `uporabnik_karantena` (`uporabnik_karantenaID`, `zacetek_karantene`, `konec_karantene`, `status`) VALUES
(3, '2022-03-09', '2022-03-09', 'Vse je vredu'),
(10, '2022-03-10', '2022-03-10', 'Vse je vredu'),
(15, '2022-03-09', '2022-03-09', 'Uporabnik je bil uspešno banan za nedoločen čas.'),
(18, '2022-03-09', '2022-03-09', 'Vse je vredu'),
(19, '2022-06-17', '2022-06-17', 'Uporabnik je bil uspešno banan za nedoločen čas.'),
(20, '2022-06-16', '2022-06-16', 'Vse je vredu');

-- --------------------------------------------------------

--
-- Table structure for table `vozilo`
--

CREATE TABLE `vozilo` (
  `voziloID` int(11) NOT NULL,
  `VIN` varchar(17) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `prevozeniKm` int(11) NOT NULL,
  `letnik` int(11) NOT NULL,
  `pogon` varchar(20) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `znamka` varchar(100) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `model` varchar(100) COLLATE utf8mb4_slovenian_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `vozilo`
--

INSERT INTO `vozilo` (`voziloID`, `VIN`, `prevozeniKm`, `letnik`, `pogon`, `znamka`, `model`, `created_at`) VALUES
(31, 'asnrvprvbnrbor', 130000, 2017, 'bencin', 'Audi', 'A3', '2022-01-28 21:48:35'),
(32, 'wkte4erfvrvrj', 201000, 2014, 'diesel', 'Toyota', 'Corolla', '2022-01-28 21:53:08'),
(33, 'abcdefghijklmn', 15000, 2021, 'bencin', 'Hyundai', 'i10', '2022-01-28 22:32:49'),
(34, 'fvffvrvrvkkhgrp', 14000, 2022, 'hibrid', 'Audi', 'A3', '2022-01-28 22:45:27'),
(35, 'apppfrferfef', 45755, 2016, 'hibrid', 'Volkswagen', 'Arteon', '2022-03-07 20:41:55'),
(36, 'JH4KA3150HC004866', 200000, 2010, 'diesel', 'BMW', 'serija 3', '2022-02-02 13:08:08'),
(37, '3C3CFFER6CT225038', 12450, 2013, 'hibrid', 'Audi', 'A4', '2022-02-01 19:52:25'),
(38, 'JH4KA3260LC000123', 14666, 2020, 'diesel', 'Alfa Romeo', 'giulia', '2022-02-02 13:11:00'),
(39, 'nwqpsjoqwo', 13000, 2015, 'e-pogon', 'Volkswagen', 'Golf', '2022-02-02 13:37:27'),
(42, 'tgerb254nvf2rni3e', 144000, 2017, 'bencin', 'Audi', 'A5', '2022-02-26 11:15:26'),
(43, 'ljrf4332543nrfe12', 144000, 2017, 'e-pogon', 'Audi', 'A4', '2022-06-16 11:13:29'),
(44, 'jjkneki2435sah99h', 12563, 2015, 'hibrid', 'Volkswagen', 'Golf', '2022-04-13 18:50:28'),
(45, '462ngtrtr2saggga2', 456444, 2005, 'diesel', 'BMW', 'serija 3', '2022-06-16 12:07:34'),
(46, 'FK6532912TAAAV', 199230, 2011, 'bencin', 'Volvo', 'C30', '2022-02-26 15:11:22'),
(47, 'kk1254aaavge90', 500, 2022, 'hibrid', 'Volvo', 'XC60', '2022-02-26 15:17:00'),
(48, 'JKKK32AV34BZZ', 12333, 2021, 'hibrid', 'BMW', 'serija 5', '2022-06-17 06:25:53'),
(49, 'vuizkvuzgtuczjj', 14000, 2019, 'e-pogon', 'Audi', 'A4', '2022-04-09 16:11:16'),
(50, 'lllw2qgrt55423', 277400, 2014, 'bencin', 'Volvo', 'C30', '2022-03-10 21:16:12'),
(51, 'ktgg3454355421f', 142555, 2018, 'hibrid', 'Volkswagen', 'Golf', '2022-04-08 19:08:37'),
(52, '543ghtgrtrtttaast', 100000, 2016, 'bencin', 'Volkswagen', 'Arteon', '2022-04-08 19:12:55'),
(53, '653654ghzujuaaf4', 20000, 2020, 'e-pogon', 'Volkswagen', 'Arteon', '2022-04-11 21:04:35'),
(54, 'KGGR2233100L', 356021, 2010, 'bencin', 'Volvo', 'C30', '2022-04-13 19:21:24'),
(55, 'kk34aabb44ff11hhf', 224055, 2002, 'bencin', 'Volkswagen', 'Golf', '2022-06-16 11:34:24'),
(56, 'hzhh3237871ya', 224905, 2001, 'bencin', 'Volkswagen', 'Golf', '2022-06-16 11:37:21'),
(57, 'k112ffab323urtg', 339921, 2012, 'hibrid', 'Alfa Romeo', '159', '2022-06-16 16:24:00'),
(58, 'kkk1221ffghhaasf', 1200, 2021, 'hibrid', 'Audi', 'A5', '2022-06-16 16:36:54'),
(59, 'ssa4411gghhll', 155200, 2013, 'bencin', 'Volvo', 'C30', '2022-06-17 06:31:18'),
(60, 'fewll43511255gg', 19000, 2016, 'LPG avtoplin', 'Lexus', 'ES', '2022-06-17 06:42:22'),
(61, 'kjff11429ffaafg', 588000, 1980, 'bencin', 'Volkswagen', 'Golf', '2022-06-17 07:09:23'),
(62, 'kszewpw123a', 14000, 2014, 'diesel', 'Volkswagen', 'Arteon', '2022-06-17 12:04:42');

-- --------------------------------------------------------

--
-- Table structure for table `znamka`
--

CREATE TABLE `znamka` (
  `znamka` varchar(100) COLLATE utf8mb4_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `znamka`
--

INSERT INTO `znamka` (`znamka`) VALUES
('Alfa Romeo'),
('Audi'),
('BMW'),
('Fiat'),
('Hyundai'),
('Lexus'),
('Mercedes-Benz'),
('Toyota'),
('Volkswagen'),
('Volvo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`komentarID`),
  ADD KEY `fk_temaid1` (`temaID`),
  ADD KEY `fk_uporabnikid3` (`uporabnikID`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`imeModela`),
  ADD KEY `fk_znamka1` (`znamka`);

--
-- Indexes for table `odgovor`
--
ALTER TABLE `odgovor`
  ADD PRIMARY KEY (`odgovorID`),
  ADD KEY `fk_komentarid1` (`komentarID`),
  ADD KEY `fk_odgovorjenoidju` (`odgovorjenID`),
  ADD KEY `fk_uporabnikid` (`uporabnikID`);

--
-- Indexes for table `oglas`
--
ALTER TABLE `oglas`
  ADD PRIMARY KEY (`oglasID`),
  ADD KEY `fk_uporabnikID2` (`uporabnikID`),
  ADD KEY `fk_voziloID1` (`voziloID`),
  ADD KEY `fk_znamka2` (`znamka`),
  ADD KEY `fk_fk_model2` (`model`);

--
-- Indexes for table `oglas_karantena`
--
ALTER TABLE `oglas_karantena`
  ADD PRIMARY KEY (`karantena_oglasID`);

--
-- Indexes for table `profilka`
--
ALTER TABLE `profilka`
  ADD PRIMARY KEY (`profilkaID`),
  ADD KEY `fk_uporabnikid1` (`uporabnikID`);

--
-- Indexes for table `slika`
--
ALTER TABLE `slika`
  ADD PRIMARY KEY (`slikaID`),
  ADD KEY `fk_oglasid1` (`oglasID`),
  ADD KEY `fk_znamkaid1` (`znamka`),
  ADD KEY `fk_modelid1` (`model`),
  ADD KEY `fk_voziloid2` (`voziloID`),
  ADD KEY `fk_upoorabnikid2` (`uporabnik_ID`);

--
-- Indexes for table `sporočilo`
--
ALTER TABLE `sporočilo`
  ADD PRIMARY KEY (`sporočiloID`),
  ADD KEY `fk_posiljateljID` (`posiljateljID`),
  ADD KEY `fk_prejemnikID` (`prejemnikID`);

--
-- Indexes for table `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`temaID`),
  ADD KEY `fk_uporabnik` (`uporabnikID`);

--
-- Indexes for table `uporabnik`
--
ALTER TABLE `uporabnik`
  ADD PRIMARY KEY (`uporabnikID`);

--
-- Indexes for table `uporabnik_karantena`
--
ALTER TABLE `uporabnik_karantena`
  ADD PRIMARY KEY (`uporabnik_karantenaID`);

--
-- Indexes for table `vozilo`
--
ALTER TABLE `vozilo`
  ADD PRIMARY KEY (`voziloID`),
  ADD KEY `fk_fk_znamka1` (`znamka`),
  ADD KEY `fk_model1` (`model`);

--
-- Indexes for table `znamka`
--
ALTER TABLE `znamka`
  ADD PRIMARY KEY (`znamka`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `komentarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `odgovor`
--
ALTER TABLE `odgovor`
  MODIFY `odgovorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `oglas`
--
ALTER TABLE `oglas`
  MODIFY `oglasID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `profilka`
--
ALTER TABLE `profilka`
  MODIFY `profilkaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slika`
--
ALTER TABLE `slika`
  MODIFY `slikaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `sporočilo`
--
ALTER TABLE `sporočilo`
  MODIFY `sporočiloID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `tema`
--
ALTER TABLE `tema`
  MODIFY `temaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `uporabnik`
--
ALTER TABLE `uporabnik`
  MODIFY `uporabnikID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `vozilo`
--
ALTER TABLE `vozilo`
  MODIFY `voziloID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `fk_temaid1` FOREIGN KEY (`temaID`) REFERENCES `tema` (`temaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_uporabnikid3` FOREIGN KEY (`uporabnikID`) REFERENCES `uporabnik` (`uporabnikID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `fk_znamka1` FOREIGN KEY (`znamka`) REFERENCES `znamka` (`znamka`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `odgovor`
--
ALTER TABLE `odgovor`
  ADD CONSTRAINT `fk_komentarid1` FOREIGN KEY (`komentarID`) REFERENCES `komentar` (`komentarID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_odgovorjenoidju` FOREIGN KEY (`odgovorjenID`) REFERENCES `odgovor` (`odgovorID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_uporabnikid` FOREIGN KEY (`uporabnikID`) REFERENCES `uporabnik` (`uporabnikID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oglas`
--
ALTER TABLE `oglas`
  ADD CONSTRAINT `fk_uporabnikID2` FOREIGN KEY (`uporabnikID`) REFERENCES `uporabnik` (`uporabnikID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_voziloID1` FOREIGN KEY (`voziloID`) REFERENCES `vozilo` (`voziloID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_znamka2` FOREIGN KEY (`znamka`) REFERENCES `vozilo` (`znamka`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profilka`
--
ALTER TABLE `profilka`
  ADD CONSTRAINT `fk_uporabnikid1` FOREIGN KEY (`uporabnikID`) REFERENCES `uporabnik` (`uporabnikID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `slika`
--
ALTER TABLE `slika`
  ADD CONSTRAINT `fk_modelid1` FOREIGN KEY (`model`) REFERENCES `oglas` (`model`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_oglasid1` FOREIGN KEY (`oglasID`) REFERENCES `oglas` (`oglasID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_upoorabnikid2` FOREIGN KEY (`uporabnik_ID`) REFERENCES `oglas` (`uporabnikID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_voziloid2` FOREIGN KEY (`voziloID`) REFERENCES `oglas` (`voziloID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_znamkaid1` FOREIGN KEY (`znamka`) REFERENCES `oglas` (`znamka`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sporočilo`
--
ALTER TABLE `sporočilo`
  ADD CONSTRAINT `fk_posiljateljID` FOREIGN KEY (`posiljateljID`) REFERENCES `uporabnik` (`uporabnikID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prejemnikID` FOREIGN KEY (`prejemnikID`) REFERENCES `uporabnik` (`uporabnikID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tema`
--
ALTER TABLE `tema`
  ADD CONSTRAINT `fk_uporabnik` FOREIGN KEY (`uporabnikID`) REFERENCES `uporabnik` (`uporabnikID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vozilo`
--
ALTER TABLE `vozilo`
  ADD CONSTRAINT `fk_fk_znamka1` FOREIGN KEY (`znamka`) REFERENCES `znamka` (`znamka`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_model1` FOREIGN KEY (`model`) REFERENCES `model` (`imeModela`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
