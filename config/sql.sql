-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-07-2025 a las 00:17:07
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
-- Base de datos: koshka
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla pines_registro
--

CREATE TABLE pines_registro (
  id int(11) NOT NULL,
  pin varchar(6) NOT NULL,
  creado_en timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla pines_registro
--

INSERT INTO pines_registro (id, pin, creado_en) VALUES
(1, '123456', '2025-06-23 18:15:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla user
--

CREATE TABLE user (
  id int(11) NOT NULL,
  Pin int(6) NOT NULL,
  NombreCompleto varchar(100) NOT NULL,
  Email varchar(100) NOT NULL,
  Usuario varchar(50) NOT NULL,
  Contraseña varchar(255) NOT NULL,
  creado_en timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla user
--

INSERT INTO user (id, Pin, NombreCompleto, Email, Usuario, Contraseña, creado_en) VALUES
(1, 123456, 'sendpulse', 'garcialarry575@gmail.com', 'Laxgames', '$2y$10$JpAdiJrHcDUC3PEvrRc23efPPQMvN97EIJIAVlxNv7yFVbxtKkxj.', '2025-06-23 18:33:54');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla pines_registro
--
ALTER TABLE pines_registro
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY pin (pin);

--
-- Indices de la tabla user
--
ALTER TABLE user
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY Email (Email);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla pines_registro
--
ALTER TABLE pines_registro
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla user
--
ALTER TABLE user
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;