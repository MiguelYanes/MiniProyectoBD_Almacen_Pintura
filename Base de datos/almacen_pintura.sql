-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 20-06-2017 a las 23:18:55
-- Versión del servidor: 5.5.55-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `almacen_pintura`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albaran`
--

CREATE TABLE IF NOT EXISTS `albaran` (
  `num_alb` int(15) NOT NULL AUTO_INCREMENT,
  `num_ped` int(50) NOT NULL,
  `nif` varchar(10) NOT NULL,
  `num_fact` int(15) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`num_alb`),
  KEY `num_ped` (`num_ped`,`nif`),
  KEY `num_fact` (`num_fact`),
  KEY `nif` (`nif`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Nota de entrega que firma la persona que recibe las mercancías que en ella se relacionan.' AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `albaran`
--

INSERT INTO `albaran` (`num_alb`, `num_ped`, `nif`, `num_fact`, `fecha`) VALUES
(7, 25, '71516046F', 2, '2017-06-20 18:25:51'),
(8, 25, '71516046F', 2, '2017-06-20 18:25:59'),
(10, 26, '71516046F', 2, '2017-06-20 18:26:49');

--
-- Disparadores `albaran`
--
DROP TRIGGER IF EXISTS `albaran_pedido`;
DELIMITER //
CREATE TRIGGER `albaran_pedido` AFTER INSERT ON `albaran`
 FOR EACH ROW UPDATE pedido 
SET entregado = 'entregado' WHERE num_ped = NEW.num_ped AND nif = NEW.nif
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE IF NOT EXISTS `almacen` (
  `cod_alm` varchar(10) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `calle` varchar(50) NOT NULL,
  `numero` int(10) NOT NULL,
  PRIMARY KEY (`cod_alm`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`cod_alm`, `ciudad`, `calle`, `numero`) VALUES
('AAAAA00001', 'ponferrada', 'poligono industrial', 7),
('AAAAA00009', 'burgos', 'parque industrial', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE IF NOT EXISTS `articulo` (
  `cod_art` varchar(10) NOT NULL,
  `carac` varchar(500) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `tipo` enum('temple','esmalte','lacado','vinilo','plastica','decorativa') DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `max_stock` int(10) NOT NULL,
  `actual_stock` int(10) NOT NULL,
  `min_stock` int(11) NOT NULL,
  `cod_alm` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`cod_art`),
  KEY `cod_alm` (`cod_alm`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`cod_art`, `carac`, `descripcion`, `tipo`, `color`, `max_stock`, `actual_stock`, `min_stock`, `cod_alm`) VALUES
('0205XK', 'H226 Líquidos y vapores inflamables. H315 Provoca irritación cutánea. H317 Puede provocar una reacción alérgica en la piel. H319 Provoca irritación ocular grave. H332 Nocivo en caso de inhalación. H335 Puede irritar las vías respiratorias. H412 Nocivo para los organismos acuáticos, con efectos nocivos duraderos. EUH204 Contiene isocianatos. Puede provocar una reacción alérgica.', 'Cromax XK-205 catalizador normal 1ltr.', 'lacado', 'amarillo', 300, 300, 30, 'AAAAA00009'),
('1120VR', 'Resina Cromax 1640WB binder 3.5Lt. Uso profesional.', 'Cromax VR-1120 barniz laca ValueClear 5ltr.', 'temple', 'azul', 150, 36, 15, 'AAAAA00001'),
('1640WB', 'Cromax es una marca global de pinturas para la reparación de automóviles. Ofrecemos una mayor productividad desde la recepción del vehículo hasta la entrega del mismo, a través de sistemas de pintado diseñados para ser aplicados de forma fácil, rápida y precisa.', 'Cromax 1640WB Resina Binder 3.5Lt.', 'vinilo', 'rojo', 500, 136, 20, 'AAAAA00001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `nif` varchar(10) NOT NULL DEFAULT '',
  `nombre` varchar(10) NOT NULL DEFAULT '',
  `ciudad` varchar(50) NOT NULL DEFAULT '',
  `calle` varchar(50) NOT NULL DEFAULT '',
  `numero` int(10) NOT NULL DEFAULT '0',
  `cp` int(10) NOT NULL DEFAULT '0',
  `fax` int(15) DEFAULT NULL,
  `password` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`nif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`nif`, `nombre`, `ciudad`, `calle`, `numero`, `cp`, `fax`, `password`) VALUES
('123456', 'MIGUEL', '', '', 0, 0, NULL, 'e1fc7a4313def98ae5303b0448c89d9a5126f3239608950859f3ea6fdeb8b19f6f7c103ecf97700be851cfbf8cda756c0929498021c675c643809eeeb4ebcbda'),
('71516046f', 'ALBERTO', 'Ponferrada', 'Av de El Bierzo', 11, 24402, NULL, '00030cfebc1160a08ca2e897cea102ad3bc5f6d0cac2c9bb13a093fd76604a50235f923b94c997a7ef9aa3198eb911f9da463d03943ed628c0c4599381a35890');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `num_fact` int(15) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `cod_alm` varchar(10) NOT NULL,
  PRIMARY KEY (`num_fact`),
  KEY `cod_alm` (`cod_alm`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`num_fact`, `fecha`, `cod_alm`) VALUES
