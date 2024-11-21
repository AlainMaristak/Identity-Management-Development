-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2024 a las 13:57:13
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reto`
--
CREATE DATABASE IF NOT EXISTS `reto` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `reto`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `raspberry_analisis`
--

CREATE TABLE `raspberry_analisis` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `resultado` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`resultado`)),
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_login`
--

CREATE TABLE `registro_login` (
  `id` int(11) NOT NULL,
  `ip` varchar(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contra` varchar(250) NOT NULL,
  `datos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `registro_login`
--

INSERT INTO `registro_login` (`id`, `ip`, `usuario`, `correo`, `contra`, `datos`) VALUES
(1, '10.11.0.50', '10.11.0.50', 'user@user.com', 'user', '{&quot;ip&quot;:&quot;10.11.0.50&quot;,&quot;user_agent&quot;:&quot;Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/131.0.0.0 Safari\\/537.36&quot;,&quot;pagina_actual&quot;:&quot;\\/Identity-Management-Development\\/WEB\\/index.php&quot;,&quot;metodo_http&quot;:&quot;POST&quot;,&quot;referer&quot;:&quot;http:\\/\\/10.11.0.112\\/Identity-Management-Development\\/WEB\\/&quot;,&quot;puerto&quot;:&quot;34082&quot;,&quot;protocolo&quot;:&quot;HTTP\\/1.1&quot;,&quot;idioma&quot;:&quot;es-ES,es;q=0.9,en;q=0.8&quot;,&quot;host&quot;:&quot;10.11.0.50&quot;}'),
(2, '10.11.0.50', '10.11.0.50', 'user@user.com', 'user', '{&quot;ip&quot;:&quot;10.11.0.50&quot;,&quot;user_agent&quot;:&quot;Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/131.0.0.0 Safari\\/537.36&quot;,&quot;pagina_actual&quot;:&quot;\\/Identity-Management-Development\\/WEB\\/index.php&quot;,&quot;metodo_http&quot;:&quot;POST&quot;,&quot;referer&quot;:&quot;http:\\/\\/10.11.0.112\\/Identity-Management-Development\\/WEB\\/&quot;,&quot;puerto&quot;:&quot;34083&quot;,&quot;protocolo&quot;:&quot;HTTP\\/1.1&quot;,&quot;idioma&quot;:&quot;es-ES,es;q=0.9,en;q=0.8&quot;,&quot;host&quot;:&quot;10.11.0.50&quot;}'),
(3, '::1', 'DUR-Ciber5', 'alain@maristak.com', '132', '{&quot;ip&quot;:&quot;::1&quot;,&quot;user_agent&quot;:&quot;Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/131.0.0.0 Safari\\/537.36&quot;,&quot;pagina_actual&quot;:&quot;\\/Identity-Management-Development\\/WEB\\/index.php&quot;,&quot;metodo_http&quot;:&quot;POST&quot;,&quot;referer&quot;:&quot;http:\\/\\/localhost\\/Identity-Management-Development\\/WEB\\/&quot;,&quot;puerto&quot;:&quot;62767&quot;,&quot;protocolo&quot;:&quot;HTTP\\/1.1&quot;,&quot;idioma&quot;:&quot;es-ES,es;q=0.9&quot;,&quot;host&quot;:&quot;DUR-Ciber5&quot;}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `id` int(11) NOT NULL,
  `tipo` int(1) NOT NULL COMMENT '1-Débito, 2-Crédito',
  `numero` varchar(16) NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `CVV` varchar(3) NOT NULL,
  `activo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tarjeta`
--

INSERT INTO `tarjeta` (`id`, `tipo`, `numero`, `fecha_caducidad`, `CVV`, `activo`) VALUES
(1, 1, '1234567890123456', '2025-08-21', '123', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas_transacciones`
--

CREATE TABLE `tarjetas_transacciones` (
  `id` int(11) NOT NULL,
  `id_usuarios_tarjetas` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `importe` varchar(9) NOT NULL,
  `ticket` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tarjetas_transacciones`
--

INSERT INTO `tarjetas_transacciones` (`id`, `id_usuarios_tarjetas`, `fecha`, `descripcion`, `importe`, `ticket`) VALUES
(1, 1, '2024-11-15 10:53:03', 'Amogus skibidi test', '420', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT 2 COMMENT '1=Admin, 2=Usuario',
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  `nombre_empresa` varchar(50) NOT NULL,
  `CIF` varchar(10) NOT NULL,
  `ultima_conexion` datetime NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `activo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `usuario`, `correo`, `contrasena`, `nombre_empresa`, `CIF`, `ultima_conexion`, `fecha_registro`, `activo`) VALUES
(1, 2, 'Alain', 'alain@maristak.com', '132', 'WannaCrack', '12345678Z', '2024-11-21 11:51:24', '2024-11-14 11:36:02', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_tarjetas`
--

CREATE TABLE `usuarios_tarjetas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_tarjeta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios_tarjetas`
--

INSERT INTO `usuarios_tarjetas` (`id`, `id_usuario`, `id_tarjeta`) VALUES
(1, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `raspberry_analisis`
--
ALTER TABLE `raspberry_analisis`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_login`
--
ALTER TABLE `registro_login`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tarjetas_transacciones`
--
ALTER TABLE `tarjetas_transacciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_tarjetas`
--
ALTER TABLE `usuarios_tarjetas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `raspberry_analisis`
--
ALTER TABLE `raspberry_analisis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_login`
--
ALTER TABLE `registro_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tarjetas_transacciones`
--
ALTER TABLE `tarjetas_transacciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios_tarjetas`
--
ALTER TABLE `usuarios_tarjetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
