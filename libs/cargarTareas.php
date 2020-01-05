<?php

include_once 'database.php';

$conexion = new Database();

$query = $conexion->connect()->prepare('SELECT nombre FROM tarea WHERE hoja_tiempo IS NULL AND estado = 0');

$query->execute();

while ($registro=$query->fetch(PDO::FETCH_ASSOC)) {
    echo "<a class='dropdown-item' href='".constant('URL')."tareas/asignar/".$registro['nombre']."'>".$registro['nombre']."</a>";
}

?>
