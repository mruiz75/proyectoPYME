<?php
include_once 'libs/database.php';

/**
 * Class ProyectoModel
 * Clase para interacturar con los objetos de proyecto en
 * la base de datos este no tiene un controller asignado
 */
class ProyectoModel {

    function getId($nombre) {
        $conexion = new Database();

        $query = $conexion->connect()->prepare('SELECT id FROM proyecto WHERE nombre = :nombre');

        $query->execute(['nombre'=>$nombre]);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result['id'];
    }

}