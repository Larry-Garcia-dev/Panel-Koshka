-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-07-2025 a las 22:57:52
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
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `codigo_hex` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id`, `nombre`, `codigo_hex`) VALUES
(1, 'Red', '#FF0000'),
(2, 'Green', '#00FF00'),
(3, 'Blue', '#0000FF'),
(4, 'Yellow', '#FFFF00'),
(5, 'Cyan', '#00FFFF'),
(6, 'Magenta', '#FF00FF'),
(7, 'Black', '#000000'),
(8, 'White', '#FFFFFF'),
(9, 'Gray', '#808080'),
(10, 'Orange', '#FFA500'),
(11, 'Pink', '#FFC0CB'),
(12, 'Purple', '#800080'),
(13, 'Brown', '#A52A2A'),
(14, 'Gold', '#FFD700'),
(15, 'Silver', '#C0C0C0'),
(16, 'Beige', '#F5F5DC'),
(17, 'Ivory', '#FFFFF0'),
(18, 'Coral', '#FF7F50'),
(19, 'Aqua', '#00FFFF'),
(20, 'Lime', '#00FF00'),
(21, 'Maroon', '#800000'),
(22, 'Navy', '#000080'),
(23, 'Olive', '#808000'),
(24, 'Teal', '#008080'),
(25, 'Violet', '#EE82EE'),
(26, 'Turquoise', '#40E0D0'),
(27, 'Indigo', '#4B0082'),
(28, 'Salmon', '#FA8072'),
(29, 'Khaki', '#F0E68C'),
(30, 'Lavender', '#E6E6FA'),
(31, 'Crimson', '#DC143C'),
(32, 'Plum', '#DDA0DD'),
(33, 'Orchid', '#DA70D6'),
(34, 'Mint', '#98FF98'),
(35, 'Peach', '#FFE5B4'),
(36, 'Chocolate', '#D2691E'),
(37, 'Tan', '#D2B48C'),
(38, 'Sky Blue', '#87CEEB'),
(39, 'Royal Blue', '#4169E1'),
(40, 'Slate Gray', '#708090'),
(41, 'Steel Blue', '#4682B4'),
(42, 'Tomato', '#FF6347'),
(43, 'Wheat', '#F5DEB3'),
(44, 'Sea Green', '#2E8B57'),
(45, 'Sienna', '#A0522D'),
(46, 'Snow', '#FFFAFA'),
(47, 'Spring Green', '#00FF7F'),
(48, 'Thistle', '#D8BFD8'),
(49, 'Powder Blue', '#B0E0E6'),
(50, 'Peru', '#CD853F'),
(51, 'Pale Green', '#98FB98'),
(52, 'Pale Turquoise', '#AFEEEE'),
(53, 'Pale Violet Red', '#DB7093'),
(54, 'Papaya Whip', '#FFEFD5'),
(55, 'Moccasin', '#FFE4B5'),
(56, 'Misty Rose', '#FFE4E1'),
(57, 'Medium Violet Red', '#C71585'),
(58, 'Medium Turquoise', '#48D1CC'),
(59, 'Medium Spring Green', '#00FA9A'),
(60, 'Medium Sea Green', '#3CB371'),
(61, 'Medium Purple', '#9370DB'),
(62, 'Medium Orchid', '#BA55D3'),
(63, 'Medium Blue', '#0000CD'),
(64, 'Medium Aquamarine', '#66CDAA'),
(65, 'Lawn Green', '#7CFC00'),
(66, 'Light Salmon', '#FFA07A'),
(67, 'Light Sea Green', '#20B2AA'),
(68, 'Light Sky Blue', '#87CEFA'),
(69, 'Light Slate Gray', '#778899'),
(70, 'Light Steel Blue', '#B0C4DE'),
(71, 'Light Yellow', '#FFFFE0'),
(72, 'Linen', '#FAF0E6'),
(73, 'Hot Pink', '#FF69B4'),
(74, 'Honeydew', '#F0FFF0'),
(75, 'Green Yellow', '#ADFF2F'),
(76, 'Gainsboro', '#DCDCDC'),
(77, 'Floral White', '#FFFAF0'),
(78, 'Dodger Blue', '#1E90FF'),
(79, 'Deep Sky Blue', '#00BFFF'),
(80, 'Deep Pink', '#FF1493'),
(81, 'Dark Violet', '#9400D3'),
(82, 'Dark Turquoise', '#00CED1'),
(83, 'Dark Slate Gray', '#2F4F4F'),
(84, 'Dark Sea Green', '#8FBC8F'),
(85, 'Dark Salmon', '#E9967A'),
(86, 'Dark Red', '#8B0000'),
(87, 'Dark Orange', '#FF8C00'),
(88, 'Dark Orchid', '#9932CC'),
(89, 'Dark Olive Green', '#556B2F'),
(90, 'Dark Magenta', '#8B008B'),
(91, 'Dark Khaki', '#BDB76B'),
(92, 'Dark Green', '#006400'),
(93, 'Dark Gray', '#A9A9A9'),
(94, 'Dark Goldenrod', '#B8860B'),
(95, 'Dark Cyan', '#008B8B'),
(96, 'Dark Blue', '#00008B'),
(97, 'Chartreuse', '#7FFF00'),
(98, 'Cadet Blue', '#5F9EA0'),
(99, 'Burly Wood', '#DEB887'),
(100, 'Azure', '#F0FFFF'),
(101, 'Antique White', '#FAEBD7');

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
(8, 'Pantalon para tiendas', 'pantalon apra tiendas los usas como muestra de respeto', 12000.00, 15, 4, '../images/productos/prod_686705fc5b220.jpg', 'inactivo'),
(9, 'Vestido Elegante Rosa', 'Defina la elegancia con líneas puras y una silueta impecable. Este vestido, confeccionado en un lujoso crepé que se desliza sobre la figura, presenta un escote [tipo de escote, ej: asimétrico, halter, barco] que acentúa sutilmente los hombros. Su corte [tipo de corte, ej: sirena, recto, imperio] y su caída fluida aseguran un movimiento grácil y una presencia inolvidable. Ideal para la mujer que encuentra la fuerza en la simplicidad.', 150000.00, 5, 6, '../images/productos/prod_6872af514edf7.jpg', 'activo'),
(10, 'Pantalon para tiendas', 'hola mundo funcional ', 15000.00, 5, 4, '../images/productos/prod_6872b5515aa56.png', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_color`
--

