-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2024 a las 23:39:23
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
-- Base de datos: `sistema_web`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

CREATE TABLE `carritos` (
  `id_carrito` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carritos`
--

INSERT INTO `carritos` (`id_carrito`, `id_cliente`, `fecha_creacion`) VALUES
(3, 48, '2024-05-31 01:24:06'),
(4, 47, '2024-05-31 01:24:40'),
(5, 46, '2024-05-31 01:25:00'),
(6, 49, '2024-05-31 07:01:06'),
(7, 56, '2024-05-31 08:19:27'),
(8, 60, '2024-05-31 08:20:37'),
(9, 63, '2024-12-02 23:22:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(50) NOT NULL,
  `email_cliente` varchar(50) NOT NULL,
  `clave_cliente` varchar(255) NOT NULL,
  `telefono_cliente` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `email_cliente`, `clave_cliente`, `telefono_cliente`) VALUES
(46, 'Alan Josafat', 'tigrealan16@gmail.com', '$2y$10$BaIr2zgbRY/EHJl4wiCwEu8o79V8/4y8z9i.vuLxc1sRYfJrfhEha', 81231241),
(47, 'Roberto Ambriz', 'rober@gmail.com', '$2y$10$rDTZkCU4V6SnduGKWppoa.dgepqIpnsusLHexGEkQ35/teF7P4guq', 818464843),
(48, 'Ivan Castillo', 'ivan@gmail.com', '$2y$10$rgEMjvBsjzkCE/XYfPv6p.x3MIU1H71Z/lPPnavaql5lxUp8x4nHi', 816486414),
(49, 'Kenia Ramirez', 'KenRa893@gmail.com', '$2y$10$3aYlm7bGQVe4Kbl6.QiXmeGAznfklnWKuI.XFR.mZvOtt08be2oBq', 2147483647),
(50, 'Antonio JR', 'JrAnton32@gmail.com', '$2y$10$R2tbzxpjj3RRjMEUrHYJ4uG4cYjF9mBI.8mkL2vn5EFmqv1.V1ia2', 2147483647),
(51, 'Jose Angel', 'Jmon1999@gmail.com', '$2y$10$i8v0J/d6LMV3gL/54ZtNHetrzWX7aj1D5.uKxUOiosyJRSiwwRXZ.', 212546374),
(52, 'Brisa Guadalupe', 'Briss23443@gmail.com', '$2y$10$s98yc2ZpQ0IfZZmQ/d.eC..yvBfyOuDsllo804w/Ay0vuQ6wq4Xw2', 2147483647),
(53, 'Yahir', 'Yaya84839@gmail.com', '$2y$10$sVBA3kPpdLlyQmo1GR534.AFOYkssSPG6eJokQYwUobOz7Bs4ElsW', 2147483647),
(54, 'Jaime Mendez', 'JM234@gmail.com', '$2y$10$ByDu1tetXXR8f3G9DWybKOh2c9/qdhBkQWTA0eB0s68uDvc.zBMbq', 2147483647),
(55, 'Nereyda Gaytan', 'NereG2424@gmail.com', '$2y$10$EpER/UqT1G95Ymk4CD6stelw7szTpZMkAHKpMIDAzsAYnkxuDg9/W', 2147483647),
(56, 'Alejandra Toral', 'Aleto655@gmail.com', '$2y$10$4461QLqRjRlPo.YrlCNgAuL3b3egYArGMEOVneDXe5wTvbaPFLxgy', 2147483647),
(57, 'Aza Sanz', 'Azzzz3404@gmail.com', '$2y$10$OS8xn414IED4DV42O4AXheOBp4xYqp4YtXBe6F0wnwyLpukkFUNci', 815875643),
(58, 'Cesar Garcia', 'Cega03030@gmail.com', '$2y$10$Na295F08ix88HEWoQKQHA.I5k6yA6ZoNGgCDQdWuHplpfvrjXAWWe', 2147483647),
(59, 'Maria Lourdes', 'MariLU244535@gmail.com', '$2y$10$mcA7B5IcsrFXFKef5yPZzOSRSoIVpZy54C5rZ.7gq9j.a9wOZo8BS', 92458383),
(60, 'Estrella ', 'estre2323@gmail.com', '$2y$10$7OZWoRCrwhvgjSA1iYvCQOJ60nZs8MTF1G0/yFDir4ZJrEfVCwVCa', 848393884),
(61, 'Estefany Leija', 'Esle34565@gmail.com', '$2y$10$o9m2bO7GEIOkwICJCTaB5upNbGi781EQD2HJzU7YT3WKZkpmU55jS', 98765436),
(62, 'Brandon Zavala', 'Brya28932@gmail.com', '$2y$10$J7R5pHSMh7zqcXb5RwEoROC13IE.sTDlBH/X/iR11lsngvQYwrdqm', 876543456),
(63, 'Alan', 'tigrealan30@gmail.com', '$2y$10$lLOYD95VETg1e/9EXSsWvOjnOve5MHaHhSEAP4.wBaIKeP1ZeGKgm', 2147483647),
(64, 'elbobby', 'elbobby@gmail.com', '$2y$10$rMMFzn.j1hnPlhQP4t8Q2OSouo74CVSaVtz0.WQI02gwyLe26Lr6m', 27185368),
(65, 'fernando lopez', 'fer@gmail.com', '$2y$10$eFZB/qfWKxWNB.ROK3xFlOnSzUG/0rRe2JgNb6JdCxVlzPGq/GqZa', 2147483647),
(66, 'Ivan', 'ivanc@gmail.com', '$2y$10$PRHSJ3Eav/SYqELPykQKi.Ab248pPVnHtaZy9YCJFERTjh/NsXGNW', 12345678);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes_baneados`
--

CREATE TABLE `clientes_baneados` (
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `email_cliente` varchar(255) NOT NULL,
  `clave_cliente` varchar(255) NOT NULL,
  `telefono_cliente` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes_baneados`
--

INSERT INTO `clientes_baneados` (`id_cliente`, `nombre_cliente`, `email_cliente`, `clave_cliente`, `telefono_cliente`) VALUES
(46, 'Alan Josafat', 'tigrealan16@gmail.com', '', '81231241');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_carrito`
--

CREATE TABLE `detalle_carrito` (
  `id_detalle` int(11) NOT NULL,
  `id_carrito` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_carrito`
--

INSERT INTO `detalle_carrito` (`id_detalle`, `id_carrito`, `id_producto`, `cantidad`) VALUES
(5, 3, 1, 1),
(6, 3, 2, 1),
(7, 3, 6, 1),
(8, 4, 1, 1),
(9, 5, 6, 1),
(10, 5, 2, 1),
(11, 6, 6, 1),
(12, 6, 2, 1),
(13, 6, 9, 1),
(14, 6, 11, 1),
(15, 7, 8, 1),
(16, 7, 33, 1),
(17, 7, 28, 1),
(18, 8, 7, 1),
(19, 8, 8, 1),
(20, 8, 10, 1),
(21, 8, 16, 1),
(22, 8, 20, 1),
(23, 8, 23, 1),
(24, 8, 33, 1),
(25, 9, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `accion` enum('agregar','eliminar','actualizar') NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informes`
--

CREATE TABLE `informes` (
  `id` int(11) NOT NULL,
  `nombre_informe` varchar(255) NOT NULL,
  `ruta_informe` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `informes`
--

INSERT INTO `informes` (`id`, `nombre_informe`, `ruta_informe`, `fecha_creacion`) VALUES
(11, 'Informe 2024-05-31 08:09:50', 'informes/informe_20240531_080950.csv', '2024-05-31 06:09:50'),
(12, 'Informe 2024-05-31 08:18:42', 'informes/informe_20240531_081842.csv', '2024-05-31 06:18:42'),
(13, 'Informe 2024-05-31 08:30:49', 'informes/informe_20240531_083049.csv', '2024-05-31 06:30:49'),
(14, 'Informe 2024-05-31 08:30:49', 'informes/informe_20240531_083049.csv', '2024-05-31 06:30:49'),
(15, 'Informe 2024-05-31 08:32:09', 'informes/informe_20240531_083209.csv', '2024-05-31 06:32:09'),
(16, 'Informe 2024-05-31 08:32:09', 'informes/informe_20240531_083209.csv', '2024-05-31 06:32:09'),
(17, 'Informe 2024-05-31 08:43:16', 'informes/informe_20240531_084316.csv', '2024-05-31 06:43:16'),
(18, 'Informe 2024-05-31 08:43:16', 'informes/informe_20240531_084316.csv', '2024-05-31 06:43:16'),
(19, 'Informe 2024-05-31 09:02:39', 'informes/informe_20240531_090239.csv', '2024-05-31 07:02:39'),
(20, 'Informe 2024-05-31 09:02:40', 'informes/informe_20240531_090240.csv', '2024-05-31 07:02:40'),
(21, 'Informe 2024-05-31 10:21:48', 'informes/informe_20240531_102148.csv', '2024-05-31 08:21:48'),
(22, 'Informe 2024-05-31 10:21:48', 'informes/informe_20240531_102148.csv', '2024-05-31 08:21:48'),
(23, 'Informe 2024-05-31 10:22:36', 'informes/informe_20240531_102236.csv', '2024-05-31 08:22:36'),
(24, 'Informe 2024-05-31 10:22:37', 'informes/informe_20240531_102237.csv', '2024-05-31 08:22:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(30) NOT NULL,
  `descripcion_producto` text DEFAULT NULL,
  `precio_producto` double(6,2) NOT NULL,
  `cantidad_producto` int(9) NOT NULL,
  `imagen_producto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_producto`, `nombre_producto`, `descripcion_producto`, `precio_producto`, `cantidad_producto`, `imagen_producto`) VALUES
(1, 'Marcador Sharpie', 'Marcador Sharpie Fino Negro (4 Piezas)', 75.00, 2, 'uploads/40067.jpg'),
(2, 'Lápices de Grafito', 'Lápices de Grafito Hexagonales Staedtler HB No.2 A', 48.00, 6, 'uploads/22041.jpg'),
(6, 'Prismacolor Junior  ', '12 Lápices de colores, doble punta, 24 Colores int', 70.00, 30, 'uploads/92714.jpg'),
(7, 'Plumas Paper Mate', 'Plumas Paper Mate Kilométrico InkJoy 100 / Punto mediano / Tinta azul / 12 piezas\r\n', 48.00, 11, 'uploads/pluma azul.jpg'),
(8, 'Libreta Profesional Scribe', 'Cuaderno Profesional Scribe Mario Bros Cuadro Chico 100 hojas', 85.00, 14, 'uploads/libretaMario.jpg'),
(9, 'Cuaderno Profesional Arimany', 'Cuaderno Profesional Arimany Harry Potter Raya 100 hojas', 129.00, 14, 'uploads/Libretahp.jpg'),
(10, 'Regla en T Maped', 'Nombre: Regla en T Maped Technic \r\nModelo: 1302I100F\r\nColor: Madera\r\nCantidad: 1 pieza\r\nMedidas: 100 cm', 550.00, 28, 'uploads/Regla t.jpg'),
(11, 'Corrector Líquido', 'Corrector Líquido en Brocha Kores Aqua 20 ml', 22.00, 17, 'uploads/correctorliqu.jpg'),
(12, 'Corrector Cinta', 'Corrector en Cinta Kores Roll On 15 m x 4.2 mm', 50.00, 25, 'uploads/correctorcint.jpg'),
(13, 'Plumas Bic Crista', 'Plumas Bic Cristal Dura Más / Punto mediano / Tinta negra roja azul verde / 10 piezas', 50.00, 12, 'uploads/PlumasMulticolor.jpg'),
(14, 'Lápices de Colores', 'Lápices de Colores Pastel Prismacolor / 24 piezas / 4.0mm', 220.00, 8, 'uploads/PrimaPastel.jpg'),
(15, 'Gomas de Borrar', 'Gomas de Borrar Maped Migasoft Migajón Blanco 2 piezas', 25.00, 15, 'uploads/Gomas.jpg'),
(16, 'TIJERAS MAPED', 'TIJERAS MAPED ULTIMATE (21 CM, 1 PZA.)', 85.00, 11, 'uploads/tijeras1.jpg'),
(17, 'Cuaderno Italiana', 'Cuaderno Italiana Scribe Cover Raya Cosido 100 hojas', 60.00, 24, 'uploads/LibretaItal.jpg'),
(18, 'Cuaderno Italiana', 'Cuaderno Italiana Scribe Cover Cuadro Chico Cosido 100 hojas\r\n', 60.00, 25, 'uploads/LibretaItal1.jpg'),
(19, 'Lapicera Escolar', 'Lapicera Escolar Sablón Wacky Oval 3 Divisiones Azul', 105.00, 20, 'uploads/lapicero.jpg'),
(20, 'Marcatextos', 'Marcatextos Azor Visión Plus Pastel Punta Cincel Colores 5 piezas', 80.00, 43, 'uploads/Marcatexto.jpg'),
(21, 'Hojas P/Carpeta', 'Hojas para Carpeta Kyma Carta Blanco 100 Hojas', 70.00, 23, 'uploads/hojasC.jpg'),
(22, 'Carpeta Escolar', 'Carpeta Escolar European Raya 80 Hojas', 240.00, 12, 'uploads/CarpetaEscolar.jpg'),
(23, 'Lápices de Colores Staedtler', 'Lápices de Colores Hexagonales Staedtler 175 C24A6 / 24 piezas', 145.00, 5, 'uploads/coloresSta.jpg'),
(24, 'Acuarelas Kores', 'Acuarelas Kores Akuarellos 12 Colores', 60.00, 3, 'uploads/Acuarela.jpg'),
(25, 'Cinta Adhesiva', 'Cinta Súper Adhesiva 3M Scotch / Transparente / 19 mm x 25.4 m / 1 píeza\r\n', 35.00, 18, 'uploads/Cinta.jpg'),
(26, 'MARCADOR PAPERMATE', 'MARCADOR PAPERMATE EXPO FASHION (COLORES, 4 PZS.)', 95.00, 4, 'uploads/Marcador.jpg'),
(27, 'Papel Bond', 'Papel Bond Carta Navigator Multipurpose / Paquete 500 hojas blancas', 130.00, 4, 'uploads/papelBo.jpg'),
(28, 'Papel Reciclado', 'Papel Reciclado Oficio Office Depot Ecológico / Paquete 500 hojas blancas', 120.00, 7, 'uploads/PapelEco.jpg'),
(29, 'Papel Texturizado', 'Papel Texturizado Pochteca Temoaya / 50 hojas / Carta / Blanco / 90 gr', 175.00, 2, 'uploads/Papel Texturizado.jpg'),
(30, 'Papel Crepé', 'Papel Crepé Mercería La Principal Colores', 25.00, 18, 'uploads/Papel Crepé.jpg'),
(31, 'Calculadora', 'Calculadora de Bolsillo Spectra 10/12 dígitos', 65.00, 10, 'uploads/Calculadora.jpg'),
(32, 'Diccionario', 'Diccionario Escolar Larousse Básico', 80.00, 13, 'uploads/Diccionario.jpg'),
(33, 'Diccionario ', 'Diccionario Pocket Larousse Inglés-Español', 120.00, 19, 'uploads/DiccionarioIngles.jpg'),
(34, 'Mochila', 'Mochila para Laptop Samsonite New Work 4 15.6 pulg. Azul', 2100.00, 4, 'uploads/Mochila.jpg'),
(35, 'Mochila', 'Mochila Escolar Ruz Sonic 3D', 850.00, 2, 'uploads/MocilaSonic.jpg'),
(36, 'Compás', 'Compás Bow Precision Fancy Maped', 135.00, 8, 'uploads/Compas.jpg'),
(37, 'Juego de Geometría', 'Juego de Geometría Flexible Maped Stop System 6 piezas', 130.00, 5, 'uploads/JuegoGeo.jpg'),
(38, 'Pegamento', 'Pritt Lápiz Adhesivo / 22 gr / 2 piezas', 65.00, 10, 'uploads/pegamento.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `nombre_producto` varchar(255) DEFAULT NULL,
  `cantidad_producto` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `nombre_cliente` varchar(255) DEFAULT NULL,
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_pago` decimal(10,2) DEFAULT NULL,
  `metodo_pago` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_producto`, `nombre_producto`, `cantidad_producto`, `id_cliente`, `nombre_cliente`, `fecha_compra`, `total_pago`, `metodo_pago`) VALUES
(17, 1, 'Marcador Sharpie', 1, 47, 'Roberto Ambriz', '2024-05-31 09:24:42', 75.00, ''),
(24, 32, 'Diccionario', 1, 56, 'Alejandra Toral', '2024-05-31 16:19:46', 80.00, ''),
(25, 8, 'Libreta Profesional Scribe', 1, 56, 'Alejandra Toral', '2024-05-31 16:19:46', 85.00, ''),
(26, 33, 'Diccionario ', 1, 56, 'Alejandra Toral', '2024-05-31 16:19:46', 120.00, ''),
(27, 28, 'Papel Reciclado', 1, 56, 'Alejandra Toral', '2024-05-31 16:19:46', 120.00, ''),
(52, 2, 'Lápices de Grafito', 1, 63, 'Alan', '2024-12-03 19:31:16', 48.00, 'tienda'),
(53, 9, 'Cuaderno Profesional Arimany', 1, 63, 'Alan', '2024-12-03 19:31:54', 129.00, 'tarjeta'),
(54, 14, 'Lápices de Colores', 1, 63, 'Alan', '2024-12-03 19:32:43', 220.00, 'tarjeta'),
(55, 6, 'Prismacolor Junior  ', 1, 63, 'Alan', '2024-12-03 19:33:22', 70.00, 'tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `apellido_usuario` varchar(50) NOT NULL,
  `usuario_usuario` varchar(50) NOT NULL,
  `clave_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `apellido_usuario`, `usuario_usuario`, `clave_usuario`) VALUES
(1, 'Alicia', 'Villareal', 'licha4', '123456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `cantidad_producto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `fecha_compra` date NOT NULL,
  `total_pago` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_producto`, `nombre_producto`, `cantidad_producto`, `id_cliente`, `nombre_cliente`, `fecha_compra`, `total_pago`) VALUES
(1, 1, 'Marcador Sharpie', 1, 48, 'Ivan Castillo', '2024-05-31', 75.00),
(2, 2, 'Lápices de Grafito', 1, 48, 'Ivan Castillo', '2024-05-31', 48.00),
(3, 6, 'Prismacolor Junior  ', 1, 48, 'Ivan Castillo', '2024-05-31', 70.00),
(4, 2, 'Lápices de Grafito', 1, 49, 'Kenia Ramirez', '2024-05-31', 48.00),
(5, 9, 'Cuaderno Profesional Arimany', 1, 49, 'Kenia Ramirez', '2024-05-31', 129.00),
(6, 11, 'Corrector Líquido', 1, 49, 'Kenia Ramirez', '2024-05-31', 22.00),
(7, 6, 'Prismacolor Junior  ', 1, 49, 'Kenia Ramirez', '2024-05-31', 70.00),
(8, 7, 'Plumas Paper Mate', 1, 60, 'Estrella ', '2024-05-31', 48.00),
(9, 8, 'Libreta Profesional Scribe', 1, 60, 'Estrella ', '2024-05-31', 85.00),
(10, 10, 'Regla en T Maped', 1, 60, 'Estrella ', '2024-05-31', 550.00),
(11, 16, 'TIJERAS MAPED', 1, 60, 'Estrella ', '2024-05-31', 85.00),
(12, 20, 'Marcatextos', 1, 60, 'Estrella ', '2024-05-31', 80.00),
(13, 23, 'Lápices de Colores Staedtler', 1, 60, 'Estrella ', '2024-05-31', 145.00),
(14, 33, 'Diccionario ', 1, 60, 'Estrella ', '2024-05-31', 120.00),
(15, 6, 'Prismacolor Junior  ', 1, 46, 'Alan Josafat', '2024-05-31', 70.00),
(16, 2, 'Lápices de Grafito', 1, 46, 'Alan Josafat', '2024-05-31', 48.00),
(17, 2, 'Lápices de Grafito', 2, 63, 'Alan', '2024-12-03', 96.00),
(18, 2, 'Lápices de Grafito', 1, 63, 'Alan', '2024-12-02', 0.00),
(19, 6, 'Prismacolor Junior  ', 3, 63, '0', '2024-12-02', 210.00),
(20, 6, 'Prismacolor Junior  ', 4, 63, '0', '2024-12-02', 280.00),
(21, 11, 'Corrector Líquido', 2, 64, '0', '2024-12-03', 44.00),
(22, 8, 'Libreta Profesional Scribe', 1, 65, '0', '2024-12-03', 85.00),
(23, 6, 'Prismacolor Junior  ', 4, 66, '0', '2024-12-03', 280.00),
(24, 8, 'Libreta Profesional Scribe', 1, 63, '0', '2024-12-03', 85.00),
(25, 2, 'Lápices de Grafito', 1, 66, '0', '2024-12-03', 48.00),
(26, 10, 'Regla en T Maped', 1, 66, '0', '2024-12-03', 550.00),
(27, 6, 'Prismacolor Junior  ', 1, 66, '0', '2024-12-03', 70.00),
(28, 1, 'Marcador Sharpie', 5, 63, 'Alan', '2024-12-03', 375.00),
(29, 6, 'Prismacolor Junior  ', 2, 66, 'Ivan', '2024-12-03', 140.00),
(30, 1, 'Marcador Sharpie', 2, 63, 'Alan', '2024-12-03', 150.00),
(31, 6, 'Prismacolor Junior  ', 3, 63, 'Alan', '2024-12-03', 210.00),
(32, 23, 'Lápices de Colores Staedtler', 1, 63, 'Alan', '2024-12-03', 145.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `email_cliente` (`email_cliente`);

--
-- Indices de la tabla `clientes_baneados`
--
ALTER TABLE `clientes_baneados`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_carrito` (`id_carrito`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `informes`
--
ALTER TABLE `informes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario_usuario` (`usuario_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carritos`
--
ALTER TABLE `carritos`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `clientes_baneados`
--
ALTER TABLE `clientes_baneados`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informes`
--
ALTER TABLE `informes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD CONSTRAINT `carritos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD CONSTRAINT `detalle_carrito_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `carritos` (`id_carrito`),
  ADD CONSTRAINT `detalle_carrito_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `inventario` (`id_producto`);

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `inventario` (`id_producto`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `inventario` (`id_producto`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `inventario` (`id_producto`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
