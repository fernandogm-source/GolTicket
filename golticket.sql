-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 01-06-2026 a las 15:44:18
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
(1, 'Madrid', 'view/img/ciudad/madrid.png'),
(2, 'Barcelona', 'view/img/ciudad/barcelona.png'),
(3, 'Almeria', 'view/img/ciudad/almeria.png'),
(4, 'Manchester', 'view/img/ciudad/manchester.png'),
(5, 'Castellon', 'view/img/ciudad/castellon.png');

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
-- Estructura de tabla para la tabla `config_filters`
--

DROP TABLE IF EXISTS `config_filters`;
CREATE TABLE IF NOT EXISTS `config_filters` (
  `id_filter` int NOT NULL AUTO_INCREMENT,
  `display_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `db_column` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `html_type` enum('select','radio','check','slider') COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_table` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `join_label` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `join_fk2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_filter`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `config_filters`
--

INSERT INTO `config_filters` (`id_filter`, `display_name`, `db_column`, `html_type`, `join_table`, `join_label`, `join_fk2`) VALUES
(1, 'Ciudad', 'nombre_ciudad', 'radio', 'ciudad', 'id_ciudad', NULL),
(2, 'Competición', 'nombre_competicion', 'radio', 'competicion', 'id_competicion', NULL),
(3, 'Equipo', 'nombre_equipo', 'check', 'equipo', 'id_equipolocal', 'id_equipovisitante'),
(4, 'Precio', 'precio', 'slider', NULL, NULL, NULL);

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
-- Estructura de tabla para la tabla `extra`
--

DROP TABLE IF EXISTS `extra`;
CREATE TABLE IF NOT EXISTS `extra` (
  `id_extra` int NOT NULL AUTO_INCREMENT,
  `nombre_extra` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_extra` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_extra`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `extra`
--

INSERT INTO `extra` (`id_extra`, `nombre_extra`, `img_extra`) VALUES
(1, 'WI-FI', 'view/logo/wifi.png'),
(2, 'Baños', 'view/logo/baño.png'),
(3, 'Parada de Autobus', 'view/logo/bus.png'),
(4, 'Asistencia médica', 'view/logo/medico.png'),
(5, 'Parking', 'view/logo/parking.png'),
(6, 'Restaurante', 'view/logo/restaurante.png'),
(7, 'Acceso para silla de ruedas', 'view/logo/sillaruedas.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `img_partido`
--

DROP TABLE IF EXISTS `img_partido`;
CREATE TABLE IF NOT EXISTS `img_partido` (
  `id_img_partido` int NOT NULL AUTO_INCREMENT,
  `id_partido` int DEFAULT NULL,
  `img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_img_partido`),
  KEY `id_partido` (`id_partido`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `img_partido`
--

INSERT INTO `img_partido` (`id_img_partido`, `id_partido`, `img`) VALUES
(1, 1, 'view/img/partido/partido1_1.png'),
(2, 1, 'view/img/partido/partido1_2.png'),
(3, 2, 'view/img/partido/partido2_2.png'),
(4, 2, 'view/img/partido/partido2_1.png'),
(5, 3, 'view/img/partido/partido3_2.png'),
(6, 3, 'view/img/partido/partido3_1.png'),
(7, 4, 'view/img/partido/partido4_2.png'),
(8, 4, 'view/img/partido/partido4_1.png'),
(9, 5, 'view/img/partido/partido5_1.png'),
(10, 5, 'view/img/partido/partido5_2.png'),
(11, 6, 'view/img/partido/partido6_1.png'),
(12, 6, 'view/img/partido/partido6_2.png'),
(13, 7, 'view/img/partido/partido7_1.png'),
(14, 7, 'view/img/partido/partido7_2.png'),
(15, 8, 'view/img/partido/partido8_1.png'),
(16, 8, 'view/img/partido/partido8_2.png'),
(17, 9, 'view/img/partido/partido9_1.png'),
(18, 9, 'view/img/partido/partido9_2.png'),
(19, 10, 'view/img/partido/partido10_1.png'),
(20, 10, 'view/img/partido/partido10_2.png'),
(21, 11, 'view/img/partido/partido11_1.png'),
(22, 11, 'view/img/partido/partido11_2.png'),
(23, 12, 'view/img/partido/partido12_1.png'),
(24, 12, 'view/img/partido/partido12_2.png'),
(25, 13, 'view/img/partido/partido13_1.png'),
(26, 13, 'view/img/partido/partido13_2.png'),
(27, 14, 'view/img/partido/partido14_1.png'),
(28, 14, 'view/img/partido/partido14_2.png'),
(29, 15, 'view/img/partido/partido15_1.png'),
(30, 15, 'view/img/partido/partido15_2.png'),
(31, 16, 'view/img/partido/partido16_1.png'),
(32, 16, 'view/img/partido/partido16_2.png'),
(33, 17, 'view/img/partido/partido17_1.png'),
(34, 17, 'view/img/partido/partido17_2.png'),
(35, 18, 'view/img/partido/partido18_1.png'),
(36, 18, 'view/img/partido/partido18_2.png'),
(37, 19, 'view/img/partido/partido19_1.png'),
(38, 19, 'view/img/partido/partido19_2.png'),
(39, 20, 'view/img/partido/partido20_1.png'),
(40, 20, 'view/img/partido/partido20_2.png'),
(41, 21, 'view/img/partido/partido21_1.png'),
(42, 21, 'view/img/partido/partido21_2.png'),
(43, 22, 'view/img/partido/partido22_1.png'),
(44, 22, 'view/img/partido/partido22_2.png'),
(45, 23, 'view/img/partido/partido23_1.png'),
(46, 23, 'view/img/partido/partido23_2.png'),
(47, 24, 'view/img/partido/partido24_1.png'),
(48, 24, 'view/img/partido/partido24_2.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes_usuario`
--

DROP TABLE IF EXISTS `likes_usuario`;
CREATE TABLE IF NOT EXISTS `likes_usuario` (
  `id_like` int NOT NULL AUTO_INCREMENT,
  `id_partido` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_like`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `precio` int DEFAULT NULL,
  `id_ciudad` int DEFAULT NULL,
  `lat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visitas` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_partido`),
  KEY `fk_partido_local` (`id_equipolocal`),
  KEY `fk_partido_visitante` (`id_equipovisitante`),
  KEY `fk_partido_campo` (`id_campo`),
  KEY `fk_partido_comp` (`id_competicion`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `partido`
--

INSERT INTO `partido` (`id_partido`, `nombre_partido`, `fecha_partido`, `id_equipolocal`, `id_equipovisitante`, `id_campo`, `id_competicion`, `precio`, `id_ciudad`, `lat`, `lng`, `visitas`) VALUES
(1, 'Real Madrid vs Barcelona', '10-05-2026', 1, 2, 1, 1, 120, 1, '40.4530', '-3.6884', '5'),
(2, 'Manchester City vs Real Madrid', '18-04-2026', 4, 1, 4, 2, 100, 4, '53.4832', '-2.2004', '1'),
(3, 'Almeria vs Castellon', '22-07-2026', 5, 3, 3, 3, 15, 3, '36.8400', '-2.4354', '1'),
(4, 'Barcelona vs Castellon', '15-05-2026', 2, 3, 2, 4, 25, 2, '41.3809', '2.1228', '2'),
(5, 'Real Madrid vs Manchester City', '20-05-2026', 1, 4, 1, 2, 130, 1, '40.4530', '-3.6884', '1'),
(6, 'Barcelona vs Real Madrid', '28-05-2026', 2, 1, 2, 1, 95, 2, '41.3809', '2.1228', '41'),
(7, 'Castellon vs Almeria', '05-06-2026', 3, 5, 5, 3, 18, 5, '39.9864', '-0.0513', '20'),
(8, 'Almeria vs Barcelona', '12-06-2026', 5, 2, 3, 4, 30, 3, '36.8400', '-2.4354', '12'),
(9, 'Manchester City vs Barcelona', '19-06-2026', 4, 2, 4, 2, 110, 4, '53.4832', '-2.2004', '1'),
(10, 'Real Madrid vs Almeria', '25-06-2026', 1, 5, 1, 1, 85, 1, '40.4530', '-3.6884', '1'),
(11, 'Barcelona vs Manchester City', '02-07-2026', 2, 4, 2, 2, 120, 2, '41.3809', '2.1228', '1'),
(12, 'Castellon vs Real Madrid', '08-07-2026', 3, 1, 5, 3, 20, 5, '39.9864', '-0.0513', '1'),
(13, 'Almeria vs Manchester City', '15-07-2026', 5, 4, 3, 2, 40, 3, '36.8400', '-2.4354', '0'),
(14, 'Real Madrid vs Castellon', '22-07-2026', 1, 3, 1, 4, 75, 1, '40.4530', '-3.6884', '0'),
(15, 'Barcelona vs Almeria', '29-07-2026', 2, 5, 2, 1, 60, 2, '41.3809', '2.1228', '0'),
(16, 'Manchester City vs Castellon', '05-08-2026', 4, 3, 4, 2, 105, 4, '53.4832', '-2.2004', '0'),
(17, 'Almeria vs Real Madrid', '12-08-2026', 5, 1, 3, 1, 35, 3, '36.8400', '-2.4354', '0'),
(18, 'Castellon vs Barcelona', '19-08-2026', 3, 2, 5, 4, 22, 5, '39.9864', '-0.0513', '0'),
(19, 'Manchester City vs Almeria', '26-08-2026', 4, 5, 4, 1, 100, 4, '53.4832', '-2.2004', '0'),
(20, 'Real Madrid vs Barcelona', '02-09-2026', 1, 2, 1, 2, 140, 1, '40.4530', '-3.6884', '0'),
(21, 'Barcelona vs Castellon', '09-09-2026', 2, 3, 2, 3, 50, 2, '41.3809', '2.1228', '0'),
(22, 'Almeria vs Castellon', '16-09-2026', 5, 3, 3, 3, 18, 3, '36.8400', '-2.4354', '0'),
(23, 'Castellon vs Manchester City', '23-09-2026', 3, 4, 5, 2, 25, 5, '39.9864', '-0.0513', '0'),
(24, 'Barcelona vs Real Madrid', '30-09-2026', 2, 1, 2, 4, 115, 2, '41.3809', '2.1228', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido_extra`
--

DROP TABLE IF EXISTS `partido_extra`;
CREATE TABLE IF NOT EXISTS `partido_extra` (
  `id_partido_extra` int NOT NULL AUTO_INCREMENT,
  `id_partido` int DEFAULT NULL,
  `id_extra` int DEFAULT NULL,
  PRIMARY KEY (`id_partido_extra`),
  KEY `id_partido` (`id_partido`),
  KEY `id_extra` (`id_extra`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `partido_extra`
--

INSERT INTO `partido_extra` (`id_partido_extra`, `id_partido`, `id_extra`) VALUES
(1, 1, 3),
(2, 1, 4),
(3, 1, 6),
(4, 2, 1),
(5, 2, 2),
(6, 2, 7),
(7, 3, 1),
(8, 3, 5),
(9, 3, 2),
(10, 4, 6),
(11, 4, 7),
(12, 4, 4),
(13, 5, 1),
(14, 5, 2),
(15, 5, 5),
(16, 6, 3),
(17, 6, 4),
(18, 6, 6),
(19, 7, 1),
(20, 7, 2),
(21, 7, 7),
(22, 8, 3),
(23, 8, 5),
(24, 8, 6),
(25, 9, 1),
(26, 9, 4),
(27, 9, 7),
(28, 10, 2),
(29, 10, 3),
(30, 10, 5),
(31, 11, 1),
(32, 11, 6),
(33, 11, 7),
(34, 12, 2),
(35, 12, 4),
(36, 12, 5),
(37, 13, 1),
(38, 13, 3),
(39, 13, 6),
(40, 14, 2),
(41, 14, 5),
(42, 14, 7),
(43, 15, 1),
(44, 15, 3),
(45, 15, 4),
(46, 16, 2),
(47, 16, 6),
(48, 16, 7),
(49, 17, 1),
(50, 17, 4),
(51, 17, 5),
(52, 18, 3),
(53, 18, 6),
(54, 18, 7),
(55, 19, 1),
(56, 19, 2),
(57, 19, 5),
(58, 20, 3),
(59, 20, 4),
(60, 20, 6),
(61, 21, 1),
(62, 21, 5),
(63, 21, 7),
(64, 22, 2),
(65, 22, 3),
(66, 22, 6),
(67, 23, 1),
(68, 23, 4),
(69, 23, 7),
(70, 24, 2),
(71, 24, 5),
(72, 24, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('client','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  `avatar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_usuario`, `username`, `password`, `mail`, `role`, `avatar`) VALUES
(1, 'ipjognkwjeqoiepdkm', '$argon2id$v=19$m=65536,t=4,p=2$VFVnUG1KaERyRTJ0Vk40WA$cuykwWD40RM0+OLlf+aSezwf86XHxzEogStQA6T/QBU', 'hola@gmail.com', 'client', 'https://robohash.org/9ac39ecec1ea38ff56c386f8d3591c9f73267bb808a3f5e8fd5819389d3d7e4c'),
(2, 'iohuibkjnoi2', '$argon2id$v=19$m=65536,t=4,p=2$cEc1dHRBTDZqdFJVZVduTw$1GkJmO5aNAKMxP9IwmGAsP4qnIAU9j/BPOCdAl428ao', 'oukh@gmail.com', 'client', 'https://robohash.org/5849b1f2a7150160227966b5706b392a4e4cbcc8c80b8ca86c40a6ae79cb5bfa'),
(3, 'pijofamkdw', '$argon2id$v=19$m=65536,t=4,p=2$REdtQm80T3FqcmF1dWNGVw$0RdsNQpe/vdnZNMwIV5pMKEbYXIOAUWxWymkhHBOGrE', 'retgdbjn@gmail.com', 'client', 'https://robohash.org/931c8d350027e4ad5be71d8f86dcbe004a67bdb7dcb4da75842845ec49a6b546'),
(4, 'iojbksnalkw', '$argon2id$v=19$m=65536,t=4,p=2$VDJmd1lLWkFQUEhoSktybQ$DP/UVqzwqZ3Uqb0bIP8PrbSqwEhvBOFjFbyPj/8iJiU', 'etdgfnvb@gmail.com', 'client', 'https://robohash.org/226e0102d08d97469bba50f026a0670095d0bee154703e5ed274bd9e6119595f'),
(5, 'iohuhbkzjld', '$argon2id$v=19$m=65536,t=4,p=2$T2tpWWpnSzBDQXlxTVNTeQ$8QCwfTevVRLJzNFj758lID5AJOx81QfkZk27yHB7d8o', 'jiohugjbkj@gmail.com', 'client', 'https://robohash.org/96ee5658666692ac59fc779957365b00b64393ef8c77616075aee6ae2e113735'),
(6, 'asdqewrftgbv', '$argon2id$v=19$m=65536,t=4,p=2$dTVicFd6VVR4YVpaTjV2cA$O1sp4A9/qHLgIS06Mr7C3tj2vmUDHnfc22kfjxftqyA', 'eqdfsvsefe@gmail.com', 'client', 'https://robohash.org/faab9fc02517a61be0562e2ea1efb3fde8808509f6080ec37ceaf96f8a71a7dd'),
(7, 'iejouifhbj', '$argon2id$v=19$m=65536,t=4,p=2$Z0JHSDg0WWxyWEE0cVJsMQ$DIK75t58jGUhNsWsjJtTpx1UzZhdWcQXuBlsZU3U81w', 'hola3@gmail.com', 'client', 'https://robohash.org/4c167a23fd8c01b65339328076cf43c809f78f4d68ed26d9d8ab23b137dd77ec'),
(8, 'qiejowfpqokedm', '$argon2id$v=19$m=65536,t=4,p=2$bS9xOURsNTg0anIuUmprZw$/IVdrUzUK5HMYljxDmTVqo5Doym6HZXczv0g2v8DCtg', 'hola4@gmail.com', 'client', 'https://robohash.org/b853ab3cc5187eff3c0019269d4bc90a2274829b029dbe2b54e231e08e5d9fe1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
