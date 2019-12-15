-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2019 a las 19:26:53
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tp_programacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comandas`
--

CREATE TABLE `comandas` (
  `id` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `nombre_cliente` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `pedido` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `codigo` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `tiempo_preparacion` timestamp NULL DEFAULT NULL,
  `importe` float NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` int(11) NOT NULL,
  `mesa` int(2) NOT NULL,
  `restaurante` int(2) NOT NULL,
  `cocinero` int(2) NOT NULL,
  `mozo` int(2) NOT NULL,
  `comentario` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `puntuacion_total` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `mesa`, `restaurante`, `cocinero`, `mozo`, `comentario`, `puntuacion_total`) VALUES
(1, 8, 7, 8, 9, 'muy lindo todo', 24),
(2, 3, 7, 6, 9, 'muy lindo todo', 25),
(3, 3, 3, 6, 4, 'muy lindo todo', 16),
(4, 3, 3, 2, 4, 'horrible', 12),
(5, 8, 9, 7, 10, 'el programador un crack', 34),
(6, 8, 1, 7, 10, 'sucio', 26),
(7, 8, 8, 7, 7, 'ni tan mal ni tan bien', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_mesa`
--

CREATE TABLE `estado_mesa` (
  `id` int(1) NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre_usuario` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `accion` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`id`, `id_usuario`, `fecha`, `nombre_usuario`, `accion`) VALUES
