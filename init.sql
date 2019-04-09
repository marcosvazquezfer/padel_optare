-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 22-10-2018 a las 17:24:15
-- Versión del servidor: 5.7.23-0ubuntu0.16.04.1-log
-- Versión de PHP: 5.6.37-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `abp32`
--
-- -----------------------------------------------------
-- Schema abp32
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `abp32` ;

-- -----------------------------------------------------
-- Schema abp32
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `abp32` ;
USE `abp32` ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Administrador`
--

CREATE TABLE `Administrador` (
  `userId` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Administrador`
--

INSERT INTO `Administrador` (`userId`) VALUES
('11111111A'),
('11111111B'),
('22222222B'),
('33333333C'),
('44444444D'),
('55555555E'),
('66666666F'),
('77777777G'),
('88888888H'),
('99999999I');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Calendario`
--

CREATE TABLE `Calendario` (
  `FechaHoraInicio` datetime NOT NULL,
  `FechaHoraFin` datetime NOT NULL,
  `idPista` int(11) NOT NULL,
  `userId` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Calendario`
--

INSERT INTO `Calendario` (`FechaHoraInicio`, `FechaHoraFin`, `idPista`, `userId`) VALUES
('2017-12-01 12:00:00', '2017-12-01 14:00:00', 1, NULL),
('2017-12-26 12:00:00', '2017-12-26 14:00:00', 1, NULL),
('2018-11-21 08:00:00', '2018-11-21 09:30:00', 1, NULL),
('2017-12-11 12:00:00', '2017-12-11 14:00:00', 2, NULL),
('2017-12-31 14:00:00', '2017-12-31 16:00:00', 2, NULL),
('2018-11-21 08:00:00', '2018-11-21 09:30:00', 2, NULL),  
('2017-12-06 12:00:00', '2017-12-06 14:00:00', 3, NULL),
('2017-12-12 12:00:00', '2017-12-12 14:00:00', 3, NULL),
('2018-11-21 08:00:00', '2018-11-21 09:30:00', 3, NULL),
('2017-12-23 12:00:00', '2017-12-23 14:00:00', 4, NULL),
('2018-11-21 08:00:00', '2018-11-21 09:30:00', 4, NULL),
('2017-12-31 12:00:00', '2017-12-31 14:00:00', 5, NULL),
('2018-11-21 08:00:00', '2018-11-21 09:30:00', 5, NULL),
('2018-11-21 08:00:00', '2018-11-21 09:30:00', 6, NULL),
('2018-11-21 08:00:00', '2018-11-21 09:30:00', 7, NULL),
('2017-12-23 14:00:00', '2017-12-23 15:00:00', 8, NULL),
('2018-11-21 08:00:00', '2018-11-21 09:30:00', 8, NULL),
('2017-12-14 12:00:00', '2017-12-14 14:00:00', 9, NULL),
('2018-11-21 08:00:00', '2018-11-21 09:30:00', 9, NULL),
('2017-12-03 12:00:00', '2017-12-03 14:00:00', 10, NULL),
('2018-11-21 08:00:00', '2018-11-21 09:30:00', 10, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Campeonato`
--

CREATE TABLE `Campeonato` (
  `idCampeonato` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `maxParticipantes` smallint(4) DEFAULT NULL,
  `normativa` varchar(100) NOT NULL,
  `fechaLimite` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Campeonato`
--

INSERT INTO `Campeonato` (`idCampeonato`, `nombre`, `maxParticipantes`, `normativa`, `fechaLimite`) VALUES
(1, 'ESEI', 50, 'normativa_COPERSA.txt', '2018-11-25 23:59:59'),
(2, 'OPTARIANOS', 50, 'normativa_OPTARIANOS.txt', '2018-11-25 23:59:59'),
(3, 'APERSA', 20, 'normativa_APERSA.txt', '2018-11-25 23:59:59'),
(4, 'PEREZ RUMBAO', 30, 'normativa_PEREZRUMBAO.txt', '2018-11-25 23:59:59'),
(5, 'GADIS', 28, 'normativa_GADIS.txt', '2018-11-25 23:59:59'),
(6, 'CIDADE DE OURENSE', 50, 'normativa_CIDADEDEOURENSE.txt', '2018-11-25 23:59:59'),
(7, 'MILENIO', 36, 'normativa_MILENIO.txt', '2018-11-25 23:59:59'),
(8, 'AS BURGAS', 40, 'normativa_ASBURGAS.txt', '2018-11-25 23:59:59'),
(9, 'AURIA', 60, 'normativa_AURIA.txt', '2018-11-25 23:59:59'),
(10, 'KO', 10, 'normativa_KO.txt', '2018-11-25 23:59:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categoria`
--

CREATE TABLE `Categoria` (
  `idCategoria` int(11) NOT NULL,
  `genero` varchar(2) DEFAULT NULL,
  `nivel` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Categoria`
--

INSERT INTO `Categoria` (`idCategoria`, `genero`, `nivel`) VALUES
(1, 'M', 1),
(2, 'F', 1),
(3, 'MX', 1),
(4, 'M', 2),
(5, 'F', 2),
(6, 'MX', 2),
(7, 'M', 3),
(8, 'F', 3),
(9, 'MX', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categorias_Campeonato`
--

CREATE TABLE `Categorias_Campeonato` (
  `idCampeonato` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Categorias_Campeonato`
--

INSERT INTO `Categorias_Campeonato` (`idCampeonato`, `idCategoria`) VALUES
(1, 1),
(1, 2),
(2, 4),
(2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Deportista`
--

CREATE TABLE `Deportista` (
  `userId` varchar(20) NOT NULL,
  `isSocio` tinyint(4) NOT NULL,
  `nivel` tinyint(2) DEFAULT NULL,
  `genero` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Deportista`
--

INSERT INTO `Deportista` (`userId`, `isSocio`, `nivel`, `genero`) VALUES
('11111111A', 1, 2, 'F'),
('11111111B', 1, 2, 'M'),
('11111111C', 1, 2, 'M'),
('11111111D', 0, 2, 'M'),
('11111111E', 0, 2, 'M'),
('11111111F', 0, 2, 'M'),
('11111111G', 0, 2, 'M'),
('11111111H', 1, 1, 'F'),
('11111111I', 1, 1, 'F'),
('22222222A', 1, 1, 'F'),
('22222222B', 1, 2, 'M'),
('22222222C', 0, 2, 'M'),
('22222222D', 0, 2, 'M'),
('22222222E', 1, 2, 'M'),
('22222222F', 1, 2, 'M'),
('22222222G', 1, 2, 'M'),
('22222222H', 1, 2, 'M'),
('22222222I', 1, 1, 'F'),
('33333333A', 1, 1, 'F'),
('33333333B', 1, 1, 'F'),
('33333333C', 1, 3, 'M'),
('33333333D', 0, 3, 'M'),
('33333333E', 0, 3, 'M'),
('33333333F', 0, 3, 'M'),
('33333333G', 0, 3, 'M'),
('33333333H', 0, 3, 'M'),
('33333333I', 0, 3, 'M'),
('44444444A', 1, 1, 'M'),
('44444444B', 1, 1, 'F'),
('44444444C', 1, 1, 'F'),
('44444444D', 1, 1, 'M'),
('44444444E', 1, 1, 'M'),
('44444444F', 1, 1, 'M'),
('44444444G', 1, 1, 'M'),
('44444444H', 1, 1, 'M'),
('44444444I', 1, 1, 'M'),
('55555555A', 0, 3, 'M'),
('55555555B', 0, 3, 'M'),
('55555555E', 1, 3, 'F'),
('55555555F', 0, 3, 'F'),
('55555555G', 1, 3, 'F'),
('55555555H', 0, 3, 'F'),
('55555555I', 0, 3, 'M'),
('66666666A', 1, 1, 'M'),
('66666666B', 1, 1, 'M'),
('66666666C', 1, 1, 'M'),
('66666666F', 0, 1, 'F'),
('66666666G', 1, 1, 'F'),
('66666666H', 0, 1, 'F'),
('66666666I', 1, 1, 'F'),
('77777777A', 0, 3, 'M'),
('77777777B', 0, 3, 'M'),
('77777777C', 0, 3, 'M'),
('77777777D', 0, 3, 'M'),
('77777777G', 0, 3, 'M'),
('77777777H', 0, 3, 'M'),
('77777777I', 1, 3, 'M'),
('88888888A', 0, 1, 'F'),
('88888888B', 1, 1, 'F'),
('88888888H', 1, 1, 'F'),
('88888888I', 1, 1, 'F'),
('99999999A', 0, 2, 'M'),
('99999999B', 1, 2, 'M'),
('99999999C', 0, 2, 'M'),
('99999999I', 1, 2, 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Deportistas_Partido`
--

CREATE TABLE `Deportistas_Partido` (
  `idPartido` int(11) NOT NULL,
  `userId` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Deportistas_Partido`
--

INSERT INTO `Deportistas_Partido` (`idPartido`, `userId`) VALUES
(1, '11111111A'),
(10, '11111111B'),
(2, '22222222B'),
(3, '33333333C'),
(4, '44444444D'),
(5, '55555555E'),
(6, '66666666F'),
(7, '77777777G'),
(8, '88888888H'),
(9, '99999999I');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Enfrentamiento`
--

CREATE TABLE `Enfrentamiento` (
  `idEnfrentamiento` int(11) NOT NULL,
  `resultado` varchar(11) DEFAULT NULL,
  `idPareja1` int(11) NOT NULL,
  `idPareja2` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `idPista` int(11) DEFAULT NULL,
  `horario` datetime DEFAULT NULL,
  `ganador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Enfrentamiento`
--

INSERT INTO `Enfrentamiento` (`idEnfrentamiento`, `resultado`, `idPareja1`, `idPareja2`, `idGrupo`, `idPista`, `horario`, `ganador`) VALUES
(1, '6-2/6-0', 1, 2, 1, NULL, NULL, 1),
(2, '2-6/4-6', 1, 3, 1, NULL, NULL, 3),
(3, '6-2/2-6/6-0', 1, 4, 1, NULL, NULL, 4),
(4, '2-6/4-6', 1, 5, 1, NULL, NULL, 5),
(5, '6-2/2-6/6-2', 1, 6, 1, NULL, NULL, 7),
(6, '6-2/2-6/6-0', 1, 7, 1, NULL, NULL, 7),
(7, '6-2/2-6/6-0', 1, 8, 1, NULL, NULL, 8),
(8, '6-2/6-0', 1, 9, 1, NULL, NULL, 9),
(9, '2-6/4-6', 1, 10, 1, NULL, NULL, 10),
(10, '6-2/6-0', 1, 11, 1, NULL, NULL, 10),
(11, '6-2/2-6/6-2', 2, 3, 1, NULL, NULL, 11),
(12, '6-2/2-6/6-0', 2, 4, 1, NULL, NULL, 12),
(13, '6-2/2-6/6-2', 2, 5, 1, NULL, NULL, 13),
(14, '6-2/2-6/6-2', 2, 6, 1, NULL, NULL, 13),
(15, '2-6/4-6', 2, 7, 1, NULL, NULL, 14),
(16, '6-2/2-6/6-0', 2, 8, 1, NULL, NULL, 15),
(17, '2-6/4-6', 2, 9, 1, NULL, NULL, 16),
(18, '6-2/2-6/6-0', 2, 10, 1, NULL, NULL, 17),
(19, '6-2/2-6/6-2', 2, 11, 1, NULL, NULL, 18),
(20, '2-6/4-6', 3, 4, 1, NULL, NULL, 19),
(21, '6-2/2-6/6-2', 3, 5, 1, NULL, NULL, 20),
(22, '6-2/2-6/6-0', 3, 6, 1, NULL, NULL, 21),
(23, '6-2/6-0', 3, 7, 1, NULL, NULL, 22),
(24, '6-2/6-0', 3, 8, 1, NULL, NULL, 1),
(25, '6-2/2-6/6-0', 3, 9, 1, NULL, NULL, 2),
(26, '6-2/2-6/6-0', 3, 10, 1, NULL, NULL, 3),
(27, '2-6/4-6', 3, 11, 1, NULL, NULL, 4),
(28, '6-2/6-0', 4, 5, 1, NULL, NULL, 5),
(29, '6-2/2-6/6-0', 4, 6, 1, NULL, NULL, 6),
(30, '6-2/2-6/6-0', 4, 7, 1, NULL, NULL, 7),
(31, '2-6/4-6', 4, 8, 1, NULL, NULL, 8),
(32, '6-2/6-0', 4, 9, 1, NULL, NULL, 9),
(33, '6-2/2-6/6-2', 4, 10, 1, NULL, NULL, 10),
(34, '2-6/4-6', 4, 11, 1, NULL, NULL, 11),
(35, '6-2/2-6/6-2', 5, 6, 1, NULL, NULL, 12),
(36, '6-2/2-6/6-0', 5, 7, 1, NULL, NULL, 13),
(37, '6-2/6-0', 5, 8, 1, NULL, NULL, 14),
(38, '6-2/2-6/6-0', 5, 9, 1, NULL, NULL, 15),
(39, NULL, 5, 10, 1, NULL, NULL, NULL),
(40, NULL, 5, 11, 1, NULL, NULL, NULL),
(41, NULL, 6, 7, 1, NULL, NULL, NULL),
(42, NULL, 6, 8, 1, NULL, NULL, NULL),
(43, NULL, 6, 9, 1, NULL, NULL, NULL),
(44, NULL, 6, 10, 1, NULL, NULL, NULL),
(45, NULL, 6, 11, 1, NULL, NULL, NULL),
(46, NULL, 7, 8, 1, NULL, NULL, NULL),
(47, NULL, 7, 9, 1, NULL, NULL, NULL),
(48, NULL, 7, 10, 1, NULL, NULL, NULL),
(49, NULL, 7, 11, 1, NULL, NULL, NULL),
(50, NULL, 8, 9, 1, NULL, NULL, NULL),
(51, NULL, 8, 10, 1, NULL, NULL, NULL),
(52, NULL, 8, 11, 1, NULL, NULL, NULL),
(53, NULL, 9, 10, 1, NULL, NULL, NULL),
(54, NULL, 9, 11, 1, NULL, NULL, NULL),
(55, NULL, 10, 11, 1, NULL, NULL, NULL),
(56, '6-2/2-6/6-0', 12, 13, 2, NULL, NULL, 12),
(57, '6-2/2-6/6-0', 12, 14, 2, NULL, NULL, 13),
(58, '6-2/6-0', 12, 15, 2, NULL, NULL, 14),
(59, '2-6/4-6', 12, 16, 2, NULL, NULL, 15),
(60, '6-2/6-0', 12, 17, 2, NULL, NULL, 16),
(61, '6-2/2-6/6-0', 12, 19, 2, NULL, NULL, 17),
(62, '2-6/4-6', 12, 20, 2, NULL, NULL, 18),
(63, '6-2/6-0', 12, 21, 2, NULL, NULL, 19),
(64, '6-2/2-6/6-0', 12, 22, 2, NULL, NULL, 20),
(65, '6-2/2-6/6-2', 12, 23, 2, NULL, NULL, 21),
(66, '2-6/4-6', 13, 14, 2, NULL, NULL, 22),
(67, '6-2/2-6/6-0', 13, 15, 2, NULL, NULL, 18),
(68, '6-2/2-6/6-2', 13, 16, 2, NULL, NULL, 19),
(69, '6-2/2-6/6-0', 13, 17, 2, NULL, NULL, 20),
(70, '6-2/6-0', 13, 19, 2, NULL, NULL, 21),
(71, '6-2/2-6/6-0', 13, 20, 2, NULL, NULL, 22),
(72, '6-2/2-6/6-2', 13, 21, 2, NULL, NULL, 23),
(73, '6-2/2-6/6-0', 13, 22, 2, NULL, NULL, 24),
(74, '6-2/6-0', 13, 23, 2, NULL, NULL, 25),
(75, '6-2/6-0', 14, 15, 2, NULL, NULL, 26),
(76, '2-6/4-6', 14, 16, 2, NULL, NULL, 22),
(77, '6-2/2-6/6-0', 14, 17, 2, NULL, NULL, 21),
(78, '6-2/6-0', 14, 19, 2, NULL, NULL, 20),
(79, '6-2/6-0', 14, 20, 2, NULL, NULL, 19),
(80, '6-2/2-6/6-0', 14, 21, 2, NULL, NULL, 18),
(81, '6-2/2-6/6-0', 14, 22, 2, NULL, NULL, 17),
(82, '6-2/6-0', 14, 23, 2, NULL, NULL, 16),
(83, '6-2/6-0', 15, 16, 2, NULL, NULL, 15),
(84, '6-2/2-6/6-0', 15, 17, 2, NULL, NULL, 1),
(85, '2-6/4-6', 15, 19, 2, NULL, NULL, 12),
(86, '6-2/6-0', 15, 20, 2, NULL, NULL, 13),
(87, '6-2/2-6/6-2', 15, 21, 2, NULL, NULL, 15),
(88, '6-2/2-6/6-0', 15, 22, 2, NULL, NULL, 16),
(89, '6-2/2-6/6-0', 15, 23, 2, NULL, NULL, 17),
(90, NULL, 16, 17, 2, NULL, NULL, NULL),
(91, NULL, 16, 19, 2, NULL, NULL, NULL),
(92, NULL, 16, 20, 2, NULL, NULL, NULL),
(93, NULL, 16, 21, 2, NULL, NULL, NULL),
(94, NULL, 16, 22, 2, NULL, NULL, NULL),
(95, NULL, 16, 23, 2, NULL, NULL, NULL),
(96, NULL, 17, 19, 2, NULL, NULL, NULL),
(97, NULL, 17, 20, 2, NULL, NULL, NULL),
(98, NULL, 17, 21, 2, NULL, NULL, NULL),
(99, NULL, 17, 22, 2, NULL, NULL, NULL),
(100, NULL, 17, 23, 2, NULL, NULL, NULL),
(101, NULL, 19, 20, 2, NULL, NULL, NULL),
(102, NULL, 19, 21, 2, NULL, NULL, NULL),
(103, NULL, 19, 22, 2, NULL, NULL, NULL),
(104, NULL, 19, 23, 2, NULL, NULL, NULL),
(105, NULL, 20, 21, 2, NULL, NULL, NULL),
(106, NULL, 20, 22, 2, NULL, NULL, NULL),
(107, NULL, 20, 23, 2, NULL, NULL, NULL),
(108, NULL, 21, 22, 2, NULL, NULL, NULL),
(109, NULL, 21, 23, 2, NULL, NULL, NULL),
(110, NULL, 22, 23, 2, NULL, NULL, NULL),
(111, '6-2/6-0', 24, 25, 3, NULL, NULL, 24),
(112, '2-6/4-6', 24, 26, 3, NULL, NULL, 24),
(113, '6-2/6-0', 24, 27, 3, NULL, NULL, 24),
(114, '6-2/2-6/6-2', 24, 29, 3, NULL, NULL, 24),
(115, '6-2/6-0', 25, 26, 3, NULL, NULL, 24),
(116, '6-2/2-6/6-2', 25, 27, 3, NULL, NULL, 24),
(117, '6-2/6-0', 25, 29, 3, NULL, NULL, 25),
(118, '2-6/4-6', 26, 27, 3, NULL, NULL, 25),
(119, NULL, 26, 29, 3, NULL, NULL, NULL),
(120, NULL, 27, 29, 3, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Grupo`
--

CREATE TABLE `Grupo` (
  `idGrupo` int(11) NOT NULL,
  `idCampeonato` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Grupo`
--

INSERT INTO `Grupo` (`idGrupo`, `idCampeonato`, `idCategoria`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pareja`
--

CREATE TABLE `Pareja` (
  `idPareja` int(11) NOT NULL,
  `capitan` varchar(20) DEFAULT NULL,
  `par` varchar(20) DEFAULT NULL,
  `idGrupo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Pareja`
--

INSERT INTO `Pareja` (`idPareja`, `capitan`, `par`, `idGrupo`) VALUES
(1, '22222222B', '33333333C', 1),
(2, '44444444D', '77777777G', 1),
(3, '99999999I', '11111111B', 1),
(4, '22222222C', '33333333D', 1),
(5, '44444444E', '77777777H', 1),
(6, '99999999A', '11111111C', 1),
(7, '22222222D', '33333333E', 1),
(8, '44444444F', '77777777I', 1),
(9, '99999999B', '11111111D', 1),
(10, '22222222E', '33333333F', 1),
(11, '44444444G', '77777777A', 1),
(12, '99999999C', '11111111E', 2),
(13, '22222222F', '33333333G', 2),
(14, '44444444H', '55555555I', 2),
(15, '66666666A', '77777777B', 2),
(16, '11111111F', '22222222G', 2),
(17, '33333333H', '44444444I', 2),
(19, '55555555A', '66666666B', 2),
(20, '77777777C', '11111111G', 2),
(21, '22222222H', '33333333I', 2),
(22, '44444444A', '55555555B', 2),
(23, '66666666C', '77777777D', 2),
(24, '11111111A', '55555555E', 3),
(25, '66666666F', '88888888H', 3),
(26, '11111111H', '22222222I', 3),
(27, '33333333A', '44444444B', 3),
(28, '11111111I', '22222222A', NULL),
(29, '33333333B', '44444444C', 3),
(30, '22222222B', '77777777G', NULL),
(31, '33333333C', '44444444D', NULL),
(32, '99999999I', '33333333D', NULL),
(33, '11111111B', '22222222C', NULL),
(34, '44444444E', '11111111C', NULL),
(35, '77777777H', '99999999A', NULL),
(36, '22222222D', '77777777I', NULL),
(37, '99999999B', '33333333F', NULL),
(38, '11111111D', '22222222E', NULL),
(39, '44444444G', '11111111E', NULL),
(40, '77777777A', '99999999C', NULL),
(41, '22222222F', '55555555I', NULL),
(42, '33333333G', '44444444H', NULL),
(43, '66666666A', '22222222G', NULL),
(44, '77777777B', '11111111F', NULL),
(45, '33333333H', '66666666B', NULL),
(46, '44444444I', '55555555A', NULL),
(47, '77777777C', '33333333I', NULL),
(48, '11111111G', '22222222H', NULL),
(49, '44444444A', '77777777D', NULL),
(50, '55555555B', '66666666C', NULL),
(51, '11111111A', '88888888H', NULL),
(52, '55555555E', '66666666F', NULL),
(53, '11111111H', '44444444B', NULL),
(54, '22222222I', '33333333A', NULL),
(55, '11111111I', '44444444C', NULL),
(56, '22222222A', '33333333B', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Parejas_Categoria`
--

CREATE TABLE `Parejas_Categoria` (
  `idPareja` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `idCampeonato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Parejas_Categoria`
--

INSERT INTO `Parejas_Categoria` (`idPareja`, `idCategoria`, `idCampeonato`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 1, 1),
(4, 1, 1),
(5, 1, 1),
(6, 1, 1),
(7, 1, 1),
(8, 1, 1),
(9, 1, 1),
(10, 1, 1),
(11, 1, 1),
(12, 1, 1),
(13, 1, 1),
(14, 1, 1),
(15, 1, 1),
(16, 1, 1),
(17, 1, 1),
(19, 1, 1),
(20, 1, 1),
(21, 1, 1),
(22, 1, 1),
(23, 1, 1),
(28, 1, 1),
(24, 2, 1),
(25, 2, 1),
(26, 2, 1),
(27, 2, 1),
(29, 2, 1),
(30, 4, 2),
(31, 4, 2),
(32, 4, 2),
(33, 4, 2),
(34, 4, 2),
(35, 4, 2),
(36, 4, 2),
(37, 4, 2),
(38, 4, 2),
(39, 4, 2),
(40, 4, 2),
(41, 4, 2),
(42, 4, 2),
(43, 4, 2),
(44, 4, 2),
(45, 4, 2),
(46, 4, 2),
(47, 4, 2),
(48, 4, 2),
(49, 4, 2),
(50, 4, 2),
(51, 5, 2),
(52, 5, 2),
(53, 5, 2),
(54, 5, 2),
(55, 5, 2),
(56, 5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Parejas_Grupo`
--

CREATE TABLE `Parejas_Grupo` (
  `idGrupo` int(11) NOT NULL,
  `idPareja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Parejas_Grupo`
--

INSERT INTO `Parejas_Grupo` (`idGrupo`, `idPareja`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(3, 24),
(3, 25),
(3, 26),
(3, 27),
(3, 29);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Partido`
--

CREATE TABLE `Partido` (
  `idPartido` int(11) NOT NULL,
  `horario` datetime NOT NULL,
  `idPista` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Partido`
--

INSERT INTO `Partido` (`idPartido`, `horario`, `idPista`) VALUES
(1, '2018-10-01 11:00:00', 1),
(2, '2018-10-01 12:30:00', 1),
(3, '2018-10-01 14:00:00', 1),
(4, '2018-10-01 15:30:00', 1),
(5, '2018-10-02 09:30:00', 1),
(6, '2018-10-02 11:00:00', 1),
(7, '2018-10-02 14:00:00', 1),
(8, '2018-10-03 14:00:00', 1),
(9, '2018-10-03 15:30:00', 1),
(10, '2018-10-05 14:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pista`
--

CREATE TABLE `Pista` (
  `idPista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Pista`
--

INSERT INTO `Pista` (`idPista`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario_Registrado`
--

CREATE TABLE `Usuario_Registrado` (
  `userId` varchar(20) NOT NULL,
  `password` varchar(25) NOT NULL,
  `nombreCompleto` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Usuario_Registrado`
--

INSERT INTO `Usuario_Registrado` (`userId`, `password`, `nombreCompleto`, `email`) VALUES
('11111111A', 'avazquez', 'Antía Vázquez Fernández', 'avazquezf@gmail.com'),
('11111111B', 'rperez1', 'Rodrigo Pérez Salgado', 'rp1@gmail.com'),
('11111111C', 'jvazquez', 'Jose Vazquez Lorenzo', 'jvl@gmail.com'),
('11111111D', 'jlorenzo', 'Juan Lorenzo Vazquez', 'jlv@gmail.com'),
('11111111E', 'smarino', 'Santiago Marino Azul', 'sma@gmail.com'),
('11111111F', 'pcachamoeira', 'Pepe Cachamoeira Martinez', 'pcm@gmail.com'),
('11111111G', 'mvazquez', 'Manuel Vazquez Gomez', 'mvg@gmail.com'),
('11111111H', 'avazquez', 'Antía Vázquez Fernández', 'auezf@gmail.com'),
('11111111I', 'mhermoso', 'Maria Hermoso Gonzalez', 'mhg@gmail.com'),
('22222222A', 'pcid', 'Pilar Cid Fernandez', 'pcf@gmail.com'),
('22222222B', 'dperez', 'Diego Pérez Solla', 'dperez@gmail.com'),
('22222222C', 'asousa', 'Alvaro Sousa Justo', 'asj@gmail.com'),
('22222222D', 'mtorres', 'Martin Torres Camba', 'mtc@gmail.com'),
('22222222E', 'ablanco', 'Adrian Blanco Vieira', 'abv@gmail.com'),
('22222222F', 'dvazquez', 'Diego Vazquez Losada', 'dvl@gmail.com'),
('22222222G', 'dsaiz', 'Daniel Saiz Sanchez', 'dss@gmail.com'),
('22222222H', 'xcosme', 'Xabier Cosme Perez', 'xcp@gmail.com'),
('22222222I', 'mpena', 'Maria Pena Dominguez', 'mpd@gmail.com'),
('33333333A', 'mdfernandez', 'María Dolores Fernández Corbillón', 'me@hotmail.com'),
('33333333B', 'mvv', 'Maria del Carmen Vazquez Vazquez', 'mvv@hotmail.com'),
('33333333C', 'icid', 'Iván Cid Fernández', 'icid@gmail.com'),
('33333333D', 'ciglesias', 'Cristian Iglesias Gonzalez', 'cig@gmail.com'),
('33333333E', 'acortes', 'Abel Cortes Perez', 'acp@gmail.com'),
('33333333F', 'jpacreu', 'Josep Pacreu Terradas', 'jpt@gmail.com'),
('33333333G', 'jbenito', 'Jacobo Benito Ferreiro', 'jbf@gmail.com'),
('33333333H', 'mgarcia', 'Marcos Garcia Rodriguez', 'mgr@gmail.com'),
('33333333I', 'mascaballero', 'Miguel Angel Caballero Santos', 'mcs@gmail.com'),
('44444444A', 'dguerra', 'David Guerra Trujillo', 'dgt@gmail.com'),
('44444444B', 'pcorbillon', 'Pilar Corbillón Fernández', 'po@gmail.com'),
('44444444C', 'cvazquez', 'Concepción Vazquez Gonzalez', 'cvg@gmail.com'),
('44444444D', 'jmvazquez', 'José Manuel Vázquez Vázquez', 'jmvazquez@gmail.com'),
('44444444E', 'msanchez', 'Manuel Sanchez Samoano', 'mss@gmail.com'),
('44444444F', 'aeriz', 'Alberto Eiriz Garcia', 'aeg@gmail.com'),
('44444444G', 'agomez', 'Alberto Gomez Vazquez', 'agv@gmail.com'),
('44444444H', 'ocabrera', 'Octavio Cabrera Monzon', 'ocm@gmail.com'),
('44444444I', 'jlotero', 'José Luis Otero Bastida', 'job@gmail.com'),
('55555555A', 'aiglesias', 'Alberto Iglesias López', 'xf@gmail.com'),
('55555555B', 'dmallou', 'Diego Mallou Cea', 'dmc@gmail.com'),
('55555555E', 'lsouto', 'Lara Souto Alonso', 'lsouto@gmail.com'),
('55555555F', 'usouto', 'Uxia Souto Alonso', 'usa@gmail.com'),
('55555555G', 'mealonso', 'Maria Elena Alonso Barral', 'mab@gmail.com'),
('55555555H', 'cgrande', 'Clotilde Grande Fernandez', 'cgf@gmail.com'),
('55555555I', 'cnoguerol', 'Carlos Noguerol Barrenechea', 'cnb@gmail.com'),
('66666666A', 'dlopez', 'Diego López Vázquez', 'zx@hotmail.com'),
('66666666B', 'ggomez', 'Guzman Gomez Vicente', 'ggv@hotmail.com'),
('66666666C', 'dfernandez', 'Daniel Fernandez Stefanuto', 'dfs@hotmail.com'),
('66666666F', 'mperez', 'Marta Perez Pena', 'mpp@hotmail.com'),
('66666666G', 'asantos', 'Alicia Santos Sanchez', 'ass@hotmail.com'),
('66666666H', 'amontero', 'Almudena Montero Montero', 'amm@hotmail.com'),
('66666666I', 'tgomez', 'Teresa Gomez Gonzales', 'tgg@hotmail.com'),
('77777777A', 'mvazquez', 'Marcos Vázquez Fernández', 'mvaz@gmail.com'),
('77777777B', 'mgranados', 'Miguel Garcia Granados', 'mgg@gmail.com'),
('77777777C', 'agarcia', 'Anton Garcia Rodriguez', 'agr@gmail.com'),
('77777777D', 'rpolanco', 'Roberto Polanco Nuñez', 'rpn@gmail.com'),
('77777777G', 'ifernandez', 'Ismael Fernandez Santos', 'ifs@gmail.com'),
('77777777H', 'freyes', 'Felipe Reyes Gonzalez', 'frg@gmail.com'),
('77777777I', 'sllull', 'Sergio Llull Monzon', 'slm@gmail.com'),
('88888888A', 'dsalgado', 'Delfina Salgado Crende', 'dsc@gmail.com'),
('88888888B', 'jgrande', 'Josefa Grande Menor', 'jgm@gmail.com'),
('88888888H', 'isantos', 'Irene Santos Santos', 'iss@gmail.com'),
('88888888I', 'squijano', 'Sabela Quijano Jordan', 'sqj.com'),
('99999999A', 'rperez', 'Roi Pérez López', 'rpe@gmail.com'),
('99999999B', 'rpernas', 'Ruben Pernas Rega', 'rpr@gmail.com'),
('99999999C', 'jasouto', 'Jose Antonio Souto Puga', 'jsp@gmail.com'),
('99999999I', 'gpuga', 'Gerardo Puga Barral', 'gpb@gmail.com');


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Administrador`
--
ALTER TABLE `Administrador`
  ADD PRIMARY KEY (`userId`);

--
-- Indices de la tabla `Calendario`
--
ALTER TABLE `Calendario`
  ADD PRIMARY KEY (`idPista`,`FechaHoraInicio`),
  ADD KEY `fk_userId_Calendario` (`userId`);

--
-- Indices de la tabla `Campeonato`
--
ALTER TABLE `Campeonato`
  ADD PRIMARY KEY (`idCampeonato`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `Categoria`
--
ALTER TABLE `Categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `Categorias_Campeonato`
--
ALTER TABLE `Categorias_Campeonato`
  ADD PRIMARY KEY (`idCampeonato`,`idCategoria`),
  ADD KEY `fk_idCategoria` (`idCategoria`);

--
-- Indices de la tabla `Deportista`
--
ALTER TABLE `Deportista`
  ADD PRIMARY KEY (`userId`);

--
-- Indices de la tabla `Deportistas_Partido`
--
ALTER TABLE `Deportistas_Partido`
  ADD PRIMARY KEY (`idPartido`,`userId`),
  ADD KEY `userId_idx` (`userId`);

--
-- Indices de la tabla `Enfrentamiento`
--
ALTER TABLE `Enfrentamiento`
  ADD PRIMARY KEY (`idEnfrentamiento`),
  ADD KEY `idGrupo_idx` (`idGrupo`),
  ADD KEY `idPista_idx` (`idPista`),
  ADD KEY `idPareja_idx` (`idPareja1`,`idPareja2`),
  ADD KEY `fk_idPareja2_Enfrentamiento` (`idPareja2`),
  ADD KEY `fk_idGrupo_Enfrentamiento` (`idGrupo`);

--
-- Indices de la tabla `Grupo`
--
ALTER TABLE `Grupo`
  ADD PRIMARY KEY (`idGrupo`),
  ADD KEY `fk_idampeonato_idCategoriaGrupo` (`idCampeonato`,`idCategoria`);

--
-- Indices de la tabla `Pareja`
--
ALTER TABLE `Pareja`
  ADD PRIMARY KEY (`idPareja`),
  ADD KEY `fk_capitan_Pareja` (`capitan`),
  ADD KEY `fk_par_Pareja` (`par`),
  ADD KEY `fk_idGrupo_Pareja` (`idGrupo`);

--
-- Indices de la tabla `Parejas_Categoria`
--
ALTER TABLE `Parejas_Categoria`
  ADD PRIMARY KEY (`idPareja`,`idCategoria`),
  ADD UNIQUE KEY `idPareja_UNIQUE` (`idPareja`),
  ADD KEY `idCategoria_idx` (`idCategoria`),
  ADD KEY `fk_idCampeonato_idCategoria_Parejas_Categoria` (`idCampeonato`,`idCategoria`);

--
-- Indices de la tabla `Parejas_Grupo`
--
ALTER TABLE `Parejas_Grupo`
  ADD PRIMARY KEY (`idGrupo`,`idPareja`),
  ADD UNIQUE KEY `idPareja_UNIQUE` (`idPareja`),
  ADD KEY `idGrupo_idx` (`idGrupo`);

--
-- Indices de la tabla `Partido`
--
ALTER TABLE `Partido`
  ADD PRIMARY KEY (`idPartido`),
  ADD KEY `horario_idx` (`horario`);

--
-- Indices de la tabla `Pista`
--
ALTER TABLE `Pista`
  ADD PRIMARY KEY (`idPista`);

--
-- Indices de la tabla `Usuario_Registrado`
--
ALTER TABLE `Usuario_Registrado`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Campeonato`
--
ALTER TABLE `Campeonato`
  MODIFY `idCampeonato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `Enfrentamiento`
--
ALTER TABLE `Enfrentamiento`
  MODIFY `idEnfrentamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `Grupo`
--
ALTER TABLE `Grupo`
  MODIFY `idGrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Pareja`
--
ALTER TABLE `Pareja`
  MODIFY `idPareja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `Partido`
--
ALTER TABLE `Partido`
  MODIFY `idPartido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Administrador`
--
ALTER TABLE `Administrador`
  ADD CONSTRAINT `userId` FOREIGN KEY (`userId`) REFERENCES `Usuario_Registrado` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Calendario`
--
ALTER TABLE `Calendario`
  ADD CONSTRAINT `fk_idPista_Calendario` FOREIGN KEY (`idPista`) REFERENCES `Pista` (`idPista`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId_Calendario` FOREIGN KEY (`userId`) REFERENCES `Deportista` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Categorias_Campeonato`
--
ALTER TABLE `Categorias_Campeonato`
  ADD CONSTRAINT `fk_idCampeonato` FOREIGN KEY (`idCampeonato`) REFERENCES `Campeonato` (`idCampeonato`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idCategoria` FOREIGN KEY (`idCategoria`) REFERENCES `Categoria` (`idCategoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Deportista`
--
ALTER TABLE `Deportista`
  ADD CONSTRAINT `fk_userId_Deportista` FOREIGN KEY (`userId`) REFERENCES `Usuario_Registrado` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Deportistas_Partido`
--
ALTER TABLE `Deportistas_Partido`
  ADD CONSTRAINT `fk_idPartido_Deportistas_Partido` FOREIGN KEY (`idPartido`) REFERENCES `Partido` (`idPartido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId_Deportistas_Partido` FOREIGN KEY (`userId`) REFERENCES `Deportista` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Enfrentamiento`
--
ALTER TABLE `Enfrentamiento`
  ADD CONSTRAINT `fk_idGrupo_Enfrentamiento` FOREIGN KEY (`idGrupo`) REFERENCES `Grupo` (`idGrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idPareja1_Enfrentamiento` FOREIGN KEY (`idPareja1`) REFERENCES `Parejas_Grupo` (`idPareja`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idPareja2_Enfrentamiento` FOREIGN KEY (`idPareja2`) REFERENCES `Parejas_Grupo` (`idPareja`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idPista_Enfrentamiento` FOREIGN KEY (`idPista`) REFERENCES `Pista` (`idPista`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Grupo`
--
ALTER TABLE `Grupo`
  ADD CONSTRAINT `fk_idampeonato_idCategoriaGrupo` FOREIGN KEY (`idCampeonato`,`idCategoria`) REFERENCES `Categorias_Campeonato` (`idCampeonato`, `idCategoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Pareja`
--
ALTER TABLE `Pareja`
  ADD CONSTRAINT `fk_capitan_Pareja` FOREIGN KEY (`capitan`) REFERENCES `Deportista` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idGrupo_Pareja` FOREIGN KEY (`idGrupo`) REFERENCES `Grupo` (`idGrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_par_Pareja` FOREIGN KEY (`par`) REFERENCES `Deportista` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Parejas_Categoria`
--
ALTER TABLE `Parejas_Categoria`
  ADD CONSTRAINT `fk_idCampeonato_idCategoria_Parejas_Categoria` FOREIGN KEY (`idCampeonato`,`idCategoria`) REFERENCES `Categorias_Campeonato` (`idCampeonato`, `idCategoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idPareja_Parejas_Categoria` FOREIGN KEY (`idPareja`) REFERENCES `Pareja` (`idPareja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Parejas_Grupo`
--
ALTER TABLE `Parejas_Grupo`
  ADD CONSTRAINT `fk_idGrupo_Parejas_Grupo` FOREIGN KEY (`idGrupo`) REFERENCES `Grupo` (`idGrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idPareja_Parejas_Grupo` FOREIGN KEY (`idPareja`) REFERENCES `Pareja` (`idPareja`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
