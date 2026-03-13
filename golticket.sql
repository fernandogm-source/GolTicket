-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 12-03-2026 a las 15:40:06
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `golticket`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campo`
--

DROP TABLE IF EXISTS `campo`;
CREATE TABLE IF NOT EXISTS `campo` (
  `id_campo` int NOT NULL AUTO_INCREMENT,
  `nombre_campo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_campo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_equipo` int NOT NULL,
  `id_ciudad` int NOT NULL,
  PRIMARY KEY (`id_campo`),
  KEY `fk_campo_equipo` (`id_equipo`),
  KEY `fk_campo_ciudad` (`id_ciudad`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `campo`
--

INSERT INTO `campo` (`id_campo`, `nombre_campo`, `img_campo`, `id_equipo`, `id_ciudad`) VALUES
(1, 'Santiago Bernabeu', 'view/img/estadio/madrid.png', 1, 1),
(2, 'Spotify Camp Nou', 'view/img/estadio/barcelona.png', 2, 2),
(3, 'UD Almería Stadium', 'view/img/estadio/almeria.png', 5, 3),
(4, 'Etihad Stadium', 'view/img/estadio/manchestercity.png', 4, 4),
(5, 'SkyFi Castalia', 'view/img/estadio/castellon.png', 3, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

DROP TABLE IF EXISTS `ciudad`;
CREATE TABLE IF NOT EXISTS `ciudad` (
  `id_ciudad` int NOT NULL AUTO_INCREMENT,
  `nombre_ciudad` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_ciudad` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_ciudad`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id_ciudad`, `nombre_ciudad`, `img_ciudad`) VALUES
(1, 'madrid', 'view/img/ciudad/madrid.png'),
(2, 'barcelona', 'view/img/ciudad/barcelona.png'),
(3, 'almeria', 'view/img/ciudad/almeria.png'),
(4, 'manchester', 'view/img/ciudad/manchester.png'),
(5, 'castellon', 'view/img/ciudad/castellon.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competicion`
--

DROP TABLE IF EXISTS `competicion`;
CREATE TABLE IF NOT EXISTS `competicion` (
  `id_competicion` int NOT NULL AUTO_INCREMENT,
  `nombre_competicion` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_competicion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_competicion`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `competicion`
--

INSERT INTO `competicion` (`id_competicion`, `nombre_competicion`, `img_competicion`) VALUES
(1, 'LaLiga', 'view/img/competicion/laliga.png'),
(2, 'Champions League', 'view/img/competicion/champions.png'),
(3, 'LaLiga 2', 'view/img/competicion/laliga2.png'),
(4, 'Copa del Rey', 'view/img/competicion/copadelrey.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

DROP TABLE IF EXISTS `equipo`;
CREATE TABLE IF NOT EXISTS `equipo` (
  `id_equipo` int NOT NULL AUTO_INCREMENT,
  `nombre_equipo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siglas_equipo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_equipo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_equipo`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`id_equipo`, `nombre_equipo`, `siglas_equipo`, `img_equipo`) VALUES
(1, 'Real Madrid C.F.', 'RMA', 'view/img/equipo/madrid.png'),
(2, 'F.C. Barcelona', 'FCB', 'view/img/equipo/barcelona.png'),
(3, 'C.D. Castellón', 'CAS', 'view/img/equipo/castellon.png'),
(4, 'Manchester City F.C.', 'MCI', 'view/img/equipo/manchestercity.png'),
(5, 'U.D. Almeria', 'ALM', 'view/img/equipo/almeria.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido`
--

DROP TABLE IF EXISTS `partido`;
CREATE TABLE IF NOT EXISTS `partido` (
  `id_partido` int NOT NULL AUTO_INCREMENT,
  `nombre_partido` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_partido` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_equipolocal` int NOT NULL,
  `id_equipovisitante` int NOT NULL,
  `id_campo` int NOT NULL,
  `id_competicion` int NOT NULL,
  PRIMARY KEY (`id_partido`),
  KEY `fk_partido_local` (`id_equipolocal`),
  KEY `fk_partido_visitante` (`id_equipovisitante`),
  KEY `fk_partido_campo` (`id_campo`),
  KEY `fk_partido_comp` (`id_competicion`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `partido`
--

INSERT INTO `partido` (`id_partido`, `nombre_partido`, `fecha_partido`, `id_equipolocal`, `id_equipovisitante`, `id_campo`, `id_competicion`) VALUES
(1, 'Real Madrid vs Barcelona', '2026-05-10', 1, 2, 1, 1),
(2, 'Manchester City vs Real Madrid', '2026-04-18', 4, 1, 4, 2),
(3, 'Almeria vs Castellon', '2026-07-22', 5, 3, 3, 3),
(4, 'Barcelona vs Castellon', '2026-05-15', 2, 3, 2, 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