(1, 9, '2019-11-12 00:52:24', 'Blacked', 'POST'),
(2, 9, '2019-11-12 01:30:08', 'Blacked', 'POST'),
(3, 21, '2019-11-12 01:30:45', 'Baron', 'POST'),
(4, 21, '2019-11-12 01:31:44', 'Baron', 'POST'),
(5, 21, '2019-11-12 01:31:59', 'Baron', 'POST'),
(6, 21, '2019-11-12 01:33:14', 'Baron', 'POST'),
(7, 9, '2019-11-12 01:36:59', 'Blacked', 'POST'),
(8, 9, '2019-11-12 01:50:26', 'Blacked', 'POST'),
(9, 12, '2019-11-12 01:58:25', 'Elchoborra', 'POST'),
(10, 12, '2019-11-12 01:58:57', 'Elchoborra', 'POST'),
(11, 12, '2019-11-12 02:05:21', 'Elchoborra', 'POST'),
(12, 9, '2019-11-12 02:06:57', 'Blacked', 'POST'),
(13, 9, '2019-11-12 02:09:30', 'Blacked', 'POST'),
(14, 9, '2019-11-12 02:09:51', 'Blacked', 'POST'),
(15, 9, '2019-11-12 02:10:07', 'Blacked', 'POST'),
(16, 9, '2019-11-12 02:10:47', 'Blacked', 'POST'),
(17, 9, '2019-11-12 02:11:10', 'Blacked', 'POST'),
(18, 9, '2019-11-12 02:12:47', 'Blacked', 'POST'),
(19, 9, '2019-11-12 02:12:58', 'Blacked', 'POST'),
(20, 9, '2019-11-12 02:14:47', 'Blacked', 'POST'),
(21, 9, '2019-11-12 02:15:01', 'Blacked', 'POST'),
(22, 9, '2019-11-12 02:15:57', 'Blacked', 'POST'),
(23, 9, '2019-11-12 02:16:49', 'Blacked', 'POST'),
(24, 9, '2019-11-12 02:22:15', 'Blacked', 'POST'),
(25, 9, '2019-11-12 02:22:59', 'Blacked', 'POST'),
(26, 9, '2019-11-12 02:23:02', 'Blacked', 'POST'),
(27, 9, '2019-11-12 02:23:32', 'Blacked', 'POST'),
(28, 9, '2019-11-12 02:24:15', 'Blacked', 'POST'),
(29, 9, '2019-11-12 02:24:32', 'Blacked', 'POST'),
(30, 9, '2019-11-12 02:25:21', 'Blacked', 'POST'),
(31, 9, '2019-11-12 02:30:14', 'Blacked', 'POST'),
(32, 9, '2019-11-12 02:30:30', 'Blacked', 'POST'),
(33, 9, '2019-11-12 02:30:48', 'Blacked', 'POST'),
(34, 9, '2019-11-12 02:31:39', 'Blacked', 'POST'),
(35, 9, '2019-11-12 02:32:18', 'Blacked', 'POST'),
(36, 9, '2019-11-12 02:32:30', 'Blacked', 'POST'),
(37, 9, '2019-11-12 02:32:32', 'Blacked', 'POST'),
(38, 9, '2019-11-12 02:32:35', 'Blacked', 'POST'),
(39, 9, '2019-11-12 02:32:48', 'Blacked', 'POST'),
(40, 9, '2019-11-12 02:32:52', 'Blacked', 'POST'),
(41, 9, '2019-11-12 02:33:37', 'Blacked', 'POST'),
(42, 9, '2019-11-12 02:36:38', 'Blacked', 'POST'),
(43, 9, '2019-11-12 02:42:16', 'Blacked', 'POST'),
(44, 9, '2019-11-12 02:44:32', 'Blacked', 'POST'),
(45, 9, '2019-11-12 02:45:14', 'Blacked', 'POST'),
(46, 9, '2019-11-12 02:46:39', 'Blacked', 'GET'),
(47, 9, '2019-11-12 03:07:24', 'Blacked', 'POST'),
(48, 9, '2019-11-12 03:10:54', 'Blacked', 'POST'),
(49, 9, '2019-11-12 03:12:31', 'Blacked', 'GET'),
(50, 9, '2019-11-12 03:14:27', 'Blacked', 'POST'),
(51, 9, '2019-11-12 03:16:40', 'Blacked', 'POST'),
(52, 9, '2019-11-12 03:17:00', 'Blacked', 'POST'),
(53, 9, '2019-11-12 03:17:03', 'Blacked', 'POST'),
(54, 9, '2019-11-12 03:18:12', 'Blacked', 'POST'),
(55, 9, '2019-11-12 16:55:27', 'Blacked', 'GET'),
(56, 9, '2019-11-12 16:57:27', 'Blacked', 'GET'),
(57, 9, '2019-11-12 16:58:11', 'Blacked', 'GET'),
(58, 9, '2019-11-12 16:58:13', 'Blacked', 'GET'),
(59, 9, '2019-11-12 16:58:43', 'Blacked', 'GET'),
(60, 9, '2019-11-12 16:59:08', 'Blacked', 'GET'),
(61, 9, '2019-11-12 16:59:20', 'Blacked', 'GET'),
(62, 9, '2019-11-12 16:59:22', 'Blacked', 'GET'),
(63, 9, '2019-11-12 17:00:05', 'Blacked', 'GET'),
(64, 9, '2019-11-12 17:02:13', 'Blacked', 'GET'),
(65, 9, '2019-11-12 17:02:15', 'Blacked', 'GET'),
(66, 9, '2019-11-12 17:02:36', 'Blacked', 'GET'),
(67, 9, '2019-11-12 17:24:40', 'Blacked', 'GET'),
(68, 9, '2019-11-12 17:24:51', 'Blacked', 'GET'),
(69, 9, '2019-11-12 17:54:16', 'Blacked', 'POST'),
(70, 9, '2019-11-12 17:55:27', 'Blacked', 'POST'),
(71, 9, '2019-11-12 17:55:31', 'Blacked', 'POST'),
(72, 9, '2019-11-12 17:55:38', 'Blacked', 'POST'),
(73, 9, '2019-11-12 17:55:54', 'Blacked', 'POST'),
(74, 9, '2019-11-12 17:56:15', 'Blacked', 'POST'),
(75, 9, '2019-11-12 17:56:32', 'Blacked', 'POST'),
(76, 9, '2019-11-12 17:56:50', 'Blacked', 'POST'),
(77, 9, '2019-11-12 17:57:32', 'Blacked', 'POST'),
(78, 9, '2019-11-12 17:57:45', 'Blacked', 'POST'),
(79, 9, '2019-11-12 17:57:51', 'Blacked', 'POST'),
(80, 9, '2019-11-12 17:58:42', 'Blacked', 'POST'),
(81, 9, '2019-11-12 17:59:07', 'Blacked', 'POST'),
(82, 9, '2019-11-12 17:59:28', 'Blacked', 'POST'),
(83, 9, '2019-11-12 17:59:39', 'Blacked', 'POST'),
(84, 9, '2019-11-12 17:59:52', 'Blacked', 'POST'),
(85, 9, '2019-11-12 18:00:18', 'Blacked', 'GET'),
(86, 9, '2019-11-12 20:25:29', 'Blacked', 'GET'),
(87, 9, '2019-11-12 20:26:11', 'Blacked', 'GET'),
(88, 9, '2019-11-12 20:26:13', 'Blacked', 'GET'),
(89, 9, '2019-11-12 20:26:44', 'Blacked', 'GET');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `codigo` int(5) NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `codigo`, `estado`) VALUES
(1, 12345, 'lista'),
(4, 55555, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `codigo` int(5) NOT NULL,
  `productos` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `hora_pedido` time NOT NULL DEFAULT current_timestamp(),
  `tiempo_preparacion` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `estado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `tiempo_preparacion` float NOT NULL,
  `cant_vendida` int(11) NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `tiempo_preparacion`, `cant_vendida`, `precio`) VALUES
(2, 'papas', 15, 0, 80),
(3, 'hambuerguesa', 30, 0, 120),
(4, 'cerveza', 5, 0, 120),
(5, 'vino', 5, 0, 90),
(6, 'milanesa', 15, 0, 90);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `contraseña` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `perfil` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `sector` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(15) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contraseña`, `nombre`, `apellido`, `perfil`, `sector`, `estado`) VALUES
(9, 'Blacked', 'miclave', 'Federico', 'Andrade', 'admin', 'todos', 'activo'),
(11, 'AleAlma', 'miclave', 'Alejandro', 'Almada', 'admin', 'todos', 'activo'),
(12, 'Elchoborra', 'miclave', 'Enrique', 'Pinti', 'admin', 'todos', 'activo'),
(13, 'Manu', 'miclave', 'manuel', 'Chorizo', 'cocinero', 'cocina', 'activo'),
(14, 'Ferdi', 'miclave', 'Fernando', 'diaz', 'cocinero', 'cocina', 'activo'),
(15, 'RuizElena', 'miclave', 'Elena', 'Ruiz', 'mozo', 'mozos', 'activo'),
(16, 'CelesteDiaz', 'miclave', 'Celeste', 'Diaz', 'mozo', 'mozos', 'activo'),
(17, 'NDiaz', 'miclave', 'Natali', 'Diaz', 'cervecero', 'cerveceros', 'activo'),
(18, 'Paulito', 'miclave', 'Paul', 'Fernandez', 'cervecero', 'cerveceros', 'activo'),
(19, 'Piazita', 'miclave', 'roberto', 'Piazza', 'bartender', 'bartenders', 'activo'),
(20, 'Elema', 'miclave', 'Emanuel', 'Ortega', 'bartender', 'bartenders', 'activo'),
(21, 'Baron', 'miclave', 'Gimena', 'Baron', 'bartender', 'bartenders', 'activo'),
(33, 'carajo', 'otraclave', 'enrique', 'Baron', 'bartender', 'cocina', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comandas`
--
ALTER TABLE `comandas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comandas`
--
ALTER TABLE `comandas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
