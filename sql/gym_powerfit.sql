-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-11-2025 a las 23:24:23
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
-- Base de datos: `gym_powerfit`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `plan` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `nombre`, `email`, `telefono`, `plan`, `created_at`) VALUES
(2, 'Maximiliano', 'mromero@gmail.com', '3794043183', 'Mensual Premium', '2025-11-06 22:39:57'),
(3, 'Gabriel', 'gabriel@gmail.com', '3794043183', 'Mensual Pro', '2025-11-06 22:54:43'),
(6, 'Gabriel Maximiliano', 'gm.romero@gmail.com', '3794043183', 'Mensual Premium', '2025-11-07 05:26:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `actividad` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `nombre`, `email`, `actividad`, `fecha`, `hora`, `created_at`) VALUES
(2, 'Maximiliano', 'mromero@gmail.com', 'CrossFit', '2025-11-28', '06:00:00', '2025-11-06 22:40:35'),
(3, 'Gabriel Maximiliano', 'gm.romero@gmail.com', 'CrossFit', '2025-11-28', '12:45:00', '2025-11-07 05:27:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `plan` varchar(50) DEFAULT NULL,
  `role` enum('admin','client') NOT NULL DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `telefono`, `usuario`, `password`, `plan`, `role`, `created_at`) VALUES
(1, 'Gabriel', 'Romero', 'gabriel.romero@gmail.com', '3794435673', 'g.romero', '$2y$10$CZgRPrykYubjqo5dXK/UueueB.kNx55PhS964uOt9UhQhP5DQnWJ.', 'Mensual Premium', 'admin', '2025-11-06 22:30:58'),
(2, 'Alejandro', 'Karvuonaris', 'ale.karvuonaris@gmail.com', '3794435673', 'ale.admin', '$2y$10$cE9M0HVlGx6Me6aGELTm5.wnUVGXXjiobwHvhTM/Rt.yyphVtZNb6', 'Mensual Premium', 'admin', '2025-11-06 22:37:15'),
(3, 'Gabriel Maximiliano', 'Romero', 'gabriel.romero2@gmail.com', '3794435673', 'gabriel.admin', '$2y$10$XQl7xIs/lyhbFiem/SeRfePSGnwAfNouwdUPM/1aAGY9qmDCKQWGO', 'Mensual Premium', 'admin', '2025-11-06 22:38:48'),
(5, 'Maximiliano', 'Romero', 'mromero@gmail.com', '3794435673', 'maxi.romero', '$2y$10$DtXYbSIr1dN5OS8bHvWJsO3CqzdlnPk83cGWsxRe34oJ0SNcN8yDy', 'Mensual Pro', 'client', '2025-11-06 22:35:26'),
(9, 'Gabriel', 'Romero Espindola', 'g.romero2@gmail.com', '3794435673', 'gromero', '$2y$10$CclnH81/6y4anLoBOui9.u8ilzH8ZUAvekmgzz2hNOd92.ETnLCcu', 'Mensual Basico', 'client', '2025-11-06 22:58:12'),
(10, 'Gabriel Maximiliano', 'Romero Espindola', 'gm.romero@gmail.com', '3794435673', 'gm.romero', '$2y$10$qf2LuMBk7DTlHGhrZdok5uieZ2dEjViCe6XYjO3nskBSefuVMA2pW', 'Mensual Pro', 'client', '2025-11-07 05:25:44');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
