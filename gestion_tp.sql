-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 29-08-2025 a las 13:31:09
-- Versión del servidor: 5.7.11
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_tp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinos`
--

CREATE TABLE `destinos` (
  `id` int(11) NOT NULL,
  `destino` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `destinos`
--

INSERT INTO `destinos` (`id`, `destino`, `fecha`) VALUES
(41, 'LA SALINA', '2024-04-04 15:36:26'),
(42, 'LAGUNILLAS', '2024-04-04 15:36:41'),
(43, 'TIA JUANA', '2024-04-04 15:37:04'),
(44, 'EL MENITO', '2024-04-04 15:37:18'),
(45, 'INTERNO', '2024-04-04 15:37:31'),
(46, 'MENEGRANDE', '2024-04-04 15:37:51'),
(47, 'TALLERES', '2024-04-04 15:38:13'),
(48, '5 DE JULIO', '2024-04-04 15:38:24'),
(49, 'MARACAIBO', '2024-04-04 15:38:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elfinder_file`
--

CREATE TABLE `elfinder_file` (
  `id` int(7) UNSIGNED NOT NULL,
  `parent_id` int(7) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` longblob NOT NULL,
  `size` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `mtime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `mime` varchar(256) NOT NULL DEFAULT 'unknown',
  `read` enum('1','0') NOT NULL DEFAULT '1',
  `write` enum('1','0') NOT NULL DEFAULT '1',
  `locked` enum('1','0') NOT NULL DEFAULT '0',
  `hidden` enum('1','0') NOT NULL DEFAULT '0',
  `width` int(5) NOT NULL DEFAULT '0',
  `height` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `elfinder_file`
--

INSERT INTO `elfinder_file` (`id`, `parent_id`, `name`, `content`, `size`, `mtime`, `mime`, `read`, `write`, `locked`, `hidden`, `width`, `height`) VALUES
(1, 0, 'DATABASE', '', 0, 0, 'directory', '1', '1', '0', '0', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elfinder_trash`
--

CREATE TABLE `elfinder_trash` (
  `id` int(7) UNSIGNED NOT NULL,
  `parent_id` int(7) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` longblob NOT NULL,
  `size` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `mtime` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `mime` varchar(256) NOT NULL DEFAULT 'unknown',
  `read` enum('1','0') NOT NULL DEFAULT '1',
  `write` enum('1','0') NOT NULL DEFAULT '1',
  `locked` enum('1','0') NOT NULL DEFAULT '0',
  `hidden` enum('1','0') NOT NULL DEFAULT '0',
  `width` int(5) NOT NULL DEFAULT '0',
  `height` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `elfinder_trash`
--

INSERT INTO `elfinder_trash` (`id`, `parent_id`, `name`, `content`, `size`, `mtime`, `mime`, `read`, `write`, `locked`, `hidden`, `width`, `height`) VALUES
(1, 0, 'DB Trash', '', 0, 0, 'directory', '1', '1', '0', '0', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `marca` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `marca`, `fecha`) VALUES
(27, 'Yutong', '2025-06-05 18:13:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operadores`
--

CREATE TABLE `operadores` (
  `id` int(11) NOT NULL,
  `operador` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `operadores`
--

INSERT INTO `operadores` (`id`, `operador`, `fecha`) VALUES
(35, 'D AMESTY', '2024-03-11 18:25:16'),
(36, 'J QUINTERO', '2024-03-11 18:25:38'),
(37, 'M MARIN', '2024-03-11 18:25:58'),
(38, 'J NAVA', '2024-03-11 18:26:21'),
(39, 'D MACHADO', '2024-03-11 18:26:40'),
(40, 'E GONZALEZ ', '2024-03-11 18:26:59'),
(41, 'J LISBOA', '2024-03-11 18:27:19'),
(42, 'D GARCIA', '2024-03-11 18:28:20'),
(43, 'W CUICA', '2024-03-11 18:28:45'),
(44, 'G ALBORNOZ', '2024-03-11 18:29:02'),
(45, 'E GUTIERREZ', '2024-03-11 18:29:20'),
(46, 'R PEREZ', '2024-03-11 18:29:35'),
(47, 'ADELIS', '2024-03-11 18:29:48'),
(48, 'J RODRIGUEZ', '2024-03-11 18:30:07'),
(49, 'J PEREZ', '2024-03-11 18:30:35'),
(50, 'Y MONTOYA', '2024-03-11 18:30:50'),
(51, 'H LANDAETA', '2024-03-11 18:31:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `origenes`
--

CREATE TABLE `origenes` (
  `id` int(11) NOT NULL,
  `origen` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `origenes`
--

INSERT INTO `origenes` (`id`, `origen`, `fecha`) VALUES
(1, 'TTCC LA SALINA', '2024-04-04 15:34:57'),
(2, 'BACHAQUERO\r\n', '2024-04-04 15:35:01'),
(3, 'LAGO MEDIO', '2024-04-04 15:35:06'),
(4, 'CABIMAS', '2024-04-04 15:35:10'),
(5, 'ZULIMA', '2024-04-04 15:35:14'),
(6, 'OJEDA', '2024-04-04 15:35:18'),
(7, 'MENEGRANDE', '2024-04-05 17:25:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblpasajeros`
--

CREATE TABLE `tblpasajeros` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `documento` int(11) NOT NULL,
  `gerencia` text COLLATE utf8_spanish_ci NOT NULL,
  `nroUnidad` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_c` date NOT NULL,
  `estado` int(11) NOT NULL,
  `compras` int(11) NOT NULL,
  `ultima_compra` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tblpasajeros`
-- Volcado de datos para la tabla `tblpasajeros`
--

INSERT INTO `tblpasajeros` (`id`, `nombre`, `documento`, `gerencia`, `nroUnidad`, `fecha_c`, `estado`, `compras`, `ultima_compra`, `fecha`) VALUES
(1, 'EDECIO QUERO', 11889669, 'TRANSPORTE TERRESTRE', 'BACHQ - LS', '2024-03-20', 1, 0, '0000-00-00 00:00:00', '2025-04-21 11:42:02'),
(2, 'ALFREDO BAYUELO', 11869025, 'PDVSA INDUSTRIAL, S.A.', 'BACHQ - LS', '2024-03-20', 1, 0, '0000-00-00 00:00:00', '2025-04-04 19:18:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `id` int(11) UNSIGNED NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `tipoNomina` varchar(20) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `estatusDeCondicion` varchar(20) NOT NULL,
  `segundaLineaGerencia` varchar(255) DEFAULT NULL,
  `instalacion_edificio` varchar(255) NOT NULL,
  `localidad_trabajo` varchar(50) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `id_administrador` int(11) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `municipioDeVivienda` varchar(20) DEFAULT NULL,
  `entregaDeBeneficio` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fotoDocumento` varchar(255) DEFAULT NULL,
  `fotoCarnet` varchar(255) DEFAULT NULL,
  `cartaMedica` varchar(255) DEFAULT NULL,
  `certificadoManejo` varchar(255) DEFAULT NULL,
  `nroLicencia` varchar(255) CHARACTER SET swe7 DEFAULT NULL,
  `fechaVencimientoDocumento` date DEFAULT NULL,
  `fechaVencimientoCartaMedica` date DEFAULT NULL,
  `fechaVencimientoCertificadoManejo` date DEFAULT NULL,
  `fechaVencimientoLicencia` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fechaVencimientoCertificadoFlotaLiviana` date DEFAULT NULL,
  `fechaVencimientoCertificadoFlotaPesada` date DEFAULT NULL,
  `certificadoFlotaLiviana` varchar(255) DEFAULT NULL,
  `certificadoFlotaPesada` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `trabajadores`
--

INSERT INTO `trabajadores` (`id`, `cedula`, `nombre`, `cargo`, `tipoNomina`, `correo`, `fechaNacimiento`, `estatusDeCondicion`, `segundaLineaGerencia`, `instalacion_edificio`, `localidad_trabajo`, `telefono`, `id_administrador`, `direccion`, `municipioDeVivienda`, `entregaDeBeneficio`, `foto`, `fotoDocumento`, `fotoCarnet`, `cartaMedica`, `certificadoManejo`, `nroLicencia`, `fechaVencimientoDocumento`, `fechaVencimientoCartaMedica`, `fechaVencimientoCertificadoManejo`, `fechaVencimientoLicencia`, `estado`, `fechaVencimientoCertificadoFlotaLiviana`, `fechaVencimientoCertificadoFlotaPesada`, `certificadoFlotaLiviana`, `certificadoFlotaPesada`, `created_at`) VALUES
(1, 15443428, 'SANTIAGO OSWALDO', 'GERENTE TRANSPORTE TERRESTRE', 'NNC', 'SANTIAGOOS', '1984-09-01', '1', 'TRANSPORTE TERRESTRE', 'EDIFICIO TRANSPORTE', 'LAGUNILLAS', '0414-9646160', 0, 'CALLE CUMANA CASA-310, CAMPO CAC, CACIQUE NIGALES, CABIMAS ', 'CABIMAS', 'S/I', '/path/to/foto1.jpg', '/path/to/documento1.pdf', '/path/to/carnet1.jpg', '/path/to/carta_medica1.pdf', '/path/to/certificado_manejo1.pdf', 'LIC123456', '2027-07-12', '2027-07-12', '2027-07-12', '2027-07-12', 1, '2027-07-12', '2027-07-12', '/path/to/certificado_flota_liviana1.pdf', '/path/to/certificado_flota_pesada1.pdf', '2025-05-08 13:58:10'),
(2, 14951254, 'ROZO LUILLANA', 'SUPERINTENDENTE PLANIF PRESUP Y GESTION', 'NNC', 'ROZOL', '1982-10-06', '1', 'PLANIFICACIÓN PRESUPUESTO Y GESTIÓN', 'EDIFICIO TRANSPORTE TERRESTRE', 'LAGUNILLAS', '0412-1617751 ', 15443428, 'AV. 32 SECTOR LOS MEDANOS CALLE GRANADA CASA N. 122-B CABIMAS', 'CABIMAS', 'CABIMAS', '/path/to/foto2.jpg', '/path/to/documento2.pdf', '/path/to/carnet2.jpg', '/path/to/carta_medica2.pdf', '/path/to/certificado_manejo2.pdf', 'LIC654321', '2027-07-12', '2027-07-12', '2027-07-12', '2027-07-12', 1, '2027-07-12', '2027-07-12', '/path/to/certificado_flota_liviana2.pdf', '/path/to/certificado_flota_pesada2.pdf', '2025-05-08 13:58:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `id_marca` text COLLATE utf8_spanish_ci NOT NULL,
  `id_operador` text COLLATE utf8_spanish_ci NOT NULL,
  `id_origen` text COLLATE utf8_spanish_ci NOT NULL,
  `id_destino` text COLLATE utf8_spanish_ci NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `kmsalida` text COLLATE utf8_spanish_ci NOT NULL,
  `hrsSalida` time NOT NULL,
  `kmllegada` text COLLATE utf8_spanish_ci NOT NULL,
  `hrsLlegada` time NOT NULL,
  `kmRecorrido` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `cantPasajeros` int(11) NOT NULL,
  `observacion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `id_marca`, `id_operador`, `id_origen`, `id_destino`, `codigo`, `kmsalida`, `hrsSalida`, `kmllegada`, `hrsLlegada`, `kmRecorrido`, `imagen`, `cantPasajeros`, `observacion`, `precio_compra`, `precio_venta`, `ventas`, `fecha`) VALUES
(17, 'Yutong', 'D AMESTY', 'TTCC LA SALINA', 'LA SALINA', '502', '102653', '05:06:00', '123545', '17:05:00', '20892', 'vistas/img/unidades/default/anonymous.png', 50, 'asdsa', 0, 0, 0, '2024-05-21 15:44:19'),
(18, 'Yutong', 'D AMESTY', 'TTCC LA SALINA', 'LAGUNILLAS', '2123', '0', '15:05:00', '123', '05:05:00', '123', 'vistas/img/unidades/default/anonymous.png', 50, '5', 0, 0, 0, '2024-05-21 13:02:30'),
(19, 'Yutong', 'R PEREZ', 'TTCC LA SALINA', 'LA SALINA', '34', '211111', '22:02:00', '222222', '22:02:00', '11111', 'vistas/img/unidades/default/anonymous.png', 32, 'asdas', 0, 0, 0, '2024-05-21 15:59:08'),
(20, 'Yutong', 'E GONZALEZ ', 'TTCC LA SALINA', 'LA SALINA', '33', '123546', '05:05:00', '232135', '03:12:00', '108589', 'vistas/img/unidades/default/anonymous.png', 150, 'asdsa', 0, 0, 0, '2024-05-21 16:57:08'),
(21, 'Yutong', 'J NAVA', 'TTCC LA SALINA', '5 DE JULIO', '202', '123456', '05:00:00', '325467', '20:02:00', '202011', 'vistas/img/unidades/default/anonymous.png', 37, 'prueba', 0, 0, 0, '2024-08-20 14:55:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`) VALUES
(1, 'Administrador', 'admin', '$2a$07$asxx54ahjppf45sd87a5aucj8XKZ3iBDnkCnaZI9FherV9s3pbweO', 'Administrador', 'vistas/img/usuarios/admin/191.jpg', 1, '2024-08-01 08:31:25', '2025-05-08 14:52:38'),
(2, 'Julio Gómez', 'julio', '$2a$06$IBo7DoNynOPDeRpg3co9XO7bls08WgGHYx985FdztPyBZr244BNQ6', 'Administrador', 'vistas/img/usuarios/julio/100.png', 1, '2025-08-29 09:27:43', '2025-08-29 13:27:43');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `elfinder_file`
--
ALTER TABLE `elfinder_file`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parent_name` (`parent_id`,`name`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indices de la tabla `elfinder_trash`
--
ALTER TABLE `elfinder_trash`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parent_name` (`parent_id`,`name`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operadores`
--
ALTER TABLE `operadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `origenes`
--
ALTER TABLE `origenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tblpasajeros`
--
ALTER TABLE `tblpasajeros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tblpasajeros`
--

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `destinos`
--
ALTER TABLE `destinos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `elfinder_file`
--
ALTER TABLE `elfinder_file`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `elfinder_trash`
--
ALTER TABLE `elfinder_trash`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `operadores`
--
ALTER TABLE `operadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `origenes`
--
ALTER TABLE `origenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `tblpasajeros`
--
ALTER TABLE `tblpasajeros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3246;

--
-- AUTO_INCREMENT de la tabla `tblpasajeros`
--
ALTER TABLE `tblpasajeros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56554;

--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
