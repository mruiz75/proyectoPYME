<?php

include_once 'database.php';

$conexion = new Database();

$query = $conexion->connect()->prepare('SELECT * FROM proyecto');

$query->execute();

echo "hola";

while ($registro=$query->fetch(PDO::FETCH_ASSOC)) {
    echo "<option>".$registro['nombre']."</option>";
}

?>
