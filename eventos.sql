-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-02-2026 a las 12:28:53
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
-- Base de datos: `goltickets`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

DROP TABLE IF EXISTS `eventos`;
CREATE TABLE IF NOT EXISTS `eventos` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `event_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_organization` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_hour` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_release_date` date DEFAULT (curdate()),
  `event_place` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_duration` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_capacity` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_price` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_disponibility` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_services` json DEFAULT NULL,
  `event_img` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_local` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_visitor` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_type` json DEFAULT NULL,
  `event_competition` enum('laliga','laliga2','copa_del_rey','champions_league') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'laliga',
  `event_state` enum('programado','en_venta','agotado','cancelado','finalizado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'programado',
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`event_id`, `event_name`, `event_description`, `event_organization`, `event_date`, `event_hour`, `event_release_date`, `event_place`, `event_city`, `event_duration`, `event_capacity`, `event_price`, `event_disponibility`, `event_services`, `event_img`, `event_local`, `event_visitor`, `ticket_type`, `event_competition`, `event_state`) VALUES
(1, 'Real Madrid vs Barcelona', 'El Clásico de España, partido de máxima rivalidad.', 'LaLiga', '15/03/2025', '21:00', '2025-01-10', 'Santiago Bernabéu', 'Madrid', '120', '81044', '95', '15000', '[\"parking\", \"taquillas\", \"acceso a tienda de merchandising\"]', 'clasico.jpg', 'Real Madrid', 'Barcelona', '[\"general\", \"vip\", \"premium\", \"palco\"]', 'laliga', 'en_venta'),
(2, 'Valencia vs Sevilla', 'Partido clave por puestos europeos.', 'LaLiga', '02/04/2025', '18:30', '2025-02-01', 'Mestalla', 'Valencia', '110', '49000', '45', '12000', '[\"parking\", \"taquillas\"]', 'valencia_sevilla.jpg', 'Valencia CF', 'Sevilla FC', '[\"general\", \"grada\", \"vip\"]', 'laliga', 'en_venta'),
(3, 'Levante vs Eibar', 'Duelo directo por el ascenso.', 'LaLiga2', '20/02/2025', '20:45', '2025-01-05', 'Ciutat de València', 'Valencia', '105', '26000', '25', '8000', '[\"taquillas\", \"acceso a tienda de merchandising\"]', 'levante_eibar.jpg', 'Levante UD', 'SD Eibar', '[\"general\", \"grada\"]', 'laliga2', 'programado'),
(4, 'Athletic Club vs Real Sociedad', 'Derbi vasco en eliminatoria de Copa del Rey.', 'RFEF', '28/01/2025', '22:00', '2024-12-20', 'San Mamés', 'Bilbao', '120', '53000', '60', '9000', '[\"parking\", \"taquillas\"]', 'derbi_vasco.jpg', 'Athletic Club', 'Real Sociedad', '[\"vip\", \"premium\", \"palco\"]', 'copa_del_rey', 'en_venta'),
(5, 'Atlético de Madrid vs Bayern Múnich', 'Partido de Champions League, fase de grupos.', 'UEFA', '03/10/2025', '20:00', '2025-08-15', 'Cívitas Metropolitano', 'Madrid', '120', '68000', '85', '14000', '[\"parking\", \"acceso a tienda de merchandising\"]', 'atleti_bayern.jpg', 'Atlético de Madrid', 'Bayern Múnich', '[\"general\", \"vip\", \"premium\", \"palco\"]', 'champions_league', 'programado');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
