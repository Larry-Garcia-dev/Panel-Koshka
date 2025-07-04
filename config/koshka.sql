-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-07-2025 a las 22:55:26
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
-- Base de datos: `koshka`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_ropa`
--

CREATE TABLE `categorias_ropa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_ropa`
--

INSERT INTO `categorias_ropa` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Camisetas', 'Prendas superiores ligeras, de manga corta o larga.'),
(2, 'Pantalones', 'Prendas inferiores largas.'),
(3, 'Jeans', 'Pantalones de mezclilla.'),
(4, 'Shorts', 'Pantalones cortos.'),
(5, 'Faldas', 'Prendas inferiores generalmente usadas por mujeres.'),
(6, 'Vestidos', 'Prenda de una sola pieza para mujeres.'),
(7, 'Chaquetas', 'Prenda exterior para el frío.'),
(8, 'Abrigos', 'Prendas gruesas para clima muy frío.'),
(9, 'Sudaderas', 'Prendas superiores cómodas, con o sin capucha.'),
(10, 'Ropa interior', 'Prendas interiores como calzoncillos, sostenes, etc.'),
(11, 'Calcetines', 'Prendas para cubrir los pies.'),
(12, 'Trajes', 'Conjunto formal de saco y pantalón.'),
(13, 'Deportiva', 'Ropa diseñada para hacer ejercicio o deportes.'),
(14, 'Pijamas', 'Ropa para dormir.'),
(15, 'Accesorios', 'Complementos como gorras, bufandas, cinturones.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pines_registro`
--

CREATE TABLE `pines_registro` (
  `id` int(11) NOT NULL,
  `pin` varchar(6) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pines_registro`
--

INSERT INTO `pines_registro` (`id`, `pin`, `creado_en`) VALUES
(1, '123456', '2025-06-23 23:15:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `categoria_id` int(11) DEFAULT NULL,
  `img` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `categoria_id`, `img`, `estado`) VALUES
(7, 'Vestido Elegante Rosa', 'Vestido muy bonito marca pajarito para guisas y ñeras', 50000.00, 12, 6, '../images/productos/prod_6867053e8a5e3.jpg', 'inactivo'),
(8, 'Pantalon para tiendas', 'pantalon apra tiendas los usas como muestra de respeto', 12000.00, 15, 3, '../images/productos/prod_686705fc5b220.jpg', 'inactivo'),
(9, 'Vestido Elegante Rosa', 'Defina la elegancia con líneas puras y una silueta impecable. Este vestido, confeccionado en un lujoso crepé que se desliza sobre la figura, presenta un escote [tipo de escote, ej: asimétrico, halter, barco] que acentúa sutilmente los hombros. Su corte [tipo de corte, ej: sirena, recto, imperio] y su caída fluida aseguran un movimiento grácil y una presencia inolvidable. Ideal para la mujer que encuentra la fuerza en la simplicidad.', 150000.00, 2, 6, '../images/productos/prod_6867111e4d4ce.jpg', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_talla`
--

CREATE TABLE `producto_talla` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) DEFAULT NULL,
  `talla_personalizada` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_talla`
--

INSERT INTO `producto_talla` (`id`, `producto_id`, `talla_id`, `talla_personalizada`) VALUES
(23, 7, 1, NULL),
(24, 7, 2, NULL),
(25, 7, 3, NULL),
(26, 7, 4, NULL),
(27, 7, 5, NULL),
(28, 7, 6, NULL),
(29, 7, 7, NULL),
(30, 7, 8, NULL),
(31, 7, 17, NULL),
(32, 8, 11, NULL),
(33, 8, 14, NULL),
(34, 8, 17, NULL),
(35, 8, NULL, 'manzana'),
(36, 9, 1, NULL),
(37, 9, 2, NULL),
(38, 9, 3, NULL),
(39, 9, 4, NULL),
(40, 9, 5, NULL),
(41, 9, 6, NULL),
(42, 9, 7, NULL),
(43, 9, 8, NULL),
(44, 9, 9, NULL),
(45, 9, 10, NULL),
(46, 9, 11, NULL),
(47, 9, 12, NULL),
(48, 9, 13, NULL),
(49, 9, 14, NULL),
(50, 9, 15, NULL),
(51, 9, 16, NULL),
(52, 9, 17, NULL),
(53, 9, 18, NULL),
(54, 9, NULL, 'manzana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas_ropa`
--

