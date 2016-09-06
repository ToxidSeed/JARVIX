-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 06, 2016 at 08:17 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `requerimentsmanager`
--
CREATE DATABASE `requerimentsmanager` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `requerimentsmanager`;

-- --------------------------------------------------------

--
-- Table structure for table `alcance`
--

CREATE TABLE IF NOT EXISTS `alcance` (
  `id` int(11) NOT NULL,
  `fechaCierre` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alcance`
--


-- --------------------------------------------------------

--
-- Table structure for table `alcanceprocesos`
--

CREATE TABLE IF NOT EXISTS `alcanceprocesos` (
  `id` int(11) NOT NULL,
  `alcanceId` int(11) DEFAULT NULL,
  `tipoId` int(11) DEFAULT NULL,
  `alcanceItemId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_48` (`alcanceId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alcanceprocesos`
--


-- --------------------------------------------------------

--
-- Table structure for table `aplicacion`
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
-- Dumping data for table `aplicacion`
--

INSERT INTO `aplicacion` (`id`, `nombre`, `rutaPublicacion`, `baseDatos`, `servidor`, `userName`, `password`, `fechaRegistro`, `fechaModificacion`, `estadoId`) VALUES
(1, 'Finanzas Personales', 'c:\\xampp\\htdocs\\', 'FinanzasPersonales', 'localhost', 'root', '123456', NULL, NULL, 1),
(3, 'BrainStorm', 'c:\\xampp\\htdocs\\', 'BrainStorm', 'localhost', '', '', NULL, '2014-04-26 14:57:10', 1),
(4, 'Activo Fijo', 'c:\\xampp\\htdocs', '', '', '', '', '2014-04-26 15:01:38', '2014-04-27 17:40:47', 0),
(5, 'Jarvix - Project Manager', '', '', '', '', '', '2015-05-10 02:35:33', '2015-05-10 02:35:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comentario`
--

CREATE TABLE IF NOT EXISTS `comentario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` int(11) DEFAULT NULL COMMENT '1: ProcesoControlPropiedad',
  `IdReferencia` int(11) DEFAULT NULL,
  `texto` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `comentario`
--

INSERT INTO `comentario` (`id`, `tipo`, `IdReferencia`, `texto`) VALUES
(1, 1, 10, 'scasdasdads'),
(2, 1, 10, '<span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: justify;">"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"</span>'),
(3, 1, 10, '<span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: justify;"><font color="#ff9900">"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo</font> inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"</span>'),
(4, 1, 10, '<span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; line-height: 20px; text-align: justify;"><font size="2"><font color="#ff0000">"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum</font> et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat."</font></span><br>'),
(5, 1, 10, 'dsadsad'),
(6, 1, 10, '11111111111111'),
(7, 2, 6, '555555555555');

-- --------------------------------------------------------

--
-- Table structure for table `control`
--

CREATE TABLE IF NOT EXISTS `control` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaUltAct` datetime DEFAULT NULL,
  `estadoId` int(11) DEFAULT NULL,
  `tecnologiaid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FK_CTRL_EST` (`estadoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=288 ;

--
-- Dumping data for table `control`
--

INSERT INTO `control` (`id`, `nombre`, `fechaRegistro`, `fechaUltAct`, `estadoId`, `tecnologiaid`) VALUES
(287, 'TextField', '2015-10-17 19:55:07', '2016-08-19 17:09:34', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `controlevento`
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
-- Dumping data for table `controlevento`
--

INSERT INTO `controlevento` (`id`, `ControlId`, `EventoId`, `FechaRegistro`) VALUES
(1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `controlpropiedad`
--

CREATE TABLE IF NOT EXISTS `controlpropiedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ControlId` int(11) DEFAULT NULL,
  `PropiedadId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDXU_Unique` (`ControlId`,`PropiedadId`),
  KEY `FK_FK_CTRLPROP_PROP` (`PropiedadId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `controlpropiedad`
--

INSERT INTO `controlpropiedad` (`id`, `ControlId`, `PropiedadId`) VALUES
(6, 1, 2),
(5, 1, 1),
(7, 2, 2),
(8, 2, 1),
(9, 3, 1),
(10, 6, 1),
(11, 7, 1),
(12, 7, 2),
(13, 8, 1),
(14, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detallealcance`
--

CREATE TABLE IF NOT EXISTS `detallealcance` (
  `id` int(11) NOT NULL,
  `alcanceId` int(11) DEFAULT NULL,
  `tipoItemId` int(11) DEFAULT NULL,
  `ItemId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_48` (`alcanceId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detallealcance`
--


-- --------------------------------------------------------

--
-- Table structure for table `editor`
--

CREATE TABLE IF NOT EXISTS `editor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `constante` varchar(10) DEFAULT NULL COMMENT '- TEXT\r\n            - BOOLEAN\r\n            - DATE\r\n            - NUMBER\r\n            - LISTVALUES',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `editor`
--

INSERT INTO `editor` (`id`, `constante`) VALUES
(1, 'BOOLEAN'),
(2, 'DATE'),
(3, 'NUMBER'),
(4, 'LISTVALUES');

-- --------------------------------------------------------

--
-- Table structure for table `entrega`
--

CREATE TABLE IF NOT EXISTS `entrega` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proyectoId` int(11) DEFAULT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `alcanceId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_46` (`proyectoId`),
  KEY `FK_Reference_47` (`alcanceId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `entrega`
--


-- --------------------------------------------------------

--
-- Table structure for table `estado`
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
-- Dumping data for table `estado`
--

INSERT INTO `estado` (`id`, `tipoEstadoId`, `nombre`, `abreviatura`) VALUES
(0, 1, 'Inactivo', NULL),
(1, 1, 'Activo', NULL),
(0, 2, 'Registrado', 'Regis'),
(1, 2, 'Aprobado', 'Aprob'),
(2, 2, 'Cancelado', 'Cance'),
(0, 3, 'Registrado', 'Reg'),
(0, 4, 'Registrado', 'Reg');

-- --------------------------------------------------------

--
-- Table structure for table `estadoprocesocontrol`
--

CREATE TABLE IF NOT EXISTS `estadoprocesocontrol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `estadoprocesocontrol`
--


-- --------------------------------------------------------

--
-- Table structure for table `estadoprocesoflujo`
--

CREATE TABLE IF NOT EXISTS `estadoprocesoflujo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(60) DEFAULT NULL,
  `Descripcion` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `estadoprocesoflujo`
--


-- --------------------------------------------------------

--
-- Table structure for table `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaUltAct` datetime DEFAULT NULL,
  `controlid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `evento`
--

INSERT INTO `evento` (`id`, `nombre`, `fechaRegistro`, `fechaUltAct`, `controlid`) VALUES
(1, 'Click', NULL, NULL, 287),
(2, 'DoubleClick', NULL, NULL, 287),
(3, 'TextChanged', NULL, NULL, 287);

-- --------------------------------------------------------

--
-- Table structure for table `formato`
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
-- Dumping data for table `formato`
--


-- --------------------------------------------------------

--
-- Table structure for table `participante`
--

CREATE TABLE IF NOT EXISTS `participante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proyectoId` int(11) DEFAULT NULL,
  `sysUsuarioId` int(11) DEFAULT NULL,
  `flgProyectoDefault` bit(1) DEFAULT NULL COMMENT '1: Valor que Indica si es el proyecto Actual.\r\n            0: Indica que es un proyecto al cual esta asociado\r\n            ',
  PRIMARY KEY (`id`),
  KEY `FK_FK_PROYACTDES_PROY` (`proyectoId`),
  KEY `FK_FK_PROYACTDES_SYSUSR` (`sysUsuarioId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `participante`
--

INSERT INTO `participante` (`id`, `proyectoId`, `sysUsuarioId`, `flgProyectoDefault`) VALUES
(19, 9, 1, b'0'),
(18, 8, 1, b'0'),
(20, 11, 1, b'0'),
(21, 4, 1, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `pasoflujo`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=968 ;

--
-- Dumping data for table `pasoflujo`
--

INSERT INTO `pasoflujo` (`id`, `ProcesoFlujoId`, `NumeroFlujo`, `Descripcion`, `TipoFlujoId`, `NumeroPaso`, `PasoFlujoReferenciaId`, `Responsable`) VALUES
(583, 410, 1, 'okkk', 1, 1, NULL, NULL),
(584, 410, 1, 'ikkkkk', 2, 1, 583, NULL),
(585, 410, 1, 'lkkk', 2, 3, 583, NULL),
(586, 410, 1, 'ikkkko', 2, 2, 584, NULL),
(587, 411, 1, 'ikkkk', 1, 1, NULL, NULL),
(588, 411, 1, 'uhhh', 1, 2, NULL, NULL),
(589, 411, 1, 'jjjjj', 2, 1, 588, NULL),
(590, 411, 1, 'ajjj', 2, 3, 588, NULL),
(591, 411, 1, 'poll', 2, 2, 589, NULL),
(592, 412, 1, 'okkk', 1, 1, NULL, NULL),
(593, 412, 1, 'ikkkk', 1, 2, NULL, NULL),
(594, 412, 1, 'ukkk', 1, 4, NULL, NULL),
(595, 412, 1, 'alt_ikkk', 2, 1, 593, NULL),
(596, 412, 1, 'iokkk', 2, 4, 593, NULL),
(597, 412, 1, 'lkkkk', 2, 2, 593, NULL),
(598, 412, 1, 'oiii', 1, 3, NULL, NULL),
(599, 412, 1, 'klll', 2, 3, 593, NULL),
(600, 412, 1, 'ikkkkppll', 3, 1, 594, NULL),
(601, 412, 1, 'loooo', 3, 2, 594, NULL),
(602, 412, 1, 'ujjjj', 3, 3, 594, NULL),
(603, 412, 1, 'okkkk', 3, 0, 594, NULL),
(604, 412, 0, 'lkkkk', 3, 0, 594, NULL),
(605, 412, 0, 'lkkkk', 2, 0, 594, NULL),
(606, 412, 0, 'kjjj', 2, 0, 594, NULL),
(607, 413, 1, 'eee', 1, 1, NULL, NULL),
(608, 413, 1, 'eqqq', 1, 2, NULL, NULL),
(609, 413, 1, 'eaarrr', 1, 3, NULL, NULL),
(610, 413, 1, 'okkkkk', 1, 4, NULL, NULL),
(611, 413, 1, 'lkkkkk', 2, 1, 608, NULL),
(612, 413, 1, 'ijjjjj', 2, 2, 608, NULL),
(613, 413, 1, 'jkkkk', 2, 3, 608, NULL),
(614, 413, 0, 'kkkkk', 2, 0, 608, NULL),
(615, 414, 1, 'okkkk', 1, 1, NULL, NULL),
(616, 414, 1, 'okkk2', 1, 2, NULL, NULL),
(617, 414, 1, 'okkk3', 1, 3, NULL, NULL),
(618, 414, 1, 'alternativo act 1', 2, 1, 617, NULL),
(619, 414, 0, 'alternativo okk', 2, 0, 617, NULL),
(620, 415, 1, 'ssssaaaa', 1, 1, NULL, NULL),
(621, 415, 1, 'ssss', 2, 1, 620, NULL),
(622, 415, 0, 'liiaaaa', 2, 0, 621, NULL),
(623, 416, 1, 'loala', 1, 1, NULL, NULL),
(624, 416, 1, 'ssss', 2, 1, 623, NULL),
(625, 416, 0, 'descripcion', 2, 0, 623, NULL),
(626, 417, 1, 'dddddd', 1, 1, NULL, NULL),
(627, 417, 1, 'ddddaaaa', 2, 1, 626, NULL),
(628, 417, 0, 'flujo2', 2, 0, 626, NULL),
(629, 418, 1, 'paso 1', 1, 1, NULL, NULL),
(630, 418, 1, 'alternative', 2, 1, 629, NULL),
(631, 418, 0, 'alternativr 2', 2, 0, 629, NULL),
(632, 419, 1, 'klll', 1, 1, NULL, NULL),
(633, 419, 1, 'juuuu', 2, 1, 632, NULL),
(634, 419, 0, 'poool', 2, 0, 632, NULL),
(635, 420, 1, 'Paso 1', 1, 1, NULL, NULL),
(636, 420, 1, 'Paso 2', 1, 2, NULL, NULL),
(637, 420, 1, 'Paso 3', 1, 3, NULL, NULL),
(638, 420, 1, 'Flujo Alternativo', 2, 1, 636, NULL),
(639, 420, 0, 'Flujo Alternativo 2', 2, 0, 636, NULL),
(640, 421, 1, 'paso 1', 1, 1, NULL, NULL),
(641, 421, 1, 'paso 2', 1, 2, NULL, NULL),
(642, 421, 1, 'alterno 1', 2, 1, 641, NULL),
(643, 421, 0, 'alterno', 2, 0, 641, NULL),
(644, 422, 1, 'sss', 1, 1, NULL, NULL),
(645, 422, 1, 'sss', 2, 1, 644, NULL),
(646, 422, 0, 'zzzz', 2, 0, 644, NULL),
(647, 423, 1, 'dddd', 1, 1, NULL, NULL),
(648, 423, 1, 'dddd', 2, 1, 647, NULL),
(649, 424, 1, 'Paso 1', 1, 1, NULL, NULL),
(650, 424, 1, 'aaa', 2, 1, 649, NULL),
(651, 424, 2, 'sss', 2, 1, 649, NULL),
(652, 424, 1, 'Paso 2', 1, 2, NULL, NULL),
(653, 424, 3, 'Alernativo Paso 3', 2, 1, 652, NULL),
(654, 424, 4, 'Alternativo Paso 1', 2, 1, 649, NULL),
(655, 425, 1, 'Paso 1', 1, 1, NULL, NULL),
(656, 425, 1, 'Flujo 1', 2, 1, 655, NULL),
(657, 425, 2, 'Flujo 1', 2, 1, 655, NULL),
(658, 426, 1, 'ss', 1, 1, NULL, NULL),
(659, 426, 1, 'asss', 2, 1, 658, NULL),
(660, 426, 2, '2', 2, 1, 658, NULL),
(661, 426, 3, 'sss', 2, 1, 658, NULL),
(662, 426, 4, 'sss', 2, 1, 658, NULL),
(663, 426, 4, 'ss', 2, 2, 658, NULL),
(664, 427, 1, 'ss', 1, 1, NULL, NULL),
(665, 427, 1, 'ss', 2, 1, 664, NULL),
(666, 427, 2, 'sss', 2, 1, 664, NULL),
(667, 427, 3, 'sss', 2, 1, 664, NULL),
(668, 427, 4, 'sss', 2, 1, 664, NULL),
(669, 427, 5, 'ss', 2, 1, 664, NULL),
(670, 427, 5, 'sss', 2, 1, 664, NULL),
(671, 427, 5, 'ssss', 2, 1, 664, NULL),
(672, 427, 5, 'ss', 2, 1, 664, NULL),
(673, 427, 5, 'sss', 2, 1, 664, NULL),
(674, 427, 1, 'sss', 1, 2, NULL, NULL),
(675, 427, 3, 'ddd', 2, 1, 674, NULL),
(676, 427, 0, 'paso 4', 2, 0, 674, NULL),
(677, 428, 1, 'pas o 1', 1, 1, NULL, NULL),
(678, 428, 3, 'ss', 2, 1, 677, NULL),
(679, 428, 1, 'sss', 1, 2, NULL, NULL),
(680, 428, 5, 'sss', 2, 1, 679, NULL),
(681, 428, 0, 'sss', 2, 0, 677, NULL),
(682, 428, 0, 'ddd', 2, 0, 677, NULL),
(683, 428, 0, 'ss', 2, 0, 677, NULL),
(684, 429, 1, 'ss', 1, 1, NULL, NULL),
(685, 429, 1, 'ss', 1, 2, NULL, NULL),
(686, 429, 1, 'sss', 2, 1, 684, NULL),
(687, 429, 0, 'ss', 2, 0, 684, NULL),
(688, 429, 0, 'sss', 2, 0, 684, NULL),
(689, 429, 0, 'dd', 2, 0, 684, NULL),
(690, 429, 0, 'ss', 2, 0, 684, NULL),
(691, 429, 0, 'ss', 2, 0, 684, NULL),
(692, 429, 0, 'ss', 2, 0, 684, NULL),
(693, 429, 0, 'ddd', 2, 0, 684, NULL),
(694, 429, 0, 'sss', 2, 0, 684, NULL),
(695, 429, 0, 'ss', 2, 0, 684, NULL),
(696, 430, 1, 'ss', 1, 1, NULL, NULL),
(697, 430, 1, 'ss', 2, 1, 696, NULL),
(698, 430, 0, 'sss', 2, 0, 696, NULL),
(699, 431, 1, 'ss', 1, 1, NULL, NULL),
(700, 431, 1, 'ss', 2, 1, 699, NULL),
(701, 431, 0, 'ss', 2, 0, 699, NULL),
(702, 432, 1, 'ss', 1, 1, NULL, NULL),
(703, 432, 4, 'ss', 2, 1, 702, NULL),
(704, 432, 2, 'ssss', 2, 0, 702, NULL),
(705, 432, 1, 'sss', 2, 0, 702, NULL),
(706, 432, 0, 'sss', 2, 0, 702, NULL),
(707, 433, 1, 'ss', 1, 1, NULL, NULL),
(708, 433, 3, 'ss', 2, 1, 707, NULL),
(709, 433, 1, 'sssa', 2, 0, 707, NULL),
(710, 433, 0, 'ss', 2, 0, 707, NULL),
(711, 434, 1, 'ss', 1, 1, NULL, NULL),
(712, 434, 2, 'ss', 2, 1, 711, NULL),
(713, 434, 0, 'ssaa', 2, 0, 711, NULL),
(714, 435, 1, 'ss', 1, 1, NULL, NULL),
(715, 435, 1, 'ss', 2, 1, 714, NULL),
(716, 435, 1, 'saaa', 2, 0, 714, NULL),
(717, 435, 2, 'hola', 2, 0, 714, NULL),
(718, 435, 1, 'Numero Flujo 3', 2, 0, 714, NULL),
(719, 435, 2, 'Numero Flujo 4', 2, 0, 714, NULL),
(720, 436, 1, 'ss', 1, 1, NULL, NULL),
(721, 436, 1, 'ss', 2, 1, 720, NULL),
(722, 436, 1, 'rrff', 2, 0, 720, NULL),
(723, 436, 2, 'aaa', 2, 0, 720, NULL),
(724, 437, 1, 's', 1, 1, NULL, NULL),
(725, 437, 2, 'saa', 2, 1, 724, NULL),
(726, 437, 1, 'saaee', 2, 0, 724, NULL),
(727, 437, 1, 'thhh', 2, 0, 724, NULL),
(728, 437, 3, 'ssaa', 2, 0, 724, NULL),
(729, 438, 1, 'ss', 1, 1, NULL, NULL),
(730, 438, 1, 'ss', 2, 1, 729, NULL),
(731, 438, 1, 'saa', 2, 0, 729, NULL),
(732, 438, 2, 'aa', 2, 0, 729, NULL),
(733, 439, 1, 's', 1, 1, NULL, NULL),
(734, 439, 1, 'ss', 2, 1, 733, NULL),
(735, 439, 1, 'saaa', 2, 0, 733, NULL),
(736, 439, 2, 'aaeee', 2, 0, 733, NULL),
(737, 440, 1, 'aa', 1, 1, NULL, NULL),
(738, 440, 1, 'aa', 2, 1, 737, NULL),
(739, 440, 1, 'aee', 2, 0, 737, NULL),
(740, 440, 2, 'aeee', 2, 0, 737, NULL),
(741, 441, 1, 's', 1, 1, NULL, NULL),
(742, 441, 5, 'a', 2, 1, 741, NULL),
(743, 441, 5, 'saee', 2, 0, 741, NULL),
(744, 441, 5, 'aee', 2, 0, 741, NULL),
(745, 441, 3, 'aee', 2, 0, 741, NULL),
(746, 442, 1, 'aaa', 1, 1, NULL, NULL),
(747, 442, 2, 'aa', 2, 1, 746, NULL),
(748, 442, 1, 'sea', 2, 0, 746, NULL),
(749, 442, 1, 'eeaa', 2, 0, 746, NULL),
(750, 442, 3, 'aeea', 2, 0, 746, NULL),
(751, 443, 1, 'aa', 1, 1, NULL, NULL),
(752, 443, 1, 'a', 2, 1, 751, NULL),
(753, 443, 1, 'aa', 2, 0, 751, NULL),
(754, 443, 2, 'eaass', 2, 0, 751, NULL),
(755, 444, 1, 'ss', 1, 1, NULL, NULL),
(756, 444, 1, 'aa', 2, 1, 755, NULL),
(757, 444, 1, 'aee', 2, 0, 755, NULL),
(758, 444, 2, 'eaas', 2, 0, 755, NULL),
(759, 444, 1, 'sss', 2, 0, 755, NULL),
(760, 444, 3, 'aeee', 2, 0, 755, NULL),
(761, 445, 1, 'aa', 1, 1, NULL, NULL),
(762, 445, 1, 'aa', 2, 1, 761, NULL),
(763, 445, 1, 'aee', 2, 0, 761, NULL),
(764, 445, 3, 'aaee', 2, 0, 761, NULL),
(765, 446, 1, 'aa', 1, 1, NULL, NULL),
(766, 446, 2, 'aa', 2, 1, 765, NULL),
(767, 446, 2, 'aee', 2, 0, 765, NULL),
(768, 446, 3, 'aae', 2, 0, 765, NULL),
(769, 447, 1, 'aa', 1, 1, NULL, NULL),
(770, 447, 1, 'sss', 1, 2, NULL, NULL),
(771, 447, 1, 'sss', 1, 3, NULL, NULL),
(772, 447, 1, 'ssss', 1, 4, NULL, NULL),
(773, 447, 1, 'sss', 1, 5, NULL, NULL),
(774, 447, 1, 'sss', 1, 6, NULL, NULL),
(775, 448, 1, 'ss', 1, 1, NULL, NULL),
(776, 448, 1, 'ssa', 2, 1, 775, NULL),
(777, 448, 2, 'aee', 2, 1, 775, NULL),
(778, 448, 3, 'saee', 2, 1, 775, NULL),
(779, 448, 4, 'aaaeee', 2, 1, 775, NULL),
(780, 448, 1, 'sss', 1, 2, NULL, NULL),
(781, 448, 1, 'zsaa', 2, 1, 780, NULL),
(782, 448, 1, 'sss', 1, 3, NULL, NULL),
(783, 448, 1, 'ssa', 2, 1, 782, NULL),
(784, 448, 1, 'sss', 2, 2, 775, NULL),
(785, 448, 2, 'ss', 2, 2, 775, NULL),
(786, 448, 3, 'aa', 2, 2, 775, NULL),
(787, 448, 4, 'aaa', 2, 2, 775, NULL),
(788, 448, 1, 'aaaee', 2, 3, 780, NULL),
(789, 448, 2, 'sss', 2, 1, 780, NULL),
(790, 449, 1, 'sssss', 1, 1, NULL, NULL),
(791, 449, 1, 'sfsdfsdf', 1, 2, NULL, NULL),
(792, 449, 1, 'aaa', 3, 1, 791, NULL),
(793, 449, 1, 'ss', 3, 1, 791, NULL),
(794, 450, 1, 'zz', 1, 1, NULL, NULL),
(795, 450, 1, 'zz', 3, 1, 794, NULL),
(796, 450, 2, 'zz', 3, 1, 794, NULL),
(797, 450, 3, 'zzz', 3, 1, 794, NULL),
(798, 450, 1, 'zzz', 1, 2, NULL, NULL),
(799, 450, 1, 'zzz', 1, 3, NULL, NULL),
(800, 450, 1, 'zzz', 3, 1, 799, NULL),
(801, 450, 2, 'sss', 3, 1, 799, NULL),
(802, 450, 1, 'ss', 2, 1, 799, NULL),
(803, 451, 1, 'gg', 1, 1, NULL, NULL),
(804, 451, 1, 'ddd', 1, 2, NULL, NULL),
(805, 452, 1, 'd', 1, 1, NULL, NULL),
(806, 452, 1, 'dd', 1, 2, NULL, NULL),
(807, 453, 1, 'sss', 1, 1, NULL, NULL),
(813, 454, 1, 'ss', 1, 1, NULL, NULL),
(812, 453, 1, 'wwww', 1, 3, NULL, NULL),
(816, 455, 1, 's', 1, 1, NULL, NULL),
(815, 454, 1, 'sss', 1, 3, NULL, NULL),
(819, 456, 1, 'ss', 1, 1, NULL, NULL),
(818, 455, 1, 'sss', 1, 3, NULL, NULL),
(820, 457, 1, 'ss', 1, 1, NULL, NULL),
(821, 457, 1, 'ss', 1, 2, NULL, NULL),
(822, 458, 1, 'dd', 1, 1, NULL, NULL),
(826, 459, 1, 'ss', 1, 1, NULL, NULL),
(825, 458, 1, 'wewe', 1, 3, NULL, NULL),
(833, 459, 1, 'aaa', 1, 8, NULL, NULL),
(834, 460, 1, 'ww', 1, 1, NULL, NULL),
(839, 461, 2, 'ss', 1, 1, NULL, NULL),
(838, 460, 1, 'sss', 1, 5, NULL, NULL),
(868, 462, 2, 'ss', 1, 2, NULL, NULL),
(859, 461, 2, 'aaa', 1, 3, NULL, NULL),
(851, 461, 2, 'aaa', 1, 2, NULL, NULL),
(870, 462, 2, 'sss', 1, 4, NULL, NULL),
(869, 462, 2, 'ss', 1, 3, NULL, NULL),
(860, 461, 2, 'aaa', 1, 4, NULL, NULL),
(866, 462, 2, 'ss', 1, 1, NULL, NULL),
(871, 462, 2, 'sss', 2, 1, 868, NULL),
(879, 463, 2, 'ewewqewq', 1, 1, NULL, NULL),
(873, 462, 2, 'sss', 2, 2, 868, NULL),
(874, 462, 3, 'sssssssssssss', 2, 1, 868, NULL),
(875, 462, 4, 'ssssssssssss', 2, 1, 868, NULL),
(881, 463, 2, 'eqweqwe', 1, 3, NULL, NULL),
(880, 463, 2, 'ewqeqwe', 1, 2, NULL, NULL),
(878, 462, 3, 'ssss', 2, 2, 868, NULL),
(882, 463, 2, 'ewqeqwewqe', 1, 4, NULL, NULL),
(883, 463, 2, 'qweqweqwe', 1, 5, NULL, NULL),
(899, 463, 1, 'dadasd', 2, 3, 880, NULL),
(901, 464, 2, 'sdasda', 1, 1, NULL, NULL),
(902, 464, 2, 'dasdasd', 1, 2, NULL, NULL),
(888, 463, 2, 'dsadsad', 2, 1, 880, NULL),
(889, 463, 2, 'dsadas', 2, 2, 880, NULL),
(890, 463, 2, 'dasdsadsa', 2, 3, 880, NULL),
(891, 463, 2, 'dsadasdsa', 2, 4, 880, NULL),
(897, 463, 1, 'dasdasd', 2, 2, 880, NULL),
(903, 464, 2, 'dsadad', 1, 3, NULL, NULL),
(905, 465, 2, 'dasda', 1, 1, NULL, NULL),
(906, 465, 2, 'asdasd', 1, 2, NULL, NULL),
(909, 466, 1, 'DASDASD', 1, 1, NULL, NULL),
(908, 465, 2, 'dasdadad', 1, 3, NULL, NULL),
(910, 466, 1, 'SADAD', 1, 2, NULL, NULL),
(911, 466, 1, 'DSADASD', 1, 3, NULL, NULL),
(913, 466, 1, 'DADA', 1, 4, NULL, NULL),
(914, 466, 1, 'DASDASD', 1, 5, NULL, NULL),
(915, 466, 1, 'DSADAD', 2, 2, 910, NULL),
(919, 467, 1, 'dsadas', 1, 1, NULL, NULL),
(917, 466, 1, 'DASDSA', 2, 3, 910, NULL),
(918, 466, 1, 'DASDASD', 2, 4, 910, NULL),
(920, 467, 1, 'asdasd', 1, 5, NULL, NULL),
(921, 467, 1, 'dasdasd', 1, 6, NULL, NULL),
(955, 469, 1, 'dsadsad', 1, 1, NULL, NULL),
(953, 468, 1, 'eeee', 1, 2, NULL, NULL),
(952, 468, 1, 'eeeee', 1, 1, NULL, NULL),
(951, 467, 1, 'Inserted 2', 1, 3, NULL, NULL),
(936, 467, 1, 'fdsfsd', 1, 7, NULL, NULL),
(937, 467, 1, 'fsdfsdf', 1, 8, NULL, NULL),
(949, 467, 1, 'Flujo Alternativo Inserted', 2, 1, 948, NULL),
(950, 467, 1, 'Exception a Inserted', 3, 1, 948, NULL),
(948, 467, 1, 'Inserted', 1, 4, NULL, NULL),
(947, 467, 1, 'sdasd', 1, 2, NULL, NULL),
(956, 469, 1, 'dasdasd', 1, 2, NULL, NULL),
(957, 469, 1, 'dasdasd', 1, 3, NULL, NULL),
(958, 470, 1, 'sdfsdfdsfdsf', 1, 1, NULL, NULL),
(959, 470, 1, 'fsdfsdfdsf', 1, 2, NULL, NULL),
(960, 470, 1, 'sdfsfsf', 1, 3, NULL, NULL),
(961, 470, 1, 'dasdasd', 1, 5, NULL, NULL),
(962, 470, 1, 'dsadad', 1, 4, NULL, NULL),
(963, 470, 1, 'dadasda', 3, 1, 962, NULL),
(964, 471, 1, '"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia v', 1, 1, NULL, NULL),
(965, 471, 1, '"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia v', 1, 2, NULL, NULL),
(966, 471, 1, '"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia v', 1, 3, NULL, NULL),
(967, 471, 1, 'dadasdsad\nas\nda\nsd\nas\nd\na\nsd\nasd\n', 1, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proceso`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=120 ;

--
-- Dumping data for table `proceso`
--

INSERT INTO `proceso` (`id`, `nombre`, `fechaRegistro`, `AplicacionId`, `fechaUltAct`, `descripcion`, `estadoId`, `proyectoId`, `rutaprototipo`) VALUES
(113, 'Proceso 1', NULL, 5, NULL, NULL, 0, 4, 'http://localhost/RequerimentsManagerSrc/uploads/SaldoDeuda44.png'),
(114, 'Proceso 2', NULL, 5, NULL, NULL, 0, 4, 'http://localhost/RequerimentsManagerSrc/uploads/jeep_drowning_by_yasharse7en.jpg'),
(115, 'Registrar proyecto', NULL, 5, NULL, NULL, 0, 4, NULL),
(116, 'Proceso 2', NULL, 5, NULL, NULL, 0, 4, 'http://localhost/RequerimentsManagerSrc/uploads/CuentaAeropost.png'),
(117, 'Proceso 2', NULL, 5, NULL, NULL, 0, 4, NULL),
(118, 'Registrar proyecto1', NULL, 5, NULL, 'ssss', 0, 4, 'http://localhost/RequerimentsManagerSrc/uploads/SaldoDeuda45.png'),
(119, 'sssss', NULL, 5, NULL, NULL, 0, 4, 'http://localhost/RequerimentsManagerSrc/uploads/CuentaAeropost1.png');

-- --------------------------------------------------------

--
-- Table structure for table `procesocontrol`
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
-- Dumping data for table `procesocontrol`
--

INSERT INTO `procesocontrol` (`id`, `ProcesoId`, `fechaRegistro`, `ControlId`, `EstadoProcesoControlId`, `nombre`, `comentarios`) VALUES
(1, 114, NULL, 287, NULL, 'ss', NULL),
(2, 114, NULL, 287, NULL, 'ss', NULL),
(3, 114, NULL, 287, NULL, 'sss', NULL),
(4, 114, NULL, 287, NULL, 'ss', NULL),
(5, 114, NULL, 287, NULL, 'ss', NULL),
(6, 114, NULL, 287, NULL, 'ss', NULL),
(7, 114, NULL, 287, NULL, 'ss', NULL),
(8, 114, NULL, 287, NULL, 'ss', NULL),
(9, 114, NULL, 287, NULL, 'ss', NULL),
(10, 114, NULL, 287, NULL, 'ss', NULL),
(11, 114, NULL, 287, NULL, 'ss', NULL),
(12, 114, NULL, 287, NULL, 'ss', NULL),
(13, 114, NULL, 0, NULL, '', NULL),
(14, 114, NULL, 287, NULL, 'ss', NULL),
(15, 114, NULL, 0, NULL, '', NULL),
(16, 118, NULL, 287, NULL, 'ssss', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `procesocontrolevento`
--

CREATE TABLE IF NOT EXISTS `procesocontrolevento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ProcesoControlId` int(11) DEFAULT NULL,
  `Valor` varchar(60) DEFAULT NULL,
  `EventoId` int(11) DEFAULT NULL,
  `ControlId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_33` (`ProcesoControlId`),
  KEY `FK_Reference_35` (`EventoId`),
  KEY `FK_Reference_45` (`ControlId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `procesocontrolevento`
--

INSERT INTO `procesocontrolevento` (`id`, `ProcesoControlId`, `Valor`, `EventoId`, `ControlId`) VALUES
(1, 1, NULL, 1, 287),
(2, 1, NULL, 3, 287),
(3, 2, NULL, 1, 287),
(4, 14, NULL, 1, 287),
(6, 16, NULL, 1, 287),
(7, 16, NULL, 2, 287);

-- --------------------------------------------------------

--
-- Table structure for table `procesocontrolpropiedad`
--

CREATE TABLE IF NOT EXISTS `procesocontrolpropiedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ProcesoControlId` int(11) DEFAULT NULL,
  `ControlId` int(11) DEFAULT NULL,
  `Valor` varchar(60) DEFAULT NULL,
  `PropiedadId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_30` (`ProcesoControlId`),
  KEY `FK_Reference_34` (`PropiedadId`),
  KEY `FK_Reference_43` (`ControlId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `procesocontrolpropiedad`
--

INSERT INTO `procesocontrolpropiedad` (`id`, `ProcesoControlId`, `ControlId`, `Valor`, `PropiedadId`) VALUES
(1, 1, 287, '', 84),
(2, 2, 287, '', 84),
(3, 7, 287, '', 84),
(4, 8, 287, '', 85),
(5, 9, 287, '', 84),
(6, 11, 287, '', 84),
(7, 12, 287, '', 84),
(8, 3, 287, '', 84),
(9, 3, 287, '', 86),
(10, 16, 287, '0', 84),
(11, 16, 287, '1', 85),
(12, 16, 287, '0', 88),
(13, 16, 287, '100', 86),
(14, 16, 287, '55555', 87),
(15, 16, 287, '21231231', 89),
(16, 16, 287, '', 90);

-- --------------------------------------------------------

--
-- Table structure for table `procesoflujo`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=472 ;

--
-- Dumping data for table `procesoflujo`
--

INSERT INTO `procesoflujo` (`id`, `procesoId`, `nombre`, `descripcion`, `fechaRegistro`, `EstadoProcesoFlujoId`) VALUES
(385, 67, 'FLUJO 1', 'DESCRIPCION FLUJO 1', NULL, 0),
(386, 67, 'dddd', 'sssss', NULL, 0),
(387, 68, 'ss', 'ss', NULL, 0),
(388, 69, 'kkkk', 'kkkk', NULL, 0),
(389, 70, 'nnnn', 'jj', NULL, 0),
(390, 70, 'UUUUU', 'UUUUU', NULL, 0),
(391, 70, 'jj', 'kk', NULL, 0),
(392, 70, 'ssss', 'ssss', NULL, 0),
(393, 70, 'sss', 'sss', NULL, 0),
(394, 70, 'sss', 'sss', NULL, 0),
(395, 71, 'ssss', 'ssss', NULL, 0),
(396, 72, 'xxx', 'xxx', NULL, 0),
(397, 73, 'sss', 'ss', NULL, 0),
(398, 74, 'Nombre', 'Descripcion', NULL, 0),
(399, 74, 'ddd', 'ddd', NULL, 0),
(400, 74, 'ssss', 'ss', NULL, 0),
(401, 75, 'ss', 'sss', NULL, 0),
(402, 76, 'sss', 'asddd', NULL, 0),
(403, 77, 'sss', 'ss', NULL, 0),
(404, 78, 'ssss', 'ssss', NULL, 0),
(405, 0, 'sss', 'sss', NULL, 0),
(406, 80, 'ssss', 'sss', NULL, 0),
(407, 81, 'hhhhhhh', 'ffrrr', NULL, 0),
(408, 82, 'sss', 'sss', NULL, 0),
(409, 83, 'ikkk', 'uujjj', NULL, 0),
(410, 83, 'kkkk', 'jiiii', NULL, 0),
(411, 83, 'jhhh', 'uuu', NULL, 0),
(412, 84, 'ikkk', 'ikkkk', NULL, 0),
(413, 84, 'jjjj', 'jjj', NULL, 0),
(414, 84, 'Nombre ', 'descripcion', NULL, 0),
(415, 85, 'ssss', 'ssssss', NULL, 0),
(416, 86, 'slkkk', 'sss', NULL, 0),
(417, 87, 'dddddd', 'dddd', NULL, 0),
(418, 87, 'jjjjj', 'jhhh', NULL, 0),
(419, 88, 'bbbb', 'yjjj', NULL, 0),
(420, 89, 'Nombre', 'Descripcion', NULL, 0),
(421, 89, 'Nombre 1', 'Descripcion 1', NULL, 0),
(422, 89, 'flujo 3', 'descripcio 3', NULL, 0),
(423, 89, 'ddd', 'ddd', NULL, 0),
(424, 90, 'ee', 'ee', NULL, 0),
(425, 90, 'ss', 'ss', NULL, 0),
(426, 90, 's', 's', NULL, 0),
(427, 90, 'ss', 'ss', NULL, 0),
(428, 90, 'www', 'ww', NULL, 0),
(429, 91, 's', 's', NULL, 0),
(430, 91, 's', 'ss', NULL, 0),
(431, 91, 'ss', 'ss', NULL, 0),
(432, 91, 's', 's', NULL, 0),
(433, 91, 'ss', 'ss', NULL, 0),
(434, 91, 's', 's', NULL, 0),
(435, 91, 'dd', 'dd', NULL, 0),
(436, 91, 'ss', 'ss', NULL, 0),
(437, 91, 'ss', 'ss', NULL, 0),
(438, 91, 'd', 'd', NULL, 0),
(439, 91, 'ss', 'ss', NULL, 0),
(440, 91, 's', 's', NULL, 0),
(441, 91, 's', 's', NULL, 0),
(442, 91, 's', 's', NULL, 0),
(443, 91, 'a', 'a', NULL, 0),
(444, 91, 's', 's', NULL, 0),
(445, 91, 'ss', 'sss', NULL, 0),
(446, 91, 's', 's', NULL, 0),
(447, 92, 'ss', 'ss', NULL, 0),
(448, 92, 'ss', 'ss', NULL, 0),
(449, 93, 's', 'ss', NULL, 0),
(450, 93, 'z', 'z', NULL, 0),
(451, 94, 'dd', 'ddd', NULL, 0),
(452, 95, 'd', 'd', NULL, 0),
(453, 96, 's', 's', NULL, 0),
(454, 97, 'ss', 'ss', NULL, 0),
(455, 98, 's', 's', NULL, 0),
(456, 99, 'ss', 'ss', NULL, 0),
(457, 100, 'ss', 'ss', NULL, 0),
(458, 102, 'd', 'd', NULL, 0),
(459, 102, 's', 's', NULL, 0),
(460, 103, 'w', 'w', NULL, 0),
(461, 104, 's', 's', NULL, 0),
(462, 105, 's', 's', NULL, 0),
(463, 105, 'wewewe', 'wewew', NULL, 0),
(464, 105, 'adasd', 'sdasd', NULL, 0),
(465, 105, 'asdasd', 'dasd', NULL, 0),
(466, 105, 'ASDASD', 'DASDAD', NULL, 0),
(467, 105, 'sdasda', 'dsada', NULL, 0),
(468, 108, 'eee', 'eee', NULL, 0),
(469, 0, 'dsadas', 'dasdsa', NULL, 0),
(470, 113, 'fsdf', 'sdfsdf', NULL, 0),
(471, 118, 'dsd', 'asdasd', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `procesoflujodetalle`
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
-- Dumping data for table `procesoflujodetalle`
--


-- --------------------------------------------------------

--
-- Table structure for table `procesopropiedad`
--

CREATE TABLE IF NOT EXISTS `procesopropiedad` (
  `id` int(11) NOT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `procesoId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FK_PROCPROP_PROC` (`procesoId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procesopropiedad`
--


-- --------------------------------------------------------

--
-- Table structure for table `procesorequerimientofuncional`
--

CREATE TABLE IF NOT EXISTS `procesorequerimientofuncional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechaRegistro` datetime DEFAULT NULL,
  `procesoId` int(11) DEFAULT NULL,
  `requerimientoFuncionalId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_FK_PROCREQFUNC_REQFUNC` (`requerimientoFuncionalId`),
  KEY `FK_FK_REQFUNC_PROC` (`procesoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `procesorequerimientofuncional`
--

INSERT INTO `procesorequerimientofuncional` (`id`, `fechaRegistro`, `procesoId`, `requerimientoFuncionalId`) VALUES
(12, NULL, 3, 4),
(13, NULL, 3, 6),
(14, NULL, 3, 3),
(15, NULL, 93, 1),
(16, NULL, 93, 2),
(17, NULL, 0, 2),
(18, NULL, 0, 1),
(19, NULL, 113, 1),
(20, NULL, 113, 2),
(21, NULL, 113, 4),
(22, NULL, 113, 5),
(23, NULL, 114, 4),
(24, NULL, 114, 3);

-- --------------------------------------------------------

--
-- Table structure for table `propiedad`
--

CREATE TABLE IF NOT EXISTS `propiedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaUltAct` datetime DEFAULT NULL,
  `ControlId` int(11) DEFAULT NULL,
  `editorid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_41` (`ControlId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

--
-- Dumping data for table `propiedad`
--

INSERT INTO `propiedad` (`id`, `nombre`, `fechaRegistro`, `fechaUltAct`, `ControlId`, `editorid`) VALUES
(81, 'ss', NULL, NULL, 284, NULL),
(82, 'ss', NULL, NULL, 285, NULL),
(83, 'sss', NULL, NULL, 286, NULL),
(84, 'Enabled', NULL, NULL, 287, 1),
(85, 'hidden', NULL, NULL, 287, 1),
(86, 'width', NULL, NULL, 287, 3),
(87, 'height', NULL, NULL, 287, 3),
(88, 'Readonly', NULL, NULL, 287, 1),
(89, 'ssssss', NULL, NULL, 287, 3),
(90, 'disabled', NULL, NULL, 287, 4);

-- --------------------------------------------------------

--
-- Table structure for table `proyecto`
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
-- Dumping data for table `proyecto`
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
-- Table structure for table `proyectoactualdesarrollo`
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
-- Dumping data for table `proyectoactualdesarrollo`
--


-- --------------------------------------------------------

--
-- Table structure for table `proyectousuario`
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
-- Dumping data for table `proyectousuario`
--

INSERT INTO `proyectousuario` (`id`, `proyectoId`, `sysUsuarioId`, `flgProyectoActual`) VALUES
(1, 3, 1, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `requerimientofuncional`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `requerimientofuncional`
--

INSERT INTO `requerimientofuncional` (`id`, `codigo`, `nombre`, `fechaRegistro`, `fechaModificacion`, `descripcion`, `proyectoId`, `estadoId`, `orden`) VALUES
(1, '', 'Mapeo de UF_SERVICES', '2015-07-02 01:29:27', '2015-07-02 01:29:27', '', 3, 0, 1),
(2, '', 'DD', '2015-07-02 01:29:42', '2015-07-02 01:29:42', 'DD', 3, 0, 1),
(3, '', 'Gestionar Usuarios', '2015-07-08 23:18:29', '2015-07-08 23:18:29', 'Gestionar Usuarios', 3, 0, 1),
(4, '', 'Gestion de Usuarios', '2015-07-08 23:25:52', '2015-07-08 23:25:52', '', 3, 0, 1),
(5, '', 'UF_CUSTOMER', '2015-07-08 23:32:43', '2015-07-08 23:32:43', 'Archivo que se utilizara.', 3, 0, 1),
(6, '', 'sss', '2015-07-08 23:33:54', '2015-07-08 23:33:54', 'sss', 4, 0, 1),
(7, '', 'ss', '2015-07-09 23:04:34', '2015-07-09 23:04:34', 'ss', 4, 0, 1),
(8, '', 'dasdsad', '2015-11-21 13:39:21', '2015-11-21 13:39:21', 'dasdsadasda', 4, 0, 1),
(9, '', 'dssss', '2015-11-21 13:39:30', '2015-11-21 13:39:30', 'ssssss', 4, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sysaplicacion`
--

CREATE TABLE IF NOT EXISTS `sysaplicacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sysaplicacion`
--

INSERT INTO `sysaplicacion` (`id`, `nombre`, `fechaRegistro`) VALUES
(1, 'Requeriments Manager', '2014-03-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sysopcionaplicacion`
--

CREATE TABLE IF NOT EXISTS `sysopcionaplicacion` (
  `id` int(11) NOT NULL,
  `SysAplicacionId` int(11) DEFAULT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `fechaRegistro` date DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  `viewLoader` varchar(150) DEFAULT NULL,
  `flgHabilitado` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_SYSOPCAPL_SYSAPL` (`SysAplicacionId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sysopcionaplicacion`
--

INSERT INTO `sysopcionaplicacion` (`id`, `SysAplicacionId`, `nombre`, `fechaRegistro`, `parentid`, `viewLoader`, `flgHabilitado`) VALUES
(1, 1, 'Controles', '2014-03-02', 9, '/GestionControles/GestionControlesController', 1),
(2, 1, 'Gestion de Eventos', '2014-03-02', NULL, '/GestionEventos/GestionEventosController', 0),
(3, 1, 'Gestion de Propiedades', '2014-03-02', NULL, '/GestionPropiedades/GestionPropiedadesController', 0),
(4, 1, 'Gestion de Formatos', '2014-03-02', NULL, NULL, 0),
(5, 1, 'Aplicaciones', '2014-03-02', NULL, '/GestionAplicaciones/GestionAplicacionesController', 1),
(6, 1, 'Toma de Requerimientos', '2014-03-02', NULL, '/GestionRequerimientos/GestionRequerimientosController', 1),
(7, 1, 'Modelar Requerimientos', '2014-03-02', NULL, '/GestionProcesos/GestionProcesosController', 1),
(0, 1, 'Proyectos', '2014-04-10', NULL, '/GestionProyectos/GestionProyectosController', 1),
(8, 1, 'Tecnologias', NULL, 9, '/Tecnologias/Tecnologias', 1),
(9, 1, 'Catalogos', NULL, NULL, NULL, 1),
(10, 1, 'Reportes', NULL, NULL, NULL, 1),
(11, 1, 'Seguimiento', NULL, 10, 'hola', 1),
(12, 1, 'Entregas', NULL, NULL, NULL, 1),
(13, 1, 'Planificar', NULL, 12, '/GestionEntregas/Entrega', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sysperfil`
--

CREATE TABLE IF NOT EXISTS `sysperfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `fechaActualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sysperfil`
--

INSERT INTO `sysperfil` (`id`, `nombre`, `fechaRegistro`, `fechaActualizacion`) VALUES
(1, 'Gestor', NULL, NULL),
(2, 'Desarrollador', NULL, NULL),
(3, 'Analista', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sysperfilopcionapp`
--

CREATE TABLE IF NOT EXISTS `sysperfilopcionapp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SysPerfilId` int(11) DEFAULT NULL,
  `SysOpcionAplicacionId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_36` (`SysPerfilId`),
  KEY `FK_Reference_37` (`SysOpcionAplicacionId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `sysperfilopcionapp`
--

INSERT INTO `sysperfilopcionapp` (`id`, `SysPerfilId`, `SysOpcionAplicacionId`) VALUES
(1, 1, 0),
(2, 1, 1),
(3, 1, 2),
(4, 1, 3),
(5, 1, 4),
(6, 1, 5),
(7, 1, 6),
(8, 1, 7),
(9, 1, 8),
(10, 1, 9),
(16, 1, 12),
(15, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `sysusuario`
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
-- Dumping data for table `sysusuario`
--

INSERT INTO `sysusuario` (`id`, `nombre`, `fechaRegistro`, `fechaActualizacion`, `email`, `passusr`, `estadoid`) VALUES
(1, 'Miguel Angel', '2014-04-27', '2014-04-27', 'maccgeo@hotmail.com', 'e37e520c9caa8cac5714ed1761894437a05ba4c9', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sysusuarioperfil`
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
-- Dumping data for table `sysusuarioperfil`
--

INSERT INTO `sysusuarioperfil` (`id`, `SysUsuarioId`, `SysPerfilId`) VALUES
(0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tecnologia`
--

CREATE TABLE IF NOT EXISTS `tecnologia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) DEFAULT NULL,
  `estadoId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tecnologia`
--

INSERT INTO `tecnologia` (`id`, `nombre`, `estadoId`) VALUES
(1, 'extjs 3.0', 1),
(2, 'python', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tipoestado`
--

CREATE TABLE IF NOT EXISTS `tipoestado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='1: Estados Generales de Mantenimientos\r\nvalores\r\n0';

--
-- Dumping data for table `tipoestado`
--

INSERT INTO `tipoestado` (`id`, `nombre`) VALUES
(1, 'Estados de Usuario'),
(2, 'Estados de Proyecto'),
(3, 'Estados de Requerimiento'),
(4, 'Estados de Procesos');

-- --------------------------------------------------------

--
-- Table structure for table `tipoflujo`
--

CREATE TABLE IF NOT EXISTS `tipoflujo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tipoflujo`
--

INSERT INTO `tipoflujo` (`id`, `nombre`) VALUES
(1, 'Flujo Principal'),
(2, 'Flujo Alternativo'),
(3, 'Excepcion');

-- --------------------------------------------------------

--
-- Table structure for table `valorpropiedad`
--

CREATE TABLE IF NOT EXISTS `valorpropiedad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(15) DEFAULT NULL,
  `propiedadId` int(11) DEFAULT NULL,
  `flgdefault` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_42` (`propiedadId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=161 ;

--
-- Dumping data for table `valorpropiedad`
--

INSERT INTO `valorpropiedad` (`id`, `Valor`, `propiedadId`, `flgdefault`) VALUES
(6, 'sss', 19, NULL),
(7, 'fsdfsd', 20, NULL),
(8, 'sdasd', 21, NULL),
(9, 'dasdasd', 22, NULL),
(10, 'dsadas', 23, NULL),
(11, 'ss', 24, NULL),
(12, 'dsd', 25, NULL),
(13, 'dsada', 26, NULL),
(14, 'dsd', 27, NULL),
(15, 'ee', 28, NULL),
(16, 'dasdsa', 29, NULL),
(17, 'dasd', 31, NULL),
(18, 'sadasd', 32, NULL),
(19, 'eee', 33, NULL),
(20, 'eee', 34, NULL),
(21, 'eee', 35, NULL),
(22, 'dsds', 1, NULL),
(23, 'dd', 2, NULL),
(24, 'dsds', 3, NULL),
(25, 'sss', 4, NULL),
(26, 'ss', 5, NULL),
(27, 'ddd', 6, NULL),
(28, 'asa', 7, NULL),
(29, 'dsds', 8, NULL),
(30, 'dsds', 9, NULL),
(31, 'ss', 10, NULL),
(32, 'dsds', 11, NULL),
(33, 'dsa', 12, NULL),
(34, 'sss', 13, NULL),
(35, 'dd', 14, NULL),
(36, 'ss', 15, NULL),
(37, 'ss', 16, NULL),
(38, 'd', 17, NULL),
(39, 'sss', 18, NULL),
(40, 'sss', 19, NULL),
(41, 'sss', 20, NULL),
(42, 'ss', 21, NULL),
(43, 'dsad', 22, NULL),
(44, 'sds', 23, NULL),
(45, 'asdas', 24, NULL),
(46, 'ddd', 25, NULL),
(47, 'sdsds', 26, NULL),
(48, 'sss', 27, NULL),
(49, 'sss', 28, NULL),
(50, 'aa', 29, NULL),
(51, 'ddd', 30, NULL),
(52, 'dasdsad', 31, NULL),
(53, 'asdsa', 32, NULL),
(54, 'sss', 33, NULL),
(55, 'sss', 34, NULL),
(56, 'dsds', 35, NULL),
(57, 'sdasd', 36, NULL),
(58, 'ff', 37, NULL),
(59, 'ss', 38, NULL),
(60, 'dsd', 39, NULL),
(61, 'dsd', 40, NULL),
(62, 'sds', 41, NULL),
(63, 'dsd', 42, NULL),
(64, 'ss', 43, NULL),
(65, 'dsd', 44, NULL),
(66, 'sdsd', 45, NULL),
(67, 'ss', 46, NULL),
(68, 'dsds', 47, NULL),
(69, 'ss', 48, NULL),
(70, 'dsds', 49, NULL),
(71, 'dsds', 50, NULL),
(72, 'null', 51, NULL),
(73, NULL, 52, NULL),
(74, 'null', 52, NULL),
(75, 'null', 53, NULL),
(76, 'null', 54, NULL),
(77, 'null', 55, NULL),
(78, NULL, 56, NULL),
(79, 'null', 57, NULL),
(80, 'null', 58, NULL),
(81, 'null', 59, NULL),
(82, NULL, 60, NULL),
(83, NULL, 61, NULL),
(84, 'ss', 62, NULL),
(85, 'sss', 63, NULL),
(86, 'sss', 64, NULL),
(87, 'ssss', 65, NULL),
(88, 'sdsd', 66, NULL),
(89, 'sss', 67, NULL),
(90, 'aaa', 68, NULL),
(91, 'eeddd', 69, NULL),
(92, 'dd', 70, NULL),
(93, 'eedd', 71, NULL),
(94, 'ddd', 71, NULL),
(95, 'ff', 72, NULL),
(96, 'dddd', 72, NULL),
(97, 'dd', 73, NULL),
(102, 'ss', 76, NULL),
(100, 'sss', 74, NULL),
(103, 'sss', 77, NULL),
(104, 'sss', 78, NULL),
(105, 'sss', 79, NULL),
(107, 'sss', 80, NULL),
(108, 'ss', 80, NULL),
(109, 'sss', 80, NULL),
(110, 'sss', 80, NULL),
(111, 'ss', 81, NULL),
(112, 'sss', 82, NULL),
(113, 'ss', 83, NULL),
(114, 'true', 84, 0),
(155, 'false', 84, 1),
(158, 'hola', 90, 0),
(159, 'buenos dias', 90, 0),
(160, 'buenas noches', 90, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
