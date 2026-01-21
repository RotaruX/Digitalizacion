-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-01-2026 a las 13:33:32
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eiffage`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `epi`
--

CREATE TABLE `epi` (
  `id_epi` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `nombre_epi` varchar(100) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `fecha_caducidad` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `epi`
--

INSERT INTO `epi` (`id_epi`, `id_trabajador`, `nombre_epi`, `fecha_entrega`, `fecha_caducidad`) VALUES
(1, 1, 'Casco de seguridad', '2024-01-10', '2025-01-10'),
(2, 1, 'Guantes anticorte', '2024-05-01', '2024-12-15'),
(3, 2, 'Botas de seguridad', '2024-02-20', '2025-02-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `id_solicitud` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `id_epi` int(11) NOT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','aprobada','rechazada') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`id_solicitud`, `id_trabajador`, `id_epi`, `fecha_solicitud`, `estado`) VALUES
(1, 1, 2, '2026-01-07 14:23:18', 'pendiente'),
(2, 1, 1, '2026-01-07 14:23:18', 'aprobada'),
(3, 2, 3, '2026-01-07 14:23:18', 'rechazada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador`
--

CREATE TABLE `trabajador` (
  `id_trabajador` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('trabajador','rrhh') NOT NULL DEFAULT 'trabajador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trabajador`
--

INSERT INTO `trabajador` (`id_trabajador`, `nombre`, `usuario`, `password`, `rol`) VALUES
(1, 'Álex Martínez', 'alex', '1234', 'trabajador'),
(2, 'Juan López', 'juan', '1234', 'trabajador'),
(3, 'María Ruiz', 'maria', '1234', 'rrhh');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `epi`
--
ALTER TABLE `epi`
  ADD PRIMARY KEY (`id_epi`),
  ADD KEY `id_trabajador` (`id_trabajador`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `id_trabajador` (`id_trabajador`),
  ADD KEY `id_epi` (`id_epi`);

--
-- Indices de la tabla `trabajador`
--
ALTER TABLE `trabajador`
  ADD PRIMARY KEY (`id_trabajador`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `epi`
--
ALTER TABLE `epi`
  MODIFY `id_epi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `trabajador`
--
ALTER TABLE `trabajador`
  MODIFY `id_trabajador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `epi`
--
ALTER TABLE `epi`
  ADD CONSTRAINT `epi_ibfk_1` FOREIGN KEY (`id_trabajador`) REFERENCES `trabajador` (`id_trabajador`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `solicitud_ibfk_1` FOREIGN KEY (`id_trabajador`) REFERENCES `trabajador` (`id_trabajador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `solicitud_ibfk_2` FOREIGN KEY (`id_epi`) REFERENCES `epi` (`id_epi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
