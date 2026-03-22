-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-10-2025 a las 03:36:20
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
-- Base de datos: `proyecto_ventas`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarComprasDetalle` (IN `identificacion` INT)   BEGIN
  SELECT 
    v.numeroFactura,
    v.fechaVenta,
    v.metodoPago,
    v.estado,
    pv.FK_CodigoBarras AS codigoBarras,
    pr.nombre        AS producto,
    pv.cantidad      AS cantidad,
    pr.precio        AS precio_unitario,
    (pv.cantidad * pr.precio) AS subtotal,
    t.nombre         AS transportador,
    CONCAT(c.nombres, ' ', c.apellidos) AS cliente
  FROM venta v
    JOIN producto_venta pv ON v.numeroFactura = pv.FK_NumeroFactura
    JOIN producto pr ON pv.FK_CodigoBarras = pr.codigoBarras
    LEFT JOIN transportador t ON v.FK_IdTransportador = t.idTransportador
    LEFT JOIN cliente c ON v.FK_IdentificacionCliente = c.numeroIdentificacion
  WHERE v.FK_IdentificacionCliente = identificacion
  ORDER BY v.fechaVenta DESC, v.numeroFactura, pr.nombre;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `numeroIdentificacion` int(11) NOT NULL,
  `nombres` varchar(30) DEFAULT NULL,
  `apellidos` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `contraseña` varchar(50) NOT NULL,
  `ROL` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`numeroIdentificacion`, `nombres`, `apellidos`, `telefono`, `correo`, `contraseña`, `ROL`) VALUES
(101, 'Laura', 'Martínez', '3001112233', 'laura.martinez@example.com', 'clave123', 'Cliente'),
(102, 'Carlos', 'Gómez', '3002223344', 'carlos.gomez@example.com', 'clave456', 'Cliente'),
(103, 'Ana', 'Ruiz', '3003334455', 'ana.ruiz@example.com', 'clave789', 'Cliente'),
(104, 'Julián', 'Fernández', '3004445566', 'julian.fernandez@example.com', 'clave321', 'Cliente'),
(777, 'Brayan', 'García', '3044139270', 'brayandavid1720@gmail.com', '123', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `identificacion` int(11) NOT NULL,
  `nombres` varchar(30) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `ROL` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`identificacion`, `nombres`, `telefono`, `email`, `contraseña`, `ROL`) VALUES
(201, 'Sofía López', '3101112233', 'sofia.lopez@example.com', 'empleado123', 'Empleado'),
(202, 'Andrés Pérez', '3102223344', 'andres.perez@example.com', 'empleado456', 'Empleado'),
(203, 'Mariana Torres', '3103334455', 'mariana.torres@example.com', 'empleado789', 'Empleado'),
(1141514822, 'Brayan David', '3044139270', 'brayandavid1720@gmail.com', '200617el', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_producto`
--

CREATE TABLE `imagenes_producto` (
  `id` int(11) NOT NULL,
  `codigoBarras` int(11) NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigoBarras` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `categoria` varchar(30) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `imagen` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigoBarras`, `nombre`, `categoria`, `precio`, `stock`, `descripcion`, `imagen`) VALUES
