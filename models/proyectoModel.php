<?php
include_once 'libs/database.php';

class ProyectoModel {

    function getId($nombre) {
        echo "hola";
        $conexion = new Database();

        $query = $conexion->connect()->prepare('SELECT id FROM proyecto WHERE nombre = :nombre');

        $query->execute(['nombre'=>$nombre]);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result['id'];
    }

}