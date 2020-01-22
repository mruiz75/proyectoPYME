--Tareas hechas

DELIMITER //
CREATE FUNCTION totalTareasHechas(idDepartamento INT) RETURNS INT
BEGIN
	DECLARE cantidad INT;
    
    SELECT COUNT(t.id) INTO cantidad
    FROM tarea t 
    INNER JOIN hoja_de_tiempo h ON t.hoja_tiempo = h.id 
    INNER JOIN usuario u ON h.usuario = u.cedula 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento;
    
    RETURN cantidad;
END//
DELIMITER ;
    

--Tareas no hechas

DELIMITER //
CREATE FUNCTION totalTareasNoHechas(idDepartamento INT) RETURNS INT
BEGIN
	DECLARE cantidad INT;
    
    SELECT COUNT(t.id) INTO cantidad
    FROM tarea t 
    INNER JOIN proyecto p ON t.proyecto = p.id 
    WHERE t.hoja_tiempo IS NULL AND t.fecha_limite BETWEEN CURRENT_DATE-7 AND CURRENT_DATE AND p.departamento = idDepartamento;

    
    RETURN cantidad;
END//
DELIMITER ;



--Total horas dedicadas a las tareas

DELIMITER //
CREATE FUNCTION totalHorasTareas(idDepartamento INT) RETURNS TIME
BEGIN
	DECLARE tiempo TIME;
    
    SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(t.lunes)+TIME_TO_SEC(t.martes)+TIME_TO_SEC(t.miercoles)+TIME_TO_SEC(t.jueves)+TIME_TO_SEC(t.viernes))) INTO tiempo 
    FROM tarea t 
    INNER JOIN hoja_de_tiempo h ON t.hoja_tiempo = h.id 
    INNER JOIN usuario u ON h.usuario = u.cedula 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento;

    
    RETURN tiempo;
END//
DELIMITER ;


--Horas promedio dedicadas a las tareas

DELIMITER //
CREATE FUNCTION totalHorasPromedioTareas(idDepartamento INT) RETURNS TIME
BEGIN
	DECLARE tiempo TIME;
    
    SELECT SEC_TO_TIME(FLOOR(AVG((TIME_TO_SEC(t.lunes)+TIME_TO_SEC(t.martes)+TIME_TO_SEC(t.miercoles)+TIME_TO_SEC(t.jueves)+TIME_TO_SEC(t.viernes)) DIV 5))) INTO tiempo 
    FROM tarea t 
    INNER JOIN hoja_de_tiempo h ON t.hoja_tiempo = h.id 
    INNER JOIN usuario u ON h.usuario = u.cedula 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento;

    
    RETURN tiempo;
END//
DELIMITER ;



--Total horas de tiempo libre

DELIMITER //
CREATE FUNCTION totalHorasLibre(idDepartamento INT) RETURNS TIME
BEGIN
	DECLARE tiempo TIME;
    
    SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(h.lunes)+TIME_TO_SEC(h.martes)+TIME_TO_SEC(h.miercoles)+TIME_TO_SEC(h.jueves)+TIME_TO_SEC(h.viernes))) INTO tiempo 
    FROM hoja_de_tiempo h 
    INNER JOIN usuario u ON h.usuario = u.cedula 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento;

    
    RETURN tiempo;
END//
DELIMITER ;


--Horas promedio libre

DELIMITER //
CREATE FUNCTION totalHorasPromedioLibre(idDepartamento INT) RETURNS TIME
BEGIN
	DECLARE tiempo TIME;
    
    SELECT SEC_TO_TIME(FLOOR(AVG((TIME_TO_SEC(h.lunes)+TIME_TO_SEC(h.martes)+TIME_TO_SEC(h.miercoles)+TIME_TO_SEC(h.jueves)+TIME_TO_SEC(h.viernes)) DIV 5))) INTO tiempo 
    FROM hoja_de_tiempo h 
    INNER JOIN usuario u ON h.usuario = u.cedula 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento;

    
    RETURN tiempo;
END//
DELIMITER ;



--Usuario con mas tareas


DELIMITER //
CREATE FUNCTION usuarioMaxTareas(idDepartamento INT) RETURNS VARCHAR(50)
BEGIN
	DECLARE nombre VARCHAR(50);
    
    SELECT CONCAT(u.nombre, ' ', u.apellido1, ' ', u.apellido2) INTO nombre 
    FROM usuario u 
    INNER JOIN hoja_de_tiempo h ON u.cedula = h.usuario 
    INNER JOIN tarea t ON h.id = t.hoja_tiempo 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento GROUP BY t.hoja_tiempo ORDER BY COUNT(t.hoja_tiempo) DESC LIMIT 1;

    
    RETURN nombre;
END//
DELIMITER ;

--Maximas tareas hechas por un usuario

DELIMITER //
CREATE FUNCTION MaxTareas(idDepartamento INT) RETURNS INT
BEGIN
	DECLARE cantidad INT;
    
    SELECT COUNT(t.hoja_tiempo) AS tareas INTO cantidad
    FROM usuario u 
    INNER JOIN hoja_de_tiempo h ON u.cedula = h.usuario 
    INNER JOIN tarea t ON h.id = t.hoja_tiempo 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento GROUP BY t.hoja_tiempo ORDER BY tareas DESC LIMIT 1;

    
    RETURN cantidad;
END//
DELIMITER ;





--Usuario con menos tareas


DELIMITER //
CREATE FUNCTION usuarioMinTareas(idDepartamento INT) RETURNS VARCHAR(50)
BEGIN
	DECLARE nombre VARCHAR(50);
    
    SELECT CONCAT(u.nombre, ' ', u.apellido1, ' ', u.apellido2) INTO nombre 
    FROM usuario u 
    INNER JOIN hoja_de_tiempo h ON u.cedula = h.usuario 
    INNER JOIN tarea t ON h.id = t.hoja_tiempo 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento GROUP BY t.hoja_tiempo ORDER BY COUNT(t.hoja_tiempo) ASC LIMIT 1;

    
    RETURN nombre;
END//
DELIMITER ;

--Minimas tareas hechas por un usuario

DELIMITER //
CREATE FUNCTION MinTareas(idDepartamento INT) RETURNS INT
BEGIN
	DECLARE cantidad INT;
    
    SELECT COUNT(t.hoja_tiempo) AS tareas INTO cantidad
    FROM usuario u 
    INNER JOIN hoja_de_tiempo h ON u.cedula = h.usuario 
    INNER JOIN tarea t ON h.id = t.hoja_tiempo 
    WHERE h.fecha_creacion = CURRENT_DATE-7 AND h.estado = 0 AND u.departamento = idDepartamento GROUP BY t.hoja_tiempo ORDER BY tareas ASC LIMIT 1;

    
    RETURN cantidad;
END//
DELIMITER ;






--Generar reportes

DELIMITER //
CREATE PROCEDURE generarReporte(IN idDepartamento INT)
BEGIN
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
        
    
END//
DELIMITER ;