(1, '2017-05-18 20:40:56', 'AAAAA00001'),
(2, '2017-06-19 23:56:05', 'AAAAA00001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma`
--

CREATE TABLE IF NOT EXISTS `forma` (
  `cod_art` varchar(10) NOT NULL,
  `num_ped` int(50) NOT NULL,
  `nif` varchar(10) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`num_ped`,`nif`,`cod_art`),
  KEY `num_ped` (`num_ped`,`nif`),
  KEY `cod_art` (`cod_art`),
  KEY `nif` (`nif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `forma`
--

INSERT INTO `forma` (`cod_art`, `num_ped`, `nif`, `cantidad`) VALUES
('1640WB', 25, '71516046f', 1),
('1120VR', 26, '71516046f', 2);

--
-- Disparadores `forma`
--
DROP TRIGGER IF EXISTS `restar_stock`;
DELIMITER //
CREATE TRIGGER `restar_stock` AFTER INSERT ON `forma`
 FOR EACH ROW UPDATE articulo a
SET a.actual_stock = a.actual_stock - NEW.cantidad 
WHERE NEW.cod_art = a.cod_art
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `num_ped` int(50) NOT NULL AUTO_INCREMENT,
  `nif` varchar(10) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `entregado` varchar(50) DEFAULT 'pendiente',
  `cod_alm` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`num_ped`,`nif`),
  KEY `cod_alm` (`cod_alm`),
  KEY `nif` (`nif`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`num_ped`, `nif`, `fecha`, `entregado`, `cod_alm`) VALUES
(25, '71516046f', '2017-06-20 18:25:21', 'pendiente', NULL),
(26, '71516046f', '2017-06-20 18:26:26', 'pendiente', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE IF NOT EXISTS `proveedor` (
  `nif` varchar(10) NOT NULL,
  `nombre` varchar(10) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `calle` varchar(50) NOT NULL,
  `numero` int(10) NOT NULL,
  `fax` int(15) NOT NULL,
  PRIMARY KEY (`nif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`nif`, `nombre`, `ciudad`, `calle`, `numero`, `fax`) VALUES
('65422888H', 'Aimsur', 'Sevila', 'Pg Calonge c/antracita', 20, 954431226),
('76534586G', 'Amodeco', 'Almoradi', 'Cl Canalejas', 13, 965702840);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suministra`
--

CREATE TABLE IF NOT EXISTS `suministra` (
  `nif` varchar(10) NOT NULL,
  `cod_art` varchar(10) NOT NULL,
  `precio` double NOT NULL,
  PRIMARY KEY (`nif`,`cod_art`),
  KEY `nif` (`nif`),
  KEY `cod_art` (`cod_art`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `suministra`
--

INSERT INTO `suministra` (`nif`, `cod_art`, `precio`) VALUES
('65422888H', '1640WB', 6.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tlf_cliente`
--

CREATE TABLE IF NOT EXISTS `tlf_cliente` (
  `nif` varchar(10) NOT NULL,
  `tlf` int(15) NOT NULL,
  PRIMARY KEY (`nif`,`tlf`),
  KEY `nif` (`nif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tlf_cliente`
--

INSERT INTO `tlf_cliente` (`nif`, `tlf`) VALUES
('71516046f', 617526871),
('71516046f', 997521426);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tlf_proveedor`
--

CREATE TABLE IF NOT EXISTS `tlf_proveedor` (
  `nif` varchar(10) NOT NULL,
  `tlf` int(15) NOT NULL,
  PRIMARY KEY (`nif`,`tlf`),
  KEY `nif` (`nif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `albaran`
--
ALTER TABLE `albaran`
  ADD CONSTRAINT `FK_albaran_factura` FOREIGN KEY (`num_fact`) REFERENCES `factura` (`num_fact`),
  ADD CONSTRAINT `FK_albaran_pedido` FOREIGN KEY (`num_ped`, `nif`) REFERENCES `pedido` (`num_ped`, `nif`);

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `FK_articulo_almacen` FOREIGN KEY (`cod_alm`) REFERENCES `almacen` (`cod_alm`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `FK_factura_almacen` FOREIGN KEY (`cod_alm`) REFERENCES `almacen` (`cod_alm`);

--
-- Filtros para la tabla `forma`
--
ALTER TABLE `forma`
  ADD CONSTRAINT `FK_forma_articulo` FOREIGN KEY (`cod_art`) REFERENCES `articulo` (`cod_art`),
  ADD CONSTRAINT `FK_forma_pedido` FOREIGN KEY (`num_ped`, `nif`) REFERENCES `pedido` (`num_ped`, `nif`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `FK_pedido_almacen` FOREIGN KEY (`cod_alm`) REFERENCES `almacen` (`cod_alm`),
  ADD CONSTRAINT `FK_pedido_cliente` FOREIGN KEY (`nif`) REFERENCES `cliente` (`nif`);

--
-- Filtros para la tabla `suministra`
--
ALTER TABLE `suministra`
  ADD CONSTRAINT `FK_suministra_articulo` FOREIGN KEY (`cod_art`) REFERENCES `articulo` (`cod_art`),
  ADD CONSTRAINT `FK_suministra_proveedor` FOREIGN KEY (`nif`) REFERENCES `proveedor` (`nif`);

--
-- Filtros para la tabla `tlf_cliente`
--
ALTER TABLE `tlf_cliente`
  ADD CONSTRAINT `FK_tlf_cliente_cliente` FOREIGN KEY (`nif`) REFERENCES `cliente` (`nif`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tlf_proveedor`
--
ALTER TABLE `tlf_proveedor`
  ADD CONSTRAINT `FK_tlf_proveedor_proveedor` FOREIGN KEY (`nif`) REFERENCES `proveedor` (`nif`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
