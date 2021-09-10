-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2021 a las 22:56:59
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jossyem1_tesis_embutido`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_final`
--

CREATE TABLE `prod_final` (
  `id_prod_final` int(11) NOT NULL,
  `cortes` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `peso` float NOT NULL,
  `fecha_ingreso` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `prod_final`
--

INSERT INTO `prod_final` (`id_prod_final`, `cortes`, `peso`, `fecha_ingreso`) VALUES
(1, 'utyutyu', 2, '2021-06-07 00:00:00'),
(2, 'utyutyu', 2, '2021-06-07 17:14:12'),
(3, 'Chuleta de chancho', 2, '2021-06-07 17:14:52');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `prod_final`
--
ALTER TABLE `prod_final`
  ADD PRIMARY KEY (`id_prod_final`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `prod_final`
--
ALTER TABLE `prod_final`
  MODIFY `id_prod_final` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