CREATE TABLE `tallas_ropa` (
  `id` int(11) NOT NULL,
  `talla` varchar(10) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tallas_ropa`
--

INSERT INTO `tallas_ropa` (`id`, `talla`, `tipo`, `descripcion`) VALUES
(1, 'XS', 'Adulto', 'Extra pequeño'),
(2, 'S', 'Adulto', 'Pequeño'),
(3, 'M', 'Adulto', 'Mediano'),
(4, 'L', 'Adulto', 'Grande'),
(5, 'XL', 'Adulto', 'Extra grande'),
(6, 'XXL', 'Adulto', 'Doble extra grande'),
(7, 'XXXL', 'Adulto', 'Triple extra grande'),
(8, '4XL', 'Adulto', 'Cuádruple extra grande'),
(9, '5XL', 'Adulto', 'Quíntuple extra grande'),
(10, '6XL', 'Adulto', 'Séxtuple extra grande'),
(11, 'Unica', 'todos', 'Talla unica '),
(12, '2', 'Niño', '2 años'),
(13, '4', 'Niño', '4 años'),
(14, '6', 'Niño', '6 años'),
(15, '8', 'Niño', '8 años'),
(16, '10', 'Niño', '10 años'),
(17, '12', 'Niño', '12 años'),
(18, '14', 'Niño', '14 años'),
(39, '30', 'Adulto', 'Talla 30 - numérica'),
(40, '32', 'Adulto', 'Talla 32 - numérica'),
(41, '34', 'Adulto', 'Talla 34 - numérica'),
(42, '36', 'Adulto', 'Talla 36 - numérica'),
(43, '38', 'Adulto', 'Talla 38 - numérica'),
(44, '40', 'Adulto', 'Talla 40 - numérica'),
(45, '42', 'Adulto', 'Talla 42 - numérica'),
(46, '44', 'Adulto', 'Talla 44 - numérica'),
(47, '46', 'Adulto', 'Talla 46 - numérica'),
(48, '48', 'Adulto', 'Talla 48 - numérica'),
(49, '50', 'Adulto', 'Talla 50 - numérica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `Pin` int(6) NOT NULL,
  `NombreCompleto` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `Pin`, `NombreCompleto`, `Email`, `Usuario`, `Contraseña`, `creado_en`, `img`) VALUES
(0, 123456, 'Larry Dev', 'garcialarry575@gmail.com', 'Laxgames', '$2y$10$mC/l0HfCserSpyCg3Hs3a.RREYnoy3/D.2clLPGo68MuqIbpMnIpm', '2025-07-03 22:20:56', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias_ropa`
--
ALTER TABLE `categorias_ropa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `producto_talla`
--
ALTER TABLE `producto_talla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `talla_id` (`talla_id`);

--
-- Indices de la tabla `tallas_ropa`
--
ALTER TABLE `tallas_ropa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias_ropa`
--
ALTER TABLE `categorias_ropa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `producto_talla`
--
ALTER TABLE `producto_talla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `tallas_ropa`
--
ALTER TABLE `tallas_ropa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias_ropa` (`id`);

--
-- Filtros para la tabla `producto_talla`
--
ALTER TABLE `producto_talla`
  ADD CONSTRAINT `producto_talla_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `producto_talla_ibfk_2` FOREIGN KEY (`talla_id`) REFERENCES `tallas_ropa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
