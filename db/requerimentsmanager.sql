-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-07-2015 a las 08:49:42
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `requerimentsmanager`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aplicacion`
--

CREATE TABLE IF NOT EXISTS `aplicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  `rutaPublicacion` varchar(250) DEFAULT NULL,
  `baseDatos` varchar(50) DEFAULT NULL,
  `servidor` varchar(50) DEFAULT NULL,
  `userName` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `estadoId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_APLICACION_ESTADO` (`estadoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `aplicacion`
--

INSERT INTO `aplicacion` (`id`, `nombre`, `rutaPublicacion`, `baseDatos`, `servidor`, `userName`, `password`, `fechaRegistro`, `fechaModificacion`, `estadoId`) VALUES
(1, 'Finanzas Personales', 'c:\\xampp\\htdocs\\', 'FinanzasPersonales', 'localhost', 'root', '123456', NULL, NULL, 1),
(3, 'BrainStorm', 'c:\\xampp\\htdocs\\', 'BrainStorm', 'localhost', '', '', NULL, '2014-04-26 14:57:10', 1),
(4, 'Activo Fijo', 'c:\\xampp\\htdocs', '', '', '', '', '2014-04-26 15:01:38', '2014-04-27 17:40:47', 0),
(5, 'Jarvix - Project Manager', '', '', '', '', '', '2015-05-10 02:35:33', '2015-05-10 02:35:33', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control`
--

CREATE TABLE IF NOT EXISTS `control` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaUltAct` datetime DEFAULT NULL,
  `estadoId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FK_CTRL_EST` (`estadoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `control`
--

INSERT INTO `control` (`id`, `nombre`, `fechaRegistro`, `fechaUltAct`, `estadoId`) VALUES
(1, 'TextField', '2014-11-16 11:55:54', '2014-11-17 21:10:14', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlevento`
--

CREATE TABLE IF NOT EXISTS `controlevento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ControlId` int(11) DEFAULT NULL,
  `EventoId` int(11) DEFAULT NULL,
  `FechaRegistro` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDXU_Unique` (`ControlId`,`EventoId`),
  KEY `FK_FK_CTRLEVEN_EVEN` (`EventoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `controlevento`
--

INSERT INTO `controlevento` (`id`, `ControlId`, `EventoId`, `FechaRegistro`) VALUES
(1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlpropiedad`
--

CREATE TABLE IF NOT EXISTS `controlpropiedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ControlId` int(11) DEFAULT NULL,
  `PropiedadId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDXU_Unique` (`ControlId`,`PropiedadId`),
  KEY `FK_FK_CTRLPROP_PROP` (`PropiedadId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `controlpropiedad`
--

INSERT INTO `controlpropiedad` (`id`, `ControlId`, `PropiedadId`) VALUES
(6, 1, 2),
(5, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL,
  `tipoEstadoId` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `abreviatura` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`,`tipoEstadoId`),
  KEY `FK_Reference_12` (`tipoEstadoId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `tipoEstadoId`, `nombre`, `abreviatura`) VALUES
(0, 1, 'Inactivo', NULL),
(1, 1, 'Activo', NULL),
(0, 2, 'Registrado', 'Regis'),
(1, 2, 'Aprobado', 'Aprob'),
(2, 2, 'Cancelado', 'Cance');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadoprocesocontrol`
--

CREATE TABLE IF NOT EXISTS `estadoprocesocontrol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `estadoprocesocontrol`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadoprocesoflujo`
--

CREATE TABLE IF NOT EXISTS `estadoprocesoflujo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(60) DEFAULT NULL,
  `Descripcion` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `estadoprocesoflujo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaUltAct` datetime DEFAULT NULL,
  `estadoId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FK_EVENT_ESTADO` (`estadoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `nombre`, `fechaRegistro`, `fechaUltAct`, `estadoId`) VALUES
(1, 'Click', '2015-03-12 21:15:39', '2015-03-12 21:15:39', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato`
--

CREATE TABLE IF NOT EXISTS `formato` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaUltAct` datetime DEFAULT NULL,
  `propiedadId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FORMAT_PROP` (`propiedadId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `formato`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participante`
--

CREATE TABLE IF NOT EXISTS `participante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proyectoId` int(11) DEFAULT NULL,
  `sysUsuarioId` int(11) DEFAULT NULL,
  `flgProyectoDefault` bit(1) DEFAULT NULL COMMENT '1: Valor que Indica si es el proyecto Actual.\r\n            0: Indica que es un proyecto al cual esta asociado\r\n            ',
  PRIMARY KEY (`id`),
  KEY `FK_FK_PROYACTDES_PROY` (`proyectoId`),
  KEY `FK_FK_PROYACTDES_SYSUSR` (`sysUsuarioId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Volcar la base de datos para la tabla `participante`
--

INSERT INTO `participante` (`id`, `proyectoId`, `sysUsuarioId`, `flgProyectoDefault`) VALUES
(19, 9, 1, b'0'),
(18, 8, 1, b'0'),
(20, 11, 1, b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasoflujo`
--

CREATE TABLE IF NOT EXISTS `pasoflujo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ProcesoFlujoId` int(11) DEFAULT NULL,
  `NumeroFlujo` int(11) DEFAULT NULL,
  `Descripcion` varchar(250) DEFAULT NULL,
  `TipoFlujoId` int(11) DEFAULT NULL,
  `NumeroPaso` int(11) DEFAULT NULL,
  `PasoFlujoReferenciaId` int(11) DEFAULT NULL,
  `Responsable` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_24` (`ProcesoFlujoId`),
  KEY `FK_Reference_25` (`TipoFlujoId`),
  KEY `FK_Reference_26` (`PasoFlujoReferenciaId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=411 ;

--
-- Volcar la base de datos para la tabla `pasoflujo`
--

INSERT INTO `pasoflujo` (`id`, `ProcesoFlujoId`, `NumeroFlujo`, `Descripcion`, `TipoFlujoId`, `NumeroPaso`, `PasoFlujoReferenciaId`, `Responsable`) VALUES
(3, 238, 1, 'ss', 2, 1, NULL, NULL),
(4, 238, 1, 'ss', 2, 1, NULL, NULL),
(5, 238, 1, 'ss', 2, 1, NULL, NULL),
(6, 238, 1, 'ss', 2, 1, NULL, NULL),
(7, 238, 1, 'ss', 2, 1, NULL, NULL),
(8, 238, 1, 'ss', 2, 1, NULL, NULL),
(2, 238, 1, 'ss', 2, 1, NULL, NULL),
(9, 238, 1, 'ss', 2, 1, NULL, NULL),
(10, 238, 1, 'ss', 2, 1, NULL, NULL),
(11, 238, 1, 'ss', 2, 1, NULL, NULL),
(12, 238, 1, 'ss', 2, 1, NULL, NULL),
(13, 238, 1, 'ss', 2, 1, NULL, NULL),
(14, 238, 1, 'ss', 2, 1, NULL, NULL),
(15, 238, 1, 'ss', 2, 1, NULL, NULL),
(16, 238, 1, 'ss', 2, 1, NULL, NULL),
(17, 238, 1, 'ss', 2, 1, NULL, NULL),
(18, 238, 1, 'ss', 2, 1, NULL, NULL),
(19, 238, 1, 'ss', 2, 1, NULL, NULL),
(20, 238, 1, 'ss', 2, 1, NULL, NULL),
(21, 238, 1, 'ss', 2, 1, NULL, NULL),
(22, 238, 1, 'ss', 2, 1, NULL, NULL),
(23, 238, 1, 'ss', 2, 1, NULL, NULL),
(24, 238, 1, 'ss', 2, 1, NULL, NULL),
(25, 238, 1, 'ss', 2, 1, NULL, NULL),
(26, 238, 1, 'ss', 2, 1, NULL, NULL),
(27, 238, 1, 'ss', 2, 1, NULL, NULL),
(28, 238, 1, 'ss', 2, 1, NULL, NULL),
(29, 238, 1, 'ss', 2, 1, NULL, NULL),
(30, 238, 1, 'ss', 2, 1, NULL, NULL),
(31, 238, 1, 'ss', 2, 1, NULL, NULL),
(32, 238, 1, 'ss', 2, 1, NULL, NULL),
(33, 238, 1, 'ss', 2, 1, NULL, NULL),
(34, 238, 1, 'ss', 2, 1, NULL, NULL),
(35, 238, 1, 'ss', 2, 1, NULL, NULL),
(36, 238, 1, 'ss', 2, 1, NULL, NULL),
(37, 238, 1, 'ss', 2, 1, NULL, NULL),
(38, 238, 1, 'ss', 2, 1, NULL, NULL),
(39, 238, 1, 'ss', 2, 1, NULL, NULL),
(40, 238, 1, 'ss', 2, 1, NULL, NULL),
(41, 238, 1, 'ss', 2, 1, NULL, NULL),
(42, 238, 1, 'ss', 2, 1, NULL, NULL),
(43, 238, 1, 'ss', 2, 1, NULL, NULL),
(44, 238, 1, 'ss', 2, 1, NULL, NULL),
(45, 238, 1, 'ss', 2, 1, NULL, NULL),
(46, 238, 1, 'ss', 2, 1, NULL, NULL),
(47, 238, 1, 'ss', 2, 1, NULL, NULL),
(48, 238, 1, 'ss', 2, 1, NULL, NULL),
(49, 238, 1, 'ss', 2, 1, NULL, NULL),
(50, 238, 1, 'ss', 2, 1, NULL, NULL),
(51, 238, 1, 'ss', 2, 1, NULL, NULL),
(52, 238, 1, 'ss', 2, 1, NULL, NULL),
(53, 238, 1, 'ss', 2, 1, NULL, NULL),
(54, 238, 1, 'ss', 2, 1, NULL, NULL),
(55, 238, 1, 'ss', 2, 1, NULL, NULL),
(56, 238, 1, 'ss', 2, 1, NULL, NULL),
(57, 238, 1, 'ss', 2, 1, NULL, NULL),
(58, 238, 1, 'ss', 2, 1, NULL, NULL),
(59, 238, 1, 'ss', 2, 1, NULL, NULL),
(60, 238, 1, 'ss', 2, 1, NULL, NULL),
(61, 238, 1, 'ss', 2, 1, NULL, NULL),
(62, 238, 1, 'ss', 2, 1, NULL, NULL),
(63, 238, 1, 'ss', 2, 1, NULL, NULL),
(64, 238, 1, 'ss', 2, 1, NULL, NULL),
(65, 238, 1, 'ss', 2, 1, NULL, NULL),
(66, 238, 1, 'ss', 2, 1, NULL, NULL),
(67, 238, 1, 'ss', 2, 1, NULL, NULL),
(68, 238, 1, 'ss', 2, 1, NULL, NULL),
(69, 238, 1, 'ss', 2, 1, NULL, NULL),
(70, 238, 1, 'ss', 2, 1, NULL, NULL),
(71, 238, 1, 'ss', 2, 1, NULL, NULL),
(72, 238, 1, 'ss', 2, 1, NULL, NULL),
(73, 238, 1, 'ss', 2, 1, NULL, NULL),
(74, 238, 1, 'ss', 2, 1, NULL, NULL),
(75, 238, 1, 'ss', 2, 1, NULL, NULL),
(76, 238, 1, 'ss', 2, 1, NULL, NULL),
(77, 238, 1, 'ss', 2, 1, NULL, NULL),
(78, 238, 1, 'ss', 2, 1, NULL, NULL),
(79, 238, 1, 'ss', 2, 1, NULL, NULL),
(80, 238, 1, 'ss', 2, 1, NULL, NULL),
(81, 238, 1, 'ss', 2, 1, NULL, NULL),
(82, 238, 1, 'ss', 2, 1, NULL, NULL),
(83, 238, 1, 'ss', 2, 1, NULL, NULL),
(84, 238, 1, 'ss', 2, 1, NULL, NULL),
(85, 238, 1, 'ss', 2, 1, NULL, NULL),
(86, 238, 1, 'ss', 2, 1, NULL, NULL),
(87, 238, 1, 'ss', 2, 1, NULL, NULL),
(88, 238, 1, 'ss', 2, 1, NULL, NULL),
(89, 238, 1, 'ss', 2, 1, NULL, NULL),
(90, 238, 1, 'ss', 2, 1, NULL, NULL),
(91, 238, 1, 'ss', 2, 1, NULL, NULL),
(92, 238, 1, 'ss', 2, 1, NULL, NULL),
(93, 238, 1, 'ss', 2, 1, NULL, NULL),
(94, 238, 1, 'ss', 2, 1, NULL, NULL),
(95, 238, 1, 'ss', 2, 1, NULL, NULL),
(96, 238, 1, 'ss', 2, 1, NULL, NULL),
(97, 238, 1, 'ss', 2, 1, NULL, NULL),
(98, 238, 1, 'ss', 2, 1, 97, NULL),
(99, 238, 0, 'ss', 2, 1, 97, NULL),
(100, 238, 0, 'ss', 2, 1, 97, NULL),
(101, 238, 0, 'ss', 2, 1, 97, NULL),
(102, 238, 0, 'ss', 2, 1, 97, NULL),
(103, 238, 1, 'ss', 2, 1, NULL, NULL),
(104, 238, 1, 'ss', 2, 1, NULL, NULL),
(105, 238, 1, 'ss', 2, 1, 104, NULL),
(106, 238, 0, 'ss', 2, 1, 104, NULL),
(107, 238, 1, 'ss', 2, 1, NULL, NULL),
(108, 238, 1, 'ss', 2, 1, NULL, NULL),
(109, 238, 1, 'ss', 2, 1, 108, NULL),
(135, 238, 0, 'ss', 2, 1, 131, NULL),
(134, 238, 1, 'ss', 2, 1, 131, NULL),
(133, 238, 1, 'ss', 2, 1, 132, NULL),
(132, 238, 1, 'ss', 2, 1, NULL, NULL),
(131, 238, 1, 'ss', 2, 1, NULL, NULL),
(130, 238, 1, 'ss', 2, 1, 127, NULL),
(129, 238, 1, 'ss', 2, 1, 128, NULL),
(128, 238, 1, 'ss', 2, 1, NULL, NULL),
(127, 238, 1, 'ss', 2, 1, NULL, NULL),
(126, 238, 1, 'ss', 2, 1, NULL, NULL),
(120, 238, 1, 'ss', 2, 1, 117, NULL),
(121, 238, 1, 'ss', 2, 1, NULL, NULL),
(122, 238, 1, 'ss', 2, 1, NULL, NULL),
(123, 238, 1, 'ss', 2, 1, NULL, NULL),
(124, 238, 1, 'ss', 2, 1, 123, NULL),
(125, 238, 1, 'ss', 2, 1, 122, NULL),
(119, 238, 1, 'ss', 2, 1, 118, NULL),
(118, 238, 1, 'ss', 2, 1, NULL, NULL),
(117, 238, 1, 'ss', 2, 1, NULL, NULL),
(116, 238, 0, 'ss', 2, 1, 114, NULL),
(115, 238, 1, 'ss', 2, 1, 113, NULL),
(114, 238, 1, 'ss', 2, 1, NULL, NULL),
(113, 238, 1, 'ss', 2, 1, NULL, NULL),
(112, 238, 1, 'ss', 2, 1, NULL, NULL),
(111, 238, 1, 'ss', 2, 1, NULL, NULL),
(110, 238, 0, 'ss', 2, 1, 107, NULL),
(136, 238, 1, 'ss', 2, 1, NULL, NULL),
(137, 238, 1, 'ss', 2, 1, NULL, NULL),
(138, 238, 1, 'ss', 2, 1, NULL, NULL),
(139, 238, 1, 'ss', 2, 1, 138, NULL),
(140, 238, 1, 'ss', 2, 1, 137, NULL),
(141, 238, 0, 'ss', 2, 1, 137, NULL),
(142, 238, 1, 'ss', 2, 1, NULL, NULL),
(143, 238, 1, 'ss', 2, 1, NULL, NULL),
(144, 238, 1, 'ss', 2, 1, NULL, NULL),
(145, 238, 1, 'ss', 2, 1, 144, NULL),
(146, 238, 1, 'ss', 2, 1, 143, NULL),
(147, 238, 1, 'ss', 2, 1, NULL, NULL),
(148, 238, 1, 'ss', 2, 1, NULL, NULL),
(149, 238, 1, 'ss', 2, 1, NULL, NULL),
(150, 238, 1, 'ss', 2, 1, 149, NULL),
(151, 238, 1, 'ss', 2, 1, 147, NULL),
(152, 238, 1, 'ss', 2, 1, NULL, NULL),
(153, 238, 1, 'ss', 2, 1, NULL, NULL),
(154, 238, 1, 'ss', 2, 1, NULL, NULL),
(155, 238, 1, 'ss', 2, 1, 154, NULL),
(156, 238, 1, 'ss', 2, 1, 153, NULL),
(157, 238, 1, 'ss', 2, 1, NULL, NULL),
(158, 238, 1, 'ss', 2, 1, NULL, NULL),
(159, 238, 1, 'ss', 2, 1, NULL, NULL),
(160, 238, 1, 'ss', 2, 1, 159, NULL),
(161, 238, 1, 'ss', 2, 1, 158, NULL),
(162, 238, 0, 'ss', 2, 1, 158, NULL),
(163, 238, 1, 'ss', 2, 1, NULL, NULL),
(164, 238, 1, 'ss', 2, 1, NULL, NULL),
(165, 238, 1, 'ss', 2, 1, NULL, NULL),
(166, 238, 1, 'ss', 2, 1, 165, NULL),
(167, 238, 1, 'ss', 2, 1, 164, NULL),
(168, 238, 1, 'ss', 2, 1, NULL, NULL),
(169, 238, 1, 'ss', 2, 1, NULL, NULL),
(170, 238, 1, 'ss', 2, 1, NULL, NULL),
(171, 238, 1, 'ss', 2, 1, 170, NULL),
(172, 238, 1, 'ss', 2, 1, 169, NULL),
(173, 238, 1, 'ss', 2, 1, NULL, NULL),
(174, 238, 1, 'ss', 2, 1, NULL, NULL),
(175, 238, 1, 'ss', 2, 1, NULL, NULL),
(176, 238, 1, 'ss', 2, 1, 175, NULL),
(177, 238, 1, 'ss', 2, 1, 174, NULL),
(178, 238, 1, 'ss', 2, 1, NULL, NULL),
(179, 238, 1, 'ss', 2, 1, NULL, NULL),
(180, 238, 1, 'ss', 2, 1, NULL, NULL),
(181, 238, 1, 'ss', 2, 1, 180, NULL),
(182, 238, 1, 'ssss', 2, 1, 179, NULL),
(183, 239, 1, 'sss', 1, 1, NULL, NULL),
(184, 239, 1, 'sss', 1, 2, NULL, NULL),
(185, 239, 1, 'sss', 1, 3, NULL, NULL),
(186, 239, 1, 'ss', 2, 1, 185, NULL),
(187, 239, 1, 'sss', 2, 1, 184, NULL),
(188, 240, 1, 'ss', 1, 1, NULL, NULL),
(189, 240, 1, 'ss', 1, 2, NULL, NULL),
(190, 240, 1, 'sss', 1, 3, NULL, NULL),
(191, 240, 1, 'sss', 2, 1, 190, NULL),
(192, 240, 1, 'sss', 2, 1, 189, NULL),
(193, 240, 0, 'dsds', 2, 0, 189, NULL),
(194, 241, 1, 'sss', 1, 1, NULL, NULL),
(195, 241, 1, 'sss', 1, 2, NULL, NULL),
(196, 241, 1, 'ssss', 1, 3, NULL, NULL),
(197, 241, 1, 'sss', 2, 1, 196, NULL),
(198, 241, 1, 'sss', 2, 1, 195, NULL),
(199, 242, 1, 'sss', 1, 1, NULL, NULL),
(200, 242, 1, 'sss', 1, 2, NULL, NULL),
(201, 242, 1, 'ss', 1, 3, NULL, NULL),
(202, 242, 2, 'sss', 2, 1, 201, NULL),
(203, 242, 1, 'sss', 2, 1, 200, NULL),
(204, 242, 1, 'dfdf', 1, 2, NULL, NULL),
(205, 243, 1, 'ss', 1, 1, NULL, NULL),
(206, 243, 1, 'sss', 1, 2, NULL, NULL),
(207, 243, 1, 'sss', 1, 3, NULL, NULL),
(208, 243, 2, 'sss', 2, 1, 207, NULL),
(209, 243, 1, 'sss', 2, 1, 206, NULL),
(210, 243, 1, 'Descripcion', 1, 4, NULL, NULL),
(211, 246, 1, 'ss', 1, 1, NULL, NULL),
(212, 246, 1, 'ss', 1, 2, NULL, NULL),
(213, 246, 1, 'ss', 1, 3, NULL, NULL),
(214, 246, 0, 'sss', 2, 0, NULL, NULL),
(215, 246, 0, 'sss', 2, 0, NULL, NULL),
(216, 247, 1, 'ss', 1, 1, NULL, NULL),
(217, 247, 1, 'ss', 1, 2, NULL, NULL),
(218, 247, 1, 'ss', 1, 3, NULL, NULL),
(219, 247, 3, 'ss', 2, 1, 218, NULL),
(220, 247, 3, 'sss', 2, 1, 217, NULL),
(221, 247, 1, 'sss', 2, 1, 216, NULL),
(222, 247, 0, 'ss', 2, 0, 217, NULL),
(223, 248, 1, 'ss', 1, 1, NULL, NULL),
(224, 248, 1, 'sss', 1, 2, NULL, NULL),
(225, 248, 1, 'sss', 1, 3, NULL, NULL),
(226, 248, 1, 'sss', 1, 4, NULL, NULL),
(227, 248, 3, 'sss', 2, 1, 226, NULL),
(228, 248, 3, 'sss', 2, 1, 225, NULL),
(229, 248, 1, 'sss', 2, 1, 224, NULL),
(230, 249, 1, 'ee', 1, 1, NULL, NULL),
(231, 249, 1, 'eee', 1, 2, NULL, NULL),
(232, 249, 1, 'eee', 1, 3, NULL, NULL),
(233, 249, 1, 'eee', 1, 4, NULL, NULL),
(234, 249, 3, 'sss', 2, 1, 233, NULL),
(235, 249, 3, 'sss', 2, 1, 232, NULL),
(236, 249, 1, 'sss', 2, 1, 231, NULL),
(237, 250, 1, 'dd', 1, 1, NULL, NULL),
(238, 250, 1, 'dd', 1, 2, NULL, NULL),
(239, 250, 1, 'dd', 1, 3, NULL, NULL),
(240, 250, 3, 'dd', 2, 1, 239, NULL),
(241, 250, 3, 'ddd', 2, 1, 238, NULL),
(242, 250, 1, 'sss', 2, 1, 237, NULL),
(243, 252, 1, 'ss', 1, 1, NULL, NULL),
(244, 252, 1, 'ss', 1, 2, NULL, NULL),
(245, 252, 1, 'sss', 1, 3, NULL, NULL),
(246, 252, 3, 'sss', 2, 1, 245, NULL),
(247, 252, 3, 'sss', 2, 1, 244, NULL),
(248, 252, 1, 'sss', 2, 1, 243, NULL),
(249, 253, 1, 'sss', 1, 1, NULL, NULL),
(250, 253, 1, 'sss', 1, 2, NULL, NULL),
(251, 253, 1, 'ss', 1, 3, NULL, NULL),
(252, 253, 3, 'ss', 2, 1, 251, NULL),
(253, 253, 3, 'ss', 2, 1, 250, NULL),
(254, 253, 1, 'sss', 2, 1, 249, NULL),
(255, 254, 1, 'ss', 1, 1, NULL, NULL),
(256, 254, 1, 'ss', 1, 2, NULL, NULL),
(257, 254, 1, 'ss', 1, 3, NULL, NULL),
(258, 254, 3, 'ss', 2, 1, 257, NULL),
(259, 254, 3, 'sss', 2, 1, 256, NULL),
(260, 254, 1, 'sss', 2, 1, 255, NULL),
(261, 255, 1, 'sss', 1, 1, NULL, NULL),
(262, 255, 1, 'sss', 1, 2, NULL, NULL),
(263, 255, 1, 'sss', 1, 3, NULL, NULL),
(264, 255, 1, 'ss', 2, 1, 263, NULL),
(265, 256, 1, 'ss', 1, 1, NULL, NULL),
(266, 256, 1, 'ss', 1, 2, NULL, NULL),
(267, 256, 1, 'sss', 1, 3, NULL, NULL),
(268, 256, 3, 'ss', 2, 1, 267, NULL),
(269, 256, 2, 'ss', 2, 1, 266, NULL),
(270, 256, 1, 'ss', 2, 1, 265, NULL),
(271, 256, 1, 'hhh', 2, 2, NULL, NULL),
(272, 257, 1, 'ss', 1, 1, NULL, NULL),
(273, 257, 1, 'ss', 1, 2, NULL, NULL),
(274, 257, 1, 'ss', 2, 1, 273, NULL),
(275, 258, 1, 'dd', 1, 1, NULL, NULL),
(276, 258, 1, 'd', 1, 2, NULL, NULL),
(277, 258, 2, 'd', 3, 1, 276, NULL),
(278, 258, 1, 'dd', 2, 1, 275, NULL),
(279, 258, 1, '', 3, 1, 278, NULL),
(280, 259, 1, 'ss', 1, 1, NULL, NULL),
(281, 259, 1, 'ss', 1, 2, NULL, NULL),
(282, 259, 1, 'sss', 2, 1, 281, NULL),
(283, 259, 1, 'sss', 3, 1, 282, NULL),
(284, 260, 1, 'dd', 1, 1, NULL, NULL),
(285, 261, 1, 'dd', 1, 1, NULL, NULL),
(286, 262, 1, 'ss', 1, 1, NULL, NULL),
(287, 263, 1, 'dd', 1, 1, NULL, NULL),
(288, 264, 1, 'h', 1, 1, NULL, NULL),
(289, 265, 1, 'kk', 1, 1, NULL, NULL),
(290, 267, 1, 's', 1, 1, NULL, NULL),
(291, 269, 1, 'ss', 1, 1, NULL, NULL),
(292, 271, 1, 'ss', 1, 1, NULL, NULL),
(293, 272, 1, 'hh', 1, 1, NULL, NULL),
(294, 273, 1, 'd', 1, 1, NULL, NULL),
(295, 274, 1, 'd', 1, 1, NULL, NULL),
(296, 275, 1, 's', 1, 1, NULL, NULL),
(297, 276, 1, 's', 1, 1, NULL, NULL),
(298, 277, 1, 'ss', 1, 1, NULL, NULL),
(299, 278, 1, 's', 1, 1, NULL, NULL),
(300, 279, 1, 's', 1, 1, NULL, NULL),
(301, 280, 1, 's', 1, 1, NULL, NULL),
(302, 281, 1, 'Descripcion', 1, 1, NULL, NULL),
(303, 282, 1, 'Descripcion', 1, 1, NULL, NULL),
(304, 283, 1, 'Descripcion', 1, 1, NULL, NULL),
(305, 284, 1, 'update', 1, 1, NULL, NULL),
(306, 285, 1, 'h', 1, 1, NULL, NULL),
(307, 286, 1, 'g', 1, 1, NULL, NULL),
(308, 287, 1, 'g', 1, 1, NULL, NULL),
(309, 288, 1, 'd', 1, 1, NULL, NULL),
(310, 288, 1, 'd2', 1, 2, NULL, NULL),
(311, 289, 1, 'ee', 1, 1, NULL, NULL),
(312, 290, 1, 'g', 1, 1, NULL, NULL),
(313, 290, 1, 'g2', 1, 2, NULL, NULL),
(314, 291, 1, 's', 1, 1, NULL, NULL),
(315, 291, 1, 's', 1, 2, NULL, NULL),
(316, 292, 1, 's', 1, 1, NULL, NULL),
(317, 292, 1, 's1', 1, 2, NULL, NULL),
(318, 293, 1, 'd1', 1, 1, NULL, NULL),
(319, 293, 1, 'd2', 1, 2, NULL, NULL),
(320, 293, 0, 'ss', 2, 2, NULL, NULL),
(321, 295, 1, 'ss', 1, 1, NULL, NULL),
(322, 295, 1, 'ss1', 1, 2, NULL, NULL),
(323, 295, 0, 'ss', 1, 2, NULL, NULL),
(324, 296, 1, 's1', 1, 1, NULL, NULL),
(325, 296, 1, 's2', 1, 2, NULL, NULL),
(326, 296, 1, 's21', 1, 2, NULL, NULL),
(327, 297, 1, 'sq1', 1, 1, NULL, NULL),
(328, 297, 1, 's2', 1, 2, NULL, NULL),
(329, 297, 1, 's21', 1, 1, NULL, NULL),
(330, 298, 1, 's1', 1, 1, NULL, NULL),
(331, 298, 1, 's2', 1, 2, NULL, NULL),
(332, 298, 1, 's21', 1, 2, NULL, NULL),
(333, 299, 1, 's1', 1, 1, NULL, NULL),
(334, 299, 1, 's2', 1, 2, NULL, NULL),
(335, 299, 1, 's21', 1, 1, NULL, NULL),
(336, 300, 1, 's1', 1, 1, NULL, NULL),
(337, 300, 1, 's2', 1, 2, NULL, NULL),
(338, 300, 1, 's21', 1, 1, NULL, NULL),
(339, 301, 1, 's1', 1, 1, NULL, NULL),
(340, 301, 2, 's2', 1, 2, NULL, NULL),
(341, 301, 1, 's21', 1, 2, NULL, NULL),
(342, 302, 1, 's1', 1, 1, NULL, NULL),
(343, 302, 1, 's2', 1, 3, NULL, NULL),
(344, 302, 1, 's21', 1, 2, NULL, NULL),
(345, 303, 1, 's1', 1, 1, NULL, NULL),
(346, 303, 1, 's2', 1, 3, NULL, NULL),
(347, 303, 1, 's21', 1, 2, NULL, NULL),
(348, 304, 1, 'sss', 1, 1, NULL, NULL),
(349, 304, 1, 'sss', 1, 2, NULL, NULL),
(350, 304, 1, 'sss', 1, 4, NULL, NULL),
(351, 304, 1, 'ss', 1, 4, NULL, NULL),
(352, 304, 1, 'sss', 1, 5, NULL, NULL),
(353, 305, 1, 's1', 1, 1, NULL, NULL),
(354, 305, 1, 's2', 1, 2, NULL, NULL),
(355, 305, 1, 's3', 1, 3, NULL, NULL),
(356, 305, 1, 's4', 1, 5, NULL, NULL),
(357, 305, 1, 'd5', 1, 4, NULL, NULL),
(358, 305, 1, 'd', 1, 5, NULL, NULL),
(359, 306, 1, 's1', 1, 1, NULL, NULL),
(360, 306, 1, 's2', 1, 2, NULL, NULL),
(361, 306, 1, 's3', 1, 3, NULL, NULL),
(362, 306, 1, 's4', 1, 4, NULL, NULL),
(363, 306, 1, 's5', 1, 5, NULL, NULL),
(364, 306, 1, 's6', 1, 6, NULL, NULL),
(365, 306, 1, 's5', 1, 6, NULL, NULL),
(366, 308, 1, 's1', 1, 1, NULL, NULL),
(367, 308, 1, 's2', 1, 3, NULL, NULL),
(368, 308, 1, 's3', 1, 3, NULL, NULL),
(369, 308, 1, 's4', 1, 4, NULL, NULL),
(370, 309, 1, 'w', 1, 1, NULL, NULL),
(371, 309, 1, 'ww', 1, 2, NULL, NULL),
(372, 309, 1, 'ww', 1, 3, NULL, NULL),
(373, 309, 1, 'ww', 1, 4, NULL, NULL),
(374, 309, 1, 'ww', 1, 4, NULL, NULL),
(375, 310, 1, 'ss', 1, 1, NULL, NULL),
(376, 310, 1, 'ss', 1, 2, NULL, NULL),
(377, 310, 1, 'sss', 1, 3, NULL, NULL),
(378, 310, 1, 'ss', 1, 5, NULL, NULL),
(379, 310, 1, 'sss', 1, 4, NULL, NULL),
(380, 310, 1, 'sss', 1, 5, NULL, NULL),
(381, 311, 1, 's', 1, 2, NULL, NULL),
(382, 311, 1, 'ss', 1, 3, NULL, NULL),
(383, 314, 1, 's', 1, 1, NULL, NULL),
(384, 314, 1, 's', 1, 3, NULL, NULL),
(385, 314, 1, 's', 1, 2, NULL, NULL),
(386, 314, 1, 's', 1, 3, NULL, NULL),
(387, 316, 1, 's', 1, 1, NULL, NULL),
(388, 316, 1, 's', 1, 2, NULL, NULL),
(389, 316, 1, '', 1, 3, NULL, NULL),
(390, 316, 1, 'ss', 1, 5, NULL, NULL),
(391, 316, 1, 's', 1, 4, NULL, NULL),
(392, 316, 1, 'ss', 1, 6, NULL, NULL),
(393, 316, 1, 'ff', 2, 1, 392, NULL),
(394, 317, 1, 'dd', 1, 1, NULL, NULL),
(395, 317, 1, 'dd', 1, 2, NULL, NULL),
(396, 320, 1, 's', 1, 1, NULL, NULL),
(397, 321, 1, 's', 1, 1, NULL, NULL),
(398, 322, 1, 'd', 1, 1, NULL, NULL),
(399, 3, 1, 'sss', 1, 1, NULL, NULL),
(400, 3, 1, 'fff', 1, 2, NULL, NULL),
(401, 338, 1, 'd', 1, 1, NULL, NULL),
(402, 339, 1, 'Usuario ingresa a la opcion de ingreso de usuarios', 1, 1, NULL, NULL),
(403, 339, 1, 'Usuario selecciona la opcion de crear un nuevo usuario\n', 1, 2, NULL, NULL),
(404, 339, 1, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido ', 1, 3, NULL, NULL),
(405, 339, 1, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido ', 1, 4, NULL, NULL),
(406, 339, 1, 'El Usuario solo registra el nombre', 2, 1, 404, NULL),
(407, 339, 1, 'El Usuario continnua en el paso numero 4 del flujo principal', 2, 2, NULL, NULL),
(408, 339, 1, 'El proceso fallo', 3, 1, 405, NULL),
(409, 339, 1, 'El Sistema muestra el mensaje "no se pudo completar la tarea"', 3, 2, NULL, NULL),
(410, 339, 1, 'dsd', 1, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proceso`
--

CREATE TABLE IF NOT EXISTS `proceso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `AplicacionId` int(11) DEFAULT NULL,
  `fechaUltAct` datetime DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estadoId` int(11) DEFAULT NULL,
  `proyectoId` int(11) DEFAULT NULL,
  `rutaprototipo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FK_PROC_APL` (`AplicacionId`),
  KEY `FK_FK_Proceso_Proyecto` (`proyectoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Volcar la base de datos para la tabla `proceso`
--

INSERT INTO `proceso` (`id`, `nombre`, `fechaRegistro`, `AplicacionId`, `fechaUltAct`, `descripcion`, `estadoId`, `proyectoId`, `rutaprototipo`) VALUES
(1, 'Gestion de Controles', NULL, 1, NULL, NULL, 1, 3, NULL),
(2, 'Gestion de Controles', NULL, 1, NULL, NULL, 1, 3, NULL),
(3, 'Gestion de Controles', NULL, 1, NULL, NULL, 1, 3, NULL),
(4, 'Gestion de Controles', NULL, 1, NULL, NULL, 1, 3, NULL),
(5, 'Gestion de Controles', NULL, 1, NULL, NULL, 1, 3, NULL),
(6, 'Gestion de Controles', NULL, 1, NULL, NULL, 1, 3, NULL),
(7, 'Gestion de Controles', NULL, 1, NULL, NULL, 1, 3, NULL),
(8, 'Gestion de Controles', NULL, 1, NULL, NULL, 1, 3, NULL),
(9, 'Gestion de Controles', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/Gestion_de_Aplicaciones3.png'),
(10, 'jjjjjj', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/'),
(11, 'iii', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/'),
(12, 'iii', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/'),
(13, 'iii', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/'),
(14, 'iii', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/NvjRdt2.gif'),
(15, 'iii', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/NvjRdt21.gif'),
(16, 'iii', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/NvjRdt22.gif'),
(17, 'iii', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/NvjRdt23.gif'),
(18, 'ssss', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/NvjRdt24.gif'),
(19, 'ssss', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/NvjRdt25.gif'),
(20, 'sss', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/NvjRdt26.gif'),
(21, 'sss', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/NvjRdt27.gif'),
(22, 'hhh', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManager/uploads/NvjRdt28.gif'),
(23, '1', NULL, 1, NULL, NULL, 1, 3, 'http://localhost/RequerimentsManagerSrc/uploads/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesocontrol`
--

CREATE TABLE IF NOT EXISTS `procesocontrol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ProcesoId` int(11) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `ControlId` int(11) DEFAULT NULL,
  `EstadoProcesoControlId` int(11) DEFAULT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `comentarios` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FK_PROCCTRL_PROC` (`ProcesoId`),
  KEY `FK_Reference_28` (`ControlId`),
  KEY `FK_Reference_29` (`EstadoProcesoControlId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Tabla que relaciona los Procesos con los controles a utiliza' AUTO_INCREMENT=17 ;

--
-- Volcar la base de datos para la tabla `procesocontrol`
--

INSERT INTO `procesocontrol` (`id`, `ProcesoId`, `fechaRegistro`, `ControlId`, `EstadoProcesoControlId`, `nombre`, `comentarios`) VALUES
(1, 1, NULL, 1, NULL, NULL, NULL),
(2, 1, NULL, 1, NULL, NULL, NULL),
(3, 1, NULL, 1, NULL, NULL, NULL),
(4, 1, NULL, 1, NULL, NULL, NULL),
(5, 4, NULL, 1, NULL, NULL, NULL),
(6, 1, NULL, 1, NULL, NULL, NULL),
(7, 1, NULL, 1, NULL, NULL, NULL),
(8, 7, NULL, 1, NULL, NULL, NULL),
(9, 1, NULL, 1, NULL, NULL, NULL),
(10, 3, NULL, 1, NULL, NULL, NULL),
(11, 3, NULL, 1, NULL, NULL, NULL),
(12, 3, NULL, 0, NULL, '', NULL),
(13, 3, NULL, 1, NULL, 'TextField235', NULL),
(14, 3, NULL, 1, NULL, 'txtPrueba', NULL),
(15, 3, NULL, 1, NULL, 'TextField', NULL),
(16, 3, NULL, 0, NULL, 'ss', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesocontrolevento`
--

CREATE TABLE IF NOT EXISTS `procesocontrolevento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ProcesoControlId` int(11) DEFAULT NULL,
  `Valor` varchar(250) DEFAULT NULL,
  `ControlEventoId` int(11) DEFAULT NULL,
  `EventoId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_32` (`ControlEventoId`),
  KEY `FK_Reference_33` (`ProcesoControlId`),
  KEY `FK_Reference_35` (`EventoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcar la base de datos para la tabla `procesocontrolevento`
--

INSERT INTO `procesocontrolevento` (`id`, `ProcesoControlId`, `Valor`, `ControlEventoId`, `EventoId`) VALUES
(1, 14, '1', 0, 0),
(2, 14, '1', 0, 0),
(3, 14, '1', 0, 0),
(4, 14, '1', 1, 1),
(5, 14, '1', 1, 1),
(6, 14, '1', 1, 1),
(7, 14, '12', 1, 1),
(8, 14, '2', 1, 1),
(9, 14, '2', 1, 1),
(10, 14, '2', 1, 1),
(11, 14, '3', 1, 1),
(12, 14, '2', 1, 1),
(13, 14, '8', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesocontrolpropiedad`
--

CREATE TABLE IF NOT EXISTS `procesocontrolpropiedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ProcesoControlId` int(11) DEFAULT NULL,
  `PropiedadId` int(11) DEFAULT NULL,
  `ControlPropiedadId` int(11) DEFAULT NULL,
  `valor` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_30` (`ProcesoControlId`),
  KEY `FK_Reference_31` (`ControlPropiedadId`),
  KEY `FK_Reference_34` (`PropiedadId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `procesocontrolpropiedad`
--

INSERT INTO `procesocontrolpropiedad` (`id`, `ProcesoControlId`, `PropiedadId`, `ControlPropiedadId`, `valor`) VALUES
(1, 13, 1, 5, NULL),
(2, 13, 1, 5, NULL),
(3, 13, 1, 5, NULL),
(4, 13, 1, 5, NULL),
(5, 13, 1, 5, NULL),
(6, 13, 1, 5, NULL),
(7, 14, 1, 5, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido '),
(8, 14, 2, 6, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesoflujo`
--

CREATE TABLE IF NOT EXISTS `procesoflujo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `procesoId` int(11) DEFAULT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `EstadoProcesoFlujoId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_23` (`procesoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=341 ;

--
-- Volcar la base de datos para la tabla `procesoflujo`
--

INSERT INTO `procesoflujo` (`id`, `procesoId`, `nombre`, `descripcion`, `fechaRegistro`, `EstadoProcesoFlujoId`) VALUES
(2, 1, 's1', 's1', NULL, -1),
(3, 1, 's1', 's1', NULL, -1),
(4, 1, 's1', 's1', NULL, -1),
(5, 1, 's1', 's1', NULL, -1),
(6, 1, 's1', 's1', NULL, -1),
(7, 1, 's1', 's1', NULL, -1),
(8, 1, 's1', 's1', NULL, -1),
(9, 1, 's1', 's1', NULL, -1),
(10, 1, 's1', 's1', NULL, -1),
(11, 1, 's1', 's1', NULL, -1),
(12, 1, 's1', 's1', NULL, -1),
(13, 1, 's1', 's1', NULL, -1),
(14, 1, 's1', 's1', NULL, -1),
(15, 1, 's1', 's1', NULL, -1),
(16, 1, 's1', 's1', NULL, -1),
(17, 1, 's1', 's1', NULL, -1),
(18, 1, 's1', 's1', NULL, -1),
(19, 1, 's1', 's1', NULL, -1),
(20, 1, 's1', 's1', NULL, -1),
(21, 1, 's1', 's1', NULL, -1),
(22, 1, 's1', 's1', NULL, -1),
(23, 1, 's1', 's1', NULL, -1),
(24, 1, 's1', 's1', NULL, -1),
(25, 1, 's1', 's1', NULL, -1),
(26, 1, 's1', 's1', NULL, -1),
(27, 1, 's1', 's1', NULL, -1),
(28, 1, 's1', 's1', NULL, -1),
(29, 1, 's1', 's1', NULL, -1),
(30, 1, 's1', 's1', NULL, -1),
(31, 1, 's1', 's1', NULL, -1),
(32, 1, 's1', 's1', NULL, -1),
(33, 1, 's1', 's1', NULL, -1),
(34, 1, 's1', 's1', NULL, -1),
(35, 1, 's1', 's1', NULL, -1),
(36, 1, 's1', 's1', NULL, -1),
(37, 1, 's1', 's1', NULL, -1),
(38, 1, 's1', 's1', NULL, -1),
(39, 1, 's1', 's1', NULL, -1),
(40, 1, 's1', 's1', NULL, -1),
(41, 1, 's1', 's1', NULL, -1),
(42, 1, 's1', 's1', NULL, -1),
(43, 1, 's1', 's1', NULL, -1),
(44, 1, 's1', 's1', NULL, -1),
(45, 1, 's1', 's1', NULL, -1),
(46, 1, 's1', 's1', NULL, -1),
(47, 1, 's1', 's1', NULL, -1),
(48, 1, 's1', 's1', NULL, -1),
(49, 1, 's1', 's1', NULL, -1),
(50, 1, 's1', 's1', NULL, -1),
(51, 1, 's1', 's1', NULL, -1),
(52, 1, 's1', 's1', NULL, -1),
(53, 1, 's1', 's1', NULL, -1),
(54, 1, 's1', 's1', NULL, -1),
(55, 1, 's1', 's1', NULL, -1),
(56, 1, 's1', 's1', NULL, -1),
(57, 1, 's1', 's1', NULL, -1),
(58, 1, 's1', 's1', NULL, -1),
(59, 1, 's1', 's1', NULL, -1),
(60, 1, 's1', 's1', NULL, -1),
(61, 1, 's1', 's1', NULL, -1),
(62, 1, 's1', 's1', NULL, -1),
(63, 1, 's1', 's1', NULL, -1),
(64, 1, 's1', 's1', NULL, -1),
(65, 1, 's1', 's1', NULL, -1),
(66, 1, 's1', 's1', NULL, -1),
(67, 1, 's1', 's1', NULL, -1),
(68, 1, 's1', 's1', NULL, -1),
(69, 1, 's1', 's1', NULL, -1),
(70, 1, 's1', 's1', NULL, -1),
(71, 1, 's1', 's1', NULL, -1),
(72, 1, 's1', 's1', NULL, -1),
(73, 1, 's1', 's1', NULL, -1),
(74, 1, 's1', 's1', NULL, -1),
(75, 1, 's1', 's1', NULL, -1),
(76, 1, 's1', 's1', NULL, -1),
(77, 1, 's1', 's1', NULL, -1),
(78, 1, 's1', 's1', NULL, -1),
(79, 1, 's1', 's1', NULL, -1),
(80, 1, 's1', 's1', NULL, -1),
(81, 1, 's1', 's1', NULL, -1),
(82, 1, 's1', 's1', NULL, -1),
(83, 1, 's1', 's1', NULL, -1),
(84, 1, 's1', 's1', NULL, -1),
(85, 1, 's1', 's1', NULL, -1),
(86, 1, 's1', 's1', NULL, -1),
(87, 1, 's1', 's1', NULL, -1),
(88, 1, 's1', 's1', NULL, -1),
(89, 1, 's1', 's1', NULL, -1),
(90, 1, 's1', 's1', NULL, -1),
(91, 1, 's1', 's1', NULL, -1),
(92, 1, 's1', 's1', NULL, -1),
(93, 1, 's1', 's1', NULL, -1),
(94, 1, 's1', 's1', NULL, -1),
(95, 1, 's1', 's1', NULL, -1),
(96, 1, 's1', 's1', NULL, -1),
(97, 1, 's1', 's1', NULL, -1),
(98, 1, 's1', 's1', NULL, -1),
(99, 1, 's1', 's1', NULL, -1),
(100, 1, 's1', 's1', NULL, -1),
(101, 1, 's1', 's1', NULL, -1),
(102, 1, 's1', 's1', NULL, -1),
(103, 1, 's1', 's1', NULL, -1),
(104, 1, 's1', 's1', NULL, -1),
(105, 1, 's1', 's1', NULL, -1),
(106, 1, 's1', 's1', NULL, -1),
(107, 1, 's1', 's1', NULL, -1),
(108, 1, 's1', 's1', NULL, -1),
(109, 1, 's1', 's1', NULL, -1),
(110, 1, 's1', 's1', NULL, -1),
(111, 1, 's1', 's1', NULL, -1),
(112, 1, 's1', 's1', NULL, -1),
(113, 1, 's1', 's1', NULL, -1),
(114, 1, 's1', 's1', NULL, -1),
(115, 1, 's1', 's1', NULL, -1),
(116, 1, 's1', 's1', NULL, -1),
(117, 1, 's1', 's1', NULL, -1),
(118, 1, 's1', 's1', NULL, -1),
(119, 1, 's1', 's1', NULL, -1),
(120, 1, 's1', 's1', NULL, -1),
(121, 1, 's1', 's1', NULL, -1),
(122, 1, 's1', 's1', NULL, -1),
(123, 1, 's1', 's1', NULL, -1),
(124, 1, 's1', 's1', NULL, -1),
(125, 1, 's1', 's1', NULL, -1),
(126, 1, 's1', 's1', NULL, -1),
(127, 1, 's1', 's1', NULL, -1),
(128, 1, 's1', 's1', NULL, -1),
(129, 1, 's1', 's1', NULL, -1),
(130, 1, 's1', 's1', NULL, -1),
(131, 1, 's1', 's1', NULL, -1),
(132, 1, 's1', 's1', NULL, -1),
(133, 1, 's1', 's1', NULL, -1),
(134, 1, 's1', 's1', NULL, -1),
(135, 1, 's1', 's1', NULL, -1),
(136, 1, 's1', 's1', NULL, -1),
(137, 1, 's1', 's1', NULL, -1),
(138, 1, 's1', 's1', NULL, -1),
(139, 1, 's1', 's1', NULL, -1),
(140, 1, 's1', 's1', NULL, -1),
(141, 1, 's1', 's1', NULL, -1),
(142, 1, 's1', 's1', NULL, -1),
(143, 1, 's1', 's1', NULL, -1),
(144, 1, 's1', 's1', NULL, -1),
(145, 1, 's1', 's1', NULL, -1),
(146, 1, 's1', 's1', NULL, -1),
(147, 1, 's1', 's1', NULL, -1),
(148, 1, 's1', 's1', NULL, -1),
(149, 1, 's1', 's1', NULL, -1),
(150, 1, 's1', 's1', NULL, -1),
(151, 1, 's1', 's1', NULL, -1),
(152, 1, 's1', 's1', NULL, -1),
(153, 1, 's1', 's1', NULL, -1),
(154, 1, 's1', 's1', NULL, -1),
(155, 1, 's1', 's1', NULL, -1),
(156, 1, 's1', 's1', NULL, -1),
(157, 1, 's1', 's1', NULL, -1),
(158, 1, 's1', 's1', NULL, -1),
(159, 1, 's1', 's1', NULL, -1),
(160, 1, 's1', 's1', NULL, -1),
(161, 1, 's1', 's1', NULL, -1),
(162, 1, 's1', 's1', NULL, -1),
(163, 1, 's1', 's1', NULL, -1),
(164, 1, 's1', 's1', NULL, -1),
(165, 1, 's1', 's1', NULL, -1),
(166, 1, 's1', 's1', NULL, -1),
(167, 1, 's1', 's1', NULL, -1),
(168, 1, 's1', 's1', NULL, -1),
(169, 1, 's1', 's1', NULL, -1),
(170, 1, 's1', 's1', NULL, -1),
(171, 1, 's1', 's1', NULL, -1),
(172, 1, 's1', 's1', NULL, -1),
(173, 1, 's1', 's1', NULL, -1),
(174, 1, 's1', 's1', NULL, -1),
(175, 1, 's1', 's1', NULL, -1),
(176, 1, 's1', 's1', NULL, -1),
(177, 1, 's1', 's1', NULL, -1),
(178, 1, 's1', 's1', NULL, -1),
(179, 1, 's1', 's1', NULL, -1),
(180, 1, 's1', 's1', NULL, -1),
(181, 1, 's1', 's1', NULL, -1),
(182, 1, 's1', 's1', NULL, -1),
(183, 1, 's1', 's1', NULL, -1),
(184, 1, 's1', 's1', NULL, -1),
(185, 1, 's1', 's1', NULL, -1),
(186, 1, 's1', 's1', NULL, -1),
(187, 1, 's1', 's1', NULL, -1),
(188, 1, 's1', 's1', NULL, -1),
(189, 1, 's1', 's1', NULL, -1),
(190, 1, 's1', 's1', NULL, -1),
(191, 1, 's1', 's1', NULL, -1),
(192, 1, 's1', 's1', NULL, -1),
(193, 1, 's1', 's1', NULL, -1),
(194, 1, 's1', 's1', NULL, -1),
(195, 1, 's1', 's1', NULL, -1),
(196, 1, 's1', 's1', NULL, -1),
(197, 1, 's1', 's1', NULL, -1),
(198, 1, 's1', 's1', NULL, -1),
(199, 1, 's1', 's1', NULL, -1),
(200, 1, 's1', 's1', NULL, -1),
(201, 1, 's1', 's1', NULL, -1),
(202, 1, 's1', 's1', NULL, -1),
(203, 1, 's1', 's1', NULL, -1),
(204, 1, 's1', 's1', NULL, -1),
(205, 1, 's1', 's1', NULL, -1),
(206, 1, 's1', 's1', NULL, -1),
(207, 1, 's1', 's1', NULL, -1),
(208, 1, 's1', 's1', NULL, -1),
(209, 1, 's1', 's1', NULL, -1),
(210, 1, 's1', 's1', NULL, -1),
(211, 1, 's1', 's1', NULL, -1),
(212, 1, 's1', 's1', NULL, -1),
(213, 1, 's1', 's1', NULL, -1),
(214, 1, 's1', 's1', NULL, -1),
(215, 1, 's1', 's1', NULL, -1),
(216, 1, 's1', 's1', NULL, -1),
(217, 1, 's1', 's1', NULL, -1),
(218, 1, 's1', 's1', NULL, -1),
(219, 1, 's1', 's1', NULL, -1),
(220, 1, 's1', 's1', NULL, -1),
(221, 1, 's1', 's1', NULL, -1),
(222, 1, 's1', 's1', NULL, -1),
(223, 1, 's1', 's1', NULL, -1),
(224, 1, 's1', 's1', NULL, -1),
(225, 1, 's1', 's1', NULL, -1),
(226, 1, 's1', 's1', NULL, -1),
(227, 1, 's1', 's1', NULL, -1),
(228, 1, 's1', 's1', NULL, -1),
(229, 1, 's1', 's1', NULL, -1),
(230, 1, 's1', 's1', NULL, -1),
(231, 1, 's1', 's1', NULL, -1),
(232, 1, 's1', 's1', NULL, -1),
(233, 1, 's1', 's1', NULL, -1),
(234, 1, 's1', 's1', NULL, -1),
(235, 1, 's1', 's1', NULL, -1),
(236, 1, 's1', 's1', NULL, -1),
(237, 1, 's1', 's1', NULL, -1),
(238, 1, 's1', 's1', NULL, -1),
(239, 1, 's1', 's1', NULL, -1),
(240, 1, 's1', 's1', NULL, -1),
(241, 1, 's1', 's1', NULL, -1),
(242, 1, 's1', 's1', NULL, -1),
(243, 1, 's1', 's1', NULL, -1),
(244, 1, 's1', 's1', NULL, -1),
(245, 1, 's1', 's1', NULL, -1),
(246, 1, 's1', 's1', NULL, -1),
(247, 1, 's1', 's1', NULL, -1),
(248, 1, 's1', 's1', NULL, -1),
(249, 1, 's1', 's1', NULL, -1),
(250, 1, 's1', 's1', NULL, -1),
(251, 1, 's1', 's1', NULL, -1),
(252, 1, 's1', 's1', NULL, -1),
(253, 1, 's1', 's1', NULL, -1),
(254, 1, 's1', 's1', NULL, -1),
(255, 1, 's1', 's1', NULL, -1),
(256, 1, 's1', 's1', NULL, -1),
(257, 1, 's1', 's1', NULL, -1),
(258, 1, 's1', 's1', NULL, -1),
(259, 1, 's1', 's1', NULL, -1),
(260, 1, 's1', 's1', NULL, -1),
(261, 1, 's1', 's1', NULL, -1),
(262, 1, 's1', 's1', NULL, -1),
(263, 1, 's1', 's1', NULL, -1),
(264, 1, 's1', 's1', NULL, -1),
(265, 1, 's1', 's1', NULL, -1),
(266, 1, 's1', 's1', NULL, -1),
(267, 1, 's1', 's1', NULL, -1),
(268, 1, 's1', 's1', NULL, -1),
(269, 1, 's1', 's1', NULL, -1),
(270, 1, 's1', 's1', NULL, -1),
(271, 1, 's1', 's1', NULL, -1),
(272, 1, 's1', 's1', NULL, -1),
(273, 1, 's1', 's1', NULL, -1),
(274, 1, 's1', 's1', NULL, -1),
(275, 1, 's1', 's1', NULL, -1),
(276, 1, 's1', 's1', NULL, -1),
(277, 1, 's1', 's1', NULL, -1),
(278, 1, 's1', 's1', NULL, -1),
(279, 1, 's1', 's1', NULL, -1),
(280, 1, 's1', 's1', NULL, -1),
(281, 1, 's1', 's1', NULL, -1),
(282, 1, 's1', 's1', NULL, -1),
(283, 1, 's1', 's1', NULL, -1),
(284, 1, 's1', 's1', NULL, -1),
(285, 1, 's1', 's1', NULL, -1),
(286, 1, 's1', 's1', NULL, -1),
(287, 1, 's1', 's1', NULL, -1),
(288, 1, 's1', 's1', NULL, -1),
(289, 1, 's1', 's1', NULL, -1),
(290, 1, 's1', 's1', NULL, -1),
(291, 1, 's1', 's1', NULL, -1),
(292, 1, 's1', 's1', NULL, -1),
(293, 1, 's1', 's1', NULL, -1),
(294, 1, 's1', 's1', NULL, -1),
(295, 1, 's1', 's1', NULL, -1),
(296, 1, 's1', 's1', NULL, -1),
(297, 1, 's1', 's1', NULL, -1),
(298, 1, 's1', 's1', NULL, -1),
(299, 1, 's1', 's1', NULL, -1),
(300, 1, 's1', 's1', NULL, -1),
(301, 1, 's1', 's1', NULL, -1),
(302, 1, 's1', 's1', NULL, -1),
(303, 1, 's1', 's1', NULL, -1),
(304, 1, 's1', 's1', NULL, -1),
(305, 1, 's1', 's1', NULL, -1),
(306, 1, 's1', 's1', NULL, -1),
(307, 1, 's1', 's1', NULL, -1),
(308, 1, 's1', 's1', NULL, -1),
(309, 1, 's1', 's1', NULL, -1),
(310, 1, 's1', 's1', NULL, -1),
(311, 1, 's1', 's1', NULL, -1),
(312, 1, 's1', 's1', NULL, -1),
(313, 1, 's1', 's1', NULL, -1),
(314, 1, 's1', 's1', NULL, -1),
(315, 1, 's1', 's1', NULL, -1),
(316, 1, 's1', 's1', NULL, -1),
(317, 1, 's1', 's1', NULL, -1),
(318, 1, 's1', 's1', NULL, -1),
(319, 1, 's1', 's1', NULL, -1),
(320, 1, 's1', 's1', NULL, -1),
(321, 1, 's1', 's1', NULL, -1),
(322, 1, 's1', 's1', NULL, -1),
(323, 1, 's1', 's1', NULL, -1),
(324, 1, 's1', 's1', NULL, -1),
(325, 1, 's1', 's1', NULL, -1),
(326, 1, 's1', 's1', NULL, -1),
(327, 1, 's1', 's1', NULL, -1),
(328, 1, 's1', 's1', NULL, -1),
(329, 1, 's1', 's1', NULL, -1),
(330, 1, 's1', 's1', NULL, -1),
(331, 1, 's1', 's1', NULL, -1),
(332, 1, 's1', 's1', NULL, -1),
(333, 1, 's1', 's1', NULL, -1),
(334, 1, 's1', 's1', NULL, -1),
(335, 1, 's1', 's1', NULL, -1),
(336, 1, 's1', 's1', NULL, -1),
(337, 1, 's', 's', NULL, -1),
(338, 1, 's', 's', NULL, 0),
(339, 3, 'Registrar Usuario', 'sdsdsdads', NULL, 0),
(340, 0, 'XX', 'XX', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesoflujodetalle`
--

CREATE TABLE IF NOT EXISTS `procesoflujodetalle` (
  `id` int(11) NOT NULL,
  `ProcesoFlujoId` int(11) DEFAULT NULL,
  `NumeroFlujo` int(11) DEFAULT NULL,
  `Descripcion` varchar(250) DEFAULT NULL,
  `TipoFlujoId` int(11) DEFAULT NULL,
  `NumeroPaso` int(11) DEFAULT NULL,
  `NombreFlujo` varchar(250) DEFAULT NULL,
  `TipoFlujoReferenciaId` int(11) DEFAULT NULL,
  `NumeroFlujoReferencia` int(11) DEFAULT NULL,
  `NombreFlujoReferencia` varchar(250) DEFAULT NULL,
  `PasoReferencia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_24` (`ProcesoFlujoId`),
  KEY `FK_Reference_25` (`TipoFlujoId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `procesoflujodetalle`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesopropiedad`
--

CREATE TABLE IF NOT EXISTS `procesopropiedad` (
  `id` int(11) NOT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `procesoId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FK_PROCPROP_PROC` (`procesoId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `procesopropiedad`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesorequerimientofuncional`
--

CREATE TABLE IF NOT EXISTS `procesorequerimientofuncional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechaRegistro` datetime DEFAULT NULL,
  `procesoId` int(11) DEFAULT NULL,
  `requerimientoFuncionalId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FK_PROCREQFUNC_REQFUNC` (`requerimientoFuncionalId`),
  KEY `FK_FK_REQFUNC_PROC` (`procesoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Volcar la base de datos para la tabla `procesorequerimientofuncional`
--

INSERT INTO `procesorequerimientofuncional` (`id`, `fechaRegistro`, `procesoId`, `requerimientoFuncionalId`) VALUES
(12, NULL, 3, 4),
(13, NULL, 3, 6),
(14, NULL, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedad`
--

CREATE TABLE IF NOT EXISTS `propiedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaUltAct` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `propiedad`
--

INSERT INTO `propiedad` (`id`, `nombre`, `fechaRegistro`, `fechaUltAct`) VALUES
(1, 'Enabled', '2014-11-17 21:08:19', '2014-11-17 21:08:19'),
(2, 'Width', '2014-11-17 21:08:26', '2014-11-17 21:08:26'),
(3, 'Height', '2014-11-17 21:08:30', '2014-11-17 21:08:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE IF NOT EXISTS `proyecto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `aplicacionId` int(11) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `estadoid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_PROYECTO_APLICACION` (`aplicacionId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcar la base de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`id`, `nombre`, `descripcion`, `aplicacionId`, `fechaRegistro`, `fechaModificacion`, `estadoid`) VALUES
(4, 'Implementacion del Sistema JARVIX', 'Implementacion del Sistema JARVIX.', 5, '2015-05-10 02:36:34', '2015-05-10 02:36:34', 1),
(5, 'dsfds', 'fsdfsdf', 1, '2015-07-01 02:01:19', '2015-07-01 02:01:19', 1),
(6, 's', 's', 1, '2015-07-01 07:38:42', '2015-07-01 07:38:42', 1),
(7, 'dsad', 'dsad', 3, '2015-07-01 23:31:07', '2015-07-01 23:31:07', 1),
(8, 'sss', 'dsadas', 1, '2015-07-04 14:54:48', '2015-07-04 14:54:48', 1),
(9, 'ss', 'sss', 5, '2015-07-05 15:16:22', '2015-07-05 15:16:22', 1),
(10, 'dsds', 'dsds', 1, '2015-07-06 18:40:40', '2015-07-06 18:40:40', 1),
(11, 'ad', 'dsadasd', 1, '2015-07-06 19:21:13', '2015-07-06 19:21:13', 1),
(12, 'sss', 'ss', 3, '2015-07-06 22:23:54', '2015-07-06 22:23:54', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectoactualdesarrollo`
--

CREATE TABLE IF NOT EXISTS `proyectoactualdesarrollo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proyectoId` int(11) DEFAULT NULL,
  `sysUsuarioId` int(11) DEFAULT NULL,
  `flgProyectoActual` bit(1) DEFAULT NULL COMMENT '1: Valor que Indica si es el proyecto Actual.\r\n            0: Indica que es un proyecto al cual esta asociado\r\n            ',
  PRIMARY KEY (`id`),
  KEY `FK_FK_PROYACTDES_PROY` (`proyectoId`),
  KEY `FK_FK_PROYACTDES_SYSUSR` (`sysUsuarioId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `proyectoactualdesarrollo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectousuario`
--

CREATE TABLE IF NOT EXISTS `proyectousuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proyectoId` int(11) DEFAULT NULL,
  `sysUsuarioId` int(11) DEFAULT NULL,
  `flgProyectoActual` bit(1) DEFAULT NULL COMMENT '1: Valor que Indica si es el proyecto Actual.\r\n            0: Indica que es un proyecto al cual esta asociado\r\n            ',
  PRIMARY KEY (`id`),
  KEY `FK_FK_PROYACTDES_PROY` (`proyectoId`),
  KEY `FK_FK_PROYACTDES_SYSUSR` (`sysUsuarioId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `proyectousuario`
--

INSERT INTO `proyectousuario` (`id`, `proyectoId`, `sysUsuarioId`, `flgProyectoActual`) VALUES
(1, 3, 1, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimientofuncional`
--

CREATE TABLE IF NOT EXISTS `requerimientofuncional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(25) DEFAULT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `proyectoId` int(11) DEFAULT NULL,
  `estadoId` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL COMMENT '1. Campo que sirve para enumerar los requerimientos funcionales, por proyecto inicializa en 1',
  PRIMARY KEY (`id`),
  KEY `FK_REQFUNC_PROY` (`proyectoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `requerimientofuncional`
--

INSERT INTO `requerimientofuncional` (`id`, `codigo`, `nombre`, `fechaRegistro`, `fechaModificacion`, `descripcion`, `proyectoId`, `estadoId`, `orden`) VALUES
(1, '', 'Mapeo de UF_SERVICES', '2015-07-02 01:29:27', '2015-07-02 01:29:27', '', 3, 1, 1),
(2, '', 'DD', '2015-07-02 01:29:42', '2015-07-02 01:29:42', 'DD', 3, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sysaplicacion`
--

CREATE TABLE IF NOT EXISTS `sysaplicacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `sysaplicacion`
--

INSERT INTO `sysaplicacion` (`id`, `nombre`, `fechaRegistro`) VALUES
(1, 'Requeriments Manager', '2014-03-02 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sysopcionaplicacion`
--

CREATE TABLE IF NOT EXISTS `sysopcionaplicacion` (
  `id` int(11) NOT NULL,
  `SysAplicacionId` int(11) DEFAULT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `fechaRegistro` date DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  `viewLoader` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_SYSOPCAPL_SYSAPL` (`SysAplicacionId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `sysopcionaplicacion`
--

INSERT INTO `sysopcionaplicacion` (`id`, `SysAplicacionId`, `nombre`, `fechaRegistro`, `parentid`, `viewLoader`) VALUES
(1, 1, 'Gestion de Controles', '2014-03-02', NULL, '/GestionControles/GestionControlesController'),
(2, 1, 'Gestion de Eventos', '2014-03-02', NULL, '/GestionEventos/GestionEventosController'),
(3, 1, 'Gestion de Propiedades', '2014-03-02', NULL, '/GestionPropiedades/GestionPropiedadesController'),
(4, 1, 'Gestion de Formatos', '2014-03-02', NULL, NULL),
(5, 1, 'Gestion de Aplicaciones', '2014-03-02', NULL, '/GestionAplicaciones/GestionAplicacionesController'),
(6, 1, 'Toma de Requerimientos', '2014-03-02', NULL, '/GestionRequerimientos/GestionRequerimientosController'),
(7, 1, 'Modelar Requerimientos', '2014-03-02', NULL, '/GestionProcesos/GestionProcesosController'),
(0, 1, 'Gestion de Proyectos', '2014-04-10', NULL, '/GestionProyectos/GestionProyectosController');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sysperfil`
--

CREATE TABLE IF NOT EXISTS `sysperfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaActualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `sysperfil`
--

INSERT INTO `sysperfil` (`id`, `nombre`, `fechaRegistro`, `fechaActualizacion`) VALUES
(1, 'Gestor', NULL, NULL),
(2, 'Desarrollador', NULL, NULL),
(3, 'Analista', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sysperfilopcionapp`
--

CREATE TABLE IF NOT EXISTS `sysperfilopcionapp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SysPerfilId` int(11) DEFAULT NULL,
  `SysOpcionAplicacionId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_36` (`SysPerfilId`),
  KEY `FK_Reference_37` (`SysOpcionAplicacionId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `sysperfilopcionapp`
--

INSERT INTO `sysperfilopcionapp` (`id`, `SysPerfilId`, `SysOpcionAplicacionId`) VALUES
(1, 1, 0),
(2, 1, 1),
(3, 1, 2),
(4, 1, 3),
(5, 1, 4),
(6, 1, 5),
(7, 1, 6),
(8, 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sysusuario`
--

CREATE TABLE IF NOT EXISTS `sysusuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) DEFAULT NULL,
  `fechaRegistro` date DEFAULT NULL,
  `fechaActualizacion` date DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `passusr` varchar(255) DEFAULT NULL,
  `estadoid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `sysusuario`
--

INSERT INTO `sysusuario` (`id`, `nombre`, `fechaRegistro`, `fechaActualizacion`, `email`, `passusr`, `estadoid`) VALUES
(1, 'Miguel Angel', '2014-04-27', '2014-04-27', 'maccgeo@hotmail.com', 'e37e520c9caa8cac5714ed1761894437a05ba4c9', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sysusuarioperfil`
--

CREATE TABLE IF NOT EXISTS `sysusuarioperfil` (
  `id` int(11) NOT NULL,
  `SysUsuarioId` int(11) DEFAULT NULL,
  `SysPerfilId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_38` (`SysPerfilId`),
  KEY `FK_Reference_39` (`SysUsuarioId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `sysusuarioperfil`
--

INSERT INTO `sysusuarioperfil` (`id`, `SysUsuarioId`, `SysPerfilId`) VALUES
(0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoestado`
--

CREATE TABLE IF NOT EXISTS `tipoestado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='1: Estados Generales de Mantenimientos\r\nvalores\r\n0';

--
-- Volcar la base de datos para la tabla `tipoestado`
--

INSERT INTO `tipoestado` (`id`, `nombre`) VALUES
(1, 'Estados de Usuario'),
(2, 'Estados de Proyecto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoflujo`
--

CREATE TABLE IF NOT EXISTS `tipoflujo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `tipoflujo`
--

INSERT INTO `tipoflujo` (`id`, `nombre`) VALUES
(1, 'Flujo Principal'),
(2, 'Flujo Alternativo'),
(3, 'Exception');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
