-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-06-2014 a las 03:21:31
-- Versión del servidor: 5.5.34
-- Versión de PHP: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `empleado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `Nombre` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ApellidoPat` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ApellidoMat` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Matricula` varchar(8) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Puesto` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`Matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`Nombre`, `ApellidoPat`, `ApellidoMat`, `Matricula`, `Puesto`) VALUES
('Hugo', 'Martínez', 'Gutiérrez', '20202020', 'Programador PHP'),
('Araceli', 'Morales', 'González', '30303030', 'Ingeniera');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