(1001, 'Coca Cola 1.5L', 'Bebidas', 4500.00, 100, 'Refresco gaseoso sabor cola', 'coca_cola.jpg'),
(1002, 'Papas Margarita 150g', 'Snacks', 3500.00, 80, 'Papas fritas sabor natural', 'margarita.jpg'),
(1003, 'Chocolate Jet 12g', 'Dulces', 800.00, 200, 'Chocolate de leche colombiano', 'jet.jpg'),
(1004, 'Agua Cristal 600ml', 'Bebidas', 2000.00, 120, 'Agua pura sin gas', 'cristal.jpg'),
(1005, 'Cerveza Poker 330ml', 'Bebidas', 3500.00, 90, 'Cerveza rubia colombiana', 'poker.jpg'),
(74545112, 'Cerveza Coronita 210 Ml X6 Und', 'Bebidas', 19400.00, 35, 'Tipo de cerveza: Lager. ABV: 4,5% Corona es una invitación para salir y relajarse. Corona ha estado complementando los momentos sencillos de la vida desde 1925, y ahora se disfruta en más de 180 paíse', 'coronita.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_venta`
--

CREATE TABLE `producto_venta` (
  `idProductoVenta` int(11) NOT NULL,
  `FK_NumeroFactura` int(11) DEFAULT NULL,
  `FK_CodigoBarras` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_venta`
--

INSERT INTO `producto_venta` (`idProductoVenta`, `FK_NumeroFactura`, `FK_CodigoBarras`, `cantidad`) VALUES
(1, 5001, 1001, 2),
(2, 5001, 1002, 1),
(3, 5002, 1005, 6),
(4, 5003, 1003, 5),
(5, 5003, 1004, 2),
(6, 5004, 1002, 3),
(7, 5004, 1001, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transportador`
--

CREATE TABLE `transportador` (
  `idTransportador` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `vehiculo` varchar(30) DEFAULT NULL,
  `placa` varchar(20) DEFAULT NULL,
  `calificacion` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transportador`
--

INSERT INTO `transportador` (`idTransportador`, `nombre`, `telefono`, `correo`, `vehiculo`, `placa`, `calificacion`) VALUES
(1, 'Luis Ramírez', '3201112233', 'luis.ramirez@transporte.com', 'Moto', 'ABC123', '5 estrellas'),
(2, 'Camila Díaz', '3202223344', 'camila.diaz@transporte.com', 'Camioneta', 'XYZ987', '4 estrellas'),
(3, 'Pedro Sánchez', '3203334455', 'pedro.sanchez@transporte.com', 'Carro', 'JKL456', '4.5 estrellas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `numeroFactura` int(11) NOT NULL,
  `fechaVenta` date DEFAULT NULL,
  `metodoPago` varchar(30) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `comentarios` varchar(100) DEFAULT NULL,
  `FK_IdentificacionCliente` int(11) DEFAULT NULL,
  `FK_IdentificacionEmpleado` int(11) DEFAULT NULL,
  `FK_IdTransportador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`numeroFactura`, `fechaVenta`, `metodoPago`, `estado`, `comentarios`, `FK_IdentificacionCliente`, `FK_IdentificacionEmpleado`, `FK_IdTransportador`) VALUES
(5001, '2025-09-01', 'Efectivo', 'Entregado', 'Compra de bebidas y snacks', 101, 201, 1),
(5002, '2025-09-02', 'Tarjeta', 'Pendiente', 'Entrega programada', 102, 202, 2),
(5003, '2025-09-03', 'Transferencia', 'Entregado', 'Compra rápida', 103, 203, 1),
(5004, '2025-09-04', 'Efectivo', 'En camino', 'Incluye productos pesados', 104, 202, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`numeroIdentificacion`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codigoBarras` (`codigoBarras`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigoBarras`);

--
-- Indices de la tabla `producto_venta`
--
ALTER TABLE `producto_venta`
  ADD PRIMARY KEY (`idProductoVenta`),
  ADD KEY `FK_NumeroFactura` (`FK_NumeroFactura`),
  ADD KEY `FK_CodigoBarras` (`FK_CodigoBarras`);

--
-- Indices de la tabla `transportador`
--
ALTER TABLE `transportador`
  ADD PRIMARY KEY (`idTransportador`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`numeroFactura`),
  ADD KEY `FK_IdentificacionCliente` (`FK_IdentificacionCliente`),
  ADD KEY `FK_IdentificacionEmpleado` (`FK_IdentificacionEmpleado`),
  ADD KEY `FK_IdTransportador` (`FK_IdTransportador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `producto_venta`
--
ALTER TABLE `producto_venta`
  MODIFY `idProductoVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `transportador`
--
ALTER TABLE `transportador`
  MODIFY `idTransportador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `numeroFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5005;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD CONSTRAINT `imagenes_producto_ibfk_1` FOREIGN KEY (`codigoBarras`) REFERENCES `producto` (`codigoBarras`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_venta`
--
ALTER TABLE `producto_venta`
  ADD CONSTRAINT `producto_venta_ibfk_1` FOREIGN KEY (`FK_NumeroFactura`) REFERENCES `venta` (`numeroFactura`),
  ADD CONSTRAINT `producto_venta_ibfk_2` FOREIGN KEY (`FK_CodigoBarras`) REFERENCES `producto` (`codigoBarras`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`FK_IdentificacionCliente`) REFERENCES `cliente` (`numeroIdentificacion`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`FK_IdentificacionEmpleado`) REFERENCES `empleado` (`identificacion`),
  ADD CONSTRAINT `venta_ibfk_3` FOREIGN KEY (`FK_IdTransportador`) REFERENCES `transportador` (`idTransportador`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