CREATE TABLE `producto_color` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(240, 10, 16, NULL),
(241, 10, 12, NULL),
(242, 10, 39, NULL),
(243, 10, 42, NULL),
(244, 10, 44, NULL),
(245, 10, 8, NULL),
(246, 10, 4, NULL),
(247, 10, 11, NULL),
(248, 10, 6, NULL),
(249, 10, 7, NULL),
(250, 10, NULL, 'power'),
(251, 8, 17, NULL),
(252, 8, 14, NULL),
(253, 8, 11, NULL),
(254, 8, NULL, 'manzana'),
(255, 9, 16, NULL),
(256, 9, 17, NULL),
(257, 9, 18, NULL),
(258, 9, 12, NULL),
(259, 9, 39, NULL),
(260, 9, 41, NULL),
(261, 9, 42, NULL),
(262, 9, 43, NULL),
(263, 9, 13, NULL),
(264, 9, 44, NULL),
(265, 9, 45, NULL),
(266, 9, 46, NULL),
(267, 9, 47, NULL),
(268, 9, 48, NULL),
(269, 9, 8, NULL),
(270, 9, 49, NULL),
(271, 9, 9, NULL),
(272, 9, 14, NULL),
(273, 9, 10, NULL),
(274, 9, 15, NULL),
(275, 9, 4, NULL),
(276, 9, 3, NULL),
(277, 9, 2, NULL),
(278, 9, 11, NULL),
(279, 9, 5, NULL),
(280, 9, 1, NULL),
(281, 9, 6, NULL),
(282, 9, 7, NULL),
(283, 9, NULL, 'pera');

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
(0, 123456, 'ADMIN', 'garcialarry575@gmail.com', 'Laxgames', '$2y$10$/4INQHAFlfcLY5oYmm2CHefGjTX21yDepySgU/tso.whLt5dNLphu', '2025-07-12 18:25:19', '6872a8a9aacb6_ef55a22cd332a58db2b3fe81c4d9384e.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias_ropa`
--
ALTER TABLE `categorias_ropa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `producto_color`
--
ALTER TABLE `producto_color`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `color_id` (`color_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `producto_color`
--
ALTER TABLE `producto_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto_talla`
--
ALTER TABLE `producto_talla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

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
-- Filtros para la tabla `producto_color`
--
ALTER TABLE `producto_color`
  ADD CONSTRAINT `producto_color_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `producto_color_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id`) ON DELETE CASCADE;

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
