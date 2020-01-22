-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 22-01-2020 a las 12:49:09
-- Versión del servidor: 5.7.28-0ubuntu0.18.04.4
-- Versión de PHP: 7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pyme`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`jorge`@`localhost` PROCEDURE `generarReporte` (IN `idDepartamento` INT)  BEGIN
	DECLARE nombreD VARCHAR(50);
    SELECT nombre INTO nombreD FROM departamento WHERE id = idDepartamento;
    
    
    INSERT INTO reporte VALUES(
        DEFAULT,
        CURRENT_DATE,
        nombreD,
        totalTareasHechas(idDepartamento),
        totalTareasNoHechas(idDepartamento),
        totalHorasTareas(idDepartamento),
        totalHorasPromedioTareas(idDepartamento),
        totalHorasLibre(idDepartamento),
        totalHorasPromedioLibre(idDepartamento),
        usuarioMaxTareas(idDepartamento),
        usuarioMinTareas(idDepartamento),
        MaxTareas(idDepartamento),
        MinTareas(idDepartamento));
        
    
END$$

--
-- Funciones
--
CREATE DEFINER=`jorge`@`localhost` FUNCTION `MaxTareas` (`idDepartamento` INT) RETURNS INT(11) BEGIN
	DECLARE cantidad INT;
    
    SELECT COUNT(t.hoja_tiempo) AS tareas INTO cantidad
    FROM usuario u 
    INNER JOIN hoja_de_tiempo h ON u.cedula = h.usuario 
    INNER JOIN tarea t ON h.id = t.hoja_tiempo 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento GROUP BY t.hoja_tiempo ORDER BY tareas DESC LIMIT 1;

    
    RETURN cantidad;
END$$

CREATE DEFINER=`jorge`@`localhost` FUNCTION `MinTareas` (`idDepartamento` INT) RETURNS INT(11) BEGIN
	DECLARE cantidad INT;
    
    SELECT COUNT(t.hoja_tiempo) AS tareas INTO cantidad
    FROM usuario u 
    INNER JOIN hoja_de_tiempo h ON u.cedula = h.usuario 
    INNER JOIN tarea t ON h.id = t.hoja_tiempo 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento GROUP BY t.hoja_tiempo ORDER BY tareas ASC LIMIT 1;

    
    RETURN cantidad;
END$$

CREATE DEFINER=`jorge`@`localhost` FUNCTION `totalHorasLibre` (`idDepartamento` INT) RETURNS TIME BEGIN
	DECLARE tiempo TIME;
    
    SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(h.lunes)+TIME_TO_SEC(h.martes)+TIME_TO_SEC(h.miercoles)+TIME_TO_SEC(h.jueves)+TIME_TO_SEC(h.viernes))) INTO tiempo 
    FROM hoja_de_tiempo h 
    INNER JOIN usuario u ON h.usuario = u.cedula 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento;

    
    RETURN tiempo;
END$$

CREATE DEFINER=`jorge`@`localhost` FUNCTION `totalHorasPromedioLibre` (`idDepartamento` INT) RETURNS TIME BEGIN
	DECLARE tiempo TIME;
    
    SELECT SEC_TO_TIME(FLOOR(AVG((TIME_TO_SEC(h.lunes)+TIME_TO_SEC(h.martes)+TIME_TO_SEC(h.miercoles)+TIME_TO_SEC(h.jueves)+TIME_TO_SEC(h.viernes)) DIV 5))) INTO tiempo 
    FROM hoja_de_tiempo h 
    INNER JOIN usuario u ON h.usuario = u.cedula 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento;

    
    RETURN tiempo;
END$$

CREATE DEFINER=`jorge`@`localhost` FUNCTION `totalHorasPromedioTareas` (`idDepartamento` INT) RETURNS TIME BEGIN
	DECLARE tiempo TIME;
    
    SELECT SEC_TO_TIME(FLOOR(AVG((TIME_TO_SEC(t.lunes)+TIME_TO_SEC(t.martes)+TIME_TO_SEC(t.miercoles)+TIME_TO_SEC(t.jueves)+TIME_TO_SEC(t.viernes)) DIV 5))) INTO tiempo 
    FROM tarea t 
    INNER JOIN hoja_de_tiempo h ON t.hoja_tiempo = h.id 
    INNER JOIN usuario u ON h.usuario = u.cedula 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento;

    
    RETURN tiempo;
END$$

CREATE DEFINER=`jorge`@`localhost` FUNCTION `totalHorasTareas` (`idDepartamento` INT) RETURNS TIME BEGIN
	DECLARE tiempo TIME;
    
    SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(t.lunes)+TIME_TO_SEC(t.martes)+TIME_TO_SEC(t.miercoles)+TIME_TO_SEC(t.jueves)+TIME_TO_SEC(t.viernes))) INTO tiempo 
    FROM tarea t 
    INNER JOIN hoja_de_tiempo h ON t.hoja_tiempo = h.id 
    INNER JOIN usuario u ON h.usuario = u.cedula 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento;

    
    RETURN tiempo;
END$$

CREATE DEFINER=`jorge`@`localhost` FUNCTION `totalTareasHechas` (`idDepartamento` INT) RETURNS INT(11) BEGIN
	DECLARE cantidad INT;
    
    SELECT COUNT(t.id) INTO cantidad
    FROM tarea t 
    INNER JOIN hoja_de_tiempo h ON t.hoja_tiempo = h.id 
    INNER JOIN usuario u ON h.usuario = u.cedula 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento;
    
    RETURN cantidad;
END$$

CREATE DEFINER=`jorge`@`localhost` FUNCTION `totalTareasNoHechas` (`idDepartamento` INT) RETURNS INT(11) BEGIN
	DECLARE cantidad INT;
    
    SELECT COUNT(t.id) INTO cantidad
    FROM tarea t 
    INNER JOIN proyecto p ON t.proyecto = p.id 
    WHERE t.hoja_tiempo IS NULL AND t.fecha_limite BETWEEN CURRENT_DATE-7 AND CURRENT_DATE AND p.departamento = idDepartamento;

    
    RETURN cantidad;
END$$

CREATE DEFINER=`jorge`@`localhost` FUNCTION `usuarioMaxTareas` (`idDepartamento` INT) RETURNS VARCHAR(50) CHARSET latin1 BEGIN
	DECLARE nombre VARCHAR(50);
    
    SELECT CONCAT(u.nombre, ' ', u.apellido1, ' ', u.apellido2) INTO nombre 
    FROM usuario u 
    INNER JOIN hoja_de_tiempo h ON u.cedula = h.usuario 
    INNER JOIN tarea t ON h.id = t.hoja_tiempo 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento GROUP BY t.hoja_tiempo ORDER BY COUNT(t.hoja_tiempo) DESC LIMIT 1;

    
    RETURN nombre;
END$$

CREATE DEFINER=`jorge`@`localhost` FUNCTION `usuarioMinTareas` (`idDepartamento` INT) RETURNS VARCHAR(50) CHARSET latin1 BEGIN
	DECLARE nombre VARCHAR(50);
    
    SELECT CONCAT(u.nombre, ' ', u.apellido1, ' ', u.apellido2) INTO nombre 
    FROM usuario u 
    INNER JOIN hoja_de_tiempo h ON u.cedula = h.usuario 
    INNER JOIN tarea t ON h.id = t.hoja_tiempo 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento GROUP BY t.hoja_tiempo ORDER BY COUNT(t.hoja_tiempo) ASC LIMIT 1;

    
    RETURN nombre;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `administrador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id`, `nombre`, `administrador`) VALUES
(1, 'administracion', 2222),
(3, 'desarrollo', 4444);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hoja_de_tiempo`
--

