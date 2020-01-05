<?php

include_once 'database.php';

class TareaModel {

    function insert($tarea) {
        $database = new Database();

        $query = $database->connect()->prepare('INSERT INTO tarea(nombre,descripcion,fecha_limite,proyecto,estado)
                                                          VALUES (:nombre,:descripcion,:fechaLimite,:proyecto,0)');

        return $query->execute(['nombre'=>$tarea->nombre,
                                'descripcion'=>$tarea->descripcion,
                                'fechaLimite'=>$tarea->fechaLimite,
                                'proyecto'=>$tarea->proyecto]);


    }

}