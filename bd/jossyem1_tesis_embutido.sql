-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2021 a las 23:25:26
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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`jossyem1`@`localhost` PROCEDURE `add_tempo_lista_receta` (IN `codigo` INT, IN `cantidad` INT, IN `nom_rec` VARCHAR(30), IN `token_user` VARCHAR(50))  BEGIN 
INSERT INTO tempo_lista_receta(token_user,id_cortes,cant,no_rece)
VALUES(token_user,codigo,cantidad,nom_rec); 
SELECT tmp.correlativo, tmp.id_cortes, tmp.cant, p.cortes, tmp.no_rece 
FROM tempo_lista_receta tmp 
INNER JOIN tipo_cortes p 
ON tmp.id_cortes = p.id_cortes 
where tmp.token_user = token_user; 
END$$

CREATE DEFINER=`jossyem1`@`localhost` PROCEDURE `del_tempo_lista_receta` (IN `id_detalle` INT, IN `token` VARCHAR(50))  BEGIN
DELETE FROM tempo_lista_receta WHERE correlativo = id_detalle COLLATE utf8_spanish_ci;

SELECT tmp.correlativo, tmp.token_user, tmp.id_cortes, tmp.cant, tmp.no_rece, p.cortes
FROM tempo_lista_receta tmp
 INNER JOIN tipo_cortes p
   ON tmp.id_cortes = p.id_cortes
   where tmp.token_user = token_user COLLATE utf8_spanish_ci;
   
   END$$

CREATE DEFINER=`jossyem1`@`localhost` PROCEDURE `procesar_lista` (IN `token` VARCHAR(50))  BEGIN 
INSERT INTO lista_receta(nom_rece,ingr_rece,cant_rece) SELECT no_rece,id_cortes,cant FROM tempo_lista_receta WHERE token_user = token COLLATE utf8_spanish_ci;
DELETE FROM tempo_lista_receta WHERE token_user= token COLLATE utf8_spanish_ci;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_receta`
--

CREATE TABLE `lista_receta` (
  `id_list_rece` int(11) NOT NULL,
  `nom_rece` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `ingr_rece` int(5) NOT NULL,
  `cant_rece` int(11) NOT NULL,
  `estado` int(5) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `lista_receta`
--

INSERT INTO `lista_receta` (`id_list_rece`, `nom_rece`, `ingr_rece`, `cant_rece`, `estado`) VALUES
(32, 'chorizon cuencano', 3, 213, 1),
(33, 'chorizon cuencano', 9, 123, 1),
(35, 'chorizon cuencano', 2, 13, 1),
(36, 'chorizon cuencano', 6, 53, 1),
(38, 'chorizon cervecero', 2, 421, 1),
(39, 'chorizon cervecero', 8, 321, 1),
(41, 'mortadela', 2, 256, 1),
(42, 'mortadela', 11, 156, 1),
(43, 'fgdg', 3, 45, 1),
(44, 'fgdg', 17, 12, 1),
(45, 'fgdg', 18, 78, 1),
(46, 'fgdg', 14, 123, 1),
(47, 'fgdg', 13, 19, 1),
(48, 'fgdg', 8, 25, 1),
(50, 'gg', 6, 1234, 1),
(51, 'gg', 11, 56, 1),
(52, 'gg', 15, 88, 1),
(53, 'utyutyu', 13, 56, 1),
(54, 'utyutyu', 16, 564, 1),
(55, 'utyutyu', 13, 45, 1),
(56, 'utyutyu', 9, 23, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mat_prima`
--

