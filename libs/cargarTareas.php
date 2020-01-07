<?php

/**
 * Archivo para mostrar las tareas en dropdown menu de agregar tarea
 * en la pantalla de hoja de tiempo este consulta las tareas de la base
 * que se le pueden mostrar al usuario
 */

include_once 'database.php';
include_once 'models/hojaTiempomodel.php';

session_start();

$cedula = $_SESSION['cedula'];

$conexion = new Database();

$query = $conexion->connect()->prepare('SELECT t.nombre 
                                                  FROM tarea t 
                                                  INNER JOIN proyecto p ON t.proyecto = p.id
                                                  INNER JOIN usuario u ON p.departamento = u.departamento
                                                  WHERE t.hoja_tiempo IS NULL AND t.estado = 0 AND u.cedula = :cedula');

$query->execute(['cedula'=>$cedula]);

$hojaTiempoModel = new HojaTiempoModel();

$id = $hojaTiempoModel->getId();

while ($registro=$query->fetch(PDO::FETCH_ASSOC)) {
    echo "<a class='dropdown-item' href='".constant('URL')."tareas/asignar/".$registro['nombre']."/".$id."'>".$registro['nombre']."</a>";
}

?>