CREATE TABLE `hoja_de_tiempo` (
  `id` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_finalizacion` datetime DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `comentarios` varchar(500) DEFAULT NULL,
  `lunes` time DEFAULT NULL,
  `martes` time DEFAULT NULL,
  `miercoles` time DEFAULT NULL,
  `jueves` time DEFAULT NULL,
  `viernes` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `hoja_de_tiempo`
--

INSERT INTO `hoja_de_tiempo` (`id`, `usuario`, `fecha_creacion`, `fecha_finalizacion`, `estado`, `comentarios`, `lunes`, `martes`, `miercoles`, `jueves`, `viernes`) VALUES
(12, 3333, '2020-01-15 00:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 5555, '2020-01-15 00:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 6666, '2020-01-15 00:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 7777, '2020-01-15 00:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  `departamento` int(11) NOT NULL,
  `administrador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `departamento` varchar(50) NOT NULL,
  `tareas_realizadas` int(11) NOT NULL,
  `tareas_no_realizadas` int(11) NOT NULL,
  `tiempo_tareas` time NOT NULL,
  `tiempo_promedio_tarea` time NOT NULL,
  `tiempo_libre` time NOT NULL,
  `tiempo_promedio_libre` time NOT NULL,
  `usuario_max_tareas` varchar(40) NOT NULL,
  `usuario_min_tareas` varchar(40) NOT NULL,
  `max_tareas` int(11) NOT NULL,
  `min_tareas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE `tarea` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `fecha_limite` date NOT NULL,
  `proyecto` int(11) NOT NULL,
  `hoja_tiempo` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `lunes` time DEFAULT NULL,
  `martes` time DEFAULT NULL,
  `miercoles` time DEFAULT NULL,
  `jueves` time DEFAULT NULL,
  `viernes` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `cedula` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido1` varchar(45) NOT NULL,
  `apellido2` varchar(45) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `contrasena` varchar(60) NOT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `departamento` int(11) NOT NULL,
  `posicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`cedula`, `nombre`, `apellido1`, `apellido2`, `correo`, `contrasena`, `telefono`, `departamento`, `posicion`) VALUES
(1111, 'ricardo', 'rodriguez', 'alfaro', 'ricardo@ejemplo.com', '$2y$10$/9NidkRAzQa.Y2f0wO19J.LmZCadkXbhXkthc.DChz9XulF4nQNMC', '888888', 1, 0),
(2222, 'Rodrigo', 'Rodriguez', 'Rodriguez', 'rrr@ejemplo.com', '$2y$10$Pi3tTNE7iuRxzv7n0J0Vq.MdQs1dDhX9eBH1Pq/0ra0rRc3FLUfU6', '888888', 1, 1),
(3333, 'Josue', 'torres', 'torres', 'jtt@ejemplo.com', '$2y$10$t6sXk6BODkArE1Asj3Gyi.GFxDTrnRyHM5a/MQkonIIelbS9EXwpa', '888888', 1, 2),
(4444, 'kevin', 'alfaro', 'alfaro', 'kaa@ejemplo.com', '$2y$10$PNmjZs8YxG5cUPIh3n4dXOKbxIsK9CG55MMWM6N7h24YQg5fZtI46', '888888', 3, 1),
(5555, 'Victor', 'Quiros', 'Quiros', 'vqq@ejemplo.com', '$2y$10$jGUK3sSNAXmDSWuW8PDIU.rkg.psQFWB9/0F/nZNvEegR9TJrjN42', '888888', 3, 2),
(6666, 'roberto', 'venegas', 'venegas', 'rvv@ejemplo.com', '$2y$10$5v3Itt1MXPWcKwg1C9UI5.6JVU69QyBLnKntp1Ugbh3H3zpubcKIS', '888888', 1, 2),
(7777, 'jose', 'villalobos', 'villalobos', 'jvv@ejemplo.com', '$2y$10$UteHxS2uu23iPw8ik5HOWet8Of8AW4/2WlPnlnTBr8IuQJ6XWTeWO', '888888', 3, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_administrador` (`administrador`);

--
-- Indices de la tabla `hoja_de_tiempo`
--
ALTER TABLE `hoja_de_tiempo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tarea_proyecto` (`proyecto`),
  ADD KEY `fk_tarea_hojatiempo` (`hoja_tiempo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cedula`),
  ADD KEY `fk_usuario_departamento` (`departamento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `hoja_de_tiempo`
--
ALTER TABLE `hoja_de_tiempo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD CONSTRAINT `fk_tarea_hojatiempo` FOREIGN KEY (`hoja_tiempo`) REFERENCES `hoja_de_tiempo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tarea_proyecto` FOREIGN KEY (`proyecto`) REFERENCES `proyecto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_departamento` FOREIGN KEY (`departamento`) REFERENCES `departamento` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