CREATE TABLE `mat_prima` (
  `id_mat` int(11) NOT NULL,
  `cod_mat_pri` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `id_prov` int(11) NOT NULL,
  `id_tip_mat` int(11) NOT NULL,
  `peso_lle` float NOT NULL,
  `fech_reg_mat` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usu` int(11) NOT NULL,
  `estado_mate` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mat_prima`
--

INSERT INTO `mat_prima` (`id_mat`, `cod_mat_pri`, `id_prov`, `id_tip_mat`, `peso_lle`, `fech_reg_mat`, `id_usu`, `estado_mate`) VALUES
(22, 'cha-1', 2, 1, 0, '2020-02-05 20:50:13', 1, 0),
(25, 'chi-1', 2, 2, 0, '2020-02-05 20:54:08', 1, 1),
(33, 'cha-2', 2, 1, 4, '2020-02-06 00:44:15', 1, 1),
(44, 'cha-3', 2, 1, 3, '2020-02-06 00:51:37', 1, 1),
(48, 'cha-4', 2, 1, 5, '2020-02-06 01:33:09', 1, 1),
(54, 'cha-6', 2, 1, 1, '2020-02-06 01:58:59', 1, 1),
(55, 'cha-7', 2, 1, 2, '2020-02-06 01:59:07', 1, 1),
(56, 'chi-2', 2, 2, 0, '2020-02-06 01:59:19', 1, 1),
(57, 'chi-3', 2, 2, 0, '2020-02-06 01:59:38', 1, 0),
(61, 'Cha-5', 2, 1, 0, '2020-02-25 05:07:07', 1, 1),
(62, 'Chi-4', 2, 2, 0, '2020-02-25 05:07:25', 1, 1),
(63, 'Cha-8', 2, 1, 0, '2020-02-25 05:07:32', 1, 1),
(64, 'Cha-9', 2, 1, 0, '2020-02-25 05:07:39', 1, 1),
(65, 'Chi-5', 2, 2, 0, '2020-02-25 16:07:02', 1, 0),
(66, 'Pol-1', 2, 3, 0, '2020-02-25 16:07:30', 1, 1),
(67, 'Cha-10', 4, 1, 0, '2020-02-25 16:08:35', 1, 1),
(68, 'Cha-11', 2, 1, 0, '2020-02-25 16:10:13', 1, 0),
(69, 'Cha-12', 2, 1, 0, '2020-02-25 16:10:32', 1, 1),
(70, 'Chi-6', 2, 2, 0, '2020-02-25 16:14:17', 1, 1),
(71, 'Pol-2', 2, 3, 20, '2020-02-25 16:14:24', 1, 1),
(73, 'Chi-7', 2, 2, 20, '2020-02-25 16:17:16', 1, 1),
(74, 'Pav-1', 4, 4, 20, '2020-02-25 16:18:08', 1, 1),
(75, 'Cha-13', 2, 1, 0, '2020-02-25 16:19:50', 1, 1),
(76, 'Cha-14', 2, 1, 0, '2020-02-25 16:20:21', 1, 1),
(77, 'Cha-15', 2, 1, 0, '2020-02-25 16:30:48', 1, 1),
(78, 'Cha-16', 2, 1, 0, '2020-02-25 16:30:52', 1, 1),
(79, 'Cha-17', 2, 1, 0, '2020-02-25 16:31:06', 1, 1),
(80, 'Cha-18', 2, 1, 0, '2020-02-25 16:32:32', 1, 1),
(81, 'Cha-19', 4, 1, 0, '2020-02-25 16:32:56', 1, 1),
(82, 'Cha-20', 4, 1, 0, '2020-02-25 16:33:31', 1, 1),
(83, 'Cha-21', 4, 1, 0, '2020-02-25 16:33:58', 1, 1),
(84, 'Cha-22', 2, 1, 0, '2020-02-25 16:34:48', 1, 1),
(85, 'Cha-23', 2, 1, 0, '2020-02-25 16:38:24', 1, 1),
(86, 'Cha-24', 4, 1, 105, '2020-02-25 16:40:59', 1, 1),
(89, 'Cha-25', 4, 1, 0, '2020-02-25 16:42:30', 1, 1),
(90, 'Cha-26', 4, 1, 0, '2020-02-25 16:42:34', 1, 1),
(91, 'Cha-27', 4, 1, 0, '2020-02-25 16:42:39', 1, 1),
(92, 'Cha-28', 4, 1, 0, '2020-02-25 16:42:40', 1, 1),
(93, 'Chi-8', 4, 2, 0, '2020-02-25 16:49:14', 1, 1),
(94, 'Cha-29', 2, 1, 0, '2020-02-25 16:52:02', 1, 1),
(95, 'Cha-30', 2, 1, 0, '2020-02-25 16:54:34', 1, 1),
(96, 'Cha-31', 4, 1, 0, '2020-02-25 16:55:45', 1, 1),
(97, 'Chi-9', 4, 2, 0, '2020-02-25 17:05:21', 1, 1),
(98, 'Cha-32', 2, 1, 0, '2020-02-25 17:05:57', 1, 1),
(99, 'Cha-33', 2, 1, 0, '2020-02-25 18:25:44', 1, 1),
(100, 'Pol-3', 2, 3, 0, '2020-02-28 13:52:34', 1, 1),
(101, 'Pol-4', 2, 3, 0, '2020-03-06 11:59:58', 1, 1),
(102, 'Cha-34', 2, 1, 0, '2020-05-29 22:53:44', 1, 1),
(103, 'Cha-35', 2, 1, 0, '2020-05-29 22:53:54', 1, 0),
(104, 'Chi-10', 2, 2, 0, '2020-05-29 22:57:45', 1, 1),
(105, 'Pav-2', 2, 4, 0, '2020-05-29 22:57:49', 1, 1),
(106, 'Chi-11', 2, 2, 0, '2020-05-29 22:58:05', 1, 1),
(107, 'Null-1', 1, 0, 0, '2021-05-26 14:27:24', 1, 1),
(109, 'Cha-36', 1, 1, 7, '2021-05-26 17:21:26', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_despost`
--

CREATE TABLE `orden_despost` (
  `id_ord_des` int(5) NOT NULL,
  `tip_mat_pri` int(11) NOT NULL,
  `lot_mat_pri` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `cor_pro` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fec_despo` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `orden_despost`
--

INSERT INTO `orden_despost` (`id_ord_des`, `tip_mat_pri`, `lot_mat_pri`, `cor_pro`, `estado`, `fec_despo`) VALUES
(1, 1, 'Cha-35', 'tocino,Chuleta,Medallon,Pierna de chancho,Costilla', 0, '2021-04-13 14:32:45'),
(148, 1, 'cha-1', 'tocino,Chuleta', 0, '2020-11-23 16:49:10'),
(149, 2, 'chi-3', 'Completo', 0, '2021-01-08 01:07:11'),
(150, 1, 'Cha-11', 'Chuleta', 0, '2021-01-16 23:13:38'),
(151, 2, 'Chi-5', 'Completo', 1, '2021-05-04 22:01:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_embut`
--

CREATE TABLE `orden_embut` (
  `id_ord_emb` int(11) NOT NULL,
  `nom_ord` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cant_ord` int(11) NOT NULL,
  `estado` int(5) NOT NULL DEFAULT 1,
  `fecha_ord_emb` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `orden_embut`
--

INSERT INTO `orden_embut` (`id_ord_emb`, `nom_ord`, `cant_ord`, `estado`, `fecha_ord_emb`) VALUES
(1, 'chorizon cervecero', 2, 0, '2020-11-01 15:55:07'),
(2, 'chorizon cervecero', 2, 0, '2020-11-01 16:15:55'),
(3, 'chorizon cuencano', 4, 0, '2020-11-01 16:16:53'),
(4, 'chorizon cervecero', 1, 0, '2020-11-01 16:25:08'),
(5, 'chorizon cervecero', 1, 0, '2020-11-01 16:27:53'),
(6, 'mortadela', 2, 0, '2020-11-01 16:38:22'),
(7, 'chorizon cervecero', 3, 0, '2020-11-02 15:26:21'),
(8, 'chorizon cuencano', 8, 0, '2020-11-02 16:11:44'),
(9, 'chorizon cuencano', 8, 0, '2020-11-02 16:12:50'),
(10, 'chorizon cuencano', 2, 0, '2021-05-04 21:42:48'),
(11, 'chorizon cuencano', 2, 0, '2021-05-09 18:58:35'),
(12, 'chorizon cervecero', 7, 0, '2021-05-18 13:26:43'),
(13, 'chorizon cervecero', 7, 0, '2021-05-18 13:26:52'),
(14, 'mortadela', 2, 0, '2021-05-21 08:35:27'),
(15, 'chorizon cuencano', 1, 0, '2021-05-21 08:36:33'),
(16, 'chorizon cuencano', 1, 0, '2021-05-21 08:37:43'),
(17, 'mortadela', 2, 0, '2021-05-21 08:38:01'),
(18, 'mortadela', 2, 0, '2021-05-21 08:46:00'),
(19, 'chorizon cuencano', 2, 0, '2021-05-21 08:46:40'),
(20, 'utyutyu', 2, 0, '2021-05-21 09:03:19'),
(21, 'mortadela', 2, 0, '2021-05-21 09:25:27'),
(22, 'chorizon cuencano', 2, 0, '2021-05-21 09:29:57'),
(23, 'mortadela', 2, 0, '2021-05-21 09:49:42'),
(24, 'mortadela', 2, 0, '2021-05-21 09:50:17'),
(25, 'chorizon cuencano', 2, 0, '2021-05-21 09:50:24'),
(26, 'chorizon cuencano', 3, 0, '2021-05-30 12:13:05'),
(27, 'chorizon cuencano', 2, 0, '2021-05-30 12:13:16'),
(28, 'chorizon cuencano', 3, 0, '2021-05-30 12:13:25'),
(29, 'chorizon cervecero', 2, 0, '2021-05-30 12:30:53'),
(30, 'chorizon cuencano', 2, 1, '2021-06-08 14:52:04'),
(31, 'chorizon cuencano', 2, 1, '2021-06-08 14:52:09'),
(32, 'chorizon cuencano', 2, 1, '2021-06-08 14:52:15'),
(33, 'chorizon cuencano', 2, 1, '2021-06-08 14:52:40'),
(34, 'chorizon cervecero', 3, 1, '2021-06-08 14:52:46'),
(35, 'chorizon cervecero', 3, 1, '2021-06-08 15:00:10');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_procesar`
--

CREATE TABLE `prod_procesar` (
  `id_pro_pro` int(5) NOT NULL,
  `cod_pro` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `pes_pro` float NOT NULL,
  `fecha_sali_proce` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_prod_pro` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prod_procesar`
--

INSERT INTO `prod_procesar` (`id_pro_pro`, `cod_pro`, `pes_pro`, `fecha_sali_proce`, `estado_prod_pro`) VALUES
(1, 'Cha-35', 180, '2021-04-13 14:33:35', 1),
(11, 'cha-1', 240, '2020-11-23 17:11:02', 0),
(12, 'chi-3', 350, '2021-02-09 23:13:02', 0),
(13, 'Cha-11', 350, '2021-02-09 23:15:44', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_terminado`
--

CREATE TABLE `prod_terminado` (
  `id_pro_ter` int(11) NOT NULL,
  `cod_pro` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cortes` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `peso` float NOT NULL,
  `fecha_ingre` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prod_terminado`
--

INSERT INTO `prod_terminado` (`id_pro_ter`, `cod_pro`, `cortes`, `peso`, `fecha_ingre`, `id_usu`) VALUES
(19, 'cha-1', 'Chuleta', 3, '2021-02-28 17:54:51', 1),
(20, 'Cha-35', 'tocino', 0, '2021-04-13 14:34:15', 1),
(22, 'emb-1', 'mortadela', 55, '2021-05-08 19:25:57', 1),
(23, 'emb-2', 'chorizon cervecero', 456, '2021-05-09 18:53:15', 1),
(24, 'emb-3', 'chorizon cervecero', 123, '2021-05-09 18:53:23', 1),
(25, 'emb-4', 'chorizon cuencano', 123, '2021-05-09 18:54:03', 1),
(27, 'emb-6', 'chorizon cuencano', 13, '2021-05-21 08:34:40', 1),
(28, 'emb-7', 'chorizon cervecero', 16, '2021-05-21 08:34:48', 1),
(29, 'emb-8', 'chorizon cervecero', 78, '2021-05-21 08:34:56', 1),
(30, 'emb-9', 'mortadela', 56, '2021-05-21 08:35:41', 1),
(31, 'emb-10', 'chorizon cuencano', 56, '2021-05-21 08:36:43', 1),
(32, 'emb-11', 'mortadela', 15, '2021-05-21 08:38:13', 1),
(33, 'emb-12', 'chorizon cuencano', 45, '2021-05-21 08:38:20', 1),
(34, 'emb-13', 'mortadela', 45, '2021-05-21 08:46:21', 1),
(35, 'emb-14', 'chorizon cuencano', 78, '2021-05-21 08:46:48', 1),
(36, 'emb-15', 'utyutyu', 24, '2021-05-21 09:03:31', 1),
(39, 'chi-3', 'Completo', 45, '2021-05-21 09:25:40', 1),
(40, 'emb-18', 'mortadela', 45, '2021-05-21 09:26:18', 1),
(41, 'cha-1', 'tocino', 3, '2021-05-21 09:29:37', 1),
(42, 'emb-19', 'chorizon cuencano', 78, '2021-05-21 09:30:05', 1),
(43, 'emb-20', 'mortadela', 75, '2021-05-21 09:49:52', 1),
(44, 'emb-21', 'chorizon cuencano', 12, '2021-05-21 09:50:41', 1),
(45, 'emb-22', 'mortadela', 138, '2021-05-21 09:50:50', 1),
(46, 'emb-23', 'chorizon cuencano', 45, '2021-05-30 12:13:40', 1),
(47, 'emb-24', 'chorizon cuencano', 12, '2021-05-30 12:14:47', 1),
(48, 'emb-5', 'chorizon cervecero', 45, '2021-06-07 18:18:03', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_prov` int(11) NOT NULL,
  `ced_pro` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ape_pro` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nom_pro` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cel_pro` int(10) NOT NULL,
  `cor_pro` text COLLATE utf8_spanish_ci NOT NULL,
  `dir_pro` text COLLATE utf8_spanish_ci NOT NULL,
  `ruc_emp` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `raz_emp` text COLLATE utf8_spanish_ci NOT NULL,
  `nom_emp` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `dir_emp` text COLLATE utf8_spanish_ci NOT NULL,
  `cor_emp` text COLLATE utf8_spanish_ci NOT NULL,
  `tel_emp` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_tip_emp` int(5) NOT NULL,
  `fech_reg_pro` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usu` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_prov`, `ced_pro`, `ape_pro`, `nom_pro`, `cel_pro`, `cor_pro`, `dir_pro`, `ruc_emp`, `raz_emp`, `nom_emp`, `dir_emp`, `cor_emp`, `tel_emp`, `id_tip_emp`, `fech_reg_pro`, `id_usu`, `estado`) VALUES
(1, '0910428465', 'Nunez Plaza', 'FERNANDO', 92419910, '55@hotmail.com', 'Terminal Km 23 Via Al Infinito Y Mas Alla', '0924194905001', 'Dfgdf', 'Sdfsdf', 'Bastion Poplas Y La Que Cruza', 'fds@hotmail.com', '32423', 1, '2019-11-26 18:46:13', 1, 1),
(2, '0924194905', 'nunez plaza', 'jean carlos', 941252515, 'abc@gmail.com', 'terminal km 23 via al infinito y mas alla', '3324054025432', 'venta de embutido', 'maria.sa', 'bastion poplas y la que cruza', 'jean@hotmail.com', '0425698732', 3, '2019-11-27 18:48:01', 1, 1),
(3, '0904689213', 'nunez plaza', 'jean carlos', 24332, 'ger@hotmail.com', 'sdf', '2121212121121', 'rfesdced', 'maria.sa', 'dsfcdsvc', 'riot_9@hotmail.com', '0425698732', 4, '2019-10-26 18:51:35', 1, 1),
(4, '0924194897', 'vargas', 'cecilia', 92419910, 'abc@gmail.com', 'terminal km 23 via al infinito y mas alla', '1111111111111', 'asdasd', 'dfgdf', '23432', 'riot_9@hotmail.com', '04256987', 2, '2019-11-26 18:54:58', 1, 0),
(5, '7777777777', 'SINCHE', 'ANDREA', 987654433, 'a@sinchcpme', 'Ffttrt', '0999999999001', 'Asd', 'Asd', 'Asdde', 'q2@gmail.com', '3333333546', 4, '2021-04-13 14:16:54', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `id` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'pc00001' COMMENT 'cp',
  `nom` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prueba`
--

INSERT INTO `prueba` (`id`, `nom`) VALUES
('1', 'b '),
('2', 'df'),
('3', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_balanza`
--

CREATE TABLE `tabla_balanza` (
  `id` int(11) NOT NULL,
  `DATA` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tabla_balanza`
--

INSERT INTO `tabla_balanza` (`id`, `DATA`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_guardar`
--

CREATE TABLE `tabla_guardar` (
  `id_save` int(11) NOT NULL,
  `save` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tempo_lista_receta`
--

CREATE TABLE `tempo_lista_receta` (
  `correlativo` int(11) NOT NULL,
  `token_user` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_cortes` int(5) NOT NULL,
  `cant` int(11) NOT NULL,
  `no_rece` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cortes`
--

CREATE TABLE `tipo_cortes` (
  `id_cortes` int(5) NOT NULL,
  `tipo_mat_despo` int(11) NOT NULL,
  `cortes` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_cortes`
--

INSERT INTO `tipo_cortes` (`id_cortes`, `tipo_mat_despo`, `cortes`) VALUES
(2, 1, 'tocino'),
(3, 1, 'Chuleta'),
(6, 3, 'Pechuga de pollo'),
(7, 3, 'Piernas de pollo'),
(8, 2, 'Lomo de Chivo'),
(9, 4, 'Pata'),
(11, 3, 'Pechuga'),
(12, 1, 'Medallon'),
(13, 1, 'Pierna de chancho'),
(14, 1, 'Costilla'),
(15, 1, 'Lomo de chancho'),
(16, 1, 'Panceta'),
(17, 1, 'Paleta'),
(18, 1, 'Cabeza'),
(19, 3, 'Menudencia'),
(20, 4, 'Menudencia'),
(21, 4, 'Pescuezo_'),
(22, 4, 'Pata_pav'),
(23, 3, 'Alas de pollo'),
(24, 3, 'Pierna de pollo'),
(25, 1, 'Tocino de chancho');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_empresa`
--

CREATE TABLE `tipo_empresa` (
  `id_tip_emp` int(5) NOT NULL,
  `nom_tip_emp` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_empresa`
--

INSERT INTO `tipo_empresa` (`id_tip_emp`, `nom_tip_emp`) VALUES
(1, 'carne'),
(2, 'pollo'),
(3, 'chivo'),
(4, 'chancho');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_mat`
--

CREATE TABLE `tipo_mat` (
  `id_tip_mat` int(11) NOT NULL,
  `nom_tip_mat` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_mat`
--

INSERT INTO `tipo_mat` (`id_tip_mat`, `nom_tip_mat`) VALUES
(1, 'Chancho'),
(2, 'Chivo'),
(3, 'Pollo'),
(4, 'Pavo'),
(6, 'Pescado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_reporte`
--

CREATE TABLE `tipo_reporte` (
  `id_tipo` int(10) NOT NULL,
  `nom_tipo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_reporte`
--

INSERT INTO `tipo_reporte` (`id_tipo`, `nom_tipo`) VALUES
(1, 'Completo'),
(2, 'Solo Producto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `cod_tip_usu` int(5) NOT NULL,
  `rol_tip_usu` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`cod_tip_usu`, `rol_tip_usu`) VALUES
(1, 'Administrador'),
(2, 'Supervisor'),
(3, 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usu` int(11) NOT NULL,
  `ced_usu` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nom_usu` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `ape_usu` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cel_usu` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tel_usu` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dir_usu` text COLLATE utf8_spanish_ci NOT NULL,
  `cor_usu` text COLLATE utf8_spanish_ci NOT NULL,
  `cod_tip_usu` int(5) NOT NULL,
  `usu_usu` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `cla_usu` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `fech_reg_usu` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usu`, `ced_usu`, `nom_usu`, `ape_usu`, `cel_usu`, `tel_usu`, `dir_usu`, `cor_usu`, `cod_tip_usu`, `usu_usu`, `cla_usu`, `fech_reg_usu`, `estado`) VALUES
(1, '0924194905', 'Super Usu', 'Super Usu', '3453453', '43534534', '4dfgt Erg', 'jeancarloswat_007@hotmail.com', 1, 'admin', '123', '2019-11-26 02:54:54', 1),
(2, '0924194897', 'Jean Pierre', 'NuÃ±ez Plazae', '111111111', '2222222222', 'La Chala', 'abc@gmail.com', 3, 'jeanpi', '123', '2019-11-23 22:18:20', 1),
(30, '0956332050', 'Sfsa', 'LdfAZdsdtÃ¡', '012501510', '2222222222', 'Terminal Km 23 Via Al Infinito Y Mas Alla', 'edgarguitarist@gmail.com', 2, 'jp', '123', '2019-11-26 19:33:06', 1),
(33, '0923322853', 'FERNANDO RAFAEL', 'NUNEZ PLAZA', '0984562544', '0451515445', 'Terminal Km 23 Via Al Infinito Y Mas Alla', '55@hotmail.com', 2, 'DITO', 'Dito123', '2019-11-26 23:47:34', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lista_receta`
--
ALTER TABLE `lista_receta`
  ADD PRIMARY KEY (`id_list_rece`),
  ADD KEY `list_ing_tip` (`ingr_rece`);

--
-- Indices de la tabla `mat_prima`
--
ALTER TABLE `mat_prima`
  ADD PRIMARY KEY (`id_mat`),
  ADD UNIQUE KEY `fech_reg_mat` (`fech_reg_mat`),
  ADD KEY `id_prov` (`id_prov`),
  ADD KEY `id_tip_mat` (`id_tip_mat`),
  ADD KEY `id_usu` (`id_usu`),
  ADD KEY `cod_mat_pri` (`cod_mat_pri`);

--
-- Indices de la tabla `orden_despost`
--
ALTER TABLE `orden_despost`
  ADD PRIMARY KEY (`id_ord_des`),
  ADD KEY `or_des_tip_mat` (`tip_mat_pri`),
  ADD KEY `or_des_cod_lo` (`lot_mat_pri`);

--
-- Indices de la tabla `orden_embut`
--
ALTER TABLE `orden_embut`
  ADD PRIMARY KEY (`id_ord_emb`);

--
-- Indices de la tabla `prod_final`
--
ALTER TABLE `prod_final`
  ADD PRIMARY KEY (`id_prod_final`);

--
-- Indices de la tabla `prod_procesar`
--
ALTER TABLE `prod_procesar`
  ADD PRIMARY KEY (`id_pro_pro`),
  ADD KEY `prod_pro_ord_cod` (`cod_pro`);

--
-- Indices de la tabla `prod_terminado`
--
ALTER TABLE `prod_terminado`
  ADD PRIMARY KEY (`id_pro_ter`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_prov`),
  ADD KEY `id_usu` (`id_usu`),
  ADD KEY `id_tip_emp` (`id_tip_emp`) USING BTREE;

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tabla_balanza`
--
ALTER TABLE `tabla_balanza`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tabla_guardar`
--
ALTER TABLE `tabla_guardar`
  ADD PRIMARY KEY (`id_save`);

--
-- Indices de la tabla `tempo_lista_receta`
--
ALTER TABLE `tempo_lista_receta`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `tem_tipo_desposte_mate` (`id_cortes`);

--
-- Indices de la tabla `tipo_cortes`
--
ALTER TABLE `tipo_cortes`
  ADD PRIMARY KEY (`id_cortes`),
  ADD KEY `tipo_mat_despo` (`tipo_mat_despo`);

--
-- Indices de la tabla `tipo_empresa`
--
ALTER TABLE `tipo_empresa`
  ADD PRIMARY KEY (`id_tip_emp`);

--
-- Indices de la tabla `tipo_mat`
--
ALTER TABLE `tipo_mat`
  ADD PRIMARY KEY (`id_tip_mat`),
  ADD KEY `tipo_mat_despo` (`id_tip_mat`) USING BTREE;

--
-- Indices de la tabla `tipo_reporte`
--
ALTER TABLE `tipo_reporte`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`cod_tip_usu`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usu`),
  ADD KEY `cod_tip_usu` (`cod_tip_usu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lista_receta`
--
ALTER TABLE `lista_receta`
  MODIFY `id_list_rece` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `mat_prima`
--
ALTER TABLE `mat_prima`
  MODIFY `id_mat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `orden_despost`
--
ALTER TABLE `orden_despost`
  MODIFY `id_ord_des` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT de la tabla `orden_embut`
--
ALTER TABLE `orden_embut`
  MODIFY `id_ord_emb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `prod_final`
--
ALTER TABLE `prod_final`
  MODIFY `id_prod_final` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prod_procesar`
--
ALTER TABLE `prod_procesar`
  MODIFY `id_pro_pro` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `prod_terminado`
--
ALTER TABLE `prod_terminado`
  MODIFY `id_pro_ter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_prov` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tabla_balanza`
--
ALTER TABLE `tabla_balanza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tabla_guardar`
--
ALTER TABLE `tabla_guardar`
  MODIFY `id_save` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tempo_lista_receta`
--
ALTER TABLE `tempo_lista_receta`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tipo_cortes`
--
ALTER TABLE `tipo_cortes`
  MODIFY `id_cortes` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `tipo_empresa`
--
ALTER TABLE `tipo_empresa`
  MODIFY `id_tip_emp` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_mat`
--
ALTER TABLE `tipo_mat`
  MODIFY `id_tip_mat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
